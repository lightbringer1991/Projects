<?php
$fileName = rand(100000, 999999);
?>

<html>
<head>
	<title>Email/phone extractor</title>
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

<div class='row'>
	<div class='col-md-offset-2 col-lg-offset-2 col-sm-12 col-md-8 col-lg-8'>
	<form id='form-emailExtractor' class='form-group'>
		<input type='hidden' name='fileID' value='<?php echo $fileName; ?>' />
		<div class='form-group col-sm-8 col-md-8 col-lg-8'>
			<textarea class='col-sm-12 col-md-12 col-lg-12 form-control' name='url'></textarea>
		</div>
		<div class='form-group checkbox col-sm-2 col-md-2 col-lg-2'>
			<label>
				<input type="radio" name='options' value='multiple' /> Search multiple pages
			</label>
			<label>
				<input type="radio" name='options' value='deep' /> Go deep 1 level
			</label>
		</div>
		<button type='submit' class='btn btn-primary col-sm-2 col-md-2 col-lg-2'>Submit</button>
	</form>
	</div>
</div>

<div class='row' id='container-download'>
	<div class='row'>
		<div class='col-sm-12 col-md-12 col-lg-12' style='text-align: center;'><h1>Ready for Download<span class='glyphicon glyphicon-arrow-down'></span></h1></div>
	</div>
	<div class='row'>
		<div class='col-md-offset-3 col-lg-offset-3 col-sm-12 col-md-6 col-lg-6'>
			<div class='col-sm-4 col-md-4 col-lg-4'>
				<button data-role='btn-csv' data-id='<?php echo $fileName; ?>' class='btn btn-primary col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-8 col-md-8 col-lg-8'>Download .csv</button>
			</div>
			<div class='col-sm-4 col-md-4 col-lg-4'>
				<button data-role='btn-xml' data-id='<?php echo $fileName; ?>' class='btn btn-primary col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-8 col-md-8 col-lg-8' disabled>Download .xml</button>
			</div>
			<div class='col-sm-4 col-md-4 col-lg-4'>
				<button data-role='btn-pdf' data-id='<?php echo $fileName; ?>' class='btn btn-primary col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-sm-8 col-md-8 col-lg-8' disabled>Download .pdf</button>
			</div>
		</div>
	</div>
</div>

<div class='loading'>
	<img src="loading_spinner.gif" width='50px' height='50px' /><br />
	Script is running
</div>

<script type='text/javascript'>
$(document).ready(function() {
$("#container-download").hide();
$('.loading').hide();

$('#form-emailExtractor').on('submit', function(event) {
	event.preventDefault();
	var data = $(event.currentTarget).serializeArray();

	var option = $(event.currentTarget).find("input[name='options']:checked").val();
	if ( (typeof option === "undefined") || confirm("Enabling multiple page search may take much longer. Do you want to proceed?") ) {
		$.ajax({
			type: 'POST',
			url: 'dataExtractor.php',
			data: data,
			success: function() {
				alert('Completed');
				$("#container-download").show();
			}
		});
	}
});
$("#container-download").on('click', 'button[data-role="btn-csv"]', function() {
	window.location.href = '<?php echo "output/$fileName.csv" ?>';
});

$(document).ajaxStart(function () {
    $('.loading').show();  // show loading indicator
});

$(document).ajaxStop(function() 
{
    $('.loading').hide();  // hide loading indicator
});

});
</script>

</body>
</html>