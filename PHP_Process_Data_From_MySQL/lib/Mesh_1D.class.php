<?php
require_once "Node.class.php";
require_once "Connect.class.php";

class Mesh_1D {
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

	public function run() {
		// generate hard nodes
		$this -> getHardNodes_geometry();
		$this -> getHardNodes_support();
		$this -> getHardNodes_ilcs();
		// $this -> generateNodes();
		
		// // generate elements
		// $this -> generateElements();

		// // generate loadings
		// $this -> generateLoadings();

	}

	// functions getHardNodes_xxx() should always be run in order
	// get hard nodes from geometry data
	// this function assumes that the provided data is well-formed
	// i.e. end of a geometry is the beginning of another geometry
	// assuming data is for  1D beam
	private function getHardNodes_geometry() {
		foreach ($this -> rawData['geometry'] as $sectionObj) {
			$startNode = $sectionObj -> getStartNode();
			$endNode = $sectionObj -> getEndNode();
			$this -> addNode($startNode);
			$this -> addNode($endNode);
		}
		$this -> nodes = Node::quickSort($this -> nodes);
	}

	// get hard nodes from support data
	private function getHardNodes_support() {
		foreach ($this -> rawData['support'] as $supportObj) {
			$newNode = $supportObj -> getSupportNode();
			$this -> addNode($newNode);
		}
		$this -> nodes = Node::quickSort($this -> nodes);
	}

	// get hard nodes from loading data
	// geometry == Distributed => collect startLocation and endLocation, plus zeroLocation if startValue and endValue have different signs
	// geometry == Point => collect startLocation only
	private function getHardNodes_ilcs() {
		$nodeList = array();
		foreach ($this -> rawData['ilcs'] as $ilcsObj) {
			$nodeList = array_merge($nodeList, $ilcsObj -> getNodes());
		}
		$this -> nodes = array_merge($this -> nodes, $nodeList);
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
				$element = new Connect(clone($this -> nodes[$i]), clone($this -> nodes[$i]), 0, 0);
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
	private function generateElements() {
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
			array_push($this -> connections, $e);
		}
	}

	// only invoke this function AFTER all nodes are generated
	private function generateLoadings() {
		// get all predefined loading data
		foreach ($this -> nodes as $n) {
			foreach ($this -> rawData['loading'] as $loadingData) {
				if ( ($loadingData['geometry'] == 'Point') && ($loadingData['type'] == 'Force') && ($loadingData['startLocation'] == $n -> x) ) {
					$n -> loading -> fz = $loadingData['startValue'];
				}
				if ( ($loadingData['geometry'] == 'Point') && ($loadingData['type'] == 'Moment') && ($loadingData['startLocation'] == $n -> x) ) {
					$n -> loading -> my = $loadingData['startValue'];
				}
			}
		}

		// begin calculating the rest
		foreach ($this -> rawData['loading'] as $loadingData) {
			if ( $loadingData['geometry'] == 'Distributed' ) {
				// find all nodes within this space
				$startNode = new Node($loadingData['startLocation'], 0, 0);
				$endNode = new Node($loadingData['endLocation'], 0, 0);
				$nodeList = $this -> getAllNodesBetweenNodes($startNode, $endNode);

				$vList = Loading::calculateLoading($nodeList, $loadingData['startValue'], $loadingData['endValue']);
				for ($i = 0; $i < count($nodeList); $i++) {
					if ($loadingData['type'] == 'Force') {
						if ($nodeList[$i] -> loading -> fz == null) {
							$nodeList[$i] -> loading -> fz = 0;
						}
						$nodeList[$i] -> loading -> fz += $vList[$i];
					} elseif ($loadingData['type'] == 'Moment') {
						if ($nodeList[$i] -> loading -> my == null) {
							$nodeList[$i] -> loading -> my = 0;
						}
						$nodeList[$i] -> loading -> my += $vList[$i];
					}
				}
			}
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
	// private function calculateZeroPosition($data) {
	// 	$loadingRatio = abs($data['startValue'] / $data['endValue']);	//2.4
	// 	$loadingLength = $data['endLocation'] - $data['startLocation'];
	// 	$zeroPoint = $data['startLocation'] + ($loadingLength * $loadingRatio) / (1 + $loadingRatio);
	// 	return new Node($zeroPoint, 0, 0);
	// }

	// obtain the list of nodes between 2 given nodes, sorted in order
	private function getAllNodesBetweenNodes($n1, $n2) {
		$output = array();
		foreach ($this -> nodes as $n) {
			if ( ($n1 -> compare($n) <= 0) && ($n2 -> compare($n) >= 0) ) { array_push($output, $n); }
		}
		return Node::quickSort($output);
	}
}
?>