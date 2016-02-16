<?php
require_once "data.php";

// return array('status', 'value')
// status can be true or false
// if status == true, value is the needed value
// if status == false, value is the index where data is found
function interrogateFirstData($data, $unit, $asslist) {
	foreach ($unit as $k => $v) {
		if ($v == $data) {
			if ($asslist[$k][0] == 1) {
				return array(true, $asslist[$k][1]);
			} else {
				return array(false, $k);
			}
		}
	}
}

// return expected value
function interrogateSecondData($second_input, $cname) {
	$inputLength = strlen($second_input);
	foreach ($cname as $k => $v) {
		if (strpos($v, $second_input) === 0) {
			return $k;
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
			echo "Result: " . $value[1] . "<br />";
			callEzPayAPI($_POST['first_data'], $value[1]);
		} else {
			echo "	<script type='text/javascript'>
						window.location.href = 'index.php?step=2&d1={$value[1]}';
					</script>";		
		}
		break;
	case '2':
		$value = interrogateSecondData($_POST['second_data'], $cname);
		if ($value == null) { echo "Result: Not Found <br />"; }
		else {
			echo "Result: " . $value;
			callEzPayAPI($unit[$_POST['index_1']], $value);
		}
		
		break;
	case 'captcha':
		// check captcha
		// session_start();
		if($_POST['captcha'] != $_SESSION['digit']) {
			// wrong captcha
			echo 0;
		} else {
			echo 1;
		};
		break;
}
?>