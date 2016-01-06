<?php
require 'lib/EbayRequestor.class.php';

$keyword = "star wars";

$requestor = new EbayRequestor($keyword);
$requestor -> runRequest();
print var_dump($requestor -> extractNecessaryData());

?>