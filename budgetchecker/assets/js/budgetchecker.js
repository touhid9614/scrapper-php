
(function ($) {

	var current = 0;
	var dealers = null;
	var st_even = false;
	var yst_even = false;
	var cr_even = false;
	var ycr_even = false;

	var on01_reg = [];
	var on01_you = [];
	var custom = [];
	var custom_you = [];
	var ranged = [];
	var ranged_you = [];

	var sort_by = function (field, reverse, primer) {
		var key = primer ?
			function (x) { return primer(x[field]); } :
			function (x) { return x[field]; };

		reverse = [-1, 1][+!!reverse];

		return function (a, b) {
			return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
		};
	};

	var yheading = '<tr>\n' +
		'<th>Name</th>\n' +
		'<th>ID</th>\n' +
		'<th>Budget</th>\n' +
		'<th>Spent</th>\n' +
		'<th>Projected</th>\n' +
		'<th>In Range</th>\n' +
		'<th>ADB</th>\n' +
		'<th>Diff. ADB</th>\n' +
		'<th>Spent Yest.</th>\n' +
		'<th>Spent Today</th>\n' +
		'</tr>\n';

	var heading = '<tr>\n' +
		'<th>Name</th>\n' +
		'<th>ID</th>\n' +
		'<th>Budget</th>\n' +
		'<th>Spent</th>\n' +
		'<th>Projected</th>\n' +
		'<th>In Range</th>\n' +
		'<th>ADB</th>\n' +
		'<th>Diff. ADB</th>\n' +
		'<th>Spent Yest.</th>\n' +
		'<th>Spent Today</th>\n' +
		'<th>B.R(%)</th>\n' +
		'<th>LB.R(%)</th>\n' +
		'<th>C/E</th>\n' +
		'<th>LC/E</th>\n' +
		'</tr>\n';
	var colspan = 16;
	var ycolspan = 12;

	function load_dealers() {
		$('.on1st').html(heading);
		$('.youtubeon1st').html(yheading);
		$('.custom').html(heading);
		$('.ranged').html(heading);
		$('.customyoutube').html(yheading);
		$('.rangedyoutube').html(yheading);

		show_progress('Loading dealerships . . .');

		url = 'ajax.php?act=get-dealers';

		var request = $.ajax({
			cache: false,
			url: url
		});

		request.done(function (data) {
			if (typeof (data.error) != "undefined" && data.error !== null) {
				alert(data.error.message);
			}
			else {
				dealers = data;
				current = 0;
				eval_dealer();
			}
		});

		request.fail(function (jqXHR, textStatus) {
			alert('Unable to load data, please refresh the page');
		});
	}

	function eval_dealer() {
		show_progress(dealers[current] + ' ' + current + ' of ' + dealers.length);

		url = 'ajax.php?act=eval-dealer&dealership=' + escape(dealers[current]);

		var request = $.ajax({
			cache: false,
			url: url
		});

		request.done(function (data) {
			if (typeof (data.error) != "undefined" && data.error !== null) {
				hide_progress();
				alert(data.error.message);
			}
			else {
				console.log(data);
				if (data.budget > 0 || data.fb_budget > 0) {
					if (data.custom && !data.ranged) {
						html = eval2html(data, cr_even);
						cr_even = !cr_even;
						$('.custom').append(html);
						custom.push(data);
					}
					else if (data.custom && data.ranged) {
						html = eval2html(data, cr_even);
						cr_even = !cr_even;
						$('.ranged').append(html);
						ranged.push(data);
					}
					else {
						html = eval2html(data, st_even);
						st_even = !st_even;
						$('.on1st').append(html);
						on01_reg.push(data);
					}
					$('#' + data.name + "_" + data.advert_type).click(function () {
						toggle_accordion(this);
					});

					$('#' + data.name + "_" + data.advert_type + "_update_budget").click(function () {
						update_budget(this);
					});
				}

				if (typeof (data.youtube) != "undefined" && data.youtube !== null) {
					data = data.youtube;

					if (data.custom && !data.ranged) {
						html = eval2html(data, ycr_even);
						ycr_even = !ycr_even;
						$('.customyoutube').append(html);
						custom_you.push(data);
					}
					else if (data.custom && data.ranged) {
						html = eval2html(data, ycr_even);
						ycr_even = !ycr_even;
						$('.rangedyoutube').append(html);
						ranged_you.push(data);
					}
					else {
						html = eval2html(data, yst_even);
						yst_even = !yst_even;
						$('.youtubeon1st').append(html);
						on01_you.push(data);
					}
					$('#' + data.name + "_" + data.advert_type).click(function () {
						toggle_accordion(this);
					});

					$('#' + data.name + "_" + data.advert_type + "_update_budget").click(function () {
						update_budget(this);
					});
				}

				current++;
				if (current < dealers.length) { eval_dealer(); }
				else { hide_progress(); sort_data(); }
			}
		});

		request.error(function (jqXHR, textStatus, message) {
			hide_progress();
			$('.error-details').html(jqXHR.responseText);
			$('.error-details').show();
			alert('Unable to load data, please refresh the page\nError Message: ' + message);
		});
	}

	function toggle_accordion(sender) {
		id = '#' + $(sender).attr('id') + '_container';
		tid = $(id).attr('data-target');
		if ($(id).hasClass('collapse')) {
			$(id).removeClass('collapse');
			$(tid).removeClass('collapse');
		}
		else {
			$(id).addClass('collapse');
			$(tid).addClass('collapse');
		}
	}

	function update_budget(sender) {
		var tid = $(sender).attr('data-target');
		var data = $(tid).serialize();

		waitingDialog.show('Saving...', { dialogSize: 'sm', progressType: 'info' });

		url = 'ajax.php';

		var request = $.ajax({
			method: "POST",
			cache: false,
			url: url,
			data: data
		});

		request.done(function (data) {
			if (data.code === 202) {
				var ret_message = '';
				$.each(data.changed, function (index, budget) {
					if (budget.success === true) {
						$("input[type=hidden][name='current_amounts[" + budget.campaign_name + "]']").val(budget.amount);
					}
					else {
						ret_message += budget.campaign_name + '\n';
						$("input[name='new_amounts[" + budget.campaign_name + "]']").val(budget.old_amount);
					}
				});

				if (ret_message !== '') {
					alert('Budget for following campaigns could not be changed\n' + ret_message);
				}
			}
		})
			.error(function (jqXHR, textStatus, message) {
				waitingDialog.hide();
				$('.error-details').html(jqXHR.responseText);
				$('.error-details').show();
			})
			.always(function () {
				waitingDialog.hide();
			});
	}

	function round(num) {
		return Math.round(num * 100) / 100;
	}

	function eval2html(data, iseven) {
		html = '';
		html += '<td>' + data.display_name + '</td>\n';
		html += '<td>' + data.customer_id + '</td>\n';
		html += '<td>' + round(data.budget) + '</td>\n';
		html += '<td>' + round(data.spent) + '</td>\n';
		html += '<td>' + round(data.projected) + '</td>\n';
		html += '<td class="spent_' + data.status + '" title="' + data.status + '">';
		html += data.offset;
		html += '</td>\n';
		html += '<td>' + round(data.adjustment) + '</td>\n';
		html += '<td>' + data.y_adb + '</td>\n';

		//new code for yesterday/today spent
		html += '<td>\n';
		if (typeof data.yesterday_spent !== 'undefined') html += round(data.yesterday_spent);
		html += '</td>\n';
		html += '<td>\n';
		if (typeof data.today_spent !== 'undefined') html += round(data.today_spent);
		html += '</td>\n';
		if (data.advert_type === 'regular') {
			html += '<td>\n';
			html += (data.bounce_rate !== null) ? Math.round(data.bounce_rate * 100) : 'N/A';
			html += '</td>\n';
			html += '<td>\n';
			html += (data.bounce_rate_pp !== null) ? Math.round(data.bounce_rate_pp * 100) : 'N/A';
			html += '</td>\n';
			html += '<td>\n';
			html += data.cost_per_engaged_user;
			html += '</td>\n';
			html += '<td>\n';
			html += data.cost_per_engaged_user_pp;
			html += '</td>\n';
		}

		if (iseven) {
			html = '<tr id="' + data.name + "_" + data.advert_type + '" class="main-row even">\n' + html;
		} else {
			html = '<tr id="' + data.name + "_" + data.advert_type + '" class="main-row">\n' + html;
		}

		html += '</tr>\n';

		span = data.advert_type === 'regular' ? colspan : ycolspan;

		html += '<tr id="' + data.name + "_" + data.advert_type + '_container" class="accordion-toggle collapse" data-target=".' + data.name + "_" + data.advert_type + '_details">\n';
		html += '<td colspan="' + span + '" class="hiddenRow" style="padding: 0px; border: none;">\n';
		html += '<div class="accordion-body collapse ' + data.name + "_" + data.advert_type + '_details">\n';
		html += '<form id="' + data.name + "_" + data.advert_type + '_campaigns">\n';
		html += '<input type="hidden" name="act" value="update-budget"/>\n';
		html += '<input type="hidden" name="dealership" value="' + data.name + '"/>\n';
		html += '<table class="table table-condensed">\n';
		html += '<tr>\n';
		html += '<th>Campaign Name</th>\n';
		html += '<th>Budget</th>\n';
		html += '<th>Spent Today</th>\n';
		html += '<th>Spent Yesterday</th>\n';
		if (data.advert_type === 'regular') {
			html += '<th>BR</th>\n';
			html += '<th>LBR</th>\n';
			html += '<th>C/E</th>\n';
			html += '<th>LC/E</th>\n';
		}
		html += '</tr>\n';

		$.each(data.campaigns, function (name, campaign) {
			html += '<tr>\n';
			html += '<td>' + name + '</td>\n';
			html += '<td>\n';
			if (typeof campaign.daily_budget !== 'undefined') {
				html += '<input type="hidden" name="campaign_ids[' + name + ']" value="' + campaign.campaign_id + '"/>\n';
				html += '<input type="hidden" name="budget_ids[' + name + ']" value="' + campaign.budget_id + '"/>\n';
				html += '<input type="hidden" name="current_amounts[' + name + ']" value="' + campaign.daily_budget + '"/>\n';
				html += '<input type="number" name="new_amounts[' + name + ']" value="' + campaign.daily_budget + '" min="0" step="any" class="budget-modifier-input" />\n';
			}
			html += '</td>\n';
			html += '<td>' + campaign.spent_today + '</td>\n';
			html += '<td>' + campaign.spent_yesterday + '</td>\n';
			if (data.advert_type === 'regular') {
				html += '<td>\n';
				html += (campaign.bounce_rate !== null) ? Math.round(campaign.bounce_rate * 100) : 'N/A';
				html += '</td>\n';
				html += '<td>\n';
				html += (campaign.bounce_rate_pp !== null) ? Math.round(campaign.bounce_rate_pp * 100) : 'N/A';
				html += '</td>\n';
				html += '<td>' + campaign.cost_per_engaged_user + '</td>\n';
				html += '<td>' + campaign.cost_per_engaged_user_pp + '</td>\n';
			}
			html += '</tr>';
		});

		html += '</table>\n';
		html += '<div class="clearfix">\n';
		html += '<button id="' + data.name + "_" + data.advert_type + '_update_budget" data-target="#' + data.name + "_" + data.advert_type + '_campaigns" type="button" class="btn btn-primary pull-right">Update Budget</button>\n';
		html += '</div>\n';
		html += '</form>\n';
		html += '</div>\n';
		html += '</td>\n';
		html += '</tr>\n';

		return html;
	}

	function gup(name) {
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regexS = "[\\?&]" + name + "=([^&#]*)";
		var regex = new RegExp(regexS);
		var results = regex.exec(window.location.href);
		if (results == null)
			return '';
		else
			return results[1];
	}

	function show_progress(message) {
		//$('.loading-dialog-div').css('display', 'block');
		$('.loading-dialog-animation-div').css('display', 'block');
		$('.loading-dialog-animation-div').html(message);

		if (message == null) {
			$('.loading-dialog-animation-div').width(0);
			$('.loading-dialog-animation-div').css('padding-right', '0px');
		} else {
			$('.loading-dialog-animation-div').width(200);
			$('.loading-dialog-animation-div').css('padding-right', '15px');
		}

		align_progress_dialog();
	}

	function hide_progress() {
		$('.loading-dialog-div').css('display', 'none');
		$('.loading-dialog-animation-div').css('display', 'none');
	}

	function align_progress_dialog() {
		var viewport_height = $(window).innerHeight();
		var viewport_width = $(window).innerWidth();

		//$('.loading-dialog-animation-div').css('left', parseInt((viewport_width - $('.loading-dialog-animation-div').outerWidth())/2) + 'px');
		//$('.loading-dialog-animation-div').css('top', parseInt((viewport_height - $('.loading-dialog-animation-div').outerHeight())/2) + 'px');
		$('.loading-dialog-animation-div').css('left', (viewport_width - $('.loading-dialog-animation-div').outerWidth()) + 'px');
		$('.loading-dialog-animation-div').css('top', (viewport_height - $('.loading-dialog-animation-div').outerHeight()) + 'px');
	}

	function sort_data() {
		render_on(on01_reg, '.on1st', 'regular');
		render_on(on01_you, '.youtubeon1st', 'youtube');
		render_on(custom, '.custom', 'regular');
		render_on(custom_you, '.customyoutube', 'youtube');
		render_on(ranged, '.ranged', 'regular');
		render_on(ranged_you, '.rangedyoutube', 'youtube');
	}

	function render_on(data, div, advert_type) {
		if (advert_type === 'regular')
			$(div).html(heading);
		else
			$(div).html(yheading);

		var sort = $('#sort-by').val();
		var desc = true;
		if (sort !== 'name') desc = false;
		var is_even = false;

		var primer = function (a) { return a; };

		if (sort === 'y_adb') primer = function (a) { return Math.abs(a); };
		if (sort === 'cost_per_engaged_user' ||
			sort === 'cost_per_engaged_user_pp' ||
			sort === 'bounce_rate' ||
			sort === 'bounce_rate_pp') primer = function (a) {
				if (advert_type === 'youtube') return 0;
				if (a === 'N/A') return -1;
				if (a === 'Inf') return 99999;
				return a;
			};

		data.sort(sort_by(sort, desc, primer));

		$.each(data, function (i, d) {
			var html = eval2html(d, is_even);
			is_even = !is_even;
			$(div).append(html);
			$('#' + d.name + "_" + d.advert_type).click(function () {
				toggle_accordion(this);
			});

			$('#' + d.name + "_" + d.advert_type + "_update_budget").click(function () {
				update_budget(this);
			});
		});
	}

	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		var expires = "expires=" + d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}

	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') c = c.substring(1);
			if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
		}
		return "";
	}

	$(document).ready(function () {
		$('#horizontalTab').easyResponsiveTabs({
			type: 'default', //Types: default, vertical, accordion
			width: 'auto', //auto or any width like 600px
			fit: true,   // 100% fit in a container
			closed: 'accordion', // Start closed if in accordion view
			activate: function (event) { // Callback function if tab is switched
				var tab = $(this);

				var tabname = tab.text();
			}
		});

		var selected = getCookie('budgetchecker_sort_by');
		if (selected == '') selected = 'name';

		$("#sort-by option").filter(function () {
			return $(this).val() == selected;
		}).prop('selected', true);

		$('#sort-by').change(function () {
			sort_data();
			setCookie('budgetchecker_sort_by', $('#sort-by').val(), 365);
		});

		$(window).trigger('resize');

		load_dealers();
	});

	$(window).resize(function () {
		var left = parseInt(($('.page').position().left + $('.page').width()) - $('.sort-by-container').width()) + 'px';
		$('.sort-by-container').css('left', left);
	});

})(jQuery);
