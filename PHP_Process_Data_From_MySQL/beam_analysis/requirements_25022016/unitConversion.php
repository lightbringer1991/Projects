<?php

function UnitConversion($variable,$unit2be){
	$crtunit = $variable['unit'];
	$valuemultiple = 1;
	switch($unit2be){
		case 'in.':
		case 'inch':
		switch($crtunit){
			case 'in.':
			case 'inch': break;
			case 'ft': $valuemultiple = 12; break;
			default:
			break;
		};
		break;			
		case 'ft':
		switch($crtunit){
			case 'in.':		
			case 'inch': $valuemultiple = 1/12; break;
			case 'ft': break;
			default:
			break;
		};
		break;			
		case 'psi':
		switch($crtunit){
			case 'psi': break;
			case 'ksi': $valuemultiple = 1000; break;
			default:
			break;
		};
		break;
		case 'ksi':
		switch($crtunit){
			case 'psi': $valuemultiple = 1/1000; break;
			case 'ksi': break;
			default:
			break;
		};	
		break;
		default:
		break;
	};
	$variable['unit'] = $unit2be;
	$variable['value'] = $variable['value'] * $valuemultiple;
	return $variable;

}
?>