
var sMedia = sMedia || {};

function get_smedia_uuid() {
    if (typeof sMedia.XDomainCookie !== 'undefined') {
        console.log("Requesting for uuid and session id");
        sMedia.XDomainCookie.get('smedia_uuid', function(uuid) {
            console.log("sMedia UUID: " + uuid);
            console.log("sMedia Session Id: " + sMedia.Context.Browser.sessionId);
        });
        
        console.log(sMedia.PageInfo);
    } else {
        console.log("Waiting for Cookie to load smart offer");
        setTimeout(get_smedia_uuid, 1000);
    }
}

get_smedia_uuid();