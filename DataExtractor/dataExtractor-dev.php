<?php
error_reporting( E_ALL );
$userPHPPath = '/home/kar24j/php';
set_include_path(get_include_path() . PATH_SEPARATOR . $userPHPPath);
set_time_limit(1800);
require_once("Net/URL2.php");
require_once("lib/url_to_absolute.php");

function getHTMLCode($url) {
	$curlHandle = curl_init($url);
	curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
	$htmlCode = curl_exec($curlHandle);
	curl_close($curlHandle);
	return $htmlCode;
}

function deleteFiles($folderpath) {
	$files = glob("$folderpath/*"); // get all file names
	foreach($files as $file){ // iterate files
		if(is_file($file))
		unlink($file); // delete file
	}
}

// find links with 'page' in their url, attempt to traverse URL with data in pagination structure
// $htmlCode 			returned from curlHandle
// $urlRegexList 		define which url format to grab
// $urlArray 			returned array (in case user wants to store unique URL only), and they will be html encoded
function getURLFromHTML($originalURL, $htmlCode, $urlRegexList, &$urlList) {
	// $mainURLObj = new Net_URL2($originalURL);
	foreach ($urlRegexList as $ur) {
		$matches = array();
		preg_match_all($ur, $htmlCode, $matches);
		if (isset($matches[1])) { 
			// convert matched links to full url
			for ($i = 0; $i < count($matches[1]); $i++) {
				$link = urlencode($matches[1][$i]);
				$link = str_replace('%2F', '/', $link);
				$link = str_replace('%3F', '?', $link);
				// $urlObj = new Net_URL2($link);
				// relative url, add scheme, host and port into it
				$matches[1][$i] = urldecode(url_to_absolute($originalURL, $link));
				// if ($urlObj -> getScheme() == false) {
				// 	$urlObj -> setScheme($mainURLObj -> getScheme());
				// 	$urlObj -> setHost($mainURLObj -> getHost());
				// 	$urlObj -> setPort($mainURLObj -> getPort());
				// }
				// // query doesn't need to be encoded
				// $urlObj -> setQuery(urldecode($urlObj -> getQuery()));
				// $matches[1][$i] = (string)$urlObj;
			}
			$urlList = array_merge($urlList, $matches[1]);
		}
		$urlList = array_unique($urlList);
	}
}

/*
	get all emails from a given HTML code
	$emailList contains the new list with unique emails
*/
function getEmailFromHTML($htmlCode, $emailRegex, &$emailList) {
	$matches = array();
	preg_match_all($emailRegex, $htmlCode, $matches);
	if (isset($matches[1])) {
		$emailList = array_merge($emailList, $matches[1]);
	}

	if (isset($matches[1])) {
		$emailList = array_merge($emailList, $matches[1]);
	}
	$emailList = array_unique($emailList);
}

function getNumbersFromHTML($htmlCode, $phoneRegexList, &$phoneList) {
	foreach ($phoneRegexList as $pr) {
		$matches = array();
		preg_match_all($pr, $htmlCode, $matches);

		if (isset($matches[1])) { 
			$phoneList = array_merge($phoneList, $matches[1]);
		}	
	}
	$phoneList = array_unique($phoneList);
}

function writeToFile($fileName, $emailList, $phoneList) {
	deleteFiles('output');
	$csvFile = fopen("output/$fileName.csv", 'w');
	foreach ($emailList as $e) {
		fwrite($csvFile, "$e\n");
	}
	foreach ($phoneList as $p) {
		fwrite($csvFile, "$p\n");
	}
	fclose($csvFile);
}

$url = $_POST['url'];
$fileName = $_POST['fileID'];
$pageTracing = (isset($_POST['tracing'])) ? $_POST['tracing'] : 0;


// //tests
// $pageTracing = 1;
// $fileName = 'test';

//----------- define global variables 

