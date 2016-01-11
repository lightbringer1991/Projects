<!DOCTYPE html>

<?php

// header('Content-type: text/plain');

include "BA_FEA_functions.php";

include "elements.php";

require_once('../../../../config.php');

class Generic {
    private $db;

    private $config;

    function __construct($database = "calc") {
        $this->config = array(
            'data' => array(),
            'database' => array(
                'host' => DB_HOSTNAME,
                'username' => DB_USERNAME,
                'password' => DB_PASSWORD,
                'db' => $database == "shared" ? DB_SHARED_NAME : DB_CALC_NAME
            )
        );

        $this->db = $this->database();
    }

    function database() {
        $conn = new mysqli(
            $this->config['database']['host'],
            $this->config['database']['username'],
            $this->config['database']['password'],
            $this->config['database']['db']
        );

        if ($conn->connect_errno) {
            die("Connection failed: ".$conn->connect_error);
        }

        return $conn;
    }

    function get($userid, $clear) {
        $dataGeometry = array();
        $dataLoading = array();
        $dataSpt = array();
        $dataMat = array();

        if ($clear == 'true') {
            $this->db->query("DELETE FROM beam_analysis_g WHERE userscalcPK = 0");
            $this->db->query("DELETE FROM beam_analysis_loading WHERE userscalcPK = 0");
            $this->db->query("DELETE FROM beam_analysis_spt WHERE userscalcPK = 0");
            $this->db->query("DELETE FROM beam_analysis_mat WHERE userscalcPK = 0");
        }

        $queryGeometry = "SELECT * FROM beam_analysis_g WHERE userscalcPK = '{$userid}'";
        $queryLoading = "SELECT * FROM beam_analysis_loading WHERE userscalcPK = '{$userid}'";
        $querySpt = "SELECT * FROM beam_analysis_spt WHERE userscalcPK = '{$userid}'";
        $queryMat = "SELECT * FROM beam_analysis_mat WHERE userscalcPK = '{$userid}'";

        if ($result = $this->db->query($queryGeometry)) {
            while ($row = $result->fetch_assoc()) {
                $dataGeometry[] = $row;
            }
        }

        if ($result = $this->db->query($queryLoading)) {
            while ($row = $result->fetch_assoc()) {
                $dataLoading[] = $row;
            }
        }

        if ($result = $this->db->query($querySpt)) {
            while ($row = $result->fetch_assoc()) {
                $dataSpt[] = $row;
            }
        }


        if ($result = $this->db->query($queryMat)) {
            while ($row = $result->fetch_assoc()) {
                $dataMat[] = $row;
            }
        }

        return array(
            'geometry' => $dataGeometry,
            'loading' => $dataLoading,
            'support' => $dataSpt,
            'material' => $dataMat
        );
    }
}

$get = (object)$_GET;
$request = (object)$_REQUEST;
$post = json_decode(file_get_contents("php://input"));

@$database = (!empty($request->database)) ? $request->database : $post->database;

$generic = new Generic($database);

$data = $generic->get(104, 'true');
// $data = $generic->get($request->userid, $request->clear);
// die(json_encode($data));

// var_dump($data);

// var_dump($data['geometry']);
$nodes_g = array();
for ($i = 0; $i < sizeof($data['geometry']); $i++){
	if($i==0){
		array_push($nodes_g, $data['geometry'][$i]['start']);
		array_push($nodes_g, $data['geometry'][$i]['end']);
	}else{
		array_push($nodes_g, $data['geometry'][$i]['end']);
	}
}
print_r($nodes_g);

var_dump($data['loading']);


// var_dump($data['support']);
$nodes_spt = array();
for ($i = 0; $i < sizeof($data['support']); $i++){
		array_push($nodes_spt, $data['support'][$i]['location']);
}
print_r($nodes_spt);

var_dump($data['material']);

print_r(sizeof($data['geometry']));

$E = 1;
$I = 1;
$EI = $E * $I;
$le = 1;

$elist = array(1, 2, 3, 4);
$ne = sizeof($elist);

echo "Number of elements: $ne";
echo "\n";

$etype = 'Euler-Bernoulli'; // Timoshenko
$nodes_e = 2;
$ndofs_n = 2;

$ndofs_e = $ndofs_n * $nodes_e;

$ndofs_all = ($ne + 1)*$ndofs_n;

$K = array();
for ($i = 0; $i < $ndofs_all; $i++)
{
	$K[$i] = array_fill(0, $ndofs_all, 0);
}

for ($ie = 0; $ie < $ne; $ie++) {

	$k_e = get_k_e($etype, $E, $I, $le);

	for ($irow = 0; $irow < 4; $irow++) {
		$irow_g = $ie * 2 + $irow;
		for ($icol = 0; $icol < 4; $icol++) {
			$icol_g = $ie * 2 + $icol;
	//			alert("ie: " + ie + ", irow: " + irow + ", icol: " + icol + ", irow_g: " + irow_g + ", icol_g: " + icol_g);
			$K[$irow_g][$icol_g] = $K[$irow_g][$icol_g] + $k_e[$irow][$icol];
		}
	}
}

echo "\n";

echo "Size of K: ". sizeof($K);


echo "\nK = \n\n";
// var_dump($K);

showArray($K, count($K), count($K[0]));




?>