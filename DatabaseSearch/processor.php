<?php
require_once "data.php";

// append 0 if 1 <= $n <= 9
function formatNumber($n) {
	if (($n >= 1) && ($n <= 9)) {
		$n = "A" . $n;
	}
	return $n;
}

// return array('status', 'value')
// status can be true or false
// if status == true, value is the merchant_sso
// if status == false, value is the index where data is found
function interrogateFirstData($data, $unit, $asslist) {
	foreach ($unit as $k => $v) {
		if ($v == $data) {
			if ($asslist[$k][0] == '1') {
				return array(true, formatNumber($asslist[$k][1]));
			} else {
				return array(false, $k);
			}
		}
	}
}

// return merchant SSO
// $cname: array from data.php
// $focused_asslist: $asslist[$i] where $unit[$i] = first_input
function interrogateSecondData($second_input, $cname, $focused_asslist) {
	$inputLength = strlen($second_input);
	// check for each $asslist[$i], $i >= 1
	for ($i = 1; $i < count($focused_asslist); $i++) {
		if (strpos($cname[$focused_asslist[$i]], $second_input) === 0) {
			return $focused_asslist[$i];
		}
	}
	return null;
}

function callEzPayAPI($acc_sso, $merchant_sso) {
	$usr_sso = 'testapi';
	$psw_sso = 'testapi2016';

	$parameters = array(
		'usr_sso' => $usr_sso,
		'psw_sso' => $psw_sso,
		'merchant_sso' => $merchant_sso,
		'acc_sso' => $acc_sso
	);
	$url="https://sandbox.ezpay.com/integration/sso.php";

	// curl initialization
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_POST, 1);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $parameters);
	curl_setopt($ch, CURLOPT_TIMEOUT, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	$result = curl_exec($ch);
	curl_close($ch);

	// process data
	if ($result == "") {
		echo "Not Found";
	} elseif (substr($result, 0, 3) == 'ZX1') {
		echo "connection error";
	} else {
		//$result has a token to complete the SSO
		//doing it by redirection
		header('location:https://sandbox.ezpay.com/integration/sso.php?SsoCode=' . $result);
	}
}

// first input is entered
switch ($_GET['step']) {
	case '1':
		$value = interrogateFirstData($_POST['first_data'], $unit, $asslist);
		if ($value[0] == true) {
			$merchant_sso = $value[1];
			$acc_sso = $merchant_sso . $_POST['first_data'];
			echo "Merchant SOO: $merchant_sso <br />";
			echo "Acc SSO: $acc_sso<br />";
			callEzPayAPI($acc_sso, $merchant_sso);
		} else {
			echo "	<script type='text/javascript'>
						window.location.href = 'index.php?step=2&d1={$value[1]}';
					</script>";
		}
		break;
	case '2':
		$merchant_sso = interrogateSecondData($_POST['second_data'], $cname, $asslist[$_POST['index_1']]);
		$acc_sso = $merchant_sso . $unit[$_POST['index_1']];
		if ($merchant_sso == null) { echo "Result: Data Not Found <br />"; }
		else {
			echo "Merchant SOO: $merchant_sso <br />";
			echo "Acc SSO: $acc_sso<br />";
			callEzPayAPI($acc_sso, $merchant_sso);
		}
		
		break;
	case 'captcha':
		// check captcha
		session_start();
		if($_POST['captcha'] != $_SESSION['digit']) {
			// wrong captcha
			echo 0;
		} else {
			echo 1;
		};
		break;
}

?>