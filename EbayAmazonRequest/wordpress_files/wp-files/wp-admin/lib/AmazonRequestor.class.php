<?php
class AmazonRequestor {
	private $keyword;
	private $data;

	private static $_secretKey = 'ye0kqRD7ZQKoq9ULaYi696cgBgXKz2LrsDpyPS1R';
	private static $_associateTag = 'productsearch09-20';
	private static $_accessKeyID = 'AKIAJQVSAMHIUG7LHPTQ';
	private static $endpoint = "webservices.amazon.com";
	private static $uri = "/onca/xml";

	public function __construct($keyword) {
		$this -> keyword = $keyword;
	}

	public function runRequest() {
		$params = array(
			"Service" => "AWSECommerceService",
			"Operation" => "ItemSearch",
			"AWSAccessKeyId" => self::$_accessKeyID,
			"AssociateTag" => self::$_associateTag,
			"SearchIndex" => "All",
			"Keywords" => $this -> keyword,
			"ResponseGroup" => "Images,ItemAttributes,Offers,Reviews",
			"Condition" => "New",
			"Timestamp" => gmdate('Y-m-d\TH:i:s\Z'),
			"IncludeReviewsSummary" => 'True',
			// "MerchantId" => 'Amazon'
			// "MinPercentageOff" => 0
		);

		$requestURL = self::generateRequestURL($params);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$requestURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);

		$this -> data = curl_exec($ch);
		error_log(gmdate('d/m/Y H:i:s') . " - Amazon data retrieved\r\n", 3, 'error_log.txt');
		return $this -> data;
	}

	public static function getItemDetailsURL($itemID) {
		$params = array(
			"Service" => "AWSECommerceService",
			"Operation" => "ItemLookup",
			"AWSAccessKeyId" => self::$_accessKeyID,
			"AssociateTag" => self::$_associateTag,
			"ItemId" => $itemID,
			"Timestamp" => gmdate('Y-m-d\TH:i:s\Z')
		);

		$requestURL = self::generateRequestURL($params);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$requestURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		$xmlData = curl_exec($ch);

		// get technical details URL
		$simpleXML = new SimpleXMLElement($xmlData);
		foreach ($simpleXML -> Items -> Item -> ItemLinks -> ItemLink as $il) {
			if ($il -> Description -> __toString() == 'Technical Details') {
				return $il -> URL -> __toString();
			}
		}
		return '';
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
				// get display picture URL
				$picture = "";
				if (isset($i -> MediumImage)) {
					$picture = $i -> MediumImage -> URL -> __toString();
				} elseif (isset($i -> ImageSets)) {
					$imageSetList = $i -> ImageSets -> ImageSet;
					$picture = $imageSetList[0] -> MediumImage -> URL -> __toString();
				} else {
					// display no image available
					$picture = "images/amazon-noimage.jpg";
				}

				$data = array();
				if ( !isset($i -> OfferSummary -> TotalNew) || (intval($i -> OfferSummary -> TotalNew -> __toString()) == 0) ) {
					continue;
				} else {
					// get listing price
					$listPrice = $i -> OfferSummary -> LowestNewPrice -> FormattedPrice -> __toString();
					if (isset($i -> ItemAttributes -> ListPrice) && ($i -> ItemAttributes -> ListPrice -> FormattedPrice -> __toString() != '0') ) {
						$listPrice = $i -> ItemAttributes -> ListPrice -> FormattedPrice -> __toString();
					}

					// get price
					$price = $i -> OfferSummary -> LowestNewPrice -> FormattedPrice -> __toString();
					if (isset($i -> Offers -> Offer -> OfferListing -> SalePrice)) {
						$price = $i -> Offers -> Offer -> OfferListing -> SalePrice -> FormattedPrice -> __toString();
					}

					$data = array(
						'picture' => $picture,
						'url' => $i -> DetailPageURL -> __toString(),
						'title' => $i -> ItemAttributes -> Title -> __toString(),
						'price' => ltrim($price, "$"),
						'listprice' => ltrim($listPrice, "$"),
						'percentagesaved' => 0,
						'currencyId' => $i -> OfferSummary -> LowestNewPrice -> CurrencyCode -> __toString(),
						'shippingCost' => 'N/A'
					);

					if (isset($i -> Offers -> Offer -> OfferListing -> PercentageSaved)) {
						$data['percentagesaved'] = ltrim($i -> Offers -> Offer -> OfferListing -> PercentageSaved -> __toString(), "$");
					}
				}
				$data['feedback'] = $i -> CustomerReviews -> IFrameURL -> __toString();
				$data['id'] = $i -> ASIN -> __toString();
				$data['store'] = 'amazon';
				array_push($output, $data);
			}
		} catch(Exception $e) {
			print_r($e -> getMessage());
		}
		return $output;
	}

	private static function generateRequestURL($params) {
		// Sort the parameters by key
		ksort($params);
		$pairs = array();

		foreach ($params as $key => $value) {
			array_push($pairs, rawurlencode($key) . "=" . rawurlencode($value));
		}

		// Generate the canonical query
		$canonical_query_string = join("&", $pairs);

		// Generate the string to be signed
		$string_to_sign = "GET\n" . self::$endpoint . "\n" . self::$uri . "\n" . $canonical_query_string;

		// Generate the signature required by the Product Advertising API
		$signature = base64_encode(hash_hmac("sha256", $string_to_sign, self::$_secretKey, true));

		// Generate the signed URL
		$request_url = 'http://' . self::$endpoint . self::$uri . '?' . $canonical_query_string . '&Signature='.rawurlencode($signature);

		return $request_url;
	}
}

?>
