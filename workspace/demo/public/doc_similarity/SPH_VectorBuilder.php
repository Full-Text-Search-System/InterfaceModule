<?php

include_once('Tokenizer.php');
include_once('Normalizer.php');
include_once('StopwordsRemover.php');

/**
* 
*/
class VectorBuilder {
	
	public static function build($dir, $fileName) {
		// according to database

		// read files
		$line = file_get_contents($dir.'/'.$fileName);

		/**********************
		* preprocessing files *
		**********************/

		// load stopword file
		$stopwordFile = fopen('stopwords.txt', 'r');
		$stoprmv = new StopwordsRemover($stopwordFile);
		fclose($stopwordFile);

		// token preprocessing and build vector for file
		$vector = array();
		$tokens = Tokenizer::tokenize($line);
		$size   = 0;
		foreach ($tokens as $token) {
			$token = Normalizer::normalize($token);
			if (!$stoprmv->isStopword($token)) {
				$size++;
				if (array_key_exists($token, $vector)) {
					$vector[$token] = $vector[$token] + 1; 
				} else {
					$vector[$token] = 1;
				}
			}
		}

	    /**********************
		* save vector to file *
		**********************/
		$vectorFile = fopen('vector/V_'.$fileName, 'w');
		fwrite($vectorFile, strval($size));
		// ksort($vector);
		foreach ($vector as $key => $value) {
			fwrite($vectorFile, "\r\n".$key." ".$value);
		}
		fclose($vectorFile);
	}