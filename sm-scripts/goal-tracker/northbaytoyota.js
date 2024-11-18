sMedia.dom.find(".form-field__cta a.submit").click(function(e) {
    var text = e.target.innerText;
    var checkbox = sMedia.dom.find('input[name="newsletter|marketing|service"]').get(0);

    if (text) {
        localStorage.setItem("sMedia.FormSubmit", JSON.stringify({
            value: text,
            time: Date.now(),
        }));

        if (typeof checkbox.checked != "undefined" && checkbox.checked == true) {
            localStorage.setItem("sMedia.EmailSubscription", JSON.stringify({
                value: true,
                time: Date.now(),
            }));
        } else {
            localStorage.removeItem("sMedia.EmailSubscription");
        }
    }
});

sMedia.dom.find('input[type="submit"][value="Subscribe"]').click(function(e) {
    setTimeout(function() {
        if (!sMedia.dom.find(".errorMsg").text()) {
            ga(`smedia_analytics_tracker.send`, "event", "Sign up for email", "subcription");
        }
    }, 500);
});

if (/thank-you\?formId/.test(location.href)) {
    var form = JSON.parse(localStorage.getItem("sMedia.FormSubmit"));
    var subcription = JSON.parse(localStorage.getItem("sMedia.EmailSubscription"));
    var cat = null;
    localStorage.removeItem("sMedia.EmailSubscription");
    localStorage.removeItem("sMedia.FormSubmit");

    if (form && typeof form.value != "undefined") {
        switch (form.value.toLowerCase()) {
            case "get your price":
                cat = "Request a quote";
                break;
            case "book your test drive":
                cat = "Book a test drive";
                break;
            case "get your answer":
                cat = "Contact Us";
                break;
            default:
                cat = form.value.toLowerCase();
                break;
        }

        console.log("Additional goal tracking form: ", form);

        if (cat) {
            ga(`smedia_analytics_tracker.send`, "event", cat, "submit");
        }
    }

    if (subcription && typeof subcription.value != "undefined" && subcription.value == true) {
        console.log("Additional goal tracking subcription");
        ga(`smedia_analytics_tracker.send`, "event", "Sign up for email", "subcription");
    }
}