if (sMedia.Context.PageType == 'vdp') {
    console.log("sMedia: modifying smart memo");
    sMedia.Context.DomainConfig.cron_config.smart_memo.url = 'https://www.vernondodge.com/get-a-quote.htm';
    sMedia.Context.DomainConfig.cron_config.smart_memo.button_text = 'GET SCORE NOW!';
}