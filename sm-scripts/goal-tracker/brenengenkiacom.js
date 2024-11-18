if (!window.customGoalTracker) {
    window.customGoalTracker = true;

    function chatClose() {
        var chatCloseBtn = sMedia.dom.find('.gg-chat-close');
        if (chatCloseBtn.length && !window.CgtChatCloseTracker) {
            window.CgtChatCloseTracker = true;
            chatCloseBtn.click(function(_) {
                ga_send("CPE-Chat Complete");
            });
        }
    }

    /* Chat events */
    sMedia.dom.find('.gg-chat-bubble').click(function(_) {
        ga_send("CPE-Chat-Start");
        setTimeout(function() {
            chatClose()
        }, 3000)
    });
    chatClose()

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
    sMedia.dom.find('form[data-form-type="contact-us"]').submit(function(_) {
        setTimeout(function() {
            if (sMedia.dom.el(this).find('.parsley-error').length == 0) {
                ga_send("CPE-Conversion-Forms", "submit");
            }
        }, 300)
    });

    sMedia.dom.find('form[data-form-type="get-a-quote"],form[data-form-type="test-drive"]').submit(function(_) {
        setTimeout(function() {
            if (sMedia.dom.el(this).find('.parsley-error').length == 0) {
                ga_send("CPE-Lead Form", "submit");
            }
        }, 300)
    });

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