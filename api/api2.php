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

function getForce($latlong) {
$neighbourhood = json_decode(file_get_contents("http://data.police.uk/api/locate-neighbourhood?q=" . $latlong));
return $neighbourhood->force;
}

function getCrime($latlong) {
	$neighbourhood = json_decode(file_get_contents("http://data.police.uk/api/locate-neighbourhood?q=" . $latlong));
	$crime = json_decode(file_get_contents("http://data.police.uk/api/" . $neighbourhood->force . "/" . $neighbourhood->neighbourhood . "/crime"));
	

	$result = 0;
	$date_count = 0;
	foreach ($crime->crimes as $history) {
		$result += $history->{'all-crime'}->{'total_crimes'};
		++$date_count;
	}
	return $result / $date_count;
}

?>
