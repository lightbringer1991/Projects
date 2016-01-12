<?php
require_once 'lib/Database.class.php';
require_once 'lib/Beam.class.php';

$db = new Database();
$data = $db -> getData(104);

$beam = new Beam($data, 500);
$beam -> runAnalysis();
// foreach ($beam -> nodes as $n) {
// 	print $n -> x . "\n";
// }
print var_dump($beam -> elements);

?>