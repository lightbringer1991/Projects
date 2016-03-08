<?php
// predefined variables
$userscalcPK = 14;
$el_max = 0.5;

require_once 'lib/Database.class.php';
require_once 'lib/FEA.class.php';
require_once 'lib/Utilities.class.php';

$db = new Database();
$data = $db -> getData($userscalcPK);

$fea = new FEA($data, $el_max);
$FK = $fea -> runAnalysis();

// output to JSON
Utilities::writeToFile('model.json', $fea -> mesh -> toJSON());
?>