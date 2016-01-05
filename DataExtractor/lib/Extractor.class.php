<?php
require_once("lib/url_to_absolute.php");

class Extractor {
	public $url;
	public $htmlCode;
	public static $emailRegex = "/([A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,})/i";
	public static $phoneRegex = array(
		"/(\d{3}[- ]\d{3}[- ]\d{4})/",					// match 123-456-7890 or 123 456-7890
		"/[^\/](\d{10})[^\/]/",							// match 1234567890
		"/(\(\d{3}\)[ \/]+\d{3}[- ]\d{4})/",			// match (123) 456-7890 or (123) / 456-7890
		"/(\+?\d+[- ]\d{3}[- ]\d{3}[- ]\d{4})/",		// match +1-123-456-7890
		"/(\d{3}[- ]\d{7})/" 							// match 123-4567890
	);
	public static $urlRegex = array(
		"/<a[^>]+href\s*=\s*[\"'](\S+page=\d+\S*)[\"']/",
		"/<a[^>]+href\s*=\s*[\"'](\S+PageNum=\d+\S*)[\"']/",
		"/<a[^>]+href\s*=\s*\"(\S+p=\d+\S*)\"/"
	);


	public function __construct($url) {
		$this -> url = $url;
		$this -> htmlCode = $this -> getHTMLCode();
	}

	public function getHTMLCode() {
		$options = array(
			CURLOPT_CUSTOMREQUEST 	=> 'GET',
			CURLOPT_POST			=> false,
			CURLOPT_USERAGENT		=> 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0',
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_HEADER 			=> false,
			CURLOPT_FOLLOWLOCATION 	=> true,
			CURLOPT_ENCODING 		=> '',
			CURLOPT_AUTOREFERER 	=> true,
			CURLOPT_MAXREDIRS		=> 10,
			// CURLOPT_CAINFO 			=> "/lib/cacert.pem"
			CURLOPT_SSL_VERIFYHOST	=> false,
			CURLOPT_SSL_VERIFYPEER	=> false
		);

		$curlHandle = curl_init($this -> url);
		curl_setopt_array($curlHandle, $options);
		$htmlCode = curl_exec($curlHandle);
		print curl_error($curlHandle);
		curl_close($curlHandle);
		return $htmlCode;
	}

	public function getEmailFromHTML(&$emailList, $emailRegex = '') {
		$matches = array();
		if ($emailRegex == '') { $emailRegex = self::$emailRegex; }

		$textData = str_replace('%40', '@', $this -> htmlCode);
		$textData = str_replace('%2F', '/', $textData);
		$textData = str_replace('%3F', '?', $textData);
		$textData = str_replace('%3D', '=', $textData);
		$textData = str_replace('%26', '&', $textData);
		$textData = str_replace('%3A', ':', $textData);
		$textData = str_replace('%25', '%', $textData);
		$textData = str_replace('%22', '"', $textData);
		$textData = str_replace('%3E', '>', $textData);

		preg_match_all($emailRegex, $textData, $matches);
		if (isset($matches[1])) {
			$emailList = array_merge($emailList, $matches[1]);
		}
		$emailList = array_unique($emailList);
	}

	public function getNumbersFromHTML(&$phoneList, $phoneRegexList = array()) {
		// remove Javascript and HTML tags
		$textData = preg_replace('/<script(.*?)>(.*?)<\/script>/is', '', $this -> htmlCode);
		$textData = preg_replace('/<style(.*?)>(.*?)<\/style>/is', '', $textData);
		$textData = strip_tags($textData);
		if (empty($phoneRegexList)) { $phoneRegexList = self::$phoneRegex; }
		foreach ($phoneRegexList as $pr) {
			$matches = array();
			preg_match_all($pr, $textData, $matches);

			if (isset($matches[1])) { 
				$phoneList = array_merge($phoneList, $matches[1]);
			}	
		}
		$phoneList = array_unique($phoneList);
	}

	public function getURLFromHTML(&$urlList, $urlRegexList = array()) {
		if (empty($urlRegexList)) { $urlRegexList = self::$urlRegex; }
		foreach ($urlRegexList as $ur) {
			$matches = array();
			preg_match_all($ur, $this -> htmlCode, $matches);
			if (isset($matches[1])) { 
				// convert matched links to full url
				for ($i = 0; $i < count($matches[1]); $i++) {
					$link = $this -> encodeURL($matches[1][$i]);
					// $link = urlencode($matches[1][$i]);
					// $link = str_replace('%2F', '/', $link);
					// $link = str_replace('%3F', '?', $link);
					// $link = str_replace('%3D', '=', $link);
					// $link = str_replace('%26', '&', $link);
					// $matches[1][$i] = urldecode(url_to_absolute($this -> url, $link));
					$matches[1][$i] = url_to_absolute($this -> url, $link);
				}
				$urlList = array_merge($urlList, $matches[1]);
			}
			$urlList = array_unique($urlList);
		}
	}

	// only get unique urls
	public function getAllURLFromHTML() {
		$output = array();
		$dom = new DOMDocument();
		@$dom -> loadHTML($this -> htmlCode);
		$xpath = new DomXPath($dom);
		$hrefs = $xpath -> evaluate("/html/body//a");
		for ($i = 0; $i < $hrefs -> length; $i++) {
			$h = $this -> encodeURL($hrefs -> item($i) -> getAttribute('href'));
			$h = url_to_absolute($this -> url, $h);

			array_push($output, $h);
		}
		return array_unique($output);
	}

	private function encodeURL($url) {
		$link = urlencode($url);
		$link = str_replace('%2F', '/', $link);
		$link = str_replace('%3F', '?', $link);
		$link = str_replace('%3D', '=', $link);
		$link = str_replace('%26', '&', $link);
		$link = str_replace('%3A', ':', $link);
		$link = str_replace('%25', '%', $link);
		return $link;
	}

	public static function deleteFiles($folderpath) {
		$files = glob("$folderpath/*"); // get all file names
		foreach($files as $file){ // iterate files
			if(is_file($file))
			unlink($file); // delete file
		}
	}

	public static function writeToFile($fileName, $emailList, $phoneList) {
		self::deleteFiles('output');
		$csvFile = fopen('output/' . $fileName . '.csv', 'w');
		foreach ($emailList as $e) {
			fwrite($csvFile, "=\"$e\"\n");
		}
		foreach ($phoneList as $p) {
			fwrite($csvFile, "=\"$p\"\n");
		}
		fclose($csvFile);
	}
}
?>