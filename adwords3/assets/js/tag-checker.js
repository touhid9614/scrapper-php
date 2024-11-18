/* jshint -W119 */
(function ($) {
	var current = 0;
	var dealerships;
	var odd = true;

	$(document).ready(function ($) {
		load_dealerships();
	});

	function load_dealerships() {
		$('.loading-text').html('Loading dealerships...');
		$.getJSON(`ajax.php?act=get-dealerships&t=${$.now()}`, function (data) {
			dealerships = data;
			check_dealership();
		});
	}

	function check_dealership() {
		if (current < dealerships.length) {
			$('.loading-text').html(`Checking ${current + 1} of ${dealerships.length}`);

			$.getJSON(`ajax.php?act=check-dealership&name=${dealerships[current].name}&t=${$.now()}`, function (data) {
				var to_write = '';

				$.each(data.urls, function (domain, details) {
					to_write += '<tr class="';
					if (odd) to_write += 'odd';
					else to_write += 'even';

					odd = !odd;
					to_write += '">';
					to_write += '<td>';
					to_write += data.name;
					to_write += '</td>';
					to_write += '<td>';
					to_write += domain;
					to_write += '</td>';
                    to_write += '<td>';

					if (details.tag == -1) to_write += '<div class="noclass" title="Not Configured"></div>';
					if (details.tag == 0) to_write += '<div class="unclass" title="Unknown"></div>';
					if (details.tag == 1) to_write += '<div class="yesclass" title="Configured"></div>';
					to_write += '</td>';

					to_write += '<td>';
					if (details.banner == -1) to_write += '<div class="noclass" title="Not Configured"></div>';
					if (details.banner == 0) to_write += '<div class="unclass" title="Unknown"></div>';
					if (details.banner == 1) to_write += '<div class="yesclass" title="Configured"></div>';
					to_write += '</td>';

					to_write += '<td>';
					if (details.phone == -1) to_write += '<div class="noclass" title="Not Configured"></div>';
					if (details.phone == 0) to_write += '<div class="unclass" title="Unknown"></div>';
					if (details.phone == 1) to_write += '<div class="yesclass" title="Configured"></div>';
					to_write += '</td>';

					to_write += '<td>';
					if (details.conv == -1) to_write += '<div class="noclass" title="Not Configured"></div>';
					if (details.conv == 0) to_write += '<div class="unclass" title="Unknown"></div>';
					if (details.conv == 1) to_write += '<div class="yesclass" title="Configured"></div>';
					to_write += '</td>';

					to_write += "</tr>\n";
				});

				$('.list-body').append(to_write);

				check_dealership();
			});

			current++;
		} else {
			$('.overlay').css('display', 'none');
		}
	}
})(jQuery);