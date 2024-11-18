if (sMedia.Context.PageType == 'vdp') {
    console.log("sMedia: modifying smart memo");
    sMedia.Context.DomainConfig.cron_config.smart_memo.url = 'https://www.vernonkia.ca/finance/';
    sMedia.Context.DomainConfig.cron_config.smart_memo.button_text = 'CHECK NOW';
}