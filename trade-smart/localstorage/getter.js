/*jshint -W104*/
/*jshint -W119*/

const iframe = document.getElementById('sm_ts_local_storage_iframe');
iframe.contentWindow.postMessage({
	action: 'get',
	key: 'sm_ts_last_engaged_vdp'
});

window.addEventListener("message", messageResponseHandler, false);
function messageResponseHandler(event) {
	const { action, key, value } = event.data;
	if (action == 'returnData') {
		// useData(key, value);
		console.log({key, value});
	}
}
