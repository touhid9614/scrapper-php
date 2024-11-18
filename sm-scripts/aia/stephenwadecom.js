if (sMedia.Context.PageType == 'vdp') {
	const CD = sMedia.Context.PageData.car_data || {};

	if (!!CD && !!CD.custom && CD.custom == 'Front-Line') {
		sMedia.Context.DomainConfig.cron_config.lead.live           = true;
		sMedia.Context.DomainConfig.cron_config.lead.lead_type_     = true;
		sMedia.Context.DomainConfig.cron_config.lead.lead_type_new  = true;
		sMedia.Context.DomainConfig.cron_config.lead.lead_type_used = true;
		sMedia.Modules.smartOffer.Register();

		setTimeout(() => {
			sMedia.Context.DomainConfig.cron_config.lead.live           = false;
			sMedia.Context.DomainConfig.cron_config.lead.lead_type_     = false;
			sMedia.Context.DomainConfig.cron_config.lead.lead_type_new  = false;
			sMedia.Context.DomainConfig.cron_config.lead.lead_type_used = false;
		}, 120000);
	}
}
