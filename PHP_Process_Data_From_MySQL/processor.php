<?php
require_once 'lib/Database.class.php';
require_once 'lib/Beam.class.php';

$db = new Database();
$data = $db -> getData(104);

$beam = new Beam($data, 500);
$beam -> runAnalysis();

// $count = 0;
// foreach ($beam -> nodes as $n) {
// 	// print $n -> x . "\n";
// 	print "\nNode ID: $count\n";
// 	print $n -> x . "\n";
// 	print $n -> value . "\n";
// 	print $n -> elementStart . "\n";
// 	print $n -> elementEnd . "\n";
// 	$count++;
// }

?>