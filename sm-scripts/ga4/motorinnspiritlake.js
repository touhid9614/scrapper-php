if (/\/value-your-trade/.test(window.location.href)) {
    const finFormSubmitSel = document.querySelector("div > div.panel-body > div:nth-child(22) > div > input.btn.btn-success");
    const contaxtFormSubmitSel = document.querySelector("div.sidebar > div.panel.panel-default > div.panel-body > form > div:nth-child(10) > div > input.btn.btn-success");

    // Fire on form submit
    finFormSubmitSel.addEventListener('click', () => {
    	ga(
        	"smedia_analytics_tracker.send",
        	"event",
        	"accuisition_trade_in",
        	"accuisition event",
        	"accuisition_trade_in",
        	{ "nonInteraction": false }
        );
        console.log("sMedia: Sending accuisition_trade_in event to GA");
    });


    // Fire on contact us submit
    contaxtFormSubmitSel.addEventListener('click', () => {
        ga(
        	"smedia_analytics_tracker.send",
        	"event",
        	"accuisition_trade_in_contact_form",
        	"accuisition event",
        	"accuisition_trade_in_contact_form",
        	{ "nonInteraction": false }
        );
        console.log("sMedia: Sending accuisition_trade_in_contact_form event to GA");
    });
}
