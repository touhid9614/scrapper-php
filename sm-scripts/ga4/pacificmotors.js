// 1. time on page as a goal in
// 2. A "Thank You" page that is generated after a client fills in a lead form.
// 3. Less likely - but a hidden field on the form with injected UTM code


if (/\/trade-in/.test(window.location.href)) {
    const finFormSubmitSel = document.querySelector('div.col-md-4.col-sm-6 > div.form > div.form-submit > button.btn.btn-default');
    
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