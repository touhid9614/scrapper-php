console.log("GA4 script call");
const add_script = document.createElement('script');
add_script.src = "https://www.googletagmanager.com/gtag/js?id=G-K3D64JBYNH";
document.head.append(add_script);
window.dataLayer = window.dataLayer || [];

function gtag() {
	dataLayer.push(arguments);
}

gtag('js', new Date());
gtag('config', 'G-K3D64JBYNH');

sMedia.Context.GlobalCallbacks.epm.push((_, count) => {
	if (count == 1 && !window.smedia_ga4tracked) {
		window.smedia_ga4tracked = true;
		gtag('event', 'digital_test_drives', { 'value': 'Profitable Engagement' });
		console.log("GA4 Profitable Engagement tracked");
	}
});
