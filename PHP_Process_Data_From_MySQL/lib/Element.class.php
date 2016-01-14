<?php
class Element {
	public $startNode;
	public $endNode;
	public $PK4ba_mat;
	public $PK4ba_g;

	public function __construct($start, $end, $mat, $g) {
		$this -> startNode = $start;
		$this -> endNode = $end;
		$this -> PK4ba_mat = $mat;
		$this -> PK4ba_g = $g;
	}

	// applies only to 1D element
	public function increaseLength($length) {
		$this -> endNode -> x += $length;
	}

	public function getLength() {
		return $this -> endNode -> x - $this -> startNode -> x;
	}
}
?>