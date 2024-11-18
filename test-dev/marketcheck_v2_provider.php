<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir       = dirname(__DIR__);
$adwords_dir    = "{$base_dir}/adwords3";
$log_path   	= "{$adwords_dir}/caches/marketcheck-test/marketcheck_v2.log";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $proxy_list;

// Web Providers
$web_providers = [
	'foxdealer' 		=> '/.*foxdealer\.com.*/i', 						// foxdealer.com
	'vinads' 			=> '/.*vinads\.com.*/i', 							// vinads.com
	'aftens' 			=> '/.*amcreative\.com.*/i', 						// amcreative.com
	'aftens' 			=> '/.*aftens\.com.*/i', 							// aftens.com
	'dealrcloud' 		=> '/.*dealrcloud\.com.*/i', 						// dealrcloud.com
	'dealrcloud' 		=> '/.*dealr\.cloud.*/i', 							// dealr.cloud
	'dealerscloud' 		=> '/.*dealerscloud\.com.*/i', 						// dealerscloud.com
	'northtxautos' 		=> '/.*northtxautos\.com.*/i', 						// northtxautos.com
	'carguywebdesign' 	=> '/.*carguywebdesign\.com.*/i', 					// carguywebdesign.com
	'pcswebdesign' 		=> '/.*pcswebdesign\.com.*/i', 						// pcswebdesign.com
	'autocorner' 		=> '/.*autocorner\.com.*/i', 						// AutoCorner.com
	'zopdealer' 		=> '/.*zopdealer\.com.*/i', 						// zopdealer.com
	'wiseit' 			=> '/.*wiseit\.com.*/i', 							// wiseit.com
	'wiseit' 			=> '/.*autoactionsoftware\.com.*/i', 				// autoactionsoftware.com
	'luminary2' 		=> '/.*luminary2\.com.*/i', 						// luminary2.com
	'itjames' 			=> '/.*itjames\.com.*/i', 							// itjames.com
	'edealer' 			=> '/.*edealer\.ca.*/i', 							// edealer.ca
	'autodealertech' 	=> '/.*autodealertech\.co.*/i', 					// autodealertech.co
	'autodealertech'	=> '/.*automotivedealertech\.com.*/i',				// automotivedealertech.com
	'autodatasolutions'	=> '/.*autodatasolutions\.com.*/i',					// autodatasolutions.com
	'autodatasolutions'	=> '/.*autodatadirect\.com.*/i',					// autodatadirect.com
	'autowebexpress'	=> '/.*autowebexpress\.com.*/i',					// autowebexpress.com
	'dealer' 			=> '/.*\/dealer\.com.*/i', 							// dealer.com
	'dealer' 			=> '/.*\.dealer\.com.*/i', 							// dealer.com
	'areacars' 			=> '/.*areacars\.com.*/i', 							// areacars.com
	'dealermc' 			=> '/.*dealermc\.com.*/i', 							// dealermc.com
	'blackbmedia' 		=> '/.*blackbmedia\.com.*/i', 						// blackbmedia.com
	'autoaubaine' 		=> '/.*autoaubaine\.com.*/i', 						// autoaubaine.com
	'autotrader' 		=> '/.*\/tadvantage-logos\/.*/i', 					// autotrader.ca
	'dealersiteplus' 	=> '/.*dealersiteplus\.ca.*/i', 					// dealersiteplus.ca
	'dealersiteplus' 	=> '/.*dealers\.carpages\.ca.*/i', 					// dealers.carpages.ca
	'dealersiteplus' 	=> '/.*logo-dealersiteplus.*/i', 					// dealersiteplus.ca
	'westoffour' 		=> '/.*westoffour\.com.*/i', 						// westoffour.com
	'dillonstienike' 	=> '/.*dillonstienike\.com.*/i', 					// dillonstienike.com
	'autoshotservices' 	=> '/.*autoshotservices\.com.*/i', 					// autoshotservices.com
	'autolinkme' 		=> '/.*autolinkme\.com.*/i', 						// autolinkme.com
	'orcasitetech' 		=> '/.*orcasitetech\.com.*/i', 						// orcasitetech.com
	'yourcarlot' 		=> '/.*yourcarlot\.com.*/i', 						// yourcarlot.com
	'dealerclick' 		=> '/.*dealerclick\.com.*/i', 						// dealerclick.com
	'cdkglobal' 		=> '/.*cdk\.com.*/i', 		    					// cdkglobal.com
	'dealerinspire' 	=> '/.*dealerinspire\.com.*/i', 					// dealerinspire.com
	'dealerspike' 		=> '/.*dealerspike\.com.*/i', 						// dealerspike.com
	'strathcom' 		=> '/.*strathcom\.com.*/i', 						// strathcom.com
	'convertus' 		=> '/.*convertus\.com.*/i', 						// convertus.com
	'ipssolutions' 		=> '/.*ipssolutions\.com.*/i', 						// ipssolutions.com
	'ipssolutions' 		=> '/.*greenbaywebdesigncompany\.com.*/i', 			// greenbaywebdesigncompany.com	// same as ipssolutions
	'webxloo' 			=> '/.*webxloo\.com.*/i', 							// webxloo.com
	'redknight' 		=> '/.*redknight\.com.*/i', 						// redknight.com
	'gorillathemes' 	=> '/.*gorillathemes\.com.*/i', 					// gorillathemes.com
	'redxwebdesign' 	=> '/.*redxwebdesign\.com.*/i', 					// redxwebdesign.com
	'autoadmanager' 	=> '/.*autoadmanager\.com.*/i', 					// autoadmanager.com
	'chrsinteractive' 	=> '/.*chrsinteractive\.com.*/i', 					// chrsinteractive.com
	'goxeedealer' 		=> '/.*goxeedealer\.com.*/i', 						// goxeedealer.com
	'gstockco' 			=> '/.*gstockco\.com.*/i', 							// gstockco.com
	'autosearchtech' 	=> '/.*autosearchtech\.com.*/i', 					// autosearchtech.com
	'carthink' 			=> '/.*carthink\.com.*/i', 							// carthink.com
	'dealereprocess' 	=> '/.*dealereprocess.*/i', 						// dealereprocess.org or .com
	'openrealty' 		=> '/.*open-realty\.org.*/i', 						// open-realty.org
	'forddirect' 		=> '/.*forddirect\.com.*/i', 						// forddirect.com
	'midealervirtual' 	=> '/.*midealervirtual\.com.*/i', 					// midealervirtual.com
	'autopublishers' 	=> '/.*autopublishers\.com.*/i', 					// autopublishers.com
	'shiftpointsolution'=> '/.*shiftpointsolution\.com.*/i', 				// shiftpointsolution.com
	'seoadvantage' 		=> '/.*seoadvantage\.com.*/i', 						// seoadvantage.com
	'dealeron' 			=> '/.*dealeron\.com.*/i', 							// dealeron.com
	'majux' 			=> '/.*majux\.com.*/i', 							// majux.com
	'vinlist' 			=> '/.*vinlist\.com.*/i', 							// vinlist.com
	'mach20autos' 		=> '/.*mach20autos\.com.*/i', 						// mach20autos.com
	'finalcom' 			=> '/.*finalcom\.net.*/i', 							// finalcom.net
	'webtechs' 			=> '/.*webtechs\.net.*/i', 							// webtechs.net
	'dealerseo' 		=> '/.*dealerseo\.net.*/i', 						// dealerseo.net
	'dealerseo' 		=> '/.*stevetackett\.com.*/i', 						// stevetackett.com	// same as dealerseo
	'dealerseo' 		=> '/.*dealerleads\.com\/dealer-seo.*/i', 			// stevetackett.com	// same as dealerseo
	'optiauto' 			=> '/.*optiauto\.net.*/i', 							// optiauto.net
	'autosalesweb' 		=> '/.*autosalesweb\.net.*/i', 						// autosalesweb.net
	'sm360' 			=> '/.*sm360\.ca.*/i', 								// sm360.ca
	'inv360' 			=> '/.*inv360\.app/i', 								// inv360.app
	'360' 				=> '/.*360\.agency.*/i', 							// 360.agency
	'dealercarsearch' 	=> '/.*dealercarsearch\.com.*/i', 					// dealercarsearch.com
	'psone' 			=> '/.*psone\.ca.*/i', 								// psone.ca
	'dealerdirect' 		=> '/.*dealerdirect\.eu.*/i', 						// dealerdirect.eu
	'fzautomotive' 		=> '/.*fzautomotive\.com.*/i', 						// fzautomotive.com
	'williamsweb' 		=> '/.*williamsweb\.com.*/i', 						// williamsweb.com
	'rndinteractive' 	=> '/.*rndinteractive\.com.*/i', 					// rndinteractive.com
	'autorevo' 			=> '/.*autorevo\.com.*/i', 							// autorevo.com
	'nissanusa' 		=> '/.*nissanusa\.com.*/i', 						// nissanusa.com
	'dealerfire'		=> '/.*dealerfire\.com.*/i', 						// dealerfire.com
	'autosweet'			=> '/.*autosweet\.com.*/i', 						// autosweet.com
	'dealerx'			=> '/.*dealerx\.com.*/i', 							// dealerx.com
	'chromacars'		=> '/.*chromacars\.com.*/i', 						// chromacars.com
	'mindspank'			=> '/.*mindspank\.com.*/i', 						// mindspank.com
	'autoconx'			=> '/.*autoconx\.com.*/i', 							// autoconx.com
	'automanager'		=> '/.*automanager\.com.*/i', 						// automanager.com
	'psmmarketing' 		=> '/.*psmmarketing\.com.*/i', 						// psmmarketing.com
	'higherturnover' 	=> '/.*higherturnover\.com.*/i', 					// higherturnover.com
	'slipstream' 		=> '/.*slipstreamcreative\.com.*/i', 				// slipstreamcreative.com
	'maverickmultimedia'=> '/.*maverickmultimedia\.com.*/i', 				// maverickmultimedia.com
	'localsearchmagic' 	=> '/.*localsearchmagic\.com.*/i', 					// localsearchmagic.com
	'carsforsale' 		=> '/.*carsforsale\.com.*/i', 						// carsforsale.com
	'carbase' 			=> '/.*carbase\.com.*/i', 							// carbase.com
	'dealercenter' 		=> '/.*dealercenter\.com.*/i', 						// dealercenter.com
	'tailbase' 			=> '/.*tailbase\.com.*/', 							// tailbase.com
	'interactrv' 		=> '/.*interactrv\.com.*/i', 						// interactrv.com
	'd2cmedia' 			=> '/.*d2cmedia\.ca.*/i', 							// d2cmedia.ca
	'd2cmedia' 			=> '/.*d2cmedia\.com.*/i', 							// d2cmedia.com
	'd2cmedia' 			=> '/.*evolio\.ca.*/i', 							// evolio.ca
	'arinet' 			=> '/.*arinet\.com.*/i', 							// arinet.com
	'passinglane' 		=> '/.*passinglane\.com.*/i', 						// passinglane.com
	'southfire' 		=> '/.*southfire\.com.*/i', 						// southfire.com
	'teamwilletts' 		=> '/.*teamwilletts\.com.*/i', 						// teamwilletts.com
	'cahillwebstudio' 	=> '/.*cahillwebstudio\.com.*/i', 					// cahillwebstudio.com
	'autocorner' 		=> '/.*autocorner\.com.*/i', 						// autocorner.com
	'Sokal' 			=> '/.*gosokal\.com.*/i', 							// sokal.com
	'dealerfront' 		=> '/.*dealerfront.*/i', 							// dealerfront
	'waynereaves' 		=> '/.*waynereaves\.com.*/i', 						// waynereaves.com
	'arvigmedia' 		=> '/.*arvigmedia\.com.*/i', 						// arvigmedia.com
	'autoxplorer' 		=> '/.*autoxplorer\.com.*/i', 						// autoxplorer.com
	'vehiclesnetwork' 	=> '/.*vehiclesnetwork\.com.*/i', 					// vehiclesnetwork.com
	'automatrix' 		=> '/.*automatrix\.com.*/i', 						// automatrix.com
	'jtzenterprise' 	=> '/.*jtzenterprise\.com.*/i', 					// jtzenterprise.com
	'teamvelocity' 		=> '/.*teamvelocitymarketing\.com.*/i', 			// teamvelocitymarketing.com
	'topmarketingagency' => '/.*topmarketingagency\.com.*/i', 				// topmarketingagency.com
	'advancedauto'		=> '/.*advancedautodealers\.com.*/i', 				// advancedautodealers.com
	'alaskasearch' 		=> '/.*alaskasearchmarketing\.com.*/i', 			// alaskasearchmarketing.com
	'damascoinnovations' => '/.*damascoinnovations\.com.*/i', 				// damascoinnovations.com
	'ezresults' 		=> '/.*ez-results\.ca.*/i', 						// EzResults.ca
	'searchoptics' 		=> '/.*searchoptics.*/i', 							// searchoptics.net or .com
	'dealerbible'		=> '/.*dealerbible\.com.*/i',						// dealerbible.com
	'dealersync'		=> '/.*dealersync\.com.*/i',						// dealersync.com
	'lotwizard'			=> '/.*lotwizard\.com.*/i',							// lotwizard.com
	'carcasm'			=> '/.*carcasm\.com.*/i',							// carcasm.com
	'dealervenom'		=> '/.*dealervenom\.com.*/i',						// dealervenom.com
	'surgemetrix'		=> '/.*surgemetrix\.com.*/i',						// surgemetrix.com
	'nakedlime'			=> '/.*nakedlime\.com.*/i',							// nakedlime.com
	'autofusion'		=> '/.*autofusion\.com.*/i',						// autofusion.com
	'jazelauto'			=> '/.*jazelauto\.com.*/i',							// jazelauto.com
	'pixelmotion'		=> '/.*pixelmotiondemo\.com.*/i',					// pixelmotiondemo.com
	'remora'			=> '/.*remora\.com.*/i',							// remora.com
	'321ignition'		=> '/.*321ignition\.com.*/i',						// 321ignition.com
	'steeringinnovation' => '/.*steeringinnovation\.com.*/i',				// steeringinnovation.com
	'sterlingemarketing' => '/.*sterlingemarketing\.com.*/i',				// sterlingemarketing.com
	'nabthat'			=> '/.*nabthat\.com.*/i',							// nabthat.com
	'indigimar'			=> '/.*indigimar\.com.*/i',							// indigimar.com
	'fullthrottle'		=> '/.*fullthrottle\.ai.*/i',						// fullthrottle.ai
	'driverseat'		=> '/.*driverseat\.io.*/i',							// driverseat.io
	'v12soft'			=> '/.*v12soft\.com.*/i',							// v12soft.com
	'gammastream'		=> '/.*gamma\.stream.*/i',							// gamma.stream
	'baschsolutions'	=> '/.*baschsolutions\.com.*/i',					// baschsolutions.com
	'digisphere'		=> '/.*digispheremarketing\.com.*/i',				// digispheremarketing.com
	'marketmastersmedia' => '/.*marketmastersmedia\.com.*/i',				// marketmastersmedia.com
	'trafficcontrol'	=> '/.*trafficcontrolmarketing\.com.*/i',			// trafficcontrolmarketing.com
	'kgi'				=> '/.*dealersolutionssoftware\.com.*/i',			// dealersolutionssoftware.com
	'autodealer'		=> '/.*autodealerwebsiteproviders\.com.*/i',		// autodealerwebsiteproviders.com
	'stevendigital'		=> '/.*stevendigital\.com.*/i',						// stevendigital.com
	'promax' 			=> '/.*promaxunlimited\.com.*/i',					// promaxunlimited.com
	'allautonetwork' 	=> '/.*allautonetwork\.com.*/i',					// allautonetwork.com
	'westadvertising' 	=> '/.*westadvertising\.com.*/i',					// westadvertising.com
	'inshoremarketing' 	=> '/.*inshoremarketing\.com.*/i',					// inshoremarketing.com
	'mannainteractive' 	=> '/.*mannainteractive\.com.*/i',					// mannainteractive.com
	'level5advertising' => '/.*level5advertising\.com.*/i',					// level5advertising.com
	'datamomentum'		=> '/.*datamomentum\.com.*/i',						// datamomentum.com
	'dealerslink'		=> '/.*dealerslink\.com.*/i',						// dealerslink.com
	'motorlot'			=> '/.*motorlot\.com.*/i',							// motorlot.com
	'ebizautos'			=> '/.*ebizautos\.com.*/i',							// ebizautos.com
	'autowall'			=> '/.*gratistech\.com.*/i',						// gratistech.com
	'roadster'			=> '/.*roadster\.com.*/i',							// roadster.com
	'crmsuite'			=> '/.*crmsuite\.com.*/i',							// crmsuite.com
	'usagnet'			=> '/.*usagnet\.com.*/i',							// usagnet.com
	'advp'				=> '/.*advp\.com.*/i',								// advp.com
	'idweb'				=> '/.*idweb\.io.*/i',								// idweb.io
	'autofunds'			=> '/.*autofunds\.com.*/i',							// autofunds.com
	'asnsoftware'		=> '/.*asnsoftware\.com.*/i',						// asnsoftware.com
	'motionfuze'		=> '/.*motionfuze\.com.*/i',						// motionfuze.com
	'datgate'			=> '/.*datgate\.com.*/i',							// datgate.com
	'leadbox'			=> '/.*leadboxhq\.com.*/i',							// leadboxhq.com
	'leadbox'			=> '/.*leadbox.*/i',								// leadboxhq.com
	'autojini'			=> '/.*autojini\.com.*/i',							// autojini.com
	'autowebing'		=> '/.*autowebing\.com.*/i',						// autowebing.com
	'dealerwebsites'	=> '/.*dealerwebsites\.com.*/i',					// dealerwebsites.com
	'speeddigital'		=> '/.*speeddigital\.com.*/i',						// speeddigital.com
	'dealergeek'		=> '/.*dealergeek\.com.*/i',						// dealergeek.com
	'dealergeek'		=> '/.*\/images\/dealer-greek-logo\.png/i',			// dealergeek.com
	'terrostar'			=> '/.*terrostar\.com.*/i',							// terrostar.com
	'novosteer'			=> '/.*novosteer\.com.*/i',							// novosteer.com
	'dealerjump'		=> '/.*dealerjump\.com.*/i',						// dealerjump.com
	'treasuredata'		=> '/.*treasuredata\.com.*/i',						// treasuredata.com
	'flexdealer'		=> '/.*flexdealer\.com.*/i',						// flexdealer.com
	'mapledesigns'		=> '/.*mapledesigns\.ca.*/i',						// mapledesigns.ca
	'standish'			=> '/.*standish\.ca.*/i',							// standish.ca
	'magnetis'			=> '/.*magnetis\.ca.*/i',							// magnetis.ca
	'carfire'			=> '/.*carfire\.ca.*/i',							// carfire.ca
	'verteb'			=> '/.*verteb\.ca.*/i',								// verteb.ca
	'bwebauto'			=> '/.*bwebauto\.ca.*/i',							// bwebauto.ca
	'autobunny'			=> '/.*autobunnydealersolutions\.ca.*/i',			// autobunnydealersolutions.ca
	'godaddy'			=> '/.*godaddy\.com\/websites\/web-design.*/i',		// godaddy.com
	'digitalarmyrangers' => '/.*\/company\/digital-army-rangers.*/i',		// digitalarmyrangers
	'motorcentral' 		=> '/.*motorcentral\.co\.nz.*/i' 					// motorcentral.co.nz
];

