if (!window.customGoalTracker) {
    window.customGoalTracker = true;

    sMedia.dom.find('a[data-name="Chat Icon Button"]').click(function(_) {
        ga_send("CPE-Chat-Start");
    });

    sMedia.dom.find('a[data-name="Text Icon Button"], a[data-label="TEXT US"]').click(function(_) {
        ga_send("CPE-Text-Start");
    });

    window.addEventListener("message", (event) => {
        if (/collapse_to_minimum/.test(event.data)) {
            ga_send("CPE-Chat Complete");
        }
    });

    /* Call event */
    sMedia.dom.find("body").on("click", "a[href^=tel]", function(e) {
        var tel = ls_get_item("sMedia.telClick");
        var link = this;
        var sameLink = tel == link.href;
        console.log("is tel clicked before", tel);
        if (!sameLink) {
            e.preventDefault();
            ga_send("CPE-Click to Call");
            ls_set_item("sMedia.telClick", link.href, 3000);
            setTimeout(function() {
                link.click();
            }, 300);
        } else {
            localStorage.removeItem("sMedia.telClick");
        }
    });

    /* Form Events */
    sMedia.dom.find('form[name="ContactUsForm"]').submit(function(_) {
        setTimeout(function() {
            if (sMedia.dom.el(this).find('.invalid').length == 0) {
                ga_send("CPE-Conversion-Forms", "submit");
            }
        }, 300)
    });

    sMedia.dom.find('a[title="Schedule Test Drive"], a[title="Get This Vehicle"], a[title="Schedule At-Home Test Drive"], a[title="Watch Price"]').click(function() {
        var retry = 0;
        var intervalId = setInterval(function() {
            retry += 1;
            var form = sMedia.dom.find('form[name="AtHomeTestDrive"], form[name="GetAQuoteForm"], form[name="PriceWatch"]');

            if (form.length) {
                clearInterval(intervalId);
                form.submit(function(_) {
                    setTimeout(function() {
                        if (sMedia.dom.el(this).find('.invalid').length == 0) {
                            ga_send("CPE-Lead Form", "submit");
                        }
                    }, 300)
                });
            }
            if (retry > 20) {
                clearInterval(intervalId);
            }
        }, 500)
    })

    function ga_send(cat, event, label) {
        ga(`smedia_analytics_tracker.send`, "event", cat, event ? event : null, label ? label : null);
    }

    function ls_set_item(key, val, validity) {
        validity = isNaN(validity) ? 356 * 24 * 60 * 60 * 1000 : validity;
        localStorage.setItem(key, JSON.stringify({
            value: val,
            time: Date.now() + validity,
        }));
    }

    function ls_get_item(key) {
        try {
            var val = localStorage.getItem(key);
            val = JSON.parse(val);
            var age = val.time - Date.now();
            if (!!val && typeof val.value != "undefined" && typeof val.time != "undefined" && age > 0) {
                return val.value;
            }
        } catch (e) {
            console.error(e);
        }
        return null;
    }
}