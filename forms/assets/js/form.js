var sMedia = sMedia || {};

(function ($) {
	$.fn.sizeChanged = function (handleFunction) {
		var element = this;
		var lastWidth = element.width();
		var lastHeight = element.height();

		setInterval(function () {
			if (lastWidth === element.width() && lastHeight === element.height())
				return;
			if (typeof (handleFunction) === 'function') {
				handleFunction({
					width: lastWidth,
					height: lastHeight
				}, {
					width: element.width(),
					height: element.height()
				});
				lastWidth = element.width();
				lastHeight = element.height();
			}
		}, 100);

		return element;
	};
}(jQuery));


$(function () {
	var form = {
		action: 'loaded',
		width : $('section#form-section div.body').outerWidth(),
		height: $('section#form-section div.body').outerHeight(),
		name  : $('title').html().replace('sMedia Form :: ', '')
	};

	window.parent.postMessage(form, '*');

	$('input[name="form"]').val(form.name);
	$('section#form-section div.body').sizeChanged(function () {
		if ($('section#form-section').css('display') === 'none') {
            return;
        }

		form = {
			action: 'resize',
			width : $('section#form-section div.body').outerWidth(),
			height: $('section#form-section div.body').outerHeight(),
			name  : $('title').html().replace('sMedia Form :: ', '')
		};

		if (form.width > 0 && form.height > 0) {
			window.parent.postMessage(form, '*');
		}
	});

	$('section#thank-you-section div.body').sizeChanged(function () {
		if ($('section#thank-you-section').css('display') === 'none') {
            return;
        }

		form = {
			action: 'resize',
			width : $('section#thank-you-section div.body').outerWidth(),
			height: $('section#thank-you-section div.body').outerHeight(),
			name  : $('title').html().replace('sMedia Form :: ', '')
		};

		if (form.width > 0 && form.height > 0) {
			window.parent.postMessage(form, '*');
		}
	});


	/*if ($('input[name="page_title"]').length == 0) {
        $('form').prepend("<input type='hidden' name='page_title' value='" + window.parent.document.title + "'>");
    }*/

	$('form').submit(function (e) {
		e.preventDefault();

		if (!$(this).valid()) {
			return false;
		}

		var isValid = true;

		// Validate Email
		// if (!validateEmail(document.getElementsByName('email_address')[0])) {
		// 	document.getElementsByName('email_address')[0].style.borderColor = "red";
		// 	isValid = false;
		// } else {
		// 	document.getElementsByName('email_address')[0].style.borderColor = '';
		// }

		// Validate Phone
		$('#phone_number').blur(function (e) {
			if (!validatePhone(document.getElementsById('phone_number'))) {
				document.getElementsById('phone_number').style.borderColor = "red";
				isValid = false;
			} else {
				document.getElementsById('phone_number').style.borderColor = "green";
			}
		});


		if (!isValid) {
			$('div.alerts').removeClass('hidden');
			return false;
		} else {
			$('div.alerts').addClass('hidden');
		}

		window.parent.postMessage({
			action: 'loading'
		}, '*');

		post_data = $(this).serialize();
		console.log(`post_data: ${post_data}`);

		$.ajax({
            type: "POST",
			url: "https://tm.smedia.ca/services/sm-ai-buttons.php",
            data: post_data,
            crossDomain: true
        })
        .done(function (data, textStatus, jqXHR) {
            console.log(`data=${data}`);
            if (data.success) {
				if(!data.redirect_url) {
					$('#thank-you-section').css('display', 'block');
				}
                $('#form-section').css('display', 'none');

                form = {
                    action: 'loaded',
                    width : $('section#thank-you-section div.body').outerWidth(),
                    height: $('section#thank-you-section div.body').outerHeight(),
                    name  : $('title').html().replace('sMedia Form :: ', '')
                };

                window.parent.postMessage(form, '*');
                window.parent.postMessage({
                    action: 'fillup',
					redirect_url: data.redirect_url,
                }, '*');

            } else {
                submission_error(data.message);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            submission_error(textStatus);
        })
        .always(function () {

        });

		return false;
	});

	var tys = $('#thank-you-section');
	var tysBtn = tys.find('#thankyou-close-btn');
	if(tysBtn.length == 0) {
		tysBtn = $('<button class="form-close-btn" id="thankyou-close-btn"></button>');
		tysBtn.appendTo(tys);
	}

	tysBtn.click(function () {
		window.parent.postMessage({
			action: 'thankyouClose',
		}, '*');
	});

	$('#form-close-btn').click(function () {
		window.parent.postMessage({
			action: 'close',
		}, '*');
	});

	sMedia.Form = {
		device: function (data) {
			$('body').removeClass('desktop');
			$('body').removeClass('mobile');
			$('body').addClass(data.device);
		},
		set_params: function (params) {
			$.each(params.data, function (key, value) {
				if (key === 'text_value' && !!value) {
					$('button.action-btn').html(value);
				}
				if (key === 'disclaimer' && value !== '') {
					$("div.security-label").after('<div class="disclaimer-text">' + value + '</div>');
					return;
				}
				if ($('input[name=' + key + ']').length > 0) {
					$('input[name=' + key + ']').val(value);
				} else {
					elem = document.createElement('input');
					elem.type = 'hidden';
					elem.name = key;
					elem.value = value;
					document.getElementsByTagName("form")[0].appendChild(elem);
				}
			});
		}
	};

	window.addEventListener("message", receiveMessage, false);

	function receiveMessage(event) {
		console.log("IFrame Message received");
		console.log(event.data);
		if (typeof sMedia.Form[event.data.action] === 'function') sMedia.Form[event.data.action](event.data);
	}

	function submission_error(error) {
		form = {
			action: 'loaded',
			width: $('section#form-section div.body').outerWidth(),
			height: $('section#form-section div.body').outerHeight(),
			name: $('title').html().replace('sMedia Form :: ', '')
		};

		window.parent.postMessage(form, '*');

		alert('Unable to submit. Error: ' + error);
	}

	/**
	 * Track form input start
	 */
	$(':input').focus(function () {
		var name = $('title').html().replace('sMedia Form :: ', '');
		if(window.aiform == void 0) {
            window.aiform = {};
		}
		if(window.aiform[name] == void 0) {
            window.aiform[name] = { started: false };
		}
		if(!window.aiform[name].started){
	        window.aiform[name].started = true;
			window.parent.postMessage({
				action: 'input_start',
				name  : name
			}, '*');
		}
	});

	/**
	 * Track form abandonment
	 */
	$(':input').blur(function () {
		form = {
			action: 'input_changed',
			status: null,
			field: $(this).attr('name')
		};

		if ($(this).val().length > 0) {
			form.status = 'Completed';
		} else {
			form.status = 'Skipped';
		}

		window.parent.postMessage(form, '*');
	});
});
