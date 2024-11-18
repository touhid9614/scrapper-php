/*jshint -W104*/
/*jshint -W119*/

const crossAllowedDomains = [
	"https://tm.smedia.ca",
	"https://tools.smedia.ca",
	"https://api.smedia.ca",
	"https://tradesmartapi.smedia.ca"
];

window.addEventListener("message", crossDomainLocalStorageHandler, false);

function crossDomainLocalStorageHandler(event) {
	if (!crossAllowedDomains.includes(event.origin)) {
		return;
	}

	const { action, key, value } = event.data;

	if (action == 'save') {
		window.localStorage.setItem(key, JSON.stringify(value));
		console.log("Cross Domain localStorage data saved", window.localStorage.getItem(key));
	} else if (action == 'get') {
		event.source.postMessage({
			action: 'returnData',
			key: key,
			value: JSON.parse(window.localStorage.getItem(key))
		}, '*');
	}
}
