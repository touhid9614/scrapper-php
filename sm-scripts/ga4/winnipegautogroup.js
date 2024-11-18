console.log("GA4 script call");
const add_script = document.createElement('script');
add_script.src = "https://www.googletagmanager.com/gtag/js?id=G-XCLQLPQ1N6";
document.head.append(add_script);
window.dataLayer = window.dataLayer || [];

function gtag() {
	dataLayer.push(arguments);
}
gtag('js', new Date());
gtag('config', 'G-XCLQLPQ1N6');
