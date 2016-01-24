var tarotActions = {
	settings: {
		container_allCards: null,
		container_chosenCards: null,

		// no need to declare this
		cardHeight: null,
		cardWidth: null,
		cardData: null,
		blank_card: null,
		back_card: null,

		id: null,						// id of the dragging image
		originalPositionX: null, 		// original left position of the dragging image, uses to make sure original card is still in place
	},
	init: function(newSettings) {
		tarotActions.settings = $.extend(tarotActions.settings, newSettings);
		$.getJSON("data.json", function(data) {
			tarotActions.settings.cardData = data;
		}).done(function() {
			tarotActions.settings.blank_card = tarotActions.settings.cardData['metadata'].imgFolder + tarotActions.settings.cardData['metadata'].blankcard;
			tarotActions.settings.back_card = tarotActions.settings.cardData['metadata'].imgFolder + tarotActions.settings.cardData['metadata'].backcard;
			tarotActions.setup();
		});
	},
	setup: function() {
		tarotActions.formatLayout();
		// generate 22 face down cards
		tarotActions.generateAllCards();
		tarotActions.settings.container_allCards.parent().on('click', "[data-role='btn-reveal']", tarotActions.click_submitChosenCards);

		// define events needed to drag and drop from all cards to chosen cards
		tarotActions.settings.container_allCards.find('.img-deck').draggable({
			revert: 'invalid',
			start: tarotActions.dragstart_dragImage
		});
		tarotActions.settings.container_chosenCards.find('.droppable').droppable({
			accept: tarotActions.accept_chooseCard,
			drop: tarotActions.drop_chooseCard
		});

		// define events needed to drag and drop from chosen cards to all cards
		tarotActions.settings.container_allCards.parent().droppable({
			drop: tarotActions.drop_unchooseCard
		});
	},
	generateAllCards: function() {
		// calculate overlapping = (width of container - width of the last card) / 20
		var cardAccumulatePosition = ( tarotActions.settings.container_allCards.width() - tarotActions.settings.cardWidth ) / 21;

		// find starting coordinate of the all-cards div
		var rect = tarotActions.settings.container_allCards.offset();
		var start = rect.left - rect.left * 3;

		// generate randomized card order
		var arr = [];
		for (var i = 0; i < 22; i++) { arr.push(i); }
		arr = tarotActions.shuffleArray(arr);
		for (var i = 0; i < 22; i++) {
			tarotActions.settings.container_allCards.append("<img draggable='true' class='img-responsive img-deck img-card' style='left: " + (start + cardAccumulatePosition * i) + "px; width: " + tarotActions.settings.cardWidth + "px;' src='" + tarotActions.settings.back_card + "' data-id='" + arr[i] + "'/>");
		}
	},
	shuffleArray: function(arr) {
		for(var j, x, i = arr.length; i; j = parseInt(Math.random() * i), x = arr[--i], arr[i] = arr[j], arr[j] = x);
		return arr;
	},
	formatLayout: function() {
		var windowHeight = window.innerHeight;
		// card height = 35% window height
		tarotActions.settings.cardHeight = windowHeight * 35 / 100;
		$('body').css('margin-bottom', tarotActions.settings.cardHeight + "px");
		$(document).find(".footer").css('height', tarotActions.settings.cardHeight + "px");
		$(document).find(".img-card").css('height', tarotActions.settings.cardHeight + "px");
		tarotActions.settings.cardWidth = tarotActions.settings.container_chosenCards.find('img:first-child').width();
		tarotActions.settings.container_allCards.parent().css('height', tarotActions.settings.cardHeight + "px");

		// initially disable submit button
		tarotActions.settings.container_allCards.parent().find("[data-role='btn-reveal']").prop('disabled', true);
	},
	click_submitChosenCards: function() {
		// disable all draggable events
		tarotActions.settings.container_chosenCards.find('.droppable').droppable('destroy');
		tarotActions.settings.container_chosenCards.find('img').draggable('destroy');
		tarotActions.settings.container_allCards.find('.img-deck').draggable('destroy');
		tarotActions.settings.container_allCards.parent().droppable('destroy');

		var pastContainerObj = tarotActions.settings.container_chosenCards.find("[data-role='container-past']");
		var presentContainerObj = tarotActions.settings.container_chosenCards.find("[data-role='container-present']");
		var futureContainerObj = tarotActions.settings.container_chosenCards.find("[data-role='container-future']");

		// reveal the cards and messages
		// reveal past card
		var rand = Math.random();
		var isReversed = (rand <= 0.5) ? false: true;
		var pastData = tarotActions.settings.cardData[pastContainerObj.find('img').attr('data-id')];
		tarotActions.displayChosenCard(pastContainerObj, pastData, isReversed);

		// reveal present card
		rand = Math.random();
		isReversed = (rand <= 0.5) ? false: true;
		var presentData = tarotActions.settings.cardData[presentContainerObj.find('img').attr('data-id')];
		tarotActions.displayChosenCard(presentContainerObj, presentData, isReversed);

		// reveal future card
		rand = Math.random();
		isReversed = (rand <= 0.5) ? false: true;
		var futureData = tarotActions.settings.cardData[futureContainerObj.find('img').attr('data-id')];
		tarotActions.displayChosenCard(futureContainerObj, futureData, isReversed);
	},
	dragstart_dragImage: function(event, ui) {
		tarotActions.settings.id = $(event.target).attr('data-id');
		tarotActions.settings.originalPositionX = $(event.target).position().left;
	},
	accept_chooseCard: function(draggable) {
		if ( (typeof $(this).find('img').attr('data-id') !== typeof undefined) && ($(this).find('img').attr('data-id') !== false) ) {
			return false;
		}
		if ($(draggable).hasClass('img-deck')) { return true; }
		return false;
	},
	drop_chooseCard: function(event, ui) {
		event.preventDefault();
		console.log(ui.helper.position());

		var id = tarotActions.settings.id;
		$(this).find('img')
			.attr('data-id', id)
			.attr('src', tarotActions.settings.back_card)
			.attr('draggable', 'true')
			.draggable({
				revert: 'invalid',
				start: tarotActions.dragstart_dragImage
			});
		tarotActions.settings.container_allCards.find('img[data-id="' + id + '"]')
			.removeAttr('style')
			.attr('style', "left: " + tarotActions.settings.originalPositionX + "px; width: " + tarotActions.settings.cardWidth + "px;")
			.hide();

		// enable submit button if needed
		var chosenCount = tarotActions.settings.container_chosenCards.find("img[draggable='true']").length;
		if (chosenCount == 3) {
			tarotActions.settings.container_allCards.parent().find("[data-role='btn-reveal']").prop('disabled', false);
		}
	},
	drop_unchooseCard: function(event) {
		event.preventDefault();

		console.log($(this));

		var id = tarotActions.settings.id;
		tarotActions.settings.container_chosenCards.find('img[data-id="' + id + '"]')
			.removeAttr('data-id')
			.attr('src', tarotActions.settings.blank_card)
			.removeAttr('style')
			.attr('style', "height: " + tarotActions.settings.cardHeight + "px;")
			.removeAttr('draggable')
			.draggable("destroy");
		tarotActions.settings.container_allCards.find('img[data-id="' + id + '"]').show();

		// disable submit button if needed
		var chosenCount = tarotActions.settings.container_chosenCards.find("img[draggable='true']").length;
		if (chosenCount < 3) {
			tarotActions.settings.container_allCards.parent().find("[data-role='btn-reveal']").prop('disabled', true);
		}
	},
	displayChosenCard: function(containerObj, data, isReversed) {
		var metaData = tarotActions.settings.cardData['metadata'];
		containerObj.find('img').attr('src', metaData.imgFolder + data.img);
		if (isReversed == true) {
			containerObj.find('img').addClass('reverse');
			containerObj.find("[data-role='card-message']").html(data.messages.past['reverse']);
		} else {
			containerObj.find("[data-role='card-message']").html(data.messages.past['normal']);
		}
	}
};
