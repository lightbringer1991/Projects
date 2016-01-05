<?php
error_reporting( E_ALL );
require_once("lib/Extractor.class.php");

// $url = $_POST['url'];
// $fileName = $_POST['fileID'];
// $option = (isset($_POST['options'])) ? $_POST['options'] : 0;
// $pageTracing = (isset($_POST['tracing'])) ? $_POST['tracing'] : 0;
// $deepLevel = (isset($_POST['deep_lv1'])) ? $_POST['deep_lv1'] : 0;

//test
$fileName = 'test';
$option = '0';

// $url = "http://we.keepitsimple.co.il/members?members_page=1";
// $url = "http://www.archifind.co.il/%D7%9E%D7%A2%D7%A6%D7%91%D7%99-%D7%A4%D7%A0%D7%99%D7%9D?page=1&amp;start_10=0&amp;start_20=0&amp;start_30=0&amp;code=&amp;expertise=0";
// $url = "https://keepitsimple.co.il/wordpress-site-building";
// $url = "http://we.keepitsimple.co.il/user/38";
// $url = "http://we.keepitsimple.co.il/user/3/";
// $url2 = "http://we.keepitsimple.co.il/user/38";
// $url = "http://www.hasut.co.il/24683";
// $url = "http://we.keepitsimple.co.il/user/149/";
// $url = 'http://www.b144.co.il/BusinessResults.aspx?_business=%D7%A7%D7%95%D7%A1%D7%9E%D7%98%D7%99%D7%A7%D7%90%D7%99%D7%95%D7%AA&_page_no=1';
// $url = "https://www.t.co.il/531-%D7%A7%D7%95%D7%A1%D7%9E%D7%98%D7%99%D7%A7%D7%90%D7%99%D7%95%D7%AA.html";
// $url = 'http://www.b144.co.il/BusinessResults.aspx?TS01568688_id=3&_business=%D7%A7%D7%95%D7%A1%D7%9E%D7%98%D7%99%D7%A7%D7%90%D7%99%D7%95%D7%AA&_page_no=1';
// $url = "http://www.imakeup.co.il/Suppliers/2/%D7%90%D7%99%D7%A4%D7%95%D7%A8+%D7%9C%D7%90%D7%99%D7%A8%D7%95%D7%A2%D7%99%D7%9D.html";
$url = 'http://www.lawyerinfo.co.il/lawyer/5332-%D7%A2%D7%99%D7%9C%D7%99-%D7%90%D7%91%D7%99%D7%90%D7%9C';

$emailList = array();
$phoneList = array();

$urlList = array($url);

// test
// $extractor = new Extractor($url);
// $urlList = array_merge($urlList, $extractor -> getAllURLFromHTML());
// print var_dump($urlList);

$extractor = new Extractor($url);
$extractor -> getEmailFromHTML($emailList);
$extractor -> getNumbersFromHTML($phoneList);
print var_dump($emailList);
print var_dump($phoneList);

// $extractor = new Extractor($url2);
// $extractor -> getEmailFromHTML($emailList);
// $extractor -> getNumbersFromHTML($phoneList);
// print var_dump($emailList);
// print var_dump($phoneList);

// ---- main script
// if ($option == 'deep') {
// 	$extractor = new Extractor($url);
// 	$urlList = array_merge($urlList, $extractor -> getAllURLFromHTML());
// }
// for ($i = 0; $i < count($urlList); $i++) {
// 	// skip url if the link is for email
// 	if (strpos($urlList[$i], 'mailto') !== false) { continue; }
// 	// error_log("Checking {$urlList[$i]}\n", 3, "error_log");
// 	print "Checking {$urlList[$i]}\n";
// 	$extractor = new Extractor($urlList[$i]);
// 	$extractor -> getEmailFromHTML($emailList);
// 	$extractor -> getNumbersFromHTML($phoneList);
// 	if ($option == 'multiple') {
// 		$extractor -> getURLFromHTML($urlList);
// 	}
// }
// Extractor::writeToFile($fileName, $emailList, $phoneList);
?>