$cloudflare = "/.*cloudflare.*/";
$cloudfront = "/.*cloudfront.*/";

$marketcheck_table = "marketcheck_dealers_v2";

$start_id 	= isset($_GET['start_id']) ? intval(filter_input(INPUT_GET, 'start_id')) : false;
$limit 		= isset($_GET['limit']) ? intval(filter_input(INPUT_GET, 'limit')) : false;

if (isset($argv)) {
	$arguments 	= $argv[1];
	$output 	= explode(":", $arguments, 3);
	$start_id 	= intval($output[0]);
	$limit 		= intval($output[1]);
	$instance 	= intval($output[2]);
	$log_path   = "{$adwords_dir}/caches/marketcheck-test/marketcheck_v2_{$instance}.log";
	writeLog($log_path, "Received {$start_id}, {$limit} & {$instance} as arguments for website_provider.");
}

$db_connect = new DbConnect('');
$existing 	= [];
$query 		= "SELECT dealer_id, inventory_url FROM {$marketcheck_table} WHERE (website_provider IS NULL) ORDER BY dealer_id ASC;";

if ($start_id) {
	$query 	= "SELECT dealer_id, inventory_url FROM {$marketcheck_table} WHERE (website_provider IS NULL AND dealer_id >= {$start_id}) ORDER BY dealer_id ASC;";
}

