<?php
class Loading {
	public $fx;
	public $fy;
	public $fz;
	public $mx;
	public $my;
	public $mz;

	public function __construct($fx = 0, $fy = 0, $fz = null, $mx = 0, $my = null, $mz = 0) {
		$this -> fx = $fx;
		$this -> fy = $fy;
		$this -> fz = $fz;
		$this -> mx = $mx;
		$this -> my = $my;
		$this -> mz = $mz;
	}
}
?>
