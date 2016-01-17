<?php
	header('Content-type: text/plain');
	include "PolynomialTerm.class.php";
	include "PolynomialEquation.class.php";
	include "array_operation_functions.php";

	$ne = 5; 							// number of elements
	$L = 1; 							// beam length
	$js = 1;							// K from (1: js, 0: Polynomial calculation)

	$e = $L / $ne; 						// elemental length
	$ndof = ($ne + 1) * 2;
	$N = array(
	    new \Polynomial\Equation(array( 2/pow($e, 3), -3/pow($e, 2), 0, 1)),
	    new \Polynomial\Equation(array( 1/pow($e, 2), -2/$e 	   , 1, 0)),
	    new \Polynomial\Equation(array(-2/pow($e, 3),  3/pow($e, 2), 0, 0)),
	    new \Polynomial\Equation(array( 1/pow($e, 2), -1/$e        , 0, 0)),
	);
	$F = array_fill(0, $ndof, 0);					// F=zeros(ndof,1);
	$fe = array_fill(0, count($N), 0);				

	for ($i = 1; $i <= $ne; $i++) 
	{ 
		$t = $e * ($i - 1);
		//fe=eval(int(4*(x+e*(i-1))^3*N,0,e));
		$eq = new \Polynomial\Equation(array(4, 12*$t, 12*$t*$t, 4*$t*$t*$t));
		for ($x = 0; $x < count($N); $x++) 
		{
			$equation = $N[$x];
			$equation = $equation->multiplyBy($eq);
			$equation = $equation->getIntegral();
			$fe[$x] = $equation->evaluateFor($e) - $equation->evaluateFor(0);
		}
		// i1=(i-1)*2+1; i2=i1+3;
		// F(i1:i2)=F(i1:i2)+fe; % assemble the global force vector
		$i1 = ($i - 1) * 2;
		$i2 = $i1 + count($N) - 1;
		for ($x = $i1; $x <= $i2; $x++) 
		{
			$F[$x] += $fe[$x-$i1];
		}
	} 	


	if ($js)
	{
		include "php_example_jsoption.php";
	}
	else
	{
		for($i = 0; $i < count($N); $i++)
		{
			$N2[$i] = $N[$i]->getDerivative(2);
		}
		$K = createArray($ndof, $ndof);					// K=zeros(ndof,ndof); 
		$ke = createArray(count($N2), count($N2));

		for ($i = 1; $i <= $ne; $i++) 
		{
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

			// i1=(i-1)*2+1; i2=i1+3;
			// K(i1:i2,i1:i2)=K(i1:i2,i1:i2)+ke; % assemble the global stiffness matrix
			// F(i1:i2)=F(i1:i2)+fe; % assemble the global force vector
			$i1 = ($i - 1) * 2;
			$i2 = $i1 + count($N) - 1;
			for ($x = $i1; $x <= $i2; $x++) 
			{
				for ($y = $i1; $y <= $i2; $y++) 
				{
					$K[$x][$y] += $ke[$x-$i1][$y-$i1];
				}
			}
		}
	}
	
	echo "\nK = \n\n";
	showArray($K, count($K), count($K[0]));

	echo "\nF = \n\n";
	showArray($F, count($F));

	$xv = array(0, $ndof-2);							//xv=[1 ndof-1];
	$K = removeRow($K, $xv);							//K(xv,:)=[];
	$K = removeCol($K, $xv);							//K(:,xv)=[];
	$F = removeRow($F, $xv);							//F(xv)=[];% apply the homogeneous GBCs

	echo "\nF 2 = \n\n";
	showArray($F, count($F));
	
	$w0 = LUPsolve($K, $F);								//w0=K\F; % nodal displacements 

	$w1 = array_fill(0, $ndof, 0);						//w1=zeros(ndof,1);

	$xv1 = array_fill(0, $ndof, 0);						//xv1=[1:ndof];
	for ($i = 0; $i < $ndof; $i++)
		$xv1[$i] = $i;
	$xv1 = removeRow($xv1, $xv);						//xv1(xv)=[];

	$w1 = replaceVec($w1, $xv1, $w0); 					//w1(xv1)=w0; % add the GBCs back
	
	echo "\nw1 = \n\n";
	showArray($w1, $ndof);

	// %(4) exact solution
	// xi=[0:L/99:L]';
	// w4=0.01*xi.^5-(1/30)*xi.^3+(7/300)*xi;
	$c = 99;
	for ($i = 0; $i <= $c; $i++) 
	{
		$xi = $i * $L / $c;
		$w4[$i] = 0.01*pow($xi,5)-(1/30)*pow($xi,3)+(7/300)*$xi;
	}
	echo "\nw4 = \n\n";
	showArray($w4, $c+1);

?>
