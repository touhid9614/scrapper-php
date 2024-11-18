window.addEventListener('message', (evt) => {
    if (event.origin == "https://calendly.com" &&
    window.location.pathname == "/book-a-test-drive/" &&
    evt.data.event == "calendly.event_scheduled") {
        const parameters = {
            content_type: "vehicle",
            country     : "Canada",
            postal_code : "S7J 5L3",
            page_type   : "other",
            url         : window.location.href
        };

        window.fbq("trackSingle", "1634040220181612", "Schedule", {...parameters, ...{event_name  : "Schedule"}});
        console.log(`sMedia: Tracking fbq('trackSingle', 'Schedule')`);
        window.fbq("trackSingle", "1634040220181612", "Lead", {...parameters, ...{event_name  : "Lead"}});
        console.log(`sMedia: Tracking fbq('trackSingle', 'Lead')`);
        // ga("smedia_analytics_tracker.send", "event", "fb_Schedule", "facebook event", "", {nonInteraction: false});
        // ga("smedia_analytics_tracker.send", "event", "fb_Lead", "facebook event", "", {nonInteraction: false});
    }
}, false);
