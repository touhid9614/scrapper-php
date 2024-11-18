if (/(#vehicle-quote-[0-9]{10})|(\/QuickQuoteForm)/.test(window.location.href)) {
	window.setTimeout(() => {
		const btnSel = 'div.text > div.copy > form > div.button-wrapper > button';
	    const btn    = document.querySelector(btnSel);

	    if (btn) {
		    btn.addEventListener('click', () => {
		        const otherEventPayload = {
					content_type    : ['vehicle'],
					country         : "Canada",
					postal_code     : "S0G 1S0",
					page_type       : sMedia.Context.PageType,
					event_name      : 'Lead',
					url 			: window.location.href
				};

				window.fbq("trackSingle", "1880346758743640", "Lead", otherEventPayload);
		        console.log(`sMedia: Tracking fbq('trackSingle', 'Lead')`);
		        // ga("smedia_analytics_tracker.send", "event", "fb_Lead", "facebook event", "", {nonInteraction: false});
		    }, false);
		} else {
			console.log("sMedia: Form submit button not found.");
		}
    }, 3000);
}
