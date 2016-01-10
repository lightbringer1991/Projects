<?php
require 'lib/EbayRequestor.class.php';
require 'lib/AmazonRequestor.class.php';

function generateTable($data, $logoURL) {
	$output = '';
	foreach ($data as $k => $v) {
		$output .= "<tr id='$k'>
						<td><img src='$logoURL' class='img-rounded'></td>
						<td><img src='{$v['picture']}' class='img-rounded'></td>
						<td>{$v['title']}</td>
						<td>{$v['price']}</td>
						<td>{$v['feedback']}</td>
						<td>{$v['shippingCost']}</td>
						<td><a target='_blank' href='{$v['url']}'>URL</a></td>
					</tr>";
	}
	return $output;
}

// // -------- main script
$keyword = $_POST['keyword'];
$site = $_POST['site'];

switch ($_POST['site']) {
	case 'ebay':
		// get eBay data
		error_log(date('d/m/Y H:i:s') . " - Ebay API start\r\n", 3, 'error_log.txt');
		$requestor = new EbayRequestor($keyword);
		$requestor -> runRequest();
		$ebayData = $requestor -> extractNecessaryData();
		echo generateTable($ebayData, 'images/ebay.jpg');

		break;
	case 'amazon':
		// get Amazon data
		error_log(date('d/m/Y H:i:s') . " - Amazon API start\r\n", 3, 'error_log.txt');
		$requestor = new AmazonRequestor($keyword);
		$requestor -> runRequest();
		$amazonData = $requestor -> extractNecessaryData();
		echo generateTable($amazonData, 'images/amazon.png');

		break;
	case 'start':
		echo "<table class='table table-striped'>
				<thead>
					<tr>
						<th>From</th>
						<th>Picture</th>
						<th>Title</th>
						<th>Price</th>
						<th>Feedback</th>
						<th>Shipping Cost</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>";
		break;
	case 'end':
		echo "	</tbody>
			</table>";
		break;
}
?>