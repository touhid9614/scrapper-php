
let endpoint_url    = 'https://tm.smedia.ca/jscrawler/api.php';
let dealership      = window.sMedia.dealership;
let act             = 'config';

let request_url     = endpoint_url + '?dealership=' + dealership + '&act=' + act;

try {
    $.ajax({
        type        : "GET",
        url         : request_url,
        crossDomain : true
    })
    .done(function(data, textStatus, jqXHR) {
        if(!data.success) {
            console.group("JS Scrapper : Config");
            console.log(data.error);
            console.groupEnd();
            return;
        }
        
        let page_url = document.location.href;
        let vdp_url_regex = new RegExp(data.result.vdp_url_regex);
        
        if(!page_url.match(vdp_url_regex)) {
            console.log("JSCrawler: Not VDP");
            return;
        }
        
        let result  = { idx : {}, data : {url : page_url} };
        let regex   = null, res = null, page_data = document.body.innerHTML;
        
        $.each(data.result.idx, function(key, regex_str){
            regex = new RegExp(regex_str);
            
            if((res = page_data.match(regex))) {
                result.idx[key] = res.groups[key].trim();
            }
        });
        
        $.each(data.result.data, function(key, regex_str){
            regex = new RegExp(regex_str);
            
            if((res = page_data.match(regex))) {
                result.data[key] = res.groups[key].trim();
            }
        });
        
        console.group("JS Scrapper");
        console.log(result);
        console.groupEnd();
        
        act         = 'update';
        request_url = endpoint_url + '?dealership=' + dealership + '&act=' + act;
        
        $.ajax({
            type        : "POST",
            url         : request_url,
            data        : JSON.stringify(result),
            contentType : "text/plain",
            crossDomain : true
        })
        .done(function(data, textStatus, jqXHR) {
            console.group("JS Scrapper : Update");
            if(!data.success) {
                console.log(data.error);
            } else {
                console.log(data.result);
            }
            console.groupEnd();
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.group("JS Scrapper");
            console.log('Status: ' + textStatus);
            console.log(jqXHR);
            console.log(errorThrown);
            console.groupEnd();
        })
        .always(function() {

        });
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.group("JS Scrapper");
        console.log('Status: ' + textStatus);
        console.log(jqXHR);
        console.log(errorThrown);
        console.groupEnd();
    })
    .always(function() {

    });
} catch(ex) {
    console.group("JS Scrapper");
    console.log(ex);
    console.groupEnd();
}