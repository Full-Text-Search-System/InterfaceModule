<?php

/**
* normalize tokens
* rule: convert tokens to lowcase
* arg: $token(string)
* return: string
*/
class Normalizer {
	
	public static function normalize($token) {
		return self::toLowcase($token);
	}

	public static function toLowcase($token) {
		return strtolower($token);
	}
}