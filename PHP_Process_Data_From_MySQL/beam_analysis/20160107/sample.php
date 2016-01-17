<?php

header('Content-type: text/plain');

// include "../20160106/PolynomialTerm.class.php";
include "PolynomialTerm.class.php";
include "PolynomialEquation.class.php";


$equation1 = new \Polynomial\Equation(array(-24, 6, -1.2));
$equation2 = $equation1->getIntegral(1);
$equation3 = $equation2->getDerivative(1);

echo "f(x)   = ".$equation1."\n";
echo "SSf(x) = ".$equation2."\n";
echo "f''(x) = ".$equation3."\n";
echo "SSf(2) = ".$equation2->evaluateFor(2) . "\n";
echo "f''(2) = ".$equation3->evaluateFor(2) . "\n";