if (!window.customGoalTracker) {
    window.customGoalTracker = true;
    sMedia.dom.find(".dvs_vin_btn a").click(function() {
        ga_send("WheelsTVClicked");
    });

    sMedia.dom.find("form.new_contact").submit(function() {
        setTimeout(function() {
            if (sMedia.dom.el(this).find("input.cf-error").length == 0) {
                ga_send("Contact Form", "submit");
            }
        }, 500);
    });

    sMedia.dom.find("body").on("submit", 'form[name="GetAQuoteForm"]', function() {
        setTimeout(function() {
            if (sMedia.dom.el(this).find("input.invalid").length == 0) {
                ga_send("Contact Form", "submit");
            }
        }, 500);
    });

    sMedia.dom.find('form[data-form-tracking-name="service-lead-intro"]').submit(function(_) {
        ls_set_item("sMedia.formSubmit", "contact", 15000);
    });

    if (/_action=SubmitServiceAppointment&formId=matthewsauto_service_lead_intro/.test(location.href)) {
        var form = ls_get_item("sMedia.formSubmit");
        localStorage.removeItem("sMedia.formSubmit");
        switch (form) {
            case "contact":
                ga_send("Contact Form", "submit");
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
            if (!!val && typeof val.value != "undefined" && typeof val.time != "undefined" && Date.now() < val.time) {
                return val.value;
            }
        } catch (e) {
            console.error(e);
        }
        return null;
    }
}