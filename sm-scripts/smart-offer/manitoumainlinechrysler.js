// https://www.manitoumainlinechrysler.ca/
// Manitou Mainline Chrysler
/* jshint -W104 */
/* jshint -W119 */

function autoverifyIframeClash() {
	const autoBtnsSel = '#av_widget-1a7453ed-5462-4450-9c0e-c545e8254602 > div > div > a';
	const iframesSel  = '#av_report__container > iframe';

	const fireScript = setInterval(() => {
		const autoBtns = document.querySelectorAll(autoBtnsSel);

		if (autoBtns.length) {
			clearInterval(fireScript);
			autoBtns.forEach(autoBtn => autoBtn.addEventListener('click', () => {
				setTimeout(() => {
					const iframeElm  = document.querySelector(iframesSel);
					window.preventSO = true;

					if (iframeElm.checkVisibility()) {
						const visibleInterval = setInterval(() => {
							if (!iframeElm.checkVisibility()) {
								clearInterval(visibleInterval);
								window.preventSO = false;
							}
						}, 500);
					}
				}, 1000);
			}));
		}
	}, 100);
}

const readyStateCheckInterval = setInterval(() => {
    if (document.readyState === "complete") {
        clearInterval(readyStateCheckInterval);
		setTimeout(() => {
			autoverifyIframeClash();
		}, 2000);
    }
}, 100);
