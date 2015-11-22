<?php

/**
* tokenize the input text
* rule: split by white space, remove all characters that are not letter
* arg: $text(string)
* return: an array containing tokens
*/
class Tokenizer {
	
	public static function tokenize($text) {
		return self::byWhiteSpace($text);
	}

	public static function byWhiteSpace($text) {
		$tmp = explode(' ', $text);
		$tokens = array();
		foreach ($tmp as $token) {
			if (ctype_alpha($token)) {
				array_push($tokens, $token);
			}
		}
		return $tokens;
	}
}
