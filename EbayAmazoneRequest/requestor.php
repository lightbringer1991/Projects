<?php
$keyword = "star wars";

$url = 'http://svcs.ebay.com/services/search/FindingService/v1';
$xmlRequest = "<?xml version='1.0' encoding='utf-8'?>
				<findItemsByKeywordsRequest xmlns='http://www.ebay.com/marketplace/search/v1/services'>
					<keywords>$keyword</keywords>
					<paginationInput>
						<entriesPerPage>10</entriesPerPage>
						<pageNumber>1</pageNumber>
					</paginationInput>
				</findItemsByKeywordsRequest>";
$header = array(
	'X-EBAY-SOA-OPERATION-NAME: findItemsByKeywords',
	'X-EBAY-SOA-SERVICE-VERSION: 1.3.0',
	'X-EBAY-SOA-REQUEST-DATA-FORMAT: XML',
	'X-EBAY-SOA-GLOBAL-ID: EBAY-US',
	'X-EBAY-SOA-SECURITY-APPNAME: IBM64d73d-91f0-48db-8c89-6d948fc030f',
	'Content-Type: text/xml;charset=utf-8'
);

$curlHandle = curl_init($url);
curl_setopt_array($curlHandle, array(
	CURLOPT_POST => true,
	CURLOPT_HTTPHEADER => $header,
	CURLOPT_POSTFIELDS => $xmlRequest,
	CURLOPT_RETURNTRANSFER => true
));

$responseXML = curl_exec($curlHandle);
curl_close($curlHandle);
print $responseXML;
?>