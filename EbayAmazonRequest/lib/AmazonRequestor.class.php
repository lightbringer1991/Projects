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
			"IncludeReviewsSummary" => 'True',
			// "MerchantId" => 'Amazon'
			// "MinPercentageOff" => 0
		);

		$requestURL = $this -> generateRequestURL($params);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$requestURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);

		$this -> data = curl_exec($ch);
		error_log(gmdate('d/m/Y H:i:s') . " - Amazon data retrieved\r\n", 3, 'error_log.txt');
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
				if (!isset($i -> Offers -> TotalOffers) || ($i -> Offers -> TotalOffers -> __toString() == '0')) {
					$data = array(
						'picture' => $picture,
						'url' => $i -> DetailPageURL -> __toString(),
						'title' => $i -> ItemAttributes -> Title -> __toString(),
						'price' => 0,
						'listprice' => 0,
						'percentagesaved' => 0,
						'currencyId' => 'N/A',
						'shippingCost' => 'N/A'						
					);
				} else {
					// get listing price
					$listPrice = $i -> Offers -> Offer -> OfferListing -> Price -> FormattedPrice -> __toString();
					if (isset($i -> ItemAttributes -> ListPrice) && ($i -> ItemAttributes -> ListPrice -> FormattedPrice -> __toString() != '0') ) {
						$listPrice = $i -> ItemAttributes -> ListPrice -> FormattedPrice -> __toString();
					}

					// get price
					$price = $i -> Offers -> Offer -> OfferListing -> Price -> FormattedPrice -> __toString();
					if (isset($i -> Offers -> Offer -> OfferListing -> SalePrice)) {
						$price = $i -> Offers -> Offer -> OfferListing -> SalePrice -> FormattedPrice -> __toString();
					}

					$data = array(
						'picture' => $picture,
						'url' => $i -> DetailPageURL -> __toString(),
						'title' => $i -> ItemAttributes -> Title -> __toString(),
						'price' => $price,
						'listprice' => $listPrice,
						'percentagesaved' => 0,
						'currencyId' => $i -> Offers -> Offer -> OfferListing -> Price -> CurrencyCode -> __toString(),
						'shippingCost' => 'N/A'
					);

					if (isset($i -> Offers -> Offer -> OfferListing -> PercentageSaved)) {
						$data['percentagesaved'] = $i -> Offers -> Offer -> OfferListing -> PercentageSaved -> __toString();
					}
				}
				$data['feedback'] = "<a data-role='url_amazonReviews' data-toggle='modal' data-target='#modal-amazonReviews' data-href='" . $i -> CustomerReviews -> IFrameURL -> __toString() . "'>Review</a>";
				$output[$i -> ASIN -> __toString()] = $data;
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
}

?>
