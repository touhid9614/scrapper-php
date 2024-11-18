<?php

use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

require_once 'client-management/configUpdater.php';

global $CronConfigs;

if (!isset($cron_config)) {
    if (!$cron_name) {
        $cron_name = filter_input(INPUT_GET, 'dealership');
    }

    $cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : reset($CronConfigs);
}

$cost_distribution = [];

if (isset($cron_config['max_cost'])) {
    $cron_max_cost = $cron_config['max_cost'];
} else {
    $cron_max_cost = 0;
}

if (isset($cron_config['cost_distribution'])) {
    $cost_distribution = $cron_config['cost_distribution'];
} else {
    $cost_distribution['new']  = 0;
    $cost_distribution['used'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-adwords')) {
    $max_cost = filter_input(INPUT_POST, 'max_cost', FILTER_VALIDATE_INT);

    /*
     *  Parser & traverser
     */
    $configFile = s3DealerConfig($cron_name);
    $parser     = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

    try
    {
        $ast = $parser->parse($configFile);
    } catch (Error $error) {
        echo 'Error Parse';
        print_r($error->getMessage());
        return;
    }

    $traverser = new NodeTraverser();

    if (isset($cron_config['max_cost'])) {
        $traverser->addVisitor(new configUpdater(
            [
                'key'   => ['max_cost'],
                'value' => $max_cost,
            ]));
    } else {
        $traverser->addVisitor(new configCreator('max_cost', $max_cost));
    }

    $cron_config['max_cost'] = $max_cost;

    $delete_check = $_POST['delete_check'];
    $cost_array   = [];

    foreach ($cost_distribution as $key => $value) {
        if (!array_key_exists($key, $delete_check)) {
            $cost_array[$key] = filter_input(INPUT_POST, $key, FILTER_VALIDATE_INT);
        }
    }

    if (isset($_POST['new_cost_name']) && isset($_POST['new_cost_amount'])) {
        $new_cost_name   = filter_input(INPUT_POST, 'new_cost_name');
        $new_cost_amount = filter_input(INPUT_POST, 'new_cost_amount', FILTER_VALIDATE_INT);

        if ($new_cost_name != '') {
            $cost_array[strtolower($new_cost_name)] = $new_cost_amount;
        }
    }

    if (isset($cron_config['cost_distribution'])) {
        $traverser->addVisitor(new configUpdater(
            [
                'key'   => ['cost_distribution'],
                'value' => $cost_array,
            ]));
    } else {
        $traverser->addVisitor(new configCreator('cost_distribution', $cost_array));
    }

    $cron_config['cost_distribution'] = $cost_array;

    configsUpdate($cron_config, $cron_name);

    try {
        $ast                 = $traverser->traverse($ast);
        $prettyPrinter       = new ePrinter();
        $config_file_content = $prettyPrinter->prettyPrintFile($ast);
    } catch (Error $error) {
        echo 'Error in traverse';
    }

    s3Update($config_file_content, $cron_name);

    DbConnect::store_log($user_id, $user['type'], 'Dealer adwords budget ', 'Dealer adwords budget change where dealer name- ' . $cron_name . ' and max cost is- ' . $max_cost, $cron_name);
    echo ("<script type='text/javascript'> location.href = location.href; </script>");
}
?>

<div>
    <p class="alert alert-info">
        <i>Values will scale automatically. However the last cost entry might be different than others to make sure your money is spent properly. Please enter <strong> integer numbers only.</strong> You must have at least one cost distribution for max budget.
        </i>
    </p>
</div>

<form method="POST" class="form-bordered" action="?dealership=<?= $cron_name ?>">
    <div class="row form-group-row">
        <div class="col-md-8">
            <div class="row form-group">
                <label class="col-md-5 control-label"> Max Budget For Advertisement </label>

                <div class="col-md-7">
                    <input type = "number" min="0" class="form-control" placeholder="Total budget for advertisement." name="max_cost" required value="<?= isset($cron_config['max_cost']) ? $cron_config['max_cost'] : 0 ?>" onblur="updateCostDistribution()">
                </div>
            </div>
        </div>

        <div class="col-md-4">

        </div>
    </div>

    <?php
    foreach ($cost_distribution as $key => $value)
    {
        ?>
        <div class="row form-group-row">
            <div class="col-md-8">
                <div class="row form-group">
                    <label class="col-md-5 control-label"> Cost Distribution: <?= ucfirst($key) ?> </label>
                    <div class="col-md-7">
                        <input type = "number" min="0" class="form-control distributed-cost" placeholder="Budget for <?= $key ?> vehicles" name="<?= $key ?>" required value="<?= $value ?>" onblur="updateMaxCost()">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="checkbox-custom chekbox-primary">
                    <input type="checkbox" name="delete_check[<?= $key ?>]" value="1">
                    <label for="remove-style"> Delete </label>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <!-- Add new cost -->
    <div class="row form-group-row" id="appear-disappear">
        <div class="col-md-8">
            <div class="row form-group">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label"> Cost Distribution : </label>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <input type="text" id="new_cost_name" name="new_cost_name" class="form-control" value="" placeholder="Cost type/cost name">
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <input type="number" min="0" id="new_cost_amount" name="new_cost_amount" class="form-control" value="0" placeholder="Budget amount" onblur="updateMaxCost()">
                </div>
            </div>
        </div>
    </div>
    <!-- End new cost -->

    <div class="row form-group-row">
        <div class="col-md-4">
            <div class="form-group">
                <button name="btn" type="button" value="add_new_btn" id="add_new_btn" class="btn btn-primary"> Add Cost Distribution </button>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <button name="btn" type="submit" value="save-adwords" id="update" class="btn btn-success pull-right" onclick="updateMaxCost()"> Update Cost Distribution </button>
            </div>
        </div>
    </div>
</form>

<style type="text/css">
    #appear-disappear
    {
        display: none;
    }

    .text-info
    {
        font-size: medium;
    }
</style>

<script type="text/javascript">
    var base = 10;

    /**
     * Updates Maximum costs for ads
     */
    function updateMaxCost() {
        var sum = 0, currValue = 0;
        $(".distributed-cost").each(function() {
            currValue = $(this).val();
            if (currValue) {
                currValue = parseInt(currValue, base);
                sum += currValue;
            } else {
                currValue = 0;
            }
            $(this).val(currValue);
        });
        $('input[name="max_cost"]').val(sum);
    }

    /**
     * { function_description }
     *
     * @param      {string[]}  arr     The arr
     * @return     {<type>}    { description_of_the_return_value }
     */
    function arraySum(arr) {
        return eval(arr.join('+'));
    }

    /**
     * { function_description }
     *
     * @param      {number}  a       { parameter_description }
     * @param      {<type>}  arr     The arr
     * @return     {<type>}  { description_of_the_return_value }
     */
    function scaling(a, arr) {
        var sum = arraySum(arr);
        var len = arr.length;
        var i;
        if (a == sum) {
            return arr;
        }
        if (sum) {
            var scalingFactor = a / sum;
            var remaining = a;
            for (i = 0; i < len - 1; i++) {
                arr[i] = Math.round(scalingFactor * arr[i]);
                remaining -= arr[i]
            }
            arr[len - 1] = remaining;
        } else {
            var defaultDistribution = Math.round(a / len);
            for (i = 0; i < len - 1; i++) {
                arr[i] = defaultDistribution;
            }
            arr[len - 1] = a - (len - 1) * defaultDistribution;
        }
        return arr;
    }

    /**
     * { function_description }
     */
    function updateCostDistribution() {
        var max_cost = $('input[name="max_cost"]').val();

        if (max_cost) {
            max_cost = parseInt(max_cost, base);
            $('input[name="max_cost"]').val(max_cost);
        } else {
            max_cost = 0;
            $('input[name="max_cost"]').val(max_cost);
        }

        var arr = [];
        var i = 0,
            currValue = 0;
        $(".distributed-cost").each(function() {
            currValue = $(this).val()
            if (currValue) {
                arr[i++] = parseInt(currValue, base);
            } else {
                arr[i++] = 0;
            }
        });

        arr = scaling(max_cost, arr);
        i = 0;

        $(".distributed-cost").each(function() {
            $(this).val(arr[i++]);
        });
    }

    $("#add_new_btn").click(function() {
        if ($(this).text() == ' Add Cost Distribution ') {
            $(this).html(' Discard Cost Distribution ');
            $(this).removeClass('btn-primary').addClass('btn-danger');
            $("#new_cost_amount").addClass('distributed-cost').prop('required', true);
        } else {
            $(this).html(' Add Cost Distribution ');
            $(this).removeClass('btn-danger').addClass('btn-primary');
            $("#new_cost_name").val('');
            $("#new_cost_amount").removeClass('distributed-cost').prop('required', false);
        }
        $("#appear-disappear").toggle();
    });
</script>
