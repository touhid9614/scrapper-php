// Select the node that will be observed for mutations
var smedia_body_targetNode = document.body;
var smedia_tp_close_button = document.getElementById('cboxTPClose');

// Callback function to execute when mutations are observed
var callback = function(mutationsList, observer) {
    for(var mutation of mutationsList) {
        if (mutation.type === 'childList') {
            //console.log("Found cboxTPClose button, binding for event");
            smedia_tp_close_button = document.getElementById('cboxTPClose');
            
            if(smedia_tp_close_button) {
                smedia_attach_tp_closed(smedia_tp_close_button);
                // stop observing
                observer.disconnect();
            }
        }
    }
};

// Create an observer instance linked to the callback function
var observer = new MutationObserver(callback);

if(!smedia_tp_close_button) {
    //console.log("Starting observer to wait for cboxTPClose button");
    // Start observing the target node for configured mutations
    observer.observe(smedia_body_targetNode, { attributes: false, childList: true, subtree: true });
} else {
    smedia_attach_tp_closed(smedia_tp_close_button);
}

function smedia_attach_tp_closed(target) {
    //console.log("Trade Pending Closed event is being added");
    target.addEventListener("click", smedia_on_tp_closed, { once : true });
}

function smedia_on_tp_closed() {
    if(typeof fbq === 'function') {
        fbq('trackCustom', 'TradePending Close');
    }
}