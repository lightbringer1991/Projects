<?php

 //require_once "Loading.class.php";

	require_once "PolynomialTerm.class.php";
	require_once "PolynomialEquation.class.php";

class Beam {


	$N = array(
	    new \Polynomial\Equation(array( 2/pow($el, 3), -3/pow($el, 2), 0, 1)),
	    new \Polynomial\Equation(array( 1/pow($el, 2), -2/$el 	   , 1, 0)),
	    new \Polynomial\Equation(array(-2/pow($el, 3),  3/pow($el, 2), 0, 0)),
	    new \Polynomial\Equation(array( 1/pow($el, 2), -1/$el        , 0, 0)),
	);

			$t = $e * ($i - 1);
	 		//ke=eval(int(N2 * (1+(x+e*(i-1))^2) * transpose(N2), 0, e));
			$eq = new \Polynomial\Equation(array(1, 2*$t, $t*$t+1));
			for ($x = 0; $x < count($N2); $x++) 
			{
				for ($y = 0; $y < count($N2); $y++) 
				{
					$equation = $N2[$x];
					$equation = $equation->multiplyBy($eq);
					$equation = $equation->multiplyBy($N2[$y]);
					$equation = $equation->getIntegral();
					$ke[$x][$y] = $equation->evaluateFor($e) - $equation->evaluateFor(0);
				}
			}






	$E = 1;
	$I = 1;
	$EI = $E * $I;
	//$le = 1; // each element's length
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




}

?>