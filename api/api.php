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


function getAuthorityFromPostcode($postcode) {
	return "K02000001";
}

function getSatisfaction($postcode) {
	$authority=getAuthorityFromPostcode($postcode);
	$query="SELECT average FROM happiness WHERE code='$authority'";
	$res = mySQLquery($query);

	
      while($row = mysql_fetch_array( $res )) {
                $average = $row[0];
		return $average;
 	 }

}

function mySQLquery($query) {
$DB_HOST="localhost";
$DB_USER="nhtg";
$DB_PASS="5WZvTbwQXLPxdQc2";
$DB_NAME="nhtg13";
mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die(mysql_error()." | HOST ".$DB_HOST." USER ".$DB_USER." PASS ".$DB_PASS ." NAME ".$DB_NAME." | Error on connect ");
mysql_select_db($DB_NAME) or die(mysql_error()." | HOST ".$DB_HOST." USER ".$DB_USER." PASS ".$DB_PASS ." NAME ".$DB_NAME." | Error on select db ");

$result = mysql_query("$query") or die(mysql_error()." | HOST ".$DB_HOST." USER ".$DB_USER." PASS ".$DB_PASS ." NAME ".$DB_NAME. " | Error on query " );  

// keeps getting the next row until there are no more to get
#while($row = mysql_fetch_array( $result )) {
#	// Print out the contents of each row into a table
#}
return $result; 
}

?>
