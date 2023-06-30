<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-feed
 * @version   1.2.11
 * @copyright Copyright (C) 2023 Mirasvit (https://mirasvit.com/)
 */


namespace Mirasvit\Feed\Export\Filter;

class NumberFilter
{

    /**
     * Addition
     * | Adds a number to another number
     *
     * @param int $input
     * @param int $operand
     * @return int
     */
    public static function plus($input, $operand)
    {
        return (float)$input + (float)$operand;
    }

    /**
     * Subtraction
     * | Subtracts a number from another number
     *
     * @param int $input
     * @param int $operand
     * @return int
     */
    public static function minus($input, $operand)
    {
        return (float)$input - (float)$operand;
    }

    /**
     * Multiplication
     * | Multiplies a number by another number
     *
     * @param int $input
     * @param int $operand
     * @return int
     */
    public static function times($input, $operand)
    {
        return (float)$input * (float)$operand;
    }

    /**
     * Division
     * | Divides a number by another number
     *
     * @param int $input
     * @param int $operand
     * @return int
     */
    public static function divided_by($input, $operand)
    {
        return (float)$input / (float)$operand;
    }

    /**
     * Modulo
     * | Returns the remainder of a division operation
     *
     * @param int $input
     * @param int $operand
     * @return int
     */
    public static function modulo($input, $operand)
    {
        return (int)$input % (int)$operand;
    }

    /**
     * Ceil
     * | Rounds an output up to the nearest integer
     *
     * @param string $input
     * @return number
     */
    public function ceil($input)
    {
        return ceil((float)$input);
    }

    /**
     * Floor
     * | Rounds an output down to the nearest integer
     *
     * @param string $input
     * @return number
     */
    public function floor($input)
    {
        return floor((float)$input);
    }

    /**
     * Round
     * | Rounds the output to the nearest integer or specified number of decimals
     *
     * @param string $input
     * @param number $precision
     * @return number
     */
    public function round($input, $precision)
    {
        return round((float)$input, $precision);
    }

    /**
     * Number Format
     * | Sets the format of the number
     *
     * @param string $input
     * @param int    $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     * @return string
     */
    public function numberFormat($input, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        return number_format((float)$input, $decimals, $decPoint, $thousandsSep);
    }

    /**
     * Price Format
     * | Sets price number format with 2 decimals
     *
     * @param string $input
     * @return string
     */
    public function price($input)
    {
        $input = floatval($input);

        return number_format($input, 2, '.', '');
    }

    /**
     * Append
     * | Appends characters to a number
     *
     * @param string $input
     * @param string $suffix
     * @return string
     */
    public function append($input, $suffix)
    {
        return $input ? $input . $suffix : $input;
    }
}
