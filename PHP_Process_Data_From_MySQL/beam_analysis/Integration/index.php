<?php
error_reporting(E_ALL);

require_once 'lib/Database.class.php';
require_once 'lib/Beam.class.php';

require_once 'FEA.class.php';

// predefined variables
$userscalcPK = 104;

// data gathering and calculation
$db = new Database();
$data = $db -> getData($userscalcPK);

// to get the connectivitiy of nodes
$el_max = 500;
$mesh = new Mesh_1D($data, $el_max);

// to be done later
$etype = 'beam23';
$beam = new Beam($mesh, $etype);

//

$loading = new Loading($mesh);

$model = new Model($beam, $loading)

FEA($model);

?>

<html>
<head>
	<title>PHP Processing Data</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
<style type='text/css'>
.loading {
	text-align: center;
	position: absolute;
	top: 50%;
	left: 50%;
}
</style>

<h3>Data extracted for userscalcPK=<?php echo $userscalcPK; ?> AND el_max=<?php echo $el_max; ?></h3>
<div class='row'>
	<div class='col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-6 col-md-6 col-lg-6'>
	<table class='table table-bordered table-striped'>
		<thead>
		<tr>
			<th class='col-sm-1 col-md-1 col-lg-1'>Node ID</th>
			<th class='col-sm-2 col-md-2 col-lg-2'>X</th>
			<th class='col-sm-2 col-md-2 col-lg-2'>Y</th>
			<th class='col-sm-2 col-md-2 col-lg-2'>Z</th>
		</tr>
		</thead>
		<tbody>
<?php
for ($i = 0; $i < count($beam -> nodes); $i++) {
	echo "	<tr>
				<td>$i</td>
				<td>" . $beam -> nodes[$i] -> x . "</td>
				<td>" . $beam -> nodes[$i] -> y . "</td>
				<td>" . $beam -> nodes[$i] -> z . "</td>
			</tr>";
}
?>
		</tbody>
	</table>
	</div>
</div>

<div class='row'>
	<div class='col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-8 col-md-8 col-lg-8'>
	<table class='table table-bordered table-striped'>
		<thead>
		<tr>
			<th class='col-sm-2 col-md-2 col-lg-2'>Element ID</th>
			<th class='col-sm-2 col-md-2 col-lg-2'>Start Node ID</th>
			<th class='col-sm-2 col-md-2 col-lg-2'>End Node ID</th>
			<th class='col-sm-3 col-md-3 col-lg-3'>PK4ba_mat</th>
			<th class='col-sm-3 col-md-3 col-lg-3'>PK4ba_g</th>
		</tr>
		</thead>
		<tbody>
<?php
for ($i = 0; $i < count($beam -> nodes) - 1; $i++) {
	echo "	<tr>
				<td>" . $i . "</td>
				<td>" . array_search($beam -> nodes[$i] -> elementStart -> startNode, $beam -> nodes) . "</td>
				<td>" . array_search($beam -> nodes[$i] -> elementStart -> endNode, $beam -> nodes) . "</td>
				<td>" . $beam -> nodes[$i] -> elementStart -> PK4ba_mat . "</td>
				<td>" . $beam -> nodes[$i] -> elementStart -> PK4ba_g . "</td>
			</tr>";
}
?>
		</tbody>
	</table>
	</div>
</div>

<div class='row'>
	<div class='col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-8 col-md-8 col-lg-8'>
	<table class='table table-bordered table-striped'>
		<thead>
		<tr>
			<th class='col-sm-1 col-md-1 col-lg-1'>Node ID</th>
			<th class='col-sm-1 col-md-1 col-lg-1'>fx</th>
			<th class='col-sm-2 col-md-2 col-lg-2'>fy</th>
			<th class='col-sm-2 col-md-3 col-lg-2'>fz</th>
			<th class='col-sm-2 col-md-3 col-lg-2'>mx</th>
			<th class='col-sm-2 col-md-3 col-lg-2'>my</th>
			<th class='col-sm-2 col-md-3 col-lg-2'>mz</th>
		</tr>
		</thead>
		<tbody>
<?php
for ($i = 0; $i < count($beam -> nodes); $i++) {
	echo "	<tr>
				<td>$i</td>
				<td>" . $beam -> nodes[$i] -> loading -> fx . "</td>
				<td>" . $beam -> nodes[$i] -> loading -> fy . "</td>
				<td>" . $beam -> nodes[$i] -> loading -> fz . "</td>
				<td>" . $beam -> nodes[$i] -> loading -> mx . "</td>
				<td>" . $beam -> nodes[$i] -> loading -> my . "</td>
				<td>" . $beam -> nodes[$i] -> loading -> mz . "</td>
			</tr>";
}
?>
		</tbody>
	</table>
	</div>
</div>

</body>
</html>
