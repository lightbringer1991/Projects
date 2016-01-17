<?php
require_once('config.php');
class Database {
	private $db;
	private $config;
	private $data;
	public function __construct($database = 'calc') {
		$this -> config = array(
			'host' => DB_HOSTNAME,
			'username' => DB_USERNAME,
			'password' => DB_PASSWORD,
			'db' => ($database == 'shared') ? DB_SHARED_NAME : DB_CALC_NAME
		);
		$this -> db = $this -> initializeConnection();
		$this -> data = array(
			'geometry' => array(),
			'loading' => array(),
			'support' => array(),
			'material' => array()
		);
	}
	private function initializeConnection() {
		$conn = new mysqli(
			$this -> config['host'],
			$this -> config['username'],
			$this -> config['password'],
			$this -> config['db']
		);
		if ($conn -> connect_errno) {
			die("Connection failed: " . $conn -> connect_error);
		}
		return $conn;
	}
	public function getData($userId, $clear = false) {
		if ($clear) {
			// remove all data with userscalcPK = 0
			$this -> db -> query("DELETE FROM beam_analysis_g WHERE userscalcPK = 0");
			$this -> db -> query("DELETE FROM beam_analysis_loading WHERE userscalcPK = 0");
			$this -> db -> query("DELETE FROM beam_analysis_spt WHERE userscalcPK = 0");
			$this -> db -> query("DELETE FROM beam_analysis_mat WHERE userscalcPK = 0");
		}
		$sql_geometry = "SELECT * FROM `beam_analysis_g` WHERE `userscalcPK`='$userId'";
		$sql_loading = "SELECT * FROM `beam_analysis_loading` WHERE `userscalcPK` = '$userId'";
		$sql_support = "SELECT * FROM `beam_analysis_spt` WHERE `userscalcPK` = '$userId'";
		$sql_material = "SELECT * FROM `beam_analysis_mat` WHERE `userscalcPK` = '$userId'";
		if ($result = $this -> db -> query($sql_geometry)) {
			while ($row = $result -> fetch_assoc()) {
				array_push($this -> data['geometry'], $row);
			}
		}
		if ($result = $this -> db -> query($sql_loading)) {
			while ($row = $result -> fetch_assoc()) {
				array_push($this -> data['loading'], $row);
			}
		}
		if ($result = $this -> db -> query($sql_support)) {
			while ($row = $result -> fetch_assoc()) {
				array_push($this -> data['support'], $row);
			}
		}
		if ($result = $this -> db -> query($sql_material)) {
			while ($row = $result -> fetch_assoc()) {
				array_push($this -> data['material'], $row);
			}
		}
		return $this -> data;
	}
}
?>