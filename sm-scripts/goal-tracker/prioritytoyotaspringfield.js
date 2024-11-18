sMedia.dom.find(".dv-dealer-lang-es").click(function(_) {
    ga_send("ES-Selected");
});

function ga_send(cat, event, label) {
    ga(`smedia_analytics_tracker.send`, "event", cat, event ? event : null, label ? label : null);
}