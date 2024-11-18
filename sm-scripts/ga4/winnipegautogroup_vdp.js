console.log("Profitable Engagement fire");

sMedia.Context.GlobalCallbacks.epm.push((_, count) => {
	if (count == 1) {
		gtag('event', 'engaged_prospect', { 'value': 'Profitable Engagement' });
	}
});
