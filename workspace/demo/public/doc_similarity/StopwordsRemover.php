<?php

/**
* determind a token is a stopword or not
* stopword file format: one word one line
*/
class StopwordsRemover {
	
	var $stopwordSet = array();

	function __construct($stopwordFile) {
		while (!feof($stopwordFile)) {
			$word = trim(fgets($stopwordFile));
			if (!array_key_exists($word, $this->stopwordSet))
				$this->stopwordSet[$word] = 0;
		}
	}

	function isStopword($token) {
		if (array_key_exists($token, $this->stopwordSet)) {
			return true;
		} else {
			return false;
		}
	}
}