<html>
<head>
	<link rel='stylesheet' href="lib/bootstrap-3.3.6-dist/css/bootstrap.min.css" />
	<script type='text/javascript' src='lib/jquery-1.12.0.min.js'></script>
	<script type='text/javascript' src='lib/bootstrap-3.3.6-dist/js/bootstrap.min.js'></script>
	<title>Data Gathering</title>
</head>
<body>
<?php
if (!isset($_GET['step']) || ($_GET['step'] == 1)) {
?>
<div class='row'>
	<div class='col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1'>
		<form action='processor.php?step=1' method='POST' id='form1'>
			<div class='form-group'>
				<label for='first_data'>First input</label>
				<input type='text' name='first_data' class='form-control' />
			</div>
			<div class='form-group'>
				<img data-role='captcha-image' src="captcha.php" width="120" height="40" border="1" alt="CAPTCHA">
				<a href="" data-role='captcha-refresh'>Refresh</a><br />
				<input type="text" class='form-control' name="captcha" value="" placeholder='Enter Captcha' />
				<p class="text-danger" data-role='error-msg'></p>
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</div>
<?php
} elseif ($_GET['step'] == 2) {
?>
<div class='row'>
	<div class='col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1'>
		<form action='processor.php?step=2' method='POST' id='form2'>
			<div class='form-group'>
				<label for='second_data'>Second input</label>
				<input type='text' name='second_data' class='form-control' />
			</div>
			<input type='hidden' name='index_1' value='<?php echo $_GET['d1']; ?>' />
			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</div>
<?php
}
?>
<script type='text/javascript'>
$(document).ready(function() {
	$("#form1").on('submit', function() {
		var captchaValue = $(this).find("input[name='captcha']").val();
		// check captcha length
		if (!captchaValue.match(/^\d{5}$/)) {
			alert('Please enter the CAPTCHA digits in the box provided');
			$(this).find("input[name='captcha']").focus();
			return false;
		}
		// validate captcha
		var flag = true;
		$.ajax({
			type: 'POST',
			url: 'processor.php?step=captcha',
			data: { 'captcha': captchaValue },
			async: false,
			success: function(data) {
				if (data == 0) {
					$("#form1").find("input[name='captcha']").val("");
					$("#form1").find("a[data-role='captcha-refresh']").click();
					$("#form1").find("p[data-role='error-msg']").html("wrong captcha entered.");
					flag = false;
				}
			}
		});
		if (!flag) { return false; }

		// validate input
		var inputValue = $(this).find("input[name='first_data']").val();
		if (inputValue == '') {
			alert("Empty value");
			return false;
		}
		// remove whitespaces
		$(this).find("input[name='first_data']").val(inputValue.trim());
		
		return true;
	});

	$("#form2").on('submit', function() {
		// validate input
		var inputValue = $(this).find("input[name='second_data']").val();
		if (inputValue == '') {
			alert("Empty value");
			return false;
		}
		// remove whitespaces
		$(this).find("input[name='second_data']").val(inputValue.trim());
		
		return true;
	});

	$("#form1").on('click', "a[data-role='captcha-refresh']", function(event) {
		event.preventDefault();
		$("#form1").find("img[data-role='captcha-image']").attr('src', 'captcha.php?' + Math.random());
	});

	$("#form1").on('input', "input[name='first_data']", function(event) {
		var upperVal = $(event.currentTarget).val().toUpperCase();
		$(event.currentTarget).val(upperVal);
	});
	$("#form1").on('focus', "input[name='captcha']", function(event) {
		$("#form1").find("p[data-role='error-msg']").html("");
	});

	$("#form2").on('input', "input[name='second_data']", function(event) {
		var upperVal = $(event.currentTarget).val().toUpperCase();
		$(event.currentTarget).val(upperVal);
	});
});
</script>
</body>
</html>