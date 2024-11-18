if (/\/value-my-sailboat\//.test(window.location.href)) {
    const finFormSubmitSel = document.querySelector('#gform_submit_button_11');
    
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
}