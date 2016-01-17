<?php

require_once "array_operation_functions.php";

class FEA {






// assemble global K matrix

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


}




// to assemble the global $F matrix

	$F = array_fill(0, $ndof, 0);					// F=zeros(ndof,1);





// to perform FEA analysis


	echo "\nK = \n\n";
	showArray($K, count($K), count($K[0]));

	echo "\nF = \n\n";
	showArray($F, count($F));

	$xv = array(0, $ndof-2);							//xv=[1 ndof-1];
	$K = removeRow($K, $xv);							//K(xv,:)=[];
	$K = removeCol($K, $xv);							//K(:,xv)=[];
	$F = removeRow($F, $xv);							//F(xv)=[];% apply the homogeneous GBCs

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