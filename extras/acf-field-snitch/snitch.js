jQuery(function($) {
	var prevInit = false;

	var initialize = function() {
		listenKeyboard();
	};

	var listenKeyboard = function() {

    /*
		var timesHit = 0;
		var timesTimer = null;

		$('body').on('keydown', function(ev) {

			if(ev.keyCode !== 27) return;

			timesHit++;

			clearTimeout(timesTimer);
			timesTimer = window.setTimeout(function() {
				timesHit = 0;
			}, 250);

			if(timesHit === 2) {
				toggleSnitch();
				timesHit = 0;
			}
		});
		*/

		toggleSnitch();

	};

	var toggleSnitch = function() {
		$('body').toggleClass('acf-snitch-on');

		if(prevInit) return;

		addSnitchInfo();
		//enableCopySnitchToClipboard();
		prevInit = true;
	};

	var addSnitchInfo = function() {
		$('[data-name]').each(function() {
			var box = $('<div class="acf-snitch"></div>');

			if(!$(this).data('name').length) return;

			var fieldName = $('<span class="field field_name">').text($(this).data('name'));
			box.append(fieldName);

			box.append($('<span>').text(' '));

			var fieldKey = $('<span class="field field_key">').text($(this).data('key'));
			box.append(fieldKey);

			if($(this).is('tr')) box.addClass('full-w').prependTo($(this).children('td').last());
			else if($(this).hasClass('sub_field')) box.addClass('full-w').prependTo($(this));
			else box.prependTo($(this));
		});

		$('[data-layout]').each(function() {
			var box = $('<div class="acf-snitch"></div>');
			var field = $('<span class="field row_layout">').text($(this).data('layout'));
			field.appendTo(box);
			box.prependTo($(this).find('.acf-fc-layout-handle'));
		});
	};

	initialize();
});