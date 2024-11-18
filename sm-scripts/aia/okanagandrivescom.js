if (/\/financing-application\//.test(window.location.href)) {
    window.setTimeout(() => {
        const btnSel = '#gform_submit_button_36';
        const btn = document.querySelector(btnSel);

        if (btn) {
            const callback = () => {
                const parameters = {
                    content_type: "vehicle",
                    country     : "Canada",
                    postal_code : "V1X 2K1",
                    page_type   : "other",
                    url         : window.location.href
                };
                console.log("Submit button pressed");
                window.fbq("trackSingle", "1215320145534798", "Contact", { ...parameters, ...{ event_name: "Contact" }});
                console.log(`sMedia: Tracking fbq('trackSingle', 'Contact')`);
                window.fbq("trackSingle", "1215320145534798", "Lead", { ...parameters, ...{ event_name: "Lead"}});
                console.log(`sMedia: Tracking fbq('trackSingle', 'Lead')`);
                // ga("smedia_analytics_tracker.send", "event", "fb_Schedule", "facebook event", "", {nonInteraction: false});
                // ga("smedia_analytics_tracker.send", "event", "fb_Lead", "facebook event", "", {nonInteraction: false});
            };
            sMedia.dom.find('body').on('click', '#gform_submit_button_36', callback)
        } else {
            console.log("sMedia: Form submit button not found.");
        }
    }, 3000);
}