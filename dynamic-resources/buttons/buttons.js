/*jshint -W004*/
/*jshint -W038*/
/*jshint -W069*/
/*jshint -W104*/
/*jshint -W119*/
window.sMedia = sMedia || {};

function sMedia_prepare_button($) {
	if (window.sMedia.ButtonReady) {
		return;
	}

	window.sMedia.ButtonReady = true;

	window.sMedia.Url = {
		getQueryByName: function (name, url) {
			if (!url) {
				url = window.location.href;
			}

			name = name.replace(/[\[\]]/g, "\\$&");
			var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
				results = regex.exec(url);

			if (!results) {
				return null;
			}

			if (!results[2]) {
				return '';
			}

			return decodeURIComponent(results[2].replace(/\+/g, " "));
		},

		query: function (name, def_val) {
			var retval = this.getQueryByName(name, this.get());

			return retval !== null ? retval : def_val;
		},

		get: function () {
			return document.location.href;
		}
	};

	window.sMedia.ButtonCookie =
	{
		get: function (cname) {
			var search = cname + "=";
			var returnvalue = "";

			if (document.cookie.length > 0) {
				offset = document.cookie.indexOf(search);
				// if cookie exists
				if (offset != -1) {
					offset += search.length;
					// set index of beginning of value
					end = document.cookie.indexOf(";", offset);
					// set index of end of cookie value
					if (end == -1) {
						end = document.cookie.length;
					}

					returnvalue = unescape(document.cookie.substring(offset, end));
				}
			}

			return returnvalue;

            /*
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');

            for (var i = 0; i <ca.length; i++)
            {
                var c = ca[i];
                while (c.charAt(0) === ' ')
                {
                    c = c.substring(1);
                }

                if (c.indexOf(name) === 0)
                {
                    return c.substring(name.length, c.length);
                }
            }

            return "";  */
		}
	};

	window.sMedia.RegExp =
	{
		p2j: function (str) {
			if (str[0] === '/') {
				str = str.substr(1);
			}

			if (str.lastIndexOf('/') !== -1) {
				str = str.substr(0, str.lastIndexOf('/'));
			}

			return str;
		},

		make: function (str, mod) {
			var regex = null;

			if (mod !== '') {
				regex = new RegExp(str, mod);
			}
			else {
				regex = new RegExp(str);
			}

			return regex;
		},

		pmake: function (str) {
			return this.make(this.p2j(str), 'i');
		}
	};

	window.sMedia.Button = {
		initialized    : false,
		url            : null,
		data           : null,
		config         : null,
		button_debug   : false,
		form_debug     : false,
		poweredby_debug: false,
		button_live    : false,
		form_live      : false,
		poweredby_live : false,
		poweredby_conf : null,
		dealership     : null,
		disclaimer     : null,
		busy           : false,
		pending        : [],
		algorithm      : 'default',

		init: function (data, config, general) {
			var algorithm_index = Math.floor(Math.random() * (general.algorithm.length));
			this.algorithm      = general.algorithm[algorithm_index];
			this.data           = data[this.algorithm];
			this.config         = config;
			this.url            = sMedia.Url.get();

			// Set debug status
			this.button_debug    = sMedia.Url.query('button_debug')    === 'true';
			this.form_debug      = sMedia.Url.query('form_debug')      === 'true';
			this.poweredby_debug = sMedia.Url.query('poweredby_debug') === 'true';

			// Set live status
			this.button_live    = general.button_live;
			this.form_live      = general.form_live;
			this.poweredby_live = general.poweredby_live;
			this.poweredby_conf = general.poweredby_conf;
			this.dealership     = general.dealership;
			this.disclaimer     = general.disclaimer;

			if (typeof general.combinations !== 'undefined') {
				this.combinations = general.combinations[this.algorithm];
			}

			this.tracker_url = general.tracker_url;
			this.initialized = true;

			console.log(`Ai button algorithm: ${this.algorithm}`);
		},

		show_baseline: function () {
			var dice = this.button_debug ? 10000 : this.get_random(0, 10000);

			if (this.algorithm == 'default') {
				return dice < 1000;
			} else {
				return dice < 2000;
			}
		},

		predict: function (button) {
			var button_data = this.data[button];
			var retval =
			{
				location: this.predict_group(button_data.locations),
				size    : this.predict_group(button_data.sizes),
				style   : this.predict_group(button_data.styles),
				texts   : {}
			};

			for (var key in button_data.texts) {
				retval.texts[key] = this.predict_group(button_data.texts[key]);
			}

			return retval;
		},

		// Predict combination using Thompson Sampling
		predict_ts: function (btn_name) {
			var highest_probability   = -1;
			var condidate_probability = -1;
			var selected              = null;

			for (let comb in this.data[btn_name]) {
				candidate_probability = rbeta(this.data[btn_name][comb]['a'] + 1, this.data[btn_name][comb]['b'] + 2);

				if (candidate_probability > highest_probability) {
					highest_probability = candidate_probability;
					selected = comb;
				}
			}

			return selected;
		},

		// Predict combination using Softmax
		predict_sm: function (btn_name) {
			var highest_probability    = Math.random();
			var cumulative_probability = 0;
			var total_view             = this.data[btn_name]['view'] + 1;
			var temperature            = 1 / Math.log(total_view + 0.0000001);
			var selected               = null;
			var z                      = 0;

			for (let comb in this.data[btn_name]['score']) {
				z += Math.exp(this.data[btn_name]['score'][comb] / temperature);
			}
			for (let comb in this.data[btn_name]['score']) {
				cumulative_probability += Math.exp(this.data[btn_name]['score'][comb] / temperature) / z;
				selected = comb;
				
				if (cumulative_probability > highest_probability) {
					return selected;
				}
			}

			return selected;
		},

		// Predict combination using UCB-1
		predict_ucb1: function (btn_name) {
			var ucb_score = {};

			for (let comb in this.data[btn_name]['view']) {
				if (this.data[btn_name]['view'][comb] == 0) {
					return comb;
				}
				ucb_score[comb] = this.data[btn_name]['score'][comb] + Math.sqrt((2 * Math.log(this.data[btn_name]['total_view'])) / this.data[btn_name]['view'][comb]);
			}

			var ucb_values = Object.values(ucb_score);

			var max = ucb_values.reduce(function (a, b) {
				return Math.max(a, b);
			});

			return Object.keys(ucb_score)[ucb_values.indexOf(max)];
		},

		predict_group: function (group_data) {
			var sum        = this.sum_vals(group_data);
			var factor     = this.get_random(0, sum);
			var sel_option = null;
			var cur_sum    = 0;

			for (var key in group_data) {
				if (sel_option === null) {
					sel_option = key;
				}

				cur_sum += group_data[key];

				if (cur_sum >= factor) {
					sel_option = key;
					break;
				}
			}

			return sel_option;
		},

		// Returns a random number between min (included) and max (excluded).
		get_random: function (min, max) {
			return Math.floor(Math.random() * (max - min)) + min;
		},

		// Returns a random number between min and max (both included).
		get_random_int: function (min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		},

		sum_vals: function (group_data) {
			var retval = 0;

			for (var key in group_data) {
				retval += group_data[key];
			}

			return retval;
		},

		actions:
		{
			form: function (params) {

			}
		},

		show: function () {
			for (var key in this.config) {
				this.show_button(key);
			}
		},

		show_button: function (btn_name) {
			var tester = sMedia.RegExp.pmake(this.config[btn_name]['url-match']);

			if (tester.test(sMedia.Url.get())) {
				this.bind_events(btn_name);
				var combination = 'baseline';

				if (this.algorithm != 'default') {
					combination = Object.keys(this.combinations[btn_name])[Object.values(this.combinations[btn_name]).indexOf('baseline')];
				}

				if (!this.show_baseline() && (this.button_live || this.button_debug)) {
					if (this.algorithm == 'default') {
						var pbtn = this.predict(btn_name);
					} else {
						var pbtn = [], temp_pbtn = {};
						if (this.algorithm == 'thompson_sampling') {
							combination = this.predict_ts(btn_name);
						} else if (this.algorithm == 'softmax') {
							combination = this.predict_sm(btn_name);
						} else if (this.algorithm == 'ucb-1') {
							combination = this.predict_ucb1(btn_name);
						}
						temp_pbtn = this.combinations[btn_name][combination].slice(1, -1).split('][');
						pbtn = {
							location: temp_pbtn[0],
							size: temp_pbtn[1],
							style: temp_pbtn[2],
							texts: { [btn_name]: temp_pbtn[3] },
						};
						console.log('Selected Combination: ', pbtn);
					}

					if (document.querySelector(this.config[btn_name]['action-target']) !== null) {
						console.log("AI Button Selector Found");
						this.set_text(btn_name, pbtn);
						this.set_style(btn_name, pbtn);
						this.set_size(btn_name, pbtn);
						this.set_location(btn_name, pbtn);
					}
					else {
						console.log("AI Button Selector Timeout Execute");

						setTimeout(function () {
							sMedia.Button.set_text(btn_name, pbtn);
							sMedia.Button.set_style(btn_name, pbtn);
							sMedia.Button.set_size(btn_name, pbtn);
							sMedia.Button.set_location(btn_name, pbtn);
						}, 15000);
					}

					if (this.algorithm == 'default') {
						combination = pbtn.location + '-' + pbtn.style + '-' + pbtn.size;
						for (var text_key in pbtn.texts) {
							combination += `-${pbtn.texts[text_key]}`;
						}
					}
				}

				$(this.config[btn_name]['action-target']).attr('smedia-combination', combination);
				$(this.config[btn_name]['action-target']).attr('smedia-btn-name', btn_name);

				var params = {
					dealership : this.dealership,
					url        : this.url,
					button_name: btn_name,
					text_key   : '',
					text_value : '',
					location   : pbtn ? pbtn.location: '',
					style      : pbtn ? pbtn.style   : '',
					size       : pbtn ? pbtn.size    : '',
					combination: combination,
					algorithm  : this.algorithm,
					smedia_uuid: sMedia.ButtonCookie.get('smedia_smart_lead_uuid')
				};

				if (pbtn) {
					for (var text_key in pbtn.texts) {
						params.text_key = text_key;
						params.text_value = pbtn.texts[text_key];
					}
				}

				sMedia.Button.track('button_viewed', params);
			}
		},

		set_text: function (btn_name, pbtn) {
			for (var text_key in pbtn.texts) {
				var target = this.config[btn_name].texts[text_key.substr(text_key.indexOf(" ") + 1)].target;
				var value  = pbtn.texts[text_key];

				if ($(target).is('input')) {
					$(target).val(value);
				}
				else {
					$(target).html(value);
				}

				$(this.config[btn_name]['action-target']).attr('smedia-text-key', text_key);
				$(this.config[btn_name]['action-target']).attr('smedia-text-value', value);
				$(target).attr('smedia-text-key', text_key);
				$(target).attr('smedia-text-value', value);
			}
		},

		set_style: function (btn_name, pbtn) {
			console.group("Setting Style");
			console.log("Name", btn_name);
			console.log("Options", this.config[btn_name]);
			console.log("Prediction", pbtn);
			console.groupEnd();

			var option      = this.config[btn_name].styles[pbtn.style];
			var style       = document.createElement('style');
			style.type      = 'text/css';
			style.innerHTML = `${this.config[btn_name]['css-class']} { `;

			for (var css_key in option.normal) {
				style.innerHTML += `${css_key}: ${option.normal[css_key]} !important;`;
			}

			style.innerHTML += "}\n" + this.config[btn_name]['css-hover'] + " { ";

			for (var _css_key in option.hover) {
				style.innerHTML += `${_css_key}: ${option.hover[_css_key]} !important;`;
			}

			style.innerHTML += "}\n";
			document.getElementsByTagName('body')[0].appendChild(style);
			$(this.config[btn_name]['action-target']).attr('smedia-style', pbtn.style);

			// Add css using jquery
			console.log(`this-css-class=${this.config[btn_name]['css-class']}`);

			for (var css_key in option.normal) {
				$(this.config[btn_name]['css-class']).css(css_key, option.normal[css_key]);
			}

			for (var _css_key in option.hover) {
				$(this.config[btn_name]['css-class']).css(_css_key, option.hover[_css_key]);
			}
		},

		set_size: function (btn_name, pbtn) {
			var option      = this.config[btn_name].sizes[pbtn.size];
			var style       = document.createElement('style');
			style.type      = 'text/css';
			style.innerHTML = `${this.config[btn_name]['css-class']} { `;

			for (var css_key in option) {
				style.innerHTML += `${css_key}: ${option[css_key]} !important;`;
			}

			style.innerHTML += "}\n";
			document.getElementsByTagName('body')[0].appendChild(style);

			$(this.config[btn_name]['action-target']).attr('smedia-size', pbtn.size);
		},

		set_location: function (btn_name, pbtn) {
			if (this.config[btn_name].target && this.config[btn_name].locations[pbtn.location]) {
				if ($(this.config[btn_name].target).length && $(this.config[btn_name].locations[pbtn.location]).length) {
					$(this.config[btn_name].target).detach().insertAfter(this.config[btn_name].locations[pbtn.location]);
				}
			}

			$(this.config[btn_name]['action-target']).attr('smedia-location', pbtn.location);
		},

		bind_events: function (btn_name) {
			if ((this.form_debug || this.form_live) && this.config[btn_name].button_action) {
				var element = $(this.config[btn_name]['action-target']).get(0);

				if (element) {
					var clone = element.cloneNode();

					while (element.firstChild) {
						clone.appendChild(element.lastChild);
					}

					element.parentNode.replaceChild(clone, element);
					var had_onclick = $(this.config[btn_name]['action-target']).attr('onclick');

					if (typeof had_onclick !== typeof undefined && had_onclick !== false) {
						$(this.config[btn_name]['action-target']).attr('smedia-click-was', had_onclick);
						$(this.config[btn_name]['action-target']).removeAttr('onclick');
					}

					console.log("Successfully unbound events");
				}

				$(this.config[btn_name]['action-target']).unbind('click');
				// Initiate window
				// sMedia_prepare_window($);
			}

			var elems = $(this.config[btn_name]['action-target']);

			elems.addClass(`smedia-ai-${btn_name.replace(' ', '-')}`);
			elems.css('cursor', 'pointer');

			if (elems.length > 0) {
				console.log("Setting event : " + this.config[btn_name]['action-target']);

				for (var i = 0; i < elems.length; i++) {
					elems.get(i).addEventListener('mousedown', sMedia.Button.click);
					console.log(`Event count : ${i + 1} Target: ${this.config[btn_name]['action-target']}`);
				}
			}
			else {
				console.log(`Can't set event : ${this.config[btn_name]['action-target']}`);
			}
		},
		showForm: function (form_name) {
			var btn_name = 'strade';
			var params = {
				dealership : sMedia.Button.dealership,
				url        : sMedia.Button.url,
				button_name: btn_name,
				text_key   : 'strade',
				text_value : 'Get Market Report',
				location   : 'default',
				style      : 'default',
				size       : 'default',
				combination: 'baseline',
				algorithm  : this.algorithm,
				smedia_uuid: sMedia.ButtonCookie.get('smedia_smart_lead_uuid'),
				disclaimer : sMedia.Button.disclaimer,
				referrer   : document.referrer
			};

			sMedia.Window.set_params(params);
			sMedia.Window.params.form = form_name;
			sMedia.Window.open(`https://tm.smedia.ca/forms/${form_name}.php?dealership=${sMedia.Button.dealership}`);
		},
        /***
         * This runs on the target element
         * 1. To access the target use 'this'
         * 2. Use sMedia.Button to access the button class
         **************************************************************************/
		click: function (e) {
			if (e.button == 1 || e.button == 2) {
				return;
			}

			var btn_name = $(this).attr('smedia-btn-name');
			var params =
			{
				dealership : sMedia.Button.dealership,
				url        : sMedia.Button.url,
				button_name: btn_name,
				text_key   : $(this).attr('smedia-text-key'),
				text_value : $(this).attr('smedia-text-value'),
				location   : $(this).attr('smedia-location'),
				style      : $(this).attr('smedia-style'),
				size       : $(this).attr('smedia-size'),
				combination: $(this).attr('smedia-combination'),
				algorithm  : sMedia.Button.algorithm,
				smedia_uuid: sMedia.ButtonCookie.get('smedia_smart_lead_uuid'),
				disclaimer : sMedia.Button.disclaimer,
				referrer   : document.referrer
			};
			sMedia.Button.track('clicked', params);


			if (typeof ga === 'function') {
				console.log(`ga loaded :${ga}`);

				ga('smedia_analytics_tracker.send', {
					hitType       : 'event',
					eventCategory : 'Button Clicked',
					eventAction   : 'AI Button',
					eventLabel    : params.button_name,
					nonInteraction: true
				});
			}
			else {
				console.log('Google Analytics is not loaded. //smedia');
			}

			if ((sMedia.Button.form_debug || sMedia.Button.form_live) && sMedia.Button.config[btn_name].button_action) {
				if (sMedia.Button.config[btn_name].button_action[0] === 'form') {
					var form_name = sMedia.Button.config[btn_name].button_action[1];
					sMedia.Window.set_params(params);
					sMedia.Window.params.form = form_name;
					sMedia.Window.open(`https://tm.smedia.ca/forms/${form_name}.php?dealership=${sMedia.Button.dealership}`);
				}

				sMedia.Button.track('form_viewed', params);
				e.stopImmediatePropagation();
				e.preventDefault();
				return false;
			}
		},
		track: function (type, params) {  //button_viewed/clicked
			this.busy = true;
			var post_data = `act=${type}&button_name=${encodeURIComponent(params.button_name)}&text_key=${encodeURIComponent(params.text_key)}&text_value=${encodeURIComponent(params.text_value)}&location=${encodeURIComponent(params.location)}&style=${encodeURIComponent(params.style)}&size=${encodeURIComponent(params.size)}&combination=${encodeURIComponent(params.combination)}&algorithm=${encodeURIComponent(params.algorithm)}&url=${encodeURIComponent(params.url)}&dealership=${encodeURIComponent(params.dealership)}&smedia_uuid=${encodeURIComponent(params.smedia_uuid)}`;

			console.log(`Posting: ${post_data}`);
			console.log(`Tracker url${this.tracker_url}`);

			if (params.dealership == 'regencymotors') {
				$.ajax({
					url: this.tracker_url,
					data: post_data,
					crossDomain: true,
					type: 'POST',

					success: function (response) {
						console.log(response);
						sMedia.Button.busy = false;

						while (sMedia.Button.pending.length > 0) {
							sMedia.Button.execute(sMedia.Button.pending.shift());
						}
					}
				});
			}
			else {
				jQuery.ajax({
					type: "POST",
					url: this.tracker_url,
					data: post_data,
					crossDomain: true
				})
				.done(function (data, textStatus, jqXHR) {
					console.log(data);
				})
				.fail(function (jqXHR, textStatus, errorThrown) {

				})
				.always(function () {
					sMedia.Button.busy = false;

					while (sMedia.Button.pending.length > 0) {
						sMedia.Button.execute(sMedia.Button.pending.shift());
					}
				});
			}
		},

		checking_button: function (checking_data, dealership) {
			var decoded_data = JSON.parse(checking_data);
			var error_message = "";

			for (var button_name in decoded_data) {
				if ($(decoded_data[button_name].action_target).length) {

				}
				else {
					error_message += `${button_name}: action-target not found. <br>`;
				}

				if ($(decoded_data[button_name].css_class).length) {

				}
				else {
					error_message += `${button_name}: css-class not found. <br>`;
				}
			}

			if (error_message) {
				var post_data = `act=save_log&error_message=${error_message}&dealership=${dealership}`;

				jQuery.ajax({
					type: "POST",
					url: this.tracker_url,
					data: post_data,
					crossDomain: true
				})
				.done(function (data, textStatus, jqXHR) {
					console.log(data);
				});
			}

			console.log(`error message=${error_message}`);
		},

		execute: function (task) {
			if (task && typeof sMedia.Button[task.name] === 'function') {
				sMedia.Button[task.name].apply(null, task.args ? task.args : []);
			}
		}
	};
}
