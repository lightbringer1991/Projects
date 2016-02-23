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
		if (isset($cname[$focused_asslist[$i]]) && strpos($cname[$focused_asslist[$i]], $second_input) === 0) {
			return formatNumber($focused_asslist[$i]);
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
	// $url="https://sandbox.ezpay.com/integration/sso.php";
	$url="https://sandbox.revopay.com/integration/sso.php";

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
		return array("error", "API call: Not Found");
	} elseif (substr($result, 0, 3) == 'ZX1') {
		return array("error", "API call: connection error");
	} else {
		//$result has a token to complete the SSO
		//doing it by redirection
		return array("success", $result);
	}
}

// first input is entered
switch ($_GET['step']) {
	case '1':
		// nothing to do, step 1 is only captcha validation
		break;
	case '2':
		$value = interrogateFirstData($_POST['first_data'], $unit, $asslist);
		if ($value[0] == true) {
			$merchant_sso = $value[1];
			$acc_sso = $merchant_sso . $_POST['first_data'];

			// demo only
			$acc_sso = "T0032";
			$merchant_sso = "TEST0004";
			$result = array(
				'merchant_sso' => $merchant_sso,
				'acc_sso' => $acc_sso,
				'result' => callEzPayAPI($acc_sso, $merchant_sso)
			);
			echo json_encode($result);
		} else {
			$result = array(
				'redirect' => "index.php?step=3&d1={$_POST['first_data']}"
			);
			echo json_encode($result);
		}
		break;
	case '3':
		// first data interrogation output is always [false, $index]
		$value = interrogateFirstData($_POST['first_data'], $unit, $asslist);
		$merchant_sso = interrogateSecondData($_POST['second_data'], $cname, $asslist[$value[1]]);
		$acc_sso = $merchant_sso . $_POST['first_data'];
		$result = array(
			'merchant_sso' => "",
			'acc_sso' => "",
			'result' => ""
		);

		// demo only
		$acc_sso = "T0032";
		$merchant_sso = "TEST0004";

		if ($merchant_sso == null) { 
			$result['merchant_sso'] = "Data Not Found";
			$result['acc_sso'] = 'Data Not Found';
			$result['result'] = array('error', 'API call: Not Found');
		} else {
			$result['merchant_sso'] = $merchant_sso;
			$result['acc_sso'] = $acc_sso;
			$result['result'] = callEzPayAPI($acc_sso, $merchant_sso);
		}
		echo json_encode($result);
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