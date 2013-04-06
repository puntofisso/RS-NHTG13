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

function getCrime($postcode) {
	$authority=getAuthorityFromPostcode($postcode);
	$query="SELECT average FROM happiness WHERE code='$authority'";
	$res = mySQLquery($query);

	
      while($row = mysql_fetch_array( $res )) {
                $average = $row[0];
		return $average;
 	 }

}

?>
