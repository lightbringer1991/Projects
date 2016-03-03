<?php
require_once 'lib/Database.class.php';
require_once 'lib/Mesh_1D.class.php';
require_once 'lib/FEA.class.php';
require_once 'lib/Utilities.class.php';

require_once 'lib/Section.class.php';

// $sectionList = Section::getAllRecordsByUsersCalcPK(14);
// $startNode = $sectionList[0] -> getStartNode();
// $endNode = $sectionList[0] -> getEndNode();
// echo var_dump($endNode);

// $elementIndex = 4;

$db = new Database();
$data = $db -> getData(14);

$beam = new Mesh_1D($data, 500);
$beam -> run();

foreach ($beam -> nodes as $n) {
	echo $n -> get('y') . ": " . $n -> value . "\n";
}


// $fea = new FEA($data, 500);
// $F = $fea -> generateF();
// Utilities::showArray($F, count($F), 1, "<br />");

// echo "<br />\$k_e checking for element $elementIndex:";
// echo "<br />\$k_e first approach checking:<br />";
// $k_e1 = $fea -> generateKE_1($fea -> mesh -> connections[$elementIndex]);
// Utilities::showArray($k_e1, 4, 4, "<br />", "&nbsp;&nbsp;&nbsp;&nbsp;");
// echo "<br /><br />\$k_e second approach checking (polynomial):<br />";
// $k_e2 = $fea -> generateKE_2($fea -> mesh -> connections[$elementIndex]);
// Utilities::showArray($k_e2, 4, 4, "<br />", "&nbsp;&nbsp;&nbsp;&nbsp;");

// echo "<br /><br />\$K checking:<br />";
// $K = $fea -> assembleKMatrix();
// Utilities::showArray($K, count($K), count($K[0]), "<br />", "&nbsp;&nbsp;");

// echo "<br /><br />K\F <br />";
// $FK = $fea -> runAnalysis();
?>