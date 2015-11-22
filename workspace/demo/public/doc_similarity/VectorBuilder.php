<?php

include_once('Tokenizer.php');
include_once('Normalizer.php');
include_once('StopwordsRemover.php');
include_once('ComputeScore.php');

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
		$vectorFile = fopen('V_'.$fileName, 'w');
		fwrite($vectorFile, strval($size));
		ksort($vector);
		foreach ($vector as $key => $value) {
			fwrite($vectorFile, "\r\n".$key." ".$value);
		}
		fclose($vectorFile);
	}

	public static function computeScore($fn1, $fn2) {
		/*********************************
		* compute score between two file *
		**********************************/

        // can set weight for each attribute
		// read vector file and build vector
		$v1File = fopen($fn1, 'r');
		$v1 = array();
		$s1 = intval(fgets($v1File));
		while (!feof($v1File)) {
			$line = explode(" ", fgets($v1File));
			$v1[$line[0]] = intval($line[1]);
		}
		fclose($v1File);

		$v2File = fopen($fn2, 'r');
		$v2 = array();
		$s2 = intval(fgets($v2File));
		while (!feof($v2File)) {
			$line = explode(" ", fgets($v2File));
			$v2[$line[0]] = intval($line[1]);
		}
		fclose($v2File);

		$score = ComputeScore::compute($v1, $s1, $v2, $s2);
		$scoreFile = fopen('score.txt', 'a');
		fwrite($scoreFile, $score." ".$fn1." ".$fn2."\r\n");
		fclose($scoreFile);
	}
}

VectorBuilder::build('file', '2015FoxC.txt');
// VectorBuilder::build('2012HanemanP_thesis.txt');
// VectorBuilder::build('2010CostanzoL.txt');
// VectorBuilder::build('Efficient and Robust Feature Selection via Joint l2,1-Norms Minimization.txt');

// VectorBuilder::computeScore('V_2015FoxC.txt', 'V_Efficient and Robust Feature Selection via Joint l2,1-Norms Minimization.txt');
// VectorBuilder::computeScore('V_2015FoxC.txt', 'V_2012HanemanP_thesis.txt');
// VectorBuilder::computeScore('V_2015FoxC.txt', 'V_2010CostanzoL.txt');

// VectorBuilder::computeScore('V_2012HanemanP_thesis.txt', 'V_Efficient and Robust Feature Selection via Joint l2,1-Norms Minimization.txt');
// VectorBuilder::computeScore('V_2012HanemanP_thesis.txt', 'V_2010CostanzoL.txt');

// VectorBuilder::computeScore('V_2010CostanzoL.txt', 'V_Efficient and Robust Feature Selection via Joint l2,1-Norms Minimization.txt');

