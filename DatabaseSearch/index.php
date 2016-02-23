<html>
<head>
	<link rel='stylesheet' href="lib/bootstrap-3.3.6-dist/css/bootstrap.min.css" />
	<script type='text/javascript' src='lib/jquery-1.12.0.min.js'></script>
	<script type='text/javascript' src='lib/bootstrap-3.3.6-dist/js/bootstrap.min.js'></script>
	<title>Data Gathering</title>
</head>
<body>
<div class='row'>
<?php
$value_firstData = "";
if (isset($_GET['step']) && $_GET['step'] == 3) {
	$value_firstData = $_GET['d1'];
}

if (!isset($_GET['step']) || ($_GET['step'] == 1)) {
	// display captcha first
?>
	<div class='col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1'>
		<form action='#' method='POST' id='form1'>
			<div class='form-group'>
				<img data-role='captcha-image' src="captcha.php" width="120" height="40" border="1" alt="CAPTCHA">
				<a href="" data-role='captcha-refresh'>Refresh</a><br />
				<input type="text" class='form-control' name="captcha" value="" placeholder='Enter Captcha' />
				<p class="text-danger" data-role='error-msg'></p>
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
<?php
} else {
?>
	<div class='col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1'>
		<form action='#' method='POST' id='form2'>
			<div class='form-group'>
				<label for='first_data'>First input</label>
				<p>line 1</p>
				<p>line 2</p>
				<input type='text' name='first_data' class='form-control' value='<?php echo $value_firstData; ?>' maxlength='12' />
			</div>
<?php
	if ($_GET['step'] == 3) {
?>
			<div class='form-group'>
				<label for='second_data'>Second input</label>
				<p>line 1</p>
				<p>line 2</p>
				<input type='text' name='second_data' class='form-control' maxlength='8' />
			</div>
<?php
	} // endif $_GET['step'] == 3
?>
			<button type="submit" class="btn btn-default">Submit</button>
		</form>
		<div class='well' data-role='searchResult'></div>
	</div>
</div>
<?php
} // end else
?>
<script type='text/javascript'>
var captchaCount = 0;

$(document).ready(function() {
	$("#form1").on('submit', function(event) {
		event.preventDefault();

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
					captchaCount += 1;
				}
			}
		});
		if (captchaCount == 5) {
			alert("Max captcha input reached. Aborting.");
			$("#form1").find('*').attr("disabled", "disabled");
		} else if (!flag) { return false; }
		else {
			window.location.href = 'index.php?step=2';
		}
	});

	$("#form1").on('click', "a[data-role='captcha-refresh']", function(event) {
		event.preventDefault();
		$("#form1").find("img[data-role='captcha-image']").attr('src', 'captcha.php?' + Math.random());
	});
	
	$("#form1").on('focus', "input[name='captcha']", function(event) {
		$("#form1").find("p[data-role='error-msg']").html("");
	});

<?php
if ( isset($_GET['step']) && ($_GET['step'] > 1) ){
?>
	$("#form2").on('submit', function(event) {
		event.preventDefault();
		var step = 2;
		// validate first input
		var input1 = $(this).find("input[name='first_data']").val();
		if (input1 == '') {
			alert("Empty value");
			return false;
		}
		// remove whitespaces
		$(this).find("input[name='first_data']").val(input1.trim());

		// validate second input
		if ($(this).find("input[name='second_data']").length) {
			step = 3;
			var input2 = $(this).find("input[name='second_data']").val();
			if (input2 == '') {
				alert("Empty value");
				return false;
			}
			// remove whitespaces
			$(this).find("input[name='second_data']").val(input2.trim());
		}

		$.ajax({
			type: 'POST',
			url: 'processor.php?step=' + step,
			data: { 'first_data': input1, 'second_data': $(this).find("input[name='second_data']").val() },
			success: function(data) {
				var jsonData = JSON.parse(data);
				if (jsonData.hasOwnProperty('redirect')) {
					window.location.href = jsonData.redirect;
				} else {
					var resultContainer = $(document).find("[data-role='searchResult']");
					resultContainer.html("Merchant SSO: " + jsonData.merchant_sso + "<br />");
					resultContainer.append("Acc SSO: " + jsonData.acc_sso + "<br />");
					if (jsonData.result[0] == 'error') {
						resultContainer.append(jsonData.result[1]);
					} else {
						var uri = 'https://sandbox.ezpay.com/integration/sso.php?SsoCode=' + jsonData.result[1];
						resultContainer.append("Success: <a href='" + uri + "'>" + uri + "</a>");
					}					
				}
			}
		});
	});


	$("#form2").on('input', "input[name='first_data']", function(event) {
		var upperVal = $(event.currentTarget).val().toUpperCase();
		$(event.currentTarget).val(upperVal);
	});

	$("#form2").on('input', "input[name='second_data']", function(event) {
		var upperVal = $(event.currentTarget).val().toUpperCase();
		$(event.currentTarget).val(upperVal);
	});
<?php
} // end if $_GET['step'] > 1
?>
});
</script>
</body>
</html>