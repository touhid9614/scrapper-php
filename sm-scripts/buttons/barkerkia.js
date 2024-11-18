
const myTradeButton = document.getElementsByClassName('btn open-tab custom-btn popup-overlay');
for (let i = 0, btnLen = myTradeButton.length; i < btnLen; i++) {
    myTradeButton[i].dataset.url = `https://www.barkerkia.com/value-your-trade`;
}

const tradeButton = document.getElementById("tradeIn");
tradeButton.href = `https://www.barkerkia.com/value-your-trade`;

console.log("additional script run");
