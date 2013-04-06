<?php
//$postcode = urldecode($_GET['postcode']);
//exec("python api.py \"$postcode\"", $output, $ret_code);
//json_decode($output);
//print_r(implode("\n",$output));

//$apicall=$_GET['api'];
//$keywords=$_GET['keywords'];
//$id = $_GET['uid'];


//if ($apicall=="searchMP") 
//	$ret = searchMP($keywords);
//if ($apicall=="getMPinfo")
//        $ret = queryTheyWorkForYou($id);
//if ($apicall=="getTWFYid") 
//	$ret = getTWFYid($id);

//header('Access-Control-Allow-Origin: *');
//print $ret;
include("api2.php");
function existText($val) {
	if ($val)
		return true;
	else return false;
}

function getLife($postcode) {

	$query = "SELECT country, countycode, districtcode from postcodes where postcode='$postcode'";
	$res = mySQLquery($query);
	$out = array();
	$searchstring="";
	while ($row =mysql_fetch_assoc($res)) {
		$out["country"] = '"'. $row["country"] .'"';
		$out["county"] = '"'.$row["countycode"].'"';;
		$out["district"] ='"'. $row["districtcode"].'"';;


	}

	$sec = array_filter($out, "existText");
	$second = implode(",", $sec);
	$query = "SELECT max(life) FROM lifeexpectancy l WHERE l.gss in ($second)";
	$res = mySQLquery($query);
	while ($row = mysql_fetch_array($res)) {

		$life = $row[0];
	}
	return $life;


}

function getHeadline($queryval,$lat,$lon) {
	
	

	// max & min Life
	$maxLife = 69.0;
	$minLife = 58.3;
	$maxHapp = 8.10;
	$minHapp = 7.09;
	// TODO modify to get runtime values

	$life = getLife($queryval);
	$happy = getSatisfaction($queryval);
	$normalisedCrime = getCrime("$lat,$lon");

	$normalisedLife = ($life-58.3)*1000/11.7;
	$normalisedHappy = ($happy-7.09)*1000/11.01;


	$lifethres = abs($normalisedLife-500);
	$happythres = abs($normalisedHappy-500);
	$crimethres = abs($normalisedCrime-250);

	$max = $lifethres;
	$winner = "life";
	$sign = "";
	
	if ($normalisedLife > 500) 
		$sign = "SOARING";
	else 
		$sign = "ROCK BOTTOM";
	
	if ($happythres > $max) {
		$max = $happythres;
		$winner = "happiness";

		if ($normalisedHappy > 500)
                $sign = "SOARING";
        		else
                $sign = "ROCK BOTTOM";

	}

	if ($crimethres > $max) {
		$max = $crimethres;
		$winner = "crime";

		if ($normalisedCrime < 250)
                $sign = "SOARING";
        else
                $sign = "ROCK BOTTOM";

	}
	$force = getForce("$lat,$lon");

	return "$force $winner $sign,$life,$happy,$normalisedCrime";

}



function getSatisfaction($postcode) {

        $query = "SELECT country, countycode, districtcode from postcodes where postcode='$postcode'";
        $res = mySQLquery($query);
        $out = array();
        $searchstring="";
        while ($row =mysql_fetch_assoc($res)) {
                $out["country"] = '"'. $row["country"] .'"';
                $out["county"] = '"'.$row["countycode"].'"';;
                $out["district"] ='"'. $row["districtcode"].'"';;


        }

        $sec = array_filter($out, "existText");
        $second = implode(",", $sec);
        $query = "SELECT max(average) FROM happiness l WHERE l.code in ($second)";
        $res = mySQLquery($query);
        while ($row = mysql_fetch_array($res)) {

                $life = $row[0];
        }
        return $life;

}

function mySQLquery($query) {
$DB_HOST="localhost";
$DB_USER="nhtg";
$DB_PASS="5WZvTbwQXLPxdQc2";
$DB_NAME="nhtg13";
mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die(mysql_error()." | HOST ".$DB_HOST." USER ".$DB_USER." PASS ".$DB_PASS ." NAME ".$DB_NAME." | Error on connect ");
mysql_select_db($DB_NAME) or die(mysql_error()." | HOST ".$DB_HOST." USER ".$DB_USER." PASS ".$DB_PASS ." NAME ".$DB_NAME." | Error on select db ");

$result = mysql_query("$query") or die(mysql_error()." | HOST ".$DB_HOST." USER ".$DB_USER." PASS ".$DB_PASS ." NAME ".$DB_NAME. " | Error on query " );  

return $result; 
}

?>
