<?php
require_once "ModelBase.class.php";

class Lcs extends ModelBase {

	public function __construct($fields = array()) {
		parent::__construct($fields);
	}

	public function getTableName() {
		return 'ba_lcs';
	}

	public function getIlcsList() {
		$data = json_decode($this -> get('params'), true);
		echo var_dump($data);
	}

	public static function getAllRecordsByCondition($condition) {
		return parent::getAllObjectByCondition('Lcs', $condition);
	}

	public static function getAllRecordsByUsersCalcPK($user_no) {
		return self::getAllRecordsByCondition("`userscalcPK`=$user_no");
	}
}
?>