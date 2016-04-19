var utilities = {
	sortPrice: function(jsonStringArray, isASC) {
		/*
			jsonStringArray: array of JSON string output from search ajax call
		*/
		var jsonObjList = [];
		for (var i = 0; i < jsonStringArray.length; i++) {
			var jsonData = JSON.parse(jsonStringArray[i]);
			for (var j = 0; j < jsonData.length; j++) {
				jsonObjList.push(jsonData[j]);
			}
		}
		jsonObjList.sort(function(a, b) {
			var priceA = a.price;
			var priceB = b.price;

			if (priceA == 'Too low to display') { priceA = a.listprice; }
			if (priceB == 'Too low to display') { priceB = b.listprice; }

			if (isASC) {
				return priceA - priceB;
			} else {
				return priceB - priceA;
			}
		});
		return jsonObjList;
	},
	updateQueryStringParameter: function(uri, key, value) {
		var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
		var separator = uri.indexOf('?') !== -1 ? "&" : "?";
		if (uri.match(re)) {
			return uri.replace(re, '$1' + key + "=" + value + '$2');
		} else {
			return uri + separator + key + "=" + value;
		}
	},
	// add ',' for thousand display
	formatNumber: function(number) {
		return number.replace(/(\d)(?=(\d{3})+$)/g, '$1,');
	},
	// truncate text to prevent text overflow
	truncateText: function(text) {
		var length = 50;						// max 50 characters are displayed
		if ($(window).width() < 767) {
			length = 30;
		} else if ($(window).width() < 1200) {
			length = 40;
		}

		if (text.length > length) {
			return text.trim().substring(0, length).split(' ').slice(0, -1).join(' ') + '...';
		} else {
			return text;
		}
		
	}
};

