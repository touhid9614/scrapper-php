// https://www.kindersleymainline.net/
// Kindersley Mainline
/* jshint -W104 */
/* jshint -W119 */

function autoverifyIframeClash() {
	const autoBtnsSel = '#av_widget-dff24b53-d52c-4a7b-ae5a-8631f68bfdd0 > div > div > a';
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
