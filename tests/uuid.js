function get_smedia_uuid() {
    if (typeof sMedia.XDomainCookie !== 'undefined') {
        console.log("Requesting for Cookie to load smart offer");
        sMedia.XDomainCookie.get('smedia_uuid', function(uuid) {
            console.log("sMedia UUID:");
            console.log(uuid);
            console.log("sMedia Session Id:");
            console.log(sMedia.Context.Browser.sessionId);
        });
    } else {
        console.log("Waiting for Cookie to load smart offer");
        setTimeout(get_smedia_uuid, 1000);
    }
}

get_smedia_uuid();