var searchActions = {
	config: {
		form_search: null,
		container_youtube_reviews: null,
		container_youtube_videos: null,
		container_result: null,
		container_loading: null,
		modal_amazonReviews: null,
		modal_youtubeVideo: null,
		image_folder: null,

		obj_bloodhound: null,

		ajax_getResult: 'searchEngine.php'
	},
	init: function(newSettings) {
		searchActions.config = $.extend(searchActions.config, newSettings);
		searchActions.config.obj_bloodhound = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: searchActions.config.ajax_getResult,
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
		searchActions.setup();
	},
	setup: function() {
		$(document).ajaxStart(function () {
			searchActions.config.container_loading.show();		// show loading indicator
		});

		$(document).ajaxStop(function() {
			searchActions.config.container_loading.hide();		// hide loading indicator
		});

		// suggestion
		searchActions.config.form_search.find("input[name='keyword']").typeahead(null, {
			source: searchActions.config.obj_bloodhound,
			limit: 'Infinity',
			templates: {
				suggestion: function (data) {
					return '<div class="col-sm-6 col-md-6 col-lg-6"><strong>' + data + '</strong></p>';
				}
			}
		}).on('typeahead:open', function() {
			$(document).find(".tt-open .tt-dataset").addClass('row');
		});

		searchActions.config.container_loading.hide();
		searchActions.config.form_search.on('submit', searchActions.submit_searchForm);
		// amazon reviews
		searchActions.config.container_result.on('click', "a[data-role='url_amazonReviews']", searchActions.click_displayAmazonReviews);
		// product details display
		searchActions.config.container_result.on('click', "a[data-role='moreDetails']", searchActions.click_displayDetails);
		// youtube video popup
		searchActions.config.container_youtube_videos.on('click', '.mv_single_meta', searchActions.click_displayVideo);
		// center the modal vertically
		searchActions.config.modal_youtubeVideo.on('show.bs.modal', function(event) {
			// should have the same percentage with .modal-xlg in the css style
			var modal_height = window.innerWidth * 70 / 100 * 9 /16;
			searchActions.config.modal_youtubeVideo.find('.modal-dialog').css("margin-top", Math.max(0, (window.innerHeight - modal_height) / 2));
		});
		// stop video from playing if user close the popup
		searchActions.config.modal_youtubeVideo.on('hidden.bs.modal', function(event) {
			$(event.currentTarget).find('.modal-body .embed-responsive').html("");
		});
	},
	ajaxCall: function(keyword, site) {
		return $.ajax({
			type: 'POST',
			url: searchActions.config.ajax_getResult,
			data: { 'keyword': keyword, 'site': site }
		});
	},
	submit_searchForm: function(event) {
		event.preventDefault();
		var keyword = $(event.currentTarget).find("input[name='keyword']").val();
		if (keyword.length > 350) {
			alert(keyword.length + " Keyword too long (must be less than 350 characters)");
			return false;
		}
		window.history.pushState({}, "", utilities.updateQueryStringParameter(window.location.href, 'query', encodeURI(keyword)));

		$.when( searchActions.ajaxCall(keyword, 'youtube') ).done(searchActions.renderYoutubeVideoDisplay);
		$.when( searchActions.ajaxCall(keyword, 'ebay'), searchActions.ajaxCall(keyword, 'amazon') ).done(function(a1, a2) {
			setTimeout(function() {
				var dataArray = utilities.sortPrice([a1[0], a2[0]], true);
				var htmlCode = searchActions.renderProductList(dataArray);
				searchActions.config.container_result.find('.pl_bottom').html(htmlCode);
				searchActions.getEbayItemSold(searchActions.config.container_result);
			}, 200);
		});
	},
	getEbayItemSold: function(containerObj) {
		containerObj.find("div[data-store='ebay']").each(function() {
			var id = $(this).attr('id');
			var that = $(this);
			$.ajax({
				type: 'POST',
				url: searchActions.config.ajax_getResult,
				global: false, 				// loading gif will not display
				data: { 'keyword': '', 'site': 'ebay_itemSold', 'id': id },
				success: function(data) {
					// skip displaying sold count if count = 0
					if (data > 0) {
						var htmlCode = "<div class='pink_ribon_cl clearfix'>"
				                            + "<img src='" + searchActions.config.image_folder + 'pink_ribbon.png' + "' />"
				                            + "<span>" + data + " Sold</span>"
				                        + "</div>";
						that.find(".inner_image_pn_bottom").append(htmlCode);
					}
				}
			});
		});
	},
	renderYoutubeVideoDisplay: function(data) {
		var jsonData = JSON.parse(data);
		var htmlCode = "";
		for (var i = 0; i < jsonData.length; i++) {
			htmlCode += "<div class='mv_single clearfix'>"
						+ "<div class='mv_single_inner clearfix'>"
							+ "<img class='thumb_preview' src='" + jsonData[i].thumbnail + "' />"
							+ "<div class='mv_single_meta clearfix' data-target='#modal-youtubeVideo' data-toggle='modal' data-src='" + jsonData[i].url + "'>"
								+ "<h3>" + utilities.truncateText(jsonData[i].title) + "</h3>"
								+ "<h4>"
								+ utilities.formatNumber(jsonData[i].views) + " views"
								+ "<span>" + jsonData[i].duration + "</span>"
								+ "</h4>"
								+ "<img class='play_icon' src='" + searchActions.config.image_folder + "play_icon.png" + "' alt='' />"
							+ "</div>"
						+ "</div>"
					+ "</div>";
		}
		searchActions.config.container_youtube_videos.html(htmlCode);
		searchActions.config.container_youtube_reviews.show();
	},
	/*
	render all items
	productData = {
		store: 'ebay', 'amazon', ...
		data: [...]
	}
	*/
	renderProductList: function(productData) {
		var output = "";
		for (var i = 0; i < productData.length; i++) {
			output += searchActions.renderProductItem(productData[i]);
		}
		return output;
	},
	// render one item
	renderProductItem: function(productItem) {
		// render exclusive contents for each store
		var reviewCode = '';
		if (productItem.store == 'ebay') {
			// render review
			reviewCode = "<div class='seller_fb pull-left'>"
							+ "<h4>Seller Information</h4>"
							+ "<h5><span>" + productItem.feedback + "</span> Positive feedback</h5>"
						+ "</div>";
		} else if (productItem.store == 'amazon') {
			reviewCode = "<a data-href='" + productItem.feedback + "' class='urating_link' data-role='url_amazonReviews' data-toggle='modal' data-target='#modal-amazonReviews'>User reviews</a>";
		}

		// render discount tag
		var discountCode = "";
		if (productItem.percentagesaved != 0) {
			discountCode = "<span class='red_star'>"
								+ "<strong>" + productItem.percentagesaved + "%</strong><br /> OFF"
							+ "</span>";
		}

		// render price display
		var priceCode = "";
		if (productItem.price == 'Too low to display') {
			priceCode = "<div class='display_mobile p_price_bottom p_price_top text_bottom pull-left clearfix'>"
							+ "<h3>Too low<br/> to display</h3>"
						+ "</div>";
		} else if ( (productItem.listprice != 0) && (productItem.price != productItem.listprice) ) {
			// item has discount
			priceCode = "<div class='p_price_bottom p_price_top text_bottom pull-left clearfix'>"
							+ "<h4>$" + productItem.listprice + "</h4>"
							+ "<h3>$" + productItem.price + "</h3>"
						+ "</div>";
		} else {
			// normal price
			priceCode = "<div class='p_price_bottom p_price_top text_bottom pull-left clearfix'>"
							+ "<h3>$" + productItem.price + "</h3>"
						+ "</div>";
		}

		// render product item
		var output = "<div id='" + productItem.id + "' class='clearfix single_pl' data-store='" + productItem.store + "'>"
				    + "<div class='container'>"
				        + "<div class='row'>"
				            + "<div class='col-md-12'>"
				                + "<div class='clearfix p_name_top p_name_bottom'>"
				                    + "<div class='image_pn_bottom pull-left clearfix'>"
				                        + "<div class='inner_image_pn_bottom clearfix'>"
				                            + "<img class='img_pn_bottom' src='" + productItem.picture + "' alt=''/>"
				                            + "<a class='product_url' title='Product Link' href='" + productItem.url + "'></a>"
				                            + discountCode
				                            + "<img class='" + productItem.store + "_btn' src='" + searchActions.config.image_folder + productItem.store + "_btn.png" + "' />"
				                        + "</div>"

				                        + "<div class='display_mobile p_price_bottom p_price_top text_bottom pull-left clearfix'>"
				                            + "<h3>Too low<br/> to display</h3>"
				                        + "</div>"
				                    + "</div>"
				                    + "<div class='text_pn_bottom text_pn_top text_bottom pull-left clearfix'>"
				                        + "<h2>" + utilities.truncateText(productItem.title) + "</h2>"
				                        + "<a data-store='" + productItem.store + "' data-role='moreDetails' target='_blank' href='#'><span>More details</span> &gt;&gt;</a>"
				                        + "<div class='clearfix display_mobile mobile_extra_meta'>"
				                            + "<a href='" + productItem.url + "' class='v_store' target='_blank'><img src='" + searchActions.config.image_folder + "v_store.png" + "' /></a>"
				                            + "<div class='clearfix p_shipping_top p_shipping_bottom text_bottom pull-left'>"
				                                + "<h4><span class='show_mobile'>Shipping </span>" + productItem.shippingCost + "</h4>"
				                            + "</div>"
				                            + reviewCode
				                        + "</div>"
				                    + "</div>"
				                + "</div>"
				                + priceCode
				                + "<div class='clearfix p_shipping_top p_shipping_bottom text_bottom pull-left'>"
				                    + "<h4>" + productItem.shippingCost + "</h4>"
				                + "</div>"
				                + "<div class='clearfix p_rating_top p_rating_bottom pull-left text_bottom padding_0right'>"
				                    + "<div class='rating_div clearfix'>"
				                    	+ reviewCode
				                        + "<a href='" + productItem.url + "' class='v_store' target='_blank'><img src='" + searchActions.config.image_folder + "v_store.png" + "' alt='' /></a>"
				                    + "</div>"
				                + "</div>"
				            + "</div>"
				        + "</div>"
				    + "</div>"
				+ "</div>";
		return output;
	},
	click_displayAmazonReviews: function(event) {
		searchActions.config.modal_amazonReviews.find('.modal-body iframe').attr('src', $(event.currentTarget).data('href'));
	},
	click_displayDetails: function(event) {
		var aObj = $(event.currentTarget);
		var itemID = aObj.closest('.single_pl').attr('id');
		event.preventDefault();
		$.ajax({
			type: 'POST',
			url: searchActions.config.ajax_getResult,
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
	},
	click_displayVideo: function(event) {
		var url = $(event.currentTarget).data('src');
		var iframeCode = '<iframe class="embed-responsive-item" src="' + url + '"></iframe>';
		searchActions.config.modal_youtubeVideo.find('.modal-body .embed-responsive').html(iframeCode);
	}
};