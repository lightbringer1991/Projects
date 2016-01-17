<?php
require_once "Node.class.php";
require_once "Connect.class.php";

class Mesh {
	private $rawData;
	public $nodes;
	public $connections;
	public $el_max;			// element max length

	// data is retrieved from Database::getData() function
	public function __construct($data, $el_max) {
		$this -> rawData = $data;
		$this -> nodes = array();
		$this -> connections = array();
		$this -> el_max = $el_max;
	}

	// public function run() {
		// generate hard nodes

		// generate loadings
		
	// }

	// functions getHardNodes_xxx() should always be run in order
	// get hard nodes from geomery data
	// this function assumes that the provided data is well-formed
	// i.e. end of a geometry is the beginning of another geometry
	// assuming data is for  1D beam
	private function getHardNodes_geometry() {
		foreach ($this -> rawData['geometry'] as $geoData) {
			$startNode = new Node(doubleval($geoData['start']), 0, 0);
			$endNode = new Node(doubleval($geoData['end']), 0, 0);
			$this -> addNode($startNode);
			$this -> addNode($endNode);
		}
		$this -> nodes = Node::quickSort($this -> nodes);
	}

	// get hard nodes from support data
	private function getHardNodes_support() {
		foreach ($this -> rawData['support'] as $sptData) {
			$newNode = new Node(doubleval($sptData['location']), 0, 0);
			$this -> addNode($newNode);
		}
		$this -> nodes = Node::quickSort($this -> nodes);
	}

	// get hard nodes from loading data
	// geometry == Distributed => collect startLocation and endLocation, plus zeroLocation if startValue and endValue have different signs
	// geometry == Point => collect startLocation only
	private function getHardNodes_loading() {
		foreach ($this -> rawData['loading'] as $loadingData) {
			if ($loadingData['geometry'] == 'Distributed') {
				$startNode = new Node(doubleval($loadingData['startLocation']), 0, 0);
				$startNode -> value = doubleval($loadingData['startValue']);
				$endNode = new Node(doubleval($loadingData['endLocation']), 0, 0);
				$endNode -> value = doubleval($loadingData['endValue']);
				$this -> addNode($startNode);
				$this -> addNode($endNode);

				// generate new node if startValue and endValue has different sign
				// this method may cause overflow if startValue and endValue are too big (over 10^5 maybe)
				// can change it to a longer version with overflow safe later
				if ($loadingData['startValue'] * $loadingData['endValue'] < 0) {
					$zeroNode = $this -> calculateZeroPosition($loadingData);
					$zeroNode -> value = 0;
					$this -> addNode($zeroNode);
				}
			} elseif ($loadingData['geometry'] == 'Point') {
				$newNode = new Node(doubleval($loadingData['startLocation']), 0, 0);
				$newNode -> value = doubleval($loadingData['startValue']);
				$this -> addNode($newNode);
			}
		}
		$this -> nodes = Node::quickSort($this -> nodes);
	}

	// generate extra nodes to fit $el_max data
	// this function assumes that node array are sorted in ascending order
	private function generateNodes() {
		$newNodeList = array();
		for ($i = 0; $i < count($this -> nodes) - 1; $i++) {
			$length = $this -> nodes[$i] -> distance($this -> nodes[$i + 1]);
			if ($length > $this -> el_max) {
				// generate new nodes
				$distance = $length / ceil($length / $this -> el_max);			// new distance between nodes
				$element = new Element(clone($this -> nodes[$i]), clone($this -> nodes[$i]), 0, 0);
				do {
					$element -> increaseLength($distance);
					array_push($newNodeList, clone($element -> endNode));					
				}
				while ($element -> endNode -> compare($this -> nodes[$i + 1]) == -1);
			}
		}
		foreach ($newNodeList as $n) {
			$this -> addNode($n);
		}
		$this -> nodes = Node::quickSort($this -> nodes);
	}

	// only invoke this function AFTER all nodes are generated
	private function generateConnections() {
		for ($i = 0; $i < count($this -> nodes) - 1; $i++) {
			// initiate values
			$startNode = $this -> nodes[$i];
			$endNode = $this -> nodes[$i + 1];
			$pk4ba_mat = 0;
			$pk4ba_g = 0;

			foreach ($this -> rawData['geometry'] as $geoData) {
				$sNode = new Node($geoData['start'], 0, 0);
				$eNode = new Node($geoData['end'], 0, 0);
				if ( ($startNode -> compare($sNode) >= 0) && ($endNode -> compare($eNode) <= 0) ) {
					$pk4ba_mat = $geoData['matID'];
					$pk4ba_g = $geoData['rcdNo'];
					break;
				}
			}

			$e = new Connect($startNode, $endNode, $pk4ba_mat, $pk4ba_g);
			$startNode -> elementStart = $e;
			$endNode -> elementEnd = $e;
		}
	}

	// ignore new node if it's already in the list
	// otherwise add it in
	private function addNode($newNode) {
		// prevent duplication
		foreach ($this -> nodes as $n) {
			if ($n -> compare($newNode) == 0) { return; }
		}
		array_push($this -> nodes, $newNode);
	}

	// $data: a row from loading table
	private function calculateZeroPosition($data) {
		$loadingRatio = abs($data['startValue'] / $data['endValue']);	//2.4
		$loadingLength = $data['endLocation'] - $data['startLocation'];
		$zeroPoint = $data['startLocation'] + ($loadingLength * $loadingRatio) / (1 + $loadingRatio);
		return new Node($zeroPoint, 0, 0);
	}

	// obtain the list of nodes between 2 given nodes, sorted in order
	private function getAllNodesBetweenNodes($n1, $n2) {
		$output = array();
		foreach ($this -> nodes as $n) {
			if ( ($n1 -> compare($n) <= 0) && ($n2 -> compare($n) >= 0) ) { array_push($output, $n); }
		}
		return Node::quickSort($output);
	}



	private function sumArray($arr, $start, $end) {
		$total = 0;
		for ($i = $start; $i <= $end; $i++) {
			$total += $arr[$i];
		}
		return $total;
	}


		$this -> getHardNodes_geometry();
		$this -> getHardNodes_support();
		$this -> getHardNodes_loading();
		$this -> generateNodes();
		
		// generate elements
		$this -> generateConnections();	




}
?>