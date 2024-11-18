	window.sMedia = window.sMedia || {};
<?php

use sMedia\AbTest\AbTestController;

function smedia_script_start($cron_name, $domain, $ref_url, $page_type)
{
    ?>
    var sMedia = sMedia || {};

    window.sMedia = window.sMedia || {};
    window.sMedia.epmCallbacks = window.sMedia.epmCallbacks || [];

    !function () {
        if (window.sMedia.ScriptReady) {
            return;
        }

        window.sMedia.ScriptReady = true;
        window.sMedia.dealership = '<?= $cron_name ?>';
        <?= "var sm_dealership = " . json_encode(array('name' => $cron_name, 'domain' => $domain)) . ";\n";?>

        function sm_include_script(sfn, loc) {
            sref=document.createElement('script');
            sref.setAttribute("type","text/javascript");
            sref.setAttribute("src", sfn);
            sref.setAttribute("async", "");
            document.getElementsByTagName(loc)[0].appendChild(sref);
            console.log(`sMedia Included Script '${sfn}'`);

            /*
            window.confirmjQueryLoaded(function($, sfn) {
                console.log("sMedia Including Script '" + sfn + "'");
                $.ajax({
                    url: sfn,
                    dataType: "script",
                    success: function( data, textStatus, jqxhr ) {
                        console.log( textStatus ); // Success
                    }
                });
            }, sfn);
            */
        }

        function sm_include_style(sfn) {
            sref=document.createElement("link");
            sref.rel = "stylesheet";
            sref.href = sfn;
            document.getElementsByTagName("head")[0].appendChild(sref);
            console.log(`sMedia Included Style '${sfn}'`);
        }

        function sm_include_iframe(sfn) {
            sref=document.createElement("iframe");
            sref.setAttribute("width", "1");
            sref.setAttribute("height", "1");
            sref.setAttribute("frameborder", "0");
            sref.setAttribute("src", sfn);
            document.getElementsByTagName("body")[0].appendChild(sref);
            console.log(`sMedia Included Iframe '${sfn}'`);
        }

        window.sm_include_iframe = sm_include_iframe;

        function sm_add_xrcb(callback) {
            var oldSend, i;

            if ( XMLHttpRequest.callbacks ) {
                // we've already overridden send() so just add the callback
                XMLHttpRequest.callbacks.push( callback );
            } else {
                // create a callback queue
                XMLHttpRequest.callbacks = [callback];
                // store the native send()
                oldSend = XMLHttpRequest.prototype.send;
                // override the native send()

                XMLHttpRequest.prototype.send = function() {
                    this.onreadystatechange = function(readystateEvent) {
                        if (this.readyState === 4) {
                            for( i = 0; i < XMLHttpRequest.callbacks.length; i++ ) {
                                XMLHttpRequest.callbacks[i]( this );
                            }
                        }
                    };
                    // call the native send()
                    oldSend.apply(this, arguments);
                }
            }
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(";");

            for (var i=0; i<ca.length; i++) {
                var c = ca[i];

                while (c.charAt(0)==" ") {
                    c = c.substring(1);
                }

                if (c.indexOf(name) != -1) {
                    return c.substring(name.length,c.length);
                }
            }

            return "";
        }

        function getSuffixed(i) {
            switch(i) {
                case 1:
                    return i + 'st';
                case 2:
                    return i + 'nd';
                case 3:
                    return i + 'rd';
                default:
                    return i + 'th';
            }
        }

        function getChildIndex(child) {
            var i = 0;
            while ((child = child.previousSibling) != null) {
                if (!child.tagName) {
                    continue;
                } else {
                    i++;
                }
            }

            return i;
        }

        var firstImageClicked   = false;
        var currentImage        = 1;
        var maxImages           = 0;

        function bindForImageTrackingCheck($, identifier) {
            if ($(identifier).length > 0) {
                console.log(`bindForImageTrackingCheck Selector Found for selector ${identifier}`);
                bindForImageTracking($, identifier);
            } else {
                console.log(`bindForImageTrackingCheck Selector Timeout Function for selector ${identifier}`);
                setTimeout(bindForImageTrackingCheck, 3000, $, identifier);
            }
        }

        function bindForNextImageTrackingCheck($, identifier) {
            if ($(identifier).length > 0) {
                console.log(`bindForNextImageTrackingCheck Selector Found for selector ${identifier}`);
                bindForNextImageTracking($, identifier);
            } else {
                console.log(`bindForNextImageTrackingCheck Selector Timeout Function for selector ${identifier}`);
                setTimeout(bindForNextImageTrackingCheck, 3000, $, identifier);
            }
        }

        function bindForPrevImageTrackingCheck($, identifier) {
            if ($(identifier).length > 0) {
                console.log(`bindForPrevImageTrackingCheck Selector Found for selector ${identifier}`);
                bindForPrevImageTracking($, identifier);
            } else {
                console.log(`bindForPrevImageTrackingCheck Selector Timeout Function for selector ${identifier}`);
                setTimeout(bindForPrevImageTrackingCheck, 3000, $, identifier);
            }
        }

        function bindForImageTracking($, identifier) {
            maxImages = $(identifier).parent().children().length;

            $(identifier).click(function() {
                console.log("Call bindForImageTracking Function");
                var i = $(identifier).index(this);
                currentImage = i + 1;
                var ith = getSuffixed(currentImage);

                if (!firstImageClicked) {
                    if (typeof ga == 'function') {
                        ga('smedia_analytics_tracker.send', {
                            hitType: 'event',
                            eventCategory: 'Picture engagement',
                            eventAction: `${ith} Picture engagement`,
                            nonInteraction: true
                        });
                    }

                    console.log(`${ith} Picture engagement | Selector | ${identifier}`);
                    firstImageClicked = true;
                }

                if (typeof ga == 'function') {
                    ga('smedia_analytics_tracker.send', {
                        hitType: 'event',
                        eventCategory: 'Picture Viewed',
                        eventAction: `${ith} Picture Viewed`,
                        nonInteraction: true
                    });
                }

                console.log(`${ith} image clicked | Selector | ${identifier}`);
            });
        }

        function bindForNextImageTracking($, identifier) {
            $(identifier).click(function() {
                console.log("Call bindForNextImageTracking Function");
                currentImage++;

                if (currentImage > maxImages) {
                    currentImage = 1;
                }

                var ith = getSuffixed(currentImage);

                if (!firstImageClicked) {
                    if (typeof ga == 'function') {
                        ga('smedia_analytics_tracker.send', {
                            hitType: 'event',
                            eventCategory: 'Picture engagement',
                            eventAction: `${ith} Picture engagement`,
                            nonInteraction: true
                        });
                    }

                    console.log(`${ith} Picture engagement | Next | ${identifier}`);
                    firstImageClicked = true;
                }

                if (typeof ga == 'function') {
                    ga('smedia_analytics_tracker.send', {
                        hitType: 'event',
                        eventCategory: 'Picture Viewed',
                        eventAction: `${ith} Picture Viewed`,
                        nonInteraction: true
                    });
                }

                console.log(`${ith} image clicked | next | ${identifier}`);
            });
        }

        function bindForPrevImageTracking($, identifier) {
            $(identifier).click(function(){
                console.log("Call bindForPrevImageTracking Function");
                currentImage--;

                if (currentImage < 1) {
                    currentImage = maxImages;
                }

                var ith = getSuffixed(currentImage);

                if (!firstImageClicked) {
                    if (typeof ga == 'function') {
                        ga('smedia_analytics_tracker.send', {
                            hitType: 'event',
                            eventCategory: 'Picture engagement',
                            eventAction: `${ith} Picture engagement`,
                            nonInteraction: true
                        });
                    }

                    console.log(`${ith} Picture engagement | Prev | ${identifier}`);
                    firstImageClicked = true;
                }

                if (typeof ga == 'function') {
                    ga('smedia_analytics_tracker.send', {
                        hitType: 'event',
                        eventCategory: 'Picture Viewed',
                        eventAction: `${ith} Picture Viewed`,
                        nonInteraction: true
                    });
                }

                console.log(`${ith} image clicked | Prev | ${identifier}`);
            });
        }

        function directmail_track(dealership, stock) {
            // Nothing here.
        }

        function ba(action, category, label, value) {
            window.uetq = window.uetq || [];
            window.uetq.push('event', action, {
                'event_category': category,
                'event_label': label,
                'event_value': value
            });
        }

        window.smedia_jquery_added = false;

        window.confirmjQueryLoaded = function (func_resp, state) {
            if (state === undefined) {
                state = null;
            }

            if (typeof jQuery === 'undefined') {
                if (!window.smedia_jquery_added) {
                    jq_script = document.createElement('script');
                    jq_script.setAttribute("src", 'https://code.jquery.com/jquery-2.2.3.min.js');
                    document.getElementsByTagName("head")[0].appendChild(jq_script);
                    window.smedia_jquery_added = true;
                }

                setTimeout(function() {
                    confirmjQueryLoaded(func_resp, state);
                }, 100);
            } else {
                if (state === null) {
                    func_resp(jQuery);
                } else {
                    func_resp(jQuery, state);
                }
            }
        }

        sm_include_style('//tm.smedia.ca/dynamic-resources/buttons/window.css');
        sm_include_script('//tm.smedia.ca/dynamic-resources/buttons/window.js', 'head');
        <?php
    }

    function smedia_page_info($url, $domain, $cron_name, $page_type, $car_data, $install_trade_smart = false) {
        ?>
        sMedia.PageInfo = {
            pageType    : '<?= $page_type ?>',
            url         : '<?= $url ?>',
            domain      : '<?= $domain ?>',
            dealership  : '<?= $cron_name ?>',
            car         : {
                year        : '<?= $car_data['year'] ?>',
                make        : '<?= $car_data['make'] ?>',
                model       : '<?= $car_data['model'] ?>',
                trim        : '<?= $car_data['trim'] ?>',
                vin         : '<?= $car_data['vin'] ?>',
                stock_number: '<?= $car_data['stock_number'] ?>'
            }
        };
        <?php
        if ($page_type == 'vdp' && $install_trade_smart) {
        ?>
            let sm_ts_last_engaged_vdp = {
                year        : '<?= $car_data['year'] ?>',
                make        : '<?= $car_data['make'] ?>',
                model       : '<?= $car_data['model'] ?>',
                trim        : '<?= $car_data['trim'] ?>',
                vin         : '<?= $car_data['vin'] ?>',
                stock_number: '<?= $car_data['stock_number'] ?>',
                url         : encodeURI('<?= $url ?>')
            };
            window.localStorage.setItem('sm_ts_last_engaged_vdp', JSON.stringify(sm_ts_last_engaged_vdp));
        <?php
        }
    }

    function smedia_script_end() {
        ?>
        }();
        <?php
    }

    function track_phone_number() {
        ?>
        function trackPhone($) {
            /* Phone Tracking */
            var phone_regex = /\(?[0-9]{3}\)?[\.\-\s][0-9]{3}[\.\-\s][0-9]{4}/g;
            $("<style type=\"text/css\">span.smedia-tracker.phone { all: unset; cursor: pointer; }</style>").appendTo("head");

            try {
                var x = $('*').contents().filter(function() {
                    return this.nodeType === 3 && $(this).text().match(phone_regex)
                }).wrap(function () {
                    var match = phone_regex.exec($(this).text());
                    return `<span class="smedia-tracker phone" data-phone="${match[0]}"></span>`;
                });

                $("span.smedia-tracker.phone").click(function() {
                    if ($(this).attr("data-tracked")) {
                        return;
                    }

                    ga('send','event','sMedia Tracking','Phone Number', $(this).attr("data-phone"));
                    console.log(`Phone number clicked: ${$(this).attr("data-phone")}`);
                    $(this).attr("data-tracked", 1);
                });
            } catch(ex) {
                console.log(`Error: ${ex.message}`);
            }
        }

        confirmjQueryLoaded(function($) {
            trackPhone($);
        });

        <?php
    }

    function smedia_vdp_views($CurrentConfig, $domain, $url) {
        $pageViews = 0;
        $analytics = new Analytics(get_current_google_customer());
        $profileId = @retrive_best_profileId($analytics, $domain);

        if ($profileId) {
            $startDate = new DateTime(date('Y-m-d'));
            $startDate->sub(new DateInterval('P60M'));
            $urlReport = $analytics->GetURLReport($profileId, $url, $startDate->format('Y-m-d'), date('Y-m-d'), array('ga:pageviews', 'ga:uniquePageviews'));
            $pageViews = $urlReport->totalsForAllResults->{'ga:uniquePageviews'};
        }

        echo "\n/*\n\tProfile ID:\t$profileId\n\tFor URL:\t$url\n\tPageViews:\t$pageViews\n*/";

        if (!$pageViews) {
            $pageViews = '0';
        }
        ?>
        sm_include_style("//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css");

        if (document.getElementById('smedia-page-views') && document.getElementById('smedia-page-views').getAttribute("countup") !== null) {
            <?= file_get_contents(dirname(__DIR__) . '/libs/countUp.min.js') ?>

            var options = {
                useEasing : true,
                useGrouping : true,
                separator : ',',
                decimal : '.',
                prefix : '',
                suffix : ''
            };

            var svdppv = new CountUp("smedia-page-views", 0, <?= $pageViews ?>, 0, 2.5, options);
            svdppv.start();
        } else {
            <?= "try{document.getElementById('smedia-page-views').innerHTML = '$pageViews';}catch(err){}\n}\n";
		}

        function smedia_scroll_depth() {
            ?>
            if (typeof jQuery != 'undefined' && jQuery.fn.jquery.replace(/\.(\d)/g,".0$1").replace(/\.0(\d{2})/g,".$1") > "1.07.00") {
            	<?= "\n" . file_get_contents(dirname(__DIR__) . '/libs/jquery.scrolldepth.min.js') . "\n"; ?>
				jQuery(function() {
					jQuery.scrollDepth({
						nonInteraction  : false,
						gtmOverride     : true
					});
				});
            }
            <?php
		}

		function smedia_banner_script($cron_config, $template, $directive) {
			if (!$template || !$directive) {
				return;
			}

			$physical_path = "adwords3/templates/{$template}/{$directive}/website_banner.png";

			if (!file_exists($physical_path)) {
				return;
			}

			$image_url = "//tm.smedia.ca/{$physical_path}?random=" . time();
			$image_res = '<img alt="" src="' . $image_url . '"/>';

			if ($cron_config) {
				$remade_directive = '';

				if (startsWith($directive, 'new')) {
					$remade_directive = 'new_' . substr($directive, 3);
				} elseif (startsWith($directive, 'used')) {
					$remade_directive = 'used_' . substr($directive, 4);
				}

				if (isset($cron_config['links']) && isset($cron_config['links'][$remade_directive])) {
					$image_res = '<a href="' . $cron_config['links'][$remade_directive] . '">' . $image_res . '</a>';
				}
			}

			echo 'try{document.getElementById(\'smedia-web-banner\').innerHTML = \'' . $image_res . '\';}catch(err){}';
		}

		function smedia_remarketing_conversion_tracker($cron_name, $cron_config, $car_data, $retargetting_delay = false) {
			$conversionTracker = array();

			$stock_number = $car_data ? trim($car_data['stock_number']) : '';

			if ($car_data) {
				$url = $car_data['url'];
				$year = $car_data['year'];
				$make = $car_data['make'];
				$model = $car_data['model'];
			} else {
				$url = '';
			}

			if ($stock_number) {
				$conversionTracker = retrive_tag($cron_name, $year, $make, $model);
			}

			$conversion_id = '';
			$conversion_label = '';

			if ($conversionTracker) {
				$conversion_id = $conversionTracker['conversion_id'];
				$conversion_label = $conversionTracker['label'];
			}

			$pa_id = '';

			if (isset($cron_config['perfect_audience_id'])) {
				$pa_id = $cron_config['perfect_audience_id'];
			}

			$iurl = "//tm.smedia.ca/tm-tracker-iframe.php?stock_number=$stock_number&id=$conversion_id&label=$conversion_label&pa_id=$pa_id&cron_name=$cron_name";
			$iurl .= "&url=" . urlencode($url);

			if (!$retargetting_delay) {
				echo "\nsm_include_iframe('$iurl');\n";
			} else {
				echo "setTimeout(function(){ sm_include_iframe('$iurl'); }, $retargetting_delay);\n";
			}
		}

		function smedia_quick_notice_popup($cron_name, $ref_url, $session_id) {
			$pop_up_settigs = get_meta('popup_config', $cron_name);
			$parsed_url = parse_url($ref_url);
			$debug = stripos($ref_url, 'covid19_debug=true') !== false;
			$home_page = (strlen(trim($parsed_url['path'], '/')) <= 0 && ($debug || strlen($parsed_url['query']) <= 0));

			if ($home_page && ($pop_up_settigs['live'] || $debug)) {
				$e_url = urlencode($ref_url);
				$quick_notice_script = "https://tm.smedia.ca/popup/quick-notice.js?dealership=$cron_name&ref=$e_url&session_id=$session_id";
				?>

				window.addEventListener("message", function(event) {
					if (!event.data || event.data.sender != 'xdomaincookie') {
						return;
					}

					if (event.data.action == 'cookie_ready') {
						console.log('Cookie ready');
						var smedia_quick_notice_load_status  = true;

						function smedia_load_quick_notice() {
							if (typeof sMedia.XDomainCookie !== 'undefined') {
								console.log("Requesting for Cookie to load quick notice");
								sMedia.XDomainCookie.get('smedia_quick_notice', function(value) {
									console.log(`quick notice cookie found ${value}` );
									<?php if (!$debug) { ?>
										if (value != null) {
											smedia_quick_notice_load_status  = false;
										}
									<?php } ?>
								});

								function smedia_quick_notice_load_status_check() {
									console.log('Checking quick_notice status ' + smedia_quick_notice_load_status)

									if (smedia_quick_notice_load_status) {
										var lead_script_url = '<?= $quick_notice_script ?>&user_unique_id=';
										console.log(`Including quick notice script: ${lead_script_url}`);
										sm_include_script(lead_script_url, 'head');
									}
								}

								setTimeout(smedia_quick_notice_load_status_check, 3000);
							} else {
								console.log("Waiting for Cookie to load quick notice");
								setTimeout(smedia_load_quick_notice, 1000);
							}
						}

						setTimeout(smedia_load_quick_notice, 1000);
					}
				}, false);
				<?php
			}
		}

		function smedia_popup_lead_form($cron_name, $stock_type, $car_data, $ref_url, $session_id, $video = false, $debug = false, $custom_div = '') {
			$year         = $car_data ? urlencode($car_data['year'])        : '';
			$make         = $car_data ? urlencode($car_data['make'])        : '';
			$model        = $car_data ? urlencode($car_data['model'])       : '';
			$stock_number = $car_data ? urlencode($car_data['stock_number']): '';
			$price        = $car_data ? urlencode($car_data['price'])       : '';
			$e_url        = urlencode($ref_url);
			$ps 		  = "https://tm.smedia.ca/popup/design.js?dealership={$cron_name}&stock_type={$stock_type}&stock_number={$stock_number}&year={$year}&make={$make}&model={$model}&price={$price}&ref={$e_url}&session_id={$session_id}&custom_div={$custom_div}";

			if ($video && $debug) {
				$ps = "https://tm.smedia.ca/popup-video/design.js?dealership={$cron_name}&stock_type={$stock_type}&stock_number={$stock_number}&year={$year}&make={$make}&model={$model}&price={$price}&ref={$e_url}&session_id={$session_id}";
			}
			?>

			var smedia_smart_offer_load_status  = false;

			function smedia_load_smart_offer() {
				if (typeof sMedia.XDomainCookie !== 'undefined') {
					console.log("Requesting for Cookie to load smart offer");
					sMedia.XDomainCookie.get('smedia_uuid', function(uuid) {
						if (!smedia_smart_offer_load_status) {
                            if (window.sMedia && window.sMedia.pageTitle) {
                                var lead_script_url = '<?= $ps ?>&user_unique_id=' + uuid + '&page_title=' + window.sMedia.pageTitle;
                            } else {
    							var lead_script_url = '<?= $ps ?>&user_unique_id=' + uuid;
                            }

                            console.log({lead_script_url});

							console.log(`Including lead script: ${lead_script_url}`);
							sm_include_script(lead_script_url, 'head');
							smedia_smart_offer_load_status = true;
						}
					});
				} else {
					console.log("Waiting for Cookie to load smart offer");
					setTimeout(smedia_load_smart_offer, 1000);
				}
			}

			/*
			* smedia_smart_offer_load_status is false then, this function will call after 4s with null uuid
			* In the next page design.js, I have checked if uuid is null, then generated new uuid by UUID class
			* This function ensure that smart offer tag does not faild to load because of sMedia.XDomainCookie.get
			*/
			function smedia_smart_offer_load_status_check() {
				if (!smedia_smart_offer_load_status) {
					var lead_script_url = '<?= $ps ?>&user_unique_id=';
					console.log(`Including lead script from smedia_smart_offer_load_status_check: ${lead_script_url}`);
					sm_include_script(lead_script_url, 'head');
					smedia_smart_offer_load_status = true;
				}
			}

			setTimeout(smedia_load_smart_offer, 1000);
			setTimeout(smedia_smart_offer_load_status_check, 5000);
			<?php
		}

		function smedia_ab_testing_tool($cron_name, $cron_config, $url) {
			try{
				echo "\n// ab_test scripts \n" ;
				$ab_test = new AbTestController($cron_name, $url, dirname(__DIR__) . "/ab-test");
				echo $ab_test->generateJavascript($cron_config);
				echo "\n// ab_test scripts ends \n" ;
			} catch(\Exception $e) {
				echo "\n// ab_test errors\n" ;
				echo "\n// ". $e->getMessage() ."\n" ;
				echo "\n// ab_test errors ends\n" ;
			}
		}

		function smedia_smart_button($cron_name, $url, $stock_type, $page_type) {
			$e_url = urlencode($url);
			$ps = "//tm.smedia.ca/buttons/buttons.js?dealership={$cron_name}&stock_type={$stock_type}&ref={$e_url}&t=";

            if ($page_type == 'vdp') {
                echo "\nsm_include_script('$ps' + new Date().getTime() + '&page_title=' + window.sMedia.pageTitle, 'head');\n";
            } else {
                echo "\nsm_include_script('$ps' + new Date().getTime() + '&page_title=' + '', 'head');\n";
            }
		}

		function smedia_directmail_init($dealership, $stock_number) {
			$url = 'https://tm.smedia.ca/dynamic-resources/directmail/mail.js';
			echo "\nsm_include_script('$url', 'head');\n";
			?>

			window.try_track_directmail = function() {
				if (typeof window.smedia_track_directmail !== 'undefined') {
					window.smedia_track_directmail('<?= $dealership ?>', '<?= $stock_number ?>');
				} else {
					setTimeout(window.try_track_directmail, 50);
				}
			};

			setTimeout(window.try_track_directmail, 100);

			<?php
		}

		function smedia_include_additional_scripts($additional_scripts) {
			if (!is_array($additional_scripts)) {
				$additional_scripts = array($additional_scripts);
			}

			if (count($additional_scripts) == 0) {
				return;
			}

			foreach ($additional_scripts as $script) {
				$script = trim($script);

				if (!$script) {
					continue;
				}

				echo "\nsm_include_script('$script', 'body');\n";
			}
		}

		function smedia_profitable_engagement(Tracker $tag_gen, $install_analytics = false) {
			?>
			var message = "Time on page more than 30 seconds";

			if (count == 2) {
				message = "Time on page more than a minute";
			} else if (count == 3) {
				message = "Time on page more than 1 minute 30 seconds";
			}

			<?php
			if (!$install_analytics) {
			?>
				if (typeof ga == 'function') {
					if(!window.engaged_prospect) {
						ga('send','event','engaged_prospect','');
					}
					ga('send','event','Profitable Engagement', message);
				}
			<?php
			} else {
			?>
				if (!window.engaged_prospect) {
					<?php $tag_gen->ga('event', array('engaged_prospect', '')); ?>
				}
			<?php
				ob_start();
				$tag_gen->ga('event', array('Profitable Engagement', "{{message}}"));
				echo str_replace("{{message}}", "\"+ message +\"", ob_get_clean());
			}
			?>
			window.engaged_prospect = true;
			console.log("Epm: ga - ", message);
			<?php
		}

		function bing_profitable_engagement(Tracker $tag_gen, $install_bing = false) {
			?>
			var message = "Time on page more than 30 seconds";

			<?php
			if ($install_bing) {
				$tag_gen->ba('profitable_engagement', 'Profitable Engagement', "'+message+'");
			}
			?>
			console.log("Epm: bing - ", message);
			<?php
		}

		function smedia_vdp_view() {
			?>
			if (typeof ga == 'function') {
				ga('smedia_analytics_tracker.send', {
					hitType: 'event',
					eventCategory: 'vdp',
					eventAction: 'view',
					nonInteraction: true
				});
			}
			<?php
		}

		function smedia_adwords_conversion($conversion_id, $conversion_label) {
			$iurl = "//tm.smedia.ca/tm-conversion.php?id={$conversion_id}&label={$conversion_label}";

			echo "\nsm_include_iframe('$iurl');\n";
		}

		function smedia_thankyou_analytics(Tracker $tag_gen, $install_analytics = false) {
			if ($install_analytics) {
				$tag_gen->ga('event', array('smedia_lead', 'submit'));
				$tag_gen->ga('event', array('Contact Form', 'submit'));
			} else {
				?>
				if (typeof ga === 'function') {
					ga('send','event','smedia_lead', 'submit');
					ga('send','event','Contact Form', 'submit');
				}
				<?php
			}
		}

		function smedia_add_hash($hash) {
			echo "\nwindow.location.hash = \"$hash\";\n";
		}

		function smedia_inpage_lead(Tracker $tag_gen, $conversion_id, $conversion_label, $fbqs, $install_analytics = false) {
			?>
			window.smedia_lead_fired = window.smedia_lead_fired || false;

			if (!window.smedia_lead_fired) {
				window.smedia_lead_fired = true;
				console.log("Firing inpage sMedia Lead");
			<?php
			smedia_add_hash("smedia_lead");
			smedia_adwords_conversion($conversion_id, $conversion_label);
			smedia_thankyou_analytics($tag_gen, $install_analytics);

			foreach ($fbqs as $fbq) {
				switch ($fbq) {
					case 'pageview':
						$tag_gen->fbq('PageView');
						break;
					case 'lead':
						$tag_gen->fbq('Lead');
						break;
				}
			}
			?>
			}
			<?php
		}

		function smedia_form_submit(Tracker $tag_gen, $ajax_url, $ajax_resp, $conversion_id, $conversion_label, $fbqs, $install_analytics = false) {
			?>
			if (typeof jQuery != 'undefined') {
				jQuery.ajaxPrefilter(function global_ajaxPrefilter(options, originalOptions, jqXHR) {
					jqXHR.done(function global_ajaxSuccess(data, textStatus, jqXHR) {
						ajax_url      = options.url;
						ajax_resp     = JSON.stringify(data);
						console.groupCollapsed(options.url);
						console.log("Options: " + JSON.stringify(options));
						console.log("Data: " + JSON.stringify(data));
						console.groupEnd();

						<?php if ($ajax_url): ?>
							if (ajax_url.indexOf('<?= $ajax_url ?>') >= 0) {
							<?php if ($ajax_resp): ?>
								if (ajax_resp.indexOf('<?= $ajax_resp ?>') >= 0) {
							<?php endif; ?>
							<?php smedia_inpage_lead($tag_gen, $conversion_id, $conversion_label, $fbqs, $install_analytics); ?>
							<?php if ($ajax_resp): ?>
								}
							<?php endif; ?>
							}
						<?php endif; ?>
					});

					jqXHR.fail(function global_ajaxError(jqXHR, textStatus, errorThrown) {
						console.error(`${textStatus} : ${errorThrown}`);
					});
				});
			} else {
				sm_add_xrcb( function( xhr ) {
					ajax_url    = xhr.responseURL;
					ajax_resp   = xhr.responseText;
					<?php if ($ajax_url): ?>
						if (ajax_url.indexOf('<?= $ajax_url ?>') >= 0) {
						<?php if ($ajax_resp): ?>
							if (ajax_resp.indexOf('<?= $ajax_resp ?>') >= 0) {
						<?php endif; ?>
						<?php smedia_inpage_lead($tag_gen, $conversion_id, $conversion_label, $fbqs, $install_analytics); ?>
						<?php if ($ajax_resp): ?>
							}
						<?php endif; ?>
						}
					<?php endif; ?>
				});
			}
			<?php
		}

		function smedia_inpage_ty(Tracker $tag_gen, $inpage_cont, $conversion_id, $conversion_label, $fbqs, $install_analytics = false) {
			?>
			if(typeof jQuery != 'undefined') {
				if (jQuery('body').children("*:contains('<?= $inpage_cont ?>')").length > 0) {
					<?php smedia_inpage_lead($tag_gen, $conversion_id, $conversion_label, $fbqs, $install_analytics); ?>
				}
			}
			<?php
		}

		function smedia_iframe_ty(Tracker $tag_gen, $iframe_url, $conversion_id, $conversion_label, $fbqs, $install_analytics = false) {
			?>
			window.iframechecker = setInterval(function() {
				i_urls = [];
				jQuery.each(jQuery('iframe'), function(i, f) {
					if (typeof jQuery(f).contents().get(0).location != 'undefined') {
						i_urls.push(jQuery(f).contents().get(0).location.href);
					}
				});
				console.dir(i_urls);
				// clearInterval(window.iframechecker);
			}, 10000);
			<?php
		}

		function smedia_picture_tracking($selectors) {
			if (!is_array($selectors)) {
				$selectors = [$selectors];
			}
			echo "\n// Picture tracking";
			foreach ($selectors as $selector) {
				echo "\nconfirmjQueryLoaded(function($) { bindForImageTrackingCheck($, '$selector'); });\n";
			}
		}

		function smedia_next_picture_tracking($selectors) {
			if (!is_array($selectors)) {
				$selectors = [$selectors];
			}
			echo "\n// Next Picture tracking";
			foreach ($selectors as $selector) {
				echo "\nconfirmjQueryLoaded(function($) { bindForNextImageTrackingCheck($, '$selector'); });\n";
			}
		}

		function smedia_prev_picture_tracking($selectors) {
			if (!is_array($selectors)) {
				$selectors = [$selectors];
			}
			echo "\n// Prev Picture tracking\n";
			foreach ($selectors as $selector) {
				echo "\nconfirmjQueryLoaded(function($) { bindForPrevImageTrackingCheck($, '$selector'); });\n";
			}
		}

		function smedia_include_smart_banner($cron_name, $url, $car_data) {
			$year  = $car_data ? urlencode($car_data['year']) : '';
			$make  = $car_data ? urlencode($car_data['make']) : '';
			$model = $car_data ? urlencode($car_data['model']): '';
			$vdp   = $car_data ? urlencode($car_data['url'])  : $url;
			$e_url = urlencode($url);
			$ps    = "//tm.smedia.ca/smart-banner/banner.js?dealership={$cron_name}&ref={$e_url}&year={$year}&make={$make}&model={$model}&vdp={$vdp}";
			?>

			function smedia_load_smart_banner() {
				if (typeof sMedia.XDomainCookie !== 'undefined') {
					console.log("Requesting for Cookie to load smart banner");
					sMedia.XDomainCookie.get('smedia_uuid', function(uuid) {
						var banner_script_url = '<?= $ps ?>&user_unique_id=' + uuid;
						console.log(`Including banner script: ${banner_script_url}`);
						sm_include_script(banner_script_url, 'head');
					});
				} else {
					console.log("Waiting for Cookie to load smart banner");
					setTimeout(smedia_load_smart_banner, 1000);
				}
			}
			setTimeout(smedia_load_smart_banner, 1000);
			<?php
		}

		function smedia_install_trade_smart($dealershipId) {
			?>
			var smedia_trade_smart_container = document.getElementById('smatp_trade_tool');
			var smedia_trade_smart_link = document.querySelector('a[href="https://www.vroomance.com/"]');

			if (smedia_trade_smart_container) {
                smedia_trade_smart_container.setAttribute("data-dealerid", "<?= $dealershipId ?>")
                sm_include_style('https://tradesmartapi.smedia.ca/stylesheets/modal.css');
                sm_include_script('https://tradesmartapi.smedia.ca/javascripts/tool.js', 'body');
            }

			function UrlExists(url, cb) {
				jQuery.ajax({
					url:      url,
					dataType: 'text',
					type:     'GET',
					complete:  function(xhr) {
						if (typeof cb === 'function') {
							cb.apply(this, [xhr.status]);
						}
					}
				});
			}

			UrlExists('https://tradesmartapi.smedia.ca/stylesheets/modal.css', function(status) {
				if (status === 200) {
					console.log('Trade Smart css load');
				} else{
					console.log('Trade Smart css is not load hide Powered by');
					document.getElementsByClassName('smedia_powered_by')[0].style.visibility = "hidden";

					if (document.getElementById('trade-loading')) {
						document.getElementById('trade-loading').style.display = "none";
					}
				}
			});

			UrlExists('https://tradesmartapi.smedia.ca/javascripts/tool.js', function(status) {
				if (status === 200) {
					console.log('Trade Smart javascripts load');
				} else {
					console.log('Trade Smart javascripts is not load hide Powered by');
					document.getElementsByClassName('smedia_powered_by')[0].style.visibility = "hidden";

					if (document.getElementById('trade-loading')) {
						document.getElementById('trade-loading').style.display = "none";
					}
				}
			});
			<?php
		}

		function smedia_hide_trade_smart() {
			?>
			// Tag install but v2 response not found trade smart
			if (document.getElementById('trade-loading')) {
				document.getElementById('trade-loading').style.display = "none";
			}

			if (document.getElementsByClassName('smedia_powered_by')[0]) {
				document.getElementsByClassName('smedia_powered_by')[0].style.visibility = "hidden";
			}
			<?php
		}

		function smedia_include_visual_scraper($url)
		{
			$e_url = urlencode($url);
			$vs = "https://tm.smedia.ca/visual-scraper/client_vs.js?ref={$e_url}";
			echo "\n sm_include_script('$vs', 'head');\n";
		}

		function smedia_install_adwords_retargeting($adwords_tracking_id)
		{
			$script_url = "https://www.googletagmanager.com/gtag/js?id={$adwords_tracking_id}";
			echo "\nsm_include_script('$script_url', 'head');\n";
			?>

			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}

			gtag('js', new Date());
			gtag('config', '<?= $adwords_tracking_id ?>');

			<?php
		}

		function smedia_track_adwords_retargeting($adwords_tracking_id, $stock_number, $price)
		{
			?>
			gtag('event', 'page_view', {
				'send_to': '<?= $adwords_tracking_id ?>',
				'value': '<?= numarifyPrice($price) ?>',
				'items': [{
						'id': '<?= $stock_number ?>',
						'google_business_vertical': 'retail'
					}
				]
			});

			<?php
		}

		function install_vinnauto($vinnauto, $vinn_car_data, $vinn)
		{
			$car_data_json  = json_encode($vinn_car_data, JSON_HEX_QUOT | JSON_HEX_APOS);
			$car_data_json  = str_replace("\u0022", "\\\"", $car_data_json);
			$car_data_json  = str_replace("\u0027", "\\'",  $car_data_json);
			$car_data_json  = str_replace("\/", "/",  $car_data_json);  // This is done to match RUBY generated JSON
			// $car_data_json  = "{$car_data_json}";

			$dealership_id  = $vinnauto['dealership_id'];
			$secret         = $vinnauto['VINN_SIGNING_SECRET'];

			$payload        = "{$dealership_id}:{$car_data_json}";
			$signature      = trim(hash_hmac('sha256', $payload, $secret, false));
			?>

			var vehicles = {
				'<?= $vinn ?>' : {
					signature: '<?= $signature ?>',
					body: '<?= $car_data_json ?>'
				}
			};

			window.vinnCheckoutConfig = {
				dealership: '<?= $dealership_id ?>',

				getVehicle: function(vin) {
					return vehicles[vin];
				}
			};

			window.smediaCarData = JSON.parse('<?= $car_data_json ?>');

			var elm = document.querySelector('<?= $vinnauto['button_container'] ?>');
			var btn = document.createElement('div');

			btn.innerHTML = "<button " + '<?= $vinnauto['button_code'] ?>' + " data-vinn-widget=" + '<?= $vinn ?>' + "> " + '<?= $vinnauto['button_text'] ?>' + " </button>";

			elm.insertAdjacentElement('<?= $vinnauto['button_position'] ?>', btn);

			<?php
			$script_url = "https://vinnauto.com/checkout.v1.js";
			echo "\nsm_include_script('$script_url', 'head');\n";
		}
    ?>
