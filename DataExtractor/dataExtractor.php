<?php
// error_reporting( E_ALL );
set_time_limit(1800);
require_once("lib/Extractor.class.php");

$urlList = explode("\r\n", $_POST['url']);
$fileName = $_POST['fileID'];
$option = (isset($_POST['options'])) ? $_POST['options'] : '0';

$emailList = array();
$phoneList = array();

//---- main script
if ($option == 'deep') {
	$moreURLs = array();
	foreach ($urlList as $u) {
		$extractor = new Extractor($u);
		$moreURLs = array_unique( array_merge($moreURLs, $extractor -> getAllURLFromHTML()) );
	}
	$urlList = array_unique(array_merge($urlList, $moreURLs));
}

error_log("Running with base URL list\r\n" . var_dump($urlList), 3, 'error_log.txt');
for ($i = 0; $i < count($urlList); $i++) {
	// skip url if the link is for email
	if (strpos($urlList[$i], 'mailto') !== false) { continue; }
	error_log($urlList[$i] . "\r\n", 3, 'error_log.txt');
	$extractor = new Extractor($urlList[$i]);
	$extractor -> getEmailFromHTML($emailList);
	$extractor -> getNumbersFromHTML($phoneList);
	if ($option == 'multiple') {
		$extractor -> getURLFromHTML($urlList);
	}
}
Extractor::writeToFile($fileName, $emailList, $phoneList);
?>