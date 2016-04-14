<?php
require 'lib/EbayRequestor.class.php';
require 'lib/GoogleRequestor.class.php';

$keyword = "star wars";

$requestor = new GoogleRequestor($keyword);
print var_dump($requestor -> getYouTubeVideos());

// $requestor = new EbayRequestor($keyword);
// $requestor -> runRequest();
// print var_dump($requestor -> extractNecessaryData());

?>