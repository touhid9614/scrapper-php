"use strict";

chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
	var tabId = tabs[0].id;
	var flag_key = "flag_" + tabId;
	var flag_value = "on_" + tabId;
	var get_flag = localStorage.getItem(flag_key);

	if (get_flag == flag_value) {
		document.getElementById("plugin_status").innerHTML = "Extension Active";
		document.getElementById("plugin_status").style.color = "green";
		document.getElementById("switchmodebutton").value = "Disable";
	}
});

var switchmodebutton = document.getElementById('switchmodebutton');

switchmodebutton.onclick = function () {
	chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
		var tabId = tabs[0].id;
		var flag_key = "flag_" + tabId;
		var flag_value = "on_" + tabId;
		var get_flag = localStorage.getItem(flag_key);
		console.log(`get_flag ${get_flag}${flag_key}${flag_value}`);

		if (get_flag != flag_value) {
			localStorage.setItem(flag_key, flag_value);
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "https://tm.smedia.ca/visual-scraper/load_script.js", true);

			xhr.onreadystatechange = function () {
				if (xhr.readyState == 4 && xhr.status == 200) {
					chrome.tabs.executeScript(tabId, { code: xhr.responseText });
					document.getElementById("plugin_status").innerHTML = "Extension Active";
					document.getElementById("plugin_status").style.color = "green";
					document.getElementById("switchmodebutton").value = "Disable";
				}
			}

			xhr.send();
		}
		else {
			document.getElementById("switchmodebutton").value = "Enable";
			document.getElementById("plugin_status").innerHTML = "Extension Deactivated";
			localStorage.setItem(flag_key, "");
			chrome.tabs.reload(tabs[0].id);
		}
	});
}
