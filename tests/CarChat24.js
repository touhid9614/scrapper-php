console.clear();
var sc = document.scripts;
var nl = document.getElementsByTagName('iframe');
var tt = [];

// Trade In
var tv = new RegExp('.*tradevue.*', 'gi');                  //TradeVue
var tg = new RegExp('.*drivecarma\.ca\/.*', 'gi');          //TradeGauge
var ed = new RegExp('.*edmunds-media\.com\/.*', 'gi');      //Edmunds
var es = new RegExp('.*edmunds\.com\/.*', 'gi');            //Edmunds
var ti = new RegExp('.*tradesii\.com\/.*', 'gi');           //Tradesii
var at = new RegExp('.*accu\-trade\.com\/.*', 'gi');        //Accutrade
var tr = new RegExp('.*traderev\.com\/.*', 'gi');           //TradeRev
var tp = new RegExp('.*tradepending\.com\/.*', 'gi');       //TradePending
var kb = new RegExp('.*kbb\.com\/.*', 'gi');                //KellyBlueBook
var tc = new RegExp('.*truecar\.*', 'gi');                  //TrueCarTrade

var gg = new RegExp('.*gubagootracking\.com\/.*', 'gi');    //Gubagoo
var gb = new RegExp('.*gubagoo\.io\/.*', 'gi');             //Gubagoo
var fd = new RegExp('.*foxdealersites\.com\/.*', 'gi');     //Foxdealer
var fs = new RegExp('.*foxdealer\.com\/.*', 'gi');          //Foxdealer
var cc = new RegExp('.*carchat24\.com\/.*', 'gi');          //CarChat24
var cl = new RegExp('.*thelivechatsoftware\.com\/.*', 'gi');//LiveAdmins

var targetURL = 'https://tm.smedia.ca/tests/CarChat24_DB.php';
var dataString = 'url=' + encodeURIComponent(getDomain(window.location.href));


var send = false;

for (var i = 0, len = sc.length; i < len; i++)
{
    var url = sc[i].src;

    if (url == '')
    {
        continue;
    }

    tt.push(url);
}

for (var i = 0, len = nl.length; i < len; i++)
{
    var url = nl[i].src;

    if (url == '')
    {
        continue;
    }

    tt.push(url);
}

for (var i = 0, len = tt.length; i < len; i++)
{
    var url = tt[i];

	/*if (gg.test(url))
    {
        dataString += "&gubagoo=true";
        send = true;
    }

    if (fd.test(url))
    {
        dataString += "&foxdealer=true";
        send = true;
    }

    if (cc.test(url))
    {
        dataString += "&carchat24=true";
        send = true;
    }

    if (cc.test(url))
    {
        dataString += "&livechat=true";
        send = true;
    }*/

    if (tv.test(url))
    {
        dataString += "&TradeVue=true";
        send = true;
        console.log("Found TradeVue", url);
        //continue;
    }

    if (tg.test(url))
    {
        dataString += "&TradeGauge=true";
        send = true;
        console.log("Found TradeGauge", url);
        //continue;
    }

    if (ed.test(url))
    {
        dataString += "&Edmunds=true";
        send = true;
        console.log("Found Edmunds", url);
        //continue;
    }

    if (es.test(url))
    {
        dataString += "&Edmunds=true";
        send = true;
        console.log("Found Edmunds", url);
        //continue;
    }

    if (ti.test(url))
    {
        dataString += "&Tradesii=true";
        send = true;
        console.log("Found Tradesii", url);
        //continue;
    }

    if (at.test(url))
    {
        dataString += "&Accutrade=true";
        send = true;
        console.log("Found Accutrade", url);
        //continue;
    }

    if (tr.test(url))
    {
        dataString += "&traderev=true";
        send = true;
        console.log("Found traderev", url);
        //continue;
    }

    if (tr.test(url))
    {
        dataString += "&TradePending=true";
        send = true;
        console.log("Found TradePending", url);
        //continue;
    }

    if (kb.test(url))
    {
        dataString += "&KellyBlueBook=true";
        send = true;
        console.log("Found KellyBlueBook", url);
        //continue;
    }

    if (tc.test(url))
    {
        dataString += "&TrueCarTrade=true";
        send = true;
        console.log("Found TrueCarTrade", url);
    }
}

if (send)
{
    sendAjax(targetURL, dataString);
}


/**
 * if element exists in array.
 *
 * @param      {<type>}   arr     The arr
 * @param      {<type>}   val     The value
 * @return     {boolean}  { description_of_the_return_value }
 */
function in_array(arr, val)
{
    for (var i = 0, len = arr.length; i < len; i++)
    {
        if (arr[i] == val)
        {
            return true;
        }
    }

    return false;
}


/**
 * { Sends an ajax request to targetURL using dataString. }
 *
 * @param       string      targetURL       The target url
 * @param       string      dataString      The data string
 */
function sendAjax(targetURL, dataString)
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", targetURL , true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xmlhttp.onload = function ()
    {
		if (this.readyState == XMLHttpRequest.DONE || this.readyState == 4)   // XMLHttpRequest.DONE == 4
        {
            if (this.status == 200)
            {
                console.log(this.responseText);
            }
            else if (this.status == 400)
            {
                console.log('There was an error 400');
            }
            else
            {
                console.log('Something else other than 200 was returned');
            }
        }
    };

    xmlhttp.send(dataString);
}


/**
 * @brief       { function_description }
 * @param       url   { parameter_description }
 * @return      { description_of_the_return_value } */
function getHostName(url)
{
    var match = url.match(/:\/\/(www[0-9]?\.)?(.[^/:]+)/i);

    if (match != null && match.length > 2 && typeof match[2] === 'string' && match[2].length > 0)
    {
        return match[2];
    }
    else
    {
        return null;
    }
}


/**
 * @brief       { function_description }
 * @param       url   { parameter_description }
 * @return      { description_of_the_return_value } */
function getDomain(url)
{
    var hostName = getHostName(url);
    var domain = hostName;
    
    if (hostName != null)
    {
        var parts = hostName.split('.').reverse();
        
        if (parts != null && parts.length > 1)
        {
            domain = `${parts[1]}.${parts[0]}`;
                
            if (hostName.toLowerCase().indexOf('.co.uk') != -1 && parts.length > 2)
            {
              domain = parts[2] + '.' + domain;
            }
        }
    }
    
    return `https://www.${domain}`;
}