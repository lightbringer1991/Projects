<?php
class AmazonRequestor {
	private $keyword;
	private $data;

	private $_secretKey = 'ye0kqRD7ZQKoq9ULaYi696cgBgXKz2LrsDpyPS1R';
	private $_associateTag = 'productsearch09-20';
	private $_accessKeyID = 'AKIAJQVSAMHIUG7LHPTQ';
	private $endpoint = "webservices.amazon.com";
	private $uri = "/onca/xml";

	public function __construct($keyword) {
		$this -> keyword = $keyword;
	}

	public function runRequest() {
		$params = array(
			"Service" => "AWSECommerceService",
			"Operation" => "ItemSearch",
			"AWSAccessKeyId" => $this -> _accessKeyID,
			"AssociateTag" => $this -> _associateTag,
			"SearchIndex" => "All",
			"Keywords" => $this -> keyword,
			"ResponseGroup" => "Images,ItemAttributes,Offers,Reviews",
			"Condition" => "New",
			"Timestamp" => gmdate('Y-m-d\TH:i:s\Z'),
			"IncludeReviewsSummary" => 'True'
		);

		$requestURL = $this -> generateRequestURL($params);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$requestURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);

		$this -> data = curl_exec($ch);
		error_log(date('d/m/Y H:i:s') . " - Amazon data retrieved\r\n", 3, 'error_log.txt');
		return $this -> data;
	}

	// return an array of necessary data, xmlResponse can be manually put in
	// if $xmlresponse is empty, use private $this -> data instead
	public function extractNecessaryData($xmlResponse = '') {
		$output = array();
		if ($xmlResponse == '') { $xmlResponse = $this -> data; }
		libxml_use_internal_errors(true);
		try {
			$simpleXML = new SimpleXMLElement($xmlResponse);
			$reviewURLList = array();
			foreach ($simpleXML -> Items -> Item as $i) {
				// get review url
				$itemLinksList = $i -> ItemLinks -> ItemLink;
				foreach ($itemLinksList as $il) {
					if ($il -> Description -> __toString() == 'All Customer Reviews') {
						$reviewURLList[$i -> ASIN -> __toString()] = $il -> URL -> __toString();
						break;
					}
				}
				$picture = "";
				if (isset($i -> MediumImage)) {
					$picture = $i -> MediumImage -> URL -> __toString();
				} else {
					$imageSetList = $i -> ImageSets -> ImageSet;
					$picture = $imageSetList[0] -> MediumImage -> URL -> __toString();
				}

				if ($i -> Offers -> TotalOffers -> __toString() == '0') {
					// print $i -> CustomerReviews -> IFrameURL -> __toString() . "\n";
					$output[$i -> ASIN -> __toString()] = array(
						'picture' => $picture,
						'url' => $i -> DetailPageURL -> __toString(),
						'title' => $i -> ItemAttributes -> Title -> __toString(),
						'price' => 0,
						'currencyId' => 'N/A',
						'shippingCost' => 'N/A'						
					);
				} else {
					$data = array(
						'picture' => $picture,
						'url' => $i -> DetailPageURL -> __toString(),
						'title' => $i -> ItemAttributes -> Title -> __toString(),
						'price' => $i -> Offers -> Offer -> OfferListing -> Price -> FormattedPrice -> __toString(),
						'currencyId' => $i -> Offers -> Offer -> OfferListing -> Price -> CurrencyCode -> __toString(),
						'shippingCost' => 'N/A'
					);
					error_log(date('d/m/Y H:i:s') . " - Review Rating for " . $i -> ASIN -> __toString() . " retrieved\r\n", 3, 'error_log.txt');
					$output[$i -> ASIN -> __toString()] = $data;
				}
			}
			// get all rating in the same request
			$ratingList = $this -> getAllReviewRating($reviewURLList);
			foreach ($ratingList as $asin => $rating) {
				$output[$asin]['feedback'] = $rating;
			}
			
		} catch(Exception $e) {
			print_r($e -> getMessage());
		}
		return $output;
	}

	private function generateRequestURL($params) {
		// Sort the parameters by key
		ksort($params);
		$pairs = array();

		foreach ($params as $key => $value) {
			array_push($pairs, rawurlencode($key) . "=" . rawurlencode($value));
		}

		// Generate the canonical query
		$canonical_query_string = join("&", $pairs);

		// Generate the string to be signed
		$string_to_sign = "GET\n" . $this -> endpoint . "\n" . $this -> uri . "\n" . $canonical_query_string;

		// Generate the signature required by the Product Advertising API
		$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $this -> _secretKey, true));

		// Generate the signed URL
		$request_url = 'http://' . $this -> endpoint . $this -> uri . '?' . $canonical_query_string . '&Signature='.rawurlencode($signature);

		return $request_url;
	}

	// input array(<ASIN> => <url>)
	// return array array(<ASIN> => <rating>)
	public function getAllReviewRating($urlList) {
		$curlList = array();
		$mh = curl_multi_init();
		foreach ($urlList as $asin => $u) {
			$curlList[$asin] = curl_init($u);
			curl_setopt_array($curlList[$asin], array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_VERBOSE => 1,
				CURLOPT_DNS_USE_GLOBAL_CACHE => 0,
				CURLOPT_DNS_CACHE_TIMEOUT => 2
			));
			curl_multi_add_handle($mh, $curlList[$asin]);
		}
		$active = null;
		do {
			$mrc = curl_multi_exec($mh, $active);
		} while ($mrc == CURLM_CALL_MULTI_PERFORM);

		while ($active && $mrc == CURLM_OK) {
			if (curl_multi_select($mh) == -1) {
				usleep(200);
			}
			do {
				$mrc = curl_multi_exec($mh, $active);
			} while ($mrc == CURLM_CALL_MULTI_PERFORM);
		}

		$output = array();
		foreach ($urlList as $asin => $u) {
			$output[$asin] = $this -> getRating(curl_multi_getcontent($curlList[$asin])) . "\n";
			curl_multi_remove_handle($mh, $curlList[$asin]);
			curl_close($curlList[$asin]);
		}
		return $output;
	}

	private function getRating($htmlCode) {
		$matches = array();
		preg_match("/<span class=\"arp-rating-out-of-text\">([^<]+)<\/span>/", $htmlCode, $matches);
		$tokens = explode(' ', $matches[1]);
		return $tokens[0];

	}
}

?>
