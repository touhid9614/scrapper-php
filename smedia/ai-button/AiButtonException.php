<?php
/**
 * Created by PhpStorm.
 * User: Arif_local
 * Date: 10/2/2019
 * Time: 4:15 PM
 */

namespace sMedia\AiButton;

/**
 * Exceptions for AiButton classes
 */
class AiButtonException extends \RuntimeException
{
    const DEALERSHIP_NOT_FOUND = 1;
    const CONFIG_NOT_FOUND     = 2;
    const ALGORITHM_IS_NOT_DEFINED = 3;
}
