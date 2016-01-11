<?php

function get_k_e($etype, $E, $I, $le){


	switch ($etype) {

		case 'Euler-Bernoulli':

		$v1 = $E*$I * 12 / pow($le, 3);
		$v2 = $E*$I * 6 / pow($le, 2);
		$v3 = $E*$I * 4 / $le;
		$v4 = pow($E*$I, 2) / $le;

		$k_e = array(
			array($v1, $v2, -$v1, $v2),
			array($v2, $v3, -$v2, $v4),
			array(-$v1, -$v2, $v1, -$v2),
			array($v2, $v4, -$v2, $v3),
			);

		case 'Timoshenko':
		break;

		default:
		break;

	}

	return $k_e;

}

?>
