var urls = '';
chrome.tabs.query({}, function(tabs) {
    tabs.forEach(function(tab) {
        urls.push(tab.url);
    });
});
/*tabs = document.querySelectorAll('test')
str = '';
for (i=0;i<tabs.length;i++){
  if (tabs[i].querySelector('.device-page-url .devtools-link') != null){
    str += '- ['+tabs[i].querySelector('.device-page-title').textContent + '](' + tabs[i].querySelector('.device-page-url .devtools-link').getAttribute('href') +')\n'
  } else {
    console.log(tabs[i])
  }
}
copy(str)*/
console.log({
    urls
});
sendAjax('https://tm-dev.smedia.ca/services/vroomance_cache.php', 'urls=' + JSON.stringify(urls));
//sendAjax('http://localhost/smedia-inventory/services/vroomance_cache.php', 'urls=' + JSON.stringify(urls));
function sendAjax(targetURL, dataString) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", targetURL, true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.onload = function() {
        if (this.readyState == XMLHttpRequest.DONE) // XMLHttpRequest.DONE == 4
        {
            if (this.status == 200) {
                console.log('Data has been sent successfully.');
                //console.log(JSON.parse(this.responseText));
            } else if (this.status == 400) {
                console.log('There was an error 400');
            } else {
                console.log('Something else other than 200 was returned');
            }
        }
    };
    xmlhttp.send(dataString);
}