// $url = "http://www.ballaratkendoclub.org/";
// $url = "http://www.melbournebudokai.com.au/page-1329142";
// $url = "http://repucom.net/contact/usa/";
// $url = "http://stdcxx.apache.org/doc/stdlibug/26-1.html";
// $url = "http://www.archifind.co.il/%D7%9E%D7%A2%D7%A6%D7%91%D7%99-%D7%A4%D7%A0%D7%99%D7%9D?page=1&amp;start_10=0&amp;start_20=0&amp;start_30=0&amp;code=&amp;expertise=0";
// $url = "http://www.localbiz.co.il/Business/Biz-Category.aspx?PageNum=1&amp;CategoryId=48&amp;CityId=-1&amp;Can=%D7%90%D7%99%D7%A0%D7%98%D7%A8%D7%A0%D7%98+-+%D7%A9%D7%99%D7%95%D7%95%D7%A7+%D7%95%D7%A4%D7%A8%D7%A1%D7%95%D7%9D&amp;Cin=";
// $url = "http://www.hasut.co.il/24683";
// $url = "http://we.keepitsimple.co.il/user/87";

$emailList = array();
$phoneList = array();
$emailRegex = "/([A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,})/i";
$phoneRegex = array(
	"/(\d{3}[- ]\d{3}[- ]\d{4})/",					// match 123-456-7890 or 123 456-7890
	"/[^a-zA-Z0-9](\d{10})[^a-zA-Z0-9]/",			// match 1234567890
	"/(\(\d{3}\)[ \/]+\d{3}[- ]\d{4})/",			// match (123) 456-7890 or (123) / 456-7890
	"/(\+?\d+[- ]\d{3}[- ]\d{3}[- ]\d{4})/",		// match +1-123-456-7890
	"/(\d{3}[- ]\d{7})/" 							// match 123-4567890
);
$urlRegex = array(
	"/<a[^>]+href\s*=\s*\"(\S+page=\d+\S+)\"/",
	"/<a[^>]+href\s*=\s*[\"'](\S+PageNum=\d+\S+)[\"']/",
	"/<a[^>]+href\s*=\s*\"(\S+p=\d+\S+)\"/"
);

$urlList = array($url);
for ($i = 0; $i < count($urlList); $i++) {
	// error_log("Checking {$urlList[$i]}\n", 3, "error_log");
	// print "Checking {$urlList[$i]}\n";
	$htmlCode = getHTMLCode($urlList[$i]);
	getEmailFromHTML($htmlCode, $emailRegex, $emailList);
	getNumbersFromHTML($htmlCode, $phoneRegex, $phoneList);

	if ($pageTracing) {
		getURLFromHTML($url, $htmlCode, $urlRegex, $urlList);
	}
	if ($i == 100) { break; }
}
writeToFile($fileName, $emailList, $phoneList);


// ---- test
// $htmlCode = getHTMLCode($url);
// $dom = new DOMDocument();
// $dom -> loadHTML($htmlCode);
// $xpath = new DOMXPath($dom);
// $hrefs = $xpath -> evaluate("/html/body//a");
// for ($i = 0; $i < $hrefs -> length; $i++) {
// 	$h = $hrefs -> item($i);
// 	// echo $h -> getAttribute('href') . "\n";
// 	echo url_to_absolute( $url, $h -> getAttribute('href') ) . "\n";
// }

// $url2 = "Biz-Category.aspx?PageNum=3&CategoryId=&CityId=-1&Can=&Cin=";



// $htmlCode = getHTMLCode($url);
// print $htmlCode
// getEmailFromHTML($htmlCode, $emailRegex, $emailList);
// getNumbersFromHTML($htmlCode, $phoneRegex, $phoneList);
// print var_dump($emailList);
// print var_dump($phoneList);

// $urlList = array();
// getURLFromHTML($url, $htmlCode, $urlRegex, $urlList);
// print var_dump($urlList);

// $matches = array();
// preg_match_all($urlRegex[1], $htmlCode, $matches);
// print var_dump($matches);

?>