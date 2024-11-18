/*jshint -W104*/
/*jshint -W119*/

const data = doSomeThingToGetData();
const iframe = document.getElementById('sm_ts_local_storage_iframe');
iframe.contentWindow.postMessage({
	action: 'save',
	key: 'sm_ts_last_engaged_vdp',
	value: data
});
