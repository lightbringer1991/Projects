var indexActions = {
	config: {
		form_search: null,
		string_typeCode: null,					// string to display on input
		ajax_getResult: 'searchEngine.php',

		// variables for type behaviour
		string_type_list: [],
		stopTypingFlag: false,
		typeSpeed: 100,
		backDelay: 1500,
		currentTextIndex: 0,

		obj_bloodhound: null
	},
	init: function(newSettings) {
		indexActions.config = $.extend(indexActions.config, newSettings);
		indexActions.setup();
	},
	setup: function() {
		// get string type list from htmlCode obtained in index.php
		indexActions.config.string_typeCode = indexActions.config.string_typeCode.trim();
		indexActions.config.string_typeCode = indexActions.config.string_typeCode.replace(/\n/g, '');
		indexActions.config.string_typeCode = indexActions.config.string_typeCode.replace(/<\/p>/g, '');
		indexActions.config.string_type_list = indexActions.config.string_typeCode.split("<p>");
		indexActions.config.string_type_list.splice(0, 1); 			// remove empty element
	
		// initiate bloodhound obj
		indexActions.config.obj_bloodhound = new Bloodhound({
		    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
		    queryTokenizer: Bloodhound.tokenizers.whitespace,
		    remote: {
		        url: indexActions.config.ajax_getResult,
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

		indexActions.initiateTypeString();
		indexActions.config.form_search.on('submit', indexActions.submit_keywordForm);
		// stop typing if input element is focused, and resume once it's empty
		indexActions.config.form_search.on('focus', "input[name='keyword']", function() {
			indexActions.config.form_search.find("input[name='keyword']").attr('placeholder', '');
			indexActions.config.stopTypingFlag = true;
		});
		indexActions.config.form_search.on('change', "input[name='keyword']", function() {
			indexActions.config.stopTypingFlag = false;
			indexActions.initiateTypeString();
		});

		// implement typeahead
		indexActions.config.form_search.find("input[name='keyword']").typeahead(null, {
	        source: indexActions.config.obj_bloodhound,
	        limit: 'Infinity',
	        templates: {
	            suggestion: function (data) {
	                return '<div class="col-sm-6 col-md-6 col-lg-6 suggestion_item">' + data + '</p>';
	            }
	        }
	    }).on('typeahead:open', function() {
			$(document).find(".tt-open .tt-dataset").addClass('row');
			// $(document).find(".tt-menu").css("width", "105%");

			// if ($(window).width() > 767 && $(window).width() < 1200) {
			// 	$(document).find(".tt-menu").css("margin-top", "9%");
			// } else{
			// 	$(document).find(".tt-menu").css("margin-top", "35%");
			// }
	    });

	    // rescale trends and input if mobile screen is too small
		if ($(window).width() < 767) {
			indexActions.config.form_search.find("input[name='keyword']").css('background-color', '');
			// indexActions.config.form_search.find('.search_trends_cl').css('margin-top','17%');
		}

		// rescale main content to make sure the footer stays at the bottom
		var headerHeight = $('.home_page_wrap').height();
		$('.home_page_wrap').css('height', headerHeight + "px");
	},
	// perform type behaviour
	initiateTypeString: function() {
		if (indexActions.config.stopTypingFlag) { return; }

		var currentText = indexActions.config.form_search.find("input[name='keyword']").attr('placeholder');
		var index = currentText.length;
		var stringText = indexActions.config.string_type_list[indexActions.config.currentTextIndex];
		// remove the text and start again
		if (currentText.length == stringText.length) {
			if (indexActions.config.currentTextIndex == indexActions.config.string_type_list.length - 1) {
				indexActions.config.currentTextIndex = 0;
			} else {
				indexActions.config.currentTextIndex++;
			}
			stringText = indexActions.config.string_type_list[indexActions.config.currentTextIndex];
			currentText = '';
			index = 0;
		}
		currentText += stringText.charAt(index);
		indexActions.config.form_search.find("input[name='keyword']").attr('placeholder', currentText);

		// determine typespeed, or delay before wipe the string out and restart
		var speed = indexActions.config.typeSpeed;
		if (currentText.length == stringText.length) {
			speed = indexActions.config.backDelay;
		}

		setTimeout(indexActions.initiateTypeString, speed);
	},
	submit_keywordForm: function(event) {
	    event.preventDefault();
	    var keyword = $(event.currentTarget).find("input[name='keyword']").val();
	    if (keyword != '') {
	        window.location.href = "/result-page/?query=" + keyword;
	    } else {
	        window.location.href = "/result-page/";
	    }

	}
};