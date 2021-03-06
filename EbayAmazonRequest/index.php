<?php
$query = '';
if (isset($_GET['query'])) {
	$query = urldecode($_GET['query']);
}
?>

<html>
<head>
	<title>Ebay - Amazon Item Search</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src='js/typeahead.bundle.min.js'></script>
</head>
<body>
<style type='text/css'>
.loading {
	text-align: center;
	position: absolute;
	top: 50%;
	left: 50%;
}

.product-image {
	height: auto;
}

.img-youtube:hover {
	cursor: pointer;
}

.modal-nopadding {
	padding: 0;
	padding-left: 70px;
	padding-right: 70px;
}


.modal-xlg {
	width: 70%;
}

/* CSS code for typeahead, will need to be moved to a separate CSS later */
.twitter-typeahead {
	display: inline !important;
	position: absolute !important;
	width: 100%;
	right: 2%;
	z-index: 200;
}

.tt-query, /* UPDATE: newer versions use tt-input instead of tt-query */
.tt-hint {
    width: 396px;
    height: 30px;
    padding: 8px 12px;
    font-size: 24px;
    line-height: 30px;
    border: 2px solid #ccc;
    border-radius: 8px;
    outline: none;
}

.tt-query { /* UPDATE: newer versions use tt-input instead of tt-query */
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
    color: #999;
    display: none;
}

.tt-menu { /* UPDATE: newer versions use tt-menu instead of tt-dropdown-menu */
	width: inherit;
	position: relative !important;
	margin-top: 37px;
	padding: 8px 0;
	background-color: #fff;
	border: 1px solid #ccc;
	border: 1px solid rgba(0, 0, 0, 0.2);
	border-radius: 8px;
	box-shadow: 0 5px 10px rgba(0,0,0,.2);
	z-index: -1 !important;
}

.tt-suggestion {
    padding: 3px 20px;
    font-size: 18px;
    line-height: 24px;
}

.tt-suggestion.tt-is-under-cursor { /* UPDATE: newer versions use .tt-suggestion.tt-cursor */
    color: #fff;
    background-color: #0097cf;

}

.tt-suggestion p {
    margin: 0;
}

/* bootstrap css for 5 equally columns */
.col-xs-15 {
    width: 20%;
    float: left;
}
@media (min-width: 768px) {
.col-sm-15 {
        width: 20%;
        float: left;
    }
}
@media (min-width: 992px) {
    .col-md-15 {
        width: 20%;
        float: left;
    }
}
@media (min-width: 1200px) {
    .col-lg-15 {
        width: 20%;
        float: left;
    }
}
</style>

<div class='row'>
	<div class='col-md-offset-2 col-lg-offset-2 col-sm-12 col-md-8 col-lg-8'>
	<form id='form-keywordSearch' class='form-group'>
		<div class='form-group col-sm-10 col-md-10 col-lg-10'>
			<input type='text' class='col-sm-12 col-md-12 col-lg-12 form-control' name='keyword' value='<?php echo $query; ?>' />
		</div>
		<button type='submit' class='btn btn-primary col-sm-2 col-md-2 col-lg-2'>Search</button>
	</form>
	</div>
</div>

<div class='row' id='container-reviews'>
	<h2>Top 5 Youtube Reviews</h2>
	<div class='col-sm-12 col-md-12 col-lg-12' id='container-youtube'>
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

<div class='modal fade' id='modal-youtubeVideo' role='dialog' style='vertical-align: middle;'>
	<div class="modal-dialog modal-xlg">
		<div class="modal-content" style='background-color: black;'>
			<div class='row'>
			<div class="modal-body modal-nopadding" style='border-style: none;'>
				<div class='col-sm-12 col-md-12 col-lg-12 embed-responsive embed-responsive-16by9'>
					
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript'>
function ajaxCall(keyword, site) {
	return $.ajax({
		type: 'POST',
		url: 'searchEngine.php',
		data: { 'keyword': keyword, 'site': site }
	});
}

function getPrice(columnText) {
	var tokens = columnText.split("(");
	var data = 0;
	// handle Too low to display
	// find (was xxx) section of the price column and use it to compare
	if (tokens[0] == 'Too low to display') {
		if ( (typeof tokens[1] !== 'undefined') && (tokens[1].indexOf("was") > -1) ) {
			data = tokens[1];
			data = data.substring(4, data.length - 1);
		}
	} else {
		data = tokens[0];
	}
	return parseFloat(data.replace(/,/g, ''));
}

// sort a table by a columnIndex (start from 1), isASC = false => sort descending
function sortByColumn(tableObj, columnIndex, isASC) {
	var rows = tableObj.find('tr');
	rows.sort(function(a, b) {
		var keyA = getPrice($(a).find('td:nth-child(' + columnIndex + ')').text());
		var keyB = getPrice($(b).find('td:nth-child(' + columnIndex + ')').text());

		// compare
		if (isASC) {
			return keyA - keyB;
		} else {
			return keyB - keyA;
		}
	});

	// append back to table
	tableObj.empty();
	rows.each(function(index, r) {
		tableObj.append(r);
	});
}

