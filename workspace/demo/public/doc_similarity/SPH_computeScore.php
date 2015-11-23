<?php 

include_once('SPH_VectorBuilder.php');
include_once('SphinxClient.php');


$fileNames = array();

// read doc name and id from database
$servername = "192.168.33.11";
$username = "admin";
$password = "123456";
$dbname = "laravel";

// create mysql connection 
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "select doc_id, filename from similarityfiles";
$res = $conn->query($sql);
if ($res->num_rows > 0) {
    // get id and name
    while($row = $res->fetch_assoc()) {
        $fileName = $row['filename'].'_'.$row["doc_id"];
        $fileNames[$row["doc_id"]] = $fileName;
    }
}
$conn->close();

// read SPH_score.txt file to an array, each line is an element in the array
$lines = array();
$scoreFile = fopen('SPH_score.txt', 'r');
while (!feof($scoreFile)) {
	$str = chop(fgets($scoreFile));
	if ($str == "") continue;
	$line = explode(':', $str);
	$lines[$line[0]] = $line[1];
}
fclose($scoreFile);

// build vector file for doc, then compute score and update score matrix
foreach ($fileNames as $id => $f) {
	VectorBuilder::build('../file', $f);
	$lines = computeScore($id , $f, $lines);
}

// write score matrix into SPH_score.txt
$scoreFile = fopen('SPH_score.txt', 'w');
foreach ($lines as $key => $val) {
	fwrite($scoreFile, $key.":".$val."\r\n");
}
fclose($scoreFile);


// foreach doc, compute score and append result to SPH_score.txt
function computeScore($docID, $vector, $scoreMatrix) {
	/*********************************
	* compute score between two file *
	**********************************/

	// SetIDRange
	$cl = new SphinxClient();
    $cl->setServer('192.168.33.10', 9312);
    
    $cl->setMatchMode(SPH_MATCH_ANY);
    $cl->setRankingMode(SPH_RANK_BM25);

    // can set weight for each field

    $vFile = fopen('vector/V_'.$vector, 'r');
	$v = "";
	$s = floatval(fgets($vFile));
	$time = 0;
	while (!feof($vFile)) {
		$line = explode(" ", fgets($vFile));
		if (floatval($line[1]) < 10) continue;
		$v .= " ".$line[0];
		$time++;
	}
	fclose($vFile);

    $result = $cl->Query($v, 'test1, testrt');
    
    $newRecord = "";

    $count = 0;
    foreach ($scoreMatrix as $row => $col) {
    	$score = "0";
    	if ($result['total_found'] != '0' && array_key_exists($row, $result['matches'])) {
    		$score = $result['matches'][$row]['weight'];
		}

		$col .= ','.$docID.'|'.$score;
		$scoreMatrix[$row] = $col;
		$newRecord .= $row.'|'.$score;
		if ($count < count($scoreMatrix)-1) {
			$newRecord .= ',';
			$count++;
		}
    }

    $scoreMatrix[$docID] = $newRecord;
    return $scoreMatrix;
}
