<?php

class Tracker
{
	public  $analytics_property_id, $fb_pixel_id, $snapchat_pixel_id, $bing_tag_id;
	private $analytics_inited, $fbq_inited, $snapchat_inited, $bing_inited;

	public function __construct($analytics_property_id = null, $fb_pixel_id = null)
	{
		$this->analytics_property_id = $analytics_property_id;
		$this->fb_pixel_id           = $fb_pixel_id;
	}

	public function ga_init()
	{
		global $user_unique_id;

		if (!$this->analytics_property_id) {
			return false;
		}

		if ($this->analytics_inited) {
			return true;
		}
?>
		if (typeof ga !== 'function') {
			(function (i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date(); a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g; m.parentNode.insertBefore(a, m)
			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
		}
		ga('create', '<?= $this->analytics_property_id ?>', 'auto', 'smedia_analytics_tracker');
		ga('smedia_analytics_tracker.set', 'dimension2', '<?= $user_unique_id ?>');
	<?php
		$this->analytics_inited = true;
		return $this->analytics_inited;
	}

	public function fb_init()
	{
		if (!$this->fb_pixel_id) {
			return false;
		}
		if ($this->fbq_inited) {
			return true;
		}
		echo "console.log(\"sMedia Initializing fbq('init', '{$this->fb_pixel_id}')\");\n";
	?>
		!function(f, b, e, v, n, t, s) {
		    if (f.fbq) {
		    	return;
		    }

		    n = f.fbq = function() {
		        n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
		    };

		    if (!f._fbq) {
		    	f._fbq = n;
		    }

		    n.push = n;
		    n.loaded = !0;
		    n.version = '2.0';
		    n.queue = [];
		    t = b.createElement(e);
		    t.async = !0;
		    t.src = v;
		    s = b.getElementsByTagName(e)[0];
		    s.parentNode.insertBefore(t, s)
		}(window, document, 'script', '//connect.facebook.net/en_US/fbevents.js');

		fbq('init', '<?= $this->fb_pixel_id ?>');
	<?php
		$this->fbq_inited = true;
		return $this->fbq_inited;
	}

	public function snapchat_init()
	{
		if (!$this->snapchat_pixel_id) {
			return false;
		}

		if ($this->snapchat_inited) {
			return true;
		}
	?>
		(function(e, t, n) {
		    if (e.snaptr) {
		    	return;
		    }

		    var a = e.snaptr = function() {
		        a.handleRequest ? a.handleRequest.apply(a, arguments) : a.queue.push(arguments)
		    };

		    a.queue = [];
		    var s = 'script';
		    r = t.createElement(s);
		    r.async = !0;
		    r.src = n;
		    var u = t.getElementsByTagName(s)[0];
		    u.parentNode.insertBefore(r, u);
		})(window, document, 'https://sc-static.net/scevent.min.js');

		snaptr('init', '<?= $this->snapchat_pixel_id ?>', {});
	<?php
		$this->snapchat_inited = true;
		return $this->snapchat_inited;
	}

	public function ba_init()
	{
		if (!$this->bing_tag_id) {
			return false;
		}

		if ($this->bing_inited) {
			return true;
		}
		?>

		(function(w, d, t, r, u) {
		    var f, n, i;

		    w[u] = w[u] || [], f = function() {
		        var o = {
		            ti: "<?= $this->bing_tag_id ?>"
		        };
		        o.q = w[u], w[u] = new UET(o), w[u].push("pageLoad")
		    },
		    n = d.createElement(t),
		    n.src = r, n.async = 1,
		    n.onload = n.onreadystatechange = function() {
		        var s = this.readyState;
		        s && s !== "loaded" && s !== "complete" || (f(), n.onload = n.onreadystatechange = null)
		    },
		    i = d.getElementsByTagName(t)[0], i.parentNode.insertBefore(n, i)
		})(window, document, "script", "//bat.bing.com/bat.js", "uetq");

		window.uetq = window.uetq || [];

		<?php
		$this->bing_inited = true;
		return $this->bing_inited;
	}

	/**
	 *
	 * @param type $event
	 * @param type $parameters
	 * @param type $after       After number of seconds
	 */
	public function fbq($event, $parameters = null, $after = 0)
	{
		if ($this->fb_init()) {
			$m_after = $after * 1000;
			$extra_param = $this->wrap_params($parameters);

			echo "\n";
			if ($after) {
				$extra_param = str_replace('"', "'", $extra_param);
				echo "setTimeout(\"";
			}
			echo "console.log(\"sMedia Tracking fbq('track', '$event')\");\n";
			echo "fbq('track', '$event'$extra_param)";

			if ($after) {
				echo "\", $m_after);";
			} else {
				echo ";";
			}

			echo "\n";
		}
	}

	private function wrap_params($parameters)
	{
		if ($parameters) {
			if (!is_array($parameters)) {
				$parameters = array($parameters);
			}

			array_walk($parameters, function (&$v) {
				$v = json_encode($v);
			});

			$parameters = implode(', ', $parameters);
			$extra_param = ", $parameters";
		} else {
			$extra_param = '';
		}

		return $extra_param;
	}

	/**
	 *
	 * @param type $event
	 * @param type $parameters
	 * @param type $after       After number of seconds
	 */
	public function ga($event, $parameters = null, $after = 0)
	{
		if ($this->ga_init()) {
			$m_after = $after * 1000;
			$extra_param = $this->wrap_params($parameters);

			echo "\n";

			if ($after) {
				$extra_param = str_replace('"', "'", $extra_param);
				echo "setTimeout(\"";
			}

			echo "ga('smedia_analytics_tracker.send','$event'$extra_param)";

			if ($after) {
				echo "\", $m_after);";
			} else {
				echo ";";
			}

			echo "\n";
		}
	}

	public function ba($action, $category, $label, $after = 0)
	{
		if ($this->ba_init()) {
			$m_after = $after * 1000;
			echo "\n";

			if ($after) {
				echo "setTimeout(ba, $m_after, '$action', '$category', '$label', $after);";
			} else {
				echo "ba('$action', '$category', '$label', $after);";
			}

			echo "\n";
		}
	}

	public function snaptr($event, $parameters = null, $after = 0)
	{
		if (!$this->snapchat_init()) {
			return;
		}

		$m_after = $after * 1000;
		$extra_param = '';

		if ($parameters) {
			$extra_param = ', ' . json_encode($parameters);
		}

		echo "\n";

		if ($after) {
			echo "setTimeout(function(){\n";
		}

		echo "console.log(\"sMedia Tracking snaptr('track', '$event')\");\n";
		echo "snaptr('track', '$event'$extra_param);\n";

		if ($after) {
			echo "}, $m_after);";
		}

		echo "\n";
	}
}
