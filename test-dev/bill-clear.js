const sel = "#invoice-list-tabs-panel-0 > div > table > tbody > tr > td.wv-table__cell--actions.invoice-list-table__action-cell.fs-exclude > div > div";
const recordPaySel = "#invoice-list-tabs-panel-0 > div > table > tbody > tr > td  > div > div > ul > li:nth-child(5) > a";
const modalSel = "#Content > div > div.wv-frame__wrapper > div.wv-frame__content > div.wv-frame__content__body > div.wv-frame__content__body__main > div > div.invoice > div.wv-modal.wv-modal--open";
const payMethSel = "#Content > div > div.wv-frame__wrapper > div.wv-frame__content > div.wv-frame__content__body > div.wv-frame__content__body__main > div > div.invoice > div.wv-modal.wv-modal--open > div.wv-modal__window > div > div.wv-modal__content__scroll-area > div.wv-modal__body > div > div > div.wv-form--horizontal > div:nth-child(3) > div > div > div > div";
const bankPaySel = "#Content > div > div.wv-frame__wrapper > div.wv-frame__content > div.wv-frame__content__body > div.wv-frame__content__body__main > div > div.invoice > div.wv-modal.wv-modal--open > div.wv-modal__window > div > div.wv-modal__content__scroll-area > div.wv-modal__body > div > div > div.wv-form--horizontal > div.wv-form-field > div > div > div > div.wv-select__menu > ul > div:nth-child(1)";
const payAccSel = "#Content > div > div.wv-frame__wrapper > div.wv-frame__content > div.wv-frame__content__body > div.wv-frame__content__body__main > div > div.invoice > div.wv-modal.wv-modal--open > div.wv-modal__window > div > div.wv-modal__content__scroll-area > div.wv-modal__body > div > div > div.wv-form--horizontal > div:nth-child(4) > div > div > div > div > div";
const cashSel = "#Content > div > div.wv-frame__wrapper > div.wv-frame__content > div.wv-frame__content__body > div.wv-frame__content__body__main > div > div.invoice > div.wv-modal.wv-modal--open > div.wv-modal__window > div > div.wv-modal__content__scroll-area > div.wv-modal__body > div > div > div.wv-form--horizontal > div:nth-child(4) > div > div > div > div > div.wv-select__menu > ul > div";
const subSel = "#Content > div > div.wv-frame__wrapper > div.wv-frame__content > div.wv-frame__content__body > div.wv-frame__content__body__main > div > div.invoice > div.wv-modal.wv-modal--open > div.wv-modal__window > div > div.wv-modal__content__scroll-area > div.wv-modal__footer > div > button.wv-button--primary";
const closeSel = "#Content > div > div.wv-frame__wrapper > div.wv-frame__content > div.wv-frame__content__body > div.wv-frame__content__body__main > div > div.invoice > div.wv-modal.wv-modal--open > div.wv-modal__window > div > div.wv-modal__header > button";

const clickAfter = (sec, name, sel) => {
    const end = Date.now() + sec * 1000;
    while (Date.now() < end) {
        continue
    }
    document.querySelector(sel).click();
};

const elms = document.querySelectorAll(sel);
elms.forEach((elm) => {
    elm.click();
    clickAfter(2, 'recordPaySel', recordPaySel);
    clickAfter(4, 'payMethSel', payMethSel);
    clickAfter(2, 'bankPaySel', bankPaySel);
    clickAfter(2, 'payAccSel', payAccSel);
    clickAfter(2, 'cashSel', cashSel);
    clickAfter(2, 'subSel', subSel);
    clickAfter(4, 'closeSel', closeSel);
});



const syncWait = (ms, name) => {
    const end = Date.now() + ms;
    while (Date.now() < end) {
        continue
    }
    console.log(name);
};

const asyncWait = ms => new Promise(resolve => setTimeout(resolve, ms));

function wait(ms, elem) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            console.log(elem);
            resolve(ms)
        }, ms)
    });
}