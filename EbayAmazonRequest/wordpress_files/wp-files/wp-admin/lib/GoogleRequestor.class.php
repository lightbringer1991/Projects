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
	public function getYouTubeVideos($maxResults = 5) {
		$client = new Google_Client();
		$client -> setDeveloperKey(self::$apiKey);
		$youtube = new Google_Service_YouTube($client);

		try {
			$searchResponse = $youtube -> search -> listSearch('id,snippet', array(
				'type' => 'video',
				'q' => urlencode($this -> keyword),
				'maxResults' => $maxResults,
				'order' => 'viewCount'
			));
			$videos = array();
			$videoIds = array();
			foreach ($searchResponse['items'] as $result) {
				array_push($videoIds, $result['id']['videoId']);
				$videos[$result['id']['videoId']] = array(
					'url' => $this -> youtubeBaseURL . $result['id']['videoId'],
					'thumbnail' => $result['snippet']['thumbnails']['high']['url'],
					'title' => $result['snippet']['title']
				);
			}
			$videoResponse = $youtube -> videos -> listVideos('id,contentDetails,statistics', array('id' => join(',', $videoIds)));
			foreach ($videoResponse['items'] as $videoResult) {
				$duration = $this -> getYouTubeDurations($videoResult['contentDetails']['duration']);
				$videos[$videoResult['id']]['duration'] = "{$duration[0]}:{$duration[1]}";
				$videos[$videoResult['id']]['views'] = $videoResult['statistics']['viewCount'];
			}

			return $videos;
		} catch (Google_Service_Exception $e) {
			die( sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage())) );
		} catch (Google_Exception $e) {
			die( sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage())) );
		}
		return null;
	}

	// return array(minutes, seconds), e.g. array(1,30) = 1min30s
	// input $videoResult['contentDetails']['duration']
	private function getYouTubeDurations($string) {
		$duration_string = $string;
		$pattern = '/PT(([0-9]+)M)?(([0-9]+)S)?/';
		preg_match($pattern, $duration_string, $matches);
		if(!empty($matches[2])) {
			$mins = ($matches[2] < 10) ? '0' . $matches[2] : $matches[2];
		} else {
			$mins = '00';
		}

		if(!empty($matches[4])) {
			$secs = ($matches[4] < 10) ? '0' . $matches[4] : $matches[4];
		} else {
			$secs = '00';
		}
		return array($mins, $secs);
	}
}
?>