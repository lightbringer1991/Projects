<?php
// predefined variables
$userscalcPK = 14;
$el_max = 0.5;

require_once 'lib/Database.class.php';
require_once 'lib/FEA.class.php';
require_once 'lib/Utilities.class.php';

$db = new Database();
$data = $db -> getData($userscalcPK);

$ilcsList = Ilcs::getAllRecordsByUsersCalcPK($userscalcPK);

$fea = new FEA($data, $el_max);

echo var_dump($ilcsList[1]);
echo var_dump( $fea -> generateF(array($ilcsList[1])) );
// $FK = $fea -> runAnalysis();

// output to JSON
// Utilities::writeToFile('model.json', $fea -> mesh -> toJSON());
?>