<?php

/**
* compute similarity between two files
* arg: $v1(array), $v2(array)
* return: score(float)
*/
class ComputeScore {
	
	// key:string, value:float
	public static function compute($v1, $s1, $v2, $s2) {
		return self::byCosine($v1, $s1, $v2, $s2);
	}

	private static function byCosine($v1, $s1, $v2, $s2) {
		// $intersect = array_intersect_key($v1, $v2);
		$unionset = array_merge($v1, $v2);
		$product = $len1 = $len2 = 0;
		$sum = $s1 + $s2;

		// foreach ($unionset as $key => $value) {
		// 	if (array_key_exists($key, $v1) && array_key_exists($key, $v2)) {
		// 		$product += ($v1[$key]/$s1 * log(($v1[$key]+$v2[$key]))) * ($v2[$key]/$s2 * log(($v1[$key]+$v2[$key])));
		// 		$len1 += ($v1[$key]/$s1 * log(($v1[$key]+$v2[$key]))) * ($v1[$key]/$s1 * log(($v1[$key]+$v2[$key])));
		// 		$len2 += ($v2[$key]/$s2 * log(($v1[$key]+$v2[$key]))) * ($v2[$key]/$s2 * log(($v1[$key]+$v2[$key])));
		// 	}
		// 	else {
		// 		if (array_key_exists($key, $v1)) {
		// 		$len1 += ($v1[$key]/$s1 * log($v1[$key])) * ($v1[$key]/$s1 * log($v1[$key]));
		// 		}

		// 		if (array_key_exists($key, $v2)) {
		// 			$len2 += ($v2[$key]/$s2 * log($v2[$key])) * ($v2[$key]/$s2 * log($v2[$key]));
		// 		}
		// 	}
		// }

		// foreach ($unionset as $key => $value) {
		// 	if (array_key_exists($key, $v1) && array_key_exists($key, $v2)) {
		// 		$product += ($v1[$key]/$s1 * log($sum/($v1[$key]+$v2[$key]))) * ($v2[$key]/$s2 * log($sum/($v1[$key]+$v2[$key])));
		// 		$len1 += ($v1[$key]/$s1 * log($sum/($v1[$key]+$v2[$key]))) * ($v1[$key]/$s1 * log($sum/($v1[$key]+$v2[$key])));
		// 		$len2 += ($v2[$key]/$s2 * log($sum/($v1[$key]+$v2[$key]))) * ($v2[$key]/$s2 * log($sum/($v1[$key]+$v2[$key])));
		// 	}
		// 	else {
		// 		if (array_key_exists($key, $v1)) {
		// 		$len1 += ($v1[$key]/$s1 * log($sum/$v1[$key])) * ($v1[$key]/$s1 * log($sum/$v1[$key]));
		// 		}

		// 		if (array_key_exists($key, $v2)) {
		// 			$len2 += ($v2[$key]/$s2 * log($sum/$v2[$key])) * ($v2[$key]/$s2 * log($sum/$v2[$key]));
		// 		}
		// 	}
		// }

		foreach ($unionset as $key => $value) {
			if (array_key_exists($key, $v1) && array_key_exists($key, $v2)) {
				$product += ($v1[$key]/$s1) * ($v2[$key]/$s2);
				$len1 += ($v1[$key]/$s1) * ($v1[$key]/$s1);
				$len2 += ($v2[$key]/$s2) * ($v2[$key]/$s2);
			}
			else {
				if (array_key_exists($key, $v1)) {
				$len1 += ($v1[$key]/$s1) * ($v1[$key]/$s1);
				}

				if (array_key_exists($key, $v2)) {
					$len2 += ($v2[$key]/$s2) * ($v2[$key]/$s2);
				}
			}
		}

		// foreach ($intersect as $key => $value) {
		// 	$product += $v1[$key]/$s1 * $v2[$key]/$s2;

		// 	$len1 += $v1[$key]/$s1 * $v1[$key]/$s1;
		// 	$len2 += $v2[$key]/$s2 * $v2[$key]/$s2;
		// }

		$len1 = sqrt($len1);
		$len2 = sqrt($len2);

		// $score = $product / ($len1+$len2-$product);
		$score = $product / ($len1*$len2);
		// $score = count($intersect) / count($unionset);
		return $score;
	}
}