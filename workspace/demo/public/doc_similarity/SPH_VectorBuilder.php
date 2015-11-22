<?php

include_once('Tokenizer.php');
include_once('Normalizer.php');
include_once('StopwordsRemover.php');
// include_once('ComputeScore.php');
// include_once('SphinxClient.php');

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

	// public static function computeScore($fn1, $fn2) {
	// 	/*********************************
	// 	* compute score between two file *
	// 	**********************************/

	// 	// SetIDRange
	// 	$cl = new SphinxClient();
 //        $cl->setServer('127.0.0.1', 9312);

 //        // /// match modes
 //        // switch ($match_mode) {
 //        //     case "SPH_MATCH_BOOLEAN":
 //        //         $cl->setMatchMode(SPH_MATCH_BOOLEAN);
 //        //         break;
 //        //     case "SPH_MATCH_ANY":
 //                $cl->setMatchMode(SPH_MATCH_ANY);
 //        //         break;
 //        //     case "SPH_MATCH_ALL":
 //        //         $cl->setMatchMode(SPH_MATCH_ALL);
 //        //         break;
 //        //     // case "SPH_MATCH_FULLSCAN":
 //                // $cl->setMatchMode(SPH_MATCH_FULLSCAN);
 //        //     //     break;
 //        //     default:
 //        //         $cl->setMatchMode(SPH_MATCH_BOOLEAN);
 //        //         break;
 //        // }

        
 //        $cl->setRankingMode(SPH_RANK_BM25);

 //        // can set weight for each attribute

 //        $v1File = fopen($fn1, 'r');
	// 	$v1 = "";
	// 	$s1 = floatval(fgets($v1File));
	// 	$time = 0;
	// 	while (!feof($v1File)) {
	// 		$line = explode(" ", fgets($v1File));
	// 		if (floatval($line[1]) < 10) continue;
	// 		// $tf = floatval($line[1]) / $s1;
	// 		$v1 .= " ".$line[0];
	// 		$time++;
	// 	}
	// 	fclose($v1File);

 //        $result = $cl->Query($v1, 'test1, testrt');
 //        $idList = array();

 //        $scoreFile = fopen('SPH_score.txt', 'a');
 //        fwrite($scoreFile, $time."\r\n");
 //        if ($result['total_found'] != '0') {
 //            foreach ($result['matches'] as $key => $val) {
	// 			fwrite($scoreFile, $key." : ".$val['weight']."\r\n");
 //            }
 //        }
 //        fclose($scoreFile);



	// 	// // read vector file and build vector
	// 	// $v1File = fopen($fn1, 'r');
	// 	// $v1 = array();
	// 	// $s1 = intval(fgets($v1File));
	// 	// while (!feof($v1File)) {
	// 	// 	$line = explode(" ", fgets($v1File));
	// 	// 	$v1[$line[0]] = intval($line[1]);
	// 	// }
	// 	// fclose($v1File);

	// 	// $v2File = fopen($fn2, 'r');
	// 	// $v2 = array();
	// 	// $s2 = intval(fgets($v2File));
	// 	// while (!feof($v2File)) {
	// 	// 	$line = explode(" ", fgets($v2File));
	// 	// 	$v2[$line[0]] = intval($line[1]);
	// 	// }
	// 	// fclose($v2File);

	// 	// $score = ComputeScore::compute($v1, $s1, $v2, $s2);
	// 	// $scoreFile = fopen('score.txt', 'a');
	// 	// fwrite($scoreFile, $score." ".$fn1." ".$fn2."\r\n");
	// 	// fclose($scoreFile);
	// }
}

// VectorBuilder::build('file', '2015FoxC.txt_329');
// VectorBuilder::build('2012HanemanP_thesis.txt');
// VectorBuilder::build('2010CostanzoL.txt');
// VectorBuilder::build('Efficient and Robust Feature Selection via Joint l2,1-Norms Minimization.txt');

// VectorBuilder::computeScore('V_2015FoxC.txt', 'V_Efficient and Robust Feature Selection via Joint l2,1-Norms Minimization.txt');
// VectorBuilder::computeScore('V_2015FoxC.txt', 'V_2012HanemanP_thesis.txt');
// VectorBuilder::computeScore('V_2015FoxC.txt', 'V_2010CostanzoL.txt');

// VectorBuilder::computeScore('V_2012HanemanP_thesis.txt', 'V_Efficient and Robust Feature Selection via Joint l2,1-Norms Minimization.txt');
// VectorBuilder::computeScore('V_2012HanemanP_thesis.txt', 'V_2010CostanzoL.txt');

// VectorBuilder::computeScore('V_2012HanemanP_thesis.txt', 'V_2010CostanzoL.txt');


// VectorBuilder::computeScore('V_Efficient and Robust Feature Selection via Joint l2,1-Norms Minimization.txt', 'V_2010CostanzoL.txt');
// VectorBuilder::computeScore('V_2010CostanzoL.txt', 'V_2010CostanzoL.txt');