if ($limit) {
	$query 	= "SELECT dealer_id, inventory_url FROM {$marketcheck_table} WHERE (website_provider IS NULL) ORDER BY dealer_id ASC LIMIT {$limit};";
}

if ($start_id && $limit) {
	$query 	= "SELECT dealer_id, inventory_url FROM {$marketcheck_table} WHERE (website_provider IS NULL AND dealer_id >= {$start_id}) ORDER BY dealer_id ASC LIMIT {$limit};";
}

$result = $db_connect->query($query);

while ($row = mysqli_fetch_assoc($result)) {
	$existing[$row['dealer_id']] = $row['inventory_url'];
}

foreach ($existing as $id => $inventory_url) {
	$root_reponse 	= HttpGet($inventory_url, true, true);

	if (!$root_reponse) {
		$provider_query =  " website_provider = 'SITE_UNRESPONSIVE'";
		$lameResponse = lameHttp($inventory_url, true);

		if (preg_match($cloudflare, $lameResponse)) {
			$provider_query =  " website_provider = 'CLOUDFLARE_BLOCKED'";
		}

		if (preg_match($cloudfront, $lameResponse)) {
			$provider_query =  " website_provider = 'CLOUDFRONT_BLOCKED'";
		}
	} else {
		$provider_query = get_web_provider_query($root_reponse, $web_providers);
	}

	$query = "UPDATE {$marketcheck_table} SET {$provider_query} WHERE dealer_id = {$id};";
	$db_connect->query($query);
	writeLog($log_path, $query);
	// echo $query . "<br>";
}

$db_connect->close_connection();


/**
 * Gets the web provider query.
 *
 * @param      <type>  $response       The response
 * @param      <type>  $providers      The providers
 * @param      <type>  $inventory_url  The inventory url
 * @param      <type>  $proxy_list     The proxy list
 *
 * @return     string  The web provider query.
 */
function get_web_provider_query($response, $providers)
{
	$vendor = "N/A";

	foreach ($providers as $provider => $regex) {
		if (preg_match($regex, $response)) {
			$vendor = $provider;
			break;
		}
	}

	return " website_provider = '$vendor' ";
}
