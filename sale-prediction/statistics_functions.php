<?php

/*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */


/**
 * { function_description }
 *
 * @param      <type>  $arr    The arr
 */
function all_statistics(array $arr): array
{
	return
		[
			'arithmatic_mean' 		=> arithmatic_mean($arr),
			'geometric_mean' 		=> geometric_mean($arr),
			'harmonic_mean' 		=> harmonic_mean($arr),
			'weighted_mean' 		=> weighted_mean($arr),
			'standard_deviation' 	=> standard_deviation($arr),
			'median'				=> median($arr),
			'mode'					=> mode($arr),
			'root_mean_square' 		=> root_mean_square($arr)
		];
}


/**
 * Calculates the mean.
 *
 * @param      <type>  $arr    The arr
 *
 * @return     array   The mean.
 */
function calc_mean(array $arr, &$standard_deviation)
{
	$standard_deviation = standard_deviation($arr);

	return arithmatic_mean($arr);
}


/**
 * { function_description }
 *
 * @param      <type>  $properties     The properties
 * @param      <type>  $std_deviation  The standard deviation
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function property_mean(array $properties, &$std_deviation)
{
	$out 		= $properties[0];
	$arrSize 	= sizeof($properties);
	$propSiz 	= sizeof($properties[0]);
	$temp 		= [];

	for ($i = 0; $i < $arrSize; $i++) {
		foreach ($properties[$i] as $key => $value) {
			$temp[$key][] = $value;
		}
	}

	foreach ($temp as $key => $value) {
		$out[$key]              = arithmatic_mean($value);
		$std_deviation[$key] 	= standard_deviation($value);
	}

	return $out;
}


/**
 * Calculate the mean average of a list of numbers
 *
 *     ∑⟮xᵢ⟯
 * x̄ = -----
 *       n
 *
 * @param array 	$arr      The arr
 *
 * @return double|null
 */
function arithmatic_mean(array $arr)
{
	$arrSize = count($arr);

	if (!$arrSize) {
		return null;
	}

	return array_sum($arr) / $arrSize;
}


/**
 * Geometric mean
 * A type of mean which indicates the central tendency or typical value of a set of numbers
 * by using the product of their values (as opposed to the arithmetic mean which uses their sum).
 * https://en.wikipedia.org/wiki/Geometric_mean
 *                    __________
 * Geometric mean = ⁿ√a₀a₁a₂ ⋯
 *
 * @param  array  $numbers
 *
 * @return number | null
 */
function geometric_mean(array $arr)
{
	$arrSize = count($arr);

	if (!$arrSize) {
		return null;
	}

	$mul = 1;

	foreach ($arr as $i => $n) {
		$mul = $i == 0 ? $n : $mul * $n;
	}

	return pow($mul, 1 / $arrSize);
}


/**
 * Harmonic mean (subcontrary mean)
 * The harmonic mean can be expressed as the reciprocal of the arithmetic mean of the reciprocals.
 * Appropriate for situations when the average of rates is desired.
 * https://en.wikipedia.org/wiki/Harmonic_mean
 *
 *             n
 * H(x) = -----------
 *          ∑⟮1 / xᵢ⟯
 *
 * @param  array  $arr
 *
 * @return number|null
 */
function harmonic_mean(array $arr)
{
	$arrSize = count($arr);

	if (!$arrSize) {
		return null;
	}

	$sum = 0;

	for ($i = 0; $i < $arrSize; $i++) {
		$sum += 1 / $arr[$i];
	}

	return $arrSize / $sum;
}


/**
 * { function_description }
 *
 * @param      <type>  $arr    The arr
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function standard_deviation(array $arr)
{
	$arrSize 	= count($arr);
	$variance 	= 0.0;
	$average 	= arithmatic_mean($arr);

	foreach ($arr as $i) {
		$variance += pow(($i - $average), 2);
	}

	return (float)sqrt($variance / ($arrSize - 1));
}


/**
 * Calculate the weighted mean average of a list of numbers
 * https://en.wikipedia.org/wiki/Weighted_arithmetic_mean
 *
 *     ∑⟮xᵢwᵢ⟯
 * x̄ = -----
 *      ∑⟮wᵢ⟯
 *
 * @param array $ratings
 *
 * @return number|null
 */
