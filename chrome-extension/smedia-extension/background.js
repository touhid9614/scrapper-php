chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab)
{
	const flag_key	= `flag_${tabId}`;
	const flag_value	= `on_${tabId}`;
	const get_flag	= localStorage.getItem(flag_key);

	console.log(`get_flag ${get_flag}${flag_key}${flag_value}`);

	if (changeInfo.status == 'complete' && get_flag == flag_value)
	{
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "https://tm.smedia.ca/visual-scraper/load_script.js", true);

		xhr.onreadystatechange = function ()
		{
			if (xhr.readyState == 4 && xhr.status == 200)
			{
				chrome.tabs.executeScript(tabId, {code: xhr.responseText});
			}
		};

		xhr.send();
	}
});
