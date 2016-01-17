<?php
	$E = 1;
	$I = 1;
	$EI = $E * $I;
	$le = 1;
	$v1 = $EI * 12 / pow($le, 3);
	$v2 = $EI * 6 / pow($le, 2);
	$v3 = $EI * 4 / $le;
	$v4 = pow($EI, 2) / $le;

	$k_e = array(
		array($v1, $v2, -$v1, $v2),
		array($v2, $v3, -$v2, $v4),
		array(-$v1, -$v2, $v1, -$v2),
		array($v2, $v4, -$v2, $v3),
		);

//	alert(k_e); 
//	$elist = array(1, 2);

	$ndof = ($ne + 1)*2;

	$K = array();
	for ($i = 0; $i < $ndof; $i++)
	{
		$K[$i] = array_fill(0, $ndof, 0);
	}

	for ($ie = 0; $ie < $ne; $ie++) {
		for ($irow = 0; $irow < 4; $irow++) {
			$irow_g = $ie * 2 + $irow;
			for ($icol = 0; $icol < 4; $icol++) {
				$icol_g = $ie * 2 + $icol;
//				alert("ie: " + ie + ", irow: " + irow + ", icol: " + icol + ", irow_g: " + irow_g + ", icol_g: " + icol_g);
				$K[$irow_g][$icol_g] = $K[$irow_g][$icol_g] + $k_e[$irow][$icol];
			}
		}
	}
?>