function weighted_mean(array $ratings)
{
	$total = 0;
	$count = 0;

	foreach ($ratings as $number => $frequency) {
		$total += $number * $frequency;
		$count += $frequency;
	}

	return $total / $count;
}


/**
 * Calculate the median average of a list of numbers
 *
 * @param array $arr    The arr
 *
 * @return number|null
 */
function median(array $arr)
{
	$arrSize 	= count($arr);

	if (!$arrSize) {
		return null;
	}

	$middleval 	= ($arrSize - 1) / 2;

	if ($arrSize % 2) {
		$median = $arr[$middleval];
	} else {
		$low 	= $arr[$middleval];
		$high 	= $arr[$middleval + 1];
		$median = ($low + $high) / 2;
	}

	return $median;
}


/**
 * Calculate the mode average of a list of numbers
 * If multiple modes (bimodal, trimodal, etc.), all modes will be returned.
 * Always returns an array, even if only one mode.
 *
 * @param array $arr    The arr
 *
 * @return array of mode(s)
 */
function mode(array $arr)
{
	$freq 		= array();
	$arrSize 	= count($arr);

	for ($i = 0; $i < $arrSize; $i++) {
		if (isset($freq[$arr[$i]])) {
			$freq[$arr[$i]]++;
		} else {
			$freq[$arr[$i]] = 1;
		}
	}

	$maxs = array_keys($freq, max($freq));
	$out  = [];

	for ($i = 0, $siz = count($maxs); $i < $siz; $i++) {
		$out[$maxs[$i]] = $freq[$maxs[$i]];
	}

	return $out;
}


/**
 * Root mean square (quadratic mean)
 * The square root of the arithmetic mean of the squares of a set of numbers.
 * https://en.wikipedia.org/wiki/Root_mean_square
 *           ___________
 *          /x₁²+x₂²+ ⋯
 * x-rms = / -----------
 *        √       n
 *
 * @param  array  $arr    The arr
 *
 * @return float
 */
function root_mean_square(array $arr): float
{
	$arrSize 	= count($arr);
	$sum 		= $arr[0] * $arr[0];

	for ($i = 1; $i < $arrSize; $i++) {
		$sum 	+= $arr[$i] * $arr[$i];
	}

	return (float)sqrt($sum / $arrSize);
}


/**
 * Cubic Mean
 * https://en.wikipedia.org/wiki/Cubic_mean
 *              _________
 *             / 1  n
 * x-cubic = ³/  -  ∑ xᵢ³
 *           √   n ⁱ⁼¹
 *
 * @param  array  $arr
 *
 * @return float
 */
function cubic_mean(array $arr): float
{
	$arrSize    = count($arr);

	if (!$arrSize) {
		return null;
	}

	$sum = 0;

	for ($i = 0; $i < $arrSize; $i++) {
		$sum += pow($arr[$i], 3);
	}

	return (float)(pow(1 / $arrSize * $sum, 1 / 3));
}


/**
 * Simple n-point moving average (SMA)
 * The unweighted mean of the previous n data.
 *
 * First calculate initial average:
 *  ⁿ⁻¹
 *   ∑ xᵢ
 *  ᵢ₌₀
 *
 * To calculating successive values, a new value comes into the sum and an old value drops out:
 *  SMAtoday = SMAyesterday + NewNumber/N - DropNumber/N
 *
 * @param  array  $arr         		The arr
 * @param  int    $windowSize       n-point moving average
 *
 * @return array of averages for each n-point time period
 */
function simple_moving_average(array $arr, int $windowSize): array
{
	$arrSize   	= count($arr);
	$SMA 		= [];
	$new       	= $windowSize;
	$drop      	= 0;
	$yesterday 	= 0;
	$SMA[] 		= array_sum(array_slice($arr, 0, $windowSize)) / $windowSize;

	while ($new < $arrSize) {
		$SMA[] 	= $SMA[$yesterday] + ($arr[$new] / $windowSize) - ($arr[$drop] / $windowSize);
		$drop++;
		$yesterday++;
		$new++;
	}

	return $SMA;
}


/**
 * Cumulative moving average (CMA)
 *
 * Base case for initial average:
 *         x₀
 *  CMA₀ = --
 *         1
 *
 * Standard case:
 *         xᵢ + (i * CMAᵢ₋₁)
 *  CMAᵢ = -----------------
 *              i + 1
 *
 * @param  array  	$arr    The arr
 *
 * @return array of cumulative averages
 */
