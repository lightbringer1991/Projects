<?php
set_include_path(get_include_path() . PATH_SEPARATOR . './lib/google-api-php-client/src');
date_default_timezone_set('America/New_York');
require_once 'lib/google-api-php-client/src/Google/autoload.php';
require_once 'Google/Client.php';
require_once 'Google/Service/YouTube.php';

class GoogleRequestor {
	private static $suggestionURL = 'http://suggestqueries.google.com/complete/search?output=firefox&hl=en&q=';
	private static $apiKey = 'AIzaSyCOWN6mX521qySYJm7hUbDCJgWm2ov-2uQ';

	private $youtubeBaseURL = 'http://www.youtube.com/embed/';

	private $keyword;

	public function __construct($keyword) {
		$this -> keyword = $keyword;
	}

	public function generateSuggestions() {
		$fullURL = self::$suggestionURL . urlencode($this -> keyword);
		$jsonData = json_decode(file_get_contents($fullURL), true);
		return $jsonData[1];
	}

	// returned videos is always $maxResults - 1
	public function getYouTubeVideos($maxResults = 6) {
		$client = new Google_Client();
		$client -> setDeveloperKey(self::$apiKey);
		$youtube = new Google_Service_YouTube($client);

		try {
			$searchResponse = $youtube -> search -> listSearch('id,snippet', array(
				'q' => urlencode($this -> keyword),
				'maxResults' => $maxResults
			));
			$videos = array();

			foreach ($searchResponse['items'] as $result) {
				if ($result['id']['kind'] == 'youtube#video') {
					$videos[$result['snippet']['title']] = array(
						'url' => $this -> youtubeBaseURL . $result['id']['videoId'],
						'thumbnail' => $result['snippet']['thumbnails']['default']['url']
					);
				}
			}
			return $videos;
		} catch (Google_Service_Exception $e) {
			die( sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage())) );
		} catch (Google_Exception $e) {
			die( sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage())) );
		}
		return null;
	}
}
?>