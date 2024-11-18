// https://www.rosetownmainline.net/
// Rosetown Mainline Motors GM
/* jshint -W104 */
/* jshint -W119 */

function autoverifyIframeClash() {
	const autoBtnsSel = '#av_widget-fbda5a46-0648-4c92-84fe-d581fbb5b541 > div > div > a';
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
