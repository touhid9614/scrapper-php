console.log("Tradesmart script start", install_trade_smart);

if (install_trade_smart) {
    var settings = abTestOptions.trade["trade-smart"];

    for (let n in settings) {
        let s = settings[n];
        let p = new RegExp(s.pattern);

        if (p.test(location.href)) {
            var selector = s.selector;
            var fullview = s.fullview;
            var insertMethod = s.insert_method;
            break;
        }
    }

    if (!!selector) {
        var container = $(selector);
        console.log("Tradesmart selector", container);

        if (container.length) {
            $("#tradepending-container").remove();
            var html = '<div id="trade-loading" style=" width: 100%; background-color: #eeeeed; height: 500px; text-align: center;"><img style="margin-top: 220px;" src="https://tm.smedia.ca/adwords3/templates/balls.svg"></div><div id="smatp_trade_tool" style="display: none;"></div> <span class="smedia_powered_by" style="text-align: right; display: none; padding: 5px;"> Powered by: <a href="https://www.vroomance.com/" target="_blank"><img src="https://tm.smedia.ca/vroomance.png" alt="Vroomance" style="margin-bottom:-5px" height="20px"></a></span>';

            if (fullview) {
                html = '<div id="trade-loading" style=" width: 100%; background-color: #eeeeed; height: 500px; text-align: center;"><img style="margin-top: 220px;" src="https://tm.smedia.ca/adwords3/templates/balls.svg"></div><div id="smatp_trade_tool" data-view="full" style="display: none;"></div><span class="smedia_powered_by" style="text-align: right; display: none; padding: 5px;">Powered by:<a href="https://www.vroomance.com/" target="_blank"><img src="https://tm.smedia.ca/vroomance.png" alt="Vroomance" style="margin-bottom:-5px" height="20px"></a></span>';
            }

            switch (insertMethod) {
                case "html":
                    container.html(html);
                    break;
                case "before":
                    container.before(html);
                    break;
                case "after":
                    container.after(html);
                    break;
            }
        }
    }
}

console.log("Tradesmart script end ");