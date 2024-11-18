/* jshint -W119 */
(function ($) {
	var carlist;

	$(document).ready(function ($) {
		$('#insert-button').click(function () {
			year = $('#year-field').val();
			make = $('#make-field').val();
			model = $('#model-field').val();

			if (!year || !make || !model) {
				alert('Year, Make and Model is required');
				return;
			}

			$('#insert-button').attr("disabled", true);

			//else insert in the database
			$.getJSON(`ajax.php?act=add-carlist&year=${escape(year)}&make=${escape(make)}&model=${escape(model)}&t=${$.now()}`, function (data) {
				if (data.error) {
					alert(data.error);
				} else {
					remove_unmatched_titles(data);
				}

				$('#insert-button').removeAttr("disabled");
			});
		});

		//initialize the application
		//**********************************************************************
		initialize_application();
	});

	$(window).resize(function () {
		resizeElements();
	});

	function remove_unmatched_titles(ids) {
		$.each(ids, function (i, id) {
			$(`#um-${id}`).remove();
		});
	}

	function insert_car_item(year, make, model) {
		if ($('#carlist').find(`[data-value='${year}']`).length == 0) {
			year_list = `<li data-value='${year}'>${year}`;
			year_list += `<ul id='carlist-${year}'></ul>`;
			year_list += "</li>";

			$('#carlist').append(year_list);
			$('#carlist').LLItemAdded($('#carlist').find(`[data-value='${year}']`));
		}

		if ($('#carlist-' + year).find(`[data-value='${year}_:_${make}']`).length == 0) {
			make_list = `<li data-value='${year}_:_${make}'>${make}`;
			make_list += `<ul id='carlist-${year}-${make}'></ul>`;
			make_list += "</li>";

			$(`#carlist-${year}`).append(make_list);
			$('#carlist').LLItemAdded($(`#carlist-${year}`).find(`[data-value='${year}_:_${make}']`));
		}

		if ($(`#carlist-${year}-${make}`).find(`[data-value='${year}_:_${make}_:_${model}']`).length == 0) {
			model_list = `<li data-value='${year}_:_${make}_:_${model}'>${model}</li>`;
			$(`#carlist-${year}-${make}`).append(model_list);
			$('#carlist').LLItemAdded($(`#carlist-${year}-${make}`).find(`[data-value='${year}_:_${make}_:_${model}']`));
		}
	}

	function initialize_application() {
		resizeElements();
		load_unmatched_titles();
	}

	function resizeElements() {
		var height = $(window).height();
		var content_height = height - 65;
		var inner_height = content_height - 60 - $('h3').height();

		$('.left-container').height(content_height);
		$('.right-container').height(content_height);
		$('.left-inner-container').height(inner_height);
		$('.top-container').height(inner_height - 110);
		$('.bottom-container').height(80);
	}

	function load_unmatched_titles() {
		$('.loading-text').html('Loading unmatched...');
		$.getJSON(`ajax.php?act=get-unmatched&t=${$.now()}`, function (data) {
			var items = [];

			$.each(data, function (key, val) {
				items.push(`<li id='um-${val.id}' class='title-list-item' data-url='${val.url}' data-title='${val.title}'>${val.title}</li>`);
			});

			$("<ul/>", {
				"class": "unmatched-titles",
				html: items.join("")
			}).appendTo(".left-inner-container");

			$('.title-list-item').click(function () {

				url = $(this).attr('data-url');
				title = $(this).attr('data-title');

				var re = new RegExp("([0-9]{4}) ([^ ]+) ([^ ]*)");
				matched = re.exec(title);

				if (matched.length > 1) $('#year-field').val(matched[1]);
				else $('#year-field').val('');
				if (matched.length > 2) $('#make-field').val(matched[2]);
				else $('#make-field').val('');
				if (matched.length > 3) $('#model-field').val(matched[3]);
				else $('#model-field').val('');

				$('#car-details').attr('src', url);
			});

			$('.overlay').css('display', 'none');
		});
	}
})(jQuery);