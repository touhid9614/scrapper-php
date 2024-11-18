window.addEventListener('message', (evt) => {
    if (event.origin == "https://app.autoverify.com" &&
    (evt.data.path == "/desktop/test-drive/request-submitted" ||
    evt.data.path == "/mobile/test-drive/request-submitted")) {
        const parameters = {
            content_type: "vehicle",
            country     : "Canada",
            postal_code : "E1E 1C9",
            page_type   : sMedia.Context.PageType,
            url         : window.location.href
        };

        window.fbq("trackSingle", "1858540934178319", "Schedule", {...parameters, ...{event_name  : "Schedule"}});
        console.log(`sMedia: Tracking fbq('trackSingle', 'Schedule')`);
        window.fbq("trackSingle", "1858540934178319", "Lead", {...parameters, ...{event_name  : "Lead"}});
        console.log(`sMedia: Tracking fbq('trackSingle', 'Lead')`);
        // ga("smedia_analytics_tracker.send", "event", "fb_Schedule", "facebook event", "", {nonInteraction: false});
        // ga("smedia_analytics_tracker.send", "event", "fb_Lead", "facebook event", "", {nonInteraction: false});
    }
}, false);