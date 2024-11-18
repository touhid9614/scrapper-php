console.log("GA4 script call");
const add_script = document.createElement('script');
add_script.src = "https://www.googletagmanager.com/gtag/js?id=G-216CT006N9";
document.head.append(add_script);
window.dataLayer = window.dataLayer || [];

function gtag() {
	dataLayer.push(arguments);
}
gtag('js', new Date());
gtag('config', 'G-216CT006N9');

sMedia.Context.GlobalCallbacks.epm.push((_, count) => {
	if (count == 1 && !sMedia.g4tracked) {
		sMedia.g4tracked = true;
		gtag('event', 'digital_test_drives', { 'value': 'Profitable Engagement' });
		console.log("GA4 Profitable Engagement tracked");
	}
});
