<?php
class EbayRequestor {
	private static $serviceAPIURL = 'http://svcs.ebay.com/services/search/FindingService/v1';
	private static $shoppingAPIURL = 'http://open.api.ebay.com/shopping';
	private $keyword;
	private $data;
	private static $appID = 'Solecomp-c20b-4fa6-a1da-0ddfc9cbd519';

	public function __construct($keyword) {
		$this -> keyword = $keyword;
	}

	// run keyword search through Ebay API
	public function runRequest() {
		$xmlRequest = "<?xml version='1.0' encoding='utf-8'?>
						<findItemsAdvancedRequest xmlns='http://www.ebay.com/marketplace/search/v1/services'>
							<keywords>" . $this -> escapeStringToXMLformat($this -> keyword) . "</keywords>
							<paginationInput>
								<entriesPerPage>10</entriesPerPage>
								<pageNumber>1</pageNumber>
							</paginationInput>
							<itemFilter>
								<name>Condition</name>
								<value>1000</value>
							</itemFilter>
							<affiliate>
								<networkId>9</networkId>
								<trackingId>5337802388</trackingId>
							</affiliate>
							<sortOrder>BestMatch</sortOrder>
							<outputSelector>SellerInfo</outputSelector>
						</findItemsAdvancedRequest>";
		$header = array(
			'X-EBAY-SOA-OPERATION-NAME: findItemsByKeywords',
			'X-EBAY-SOA-SERVICE-VERSION: 1.3.0',
			'X-EBAY-SOA-REQUEST-DATA-FORMAT: XML',
			'X-EBAY-SOA-GLOBAL-ID: EBAY-US',
			'X-EBAY-SOA-SECURITY-APPNAME: ' . self::$appID,
			'Content-Type: text/xml;charset=utf-8'
		);
		$this -> data = self::executeCurl(self::$serviceAPIURL, $header, $xmlRequest);
		error_log(gmdate('d/m/Y H:i:s') . " - Ebay data retrieved\r\n", 3, 'error_log.txt');
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
			foreach ($simpleXML -> searchResult -> item as $i) {
				// get list price
				$listPrice = $i -> sellingStatus -> currentPrice -> __toString();
				if (isset($i -> discountPriceInfo)) {
					$listPrice = $i -> discountPriceInfo -> originalRetailPrice -> __toString();
				}



				$priceAttributes = $i -> sellingStatus -> currentPrice -> attributes();
				$data = array(
					'picture' => $i -> galleryURL -> __toString(),
					'url' => $i -> viewItemURL -> __toString(),
					'title' => $i -> title -> __toString(),
					'price' => $i -> sellingStatus -> currentPrice -> __toString(),
					'listprice' => $listPrice,
					'currencyId' => $priceAttributes['currencyId'] -> __toString(),
					'feedback' => $i -> sellerInfo -> positiveFeedbackPercent -> __toString(),
					'shippingCost' => $i -> shippingInfo -> shippingServiceCost -> __toString()
				);
				if ($data['picture'] == '') { $data['picture'] = 'images/ebay-noimage.gif'; }

				// calculate percentage saved
				$data['percentagesaved'] = number_format(($data['listprice'] - $data['price']) / $data['listprice'] * 100, 2);

				$output[$i -> itemId -> __toString()] = $data;
			}
			
		} catch(Exception $e) {
			print_r($e -> getMessage());
		}
		return $output;
	}

	public static function getShippingCost($itemID) {
		$xmlRequest = "<?xml version='1.0' encoding='utf-8'?>
		<GetShippingCostsRequest xmlns='urn:ebay:apis:eBLBaseComponents'>
			<DestinationCountryCode>AU</DestinationCountryCode>
			<DestinationPostalCode>3350</DestinationPostalCode>
			<IncludeDetails>1</IncludeDetails>
			<ItemID>$itemID</ItemID>
		</GetShippingCostsRequest>";
		$header = array(
			'X-EBAY-API-CALL-NAME: GetShippingCosts',
			'X-EBAY-API-APP-ID: ' . self::$appID,
			'X-EBAY-API-VERSION: 949',
			'X-EBAY-API-REQUEST-ENCODING: XML',
			'X-EBAY-API-RESPONSE-ENCODING: XML',
			'Content-Type: text/xml;charset=utf-8'
		);
		return self::executeCurl(self::$shoppingAPIURL, $header, $xmlRequest);

	}

	// return curl output
	public static function executeCurl($url, $header, $xmlRequest) {
		$curlHandle = curl_init($url);
		curl_setopt_array($curlHandle, array(
			CURLOPT_POST => true,
			CURLOPT_HTTPHEADER => $header,
			CURLOPT_POSTFIELDS => $xmlRequest,
			CURLOPT_RETURNTRANSFER => true
		));
		$data = curl_exec($curlHandle);
		curl_close($curlHandle);
		return $data;
	}

	// escape special character to fit xml format
	private function escapeStringToXMLformat($str) {
		$str = str_replace('"', "&quot;", $str);
		$str = str_replace("'", "&apos;", $str);
		$str = str_replace('<', "&lt;", $str);
		$str = str_replace('>', "&gt;", $str);
		$str = str_replace('&', "&amp;", $str);
		return $str;
	}
}
?>