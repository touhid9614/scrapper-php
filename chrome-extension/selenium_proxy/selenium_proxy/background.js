var config = 
{
    mode: "fixed_servers",
    rules: 
    {
        singleProxy: 
        {
            scheme: "http",
            host: "200.35.155.163",
            port: parseInt("1212")
        },

        bypassList: ["localhost"]
    }
};

chrome.proxy.settings.set({value: config, scope: "regular"}, function() {});

function callbackFn(details) 
{
    return details.isProxy === !0 ? 
    {
        authCredentials: 
        {
            username: 'user-06440',
            password: '3k9ZArLGx62Q6Wv7'
        }
    } : {}
}

chrome.webRequest.onAuthRequired.addListener(
    callbackFn, {urls: ["<all_urls>"]}, ['blocking']
);