function cumulative_moving_average(array $arr): array
{
	$arrSize   	= count($arr);
	$CMA      	= [];
	$CMA[] 		= $arr[0];

	for ($i = 1; $i < $arrSize; $i++) {
		$CMA[] = (($arr[$i]) + ($CMA[$i - 1] * $i)) / ($i + 1);
	}

	return $CMA;
}


/**
 * Weighted n-point moving average (WMA)
 *
 * Similar to simple n-point moving average,
 * however, each n-point has a weight associated with it,
 * and instead of dividing by n, we divide by the sum of the weights.
 *
 * Each weighted average = ∑(weighted values) / ∑(weights)
 *
 * @param  array  $arr    			The arr
 * @param  int    $windowSize       n-point moving average
 * @param  array  $weights Weights for each n points
 *
 */
function weighted_moving_average(array $arr, int $windowSize, array $weights)
{
	$weight_size = count($weights);

	if ($weight_size !== $windowSize) {
		return null;
	}

	$arrSize = count($arr);
	$WMA_sum = 0;

	for ($i = $arrSize - 1, $j = $weight_size - 1; $i >= $arrSize - $windowSize; $i--, $j--) {
		$WMA_sum += $arr[$i] * $weights[$j];
	}

	$WMA = $WMA_sum / array_sum($weights);

	return $WMA;
}


/**
 * Exponential moving average (EMA)
 *
 * The start of the EMA is seeded with the first data point.
 * Then each day after that:
 *  EMAtoday = α⋅xtoday + (1-α)EMAyesterday
 *
 *   where
 *    α: coefficient that represents the degree of weighting decrease, a constant smoothing factor between 0 and 1.
 *
 * @param 	array  	$numbers     		The numbers
 * @param 	int    	$windowSize       	Length of the EPA
 *
 * @return array of exponential moving averages
 */
function exponential_moving_average(array $numbers, int $windowSize): array
{
	$arrSize 	= count($numbers);
	$alpha   	= 2 / ($windowSize + 1);
	$EMA 		= [];
	$EMA[] 		= $numbers[0];

	for ($i = 1; $i < $arrSize; $i++) {
		$EMA[] 	= ($alpha * $numbers[$i]) + ((1 - $alpha) * $EMA[$i - 1]);
	}

	return $EMA;
}


/**
 * Arithmetic-Geometric mean
 *
 * First, compute the arithmetic and geometric means of x and y, calling them a₁ and g₁ respectively.
 * Then, use iteration, with a₁ taking the place of x and g₁ taking the place of y.
 * Both a and g will converge to the same mean.
 * https://en.wikipedia.org/wiki/Arithmetic%E2%80%93geometric_mean
 *
 * x and y ≥ 0
 * If x or y = 0, then arithmetic_geometric_mean = 0
 * If x or y < 0, then NaN
 *
 * @param  $x
 * @param  $y
 *
 * @return number | null
 */
function arithmetic_geometric_mean($x, $y)
{
	if ($x < 0 || $y < 0) {
		return null;
	}

	if ($x == 0 || $y == 0) {
		return 0;
	}

	list($a, $g) = [$x, $y];

	for ($i = 0; $i <= 10; $i++) {
		list($a, $g) = [arithmatic_mean([$a, $g]), geometric_mean([$a, $g])];
	}

	return $a;
}


/**
 * Logarithmic mean
 * A function of two non-negative numbers which is equal to their
 * difference divided by the logarithm of their quotient.
 *
 * https://en.wikipedia.org/wiki/Logarithmic_mean
 *
 *  logarithmic_mean(x, y) = 0 		if x = 0 or y = 0
 *              					x if x = y
 *  otherwise:
 *                y - x
 *             -----------
 *             ln y - ln x
 *
 * @param  $x
 * @param  $y
 *
 * @return number
 */
function logarithmic_mean($x, $y)
{
	if ($x == 0 || $y == 0) {
		return 0;
	}

	if ($x == $y) {
		return $x;
	}

	return ($y - $x) / (log($y) - log($x));
}


/**
 * Heronian mean
 * https://en.wikipedia.org/wiki/Heronian_mean
 *            __
 * H = ⅓(A + √AB + B)
 *
 * @param  $A
 * @param  $B
 *
 * @return float
 */
