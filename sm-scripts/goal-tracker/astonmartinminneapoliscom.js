if (!window.customGoalTracker) {
    window.customGoalTracker = true;

    /* Chat events */
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
    sMedia.dom.find('form.contact [type="submit"]').click(function(_) {
        ls_set_item("sMedia.formSubmit", "contact", 30000);
    });

    sMedia.dom.find('form[data-gf_title="Check Availability"] input[type="submit"], form[data-gf_title=^"Schedule"] input[type="submit"], form[data-gf_title="Get E-Price"] input[type="submit"]').click(function(_) {
        ls_set_item("sMedia.formSubmit", "lead", 30000);
    });

    if (/thank-you-for-/.test(location.href)) {
        var form = ls_get_item("sMedia.formSubmit");
        localStorage.removeItem("sMedia.formSubmit");
        switch (form) {
            case "contact":
                ga_send("CPE-Conversion-Forms", "submit");
                break;
            case "lead":
                ga_send("CPE-Lead Form", "submit");
                break;
        }
    }

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