<html>
<head>
	<title>Ebay - Amazon Item Search</title>
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
	<form id='form-keywordSearch' class='form-group'>
		<div class='form-group col-sm-10 col-md-10 col-lg-10'>
			<input type='text' class='col-sm-12 col-md-12 col-lg-12 form-control' name='keyword' />
		</div>
		<button type='submit' class='btn btn-primary col-sm-2 col-md-2 col-lg-2'>Search</button>
	</form>
	</div>
</div>

<div class='row' id='container-result'>
	<div class='row'>
		<div class='col-sm-12 col-md-12 col-lg-12' style='text-align: center;'><h1>Search Result</h1></div>
	</div>
	<div class='row'>
		<div class='col-sm-12 col-md-12 col-lg-12' data-role='content'></div>
	</div>
</div>

<div class='loading'>
	<img src="images/loading_spinner.gif" width='50px' height='50px' /><br />
	Searching ...
</div>

<script type='text/javascript'>
function ajaxCall(keyword, site) {
	return $.ajax({
		type: 'POST',
		url: 'searchEngine.php',
		data: { 'keyword': keyword, 'site': site }
	});
}

$(document).ready(function() {
$("#container-result").hide();
$('.loading').hide();

$('#form-keywordSearch').on('submit', function(event) {
	event.preventDefault();
	var keyword = $(event.currentTarget).find("input[name='keyword']").val();
	if (keyword.length > 350) {
		alert(keyword.length + " Keyword too long (must be less than 350 characters)");
		return false;
	}
	$.when( ajaxCall(keyword, 'start'), ajaxCall(keyword, 'ebay'), ajaxCall(keyword, 'amazon'), ajaxCall(keyword, 'end') ).done(function(a1, a2, a3, a4) {
		$("#container-result [data-role='content']").html(a1[0] + a2[0] + a3[0] + a4[0]);
		$("#container-result").show();
	});
});

$(document).ajaxStart(function () {
    $('.loading').show();  // show loading indicator
});

$(document).ajaxStop(function() 
{
    $('.loading').hide();  // hide loading indicator
});

$(document).on('click', "a[data-role='url_amazonReviews']", function() {
	$("#modal-amazonReviews").find('.modal-body iframe').attr('src', $(this).data('href'));
});

});
</script>

<div class="modal fade" tabindex="-1" role="dialog" id='modal-amazonReviews'>
<div class="modal-dialog modal-lg">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Modal title</h4>
	</div>
	<div class="modal-body">
		<iframe class='col-sm-12 col-md-12 col-lg-12' height='600px'></iframe>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>