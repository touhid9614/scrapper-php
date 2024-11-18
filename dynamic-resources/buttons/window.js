/*jshint -W119*/
window.sMedia = sMedia || {};

sMedia.ready = function (callback) {
	window.sMedia.onready = callback;
};

function sMedia_prepare_window($) {
	if (window.sMedia.WindowReady) {
		return;
	}

	window.sMedia.WindowReady = true;
	window.sMedia.Window =
	{
		is_open: false,
		initialized: false,
		params: null,

		init: function () {
			var html_content =
			`<div id="smedia-window-overlay" style="display:none"></div>
			<div id="smedia-window-container" scrolling="no" style="display:none">
				<iframe id="smedia-window-frame" scrolling="no" src="https://tm.smedia.ca/adwords3/templates/balls.svg"></iframe>
				<div id="smedia-loading-spinner">
					<img src="https://tm.smedia.ca/adwords3/templates/balls.svg" />
				</div>
			</div>`;
			var smedia_temp_div = document.createElement('div');
			smedia_temp_div.innerHTML = html_content;
			var smedia_form_elements = smedia_temp_div.childNodes;
			document.getElementsByTagName("body")[0].appendChild(smedia_form_elements[0]);
			document.getElementsByTagName("body")[0].appendChild(smedia_form_elements[1]);

			$('#smedia-window-overlay').click(function () {
				sMedia.Window.close();
			});

			this.initialized = true;

			if (typeof sMedia.onready === 'function') {
				sMedia.onready();
			}
		},

		set_params: function (params) {
			this.params = params;
		},

		loading: function () {
			$('#smedia-window-frame').hide();
			$('#smedia-loading-spinner').show();
			this.resize_container(36, 36);
		},

		loaded: function (form) {
			this.resize(form);

			try {
				$(window).resize();
			} catch (error) {
				console.error(error);
			}

			$('#smedia-loading-spinner').hide();
			$('#smedia-window-frame').show();
			console.log("Setting Params");
			console.log(this.params);
			$('#smedia-window-frame')[0].contentWindow.postMessage({ action: 'set_params', 'data': this.params }, '*');
		},

		open: function (url) {
			if (!this.initialized) {
				this.init();
			}

			if (this.is_open) {
				return;
			}

			$('#smedia-window-overlay').css('display', 'block');
			$('#smedia-window-container').css('display', 'inline-block');
			this.loading();
			$('#smedia-window-frame').attr('src', url);
			is_open = true;
		},

		resize_container: function (width, height) {
			$('#smedia-window-container').width(width);
			$('#smedia-window-container').height(height);
			$('#smedia-window-container').css('overflow-y', 'hidden');

			if ($('#smedia-window-container').height() > $(window).height()) {
				$('#smedia-window-container').height($(window).height());
				$('#smedia-window-container').css('overflow-y', 'auto');
			}

			$('#smedia-window-container').css('margin-left', (($('#smedia-window-container').outerWidth() / 2) * -1) + 'px');
			$('#smedia-window-container').css('margin-top', (($('#smedia-window-container').outerHeight() / 2) * -1) + 'px');
		},

		resize: function (form) {
			$('#smedia-window-frame').width(form.width);
			$('#smedia-window-frame').height(form.height);
			this.resize_container(form.width, form.height);
		},

		close: function () {
			$('#smedia-window-overlay').css('display', 'none');
			$('#smedia-window-container').css('display', 'none');
			is_open = false;
		},

		fillup: function () {
			ga('smedia_analytics_tracker.send',
				{
					hitType: 'event',
					eventCategory: 'Form Fillup',
					eventAction: 'AI Form',
					nonInteraction: true
				});
		},

		input_changed: function (data) {
			ga('smedia_analytics_tracker.send',
				{
					hitType: 'event',
					eventCategory: 'Input Tracking',
					eventAction: data.status,
					eventLabel: data.field,
					nonInteraction: true
				});
		}
	};

	window.sMedia.Window.init();

	window.addEventListener("message", receiveMessage, false);

	function receiveMessage(event) {
		// console.log("Main Window Message received");
		// console.log(event.data);

		if (typeof sMedia.Window[event.data.action] === 'function') {
			sMedia.Window[event.data.action](event.data);
		}
	}

	$(window).resize(function () {
		$('#smedia-window-frame')[0].contentWindow.postMessage({ action: 'device', 'device': $(window).width() >= 860 ? 'desktop' : 'mobile' }, '*');
	});
}

window.confirmjQueryLoaded(function ($) {
	//Initiate window
	sMedia_prepare_window($);
});