function heronian_mean($A, $B)
{
	return 1 / 3 * ($A + sqrt($A * $B) + $B);
}


/**
 * Identric Mean
 * https://en.wikipedia.org/wiki/Identric_mean
 *                 ____
 *          1     / xˣ
 * I(x,y) = - ˣ⁻ʸ/  --
 *          ℯ   √   yʸ
 *
 * @param  $x
 * @param  $y
 *
 * @return number
 */
function identric_mean($x, $y)
{
	if ($x <= 0 || $y <= 0) {
		return null;
	}

	if ($x == $y) {
		return $x;
	}

	return exp(-1) * pow((pow($x, $x) / pow($y, $y)), 1 / ($x - $y));
}


/**
 * Lehmer mean
 * https://en.wikipedia.org/wiki/Lehmer_mean
 *
 *          ∑xᵢᵖ
 * Lp(x) = ------
 *         ∑xᵢᵖ⁻¹
 *
 * Special cases:
 *  L-∞(x) is the min(x)
 *  L₀(x) is the harmonic mean
 *  L½(x₀, x₁) is the geometric mean if computed against two numbers
 *  L₁(x) is the arithmetic mean
 *  L₂(x) is the contraharmonic mean
 *  L∞(x) is the max(x)
 *
 * @param  $arr
 * @param  $p
 *
 * @return number
 */
function lehmer_mean(array $arr, $p)
{
	if ($p == -\INF) {
		return min($arr);
	}

	if ($p == \INF) {
		return max($arr);
	}

	$up 	= 0;
	$down 	= 0;

	for ($i = 0, $arrSize = count($arr); $i < $arrSize; $i++) {
		$temp 	=  pow($arr[$i], $p - 1);
		$down 	+= $temp;
		$up 	+= $temp * $arr[$i];
	}

	return $up / $down;
}


/**
 * Generalized mean (power mean, Hölder mean)
 * https://en.wikipedia.org/wiki/Generalized_mean
 *
 *          / 1  n    \ 1/p
 * Mp(x) = |  -  ∑ xᵢᵖ |
 *          \ n ⁱ⁼¹   /
 *
 * Special cases:
 *  M-∞(x) is min(x)
 *  M₋₁(x) is the harmonic mean
 *  M₀(x) is the geometric mean
 *  M₁(x) is the arithmetic mean
 *  M₂(x) is the quadratic mean
 *  M₃(x) is the cubic mean
 *  M∞(x) is max(X)
 *
 * @param  array  	$numbers
 * @param  	 		$p
 *
 * @return number
 */
function generalized_mean(array $numbers, $p)
{
	if ($p == -\INF) {
		return min($numbers);
	}

	if ($p == \INF) {
		return max($numbers);
	}

	if ($p == 0) {
		return geometric_mean($numbers);
	}

	$n    = count($numbers);

	$sum = 0;

	for ($i = 0, $arrSize = count($numbers); $i < $arrSize; $i++) {
		$sum +=  pow($numbers[$i], $p);
	}

	return pow(1 / $n * $sum, 1 / $p);
}


/**
 * Truncated mean (trimmed mean)
 * The mean after discarding given parts-new of a probability distribution or sample
 * at the high and low end, and typically discarding an equal amount of both.
 * This number of points to be discarded is given as a percentage of the total number of points.
 * https://en.wikipedia.org/wiki/Truncated_mean
 *
 * Trim count = floor( (trim percent / 100) * sample size )
 *
 * For example: [8, 3, 7, 1, 3, 9] with a trim of 20%
 * First sort the list: [1, 3, 3, 7, 8, 9]
 * Sample size = 6
 * Then determine trim count: floot(20/100 * 6 ) = 1
 * Trim the list by removing 1 from each end: [3, 3, 7, 8]
 * Finally, find the mean: 5.2
 *
 * @param  array  $numbers
 * @param  int    $trim_percent Percent between 0-99
 *
 * @return float
 */
function truncated_mean(array $numbers, int $trim_percent)
{
	if ($trim_percent < 0 || $trim_percent > 99) {
		return null;
	}

	$n          = count($numbers);
	$trim_count = floor($n * ($trim_percent / 100));

	sort($numbers);

	for ($i = 1; $i <= $trim_count; $i++) {
		array_shift($numbers);
		array_pop($numbers);
	}

	return arithmatic_mean($numbers);
}
