<?php

/* REQUIRED IMPORTS */
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar;
use PhpParser\PrettyPrinter;

/**
 * Interface to be notified of the composition of a normalized node.
 */
class NormalizedNodeVisitor extends NodeVisitorAbstract
{
    /**
     * { function_description }
     *
     * @param      string       $value  The value
     *
     * @return     Expr|Scalar  ( description_of_the_return_value )
     */
    public function normalizeValue($value)
    {
        if (is_null($value)) {
            return new Expr\ConstFetch(
                new Name('null')
            );
        } elseif (is_bool($value)) {
            return new Expr\ConstFetch(
                new Name($value ? 'true' : 'false')
            );
        } elseif (is_int($value)) {
            return new Scalar\LNumber($value);
        } elseif (is_float($value)) {
            return new Scalar\DNumber($value);
        } elseif (is_string($value)) {
            return new Scalar\String_($value);
        } elseif (is_array($value)) {
            $items   = [];
            $lastKey = -1;

            foreach ($value as $itemKey => $itemValue) {
                // for consecutive, numeric keys don't generate keys
                if (null !== $lastKey && ++$lastKey === $itemKey) {
                    $items[] = new Expr\ArrayItem(
                        $this->normalizeValue($itemValue)
                    );
                } else {
                    $lastKey = null;
                    $items[] = new Expr\ArrayItem(
                        $this->normalizeValue($itemValue),
                        $this->normalizeValue($itemKey)
                    );
                }
            }

            return new Expr\Array_($items);
        }
    }
}

/**
 * Class for configuration creator.
 */
class configCreator extends NormalizedNodeVisitor
{
    private $key = null, $value = null;

    /**
     * Constructs the object.
     *
     * @param      <type>  $key    The key
     * @param      <type>  $value  The value
     */
    public function __construct($key, $value)
    {
        $this->key   = is_string($key) ? $key : null;
        $this->value = $this->normalizeValue($value);
    }

    /**
     * { function_description }
     *
     * @param      \PhpParser\Node  $node   The node
     */
    public function enterNode(Node $node)
    {
        if ($this->key !== null && $node instanceof Assign && $node->var instanceof ArrayDimFetch && $node->var->var->name == 'CronConfigs') {
            if ($this->hasConfig($this->key, $node->expr->items, $i)) {
                $node->expr->items[$i] = $this->value;
            } else {
                $node->expr->items[] = new ArrayItem($this->value, $this->normalizeValue($this->key));
            }

            $this->key = null;
        }
    }

    /**
     * Determines if it has configuration.
     *
     * @param      <type>   $key    The key
     * @param      <type>   $nodes  The nodes
     * @param      integer  $i      { parameter_description }
     *
     * @return     boolean  True if has configuration, False otherwise.
     */
    public function hasConfig($key, $nodes, &$i)
    {
        for ($i = 0; $i < count($nodes); $i++) {
            if ($nodes[$i] instanceof ArrayItem && $nodes[$i]->key->value == $key) {
                return true;
            }
        }

        return false;
    }
}

/**
 * Class for configuration updater.
 */
class configUpdater extends NormalizedNodeVisitor
{
    private $key = null, $value = null, $keys = [];

    /**
     * Constructs the object.
     *
     * @param      array  $update  The update
     */
    public function __construct(array $update)
    {
        $this->key   = isset($update['key']) ? $update['key'] : null;
        $this->value = $this->normalizeValue(isset($update['value']) ? $update['value'] : null);
    }

    /**
     * { function_description }
     *
     * @param      array  $nodes  The nodes
     */
    public function beforeTraverse(array $nodes)
    {
        $this->keys = $this->key ? $this->key : [];
    }

    /**
     * { function_description }
     *
     * @param      \PhpParser\Node  $node   The node
     */
    public function enterNode(Node $node)
    {
        if ($this->keys !== null && $node instanceof ArrayItem) {
            // Clean out the function body
            if ($node->key && $node->key->value == $this->keys[0]) {
                unset($this->keys[0]);
                $this->keys = array_values($this->keys);

                if (count($this->keys) === 0) {
                    $node->value = $this->value;
                    $this->keys  = null;
                }
            }
        }
    }
}

/**
 * Class for e printer.
 */
class ePrinter extends PrettyPrinter\Standard
{
    /**
     * { function_description }
     *
     * @param      \PhpParser\Node\Expr\Array_  $node   The node
     *
     * @return     string                       ( description_of_the_return_value )
     */
    protected function pExpr_Array(Array_ $node)
    {
        $syntax = $node->getAttribute('kind', $this->options['shortArraySyntax'] ? Array_::KIND_SHORT : Array_::KIND_LONG);
        if ($syntax === Array_::KIND_SHORT) {
            return '[' . $this->epMaybeMultiline($node->items, true) . ']';
        } else {
            return 'array(' . $this->epMaybeMultiline($node->items, true) . ')';
        }
    }

    /**
     * { function_description }
     *
     * @param      array    $nodes  The nodes
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    private function ehasNodeWithComments(array $nodes)
    {
        foreach ($nodes as $node) {
            if ($node && $node->getAttribute('comments')) {
                return true;
            }
        }

        return false;
    }

    /**
     * { function_description }
     *
     * @param      array    $nodes          The nodes
     * @param      boolean  $trailingComma  The trailing comma
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    private function epMaybeMultiline(array $nodes, $trailingComma = false)
    {
        if (!$this->ehasNodeWithComments($nodes) && !(count($nodes) && $nodes[0] instanceof ArrayItem)) {
            return $this->pCommaSeparated($nodes);
        } else {
            return $this->pCommaSeparatedMultiline($nodes, $trailingComma) . "\n";
        }
    }
}
