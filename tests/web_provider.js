console.clear();
var sc = document.scripts;
var targetURL = 'https://tm.smedia.ca/tests/web_provider_db.php';
var dataString = `url=${encodeURIComponent(getDomain(window.location.href))}`;
var send = false;
var provider = '';

// Web Providers
$web_providers = {
	'foxdealer' 		:  new RegExp('.*foxdealer\.com.*', 'gi'), 							// foxdealer.com
	'edealer' 			:  new RegExp('.*edealer\.ca.*', 'gi'),								// edealer.ca
	'dealer' 			:  new RegExp('.*\.dealer\.com.*', 'gi'),							// dealer.com
	'cdkglobal' 		:  new RegExp('.*cdk\.com.*', 'gi'),		    					// cdkglobal.com
	'dealerinspire' 	:  new RegExp('.*dealerinspire\.com.*', 'gi'), 						// dealerinspire.com
	'dealerspike' 		:  new RegExp('.*dealerspike\.com.*', 'gi'), 						// dealerspike.com
	'strathcom' 		:  new RegExp('.*strathcom\.com.*', 'gi'),							// strathcom.com
	'convertus' 		:  new RegExp('.*convertus\.com.*', 'gi'), 							// convertus.com
	'dealereprocess' 	:  new RegExp('.*dealereprocess\.org.*', 'gi'), 					// dealereprocess.org
	'forddirect' 		:  new RegExp('.*forddirect\.com.*', 'gi'),							// forddirect.com
	'dealeron' 			:  new RegExp('.*dealeron\.com.*', 'gi'), 							// dealeron.com
	'sm360' 			:  new RegExp('.*sm360\.ca.*', 'gi'), 								// sm360.ca
	'360' 				:  new RegExp('.*360\.agency.*', 'gi'), 							// 360.agency
	'dealercarsearch' 	:  new RegExp('.*dealercarsearch\.com.*', 'gi'), 					// dealercarsearch.com
	'psone' 			:  new RegExp('.*psone\.ca.*', 'gi'), 								// psone.ca
	'dealerdirect' 		:  new RegExp('.*dealerdirect\.eu.*', 'gi'), 						// dealerdirect.eu
	'fzautomotive' 		:  new RegExp('.*fzautomotive\.com.*', 'gi'), 						// fzautomotive.com
	'rndinteractive' 	:  new RegExp('.*rndinteractive\.com.*', 'gi'), 					// rndinteractive.com
	'autorevo' 			:  new RegExp('.*autorevo\.com.*', 'gi'), 							// autorevo.com
	'nissanusa' 		:  new RegExp('.*nissanusa\.com.*', 'gi'), 							// nissanusa.com
	'dealerfire'		:  new RegExp('.*dealerfire\.com.*', 'gi'), 						// dealerfire.com
	'autosweet'			:  new RegExp('.*autosweet\.com.*', 'gi'), 							// autosweet.com
	'dealerx'			:  new RegExp('.*dealerx\.com.*', 'gi'), 							// dealerx.com
	'autoconx'			:  new RegExp('.*autoconx\.com.*', 'gi'), 							// autoconx.com
	'psmmarketing' 		:  new RegExp('.*psmmarketing\.com.*', 'gi'), 						// psmmarketing.com
	'carsforsale' 		:  new RegExp('.*carsforsale\.com.*', 'gi'), 						// carsforsale.com
	'carbase' 			:  new RegExp('.*carbase\.com.*', 'gi'), 							// carbase.com
	'dealercenter' 		:  new RegExp('.*dealercenter\.com.*', 'gi'), 						// dealercenter.com
	'tailbase' 			:  new RegExp('.*tailbase\.com.*', 'gi'), 							// tailbase.com
	'interactrv' 		:  new RegExp('.*interactrv\.com.*', 'gi'), 						// interactrv.com
	'd2cmedia' 			:  new RegExp('.*d2cmedia\.com.*', 'gi'), 							// d2cmedia.com
	'arinet' 			:  new RegExp('.*arinet\.com.*', 'gi'), 							// arinet.com
	'Sokal' 			:  new RegExp('.*gosokal\.com.*', 'gi'), 							// sokal.com
	'waynereaves' 		:  new RegExp('.*waynereaves\.com.*', 'gi'), 						// waynereaves.com
	'teamvelocity' 		:  new RegExp('.*teamvelocitymarketing\.com.*', 'gi'), 				// teamvelocitymarketing.com
	'ezresults' 		:  new RegExp('.*ez\-results\.ca.*', 'gi'), 						// EzResults.ca
	'searchoptics' 		:  new RegExp('.*searchoptics.*', 'gi'), 							// searchoptics.net or .com
	'dealerbible'		:  new RegExp('.*dealerbible\.com.*', 'gi'),						// dealerbible.com
	'dealersync'		:  new RegExp('.*dealersync\.com.*', 'gi'),							// dealersync.com
	'dealervenom'		:  new RegExp('.*dealervenom\.com.*', 'gi'),						// dealervenom.com
	'surgemetrix'		:  new RegExp('.*surgemetrix\.com.*', 'gi'),						// surgemetrix.com
	'nakedlime'			:  new RegExp('.*nakedlime\.com.*',	'gi'),							// nakedlime.com
	'autofusion'		:  new RegExp('.*autofusion\.com.*', 'gi'),							// autofusion.com
	'jazelauto'			:  new RegExp('.*jazelauto\.com.*', 'gi'),							// jazelauto.com
	'pixelmotion'		:  new RegExp('.*pixelmotiondemo\.com.*', 'gi'),					// pixelmotiondemo.com
	'remora'			:  new RegExp('.*remora\.com.*', 'gi'),								// remora.com
	'321ignition'		:  new RegExp('.*321ignition\.com.*', 'gi'),						// 321ignition.com
	'steeringinnovation':  new RegExp('.*steeringinnovation\.com.*', 'gi'),					// steeringinnovation.com
	'nabthat'			:  new RegExp('.*nabthat\.com.*', 'gi'),							// nabthat.com
	'indigimar'			:  new RegExp('.*indigimar\.com.*', 'gi'),							// indigimar.com
	'fullthrottle'		:  new RegExp('.*fullthrottle\.ai.*', 'gi'),						// fullthrottle.ai
	'v12soft'			:  new RegExp('.*v12soft\.com.*', 'gi'),							// v12soft.com
	'baschsolutions'	:  new RegExp('.*baschsolutions\.com.*', 'gi'),						// baschsolutions.com
	'digisphere'		:  new RegExp('.*digispheremarketing\.com.*', 'gi'),				// digispheremarketing.com
	'marketmastersmedia':  new RegExp('.*marketmastersmedia\.com.*', 'gi'),					// marketmastersmedia.com
	'trafficcontrol'	:  new RegExp('.*trafficcontrolmarketing\.com.*', 'gi'),			// trafficcontrolmarketing.com
	'stevendigital'		:  new RegExp('.*stevendigital\.com.*', 'gi'),						// stevendigital.com
	'promax' 			:  new RegExp('.*promaxunlimited\.com.*', 'gi'),					// promaxunlimited.com
	'ebizautos'			:  new RegExp('.*ebizautos\.com.*', 'gi'),							// ebizautos.com
	'usagnet'			:  new RegExp('.*usagnet\.com.*', 'gi'),							// usagnet.com
	'autojini'			:  new RegExp('.*autojini\.com.*', 'gi'),							// autojini.com
	'terrostar'			:  new RegExp('.*terrostar\.com.*', 'gi'),							// terrostar.com
	'standish'			:  new RegExp('.*standish\.ca.*', 'gi'),							// standish.ca
	'verteb'			:  new RegExp('.*verteb\.ca.*', 'gi'),								// verteb.ca
	'bwebauto'			:  new RegExp('.*bwebauto\.ca.*', 'gi'),							// bwebauto.ca
	'godaddy'			:  new RegExp('.*godaddy\.com\/websites\/web-design.*', 'gi'),		// godaddy.com
	'motorcentral' 		:  new RegExp('.*motorcentral\.co\.nz.*', 'gi') 					// motorcentral.co.nz
};

for (var i = 0, len = sc.length; i < len; i++) {
	var url = sc[i].src;

	if (true) {
		//
	}
}

/**
 * { Sends an ajax request to targetURL using dataString. }
 *
 * @param       string      targetURL       The target url
 * @param       string      dataString      The data string
 */
function sendAjax(targetURL, dataString) {
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.open("POST", targetURL, true);
	xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	xmlhttp.onload = function () {
		if (this.readyState == XMLHttpRequest.DONE || this.readyState == 4)   // XMLHttpRequest.DONE == 4
		{
			if (this.status == 200) {
				console.log(this.responseText);
			}
			else if (this.status == 400) {
				console.log('There was an error 400');
			}
			else {
				console.log('Something else other than 200 was returned');
			}
		}
	};

	xmlhttp.send(dataString);
}