function updateQueryStringParameter(uri, key, value) {
	var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
	var separator = uri.indexOf('?') !== -1 ? "&" : "?";
	if (uri.match(re)) {
		return uri.replace(re, '$1' + key + "=" + value + '$2');
	} else {
		return uri + separator + key + "=" + value;
	}
}

function getEbayItemSold(containerObj) {
	console.log(containerObj.find("tr[data-store='ebay']"));
	containerObj.find("tr[data-store='ebay']").each(function() {
		var id = $(this).attr('id');
		var that = $(this);
		$.ajax({
			type: 'POST',
			url: 'searchEngine.php',
			global: false, 				// loading gif will not display
			data: { 'keyword': '', 'site': 'ebay_itemSold', 'id': id },
			success: function(data) {
				// skip displaying sold count if count = 0
				if (data > 0) {
					that.find("td:nth-child(2)").append("<p style='clear: both;'><div class='alert alert-info' role='alert'>" + data + " sold</div></p>");
				}
			}
		});
	});
}

var suggestions = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	remote: {
		url: 'searchEngine.php',
		prepare: function(query, settings) {
			settings.type = 'POST';
			settings.global = false;
			settings.data = { 'keyword': query, 'site': 'suggestion' };
			return settings;
		}
	},
	transform: function(response) {
		return JSON.parse(response);
	}	
});

$(document).ready(function() {
$("#container-result").hide();
$("#container-reviews").hide();
$('.loading').hide();

$('#form-keywordSearch').on('submit', function(event) {
	event.preventDefault();
	var keyword = $(event.currentTarget).find("input[name='keyword']").val();
	if (keyword.length > 350) {
		alert(keyword.length + " Keyword too long (must be less than 350 characters)");
		return false;
	}
	window.history.pushState({}, "", updateQueryStringParameter(window.location.href, 'query', encodeURI(keyword)));

	$.when( ajaxCall(keyword, 'youtube') ).done(function(a) {
		$("#container-youtube").html(a);
		$("#container-reviews").show();
	});

	$.when( ajaxCall(keyword, 'start'), ajaxCall(keyword, 'ebay'), ajaxCall(keyword, 'amazon'), ajaxCall(keyword, 'end') ).done(function(a1, a2, a3, a4) {
		setTimeout(function() {
			$("#container-result [data-role='content']").html(a1[0] + a2[0] + a3[0] + a4[0]);
			sortByColumn($("#container-result table").find('tbody'), 4, true);
			$("#container-result").show();
			getEbayItemSold($("#container-result"));			
		}, 200);
	});
});

$(document).ajaxStart(function () {
    $('.loading').show();  // show loading indicator
});

$(document).ajaxStop(function() 
{
    $('.loading').hide();  // hide loading indicator
});

// amazon reviews
$(document).on('click', "a[data-role='url_amazonReviews']", function() {
	$("#modal-amazonReviews").find('.modal-body iframe').attr('src', $(this).data('href'));
});

$(document).on('click', "a[data-role='moreDetails']", function(event) {
	var aObj = $(event.currentTarget);
	var itemID = aObj.closest('tr').attr('id');
	event.preventDefault();
	$.ajax({
		type: 'POST',
		url: 'searchEngine.php',
		data: { 'keyword': '', 'site': 'details', 'store': aObj.data('store'), 'id': itemID },
		async: false,
		success: function(url) {
			var win = window.open(url, '_blank');
			if (win) {
				// focus on the new tab
				win.focus();
			}
		}
	});

});

// youtube videos
$(document).on('click', '.img-youtube', function(event) {
	var url = $(event.currentTarget).parent().data('src');
	var iframeCode = '<iframe class="embed-responsive-item" src="' + url + '"></iframe>';
	
	$("#modal-youtubeVideo").find('.modal-body .embed-responsive').html(iframeCode);
});

// center the modal vertically
$("#modal-youtubeVideo").on('show.bs.modal', function(event) {
	// should have the same percentage with .modal-xlg in the css style
	var modal_height = window.innerWidth * 70 / 100 * 9 /16;
	$("#modal-youtubeVideo").find('.modal-dialog').css("margin-top", Math.max(0, (window.innerHeight - modal_height) / 2));
});

// clear the embedded youtube iframe on modal close, stop the video from playing
$("#modal-youtubeVideo").on('hidden.bs.modal', function(event) {
	$(event.currentTarget).find('.modal-body .embed-responsive').html("");
});

<?php
if ($query != '') {
?>
	$('#form-keywordSearch').trigger('submit');
<?php
}
?>

$("input[name='keyword']").typeahead(null, {
	source: suggestions,
	limit: 'Infinity',
	templates: {
		suggestion: function (data) {
			return '<div class="col-sm-6 col-md-6 col-lg-6"><strong>' + data + '</strong></p>';
		}
	}
}).on('typeahead:open', function() {
	$(document).find(".tt-open .tt-dataset").addClass('row');
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