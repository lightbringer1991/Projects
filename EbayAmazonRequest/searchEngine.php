<?php
require_once 'lib/EbayRequestor.class.php';
require_once 'lib/AmazonRequestor.class.php';
require_once "lib/GoogleRequestor.class.php";

function generateTable($data, $store) {
	$output = '';
	foreach ($data as $k => $v) {
		$discountInfo = ($v['listprice'] == $v['price']) ? "" : "(was {$v['listprice']})";
		// add discount percentage
		if ( $v['percentagesaved'] != 0 ) {
			$discountInfo .= "(save {$v['percentagesaved']}%)";
		}

		$output .= "<tr id='$k'>
						<td class='col-sm-2 col-md-2 col-lg-2'><img src='{$v['logo']}' class='img-rounded'></td>
						<td class='col-sm-2 col-md-2 col-lg-2'><img src='{$v['picture']}' class='product-image img-rounded col-sm-10 col-md-10 col-lg-10'></td>
						<td class='col-sm-2 col-md-2 col-lg-2'>
							{$v['title']}
							<br /><a data-store='$store' data-role='moreDetails' target='_blank' href='#'>More Details &gt;&gt;</a>
						</td>
						<td class='col-sm-2 col-md-2 col-lg-2'>{$v['price']}$discountInfo</td>
						<td class='col-sm-2 col-md-2 col-lg-2'>{$v['feedback']}</td>
						<td class='col-sm-2 col-md-2 col-lg-2'>{$v['shippingCost']}</td>
						<td class='col-sm-2 col-md-2 col-lg-2'><a target='_blank' href='{$v['url']}'>URL</a></td>
					</tr>";
	}
	return $output;
}

// -------- main script
$keyword = $_POST['keyword'];
$site = $_POST['site'];

switch ($_POST['site']) {
	case 'ebay':
		// get eBay data
		error_log(date('d/m/Y H:i:s') . " - Ebay API start\r\n", 3, 'error_log.txt');
		$requestor = new EbayRequestor($keyword);
		$requestor -> runRequest();
		$ebayData = $requestor -> extractNecessaryData();
		echo generateTable($ebayData, 'ebay');

		break;
	case 'amazon':
		// get Amazon data
		error_log(date('d/m/Y H:i:s') . " - Amazon API start\r\n", 3, 'error_log.txt');
		$requestor = new AmazonRequestor($keyword);
		$requestor -> runRequest();
		$amazonData = $requestor -> extractNecessaryData();
		echo generateTable($amazonData, 'amazon');

		break;
	case 'start':
		echo "<table class='table table-striped table-bordered'>
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
	case 'details':
		$store = $_POST['store'];
		$id = $_POST['id'];
		if ($store == 'ebay') {
			echo EbayRequestor::getItemDetailsURL($_POST['id']);
		} elseif ($store == 'amazon') {
			echo AmazonRequestor::getItemDetailsURL($_POST['id']);
		}
		break;
	case 'suggestion':
		$re = new GoogleRequestor($_POST['keyword']);
		echo json_encode($re -> generateSuggestions());
		break;
}
?>