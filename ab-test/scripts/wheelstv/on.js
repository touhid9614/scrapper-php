console.log("WheelsTv AB testing with button. Nothing to do but EPM tracking if VDP.");

if (sMedia.Context.PageData.page_type === 'vdp') {
	const abTestApi = `${sMedia.apiHost}/APIs/v1/abTestApi.php`;

	const viewPayload = {
		action 	  : 'save_view',
		dealership: sMedia.Context.DomainConfig.cron,
		url       : encodeURIComponent(window.location.href),
		option 	  : 'On',
		table_name: 'wheelstv'
	};

	new sMedia.Ajax().Post(abTestApi, viewPayload, (r) => {
		console.log(`${viewPayload.dealership} view has been sent for AB testing.`, r);
	}, null, "x-www-form-urlencoded");

	sMedia.Context.GlobalCallbacks.epm.push((_, count) => {
		if (count == 1) {
			const savePayload = {
				action 	  : 'save_epm',
				dealership: sMedia.Context.DomainConfig.cron,
				url       : encodeURIComponent(window.location.href),
				option 	  : 'On',
				table_name: 'wheelstv'
			};

			new sMedia.Ajax().Post(abTestApi, savePayload, (r) => {
				console.log(`${savePayload.dealership} engagement has been sent for AB testing.`, r);
			}, null, "x-www-form-urlencoded");
		}
	});
}