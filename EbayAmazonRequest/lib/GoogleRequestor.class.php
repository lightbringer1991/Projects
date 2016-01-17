<?php
class GoogleRequestor {
	private static $suggestionURL = 'http://suggestqueries.google.com/complete/search?output=firefox&hl=en&q=';

	private $keyword;

	public function __construct($keyword) {
		$this -> keyword = $keyword;
	}

	public function generateSuggestions() {
		$fullURL = self::$suggestionURL . urlencode($this -> keyword);
		$jsonData = json_decode(file_get_contents($fullURL), true);
		return $jsonData[1];
	}
}
?>