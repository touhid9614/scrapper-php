if (sMedia.Context.PageType == 'vdp') {
    const sels = 'li.textbutton.invGetQuote, li.textbutton.invValueTrade, li.textbutton.invContactUs';
    const elms = document.querySelectorAll(sels)

    elms.forEach((elm) => {
        elm.addEventListener('click', () => {
            window.setTimeout(() => {
            	const submitBtn = document.querySelector('#btnSubmit');

				if (submitBtn) {
					submitBtn.addEventListener('click', () => {
						const carData = sMedia.Context.PageData.car_data;
						const vdpEventPayload = {
							content_type    : ['vehicle'],
							country         : "Canada",
							postal_code     : "K0C 1N0",
							currency        : "CAD",
							page_type       : 'vdp',
							event_name      : 'Lead',
							url 			: window.location.href,
							content_ids     : [carData.stock_number.trim()],
							stock_number    : carData.stock_number.trim(),
							year            : carData.year,
							make            : carData.make,
							model           : carData.model,
							price           : sMedia.priceToNumber(carData.price),
							state_of_vehicle: carData.stock_type,
							exterior_color  : carData.color,
							transmission    : carData.transmission,
							body_style      : carData.body_style,
							fuel_type       : carData.fuel_type,
							drivetrain      : carData.drivetrain,
							vin 			: carData.vin
						};

						window.fbq("trackSingle", "812966632922170", "Lead", vdpEventPayload);
				        console.log(`sMedia: Tracking fbq('trackSingle', 'Lead')`);
		        		// ga("smedia_analytics_tracker.send", "event", "fb_Lead", "facebook event", "", {nonInteraction: false});
					}, false);
				} else {
					console.log("sMedia: Form submit button not found.");
				}
            }, 3000);
        }, false);
    });
}