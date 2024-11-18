/* eslint-disable @typescript-eslint/no-unused-vars */
/* eslint-disable @typescript-eslint/no-array-constructor */
/* eslint-disable no-undef */
/* eslint-disable no-redeclare */
/* jshint -W009 */
/* jshint -W014 */
/* jshint -W030 */
/* jshint -W056 */
/* jshint -W058 */
/* jshint -W061 */
/* jshint -W069 */
/* jshint -W083 */
/* jshint -W104 */
/* jshint -W117 */
/* jshint -W119 */
/* jshint -W138 */
if (typeof sMedia === 'undefined' || !sMedia.Context) {
var sMedia;
(function (sMedia) {
    sMedia.SECONDS_IN_A_DAY = 86400;
    sMedia.GA4_EVENTS = [
        { "listen": "engaged_prospect", ga4: "engaged_prospect" },
        { "listen": "smart_offer.shown", ga4: "smart_offer_shown" },
        { "listen": "smart_offer.submit", ga4: "smart_offer_lead" },
        { "listen": "aiform.complete", ga4: "ai_button_submit" },
        { "listen": "aibutton.click", ga4: "ai_button_click" }
    ];
    sMedia.ANALYTICS_EVENTS = {
        pageview: {
            category: null,
            action: null,
            label: null,
            nonInteraction: true,
        },
        vdp: {
            category: "vdp",
            action: "view",
            label: null,
            nonInteraction: true,
        },
        profitable_engagement_1: {
            category: "Profitable Engagement",
            action: "Time on page more than 30 seconds",
            label: null,
            nonInteraction: false,
        },
        profitable_engagement_2: {
            category: "Profitable Engagement",
            action: "Time on page more than a minute",
            label: null,
            nonInteraction: false,
        },
        profitable_engagement_3: {
            category: "Profitable Engagement",
            action: "Time on page more than 1 minute 30 seconds",
            label: null,
            nonInteraction: false,
        },
        smart_offer_lead: {
            category: "smart_offer",
            action: "lead",
            label: null,
            nonInteraction: false,
        },
        smart_offer_shown: {
            category: "smart_offer",
            action: "shown",
            label: null,
            nonInteraction: true,
        },
        ai_button_clicked: {
            category: "Button Clicked",
            action: "AI Button",
            label: "{button_name}",
            nonInteraction: false,
        },
        ai_button_input: {
            category: "Input Tracking",
            action: "{status}",
            label: "{field}",
            nonInteraction: false,
        },
        ai_button_fillup: {
            category: "Form Fillup",
            action: "AI Form",
            label: null,
            nonInteraction: false,
        },
        lead_from_submit: {
            category: "Lead Form",
            action: "submit",
            label: null,
            nonInteraction: false,
        },
        picture_engagement: {
            category: "Picture engagement",
            action: "{ith} Picture engagement",
            label: null,
            nonInteraction: false,
        },
        picture_viewd: {
            category: "Picture Viewed",
            action: "{ith} Picture Viewed",
            label: null,
            nonInteraction: false,
        },
    };
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    function isEmptyString(str) {
        return !Boolean(str);
    }
    sMedia.isEmptyString = isEmptyString;
    function isEmptyArray(arr) {
        return !(Array.isArray(arr) && (arr.length > 0));
    }
    sMedia.isEmptyArray = isEmptyArray;
    function isEmptyObject(obj) {
        return (Object.values(obj).length === 0);
    }
    sMedia.isEmptyObject = isEmptyObject;
    function isProperPrice(price, minPrice = 1000, maxPrice = 1000000) {
        if (!isNumber(price)) {
            price = priceToNumber(price);
        }
        if (price) {
            return (checkPriceRange(price, minPrice, maxPrice) &&
                validatePrice(price));
        }
        return false;
    }
    sMedia.isProperPrice = isProperPrice;
    function isDefined(val) {
        return typeof val !== "undefined";
    }
    sMedia.isDefined = isDefined;
    function assignIfExists(elm, defValue = null) {
        if (isDefined(elm)) {
            return elm;
        }
        else {
            return defValue;
        }
    }
    sMedia.assignIfExists = assignIfExists;
    function isValidVin(vin) {
        vin = vin.toUpperCase();
        if (vin.length !== 17) {
            return false;
        }
        if (vin.includes("I") || vin.includes("O") || vin.includes("Q")) {
            return false;
        }
        const checkSum = vin.substr(8, 1);
        const allowedCS = "0123456789X";
        if (!allowedCS.includes(checkSum)) {
            return false;
        }
        const transVIN = transliterateVIN(vin);
        const weightedVIN = getWeightedVIN(transVIN);
        const weightedSum = weightedVIN.reduce((acc, curr) => acc + curr);
        let remainder = weightedSum % 11;
        if (remainder == 10) {
            remainder = "X";
        }
        if (remainder != checkSum) {
            return false;
        }
        return true;
    }
    sMedia.isValidVin = isValidVin;
    function transliterateVIN(vin) {
        const transliterationTable = {
            A: 1,
            B: 2,
            C: 3,
            D: 4,
            E: 5,
            F: 6,
            G: 7,
            H: 8,
            J: 1,
            K: 2,
            L: 3,
            M: 4,
            N: 5,
            P: 7,
            R: 9,
            S: 2,
            T: 3,
            U: 4,
            V: 5,
            W: 6,
            X: 7,
            Y: 8,
            Z: 9,
        };
        return strReplace(Object.keys(transliterationTable), Object.values(transliterationTable), vin);
    }
    sMedia.transliterateVIN = transliterateVIN;
    function getWeightedVIN(transVIN) {
        const transVINparts = strSplit(transVIN);
        const weightedVIN = [];
        const weightTable = {
            0: 8,
            1: 7,
            2: 6,
            3: 5,
            4: 4,
            5: 3,
            6: 2,
            7: 10,
            8: 0,
            9: 9,
            10: 8,
            11: 7,
            12: 6,
            13: 5,
            14: 4,
            15: 3,
            16: 2,
        };
        Object.entries(transVINparts).forEach(([key, value]) => {
            weightedVIN[key] = value * weightTable[key];
        });
        return weightedVIN;
    }
    sMedia.getWeightedVIN = getWeightedVIN;
    function strSplit(str, splitLength = 1) {
        if (splitLength === null) {
            splitLength = 1;
        }
        if (str === null || splitLength < 1) {
            return false;
        }
        str += "";
        const chunks = [];
        let pos = 0;
        const len = str.length;
        while (pos < len) {
            chunks.push(str.slice(pos, (pos += splitLength)));
        }
        return chunks;
    }
    sMedia.strSplit = strSplit;
    function isNumber(price) {
        if (typeof price == "number") {
            return true;
        }
    }
    sMedia.isNumber = isNumber;
    function priceToNumber(price) {
        if (isNumber(price)) {
            return price;
        }
        else if (!price) {
            return 0;
        }
        const remainder = price.replace(/[0-9.,$]+/, "");
        if (remainder == "") {
            return Number(price.replace(/[^0-9.]+/gi, ""));
        }
        return 0;
    }
    sMedia.priceToNumber = priceToNumber;
    function checkPriceRange(price, minPrice, maxPrice) {
        if (price >= minPrice && price <= maxPrice) {
            return true;
        }
        return false;
    }
    sMedia.checkPriceRange = checkPriceRange;
    function validatePrice(price) {
        const priceRegex = new RegExp("^[0-9]+(.[0-9]{0,2})?$", "gi");
        return priceRegex.test(price);
    }
    sMedia.validatePrice = validatePrice;
    function sleep(milliseconds) {
        const timeStart = new Date().getTime();
        let loop = true;
        while (loop) {
            const elapsedTime = new Date().getTime() - timeStart;
            if (elapsedTime > milliseconds) {
                loop = false;
            }
        }
    }
    sMedia.sleep = sleep;
    function executeIfFileExist(src, callback) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === this.DONE) {
                callback();
            }
        };
        xhr.open("HEAD", src);
    }
    sMedia.executeIfFileExist = executeIfFileExist;
    function getIndexed(i) {
        switch (i) {
            case 1:
                return `${i}st`;
            case 2:
                return `${i}nd`;
            case 3:
                return `${i}rd`;
            default:
                return `${i}th`;
        }
    }
    sMedia.getIndexed = getIndexed;
    function regexP2J(str) {
        return new RegExp(str.slice(1, -1), 'i');
    }
    sMedia.regexP2J = regexP2J;
    function assumeStockType(carData = null) {
        let stock_type = assumeStockTypeFromUrl();
        if (!stock_type && carData) {
            if (carData.stock_type) {
                stock_type = carData.stock_type;
            }
            if (!stock_type && carData.title) {
                stock_type = assumeStockTypeFromTitle(carData.title);
            }
            if (!stock_type && carData.kilometres) {
                stock_type = assumeStockTypeFromKilometres(carData.kilometres);
            }
            if (!stock_type && carData.year) {
                stock_type = assumeStockTypeFromYear(parseInt(carData.year));
            }
        }
        if (stock_type) {
            return stock_type;
        }
        else {
            return 'new';
        }
    }
    sMedia.assumeStockType = assumeStockType;
    function assumeStockTypeFromUrl() {
        const url = window.location.href.split('#')[0].toLowerCase();
        if (url.includes('used') || url.includes('preowned') || url.includes('pre-owned') || url.includes('certified')) {
            return 'used';
        }
        else if (url.includes('new')) {
            return 'new';
        }
        else {
            return null;
        }
    }
    sMedia.assumeStockTypeFromUrl = assumeStockTypeFromUrl;
    function assumeStockTypeFromTitle(title) {
        title = title.toLowerCase();
        if (title.includes('used') || title.includes('preowned') || title.includes('pre-owned') || title.includes('certified')) {
            return 'USED';
        }
        else if (title.includes('new')) {
            return 'NEW';
        }
        else {
            return null;
        }
    }
    sMedia.assumeStockTypeFromTitle = assumeStockTypeFromTitle;
    function assumeStockTypeFromKilometres(kilometres) {
        const kilometerValue = parseInt(kilometres.replace(/[^0-9.]/g, ''));
        if (kilometerValue > 1000) {
            return 'used';
        }
        else if (kilometerValue < 100) {
            return 'new';
        }
        else {
            return null;
        }
    }
    sMedia.assumeStockTypeFromKilometres = assumeStockTypeFromKilometres;
    function assumeStockTypeFromYear(year) {
        if (year++ >= new Date().getFullYear()) {
            return 'new';
        }
        else {
            return 'used';
        }
    }
    sMedia.assumeStockTypeFromYear = assumeStockTypeFromYear;
    function generateCarData(regexSet, pageSource) {
        const carDerivedData = {
            url: window.location.href.split('#')[0]
        };
        if (!regexSet) {
            return carDerivedData;
        }
        if (regexSet.new || regexSet.used) {
            const assumedStockType = assumeStockType();
            regexSet = regexSet[assumedStockType];
            carDerivedData['stock_type'] = assumedStockType;
        }
        for (const key in regexSet) {
            const rgx = regexP2J(regexSet[key]);
            const mat = rgx.exec(pageSource);
            if (mat && mat.groups) {
                carDerivedData[key] = mat.groups[key].trim();
            }
        }
        if (!carDerivedData['stock_type']) {
            carDerivedData['stock_type'] = assumeStockType();
        }
        return carDerivedData;
    }
    sMedia.generateCarData = generateCarData;
    function smediaUrlEncrypt(url) {
        const mapping = {
            '%2F': 'SMEDIA_FORWARD_SLASH',
            '%5C': 'SMEDIA_BACKWARD_SLASH',
            '%3F': 'SMEDIA_WHAT',
            '%26': 'SMEDIA_AMPERSENT',
            '%40': 'SMEDIA_AT_THE_RATE_OF',
            '%2A': 'SMEDIA_STAR'
        };
        return strReplace(Object.keys(mapping), Object.values(mapping), url);
    }
    sMedia.smediaUrlEncrypt = smediaUrlEncrypt;
    function smediaUrlDecrypt(url) {
        const mapping = {
            '%2F': 'SMEDIA_FORWARD_SLASH',
            '%5C': 'SMEDIA_BACKWARD_SLASH',
            '%3F': 'SMEDIA_WHAT',
            '%26': 'SMEDIA_AMPERSENT',
            '%40': 'SMEDIA_AT_THE_RATE_OF',
            '%2A': 'SMEDIA_STAR'
        };
        return strReplace(Object.values(mapping), Object.keys(mapping), url);
    }
    sMedia.smediaUrlDecrypt = smediaUrlDecrypt;
    function strReplace(search, replace, subject) {
        let reg;
        if (typeof (search) == "string") {
            search = search.replace(/[.?*+^$[\]\\(){}|-]/g, "\\");
            reg = new RegExp(`(${search})`, "g");
        }
        else {
            search = search.map(function (i) {
                return i.replace(/[.?*+^$[\]\\(){}|-]/g, "\\");
            });
            reg = new RegExp(`(${search.join("|")})`, "g");
        }
        let rep;
        if (typeof (replace) == "string") {
            rep = replace;
        }
        else {
            if (typeof (search) == "string") {
                rep = replace[0];
            }
            else {
                rep = function (i) {
                    return replace[search.indexOf(i)];
                };
            }
        }
        return subject.replace(reg, rep);
    }
    sMedia.strReplace = strReplace;
    function awaitResolution(checkResolution, timeout, interval) {
        const initialTime = +(new Date);
        if (typeof timeout === 'undefined') {
            timeout = 1500;
        }
        if (typeof interval === 'undefined') {
            interval = 100;
        }
        return new Promise(function promiseResolver(resolve, reject) {
            function doCheckResolution(resolve, reject) {
                const currentTime = +(new Date);
                if (currentTime - initialTime > timeout) {
                    return reject(`Timeout of ${timeout} milliseconds has been reached.`);
                }
                const result = checkResolution();
                if (result !== null) {
                    return resolve(result);
                }
                setTimeout(doCheckResolution, interval);
            }
            doCheckResolution(resolve, reject);
        });
    }
    sMedia.awaitResolution = awaitResolution;
    function escapeString(str) {
        return str.replaceArray(['/'], ['\/']);
    }
    sMedia.escapeString = escapeString;
    function string_to_regex(str) {
        const regex_split = str.replace(/\\\//g, "--slash--").split("/");
        if (regex_split.length == 3) {
            const re = new RegExp(regex_split[1].replace(/--slash--/g, "/"), regex_split[2]);
            return re;
        }
        return null;
    }
    sMedia.string_to_regex = string_to_regex;
    function stringToInt(s) {
        return parseInt((s || "").replace(/[^0-9.]/, "").split(".")[0]);
    }
    sMedia.stringToInt = stringToInt;
    function OrAllMembers(debugFlags) {
        let out = false;
        for (const flag in debugFlags) {
            out = out || debugFlags[flag];
        }
        return out;
    }
    sMedia.OrAllMembers = OrAllMembers;
    function getValueById(id) {
        return (document.querySelector(`#${id}`) ? document.getElementById(id).value : '');
    }
    sMedia.getValueById = getValueById;
    function debugLog(msg) {
        sMedia.Context.LogService.Debug(msg);
    }
    sMedia.debugLog = debugLog;
    function arrayLower(arr) {
        const lower = arr.map(element => {
            return element.toLowerCase().trim();
        });
        return lower;
    }
    sMedia.arrayLower = arrayLower;
    function removeInvalids(arr) {
        let index = -1;
        let resIndex = -1;
        const arr_length = arr ? arr.length : 0;
        const result = [];
        while (++index < arr_length) {
            const value = arr[index];
            if (value) {
                result[++resIndex] = value;
            }
        }
        return result;
    }
    sMedia.removeInvalids = removeInvalids;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    function showForCustomPage(offer_config, carDataParam, itsVDP) {
        let out = (!!offer_config.customVDP.stockType.length ||
            !!offer_config.customVDP.year.length ||
            !!offer_config.customVDP.make.length ||
            !!offer_config.customVDP.model.length ||
            !!offer_config.customVDP.regex.length);
        const lowerStocks = sMedia.removeInvalids(sMedia.arrayLower(offer_config.customVDP.stockType));
        if (lowerStocks.length) {
            out = out && itsVDP && lowerStocks.includes((carDataParam.stock_type || 'new').toLowerCase().trim());
        }
        if (offer_config.customVDP.year.length && carDataParam && carDataParam.year) {
            out = out && itsVDP && offer_config.customVDP.year.includes(carDataParam.year);
        }
        const lowerMakes = sMedia.removeInvalids(sMedia.arrayLower(offer_config.customVDP.make));
        if (lowerMakes.length && carDataParam && carDataParam.make) {
            out = out && itsVDP && lowerMakes.includes((carDataParam.make || '').toLowerCase().trim());
        }
        const lowerModels = sMedia.removeInvalids(sMedia.arrayLower(offer_config.customVDP.model));
        if (lowerModels.length && carDataParam && carDataParam.model) {
            out = out && itsVDP && lowerModels.includes((carDataParam.model || '').toLowerCase().trim());
        }
        if (!sMedia.isEmptyArray(offer_config.customVDP.regex)) {
            offer_config.customVDP.regex.forEach((rgx) => {
                if (!sMedia.isEmptyString(rgx)) {
                    const reg = new RegExp(rgx, 'i');
                    out = out && reg.test(window.location.href.split('#')[0]);
                }
            });
        }
        return out;
    }
    sMedia.showForCustomPage = showForCustomPage;
    function showForOtherPageAsRegex(otherPage) {
        let out = false;
        if (otherPage.length) {
            otherPage.forEach((rgx) => {
                if (!sMedia.isEmptyString(rgx)) {
                    const reg = new RegExp(rgx, 'i');
                    out = out || reg.test(window.location.href.split('#')[0]);
                }
            });
        }
        return out;
    }
    sMedia.showForOtherPageAsRegex = showForOtherPageAsRegex;
    function isEnabledForThisPage(offer_config) {
        const pageType = sMedia.Context.PageType;
        const thisUrl = `${window.location.origin}${window.location.pathname}`.split('#')[0];
        const carDataParam = (sMedia.Context.PageData.car_data || {});
        const carStkType = (carDataParam.stock_type || '').toLowerCase().trim();
        const itsVDP = (pageType === "vdp");
        if ((offer_config.pages.all) ||
            (window.location.pathname === "/" && offer_config.pages.home) ||
            (itsVDP && offer_config.pages[carStkType]) ||
            (itsVDP && offer_config.pages['certified'] && carDataParam.certified) ||
            (offer_config.pages.customVDP && showForCustomPage(offer_config, carDataParam, itsVDP)) ||
            (offer_config.pages.otherPage && offer_config.otherPage.includes(thisUrl)) ||
            (offer_config.pages.otherPage && showForOtherPageAsRegex(offer_config.otherPage))) {
            return true;
        }
        return false;
    }
    sMedia.isEnabledForThisPage = isEnabledForThisPage;
    function getTimeLimit(offer_config) {
        let timeLimit = offer_config.display.display_after;
        const customTimers = offer_config.custom_timing || [];
        if (customTimers.length) {
            for (const customCampaign of customTimers) {
                if (!sMedia.isEmptyString(customCampaign.label)) {
                    const campaignRegEx = new RegExp(`utm_campaign=${customCampaign.label}`, 'i');
                    if (campaignRegEx.test(window.location.href)) {
                        timeLimit = customCampaign.value;
                        break;
                    }
                }
            }
        }
        return timeLimit;
    }
    sMedia.getTimeLimit = getTimeLimit;
    function metFacebookCampaignCap(offer_config, persistentStorage, serviceName, storagePrefix) {
        if (offer_config.campaign_cap_fb.active &&
            /utm_medium=facebook/.test(window.location.href) &&
            /utm_source=smedia_/.test(window.location.href)) {
            const fb_now = Date.now();
            let fb_start = sMedia.LocalStorage.get(`${storagePrefix}_campaign_cap_fb_start_date_${persistentStorage}`) || fb_now;
            let fb_show_count = sMedia.LocalStorage.get(`${storagePrefix}_campaign_cap_fb_show_count_${persistentStorage}`) || 0;
            const fb_times = offer_config.campaign_cap_fb.days * sMedia.SECONDS_IN_A_DAY;
            if ((fb_now - fb_start) > fb_times) {
                sMedia.LocalStorage.set(`${storagePrefix}_campaign_cap_fb_start_date_${persistentStorage}`, fb_now, fb_times);
                sMedia.LocalStorage.set(`${storagePrefix}_campaign_cap_fb_show_count_${persistentStorage}`, 0, fb_times);
                fb_start = fb_now;
                fb_show_count = 0;
            }
            if ((fb_start == fb_now)) {
                sMedia.LocalStorage.set(`${storagePrefix}_campaign_cap_fb_start_date_${persistentStorage}`, fb_now, fb_times);
            }
            if (!fb_show_count) {
                sMedia.LocalStorage.set(`${storagePrefix}_campaign_cap_fb_show_count_${persistentStorage}`, 0, fb_times);
            }
            if ((fb_now - fb_start) <= fb_times) {
                if (fb_show_count > offer_config.campaign_cap_fb.count) {
                    console.log(`sMedia: Campaign FB cap count is ${offer_config.campaign_cap_fb.count} in config '${offer_config.name}' current fb show count is ${fb_show_count} and hence '${serviceName}' is ignored.`);
                    return true;
                }
            }
        }
        return false;
    }
    sMedia.metFacebookCampaignCap = metFacebookCampaignCap;
    function metGoogleCampaignCap(offer_config, persistentStorage, serviceName, storagePrefix) {
        if (offer_config.campaign_cap_google.active &&
            /utm_medium=google/.test(window.location.href) &&
            /utm_source=smedia_/.test(window.location.href)) {
            const google_now = Date.now();
            let google_start = sMedia.LocalStorage.get(`${storagePrefix}_campaign_cap_google_start_date_${persistentStorage}`) || google_now;
            let google_show_count = sMedia.LocalStorage.get(`${storagePrefix}_campaign_cap_google_show_count_${persistentStorage}`) || 0;
            const google_times = offer_config.campaign_cap_fb.days * sMedia.SECONDS_IN_A_DAY;
            if ((google_now - google_start) > google_times) {
                sMedia.LocalStorage.set(`${storagePrefix}_campaign_cap_google_start_date_${persistentStorage}`, google_now, google_times);
                sMedia.LocalStorage.set(`${storagePrefix}_campaign_cap_google_show_count_${persistentStorage}`, 0, google_times);
                google_start = google_now;
                google_show_count = 0;
            }
            if ((google_start == google_now)) {
                sMedia.LocalStorage.set(`${storagePrefix}_campaign_cap_google_start_date_${persistentStorage}`, google_now, google_times);
            }
            if (!google_show_count) {
                sMedia.LocalStorage.set(`${storagePrefix}_campaign_cap_google_show_count_${persistentStorage}`, 0, google_times);
            }
            if ((google_now - google_start) <= google_times) {
                if (google_show_count > offer_config.campaign_cap_google.count) {
                    console.log(`sMedia: Campaign GOOGLE cap count is ${offer_config.campaign_cap_google.count} in config '${offer_config.name}' current fb show count is ${google_show_count} and hence '${serviceName}' is ignored.`);
                    return true;
                }
            }
        }
        return false;
    }
    sMedia.metGoogleCampaignCap = metGoogleCampaignCap;
    function dailyShownCapMet(offer_config, storage, storagePrefix) {
        const shownCount = sMedia.LocalStorage.get(`${storagePrefix}_show_count_${storage}`) || 0;
        sMedia.Context.LogService.Debug(`sMedia: Daily shown count ==> ${shownCount}`);
        return offer_config.shown_cap.active && (shownCount >= offer_config.shown_cap.value);
    }
    sMedia.dailyShownCapMet = dailyShownCapMet;
    function sessionShownCapMet(offer_config, storage, storagePrefix) {
        const shownCount = sMedia.LocalStorage.get(`${storagePrefix}_show_count_${storage}`) || 0;
        sMedia.Context.LogService.Debug(`sMedia: Session shown count ==> ${shownCount}`);
        return offer_config.session_close.active && (shownCount >= offer_config.session_close.value);
    }
    sMedia.sessionShownCapMet = sessionShownCapMet;
    function setAndIncrementSessionDepth(sessionStorage, storagePrefix) {
        const pageVisited = (sMedia.LocalStorage.get(`${storagePrefix}_page_visited_${sessionStorage}`) || 0) + 1;
        sMedia.LocalStorage.set(`${storagePrefix}_page_visited_${sessionStorage}`, pageVisited, sMedia.SECONDS_IN_A_DAY);
        return pageVisited;
    }
    sMedia.setAndIncrementSessionDepth = setAndIncrementSessionDepth;
    function storeSmartOfferSubmit(offer_config, storage, storagePrefix) {
        const submittedAt = sMedia.LocalStorage.get(`${storagePrefix}_submitted_at_${storage}`) || [];
        submittedAt.push(sMedia.Time.Now());
        sMedia.LocalStorage.set(`${storagePrefix}_submitted_at_${storage}`, submittedAt, 30 * sMedia.SECONDS_IN_A_DAY);
    }
    sMedia.storeSmartOfferSubmit = storeSmartOfferSubmit;
    function metFillUpCap(offer_config, persistentStorage, storagePrefix) {
        const shownAt = sMedia.LocalStorage.get(`${storagePrefix}_shown_at_${persistentStorage}`) || [];
        const shownBefore = (shownAt.length > 0) ? true : false;
        const submittedAt = sMedia.LocalStorage.get(`${storagePrefix}_submitted_at_${persistentStorage}`) || [];
        const submittedBefore = (submittedAt.length) ? sMedia.Time.Now() - Math.max.apply(null, submittedAt) : null;
        const metFillUpCap = offer_config.fillup_cap.active &&
            (shownBefore) &&
            (submittedAt.length && submittedBefore > 0) &&
            (submittedBefore <= offer_config.fillup_cap.value * sMedia.SECONDS_IN_A_DAY);
        return metFillUpCap;
    }
    sMedia.metFillUpCap = metFillUpCap;
    function showBasedOnDeviceType(offer_config) {
        return offer_config.device_type[sMedia.Context.Browser.getDeviceType()];
    }
    sMedia.showBasedOnDeviceType = showBasedOnDeviceType;
    function sessionDepthCheck(offer_config, pageVisitCount) {
        return (offer_config.session_depth.active && pageVisitCount < offer_config.session_depth.value);
    }
    sMedia.sessionDepthCheck = sessionDepthCheck;
    function priceRangeMet(offer_config) {
        const carDataParam = (sMedia.Context.PageData.car_data || {});
        const carPrice = sMedia.stringToInt(carDataParam.price);
        const showBasedOnPrice = !offer_config.check_price.active ||
            (!carPrice || (carPrice > offer_config.check_price.min && carPrice < offer_config.check_price.max));
        return showBasedOnPrice;
    }
    sMedia.priceRangeMet = priceRangeMet;
    function storeOfferShown(storage, storagePrefix) {
        const shownAt = sMedia.LocalStorage.get(`${this.storagePrefix}_shown_at_${storage}`) || [];
        shownAt.push(sMedia.Time.Now());
        sMedia.LocalStorage.set(`${storagePrefix}_shown_at_${storage}`, shownAt.slice(-4), 30 * sMedia.SECONDS_IN_A_DAY);
    }
    sMedia.storeOfferShown = storeOfferShown;
    function increaseShowCount(sessionStorage, persistentStorage, storagePrefix) {
        const shownCount = sMedia.LocalStorage.get(`${storagePrefix}_show_count_${sessionStorage}`) || 0;
        sMedia.LocalStorage.set(`${storagePrefix}_show_count_${sessionStorage}`, shownCount + 1, sMedia.SECONDS_IN_A_DAY);
        const dailyShownCount = sMedia.LocalStorage.get(`${storagePrefix}_show_count_${persistentStorage}`) || 0;
        sMedia.LocalStorage.set(`${storagePrefix}_show_count_${persistentStorage}`, dailyShownCount + 1, sMedia.SECONDS_IN_A_DAY);
    }
    sMedia.increaseShowCount = increaseShowCount;
    function fetchProfilerAnswers(config_id) {
        return sMedia.LocalStorage.get(`smart_profiler_answers_${config_id}`) || [];
    }
    sMedia.fetchProfilerAnswers = fetchProfilerAnswers;
    function storeSmartProfilerAnswers(config_id, currentAnswerObject) {
        const savedAnswers = fetchProfilerAnswers(config_id);
        savedAnswers.push(currentAnswerObject);
        sMedia.LocalStorage.set(`smart_profiler_answers_${config_id}`, savedAnswers, 7 * sMedia.SECONDS_IN_A_DAY);
    }
    sMedia.storeSmartProfilerAnswers = storeSmartProfilerAnswers;
    function clearProfilerAnswers(config_id) {
        sMedia.LocalStorage.clear(`smart_profiler_answers_${config_id}`);
    }
    sMedia.clearProfilerAnswers = clearProfilerAnswers;
    function showProfilerNextView(currentId, nextId, defaultId) {
        document.getElementById(`sp-qa-ui-${currentId}`).classList.add('sp-hidden');
        if (nextId == "-1") {
            nextId = defaultId;
        }
        if (nextId == "0") {
            if (defaultId != "0") {
                const nextUi = document.getElementById(`sp-qa-ui-${defaultId}`);
                nextUi.classList.remove('sp-hidden');
                nextUi.dataset.shownAt = Date.now().toString();
            }
            else {
                showProfilerLeadForm();
            }
        }
        else {
            const nextUi = document.getElementById(`sp-qa-ui-${nextId}`);
            nextUi.classList.remove('sp-hidden');
            nextUi.dataset.shownAt = Date.now().toString();
        }
    }
    sMedia.showProfilerNextView = showProfilerNextView;
    function showProfilerLeadForm() {
        document.getElementById('smart-profiler-lead-form').classList.remove('sp-hidden');
        const brWidth = window.innerWidth;
        const proCon = document.getElementById('smart-profiler-container');
        if (brWidth <= 900) {
            if (!proCon.className.includes('smart-profiler-container-lead-page')) {
                proCon.classList.add('smart-profiler-container-lead-page');
            }
        }
        else {
            if (proCon.className.includes('smart-profiler-container-lead-page')) {
                proCon.classList.remove('smart-profiler-container-lead-page');
            }
        }
    }
    sMedia.showProfilerLeadForm = showProfilerLeadForm;
    function isNonZeroElementInViewPort(element) {
        const rect = element.getBoundingClientRect();
        const winHeight = window.innerHeight || document.documentElement.clientHeight;
        const winWidth = window.innerWidth || document.documentElement.clientWidth;
        return !(rect.width == 0 || rect.height == 0) && (rect.top >= 0 && rect.left >= 0) &&
            (rect.bottom <= winHeight) && (rect.right <= winWidth);
    }
    sMedia.isNonZeroElementInViewPort = isNonZeroElementInViewPort;
    function getInputsInViewPort() {
        const allInputs = document.querySelectorAll('input, select, textarea');
        return [...allInputs].filter((elm) => isNonZeroElementInViewPort(elm));
    }
    sMedia.getInputsInViewPort = getInputsInViewPort;
    function multipleInputsInViewPort() {
        const SOC = sMedia.Context.DomainConfig.smart_offer_control;
        if (SOC && SOC.form_open && SOC.form_open[sMedia.Context.PageType]) {
            const visibleInputs = getInputsInViewPort();
            const len = visibleInputs.length;
            return len > 2;
        }
        return false;
    }
    sMedia.multipleInputsInViewPort = multipleInputsInViewPort;
    function sendSoShownGA() {
        if (typeof ga === 'function') {
            ga("smedia_analytics_tracker.send", {
                hitType: "event",
                eventCategory: "smart_offer",
                eventAction: "shown",
                nonInteraction: true,
            });
        }
        const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
            sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
        if (trackerCount > 1) {
            const trackerBaseName = "smedia_analytics_tracker";
            for (let p = 1; p < trackerCount; p++) {
                const trackerName = `${trackerBaseName}_${p}`;
                if (typeof ga === 'function') {
                    ga(`${trackerName}.send`, {
                        hitType: "event",
                        eventCategory: "smart_offer",
                        eventAction: "shown",
                        nonInteraction: true,
                    });
                }
            }
        }
        const shownEvent = new CustomEvent("smart_offer.shown", {
            detail: {
                pageType: sMedia.Context.PageType,
                carData: sMedia.Context.PageData.car_data,
            },
        });
        document.dispatchEvent(shownEvent);
    }
    sMedia.sendSoShownGA = sendSoShownGA;
    function sendSoSubmitGA() {
        if (typeof ga === 'function') {
            ga("smedia_analytics_tracker.send", {
                hitType: "event",
                eventCategory: "smart_offer",
                eventAction: "lead",
                nonInteraction: true,
            });
        }
        const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
            sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
        if (trackerCount > 1) {
            const trackerBaseName = "smedia_analytics_tracker";
            for (let p = 1; p < trackerCount; p++) {
                const trackerName = `${trackerBaseName}_${p}`;
                if (typeof ga === 'function') {
                    ga(`${trackerName}.send`, {
                        hitType: "event",
                        eventCategory: "smart_offer",
                        eventAction: "lead",
                        nonInteraction: true,
                    });
                }
            }
        }
        const completeEvent = new CustomEvent("smart_offer.submit", {
            detail: {
                formName: "smart_offer_submit",
                pageType: sMedia.Context.PageType,
                carData: sMedia.Context.PageData.car_data,
            },
        });
        document.dispatchEvent(completeEvent);
    }
    sMedia.sendSoSubmitGA = sendSoSubmitGA;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    let LogType;
    (function (LogType) {
        LogType[LogType["Info"] = 0] = "Info";
        LogType[LogType["Warning"] = 1] = "Warning";
        LogType[LogType["Error"] = 2] = "Error";
        LogType[LogType["Debug"] = 3] = "Debug";
    })(LogType = sMedia.LogType || (sMedia.LogType = {}));
    class LogService {
        constructor(scope, debug) {
            this.scope = scope;
            this.debug = debug;
        }
        Debug(msg) {
            this.Log(LogType.Debug, msg);
        }
        Log(type, msg) {
            if (type == LogType.Debug && !this.debug) {
                return;
            }
            let colour = "#00f";
            let title = "Info";
            let func = console.log;
            switch (type) {
                case LogType.Debug:
                    colour = "#880";
                    title = "Debug";
                    func = console.info;
                    break;
                case LogType.Error:
                    colour = "#f00";
                    title = "Error";
                    func = console.error;
                    break;
                case LogType.Warning:
                    colour = "#f30";
                    title = "Warning";
                    func = console.warn;
                    break;
                case LogType.Info:
                    colour = "#00f";
                    title = "Info";
                    func = console.info;
                    break;
            }
            console.group(`%c ${this.scope} ${title}`, `background: #fff; color: ${colour}`);
            func(msg);
            console.groupEnd();
        }
    }
    sMedia.LogService = LogService;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class LocalStorage {
        static Supported() {
            if (typeof Storage !== "undefined") {
                return true;
            }
            else {
                return false;
            }
        }
        static set(key, value, ttl = 0) {
            const item = {
                value: value,
                canExpire: ttl >= 0,
                expireAt: ((new Date().getTime()) / 1000) + ttl,
            };
            localStorage.setItem(key, JSON.stringify(item));
        }
        static get(key) {
            const itemStr = localStorage.getItem(key);
            if (!itemStr) {
                return null;
            }
            const item = JSON.parse(itemStr);
            if (item.canExpire && (((new Date().getTime()) / 1000) > item.expireAt)) {
                localStorage.removeItem(key);
                return null;
            }
            return item.value;
        }
        static clearAll() {
            localStorage.clear();
            console.log("sMedia: Localstorage has been cleared");
        }
        static clear(key) {
            localStorage.removeItem(key);
            console.log(`sMedia: ${key} has been removed from localstorage`);
        }
    }
    sMedia.LocalStorage = LocalStorage;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class Ajax {
        constructor() {
            this.Busy = false;
        }
        Get(url, callback, onErrorCallback) {
            if (this.Busy) {
                return;
            }
            this.Busy = true;
            try {
                this.Request = new (XMLHttpRequest || ActiveXObject)("MSXML2.XMLHTTP.3.0");
                this.Request.open("GET", url, true);
                this.Request.onreadystatechange = () => {
                    if (this.Request.readyState > 3) {
                        if (this.Request.status === 200 && callback) {
                            try {
                                callback(JSON.parse(this.Request.response));
                            }
                            catch (e) {
                                sMedia.Context.LogService.Debug(e);
                            }
                        }
                        else if (onErrorCallback) {
                            try {
                                onErrorCallback(JSON.parse(this.Request.response));
                            }
                            catch (e) {
                                sMedia.Context.LogService.Debug(e);
                            }
                        }
                        this.Busy = false;
                    }
                };
                try {
                    this.Request.send();
                }
                catch (e) {
                    sMedia.Context.LogService.Debug(e);
                    if (onErrorCallback) {
                        try {
                            onErrorCallback(e);
                        }
                        catch (e) {
                            sMedia.Context.LogService.Debug(e);
                        }
                    }
                }
            }
            catch (e) {
                if (onErrorCallback) {
                    try {
                        onErrorCallback(e);
                    }
                    catch (e) {
                        sMedia.Context.LogService.Debug(e);
                    }
                }
                this.Busy = false;
                sMedia.Context.LogService.Debug(e);
            }
        }
        Post(url, data, callback, onErrorCallback, contentType, additionalHeaders) {
            if (this.Busy) {
                return;
            }
            contentType = !!contentType ? contentType : "application/json";
            this.Busy = true;
            try {
                this.Request = new (XMLHttpRequest || ActiveXObject)("MSXML2.XMLHTTP.3.0");
                this.Request.open("POST", url, true);
                if (contentType !== "multipart/form-data") {
                    this.Request.setRequestHeader("Content-type", contentType);
                }
                if (!!additionalHeaders && !sMedia.isEmptyObject(additionalHeaders)) {
                    for (const [key, value] of Object.entries(additionalHeaders)) {
                        this.Request.setRequestHeader(key, value);
                    }
                }
                this.Request.onreadystatechange = () => {
                    if (this.Request.readyState == XMLHttpRequest.DONE || this.Request.readyState > 3) {
                        if (this.Request.status === 200 && callback) {
                            try {
                                callback(JSON.parse(this.Request.response));
                            }
                            catch (e) {
                                sMedia.Context.LogService.Debug(e);
                            }
                        }
                        else if (onErrorCallback) {
                            try {
                                onErrorCallback(JSON.parse(this.Request.response));
                            }
                            catch (e) {
                                sMedia.Context.LogService.Debug(e);
                            }
                        }
                        this.Busy = false;
                    }
                };
                try {
                    let processedData = null;
                    switch (contentType) {
                        case "application/json":
                            processedData = JSON.stringify(data);
                            break;
                        case "application/x-www-form-urlencoded":
                            processedData = Object.keys(data).map((key) => `${key}=${data[key]}`).join("&");
                            break;
                        case "multipart/form-data":
                            processedData = data;
                            break;
                    }
                    this.Request.send(processedData);
                }
                catch (e) {
                    if (onErrorCallback) {
                        try {
                            onErrorCallback(e);
                        }
                        catch (e) {
                            sMedia.Context.LogService.Debug(e);
                        }
                    }
                    sMedia.Context.LogService.Debug(e);
                }
            }
            catch (e) {
                this.Busy = false;
                if (onErrorCallback) {
                    try {
                        onErrorCallback(e);
                    }
                    catch (e) {
                        sMedia.Context.LogService.Debug(e);
                    }
                }
                sMedia.Context.LogService.Debug(e);
            }
        }
        IsBusy() {
            return this.Busy;
        }
    }
    sMedia.Ajax = Ajax;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class HttpCom {
        constructor(endpoint, ajax) {
            this.Endpoint = endpoint;
            this.ajax = ajax;
        }
        Submit(request, callback) {
            this.ajax.Post(this.Endpoint, request, callback);
        }
        IsBusy() {
            return this.ajax.IsBusy();
        }
    }
    sMedia.HttpCom = HttpCom;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class DomInstaller {
        static InstallScript(script_url, location = "head", onload, async = true) {
            if (location !== "body") {
                location = "head";
            }
            const sref = document.createElement("script");
            sref.setAttribute("type", "text/javascript");
            sref.setAttribute("src", script_url);
            if (async === true) {
                sref.setAttribute("async", "");
            }
            if (!!onload) {
                sref.addEventListener("load", onload);
            }
            let parent;
            if (typeof location === "string") {
                parent = document.querySelector(location);
            }
            else {
                parent = location;
            }
            parent.appendChild(sref);
            console.log(`sMedia: Included Script '${script_url}'`);
        }
        static InstallStyle(style_url, location = "head", onload) {
            const sref = document.createElement("link");
            sref.rel = "stylesheet";
            sref.href = style_url;
            if (!!onload) {
                sref.addEventListener("load", onload);
            }
            let parent;
            if (typeof location === "string") {
                parent = document.querySelector(location);
            }
            else {
                parent = location;
            }
            parent.appendChild(sref);
            console.log(`sMedia: Included Style '${style_url}'`);
        }
        static InstallIframe(frame_url) {
            const sref = document.createElement("iframe");
            sref.setAttribute("width", "1");
            sref.setAttribute("height", "1");
            sref.setAttribute("frameborder", "0");
            sref.setAttribute("src", frame_url);
            document.getElementsByTagName("body")[0].appendChild(sref);
            console.log(`sMedia: Included Iframe '${frame_url}'`);
        }
    }
    sMedia.DomInstaller = DomInstaller;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class Dictionary {
        constructor() {
            this.items = {};
            this.count = 0;
        }
        ContainsKey(key) {
            return this.items.hasOwnProperty(key);
        }
        Count() {
            return this.count;
        }
        Add(key, value) {
            if (!this.items.hasOwnProperty(key)) {
                this.count++;
            }
            this.items[key] = value;
        }
        Remove(key) {
            const val = this.items[key];
            delete this.items[key];
            this.count--;
            return val;
        }
        Item(key) {
            return this.items[key];
        }
        Keys() {
            const keySet = [];
            for (const prop in this.items) {
                if (this.items.hasOwnProperty(prop)) {
                    keySet.push(prop);
                }
            }
            return keySet;
        }
        Values() {
            const values = [];
            for (const prop in this.items) {
                if (this.items.hasOwnProperty(prop)) {
                    values.push(this.items[prop]);
                }
            }
            return values;
        }
    }
    sMedia.Dictionary = Dictionary;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class Time {
        static Now() {
            return Math.round(new Date().getTime() / 1000);
        }
        static MillisecondsNow() {
            return new Date().getTime();
        }
    }
    sMedia.Time = Time;
    class Timer {
        constructor(callback, interval = 1000) {
            this.Callback = callback;
            this.Interval = interval;
        }
        Start(count = 0) {
            this.Run = true;
            this._Tick = 0;
            this.TickFor = count;
            this.Timeout();
        }
        Stop() {
            this.Run = false;
        }
        Tick() {
            return this._Tick;
        }
        Timeout() {
            setTimeout(() => {
                if (!this.Run) {
                    return;
                }
                this._Tick++;
                if (this.Callback) {
                    this.Callback(this._Tick);
                }
                if (this.TickFor > 0 && this._Tick === this.TickFor) {
                    this.Stop();
                    return;
                }
                this.Timeout();
            }, this.Interval);
        }
    }
    sMedia.Timer = Timer;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class SHA256 {
        constructor() {
            this.chrsz = 8;
            this.hexcase = 0;
        }
        Hash(s) {
            s = this.Utf8Encode(s);
            return this.binb2hex(this.core_sha256(this.str2binb(s), s.length * this.chrsz));
        }
        safe_add(x, y) {
            const lsw = (x & 0xffff) + (y & 0xffff);
            const msw = (x >> 16) + (y >> 16) + (lsw >> 16);
            return (msw << 16) | (lsw & 0xffff);
        }
        S(X, n) {
            return (X >>> n) | (X << (32 - n));
        }
        R(X, n) {
            return X >>> n;
        }
        Ch(x, y, z) {
            return (x & y) ^ (~x & z);
        }
        Maj(x, y, z) {
            return (x & y) ^ (x & z) ^ (y & z);
        }
        Sigma0256(x) {
            return this.S(x, 2) ^ this.S(x, 13) ^ this.S(x, 22);
        }
        Sigma1256(x) {
            return this.S(x, 6) ^ this.S(x, 11) ^ this.S(x, 25);
        }
        Gamma0256(x) {
            return this.S(x, 7) ^ this.S(x, 18) ^ this.R(x, 3);
        }
        Gamma1256(x) {
            return this.S(x, 17) ^ this.S(x, 19) ^ this.R(x, 10);
        }
        core_sha256(m, l) {
            const K = [
                0x428a2f98,
                0x71374491,
                0xb5c0fbcf,
                0xe9b5dba5,
                0x3956c25b,
                0x59f111f1,
                0x923f82a4,
                0xab1c5ed5,
                0xd807aa98,
                0x12835b01,
                0x243185be,
                0x550c7dc3,
                0x72be5d74,
                0x80deb1fe,
                0x9bdc06a7,
                0xc19bf174,
                0xe49b69c1,
                0xefbe4786,
                0xfc19dc6,
                0x240ca1cc,
                0x2de92c6f,
                0x4a7484aa,
                0x5cb0a9dc,
                0x76f988da,
                0x983e5152,
                0xa831c66d,
                0xb00327c8,
                0xbf597fc7,
                0xc6e00bf3,
                0xd5a79147,
                0x6ca6351,
                0x14292967,
                0x27b70a85,
                0x2e1b2138,
                0x4d2c6dfc,
                0x53380d13,
                0x650a7354,
                0x766a0abb,
                0x81c2c92e,
                0x92722c85,
                0xa2bfe8a1,
                0xa81a664b,
                0xc24b8b70,
                0xc76c51a3,
                0xd192e819,
                0xd6990624,
                0xf40e3585,
                0x106aa070,
                0x19a4c116,
                0x1e376c08,
                0x2748774c,
                0x34b0bcb5,
                0x391c0cb3,
                0x4ed8aa4a,
                0x5b9cca4f,
                0x682e6ff3,
                0x748f82ee,
                0x78a5636f,
                0x84c87814,
                0x8cc70208,
                0x90befffa,
                0xa4506ceb,
                0xbef9a3f7,
                0xc67178f2,
            ];
            const HASH = [
                0x6a09e667,
                0xbb67ae85,
                0x3c6ef372,
                0xa54ff53a,
                0x510e527f,
                0x9b05688c,
                0x1f83d9ab,
                0x5be0cd19,
            ];
            const W = [64];
            let a, b, c, d, e, f, g, h;
            let T1, T2;
            m[l >> 5] |= 0x80 << (24 - (l % 32));
            m[(((l + 64) >> 9) << 4) + 15] = l;
            for (let i = 0; i < m.length; i += 16) {
                a = HASH[0];
                b = HASH[1];
                c = HASH[2];
                d = HASH[3];
                e = HASH[4];
                f = HASH[5];
                g = HASH[6];
                h = HASH[7];
                for (let j = 0; j < 64; j++) {
                    if (j < 16) {
                        W[j] = m[j + i];
                    }
                    else {
                        W[j] = this.safe_add(this.safe_add(this.safe_add(this.Gamma1256(W[j - 2]), W[j - 7]), this.Gamma0256(W[j - 15])), W[j - 16]);
                        T1 = this.safe_add(this.safe_add(this.safe_add(this.safe_add(h, this.Sigma1256(e)), this.Ch(e, f, g)), K[j]), W[j]);
                        T2 = this.safe_add(this.Sigma0256(a), this.Maj(a, b, c));
                        h = g;
                        g = f;
                        f = e;
                        e = this.safe_add(d, T1);
                        d = c;
                        c = b;
                        b = a;
                        a = this.safe_add(T1, T2);
                    }
                }
                HASH[0] = this.safe_add(a, HASH[0]);
                HASH[1] = this.safe_add(b, HASH[1]);
                HASH[2] = this.safe_add(c, HASH[2]);
                HASH[3] = this.safe_add(d, HASH[3]);
                HASH[4] = this.safe_add(e, HASH[4]);
                HASH[5] = this.safe_add(f, HASH[5]);
                HASH[6] = this.safe_add(g, HASH[6]);
                HASH[7] = this.safe_add(h, HASH[7]);
            }
            return HASH;
        }
        str2binb(str) {
            const bin = [];
            const mask = (1 << this.chrsz) - 1;
            for (let i = 0; i < str.length * this.chrsz; i += this.chrsz) {
                bin[i >> 5] |=
                    (str.charCodeAt(i / this.chrsz) & mask) << (24 - (i % 32));
            }
            return bin;
        }
        Utf8Encode(string) {
            string = string.replace(/\r\n/g, "\n");
            let utftext = "";
            for (let n = 0; n < string.length; n++) {
                const c = string.charCodeAt(n);
                if (c < 128) {
                    utftext += String.fromCharCode(c);
                }
                else if (c > 127 && c < 2048) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
                else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
            }
            return utftext;
        }
        binb2hex(binarray) {
            const hex_tab = this.hexcase
                ? "0123456789ABCDEF"
                : "0123456789abcdef";
            let str = "";
            for (let i = 0; i < binarray.length * 4; i++) {
                str +=
                    hex_tab.charAt((binarray[i >> 2] >> ((3 - (i % 4)) * 8 + 4)) & 0xf) +
                        hex_tab.charAt((binarray[i >> 2] >> ((3 - (i % 4)) * 8)) & 0xf);
            }
            return str;
        }
    }
    sMedia.SHA256 = SHA256;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class URLParser {
        constructor(url) {
            this._url = url;
        }
        getQueryByName(name, url) {
            if (!url) {
                url = window.location.href.split('#')[0];
            }
            name = name.replace(/[\[\]]/g, "\\$&");
            const regex = new RegExp(`[?&]${name}(=([^&#]*)|&|#|$)`);
            const results = regex.exec(url);
            if (!results) {
                return null;
            }
            if (!results[2]) {
                return "";
            }
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
        query(name, def_val = "") {
            const retval = this.getQueryByName(name, this.get());
            return retval !== null ? retval : def_val;
        }
        get() {
            return this._url;
        }
        static current() {
            return new URLParser(document.location.href.split('#')[0]);
        }
    }
    sMedia.URLParser = URLParser;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class Cookie {
        static get(name) {
            const cookieRegex = new RegExp(`(?:^|; )${encodeURIComponent(name)}=([^;]*)`);
            const result = cookieRegex.exec(document.cookie);
            return result ? result[1] : null;
        }
        static set(name, value, days) {
            let expires = "";
            if (days > 0) {
                const date = new Date();
                date.setTime(date.getTime() + days * sMedia.SECONDS_IN_A_DAY * 1000);
                expires = `; expires=${date.toUTCString()}`;
            }
            document.cookie = `${name}=${value}${expires}; path=/`;
        }
        static remove(name) {
            this.set(name, "", -1);
        }
    }
    sMedia.Cookie = Cookie;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class XDomainCookie {
        static init(cookie_proxy_path, callback, timeout = 5000) {
            this.Callbacks = new sMedia.Dictionary();
            this.StorageCallbacks = new sMedia.Dictionary();
            window.addEventListener("message", (event) => {
                this.receiveMessage(event);
            }, false);
            this.cookieContainer = document.createElement("iframe");
            this.cookieContainer.src = `${cookie_proxy_path}/xcookie.html`;
            this.cookieContainer.style.display = "none";
            document.body.appendChild(this.cookieContainer);
            const t = new sMedia.Timer((_) => {
                if (this.ready) {
                    t.Stop();
                    callback();
                }
            }, 100);
            t.Start(Math.ceil(timeout / 100));
        }
        static isReady() {
            return this.ready;
        }
        static get(name, callback) {
            if (!this.ready) {
                return;
            }
            this.counter++;
            const requestId = String(this.counter);
            const data = { name: name, requestId: requestId };
            this.Callbacks.Add(requestId, callback);
            this.callContainerFunction("get_cookie", data);
        }
        static set(name, value, days) {
            if (!this.ready) {
                return;
            }
            const data = { name: name, value: value, days: days };
            this.callContainerFunction("set_cookie", data);
        }
        static remove(name) {
            if (!this.ready) {
                return;
            }
            const data = { name: name };
            this.callContainerFunction("remove_cookie", data);
        }
        static storageSupported() {
            return typeof Storage !== "undefined";
        }
        static setStorageData(key, value, ttl) {
            if (ttl <= 0) {
                ttl = 0;
            }
            if (!this.ready) {
                return;
            }
            const data = {
                key: key,
                value: JSON.stringify(value),
                ttl: ttl,
            };
            this.callContainerFunction("set_data", data);
        }
        static getStorageData(key, callback) {
            this.storageCounter++;
            const requestId = String(this.storageCounter);
            const data = { key: key, requestId: requestId };
            this.StorageCallbacks.Add(requestId, callback);
            this.callContainerFunction("get_data", data);
        }
        static receiveMessage(event) {
            if (!event.data || event.data.sender != "xdomaincookie") {
                return;
            }
            switch (event.data.action) {
                case "cookie_ready":
                    this.ready = true;
                    break;
                case "cookie_callback": {
                    const requestId = event.data.requestId;
                    if (this.Callbacks.ContainsKey(requestId)) {
                        const callback = this.Callbacks.Remove(requestId);
                        callback(event.data.value);
                    }
                    break;
                }
                case "storage_get_callback": {
                    const storageRequestId = event.data.requestId;
                    if (this.StorageCallbacks.ContainsKey(storageRequestId)) {
                        const callback = this.StorageCallbacks.Remove(storageRequestId);
                        callback(JSON.parse(event.data.value));
                    }
                    break;
                }
            }
        }
        static callContainerFunction(action, data) {
            data.sender = "xdomaincookie";
            data.action = action;
            this.sendMessage(data);
        }
        static sendMessage(data) {
            this.cookieContainer.contentWindow.postMessage(data, "*");
        }
    }
    XDomainCookie.ready = false;
    XDomainCookie.counter = 0;
    XDomainCookie.storageCounter = 0;
    sMedia.XDomainCookie = XDomainCookie;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class Browser {
        constructor(hashFunc) {
            this.HashFunction = hashFunc;
            this.screenSize = [window.screen.width, window.screen.height].join("x");
            this.userAgent = navigator.userAgent;
            this.urlReferrer = document.referrer;
            this.url = document.location.href.split('#')[0];
            this.domain = document.location.hostname;
            this.timestamp = sMedia.Time.MillisecondsNow();
            this.now = sMedia.Time.MillisecondsNow();
        }
        prepareBrowserIds(callback) {
            let uuid = sMedia.Cookie.get("smedia_uuid");
            if (!uuid || typeof uuid != "string") {
                const uuidArray = [
                    this.userAgent,
                    this.screenSize,
                    this.urlReferrer,
                    this.url,
                    this.timestamp
                ];
                uuid = this.HashFunction.Hash(uuidArray.join("|"));
            }
            sMedia.Cookie.set("smedia_uuid", uuid, 365);
            this.uniqueUserId = uuid;
            this.sessionId = this.getSessionId();
            this.pageViewId = this.getPageViewId();
            this.browserReady = true;
            callback();
        }
        isReady() {
            return this.browserReady;
        }
        getSessionId() {
            let sessionId = sMedia.Cookie.get("smedia_session_id");
            if (!sessionId) {
                const sessionIDArray = [
                    this.url,
                    this.uniqueUserId,
                    this.timestamp
                ];
                sessionId = this.HashFunction.Hash(sessionIDArray.join("|"));
                sMedia.Cookie.set("smedia_session_id", sessionId);
            }
            return sessionId;
        }
        getPageViewId() {
            return this.HashFunction.Hash([
                this.url,
                this.uniqueUserId,
                this.sessionId,
                this.timestamp,
            ].join("|"));
        }
        scriptDomain() {
            const scripts = document.getElementsByTagName("SCRIPT");
            if (scripts && scripts.length > 0) {
                for (const i in scripts) {
                    const script = scripts[i];
                    if (script.src && script.src.match(/\/common\.js$/)) {
                        const [, domain = ""] = script.src.match(/(?:https?\:\/\/)((?:[a-zA-Z0-9-\.]+))/) || [];
                        return domain;
                    }
                }
            }
            return "";
        }
        getDeviceType() {
            const UA = navigator.userAgent;
            const tablets = new RegExp('(tablet|ipad|playbook|silk)|(android(?!.*mobi))', 'i');
            const mobiles = new RegExp('Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)');
            if (tablets.test(UA)) {
                return "tablet";
            }
            if (mobiles.test(UA)) {
                return "mobile";
            }
            return "desktop";
        }
        onUrlChange(callback) {
            const t = new sMedia.Timer((_) => {
                if (this.url !== document.location.href.split('#')[0]) {
                    this.url = document.location.href.split('#')[0];
                    this.timestamp = sMedia.Time.MillisecondsNow();
                    this.now = sMedia.Time.MillisecondsNow();
                    callback();
                }
            }, 200);
            t.Start(0);
        }
    }
    sMedia.Browser = Browser;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class UniquePathGenerator {
        childIndex(elem) {
            if (elem && elem.parentNode && elem.parentNode.children) {
                const children = elem.parentNode.children;
                for (let i = 0; i < children.length; i++) {
                    if (children.item(i) == elem) {
                        return i;
                    }
                }
            }
            return null;
        }
        GetPath(el, skipId = false) {
            const rightArrowParents = [];
            let elm, idx, entry, tagname;
            for (elm = el; elm; elm = elm.parentNode) {
                idx = this.childIndex(elm) + 1;
                tagname = elm.tagName;
                if (!tagname) {
                    continue;
                }
                entry = tagname.toLowerCase();
                if (entry === "html") {
                    break;
                }
                if (elm.id &&
                    typeof elm.id.includes === "function" &&
                    !skipId) {
                    if (!elm.id.includes("/")) {
                        entry += `#${elm.id}:nth-child(${idx})`;
                        rightArrowParents.push(entry);
                        break;
                    }
                }
                if (elm.className && elm.className.replace) {
                    const cls = elm.className
                        .replace(/^\s+|\s+$/gm, "")
                        .replace(/\s\s+/g, " ")
                        .replace(/\s/g, ".");
                    if (cls) {
                        entry += `.${cls}`;
                    }
                }
                entry += `:nth-child(${idx})`;
                rightArrowParents.push(entry);
            }
            rightArrowParents.reverse();
            return rightArrowParents.join(" ");
        }
    }
    sMedia.UniquePathGenerator = UniquePathGenerator;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class EventRequest {
        constructor(category, action, value, data, callback, id) {
            this.Category = category;
            this.Action = action;
            this.Value = value;
            this.Data = data;
            this.Callback = callback;
            this.Timestamp = sMedia.Time.MillisecondsNow();
            this.Id = id ? id : this.generateId();
        }
        generateId() {
            const hashableArray = [
                sMedia.Context.Browser.uniqueUserId,
                sMedia.Context.Browser.url,
                this.Category,
                this.Action,
                this.Value,
                this.Data,
                this.Timestamp
            ];
            return sMedia.Context.HashFunction.Hash(hashableArray.join("|"));
        }
    }
    sMedia.EventRequest = EventRequest;
    class EventResponse {
        constructor(id, success, data, message) {
            this.RequestId = id;
            this.Success = success;
            this.Data = data;
            this.Message = message;
        }
    }
    sMedia.EventResponse = EventResponse;
    class EventTracker {
        constructor(com, buffer_size = 10, buffer_timeout = 1000) {
            this.EventQueue = new Array();
            this.WaitQueue = new sMedia.Dictionary();
            this.RecordCallbacks = new Array();
            this.Com = com;
            this.BufferSize = buffer_size;
            this.BufferTimeout = buffer_timeout;
        }
        OnRecord(callback) {
            this.RecordCallbacks.push(callback);
        }
        RemoveRecordCallback(callback) {
            const index = this.RecordCallbacks.indexOf(callback);
            if (index >= 0) {
                delete this.RecordCallbacks[index];
            }
        }
        Record(category, action, value, data, callback, eventIdCallback, id) {
            let request = null;
            if (id && !this.Processing) {
                this.EventQueue.every((e, i, er) => {
                    if (e.Id == id) {
                        er[i].Value = value;
                        er[i].Data = data;
                        request = er[i];
                        return false;
                    }
                    return true;
                });
            }
            if (!request) {
                const commonData = { pageType: sMedia.Context.PageType, ip: sMedia.Context.DomainConfig.ip };
                const eventData = { ...data, ...commonData } || commonData;
                request = new EventRequest(category, action, value, eventData, callback, id);
                this.EventQueue.push(request);
                if (eventIdCallback) {
                    eventIdCallback(request.Id);
                }
            }
            this.RecordCallbacks.forEach((eventReceived) => {
                eventReceived(request);
            });
            if (this.EventQueue.length >= this.BufferSize) {
                this.Process();
            }
        }
        Flush() {
            this.Process();
        }
        Process() {
            if (this.Processing ||
                this.Com.IsBusy() ||
                this.EventQueue.length == 0) {
                return;
            }
            this.Processing = true;
            sMedia.Context.Browser.now = sMedia.Time.MillisecondsNow();
            const request = {
                browser: sMedia.Context.Browser,
                events: [],
            };
            while (this.EventQueue.length > 0) {
                const event = this.EventQueue.shift();
                this.WaitQueue.Add(event.Id, event);
                request.events.push(event);
            }
            const tagControls = sMedia.Context.DomainConfig.dealer_info.tag_controls;
            const allowEventTracker = sMedia.isEmptyObject(tagControls) ? true : tagControls.event_tracker;
            if (allowEventTracker) {
                this.Com.Submit(request, (resp) => {
                    this.Processing = false;
                    if (resp.success) {
                        for (let i = 0; i < resp.result.length; i++) {
                            const event = this.WaitQueue.Remove(resp.result[i].Id);
                            if (event && event.Callback) {
                                event.Callback(new EventResponse(event.Id, resp.result[i].success, resp.result[i], resp.message));
                            }
                        }
                    }
                });
            }
        }
        Start() {
            this.Timer = new sMedia.Timer((t) => {
                this.Process();
            }, this.BufferTimeout);
            this.Timer.Start();
        }
        Stop() {
            this.Timer.Stop();
        }
    }
    sMedia.EventTracker = EventTracker;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class Application {
        constructor(hashFunc, browser, pathGenerator, eventTracker, logService) {
            this.TagStatus = new sMedia.TagStatus();
            this.AppStates = {
                smart_profiler_enabled: false
            };
            this.PreReadyCallbacks = new Array();
            this.ReadyCallbacks = new Array();
            this.CloseCallbacks = new Array();
            this.HashFunction = hashFunc;
            this.Browser = browser;
            this.PathGenerator = pathGenerator;
            this.EventTracker = eventTracker;
            this.Ready = false;
            this.Closed = false;
            this.LogService = logService;
            this.BrowserName = this.browserDetect();
            this.InitGlobalCallbacks();
        }
        InitGlobalCallbacks() {
            var _a, _b, _c, _d, _e;
            const GC = {};
            if (window.smediaCallbacks !== void 0) {
                Object.keys(window.smediaCallbacks).forEach((k) => {
                    const keys = k.split(".");
                    if (keys.length == 1) {
                        GC[keys[0]] = window.smediaCallbacks[k];
                    }
                    else if (keys.length == 2) {
                        GC[keys[0]] = GC[keys[0]] || {};
                        GC[keys[0]][keys[1]] = window.smediaCallbacks[k];
                    }
                });
            }
            this.GlobalCallbacks = {
                epm: (GC === null || GC === void 0 ? void 0 : GC.epm) || [],
                aiButton: {
                    onTextChange: ((_a = GC === null || GC === void 0 ? void 0 : GC.aiButton) === null || _a === void 0 ? void 0 : _a.onTextChange) || [],
                    onClick: ((_b = GC === null || GC === void 0 ? void 0 : GC.aiButton) === null || _b === void 0 ? void 0 : _b.onClick) || [],
                },
                aiForm: {
                    onClose: ((_c = GC === null || GC === void 0 ? void 0 : GC.aiForm) === null || _c === void 0 ? void 0 : _c.onClose) || [],
                    onLoad: ((_d = GC === null || GC === void 0 ? void 0 : GC.aiForm) === null || _d === void 0 ? void 0 : _d.onLoad) || [],
                    onFillUp: ((_e = GC === null || GC === void 0 ? void 0 : GC.aiForm) === null || _e === void 0 ? void 0 : _e.onFillUp) || [],
                },
            };
        }
        IsReady() {
            return this.Ready;
        }
        PreReady(callback) {
            this.PreReadyCallbacks.push(callback);
            if (this.Ready) {
                callback();
            }
        }
        OnReady(callback) {
            this.ReadyCallbacks.push(callback);
            if (this.Ready) {
                callback();
            }
        }
        OnClose(callback) {
            this.CloseCallbacks.push(callback);
            if (this.Closed) {
                callback();
            }
        }
        ApplicationReady(Dealership, DomainConfig, PageType, PageData, DebugFlags) {
            this.Dealership = Dealership;
            this.DomainConfig = DomainConfig;
            this.PageType = PageType;
            this.PageData = PageData;
            this.DebugFlags = DebugFlags;
            this.EventTracker.Start();
            this.TagStatus.setDomainConfig(this.DomainConfig);
            this.TagStatus.setPageData(this.PageData);
            for (const pre of this.PreReadyCallbacks) {
                pre();
            }
            for (const ready of this.ReadyCallbacks) {
                ready();
            }
            this.Ready = true;
        }
        Close() {
            var _a;
            (_a = this.EventTracker) === null || _a === void 0 ? void 0 : _a.Stop();
            this.InitGlobalCallbacks();
            for (let i = 0; i < this.CloseCallbacks.length; i++) {
                this.CloseCallbacks[i]();
            }
            this.Closed = true;
        }
        browserDetect() {
            const userAgent = navigator.userAgent;
            if (userAgent.match(/chrome|chromium|crios/i)) {
                return "chrome";
            }
            else if (userAgent.match(/firefox|fxios/i)) {
                return "firefox";
            }
            else if (userAgent.match(/safari/i)) {
                return "safari";
            }
            else if (userAgent.match(/opr\//i)) {
                return "opera";
            }
            else if (userAgent.match(/edg/i)) {
                return "edge";
            }
            else {
                return "unknown browser";
            }
        }
    }
    sMedia.Application = Application;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class RegExpProcessor {
        p2j(str) {
            if (str[0] === "/") {
                str = str.substr(1);
            }
            if (str.lastIndexOf("/") !== -1) {
                str = str.substr(0, str.lastIndexOf("/"));
            }
            return str;
        }
        make(str, mod) {
            let regex = null;
            if (mod !== "") {
                regex = new RegExp(str, mod);
            }
            else {
                regex = new RegExp(str);
            }
            return regex;
        }
        pmake(str) {
            return this.make(this.p2j(str), "i");
        }
    }
    sMedia.RegExpProcessor = RegExpProcessor;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class DOM {
        constructor(query = null, ctx = document) {
            this.length = 0;
            if (!query) {
                return;
            }
            if (typeof query === "string") {
                try {
                    query = query.trim();
                    const els = ctx.querySelectorAll(query);
                    els.forEach((el, index) => {
                        (this[index] = el);
                    });
                    this.length = els.length;
                }
                catch (e) {
                    console.error("sMedia error: ", e);
                }
            }
            else if ((query instanceof HTMLCollection) || (query instanceof Array)) {
                for (const i in query) {
                    this[i] = query[i];
                }
            }
            else {
                this[0] = query;
                this.length = 1;
            }
            if (typeof window.domEvents === "undefined") {
                window.domEvents = new Map();
            }
        }
        find(query, ctx = document) {
            return new DOM(query, ctx);
        }
        el(query, ctx = document) {
            return new DOM(query, ctx);
        }
        create(html) {
            const template = document.createElement("template");
            template.innerHTML = html;
            return this.el(template.content.children);
        }
        first() {
            return new DOM(this[0]);
        }
        get(key) {
            return this[key] || null;
        }
        each(cb) {
            for (let i = 0, len = this.length; i < len;) {
                if (cb.call(this, this[i], i++) === false) {
                    break;
                }
            }
            return this;
        }
        toArray() {
            const arr = [];
            for (let i = 0, len = this.length; i < len; i++) {
                arr[i] = this[i];
            }
            return arr;
        }
        index(e) {
            return this.toArray().indexOf(e);
        }
        cssObj(css) {
            this.each((el) => {
                Object.keys(css).forEach((key) => el.style.setProperty(key, css[key]));
            });
            return this;
        }
        css(css, val) {
            if (typeof css === "string") {
                if (typeof val === "undefined") {
                    return window.getComputedStyle(this[0]).getPropertyValue(css);
                }
                else {
                    this.each((el) => el.style.setProperty(css, val));
                    return;
                }
            }
            this.cssObj(css);
        }
        hide() {
            this.each((el) => {
                const old_val = window.getComputedStyle(el).getPropertyValue("display");
                el.setAttribute("smedia-dom-restore-display", old_val);
            });
        }
        show() {
            this.each((el) => {
                const old_val = el.getAttribute("smedia-dom-restore-display");
                el.style.setProperty("display", old_val);
            });
        }
        heightWidth(type, val) {
            const sizing = this.first().css("box-sizing");
            if (typeof val === "undefined") {
                const el = this.first();
                let padding = 0;
                if (type === "width") {
                    padding =
                        parseFloat(el.css("padding-left")) +
                            parseFloat(el.css("padding-right"));
                }
                else {
                    padding =
                        parseFloat(el.css("padding-top")) +
                            parseFloat(el.css("padding-bottom"));
                }
                if (sizing === "content-box") {
                    return parseFloat(el.css(type));
                }
                return this.innerHeightWidth(type) - padding;
            }
            if (sizing === "border-box") {
                val += this.outerHeightWidth(type) - this.heightWidth(type);
            }
            this.css(type, `${val}px`);
        }
        width(val) {
            return this.heightWidth("width", val);
        }
        height(val) {
            return this.heightWidth("height", val);
        }
        innerHeightWidth(type) {
            const el = this.first();
            let border = 0;
            const padding = 0;
            const sizing = this.first().css("box-sizing");
            if (sizing === "content-box") {
                if (type === "width") {
                    border =
                        parseFloat(el.css("padding-left")) +
                            parseFloat(el.css("padding-right"));
                }
                else {
                    border =
                        parseFloat(el.css("padding-top")) +
                            parseFloat(el.css("padding-bottom"));
                }
                return this.heightWidth(type) + padding;
            }
            if (type === "width") {
                border =
                    parseFloat(el.css("border-left-width")) +
                        parseFloat(el.css("border-right-width"));
            }
            else {
                border =
                    parseFloat(el.css("border-top-width")) +
                        parseFloat(el.css("border-bottom-width"));
            }
            return this.outerHeightWidth(type) - border;
        }
        innerWidth() {
            return this.innerHeightWidth("width");
        }
        innerHeight() {
            return this.innerHeightWidth("height");
        }
        outerHeightWidth(type, includeMargin = false) {
            const el = this.first();
            let margin = 0;
            let border = 0;
            const sizing = this.first().css("box-sizing");
            if (includeMargin) {
                if (type === "width") {
                    margin =
                        parseFloat(el.css("margin-left")) +
                            parseFloat(el.css("margin-right"));
                }
                else {
                    margin =
                        parseFloat(el.css("margin-top")) +
                            parseFloat(el.css("margin-bottom"));
                }
            }
            if (sizing === "content-box") {
                if (type === "width") {
                    border =
                        parseFloat(el.css("border-left-width")) +
                            parseFloat(el.css("border-right-width"));
                }
                else {
                    border =
                        parseFloat(el.css("border-top-width")) +
                            parseFloat(el.css("border-bottom-width"));
                }
                return this.innerHeightWidth(type) + border + margin;
            }
            return parseFloat(el.css(type)) + margin;
        }
        outerWidth(includeMargin = false) {
            return this.outerHeightWidth("width", includeMargin);
        }
        outerHeight(includeMargin = false) {
            return this.outerHeightWidth("height", includeMargin);
        }
        attrObj(attr) {
            Object.keys(attr).forEach((key) => {
                this.each((el) => el.setAttribute(key, attr[key]));
            });
        }
        attr(attr, val) {
            if (typeof attr === "string") {
                if (typeof val === "undefined") {
                    const value = this[0].getAttribute(attr);
                    return value;
                }
                else {
                    this.each((el) => el.setAttribute(attr, val));
                    return;
                }
            }
            this.attrObj(attr);
        }
        removeAttr(attr) {
            this.each((el) => {
                el.removeAttribute(attr);
            });
        }
        val(val) {
            const item = this.get(0);
            if (item.value === undefined) {
                return null;
            }
            if (val === undefined) {
                return item.value;
            }
            item.value = val;
            return val;
        }
        html(val) {
            const item = this.get(0);
            if (!item) {
                return null;
            }
            if (val === undefined) {
                return item.innerHTML;
            }
            this.each((el) => {
                el.innerHTML = val;
            });
            return val;
        }
        text(val) {
            const item = this.get(0);
            if (!item) {
                return null;
            }
            if (val === undefined) {
                return item.innerText;
            }
            this.each((el) => {
                el.innerText = val;
            });
            return val;
        }
        remove() {
            this.each((el) => {
                el.parentNode.removeChild(el);
            });
        }
        insertAdjacent(where, item) {
            this.each((el) => {
                if (typeof item === "string") {
                    return el.insertAdjacentHTML(where, item);
                }
                el.insertAdjacentElement(where, item);
            });
            return this;
        }
        parent() {
            return this.el(this.get(0).parentElement);
        }
        parentWalker(parents) {
            let p;
            if (parents.length == 0) {
                p = this.parent().get(0);
            }
            else {
                p = parents[parents.length - 1].parentElement;
            }
            if (p == null || p.nodeName == "HTML") {
                return parents;
            }
            else {
                parents.push(p);
                return this.parentWalker(parents);
            }
        }
        parents(query = "") {
            let parents = this.parentWalker([]);
            if (query != "") {
                const match = Array.from(document.querySelectorAll(query));
                parents = parents.filter((v) => match.includes(v));
            }
            return new DOM(parents);
        }
        before(item) {
            this.insertAdjacent("beforebegin", item);
        }
        after(item) {
            this.insertAdjacent("afterend", item);
        }
        append(item) {
            this.each((el) => {
                if (typeof item === "string") {
                    return el.insertAdjacentHTML("beforeend", item);
                }
                el.appendChild(item);
            });
            return this;
        }
        prepend(item) {
            this.each((el) => {
                if (typeof item === "string") {
                    return el.insertAdjacentHTML("afterbegin", item);
                }
                el.insertBefore(item, el.firstChild);
            });
            return this;
        }
        hasClass(str) {
            let result = false;
            this.each((el) => {
                result = _hasClass(el, str);
            });
            return result;
        }
        addClass(str) {
            this.each((el) => {
                const state = _hasClass(el, str);
                if (!state) {
                    el.className += ` ${str}`;
                }
            });
            return this;
        }
        removeClass(str) {
            this.each((el) => {
                const state = _hasClass(el, str);
                if (state) {
                    const reg = new RegExp(`(\\s|^)${str}(\\s|$)`);
                    const val = el.className.replace(reg, " ").trim();
                    el.className = val.replace(/\s{2,}/g, " ");
                }
            });
            return this;
        }
        toggleClass(str) {
            if (this.hasClass(str)) {
                this.removeClass(str);
            }
            else {
                this.addClass(str);
            }
            return this;
        }
        unbind(ev) {
            this.each((el) => {
                if (typeof window.domEvents !== "undefined") {
                    const events = window.domEvents.get(el);
                    if (!!events) {
                        events.find(ev).forEach((v) => {
                            el.removeEventListener(ev, v.handler, true);
                        });
                        events.remove(ev);
                    }
                }
            });
            return this;
        }
        on(ev, op1, op2) {
            const direct = typeof op1 === "function" && op2 === undefined;
            const delegate = typeof op1 === "string" && typeof op2 === "function";
            this.each((el) => {
                let cb;
                const events = window.domEvents.get(el) || new IEvents();
                if (direct) {
                    cb = this.directEvent(op1);
                }
                if (delegate) {
                    cb = this.delegateEvent(el, op1, op2);
                }
                if (cb) {
                    el.addEventListener(ev, cb, true);
                    events.add({ type: ev, handler: cb });
                    window.domEvents.set(el, events);
                }
                else {
                    throw new Error("DOM.on: Invalid Arguments");
                }
            });
            return this;
        }
        click(cb) {
            this.on("click", cb);
        }
        submit(cb) {
            this.on("submit", cb);
        }
        trigger(eventName) {
            const event = document.createEvent("Event");
            event.initEvent(eventName);
            this.each((el) => el.dispatchEvent(event));
        }
        serializeArray() {
            const fields = this.find("[name]", this.get(0));
            const values = [];
            fields.each((el) => {
                const _el = this.el(el);
                values.push({ name: _el.attr("name"), value: _el.val() });
            });
            return values;
        }
        serializeObj() {
            const fields = this.serializeArray();
            return fields.reduce((acc, v) => {
                acc[v.name] = v.value;
                return acc;
            }, {});
        }
        serialize() {
            return this.serializeArray()
                .map((v) => `${v.name}=${v.value}`)
                .join("&");
        }
        directEvent(cb) {
            return (ev) => {
                const el = ev.currentTarget;
                cb.apply(el, [ev]);
            };
        }
        delegateEvent(scope, query, cb) {
            return (ev) => {
                const elements = new DOM(query, scope);
                let el = null;
                let hit = false;
                elements.each((_el) => {
                    let test = ev.target;
                    if (test === _el) {
                        hit = true;
                        el = test;
                        return;
                    }
                    while (test && test !== scope) {
                        test = test.parentNode;
                        if (test === _el) {
                            hit = true;
                            el = test;
                        }
                    }
                });
                if (hit) {
                    cb.apply(el, [ev]);
                }
            };
        }
    }
    sMedia.DOM = DOM;
    class IEvents {
        constructor() {
            this.list = [];
        }
        find(ev) {
            const { list } = this;
            return list.filter((_ev) => _ev.type === ev);
        }
        add(ev) {
            this.list.push(ev);
        }
        remove(ev) {
            const { list } = this;
            this.list = list.filter((_ev) => _ev.type !== ev);
        }
    }
    sMedia.IEvents = IEvents;
    const _hasClass = function (el, str) {
        let result = false;
        const value = ` ${str} `;
        const clean = ` ${el.className} `.replace(/[\n\t]/g, " ");
        if (clean.indexOf(value) > -1) {
            result = true;
        }
        return result;
    };
    sMedia.dom = new DOM();
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class Trackers {
        constructor(analytics_tracking_id = null, fb_pixel_id = null, user_unique_id = null) {
            this.analytics_init_list = [];
            this.fbq_init_list = [];
            this.analytics_tracker_name = "smedia_analytics_tracker";
            this.analytics_tracking_id = analytics_tracking_id;
            this.fb_pixel_id = fb_pixel_id;
            this.user_unique_id = user_unique_id;
            this.listenEventAndSendGa4();
        }
        ga_init() {
            if (!this.analytics_tracking_id) {
                return false;
            }
            if (this.analytics_init_list.includes(this.analytics_tracking_id)) {
                return true;
            }
            if (typeof ga !== "function") {
                (function (i, s, o, g, r, a, m) {
                    i["GoogleAnalyticsObject"] = r;
                    (i[r] =
                        i[r] ||
                            function () {
                                (i[r].q = i[r].q || []).push(arguments);
                            }),
                        (i[r].l = Date.now());
                    (a = s.createElement(o)),
                        (m = s.getElementsByTagName(o)[0]);
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m);
                })(window, document, "script", `//www.google-analytics.com/analytics.js`, "ga");
            }
            const id_len = this.analytics_init_list.length;
            if (id_len) {
                this.analytics_tracker_name = `smedia_analytics_tracker_${id_len}`;
            }
            ga("create", this.analytics_tracking_id, "auto", this.analytics_tracker_name);
            ga(`${this.analytics_tracker_name}.set`, "dimension2", this.user_unique_id);
            this.analytics_inited = true;
            this.analytics_init_list.push(this.analytics_tracking_id);
            return this.analytics_inited;
        }
        fb_init() {
            if (!this.fb_pixel_id) {
                return false;
            }
            if (this.fbq_init_list.includes(this.fb_pixel_id)) {
                return true;
            }
            (function (f, b, e, v, n, t, s) {
                if (f.fbq) {
                    return;
                }
                n = f.fbq = function () {
                    n.callMethod
                        ? n.callMethod.apply(n, arguments)
                        : n.queue.push(arguments);
                };
                if (!f._fbq) {
                    f._fbq = n;
                }
                n.push = n;
                n.loaded = !0;
                n.version = "2.0";
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s);
            })(window, document, "script", `//connect.facebook.net/en_US/fbevents.js`);
            window.fbq("init", this.fb_pixel_id);
            this.fbq_inited = true;
            this.fbq_init_list.push(this.fb_pixel_id);
            return this.fbq_inited;
        }
        sendGa4(event) {
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({ event });
        }
        listenEventAndSendGa4() {
            sMedia.GA4_EVENTS.forEach((ev) => {
                console.log("adding ga4 event listener", ev);
                document.addEventListener(ev.listen, () => {
                    this.sendGa4(ev.ga4);
                    console.log("pushing ga4 event", ev);
                });
            });
        }
        sendGa(install_analytics = true, eventType = "event", event, delay = 0) {
            let action;
            if (!install_analytics) {
                if (typeof ga == "function") {
                    action = () => ga("send", "event", event.category, event.action, event.label, { nonInteraction: event.nonInteraction });
                }
                else {
                    action = () => console.log("No analytics installed");
                }
            }
            else {
                action = () => this.ga_sm(eventType, event.category, event.action, event.label, event.nonInteraction);
            }
            setTimeout(action, delay);
        }
        ga_sm(event, category = "", action = "", label = "", nonInteraction = false, after = 0) {
            if (this.ga_init()) {
                const m_after = after * 1000;
                const trackerBaseName = "smedia_analytics_tracker";
                const trackerCount = sMedia.Context.DomainConfig.single_tag_config
                    .analytics
                    ? sMedia.Context.DomainConfig.single_tag_config.analytics.length
                    : 0;
                setTimeout(() => {
                    ga(`${this.analytics_tracker_name}.send`, event, category, action, label, { nonInteraction });
                    if (trackerCount > 1) {
                        for (let p = 1; p < trackerCount; p++) {
                            const trackerName = `${trackerBaseName}_${p}`;
                            ga(`${trackerName}.send`, event, category, action, label, { nonInteraction });
                        }
                    }
                }, m_after);
            }
        }
        fbq_sm(event, trackingCategory = "track", pixel_id, parameters = null, after = 0) {
            if (this.fb_init()) {
                const m_after = after * 1000;
                setTimeout(() => {
                    console.log(`sMedia: Tracking fbq('${trackingCategory}', '${event}')`);
                    if (parameters) {
                        window.fbq(trackingCategory, pixel_id, event, parameters);
                    }
                    else {
                        window.fbq(trackingCategory, pixel_id, event);
                    }
                }, m_after);
            }
        }
    }
    sMedia.Trackers = Trackers;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class TagStatus {
        constructor() {
            this.errors = [];
            const that = this;
            window.smedia_tag_status = () => that.smediaTagStatus();
        }
        smediaTagStatus() {
            if (!!sMedia.Context) {
                return {
                    errors: this.errors,
                    dealership: this.dealership,
                    service: this.service,
                    trackers: this.trackers,
                    pageType: this.pageType,
                    carData: this.carData,
                };
            }
            else {
                return {
                    err: "sMedia: Tag not found",
                };
            }
        }
        setError(error) {
            this.errors.push(error);
        }
        setDomainConfig(DC) {
            const dealerInfo = DC.dealer_info || {};
            const CC = DC.cron_config || {};
            const SC = DC.scrapper_config || {};
            const PT = sMedia.Context.PageType;
            const STI = DC.single_tag_config;
            this.dealership = {
                status: dealerInfo.status,
                name: dealerInfo.company_name,
                cron_name: DC.cron,
                domain: DC.domain,
                scrapperType: dealerInfo.scrapper_type,
            };
            this.trackers = {
                analytic: {
                    id: (!!STI.analytics) ? this.getAccountIds(STI.analytics) : [],
                },
                pixel: {
                    id: (!!STI.facebook) ? this.getAccountIds(STI.facebook) : [],
                },
                bing: {
                    id: (!!STI.bing) ? this.getAccountIds(STI.bing) : [],
                },
                google: {
                    id: dealerInfo.google_account_id,
                },
                fbPage: {
                    id: dealerInfo.fb_page_id,
                },
                snapchatPixel: {
                    id: (!!STI.snapchat) ? this.getAccountIds(STI.snapchat) : [],
                },
            };
            this.service = {
                smartOffer: {
                    live: (CC.lead || {}).live,
                    bgFileUrl: ((this.service || {}).smartOffer || {}).bgFileUrl || null,
                },
                aiButton: {
                    live: dealerInfo.buttons_live == "1",
                },
                aiForm: {
                    live: dealerInfo.form_live == "1",
                },
                tradesmart: {
                    status: dealerInfo.tradesmart,
                    dealerId: dealerInfo.tradesmart_dealer_id,
                },
                smarBanner: {
                    status: (CC.smart_banner || {}).live || false
                },
                jscrawler: {
                    status: ((PT == 'vdp') && SC.vdp_url_regex && SC.client_scrapping) ? true : false
                },
                vinnauto: {
                    status: ((PT == 'vdp') && (CC.vinnauto.button_status)),
                },
                directmail: {
                    status: CC.mail_retargeting && CC.mail_retargeting.enabled
                }
            };
        }
        setPageData(PD) {
            this.pageType = PD.page_type;
            const CD = PD.car_data || {};
            this.carData = {
                stockType: CD.stock_type || "",
                stockNumber: CD.stock_number || "",
                vin: CD.vin || "",
                svin: CD.svin || "",
                year: CD.year || "",
                make: CD.make || "",
                model: CD.model || "",
                trim: CD.trim || "",
                price: CD.price || "",
                msrp: CD.msrp || "",
                kilometers: CD.kilometers || CD.kilometres || "",
                bodyStyle: CD.body_style || "",
                engine: CD.engine || "",
                transmission: CD.transmission || "",
                vdpUrl: CD.url || window.location.href.split('#')[0],
            };
            this.service.smartOffer.bgFileUrl = PD.smart_offer_image_url;
        }
        getAccountIds(trackerSets) {
            const out = [];
            trackerSets.forEach(trackerObject => {
                if (trackerObject.account_id.length > 0) {
                    out.push(trackerObject.account_id);
                }
            });
            return out;
        }
    }
    sMedia.TagStatus = TagStatus;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    const script_path = `https://events.smedia.ca`;
    const current_url = window.location.href;
    const urlHash = window.location.hash;
    let queryString = window.location.search;
    if (queryString == '' && urlHash != '' && urlHash.includes('?')) {
        queryString = urlHash.substring(urlHash.indexOf('?'));
    }
    const urlParams = new URLSearchParams(queryString);
    const debugFlags = {
        tagDebug: urlParams.get("tag_debug") === "true",
        smediaDebug: urlParams.get("smedia_debug") === "true",
        softDebug: urlParams.get("smedia_debug_partial") === "true",
        smartOffer: urlParams.get("smart_offer_debug") === "true",
        smartProfiler: urlParams.get("smart_profiler_debug") === "true",
        aiButtonDebug: urlParams.get("button_debug") === "true",
        aiFormDebug: urlParams.get("form_debug") === "true",
        poweredbyDebug: urlParams.get("poweredby_debug") === "true",
        smartBannerDdebug: urlParams.get("smartbanner_debug") === "true",
        mailRetargeting: urlParams.get("directmail_debug") === "true",
    };
    const hFunc = new sMedia.SHA256();
    const browser = new sMedia.Browser(hFunc);
    const httpCom = new sMedia.HttpCom(`${script_path}/events`, new sMedia.Ajax());
    const eventTracker = new sMedia.EventTracker(httpCom, 10, 500);
    const logService = new sMedia.LogService("sMedia", debugFlags.smediaDebug || debugFlags.softDebug);
    const domainConfigKey = "domain_config";
    const pageDataKey = `page_data_${hFunc.Hash(browser.url)}`;
    const context = sMedia.Context || new sMedia.Application(hFunc, browser, new sMedia.UniquePathGenerator(), eventTracker, logService);
    sMedia.apiHost = `https://tm.smedia.ca`;
    sMedia.Context = context;
    const initApp = () => {
        browser.prepareBrowserIds(() => {
            if (debugFlags.smediaDebug) {
                sMedia.LocalStorage.clearAll();
                logService.Debug(`sMedia : Clearing local storage.`);
            }
            if (debugFlags.softDebug) {
                sMedia.LocalStorage.clear(domainConfigKey);
                logService.Debug(`sMedia : Clearing domain config.`);
                sMedia.LocalStorage.clear(pageDataKey);
                logService.Debug(`sMedia : Clearing page data.`);
            }
            let domainConfig = sMedia.LocalStorage.get(domainConfigKey);
            if (domainConfig && (domainConfig.cron_config || {}).tag_debug == true) {
                sMedia.LocalStorage.clear(domainConfigKey);
                domainConfig = null;
            }
            let pageData = sMedia.LocalStorage.get(pageDataKey);
            const debugParam = sMedia.OrAllMembers(debugFlags) ? "&smedia_debug=true" : "";
            const parser = new URL(current_url);
            const host = parser.host;
            if (!domainConfig) {
                domainConfig = {};
                const apiServer = window.apiServer || 'api';
                const domainConfigApi = (debugParam == "")
                    ? `${sMedia.apiHost}/tag_api/dealer_data-${host}.json`
                    : `${sMedia.apiHost}/APIs/v1/dealerDataPartial.php?url=${encodeURIComponent(sMedia.smediaUrlEncrypt(host))}${debugParam}&server=${apiServer}`;
                logService.Debug(`sMedia : Requesting domain configuration from '${domainConfigApi}'`);
                new sMedia.Ajax().Get(domainConfigApi, (response) => {
                    if (response.success == true) {
                        const DC = response.data;
                        const tagDebug = (DC.cron_config || {}).tag_debug;
                        if (!tagDebug || debugFlags.smediaDebug == true) {
                            domainConfig = DC;
                            if (!tagDebug) {
                                sMedia.LocalStorage.set(domainConfigKey, domainConfig, sMedia.SECONDS_IN_A_DAY);
                            }
                            if (domainConfig.multi_dealer) {
                                const thisPageUrl = `${window.location.origin}${window.location.pathname}`;
                                const urlResolve = domainConfig.scrapper_config.url_resolve;
                                for (const syntheticDealer in urlResolve) {
                                    const urlRegex = urlResolve[syntheticDealer];
                                    const useRegex = new RegExp(urlRegex.substring(urlRegex.indexOf("/") + 1, urlRegex.lastIndexOf("/")));
                                    if (useRegex.test(thisPageUrl)) {
                                        domainConfig.cron = syntheticDealer;
                                        domainConfig.single_tag_config = domainConfig.multi_tag_config[syntheticDealer];
                                        sMedia.LocalStorage.set(domainConfigKey, domainConfig, sMedia.SECONDS_IN_A_DAY);
                                        break;
                                    }
                                }
                                sMedia.LocalStorage.clear(pageDataKey);
                            }
                        }
                        else {
                            sMedia.LocalStorage.clear(domainConfigKey);
                            debugFlags.tagDebug = true;
                        }
                    }
                    else {
                        sMedia.Context.TagStatus.setError(response.message || "Unknown error");
                    }
                });
            }
            if (!pageData) {
                pageData = {};
                const pageDataApi = (debugParam == "")
                    ? `${sMedia.apiHost}/tag_api/${host}/page_data-${btoa(window.location.href).replace("/", "--SLASH--").replace("+", "--PLUS--")}.json`
                    : `${sMedia.apiHost}/APIs/v1/pageDataFull.php?url=${encodeURIComponent(sMedia.smediaUrlEncrypt(window.location.href))}${debugParam}`;
                logService.Debug(`sMedia : Requesting page data from '${pageDataApi}'`);
                new sMedia.Ajax().Get(pageDataApi, (response) => {
                    if (response.success == true) {
                        pageData = response.data;
                        sMedia.LocalStorage.set(pageDataKey, pageData, sMedia.SECONDS_IN_A_DAY);
                    }
                    else {
                        sMedia.Context.TagStatus.setError(response.message || "Unknown error");
                    }
                });
            }
            let pageType = null;
            const wait = setInterval(() => {
                if (debugFlags.tagDebug === true) {
                    clearInterval(wait);
                    console.log("sMedia: tag is in debug mode.");
                }
                else if (!!domainConfig &&
                    !sMedia.isEmptyObject(domainConfig) &&
                    !!pageData &&
                    !sMedia.isEmptyObject(pageData)) {
                    clearInterval(wait);
                    if (pageData.page_type) {
                        pageType = pageData.page_type;
                    }
                    if (pageType == "vdp" && !pageData.car_data) {
                        pageData.car_data = sMedia.generateCarData(domainConfig.scrapper_config.data_capture_regx_full, document.documentElement.innerHTML);
                        sMedia.LocalStorage.set(pageDataKey, pageData, sMedia.SECONDS_IN_A_DAY);
                    }
                    sMedia.Context.ApplicationReady(domainConfig.cron, domainConfig, pageType, pageData, debugFlags);
                }
            }, 100);
        });
    };
    initApp();
    browser.onUrlChange(() => {
        sMedia.Context.Close();
        setTimeout(() => initApp(), 2000);
    });
    window.onbeforeunload = () => {
        sMedia.Context.Close();
    };
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class AdditionalScripts {
        Register() {
            const dealer = sMedia.Context.DomainConfig.cron;
            const STC = sMedia.Context.DomainConfig.single_tag_config;
            const PT = sMedia.Context.PageType;
            if (!STC.additional || !STC.additional[0].config[PT]) {
                console.log(`sMedia: No additional script found for '${dealer}' for page type ${PT}.`);
                return;
            }
            const sm_add_scripts = STC.additional[0].config[PT].additional_scripts;
            console.log(`sMedia: Adding ${sm_add_scripts.length} additional script(s) for '${dealer}' for page type ${PT}.`);
            sm_add_scripts.forEach((element) => {
                if (!sMedia.isEmptyString(element)) {
                    sMedia.DomInstaller.InstallScript(element);
                }
            });
        }
        Unregister() {
        }
    }
    sMedia.additionalScripts = new AdditionalScripts();
    sMedia.Context.OnReady(() => {
        sMedia.additionalScripts.Register();
    });
    sMedia.Context.OnClose(() => {
        sMedia.additionalScripts.Unregister();
    });
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class ButtonClickTracker {
        Register() {
            document.addEventListener("click", this.OnClick, true);
        }
        Unregister() { }
        OnClick(e) {
            const xpath = (e.path || []).length
                ? sMedia.Context.PathGenerator.GetPath(e.path[0])
                : null;
            const area = e.target.getBoundingClientRect();
            const tag = e.target.tagName;
            const tagType = e.target.type;
            let text = "";
            const coordX = e.pageX;
            const coordY = e.pageY;
            const acceptedTags = ["BUTTON", "INPUT", "A"];
            if (!acceptedTags.some((a) => { return a == tag; })) {
                return;
            }
            const includeType = ["button", "submit"];
            const found = includeType.indexOf(tagType);
            if (tag === "INPUT" && found === -1) {
                return;
            }
            else if (tag === "A") {
                text = e.target.innerHTML;
            }
            else {
                text = e.target.value;
            }
            sMedia.Context.EventTracker.Record("MouseEvent", "ButtonClick", 1, {
                X: coordX,
                Y: coordY,
                Element: xpath,
                Area: area,
                Tag: tag,
                Text: text,
            });
        }
    }
    sMedia.buttonClickTracker = new ButtonClickTracker();
    sMedia.Context.OnReady(() => {
        sMedia.buttonClickTracker.Register();
    });
    sMedia.Context.OnReady(() => {
        sMedia.buttonClickTracker.Unregister();
    });
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Tracker;
    (function (Tracker) {
        class ClickTracker {
            Register() {
                document.addEventListener("click", this.OnClick);
            }
            Unregister() {
                document.removeEventListener("click", this.OnClick);
            }
            OnClick(e) {
                const xpath = (e.path || []).length
                    ? sMedia.Context.PathGenerator.GetPath(e.path[0])
                    : null;
                const area = e.target.getBoundingClientRect();
                const tag = e.target.tagName;
                const coordX = e.pageX;
                const coordY = e.pageY;
                sMedia.Context.EventTracker.Record("MouseEvent", "Click", 1, {
                    'X': coordX,
                    'Y': coordY,
                    'Element': xpath,
                    'Area': area,
                    'Tag': tag
                });
            }
        }
        Tracker.clickTracker = new ClickTracker();
        sMedia.Context.OnReady(() => {
            Tracker.clickTracker.Register();
        });
        sMedia.Context.OnClose(() => {
            Tracker.clickTracker.Unregister();
        });
    })(Tracker = sMedia.Tracker || (sMedia.Tracker = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Tracker;
    (function (Tracker) {
        class HoverTracker {
            Register() {
                document.onmouseover = this.MouseEnter;
                document.onmouseout = this.MouseLeave;
            }
            Unregister() { }
            MouseEnter(e) {
                const path = (e.path || [])[0] || null;
                if (path == this.LastElement) {
                    return;
                }
                this.LastElement = path;
                this.TimeStamp = sMedia.Time.MillisecondsNow();
            }
            MouseLeave(e) {
                const path = (e.path || [])[0] || null;
                const xpath = sMedia.Context.PathGenerator.GetPath(path);
                const elapsed = sMedia.Time.MillisecondsNow() - this.TimeStamp;
                const area = e.target.getBoundingClientRect();
                const tag = e.target.tagName;
                if (elapsed > 500 && tag != "HTML") {
                    sMedia.Context.EventTracker.Record("MouseEvent", "Hover", elapsed, {
                        'Element': xpath,
                        'Duration': elapsed,
                        'Area': area,
                        'Tag': tag
                    });
                }
            }
        }
        Tracker.hoverTracker = new HoverTracker();
        sMedia.Context.OnReady(() => {
            Tracker.hoverTracker.Register();
        });
        sMedia.Context.OnReady(() => {
            Tracker.hoverTracker.Unregister();
        });
    })(Tracker = sMedia.Tracker || (sMedia.Tracker = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Tracker;
    (function (Tracker) {
        class PageTimeTracker {
            Register() {
                this.EventId = null;
                this.Timer = new sMedia.Timer(t => {
                    const TimeOnPage = (sMedia.Time.MillisecondsNow() - sMedia.Context.Browser.timestamp);
                    sMedia.Context.EventTracker.Record("Page", "TimeOnPage", TimeOnPage, {
                        TimeOnPage: TimeOnPage
                    }, null, id => {
                        this.EventId = id;
                    }, this.EventId);
                }, 5000);
                this.Timer.Start();
            }
            Unregister() {
                this.Timer.Stop();
            }
        }
        Tracker.pageTimeTracker = new PageTimeTracker();
        sMedia.Context.OnReady(() => {
            Tracker.pageTimeTracker.Register();
        });
        sMedia.Context.OnClose(() => {
            Tracker.pageTimeTracker.Unregister();
        });
    })(Tracker = sMedia.Tracker || (sMedia.Tracker = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Tracker;
    (function (Tracker) {
        class PictureViewTracker {
            Register() {
                this.firstImageClicked = false;
                this.currentImage = 1;
                this.maxImages = 0;
                const SC = (sMedia.Context.DomainConfig || {}).scrapper_config;
                if (sMedia.Context.PageType == "vdp" && (SC.picture_selectors || []).length) {
                    this.smediaPictureTracking(SC.picture_selectors);
                    if ((SC.picture_nexts || []).length) {
                        this.smediaNextPictureTracking(SC.picture_nexts);
                    }
                    if ((SC.picture_prevs || []).length) {
                        this.smediaPrevPictureTracking(SC.picture_prevs);
                    }
                }
            }
            smediaPictureTracking(selectors) {
                if (!Array.isArray(selectors)) {
                    selectors = [selectors];
                }
                console.log("sMedia : Picture tracking");
                selectors.forEach((elm) => {
                    this.bindForImageTrackingCheck(elm, 0);
                });
            }
            smediaNextPictureTracking(selectors) {
                if (!Array.isArray(selectors)) {
                    selectors = [selectors];
                }
                console.log("sMedia : Next Picture tracking");
                selectors.forEach((elm) => {
                    this.bindForNextImageTrackingCheck(elm, 0);
                });
            }
            smediaPrevPictureTracking(selectors) {
                if (!Array.isArray(selectors)) {
                    selectors = [selectors];
                }
                console.log("sMedia : Prev Picture tracking");
                selectors.forEach((elm) => {
                    this.bindForPrevImageTrackingCheck(elm, 0);
                });
            }
            bindForImageTrackingCheck(identifier, loopCount) {
                if (sMedia.dom.find(identifier).length) {
                    this.bindForImageTracking(identifier);
                }
                else {
                    if (loopCount++ == 10) {
                        return;
                    }
                    const that = this;
                    setTimeout(() => that.bindForImageTrackingCheck(identifier, loopCount), 3000);
                }
            }
            bindForNextImageTrackingCheck(identifier, loopCount) {
                if (sMedia.dom.find(identifier).length) {
                    this.bindForNextImageTracking(identifier);
                }
                else {
                    const that = this;
                    if (loopCount++ == 10) {
                        return;
                    }
                    setTimeout(() => that.bindForNextImageTrackingCheck(identifier, loopCount), 3000);
                }
            }
            bindForPrevImageTrackingCheck(identifier, loopCount) {
                if (sMedia.dom.find(identifier).length) {
                    this.bindForPrevImageTracking(identifier);
                }
                else {
                    const that = this;
                    if (loopCount++ == 10) {
                        return;
                    }
                    setTimeout(() => that.bindForPrevImageTrackingCheck(identifier, loopCount), 3000);
                }
            }
            bindForImageTracking(identifier) {
                const images = sMedia.dom.find(identifier);
                if (images.length) {
                    this.maxImages = images.get(0).parentElement.children.length;
                }
                const that = this;
                images.click(function () {
                    console.log("sMedia : Call bindForImageTracking Function");
                    const i = images.index(this);
                    that.currentImage = i + 1;
                    const ith = sMedia.getIndexed(that.currentImage);
                    if (!that.firstImageClicked) {
                        sMedia.Context.EventTracker.Record("Picture Engagement", `${ith} Picture engagement`, 1, {
                            currentImage: that.currentImage,
                            url: !!(this.src) ? this.src : "",
                        });
                        if (typeof ga == "function") {
                            ga("smedia_analytics_tracker.send", {
                                hitType: "event",
                                eventCategory: "Picture engagement",
                                eventAction: `${ith} Picture engagement`,
                                nonInteraction: true,
                            });
                            const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
                                sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
                            if (trackerCount > 1) {
                                const trackerBaseName = 'smedia_analytics_tracker';
                                for (let p = 1; p < trackerCount; p++) {
                                    const trackerName = `${trackerBaseName}_${p}`;
                                    ga(`${trackerName}.send`, {
                                        hitType: "event",
                                        eventCategory: "Picture engagement",
                                        eventAction: `${ith} Picture engagement`,
                                        nonInteraction: true,
                                    });
                                }
                            }
                        }
                        console.log(`sMedia : ${ith} Picture engagement | Selector | ${identifier}`);
                        that.firstImageClicked = true;
                    }
                    if (typeof ga == "function") {
                        ga("smedia_analytics_tracker.send", {
                            hitType: "event",
                            eventCategory: "Picture Viewed",
                            eventAction: `${ith} Picture Viewed`,
                            nonInteraction: true,
                        });
                        const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
                            sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
                        if (trackerCount > 1) {
                            const trackerBaseName = 'smedia_analytics_tracker';
                            for (let p = 1; p < trackerCount; p++) {
                                const trackerName = `${trackerBaseName}_${p}`;
                                ga(`${trackerName}.send`, {
                                    hitType: "event",
                                    eventCategory: "Picture Viewed",
                                    eventAction: `${ith} Picture Viewed`,
                                    nonInteraction: true,
                                });
                            }
                        }
                    }
                    console.log(`sMedia : ${ith} image clicked | Selector | ${identifier}`);
                });
            }
            bindForNextImageTracking(identifier) {
                const that = this;
                sMedia.dom.find(identifier).click(function () {
                    console.log("sMedia : Call bindForNextImageTracking Function");
                    that.currentImage++;
                    if (that.currentImage > that.maxImages) {
                        that.currentImage = 1;
                    }
                    const ith = sMedia.getIndexed(that.currentImage);
                    if (!that.firstImageClicked) {
                        if (typeof ga == "function") {
                            ga("smedia_analytics_tracker.send", {
                                hitType: "event",
                                eventCategory: "Picture engagement",
                                eventAction: `${ith} Picture engagement`,
                                nonInteraction: true,
                            });
                            const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
                                sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
                            if (trackerCount > 1) {
                                const trackerBaseName = 'smedia_analytics_tracker';
                                for (let p = 1; p < trackerCount; p++) {
                                    const trackerName = `${trackerBaseName}_${p}`;
                                    ga(`${trackerName}.send`, {
                                        hitType: "event",
                                        eventCategory: "Picture engagement",
                                        eventAction: `${ith} Picture engagement`,
                                        nonInteraction: true,
                                    });
                                }
                            }
                        }
                        console.log(`${ith} Picture engagement | Next | ${identifier}`);
                        that.firstImageClicked = true;
                    }
                    if (typeof ga == "function") {
                        ga("smedia_analytics_tracker.send", {
                            hitType: "event",
                            eventCategory: "Picture Viewed",
                            eventAction: `${ith} Picture Viewed`,
                            nonInteraction: true,
                        });
                        const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
                            sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
                        if (trackerCount > 1) {
                            const trackerBaseName = 'smedia_analytics_tracker';
                            for (let p = 1; p < trackerCount; p++) {
                                const trackerName = `${trackerBaseName}_${p}`;
                                ga(`${trackerName}.send`, {
                                    hitType: "event",
                                    eventCategory: "Picture Viewed",
                                    eventAction: `${ith} Picture Viewed`,
                                    nonInteraction: true,
                                });
                            }
                        }
                    }
                    console.log(`sMedia : ${ith} image clicked | next | ${identifier}`);
                });
            }
            bindForPrevImageTracking(identifier) {
                const that = this;
                sMedia.dom.find(identifier).click(function () {
                    console.log("sMedia : Call bindForPrevImageTracking Function");
                    that.currentImage--;
                    if (that.currentImage < 1) {
                        that.currentImage = that.maxImages;
                    }
                    const ith = sMedia.getIndexed(that.currentImage);
                    if (!that.firstImageClicked) {
                        if (typeof ga == "function") {
                            ga("smedia_analytics_tracker.send", {
                                hitType: "event",
                                eventCategory: "Picture engagement",
                                eventAction: `${ith} Picture engagement`,
                                nonInteraction: true,
                            });
                            const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
                                sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
                            if (trackerCount > 1) {
                                const trackerBaseName = 'smedia_analytics_tracker';
                                for (let p = 1; p < trackerCount; p++) {
                                    const trackerName = `${trackerBaseName}_${p}`;
                                    ga(`${trackerName}.send`, {
                                        hitType: "event",
                                        eventCategory: "Picture engagement",
                                        eventAction: `${ith} Picture engagement`,
                                        nonInteraction: true,
                                    });
                                }
                            }
                        }
                        console.log(`sMedia : ${ith} Picture engagement | Prev | ${identifier}`);
                        that.firstImageClicked = true;
                    }
                    if (typeof ga == "function") {
                        ga("smedia_analytics_tracker.send", {
                            hitType: "event",
                            eventCategory: "Picture Viewed",
                            eventAction: `${ith} Picture Viewed`,
                            nonInteraction: true,
                        });
                        const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
                            sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
                        if (trackerCount > 1) {
                            const trackerBaseName = 'smedia_analytics_tracker';
                            for (let p = 1; p < trackerCount; p++) {
                                const trackerName = `${trackerBaseName}_${p}`;
                                ga(`${trackerName}.send`, {
                                    hitType: "event",
                                    eventCategory: "Picture Viewed",
                                    eventAction: `${ith} Picture Viewed`,
                                    nonInteraction: true,
                                });
                            }
                        }
                    }
                    console.log(`sMedia : ${ith} image clicked | Prev | ${identifier}`);
                });
            }
            Unregister() { }
        }
        Tracker.pictureViewTracker = new PictureViewTracker();
        sMedia.Context.OnReady(() => {
            Tracker.pictureViewTracker.Register();
        });
        sMedia.Context.OnClose(() => {
            Tracker.pictureViewTracker.Unregister();
        });
    })(Tracker = sMedia.Tracker || (sMedia.Tracker = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Tracker;
    (function (Tracker) {
        class RetargettingConversionTracker {
            Register() {
                const DC = sMedia.Context.DomainConfig;
                const CD = sMedia.Context.PageData.car_data;
                let data;
                if (CD && DC) {
                    const hugeUrl = `${sMedia.apiHost}/APIs/v1/conversionTrackerData.php?dealership=${DC.cron}&make=${CD.make}&model=${CD.model}&year=${CD.year}`;
                    new sMedia.Ajax().Get(hugeUrl, (res) => {
                        if (res.success === true) {
                            data = res.data;
                        }
                        else {
                            data = null;
                        }
                    }, () => (data = null));
                    const wait = setInterval(() => {
                        if (typeof data !== "undefined") {
                            clearInterval(wait);
                            if (data && data.conversionId) {
                                const frameUrl = `//tm.smedia.ca/tm-tracker-iframe.php?stock_number=${CD.stock_number}&id=${data.conversionId}&label=${data.conversionLabel}&pa_id=${DC.cron_config.perfect_audience_id}&cron_name=${DC.cron}`;
                                const delay = DC.cron_config.retargetting_delay || 1;
                                setTimeout(function () {
                                    sMedia.DomInstaller.InstallIframe(frameUrl);
                                }, delay);
                            }
                        }
                    }, 200);
                }
                else {
                    if (DC) {
                        console.log("sMedia : CAR DATA not found");
                    }
                    else {
                        console.log("sMedia : DOMAIN CONFIG not found");
                    }
                }
            }
            Unregister() { }
        }
        Tracker.rctracker = new RetargettingConversionTracker();
        sMedia.Context.OnReady(() => {
            if (sMedia.Context.PageType === "vdp") {
                Tracker.rctracker.Register();
            }
        });
        sMedia.Context.OnReady(() => {
            if (sMedia.Context.PageType === "vdp") {
                Tracker.rctracker.Unregister();
            }
        });
    })(Tracker = sMedia.Tracker || (sMedia.Tracker = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class ScrollDepthTracker {
        constructor() {
            this.LastScroll = 0;
        }
        Register() {
            document.addEventListener("scroll", e => {
                const body = document.body;
                const html = document.documentElement;
                const scrollHeight = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight) - window.innerHeight;
                const scrollPercentage = scrollHeight > 0 ? Math.round((window.scrollY / scrollHeight) * 100) : 100;
                if (scrollPercentage > this.LastScroll) {
                    const data = {
                        'scrollX': window.scrollX,
                        'scrollY': window.scrollY,
                        'scrollHeight': scrollHeight,
                        'scrollPercentage': scrollPercentage,
                        'window': [window.innerWidth, window.innerHeight]
                    };
                    sMedia.Context.EventTracker.Record('Page', 'ScrollDepth', scrollPercentage, data, null, id => {
                        this.EventId = id;
                    }, this.EventId);
                    this.LastScroll = scrollPercentage;
                }
            });
        }
        Unregister() { }
    }
    sMedia.scrollDepthTracker = new ScrollDepthTracker();
    sMedia.Context.OnReady(() => {
        sMedia.scrollDepthTracker.Register();
    });
    sMedia.Context.OnReady(() => {
        sMedia.scrollDepthTracker.Unregister();
    });
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class AiButton {
        constructor() {
            this.initialized = false;
            this.data = null;
            this.config = null;
            this.buttonDebug = false;
            this.formDebug = false;
            this.poweredbyDebug = false;
            this.poweredby_conf = null;
            this.dealership = null;
            this.disclaimer = null;
            this.busy = false;
            this.pending = [];
            this.algorithm = "default";
            this.urlParser = sMedia.URLParser.current();
            this.regex = new sMedia.RegExpProcessor();
            this.window = new sMedia.ButtonWindow();
        }
        Register() {
            const DC = sMedia.Context.DomainConfig;
            if (DC && DC.ai_button) {
                this.init(DC.ai_button.data, DC.cron_config.buttons, {
                    dealership: DC.cron,
                    button_live: DC.dealer_info.buttons_live &&
                        (DC.dealer_info.buttons_live === "1" ||
                            DC.dealer_info.buttons_live === "1")
                        ? true
                        : false,
                    form_live: DC.dealer_info.form_live &&
                        (DC.dealer_info.form_live === "1" ||
                            DC.dealer_info.form_live === "1")
                        ? true
                        : false,
                    poweredby_live: DC.cron_config.powered_by_live &&
                        DC.cron_config.powered_by_live === true
                        ? true
                        : false,
                    poweredby_conf: {},
                    combinations: DC.ai_button.combinations,
                    algorithm: DC.ai_button.algorithm,
                    disclaimer: DC.cron_config.form_disclaimer,
                    tracker_url: `${sMedia.apiHost}/services/sm-ai-buttons.php`,
                });
                this.show();
            }
        }
        Unregister() { }
        init(data, config, options) {
            const algorithm_index = Math.floor(Math.random() * options.algorithm.length);
            this.algorithm = options.algorithm[algorithm_index];
            this.data = data[this.algorithm];
            this.config = config;
            this.url = this.urlParser.get();
            this.buttonDebug = sMedia.Context.DebugFlags.aiButtonDebug;
            this.formDebug = sMedia.Context.DebugFlags.aiFormDebug;
            this.poweredbyDebug = sMedia.Context.DebugFlags.poweredbyDebug;
            this.button_live = options.button_live;
            this.form_live = options.form_live;
            this.poweredby_live = options.poweredby_live;
            this.poweredby_conf = options.poweredby_conf;
            this.dealership = options.dealership;
            this.disclaimer = options.disclaimer;
            if (typeof options.combinations !== "undefined") {
                this.combinations = options.combinations[this.algorithm];
            }
            this.tracker_url = options.tracker_url;
            this.initialized = true;
        }
        show_baseline() {
            const dice = this.buttonDebug ? 10000 : this.get_random(0, 10000);
            return dice < 1000;
        }
        predict(button) {
            const button_data = this.data[button];
            const retval = {
                location: this.predict_group(button_data.locations),
                size: this.predict_group(button_data.sizes),
                style: this.predict_group(button_data.styles),
                texts: {},
            };
            for (const key in button_data.texts) {
                retval.texts[key] = this.predict_group(button_data.texts[key]);
            }
            return retval;
        }
        predict_ts(btn_name) {
            let highest_probability = -1;
            let candidate_probability = -1;
            let selected = null;
            const button_data = this.data[btn_name];
            for (const comb in button_data) {
                candidate_probability = sMedia.rbeta(button_data[comb].a + 1, button_data[comb].b + 2);
                if (candidate_probability > highest_probability) {
                    highest_probability = candidate_probability;
                    selected = comb;
                }
            }
            return selected;
        }
        predict_sm(btn_name) {
            const button_data = this.data[btn_name];
            const highest_probability = Math.random();
            let cumulative_probability = 0;
            const total_view = button_data.view + 1;
            const temperature = 1 / Math.log(total_view + 0.0000001);
            let selected = null;
            let z = 0;
            for (const comb in button_data.score) {
                z += Math.exp(button_data.score[comb] / temperature);
            }
            for (const comb in button_data.score) {
                cumulative_probability +=
                    Math.exp(button_data.score[comb] / temperature) / z;
                selected = comb;
                if (cumulative_probability > highest_probability) {
                    return selected;
                }
            }
            return selected;
        }
        predict_ucb1(btn_name) {
            const button_data = this.data[btn_name];
            const ucb_score = {};
            for (const comb in button_data.view) {
                if (button_data.view[comb] == 0) {
                    return comb;
                }
                ucb_score[comb] =
                    button_data.score[comb] +
                        Math.sqrt((2 * Math.log(button_data.total_view)) /
                            button_data.view[comb]);
            }
            const ucb_values = Object.keys(ucb_score).map((key) => ucb_score[key]);
            const max = ucb_values.reduce(function (a, b) {
                return Math.max(a, b);
            });
            return Object.keys(ucb_score)[ucb_values.indexOf(max)];
        }
        predict_group(group_data) {
            const sum = this.sum_vals(group_data);
            const factor = this.get_random(0, sum);
            let sel_option = null;
            let cur_sum = 0;
            for (const key in group_data) {
                if (sel_option === null) {
                    sel_option = key;
                }
                cur_sum += group_data[key];
                if (cur_sum >= factor) {
                    sel_option = key;
                    break;
                }
            }
            return sel_option;
        }
        get_random(min, max) {
            return Math.floor(Math.random() * (max - min)) + min;
        }
        get_random_int(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
        sum_vals(group_data) {
            let retval = 0;
            for (const key in group_data) {
                retval += group_data[key];
            }
            return retval;
        }
        show() {
            const that = this;
            for (const key in this.config) {
                const wait = setInterval(() => {
                    if (that.show_button(key)) {
                        clearInterval(wait);
                    }
                }, 1000);
            }
        }
        getButtonCookie(cname) {
            const search = `${cname} = `;
            let returnvalue = "";
            if (document.cookie.length > 0) {
                let offset = document.cookie.indexOf(search);
                if (offset != -1) {
                    offset += search.length;
                    let end = document.cookie.indexOf(";", offset);
                    if (end == -1) {
                        end = document.cookie.length;
                    }
                    returnvalue = unescape(document.cookie.substring(offset, end));
                }
            }
            return returnvalue;
        }
        show_button(btn_name) {
            if (sMedia.dom.find(this.config[btn_name]["action-target"]).length == 0) {
                return false;
            }
            const tester = this.regex.pmake(this.config[btn_name]["url-match"]);
            if (tester.test(this.urlParser.get())) {
                this.bind_events(btn_name);
                let combination = this.algorithm == "default"
                    ? "baseline"
                    : (Object.entries(this.combinations[btn_name]).find((entry) => entry[1] == "baseline") || [])[0];
                let pbtn = null;
                if (!this.show_baseline() &&
                    (this.button_live || this.buttonDebug)) {
                    if (this.algorithm == "default") {
                        pbtn = this.predict(btn_name);
                    }
                    else {
                        if (this.algorithm == "thompson_sampling") {
                            combination = this.predict_ts(btn_name);
                        }
                        else if (this.algorithm == "softmax") {
                            combination = this.predict_sm(btn_name);
                        }
                        else if (this.algorithm == "ucb-1") {
                            combination = this.predict_ucb1(btn_name);
                        }
                        const temp_pbtn = this.combinations[btn_name][combination].slice(1, -1).split("][");
                        pbtn = {
                            location: temp_pbtn[0],
                            size: temp_pbtn[1],
                            style: temp_pbtn[2],
                            texts: { [btn_name]: temp_pbtn[3] },
                        };
                    }
                    this.set_text(btn_name, pbtn);
                    this.set_style(btn_name, pbtn);
                    this.set_size(btn_name, pbtn);
                    this.set_location(btn_name, pbtn);
                    if (this.algorithm == "default") {
                        combination = `${pbtn.location}-${pbtn.style}-${pbtn.size}`;
                        for (const text_key in pbtn.texts) {
                            combination += `-${pbtn.texts[text_key]}`;
                        }
                    }
                }
                else {
                    const actionTarget = sMedia.dom.find(this.config[btn_name]["action-target"]);
                    if (actionTarget) {
                        actionTarget.attr({
                            "smedia-text-key": btn_name.substr(btn_name.indexOf(" ") + 1),
                            "smedia-text-value": actionTarget.text(),
                            "smedia-baseline": "yes",
                        });
                    }
                }
                sMedia.dom.find(this.config[btn_name]["action-target"]).each((el) => {
                    el.setAttribute("smedia-combination", combination);
                });
                sMedia.dom.find(this.config[btn_name]["action-target"]).each((el) => {
                    el.setAttribute("smedia-btn-name", btn_name);
                });
                const params = {
                    dealership: this.dealership,
                    url: this.url,
                    button_name: btn_name,
                    text_key: "",
                    text_value: "",
                    location: pbtn ? pbtn.location : "",
                    style: pbtn ? pbtn.style : "",
                    size: pbtn ? pbtn.size : "",
                    combination: combination,
                    algorithm: this.algorithm,
                    smedia_uuid: this.getButtonCookie("smedia_smart_lead_uuid") ||
                        sMedia.Context.Browser.uniqueUserId,
                };
                if (pbtn) {
                    for (const text_key in pbtn.texts) {
                        params.text_key = text_key;
                        params.text_value = pbtn.texts[text_key];
                    }
                }
                this.track("button_viewed", params);
            }
            return true;
        }
        set_text(btn_name, pbtn) {
            var _a, _b, _c;
            for (const text_key in pbtn.texts) {
                const target = (((this.config[btn_name] || {}).texts || {})[text_key.substr(text_key.indexOf(" ") + 1)] || {}).target;
                const value = pbtn.texts[text_key];
                const targetElement = sMedia.dom.find(target).first();
                if ((targetElement.get(0) || {}).nodeName === "INPUT") {
                    targetElement.val(value);
                }
                else {
                    targetElement.html(value);
                }
                const actionTarget = sMedia.dom.find(this.config[btn_name]["action-target"]);
                actionTarget.attr({
                    "smedia-text-key": text_key,
                    "smedia-text-value": value,
                });
                targetElement.attr({
                    "smedia-text-key": text_key,
                    "smedia-text-value": value,
                });
                const pd = sMedia.Context.PageData;
                const textChangeEvent = new CustomEvent("aibutton.textchange", {
                    detail: {
                        buttonName: btn_name,
                        textKey: text_key,
                        value: value,
                        pageType: pd.page_type,
                        carData: pd.car_data,
                    },
                });
                document.dispatchEvent(textChangeEvent);
                (_c = (_b = (_a = sMedia.Context.GlobalCallbacks) === null || _a === void 0 ? void 0 : _a.aiButton) === null || _b === void 0 ? void 0 : _b.onTextChange) === null || _c === void 0 ? void 0 : _c.forEach((cb) => {
                    typeof cb === "function" &&
                        cb(btn_name, text_key, value);
                });
            }
        }
        set_style(btn_name, pbtn) {
            const option = this.config[btn_name].styles[pbtn.style];
            const style = document.createElement("style");
            style.type = "text/css";
            style.innerHTML = `${this.config[btn_name]["css-class"]} { `;
            for (const css_key in option.normal) {
                style.innerHTML += `${css_key}: ${option.normal[css_key]} !important;`;
            }
            style.innerHTML += `}\n ${this.config[btn_name]["css-hover"]} { `;
            for (const _css_key in option.hover) {
                style.innerHTML += `${_css_key}: ${option.hover[_css_key]} !important;`;
            }
            style.innerHTML += "}\n";
            document.getElementsByTagName("body")[0].appendChild(style);
            sMedia.dom.find(this.config[btn_name]["action-target"]).attr("smedia-style", pbtn.style);
            for (const css_key in option.normal) {
                sMedia.dom.find(this.config[btn_name]["css-class"]).css(css_key, option.normal[css_key]);
            }
            for (const _css_key in option.hover) {
                sMedia.dom.find(this.config[btn_name]["css-class"]).css(_css_key, option.hover[_css_key]);
            }
        }
        set_size(btn_name, pbtn) {
            const option = this.config[btn_name].sizes[pbtn.size];
            const style = document.createElement("style");
            style.type = "text/css";
            style.innerHTML = `${this.config[btn_name]["css-class"]} { `;
            for (const css_key in option) {
                style.innerHTML += `${css_key}: ${option[css_key]} !important;`;
            }
            style.innerHTML += "}\n";
            document.getElementsByTagName("body")[0].appendChild(style);
            sMedia.dom.find(this.config[btn_name]["action-target"]).attr("smedia-size", pbtn.size);
        }
        set_location(btn_name, pbtn) {
            const target = sMedia.dom.find(this.config[btn_name].target);
            const location = sMedia.dom.find(this.config[btn_name].locations[pbtn.location]);
            if (target && location) {
                if (target.length && location.length) {
                    location.after(target.get(0));
                }
            }
            sMedia.dom.find(this.config[btn_name]["action-target"]).attr("smedia-location", pbtn.location);
        }
        unbindOnclickAttr(btn_name) {
            if ((this.formDebug || this.form_live) &&
                this.config[btn_name].button_action) {
                const elements = sMedia.dom.find(this.config[btn_name]["action-target"]);
                const that = this;
                elements.each(function (element) {
                    if (element) {
                        const clone = element.cloneNode();
                        while (element.firstChild) {
                            clone.appendChild(element.firstChild);
                        }
                        element.parentNode.replaceChild(clone, element);
                        const had_onclick = sMedia.dom
                            .find(that.config[btn_name]["action-target"])
                            .attr("onclick");
                        if (typeof had_onclick !== typeof undefined &&
                            !!had_onclick) {
                            sMedia.dom.find(that.config[btn_name]["action-target"]).attr("smedia-click-was", had_onclick);
                            sMedia.dom.find(that.config[btn_name]["action-target"]).removeAttr("onclick");
                        }
                    }
                });
                sMedia.dom.find(this.config[btn_name]["action-target"]).unbind("click");
            }
        }
        bind_events(btn_name) {
            this.unbindOnclickAttr(btn_name);
            const elems = sMedia.dom.find(this.config[btn_name]["action-target"]);
            elems.addClass(`smedia-ai-${btn_name.replace(" ", "-")}`);
            elems.css("cursor", "pointer");
            if (elems.length > 0) {
                for (let i = 0; i < elems.length; i++) {
                    const elm = elems[i];
                    elm.addEventListener("mousedown", this.click.bind(this), {
                        capture: true,
                    });
                }
            }
        }
        showForm(form_name) {
            const btn_name = "strade";
            const params = {
                dealership: this.dealership,
                url: this.url,
                button_name: btn_name,
                text_key: "strade",
                text_value: "Get Market Report",
                location: "default",
                style: "default",
                size: "default",
                combination: "baseline",
                algorithm: this.algorithm,
                smedia_uuid: this.getButtonCookie("smedia_smart_lead_uuid") ||
                    sMedia.Context.Browser.uniqueUserId,
                disclaimer: this.disclaimer,
                referrer: document.referrer,
            };
            this.window.set_params(params);
            this.window.params.form = form_name;
            this.window.open(`${sMedia.apiHost}/forms/${form_name}.php?dealership=${this.dealership}`);
        }
        click(e) {
            var _a, _b, _c;
            if (e.button == 1 || e.button == 2) {
                return;
            }
            const target = sMedia.dom.el(event.target);
            let btnDataEl = target;
            if (btnDataEl.attr("smedia-btn-name") === null) {
                btnDataEl = target.parents("[smedia-btn-name]");
            }
            const currentTarget = sMedia.dom.el(event.currentTarget);
            const btn_name = target.attr("smedia-btn-name")
                ? target.attr("smedia-btn-name")
                : currentTarget.attr("smedia-btn-name");
            if (!btn_name) {
                console.warn("Ai button name not found", e);
                return;
            }
            const params = {
                dealership: this.dealership,
                url: this.url,
                button_name: btn_name,
                text_key: btnDataEl.attr("smedia-text-key"),
                text_value: btnDataEl.attr("smedia-text-value"),
                location: btnDataEl.attr("smedia-location"),
                style: btnDataEl.attr("smedia-style"),
                size: btnDataEl.attr("smedia-size"),
                combination: btnDataEl.attr("smedia-combination"),
                algorithm: this.algorithm,
                smedia_uuid: this.getButtonCookie("smedia_smart_lead_uuid") ||
                    sMedia.Context.Browser.uniqueUserId,
                disclaimer: this.disclaimer,
                referrer: document.referrer,
            };
            const pd = sMedia.Context.PageData;
            const clickEvent = new CustomEvent("aibutton.click", {
                detail: {
                    buttonName: btn_name,
                    textKey: params.text_key,
                    value: params.text_value,
                    pageType: pd.page_type,
                    carData: pd.car_data,
                },
            });
            document.dispatchEvent(clickEvent);
            (_c = (_b = (_a = sMedia.Context.GlobalCallbacks) === null || _a === void 0 ? void 0 : _a.aiButton) === null || _b === void 0 ? void 0 : _b.onClick) === null || _c === void 0 ? void 0 : _c.forEach((cb) => {
                typeof cb === "function" && cb(btn_name, params.text_value);
            });
            this.track("clicked", params);
            if (typeof ga === "function") {
                ga("smedia_analytics_tracker.send", {
                    hitType: "event",
                    eventCategory: "Button Clicked",
                    eventAction: "AI Button",
                    eventLabel: params.button_name,
                    nonInteraction: true,
                });
                const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
                    sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
                if (trackerCount > 1) {
                    const trackerBaseName = "smedia_analytics_tracker";
                    for (let p = 1; p < trackerCount; p++) {
                        const trackerName = `${trackerBaseName}_${p}`;
                        ga(`${trackerName}.send`, {
                            hitType: "event",
                            eventCategory: "Button Clicked",
                            eventAction: "AI Button",
                            eventLabel: params.button_name,
                            nonInteraction: true,
                        });
                    }
                }
            }
            if ((this.formDebug || this.form_live) &&
                this.config[btn_name].button_action) {
                if (this.config[btn_name].button_action[0] === "form") {
                    const form_name = this.config[btn_name].button_action[1];
                    this.window.set_params(params);
                    this.window.params.form = form_name;
                    const styleme = `<style type="text/css">
						div#smedia-window-overlay {
							position  : fixed;
							width     : 100%;
							height    : 100%;
							top       : 0px;
							left      : 0px;
							display   : none;
							z-index   : 999999;
							background: #000000;
							display   : none;
							opacity   : 0.75;
						}

						div#smedia-window-container {
							overflow             : hidden;
							background-color     : white;
							-webkit-border-radius: 5px;
							-moz-border-radius   : 5px;
							border-radius        : 5px;
							position             : fixed;
							font-family          : Arial;
							max-width            : 100%;
							top                  : 50%;
							left                 : 50%;
							display              : none;
							z-index              : 1000000;
						}

						iframe#smedia-window-frame {
							overflow    : hidden;
							margin-left : auto;
							margin-right: auto;
							border      : none;
						}
					</style>`;
                    sMedia.dom.find("body").append(styleme);
                    const showFormUrl = `${sMedia.apiHost}/forms/${form_name}.php?dealership=${this.dealership}`;
                    this.window.open(showFormUrl);
                }
                this.track("form_viewed", params);
                e.stopImmediatePropagation();
                e.preventDefault();
                return false;
            }
        }
        track(type, params) {
            this.busy = true;
            const post_data = {
                act: type,
                button_name: encodeURIComponent(params.button_name),
                text_key: encodeURIComponent(params.text_key),
                text_value: encodeURIComponent(params.text_value),
                location: encodeURIComponent(params.location),
                style: encodeURIComponent(params.style),
                size: encodeURIComponent(params.size),
                combination: encodeURIComponent(params.combination),
                algorithm: encodeURIComponent(params.algorithm),
                url: encodeURIComponent(params.url),
                dealership: encodeURIComponent(params.dealership),
                smedia_uuid: encodeURIComponent(params.smedia_uuid),
            };
            new sMedia.Ajax().Post(this.tracker_url, post_data, (response) => {
                this.debug(response);
                this.busy = false;
                while (this.pending.length > 0) {
                    this.execute(this.pending.shift());
                }
            }, null, "application/x-www-form-urlencoded");
        }
        checking_button(checking_data, dealership) {
            const decoded_data = JSON.parse(checking_data);
            let error_message = "";
            for (const button_name in decoded_data) {
                if (!sMedia.dom.find(decoded_data[button_name].action_target).length) {
                    error_message += `${button_name}: action-target not found. <br>`;
                }
                if (!sMedia.dom.find(decoded_data[button_name].css_class).length) {
                    error_message += `${button_name}: css-class not found. <br>`;
                }
            }
            if (error_message) {
                const post_data = {
                    act: "save_log",
                    error_message: error_message,
                    dealership: dealership,
                };
                new sMedia.Ajax().Post(this.tracker_url, post_data, (response) => this.debug(response), null, "application/x-www-form-urlencoded");
            }
        }
        execute(task) {
            if (task && typeof this[task.name] === "function") {
                this[task.name].apply(null, task.args ? task.args : []);
            }
        }
        debug(msg) {
            sMedia.Context.LogService.Debug(msg);
        }
    }
    sMedia.AiButton = AiButton;
    sMedia.Context.OnReady(() => {
        const aiButton = new AiButton();
        aiButton.Register();
    });
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class ButtonWindow {
        constructor() {
            this.is_open = false;
            this.initialized = false;
            this.params = null;
        }
        init() {
            const html_content = `<div id="smedia-window-overlay" style="display:none"></div>
			<div id="smedia-window-container" scrolling="no" style="display:none">
				<iframe id="smedia-window-frame" scrolling="no" src="${sMedia.apiHost}/adwords3/templates/balls.svg"></iframe>
				<div id="smedia-loading-spinner">
					<img src="${sMedia.apiHost}/adwords3/templates/balls.svg"/>
				</div>
			</div>`;
            const smedia_temp_div = document.createElement("div");
            smedia_temp_div.innerHTML = html_content;
            const smedia_form_elements = smedia_temp_div.childNodes;
            document
                .getElementsByTagName("body")[0]
                .appendChild(smedia_form_elements[0]);
            document
                .getElementsByTagName("body")[0]
                .appendChild(smedia_form_elements[1]);
            const that = this;
            sMedia.dom.find("#smedia-window-overlay").on("click", function () {
                that.close();
            });
            this.initialized = true;
            if (typeof this.onReady === "function") {
                this.onReady();
            }
        }
        set_params(params) {
            this.params = params;
        }
        loading() {
            sMedia.dom.find("#smedia-window-frame").hide();
            sMedia.dom.find("#smedia-loading-spinner").show();
            this.resize_container(36, 36);
        }
        loaded(form) {
            var _a, _b;
            this.resize(form);
            try {
                sMedia.dom.el(window).trigger("resize");
            }
            catch (error) {
                console.error("sMedia error", error);
            }
            sMedia.dom.find("#smedia-loading-spinner").hide();
            sMedia.dom.find("#smedia-window-frame").show();
            const frame = sMedia.dom
                .find("#smedia-window-frame")
                .get(0);
            frame.contentWindow.postMessage({ action: "set_params", data: this.params }, "*");
            const PD = sMedia.Context.PageData;
            const loadEvent = new CustomEvent("aiform.load", {
                detail: {
                    formName: this.params.form,
                    pageType: PD.page_type,
                    carData: PD.car_data,
                },
            });
            document.dispatchEvent(loadEvent);
            (((_b = (_a = sMedia.Context.GlobalCallbacks) === null || _a === void 0 ? void 0 : _a.aiForm) === null || _b === void 0 ? void 0 : _b.onLoad) || []).forEach((cb) => {
                typeof cb === "function" && cb(this.params.form);
            });
        }
        open(url) {
            if (!this.initialized) {
                this.init();
                const that = this;
                window.addEventListener("message", (event) => {
                    switch (event.data.action) {
                        case "loaded":
                            that.loaded(event.data);
                            break;
                        case "loading":
                            that.loading();
                            break;
                        case "resize":
                            that.resize(event.data);
                            break;
                        case "input_changed":
                            that.input_changed(event.data);
                            break;
                        case "input_start":
                            that.input_start();
                            break;
                        case "fillup":
                            that.fillup(event.data.redirect_url);
                            break;
                        case "close":
                            that.close();
                            break;
                        case "thankyouClose":
                            that.close(true);
                            break;
                        default:
                            if (typeof that[event.data.action] === "function") {
                                this[event.data.action](event.data);
                            }
                            break;
                    }
                }, false);
                window.addEventListener("resize", () => {
                    sMedia.dom.find("#smedia-window-frame")[0].contentWindow.postMessage({
                        action: "device",
                        device: sMedia.dom.find("body").width() >= 860 ? "desktop" : "mobile",
                    }, "*");
                });
            }
            if (this.is_open) {
                return;
            }
            sMedia.dom.find("#smedia-window-overlay").css("display", "block");
            sMedia.dom.find("#smedia-window-container").css("display", "inline-block");
            this.loading();
            sMedia.dom.find("#smedia-window-frame").attr("src", url);
            this.is_open = true;
        }
        resize_container(width, height) {
            const container = sMedia.dom.find("#smedia-window-container");
            container.width(width);
            container.height(height);
            container.css({ "overflow-y": "hidden" });
            if (container.height() > window.innerWidth) {
                container.height(window.innerWidth);
                container.css("overflow-y", "auto");
            }
            container.css("margin-left", `${(container.outerWidth() >> 1) * -1}px`);
            container.css("margin-top", `${(container.outerHeight() >> 1) * -1}px`);
        }
        resize(form) {
            sMedia.dom.find("#smedia-window-frame").width(form.width);
            sMedia.dom.find("#smedia-window-frame").height(form.height);
            this.resize_container(form.width, form.height);
        }
        close(thankyouClose = false) {
            var _a, _b, _c;
            sMedia.dom.find("#smedia-window-overlay").css("display", "none");
            sMedia.dom.find("#smedia-window-container").css("display", "none");
            this.is_open = false;
            if (!thankyouClose) {
                const PD = sMedia.Context.PageData;
                const closeEvent = new CustomEvent("aiform.close", {
                    detail: {
                        detail: {
                            formName: this.params.form,
                            pageType: PD.page_type,
                            carData: PD.car_data,
                        },
                    },
                });
                document.dispatchEvent(closeEvent);
                (_c = (_b = (_a = sMedia.Context.GlobalCallbacks) === null || _a === void 0 ? void 0 : _a.aiForm) === null || _b === void 0 ? void 0 : _b.onClose) === null || _c === void 0 ? void 0 : _c.forEach((cb) => {
                    typeof cb === "function" && cb(this.params.form);
                });
            }
        }
        fillup(redirect_url) {
            var _a, _b, _c;
            ga("smedia_analytics_tracker.send", {
                hitType: "event",
                eventCategory: "Form Fillup",
                eventAction: "AI Form",
                nonInteraction: true,
            });
            const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
                sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
            if (trackerCount > 1) {
                const trackerBaseName = "smedia_analytics_tracker";
                for (let p = 1; p < trackerCount; p++) {
                    const trackerName = `${trackerBaseName}_${p}`;
                    ga(`${trackerName}.send`, {
                        hitType: "event",
                        eventCategory: "Form Fillup",
                        eventAction: "AI Form",
                        nonInteraction: true,
                    });
                }
            }
            const PD = sMedia.Context.PageData;
            const completeEvent = new CustomEvent("aiform.complete", {
                detail: {
                    formName: this.params.form,
                    pageType: PD.page_type,
                    carData: PD.car_data,
                },
            });
            document.dispatchEvent(completeEvent);
            (_c = (_b = (_a = sMedia.Context.GlobalCallbacks) === null || _a === void 0 ? void 0 : _a.aiForm) === null || _b === void 0 ? void 0 : _b.onFillUp) === null || _c === void 0 ? void 0 : _c.forEach((cb) => {
                typeof cb === "function" && cb(this.params.form);
            });
            if (!!redirect_url) {
                setTimeout(() => (location.href.split('#')[0] = redirect_url), 1000);
            }
        }
        input_start() {
            const PD = sMedia.Context.PageData;
            const startEvent = new CustomEvent("aiform.start", {
                detail: {
                    formName: this.params.form,
                    pageType: PD.page_type,
                    carData: PD.car_data,
                },
            });
            document.dispatchEvent(startEvent);
        }
        input_changed(data) {
            ga("smedia_analytics_tracker.send", {
                hitType: "event",
                eventCategory: "Input Tracking",
                eventAction: data.status,
                eventLabel: data.field,
                nonInteraction: true,
            });
            const trackerCount = sMedia.Context.DomainConfig.single_tag_config.analytics ?
                sMedia.Context.DomainConfig.single_tag_config.analytics.length : 0;
            if (trackerCount > 1) {
                const trackerBaseName = "smedia_analytics_tracker";
                for (let p = 1; p < trackerCount; p++) {
                    const trackerName = `${trackerBaseName}_${p}`;
                    ga(`${trackerName}.send`, {
                        hitType: "event",
                        eventCategory: "Input Tracking",
                        eventAction: data.status,
                        eventLabel: data.field,
                        nonInteraction: true,
                    });
                }
            }
            const inputChangeEvent = new CustomEvent("aiform.input_change", {
                detail: {
                    formName: this.params.form,
                    field: data.field,
                    status: data.status,
                },
            });
            document.dispatchEvent(inputChangeEvent);
        }
    }
    sMedia.ButtonWindow = ButtonWindow;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    function rbeta(alpha, beta) {
        const alpha_gamma = rgamma(alpha, 1);
        return alpha_gamma / (alpha_gamma + rgamma(beta, 1));
    }
    sMedia.rbeta = rbeta;
    function rgamma(alpha, beta) {
        const SG_MAGICCONST = 1 + Math.log(4.5);
        const LOG4 = Math.log(4.0);
        let x;
        let z;
        if (alpha > 1) {
            const ainv = Math.sqrt(2.0 * alpha - 1.0);
            const bbb = alpha - LOG4;
            const ccc = alpha + ainv;
            const loop = true;
            while (loop) {
                const u1 = Math.random();
                if (!(1e-7 < u1 && u1 < 0.9999999)) {
                    continue;
                }
                const u2 = 1.0 - Math.random();
                const v = Math.log(u1 / (1.0 - u1)) / ainv;
                x = alpha * Math.exp(v);
                z = u1 * u1 * u2;
                const r = bbb + ccc * v - x;
                if (r + SG_MAGICCONST - 4.5 * z >= 0.0 || r >= Math.log(z)) {
                    return x * beta;
                }
            }
        }
        else if (alpha == 1.0) {
            let u = Math.random();
            while (u <= 1e-7) {
                u = Math.random();
            }
            return -Math.log(u) * beta;
        }
        else {
            let looper = true;
            while (looper) {
                const u3 = Math.random();
                const b = (Math.E + alpha) / Math.E;
                const p = b * u3;
                if (p <= 1.0) {
                    x = Math.pow(p, 1.0 / alpha);
                }
                else {
                    x = -Math.log((b - p) / alpha);
                }
                const u4 = Math.random();
                if (p > 1.0) {
                    if (u4 <= Math.pow(x, alpha - 1.0)) {
                        looper = false;
                    }
                }
                else if (u4 <= Math.exp(-x)) {
                    looper = false;
                }
            }
            return x * beta;
        }
    }
    sMedia.rgamma = rgamma;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class DirectMail {
            Register() {
                if (sMedia.Context.DomainConfig.cron_config.mail_retargeting &&
                    (sMedia.Context.DomainConfig.cron_config.mail_retargeting.enabled || sMedia.Context.DebugFlags.mailRetargeting) &&
                    sMedia.Context.PageData && sMedia.Context.PageType == "vdp") {
                    this.Install(sMedia.Context.Dealership, sMedia.Context.PageData.car_data.stock_number);
                }
            }
            Install(dealership, stock_number) {
                const request_url = `${sMedia.apiHost}/services/direct-mail.php?dealership=${encodeURIComponent(dealership)}&stock_number=${encodeURIComponent(stock_number)}`;
                new sMedia.Ajax().Get(request_url, function (response) {
                    console.log(response);
                    if (response.success === true && response.client_id) {
                        const payload_array = {
                            'aid': response.client_id,
                            'logo': response.logo,
                            'front_banner': response.front_banner,
                            'back_banner': response.back_banner,
                            'coupon_offer': response.promotion_text,
                            'offer_color': response.promotion_color,
                            'promo_bg_color': response.overlay_color,
                            'promo_color': response.overlay_text_colour,
                            'promo_text': 'FEATURED VEHICLE',
                            'price_color': response.price_color,
                            'coupon_date': new Date().toLocaleDateString(),
                            'coupon_validity': response.coupon_validity,
                            'vehicle_1_stock': response.vehicles[0].stock_number,
                            'vehicle_1_year': response.vehicles[0].year,
                            'vehicle_1_make': response.vehicles[0].make,
                            'vehicle_1_model': response.vehicles[0].model,
                            'vehicle_1_price': response.vehicles[0].price,
                            'vehicle_1_img': response.vehicles[0].image,
                            'vehicle_2_stock': response.vehicles[1].stock_number,
                            'vehicle_2_year': response.vehicles[1].year,
                            'vehicle_2_make': response.vehicles[1].make,
                            'vehicle_2_model': response.vehicles[1].model,
                            'vehicle_2_price': response.vehicles[1].price,
                            'vehicle_2_img': response.vehicles[1].image
                        };
                        let RDE = 'https://rdcdn.com/rt?e=1&img=1';
                        for (const [load_key, load_value] of Object.entries(payload_array)) {
                            RDE += `&${load_key}=${encodeURIComponent(load_value)}`;
                        }
                        const RDP = document.createElement('img');
                        RDP.setAttribute("width", "1");
                        RDP.setAttribute("height", "1");
                        RDP.setAttribute("src", RDE);
                        document.getElementsByTagName("body")[0].appendChild(RDP);
                    }
                });
            }
            Unregister() { }
        }
        Modules.directMail = new DirectMail();
        sMedia.Context.OnReady(() => {
            Modules.directMail.Register();
        });
        sMedia.Context.OnClose(() => {
            Modules.directMail.Unregister();
        });
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class Epm {
        constructor() {
            this.clickScored = false;
            this.buttonClickScored = false;
            this.timeOnPageScored = false;
            this.scrollDepthScored = false;
            this.firstScroll = false;
            this.executionCount = 0;
            this.timeOnPage = 0;
            this.timeoutId = null;
        }
        Register() {
            this.clickScored = false;
            this.buttonClickScored = false;
            this.timeOnPageScored = false;
            this.scrollDepthScored = false;
            this.firstScroll = false;
            this.executionCount = 0;
            this.timeOnPage = 0;
            this.timeoutId = null;
            if (sMedia.Context.PageType === "vdp") {
                const recordCallback = this.EventRecorded.bind(this);
                this.epmData = new sMedia.EpmData();
                this.epmData.load();
                sMedia.Context.EventTracker.OnRecord(recordCallback);
            }
            this.log = sMedia.Context.LogService;
            sMedia.Context.GlobalCallbacks.epm.push((_, c) => sMedia.Context.EventTracker.Record("EpmEvent", `${c * 30}_Sec`, null, {
                ...this.epmData.activePage,
                name: undefined,
                visit: undefined,
            }));
        }
        Unregister() {
            if (this.timeoutId) {
                clearTimeout(this.timeoutId);
            }
            const recordCallback = this.EventRecorded.bind(this);
            sMedia.Context.EventTracker.RemoveRecordCallback(recordCallback);
        }
        ExecuteEpm() {
            if (sMedia.Context.PageType !== "vdp" ||
                !this.epmData.isActivePageEngaged() ||
                this.executionCount > 3) {
                return;
            }
            this.executionCount += 1;
            sMedia.Context.GlobalCallbacks.epm.forEach((cb) => {
                try {
                    cb(this.timeOnPage, this.executionCount);
                }
                catch (e) {
                    this.log.Log(sMedia.LogType.Error, { "sMedia error": e });
                }
            });
            if (this.executionCount < 3) {
                this.setExecTimeout();
            }
        }
        setExecTimeout(time = 30000) {
            clearTimeout(this.timeoutId);
            this.timeoutId = setTimeout(() => {
                this.ExecuteEpm();
            }, time);
        }
        EventRecorded(event) {
            if (!this.epmData.firstLoad) {
                const executeEpm = () => setTimeout(() => {
                    if (document.readyState === "complete" &&
                        sMedia.Context.PageType === "vdp" &&
                        this.executionCount === 0 &&
                        this.epmData.isActivePageEngaged()) {
                        this.setExecTimeout(100);
                    }
                }, 2000);
                switch (event.Action) {
                    case "Click":
                        if (this.clickScored)
                            break;
                        this.AddPoint("click", 10);
                        this.clickScored = true;
                        executeEpm();
                        break;
                    case "ButtonClick":
                        if (this.buttonClickScored)
                            break;
                        this.AddPoint("buttonClick", 70);
                        this.buttonClickScored = true;
                        executeEpm();
                        break;
                    case "TimeOnPage":
                        this.timeOnPage = event.Value;
                        if ((this.timeOnPageScored || event.Value / 1000) < 30)
                            break;
                        this.AddPoint("pageTime", 70);
                        this.timeOnPageScored = true;
                        executeEpm();
                        break;
                    case "ScrollDepth":
                        if (event.Value > 5 && !this.firstScroll) {
                            this.AddPoint("firstScroll", 10);
                            this.firstScroll = true;
                            executeEpm();
                        }
                        if (event.Value < 50 || this.scrollDepthScored) {
                            break;
                        }
                        this.AddPoint("scroll", 10);
                        this.scrollDepthScored = true;
                        executeEpm();
                        break;
                }
            }
        }
        AddPoint(event, point) {
            this.epmData.load();
            setTimeout(() => {
                this.epmData.increaseCarPoint({
                    year: sMedia.Context.PageData.car_data.year,
                    make: sMedia.Context.PageData.car_data.make,
                    model: sMedia.Context.PageData.car_data.model,
                }, event, point);
                this.epmData.save();
            }, 500);
        }
        debug(msg) {
            this.log.Debug(msg);
        }
    }
    const epm = new Epm();
    sMedia.Context.OnReady(() => {
        epm.Register();
    });
    sMedia.Context.OnClose(() => {
        epm.Unregister();
    });
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    class EpmData {
        constructor() {
            this.make = [];
            this.model = [];
            this.year = [];
            this.activePage = {
                name: "",
                click: 0,
                buttonClick: 0,
                firstScroll: 0,
                scroll: 0,
                pageTime: 0,
                visit: 1,
            };
            this.firstLoad = true;
        }
        load() {
            const cb = (data) => {
                if (data && !!data.make) {
                    this.make = data.make;
                    if (!this.get("make", sMedia.Context.PageData.car_data.make))
                        this.addCurrent("make");
                }
                else {
                    this.addCurrent("make");
                }
                if (data && !!data.model) {
                    this.model = data.model;
                    if (!this.get("model", sMedia.Context.PageData.car_data.model))
                        this.addCurrent("model");
                }
                else {
                    this.addCurrent("model");
                }
                if (data && !!data.year) {
                    this.year = data.year;
                    if (!this.get("year", sMedia.Context.PageData.car_data.year))
                        this.addCurrent("year");
                }
                else {
                    this.addCurrent("year");
                }
                this.save();
                if (this.firstLoad && sMedia.Context.PageType === "vdp") {
                    const CD = sMedia.Context.PageData.car_data;
                    if (CD.year && CD.make && CD.model) {
                        this.incVisit(this.get("make", CD.make));
                        this.incVisit(this.get("model", CD.model));
                        this.incVisit(this.get("year", CD.year));
                        this.save();
                    }
                    this.firstLoad = false;
                }
            };
            cb(sMedia.LocalStorage.get("epmdata"));
        }
        addCurrent(type) {
            const zero = {
                name: "",
                click: 0,
                buttonClick: 0,
                pageTime: 0,
                firstScroll: 0,
                scroll: 0,
                visit: 0,
            };
            this[type].push({
                ...zero,
                name: sMedia.Context.PageData.car_data[type],
            });
        }
        get(type, name) {
            return this[type].find((v) => v.name === name);
        }
        incVisit(data) {
            data.visit = data.visit + 1;
            data.click = this.calcMean(data.click, data.visit, 0);
            data.buttonClick = this.calcMean(data.buttonClick, data.visit, 0);
            data.pageTime = this.calcMean(data.pageTime, data.visit, 0);
            data.firstScroll = this.calcMean(data.firstScroll, data.visit, 0);
            data.scroll = this.calcMean(data.scroll, data.visit, 0);
        }
        calcMean(acc, visit, add) {
            if (visit == 1) {
                return add;
            }
            return (this.firstLoad) ? ((acc + add) >> 1) : (((acc << 1) + add) >> 1);
        }
        increase(type, name, event, point) {
            const data = this.get(type, name);
            if (!!data && data[event] !== undefined) {
                data[event] = this.calcMean(data[event], data.visit, point);
            }
        }
        increaseCarPoint(carInfo, event, point) {
            this.activePage[event] = point;
            ["make", "model", "year"].forEach((k) => {
                this.increase(k, carInfo[k], event, point);
            });
        }
        getTotal(d) {
            return (d.pageTime + d.buttonClick + d.firstScroll + d.scroll + d.click);
        }
        getAvarageFor(type) {
            const data = this[type];
            const total = data.reduce((acc, v) => acc + this.getTotal(v), 0);
            return total / data.length;
        }
        isActivePageEngaged() {
            const total = this.getTotal(this.activePage);
            return total >= 80;
        }
        getEngagements(carInfo) {
            return ["make", "model", "year"].map((type) => {
                const total = this.getTotal(this.get(type, carInfo[type]));
                const avg = this.getAvarageFor(type);
                return total >= avg;
            });
        }
        getTotalEngagements(carInfo) {
            return this.getEngagements(carInfo).reduce((total, v) => total + (v === true ? 1 : 0), 0);
        }
        getTotalPageView() {
            return this.make.reduce((total, v) => total + v.visit, 0);
        }
        save() {
            const data = {
                make: this.make,
                model: this.model,
                year: this.year,
            };
            sMedia.LocalStorage.set("epmdata", data, 299500);
        }
    }
    sMedia.EpmData = EpmData;
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class JsCrawler {
            Register() {
                const SC = sMedia.Context.DomainConfig.scrapper_config;
                if ((sMedia.Context.PageType == 'vdp') && SC.vdp_url_regex && SC.client_scrapping) {
                    this.installJsCrawler();
                }
            }
            installJsCrawler() {
                const js_crawler_script = `${sMedia.apiHost}/jscrawler/scrapper.js`;
                sMedia.DomInstaller.InstallScript(js_crawler_script);
            }
            Unregister() {
            }
        }
        Modules.jsCrawler = new JsCrawler();
        sMedia.Context.OnReady(() => {
            Modules.jsCrawler.Register();
        });
        sMedia.Context.OnClose(() => {
            Modules.jsCrawler.Unregister();
        });
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class SmartBanner {
            constructor() {
                this.apiUrl = `${sMedia.apiHost}/services/smart-banner.php`;
                this.dataStorageKey = "smedia_sb_data";
            }
            registerEpmTracker() {
                const that = this;
                if (this.carData.url && sMedia.Context.GlobalCallbacks.epm !== undefined) {
                    sMedia.Context.GlobalCallbacks.epm.push((_, count) => {
                        if (count == 1) {
                            that.saveEngagedCar();
                        }
                    });
                }
            }
            Register() {
                this.carData = sMedia.Context.PageData.car_data || {};
                this.registerEpmTracker();
            }
            Unregister() { }
            saveEngagedCar() {
                const ctx = sMedia.Context;
                if (!["make", "model", "year", "url"].find((e) => !(e in this.carData))) {
                    const formData = {
                        act: "save",
                        sb_dealership: ctx.DomainConfig.cron,
                        sb_uuid: ctx.Browser.uniqueUserId,
                        sb_make: this.carData.make,
                        sb_model: this.carData.model,
                        sb_year: this.carData.year,
                        sb_vdp: this.carData.url,
                    };
                    const that = this;
                    new sMedia.Ajax().Post(this.apiUrl, formData, (response) => {
                        const data = {
                            vdp: this.carData.url,
                            title: [
                                this.carData.year,
                                this.carData.make,
                                this.carData.model,
                            ].join(" "),
                            car_image: ((response || {}).data || {}).car_image || "",
                            dealership: sMedia.Context.DomainConfig.cron,
                        };
                        sMedia.LocalStorage.set(that.dataStorageKey, data, sMedia.SECONDS_IN_A_DAY);
                    }, null, "application/x-www-form-urlencoded");
                }
            }
        }
        Modules.smartBanner = new SmartBanner();
        sMedia.Context.OnReady(() => {
            Modules.smartBanner.Register();
        });
        sMedia.Context.OnClose(() => {
            Modules.smartBanner.Unregister();
        });
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class SmartOffer {
            constructor() {
                this.debug = false;
                this.soVideoReady = false;
                this.readyToShow = false;
                this.smartOfferReady = true;
                this.showSmartOffer = false;
                this.thisIsMemo = false;
                this.thisIsMemoVideo = false;
                this.thisIsResume = false;
                this.smartOfferShown = false;
                this.sessPageVisits = 0;
                this.storagePrefix = 'so';
                this.fireSmartOffer = (enabledForPageType, player, firedByTimer = false) => {
                    if ((this.debug || this.showSmartOffer) && enabledForPageType && !(firedByTimer && this.smartOfferShown)) {
                        const rwait = setInterval(() => {
                            if (this.readyToShow && !sMedia.multipleInputsInViewPort() && !window.preventSO) {
                                clearInterval(rwait);
                                if (this.video) {
                                    player.play();
                                    setTimeout(() => {
                                        if (player.paused()) {
                                            player.muted(true);
                                            player.play();
                                        }
                                    }, 500);
                                }
                                this.smartOfferLead.show();
                                this.smartOfferShown = true;
                                if (this.thisIsMemo || this.thisIsMemoVideo) {
                                    this.bindSmartMemoEvents();
                                }
                                if (this.so_config.exit_intent.active) {
                                    document.addEventListener("visibilitychange", () => {
                                        window.setTimeout(() => {
                                            this.smartOfferLead.close(true);
                                        }, this.so_config.exit_intent.value);
                                    }, { once: true });
                                }
                                if (this.so_config.inactivity.active) {
                                    window.setTimeout(() => {
                                        this.smartOfferLead.close(true);
                                    }, this.so_config.inactivity.value);
                                }
                            }
                            else {
                                sMedia.debugLog(`sMedia: SO not ready or other form visible`);
                            }
                        }, 500);
                    }
                };
            }
            Register() {
                const cookie_script = `${sMedia.apiHost}/sm-scripts/smart-offer/gtm-cookie-replicator.js`;
                sMedia.DomInstaller.InstallScript(cookie_script);
                const smartProfiler = new Modules.SmartProfiler();
                smartProfiler.Register();
                if (!sMedia.Context.AppStates.smart_profiler_enabled) {
                    this.init();
                }
            }
            Unregister() { }
            init() {
                const browser = sMedia.Context.Browser;
                const pageType = sMedia.Context.PageType;
                this.debug = sMedia.Context.DebugFlags.smartOffer;
                const domConfig = sMedia.Context.DomainConfig;
                const apiServer = sMedia.Context.DomainConfig.smedia_domains.smedia_api;
                this.leadFormUrl = `${apiServer}/v1/smart-offer/new/${domConfig.mongo_dealer_info.id}/`;
                const carDataParam = (sMedia.Context.PageData.car_data || {});
                const smartOffers = (domConfig.services || {}).smart_offer || [];
                const defaultConfigs = {
                    pages: {
                        all: false,
                        home: false,
                        new: false,
                        used: false,
                        certified: false,
                        customVDP: false,
                        otherPage: false,
                    },
                    customVDP: {
                        stockType: [],
                        year: [],
                        make: [],
                        model: [],
                        regex: []
                    },
                    memoSetting: {
                        heading: {
                            show: false,
                            text: ""
                        },
                        body: {
                            show: false,
                            text: ""
                        },
                        button: {
                            show: false,
                            text: "",
                            redirect_url: ""
                        }
                    },
                    basicForm: {
                        first: {
                            label: 'Name',
                            type: 'text',
                            placeholder: 'Enter Your Name',
                            required: true
                        },
                        second: {
                            label: 'Email',
                            type: 'email',
                            placeholder: 'Enter Email Address',
                            required: true
                        },
                        third: {
                            label: 'Phone',
                            type: 'tel',
                            placeholder: 'Enter Phone Number',
                            required: true
                        }
                    },
                    extraForm: {
                        fourth: {
                            value: {
                                current_vdp: false,
                                placeholder: "Year Make Model"
                            },
                            show: false,
                            text: "New Car Info",
                            required: false,
                            show_car_option: false
                        },
                        fifth: {
                            show: false,
                            text: "Location",
                            required: false,
                            type: "dropdown",
                            placeholder: "Preferred Location",
                            option: []
                        },
                        resume: {
                            show: true,
                            text: "Resume File",
                            required: true,
                            type: "file",
                            placeholder: "No file chosen"
                        }
                    },
                    color: {
                        bg_color: "#EFEFEF",
                        text_color: "#404450",
                        heading_text_color: "#ffffff",
                        body_text_color: "#ffffff",
                        disclaimer_color: "#404450",
                        border_color: "#E5E5E5",
                        button_text_color: "#ffffff",
                        button_color: ["#000000", "#000000"],
                        button_color_hover: ["#222222", "#222222"],
                        button_color_active: ["#222222", "#222222"]
                    },
                    imgOrVideo: {
                        video: {
                            url: "https://www.youtube.com/watch?v=wCFi9s3LhBU&ab_channel=sMediaProofs",
                            title: "",
                            description: "",
                            show_form: true,
                        },
                        isVideo: false,
                        image: "https://cdash-reports.smedia.ca/smart-offer/demo.png",
                        version: "v0"
                    },
                    response_email: {
                        active: true,
                        email_title: '',
                        subject: "Hello [name],<p>Please print the following coupon and bring it in for the offer</p><img src=\"[image]\"/><p><br/>[dealership]",
                        email: "Hello [name],<p>Please print the following coupon and bring it in for the offer</p><img src=\"[image]\"/><p><br/>[dealership]"
                    },
                    forward_to: {
                        email_list: [],
                        subject: "sMedia Coupon Lead"
                    },
                    special_to: {
                        email_list: [],
                        subject: "sMedia Coupon Lead",
                        provider_name: "sMedia Coupon",
                        source: "sMedia Coupon"
                    },
                    device_type: {
                        mobile: true,
                        desktop: true,
                        tablet: true
                    },
                    display: {
                        display_after: 13000,
                        retarget_after: 5000,
                        fb_retarget_after: 5000,
                        adword_retarget_after: 5000
                    },
                    check_price: {
                        active: false,
                        max: 10000000,
                        min: 0
                    },
                    shown_cap: {
                        active: false,
                        value: 3
                    },
                    fillup_cap: {
                        active: false,
                        value: 7
                    },
                    session_close: {
                        active: false,
                        value: 3
                    },
                    session_depth: {
                        active: false,
                        value: 0
                    },
                    inactivity: {
                        active: false,
                        value: 300000
                    },
                    exit_intent: {
                        active: false,
                        value: 600000
                    },
                    campaign_cap_google: {
                        active: false,
                        count: 3,
                        days: 7
                    },
                    campaign_cap_fb: {
                        active: false,
                        count: 3,
                        days: 7
                    },
                    show_cases: {
                        timer: {
                            active: true,
                        },
                        onclick: {
                            active: false,
                            selectors: []
                        },
                        static: {
                            active: false,
                            options: [
                                {
                                    url: 'https://www.abc.com/test-page',
                                    selector: '#someRandomElement > a'
                                }
                            ]
                        }
                    },
                    name: "default smart offer",
                    live: false,
                    priority: 5,
                    archive: false,
                    exit_intent_popup: false,
                    template: "Smart Offer Lead",
                    otherPage: [],
                    buttonText: "submit",
                    custom_timing: [],
                    _id: "default",
                    createdAt: "",
                    updatedAt: "",
                    disclaimer: "",
                    id: "default"
                };
                if (!smartOffers.length) {
                    sMedia.debugLog("sMedia: No `SMART OFFER` config found for new-smart-offer.");
                }
                for (const leadConfigs of smartOffers) {
                    if (["Smart Memo Creative", "Smart Memo"].includes(leadConfigs.template)) {
                        this.thisIsMemo = true;
                    }
                    else {
                        this.thisIsMemo = false;
                    }
                    if (leadConfigs.template == "Smart Memo Video") {
                        this.thisIsMemoVideo = true;
                    }
                    else {
                        this.thisIsMemoVideo = false;
                    }
                    if (leadConfigs.template == "Smart Resume") {
                        this.thisIsResume = true;
                    }
                    else {
                        this.thisIsResume = false;
                    }
                    this.bgFileUrl = leadConfigs.imgOrVideo.image || null;
                    this.sessionStorage = sMedia.Context.HashFunction.Hash(`${sMedia.Context.Dealership}|${browser.uniqueUserId}|${browser.sessionId}|${leadConfigs.name}`);
                    this.persistentStorage = sMedia.Context.HashFunction.Hash(`${sMedia.Context.Dealership}|${browser.uniqueUserId}|${leadConfigs.name}`);
                    this.so_config = Object.assign({}, defaultConfigs, leadConfigs || {});
                    this.smartOfferLead = new Modules.SmartOfferLead(this.so_config, this.sessionStorage, this.persistentStorage, this.leadFormUrl, this.storagePrefix);
                    const isLive = this.so_config.live || false;
                    this.debug = sMedia.Context.DebugFlags.smartOffer;
                    this.showSmartOffer = true;
                    this.smartOfferShown = false;
                    if (!(isLive || this.debug)) {
                        sMedia.debugLog(`sMedia: Smart offer is neither live in config ==> '${this.so_config.name}' nor we are in debug mode. Hence smart offer stopped for this config.`);
                        continue;
                    }
                    this.video = this.so_config.imgOrVideo.isVideo;
                    const enabledForPageType = sMedia.isEnabledForThisPage(this.so_config);
                    sMedia.debugLog(`sMedia: Smart Offer live status ==> ${isLive} in config ==> '${this.so_config.name}'`);
                    sMedia.debugLog(`sMedia: Smart Offer enable status for this page ('${pageType}')  ==> '${enabledForPageType}' in config ==> '${this.so_config.name}'`);
                    sMedia.debugLog(`sMedia: Smart Offer Video ==> ${this.video} in config ==> '${this.so_config.name}'`);
                    if (!enabledForPageType) {
                        this.showSmartOffer = false;
                        sMedia.debugLog(`sMedia: Smart offer is not enabled for this page in config ==> '${this.so_config.name}'. Hence smart offer stopped for this config (even if in debug mode).`);
                        continue;
                    }
                    this.sessPageVisits = sMedia.setAndIncrementSessionDepth(this.sessionStorage, this.storagePrefix);
                    const metFBcap = sMedia.metFacebookCampaignCap(this.so_config, this.persistentStorage, 'smart offer', this.storagePrefix);
                    if (metFBcap) {
                        this.showSmartOffer = false;
                        sMedia.debugLog("sMedia: Smart offer will not be shown due to facebook campaign cap met");
                    }
                    const metGOOGLEcap = sMedia.metGoogleCampaignCap(this.so_config, this.persistentStorage, 'smart offer', this.storagePrefix);
                    if (metGOOGLEcap) {
                        this.showSmartOffer = false;
                        sMedia.debugLog("sMedia: Smart offer will not be shown due to google campaign cap met");
                    }
                    const metDailyShownCap = sMedia.dailyShownCapMet(this.so_config, this.persistentStorage, this.storagePrefix);
                    if (metDailyShownCap) {
                        this.showSmartOffer = false;
                        sMedia.debugLog(`sMedia: Smart offer is not shown due to daily shown cap has been met.`);
                    }
                    const metSessionShownCap = sMedia.sessionShownCapMet(this.so_config, this.sessionStorage, this.storagePrefix);
                    if (metSessionShownCap) {
                        this.showSmartOffer = false;
                        sMedia.debugLog(`sMedia: Smart offer is not shown due to session shown cap has been met.`);
                    }
                    const metSoFillUpCap = sMedia.metFillUpCap(this.so_config, this.persistentStorage, this.storagePrefix);
                    if (metSoFillUpCap) {
                        this.showSmartOffer = false;
                        sMedia.debugLog(`sMedia: Smart offer is not shown due to fill up cap is met.`);
                    }
                    const showForThisDevice = sMedia.showBasedOnDeviceType(this.so_config);
                    if (!showForThisDevice) {
                        this.showSmartOffer = false;
                        sMedia.debugLog(`sMedia: Smart offer is not enabled for device type ==> '${sMedia.Context.Browser.getDeviceType()}'.`);
                    }
                    const belowSessionDepth = sMedia.sessionDepthCheck(this.so_config, this.sessPageVisits);
                    if (belowSessionDepth) {
                        this.showSmartOffer = false;
                        sMedia.debugLog(`sMedia: Smart offer will not be shown due to current session depth being ${this.sessPageVisits} while ${this.so_config.session_depth.value} is required.`);
                    }
                    const showBasedOnPrice = sMedia.priceRangeMet(this.so_config);
                    if (!showBasedOnPrice) {
                        this.showSmartOffer = false;
                        sMedia.debugLog(`sMedia: Smart offer is not being shown due to price range requirement not matched.`);
                    }
                    const imgOrVideoUrlExists = ((this.bgFileUrl.length > (sMedia.apiHost.length + 4)) || (!sMedia.isEmptyString(this.so_config.imgOrVideo.video.url)));
                    if (!imgOrVideoUrlExists) {
                        this.showSmartOffer = false;
                        sMedia.debugLog(`sMedia: Smart offer is not being shown due URL for 'smart_offer_image' or 'smart_offer_video' is missing.`);
                    }
                    const soTimeLimit = sMedia.getTimeLimit(this.so_config);
                    console.log({ soTimeLimit });
                    this.appendHtml(this.getHtml(domConfig, carDataParam, browser));
                    this.appendCss({ dynamic: false });
                    const setSOready = (state) => {
                        window.setTimeout(() => {
                            this.readyToShow = state;
                        }, 5000);
                    };
                    document.addEventListener("aiform.load", () => { this.readyToShow = false; });
                    document.addEventListener("aiform.close", () => setSOready(true));
                    document.addEventListener("aiform.complete", () => setSOready(true));
                    const wait = setInterval(() => {
                        if (this.smartOfferReady && (!this.video || this.soVideoReady)) {
                            clearInterval(wait);
                            this.appendCss({ bgFileUrl: this.bgFileUrl, dynamic: true });
                            this.readyToShow = true;
                            let player = null;
                            if (this.video) {
                                this.readyToShow = false;
                                player = window.videojs("sm-lead-video", {
                                    techOrder: ["youtube"],
                                    sources: [{
                                            type: "video/youtube",
                                            src: this.so_config.imgOrVideo.video.url,
                                        }],
                                    youtube: {
                                        playsinline: 1,
                                        modestbranding: 1,
                                        autoplay: 1,
                                    },
                                }, () => {
                                    this.readyToShow = true;
                                    player.play();
                                });
                                player.on("firstplay", () => {
                                    player.muted(true);
                                    player.pause();
                                });
                            }
                            if (this.so_config.show_cases.timer.active) {
                                window.setTimeout(this.fireSmartOffer, soTimeLimit, enabledForPageType, player, true);
                            }
                            if (this.so_config.show_cases.onclick.active) {
                                const that = this;
                                const sels = that.so_config.show_cases.onclick.selectors;
                                if (sels && sels.length) {
                                    sels.forEach((sel) => {
                                        this.unbindOnclickAttr(sel);
                                        const onclick_elements = document.querySelectorAll(sel);
                                        onclick_elements.forEach((elm) => {
                                            elm.addEventListener('click', function (e) {
                                                e.preventDefault();
                                                e.stopPropagation();
                                                that.fireSmartOffer(enabledForPageType, player);
                                            });
                                        });
                                    });
                                }
                            }
                            if (this.so_config.exit_intent_popup) {
                                const exit_intent_so_fire = (event, event_name) => {
                                    sMedia.debugLog(`sMedia: Exit intent discovered and SO fired for event ==> '${event_name}'`);
                                    event.preventDefault();
                                    event.stopPropagation();
                                    this.fireSmartOffer(enabledForPageType, player);
                                };
                                const cases = [];
                                cases.forEach((event_name) => {
                                    document.addEventListener(event_name, (event) => {
                                        if (!this.smartOfferShown) {
                                            exit_intent_so_fire(event, event_name);
                                        }
                                    }, { once: true });
                                });
                                document.addEventListener('mousemove', (event) => {
                                    if (!this.smartOfferShown && event.clientY <= 0) {
                                        exit_intent_so_fire(event, 'mousemove');
                                    }
                                }, false);
                            }
                        }
                    }, 500);
                    if (enabledForPageType) {
                        sMedia.debugLog(`sMedia: Smart offer is enabled for this page in config ==> '${this.so_config.name}' and hence other configs will be ignored in this page.`);
                        break;
                    }
                }
            }
            unbindOnclickAttr(selector) {
                const elements = sMedia.dom.find(selector);
                elements.each(function (element) {
                    if (element) {
                        const clone = element.cloneNode();
                        while (element.firstChild) {
                            clone.appendChild(element.firstChild);
                        }
                        element.parentNode.replaceChild(clone, element);
                        const had_onclick = sMedia.dom.find(selector).attr("onclick");
                        if (typeof had_onclick !== typeof undefined && !!had_onclick) {
                            sMedia.dom.find(selector).attr("smedia-click-was", had_onclick);
                            sMedia.dom.find(selector).removeAttr("onclick");
                            console.log("kicked out events");
                        }
                    }
                });
                sMedia.dom.find(selector).unbind("click");
            }
            getDropDown(fifth) {
                fifth.option.sort();
                let allOptions = `<option class="sm-dropdown-option" value="" disabled selected>${fifth.placeholder}</option>`;
                fifth.option.forEach((element) => {
                    allOptions += `<option value="${element}" class="sm-dropdown-option">${element}</option>`;
                });
                const fifthDropDown = `<div class="${this.video ? `sm-col sm-col-extra-form` : `sm-row`}">
				${this.video ? '' : `<label for="sm-fifth">${fifth.text}</label>`}
				<select class="sm-fifth-dropdown placeholder"
				${this.video ? `style="padding-top: 2px !important; padding-bottom: 2px !important;"` : `style="line-height: normal !important"`}
				name="fifth" id="sm-fifth"
				${fifth.required ? 'required' : ''}>
					${allOptions}
				</select>
			</div>`;
                return fifthDropDown;
            }
            getHtml(domConfig, carDataParam, browser) {
                const forthOrFifth = (this.so_config.extraForm.fourth.show || this.so_config.extraForm.fifth.show);
                const eitherExtraForm = forthOrFifth || (this.thisIsResume && !forthOrFifth);
                const first = this.so_config.basicForm.first;
                const second = this.so_config.basicForm.second;
                const third = this.so_config.basicForm.third;
                const carTitle = carDataParam ? `${carDataParam.year} ${carDataParam.make} ${carDataParam.model}`.replaceAll('undefined', '').trim().ucwords() : '';
                const trafficSource = sMedia.Cookie.get('__utmzz');
                const fourth = this.so_config.extraForm.fourth;
                const forthField = fourth.show ?
                    `<div class="${this.video ? `sm-col sm-col-extra-form` : `sm-row`}">
				${this.video ? '' : `<label for="sm-fourth">${fourth.text}</label>`}
				<input type="text" id="sm-fourth" class="${this.video ? `ibm-font` : ''} sm-text smart-offer-input-field" name="fourth"
				value="${fourth.value.current_vdp ? carTitle : ""}"
				placeholder="${fourth.value.placeholder}"
				${fourth.required ? 'required' : ''}>
			</div>` : "";
                const fifth = this.so_config.extraForm.fifth;
                const fifthField = fifth.show ?
                    ((fifth.type == 'dropdown' && fifth.option.length) ?
                        this.getDropDown(fifth)
                        :
                            `<div class="${this.video ? `sm-col sm-col-extra-form` : `sm-row`}">
				${this.video ? '' : `<label for="sm-fifth">${fifth.text}</label>`}
				<input type="${fifth.type}" id="sm-fifth" class="${this.video ? `ibm-font` : ''} sm-${fifth.type} smart-offer-input-field" name="fifth"
				value="" placeholder="${fifth.placeholder}" ${fifth.required ? 'required' : ''}>
			</div>`) : "";
                const resumeDiv = this.thisIsResume ?
                    `<div class="sm-row">
				<label for="sm-resume">${this.so_config.extraForm.resume.text}</label>
				<input type="file" id="sm-resume" name="sm-resume" class="sm-resume sm-file smart-offer-input-field" required
				accept="image/jpeg image/png image/jpg application/pdf application/msword application/vnd.openxmlformats-officedocument.wordprocessingml.document">
				<sub class="resume-declaration">Please upload doc, docx, pdf, jpg or png file only with max size 5 MB<sub>
			</div>`
                    : "";
                const imageForm = `<div class="sm-row">
				<label for="sm-first">${first.label}</label>
				<input type="${first.type}" id="sm-first" class="sm-${first.type} smart-offer-input-field" name="first" placeholder="${first.placeholder}" value="" ${first.required ? 'required' : ''}>
			</div>
			<div class="sm-row">
				<label for="sm-second">${second.label}</label>
				<input type="${second.type}" id="sm-second" class="sm-${second.type} smart-offer-input-field" name="second" placeholder="${second.placeholder}" value="" ${second.required ? 'required' : ''}>
			</div>
			<div class="sm-row">
				<label for="sm-third">${third.label}</label>
				<input type="${third.type}" id="sm-third" class="sm-${third.type} smart-offer-input-field" name="third" placeholder="${third.placeholder}" value="" ${third.required ? 'required' : ''}>
			</div>
			${forthField}
			${fifthField}
			${resumeDiv}
			<div class="sm-row">
				<button class="sm-lead-submit-btn">${this.so_config.buttonText.toUpperCase()}</button>
			</div>`;
                const videoForm = `<div class="sm-row">
				<div class="sm-col">
					<input type="${first.type}" id="sm-first" class="ibm-font sm-${first.type} smart-offer-input-field" name="first" placeholder="${first.placeholder}" value="" ${first.required ? 'required' : ''}>
				</div>
				<div class="sm-col">
					<input type="${second.type}" id="sm-second" class="ibm-font sm-${second.type} smart-offer-input-field" name="second" placeholder="${second.placeholder}" value="" ${second.required ? 'required' : ''}>
				</div>
			</div>
			<br class="video-form-break">
			<div class="sm-row">
				<div class="sm-col">
					<input type="${third.type}" id="sm-third" class="ibm-font sm-${third.type} smart-offer-input-field" name="third" placeholder="${third.placeholder}" value="" ${third.required ? 'required' : ''}>
				</div>
				<div class="sm-col">
					<button class="sm-lead-video-submit-btn sm-lead-submit-btn">${this.so_config.buttonText.toUpperCase()}</button>
				</div>
			</div>`;
                const videoFormWithExtraFields = `<div class="sm-row">
				<div class="sm-col sm-col-extra-form">
					<input type="${first.type}" id="sm-first" class="ibm-font sm-${first.type} smart-offer-input-field" name="first" placeholder="${first.placeholder}" value="" ${first.required ? 'required' : ''}>
				</div>
				<div class="sm-col sm-col-extra-form">
					<input type="${second.type}" id="sm-second" class="ibm-font sm-${second.type} smart-offer-input-field" name="second" placeholder="${second.placeholder}" value="" ${second.required ? 'required' : ''}>
				</div>
				<div class="sm-col sm-col-extra-form">
					<input type="${third.type}" id="sm-third" class="ibm-font sm-${third.type} smart-offer-input-field" name="third" placeholder="${third.placeholder}" value="" ${third.required ? 'required' : ''}>
				</div>
			</div>
			<br class="video-form-break">
			<div class="sm-row">
				${forthField}
				${fifthField}
				<div class="sm-col sm-col-extra-form">
					<button class="sm-lead-submit-btn sm-lead-video-submit-btn">${this.so_config.buttonText.toUpperCase()}</button>
				</div>
			</div>`;
                const disclaimer = (this.so_config.disclaimer && this.so_config.disclaimer.length) ?
                    `<div class="sm-disclaimer" id= "sm-disclaimer">
				<i>*${this.so_config.disclaimer}</i>
			</div>`
                    : "";
                const hidden_forms = `<div class="so-hidden-inputs" id="so-hidden-inputs">
				<input type="hidden" name="dealership" id="dealership" value="${domConfig.cron || ""}">
				<input type="hidden" name="stock_type" id="stock_type" value="${carDataParam.stock_type || ""}">
				<input type="hidden" name="year" id="year" value="${carDataParam.year || ""}">
				<input type="hidden" name="make" id="make" value="${carDataParam.make || ""}">
				<input type="hidden" name="model" id="model" value="${carDataParam.model || ""}">
				<input type="hidden" name="trim" id="trim" value="${carDataParam.trim || ""}">
				<input type="hidden" name="title" id="title" value="${carDataParam.title || carTitle}">
				<input type="hidden" name="url" id="url" value="${carDataParam.url || window.location}">
				<input type="hidden" name="stock_number" id="stock_number" value="${carDataParam.stock_number || ""}">
				<input type="hidden" name="vin" id="vin" value="${carDataParam.vin || ""}">
				<input type="hidden" name="svin" id="svin" value="${carDataParam.svin || ""}">
				<input type="hidden" name="odometer" id="odometer" value="${carDataParam.kilometers || ""}">
				<input type="hidden" name="kilometres" id="kilometres" value="${carDataParam.kilometers || ""}">
				<input type="hidden" name="engine" id="engine" value="${carDataParam.engine || ""}">
				<input type="hidden" name="transmission" id="transmission" value="${carDataParam.transmission || ""}">
				<input type="hidden" name="body_style" id="body_style" value="${carDataParam.body_style || ""}">
				<input type="hidden" name="doors" id="doors" value="${carDataParam.doors || ""}">
				<input type="hidden" name="smedia_smart_lead_uuid" id="smedia_smart_lead_uuid" value="${browser.uniqueUserId || ""}">
				<input type="hidden" name="session_id" id="session_id" value="${browser.sessionId || ""}">
				<input type="hidden" name="referrer" id="referrer" value="${document.referrer || window.location.href}">
				<input type="hidden" name="mongo_dealer_id" id="mongo_dealer_id" value="${domConfig.mongo_dealer_info.id || ""}">
				<input type="hidden" name="template" id="template" value="${this.so_config.template || ""}">
				<input type="hidden" name="config_id" id="config_id" value="${this.so_config.id || ""}">
				<input type="hidden" name="config_name" id="config_name" value="${this.so_config.name || ""}">
				<input type="hidden" name="debug" id="debug" value="${this.debug || ""}">
				<input type="hidden" name="smart-offer-traffic-source" id="smart-offer-traffic-source" value="${trafficSource || ""}">
			</div>`;
                const form_inputs = `${this.video ? (eitherExtraForm ? videoFormWithExtraFields : videoForm) : imageForm}`;
                const form_html = `<div id="sm-form-container">
				<form id="sm-lead-form" name="sm-lead-form" method="post" ${this.thisIsResume ? `enctype="multipart/form-data"` : ""}>
					${hidden_forms}
					${form_inputs}
					${disclaimer}
				</form>
			</div>`;
                const form_spinner = `<div class="sm-row">
				<div id="sm-loading-spinner" class="sm-loading-spinner">
					<img src="${sMedia.apiHost}/adwords3/templates/balls.svg"/>
				</div>
			</div>`;
                const video_title = this.video && !!this.so_config.imgOrVideo.video && !!this.so_config.imgOrVideo.video.title
                    ? `<div class="sm-lead-collect-form-video-title ibm-font">${this.so_config.imgOrVideo.video.title}</div>`
                    : "";
                const video_description = this.video && !!this.so_config.imgOrVideo.video && !!this.so_config.imgOrVideo.video.description
                    ? `<div class="sm-lead-collect-form-video-desc ibm-font">${this.so_config.imgOrVideo.video.description}</div>`
                    : "";
                const image = !this.video
                    ? '<div class="sm-lead-collect-form-image"></div>'
                    : "";
                const smart_offer_form_part = `<div class="sm-lead-collect-form-body">
				${form_html}
				${form_spinner}
			</div>`;
                const smart_memo_heading = `<div id="sm-memo-heading-div" class="">
				<h3 class="sm-memo-h3">${this.so_config.memoSetting.heading.text}</h3>
			</div>`;
                const smart_memo_body = `<div id="sm-memo-body-div" class="sm-memo-body-div">
				<p class="sm-memo-body-text">${this.so_config.memoSetting.body.text}</p>
			</div>`;
                const smart_memo_button = `<div id="sm-memo-submit-btn-div" class="sm-memo-submit-btn-div">
				<button id="sm-memo-submit-btn" class="sm-lead-submit-btn">${this.so_config.memoSetting.button.text}</button>
			</div>`;
                const smart_memo_html = `<div id="sm-form-container">
				<form id="sm-lead-form" method="post" action="${this.leadFormUrl}">
					${hidden_forms}
				</form>
				${this.so_config.memoSetting.heading.show ? smart_memo_heading : ''}
				${this.so_config.memoSetting.body.show ? smart_memo_body : ''}
				${this.so_config.memoSetting.button.show ? smart_memo_button : ''}
			</div>
			`;
                const html_content_image = `<div id="smedia-overlay" style="display:none"></div>
			<div id="smedia-lead-collect-form" class="sm-lead-collect-form so-invisible">
				<button class="sm-close-btn" id="sm-close-btn"></button>
				<div class="sm-lead-collect-form-wrap">
					${image}
					${this.thisIsMemo ? smart_memo_html : smart_offer_form_part}
				</div>
			</div>`;
                const video_width = (document.body.clientWidth >= 640)
                    ? 640
                    : document.body.clientWidth - 16 * 2;
                const video_height = video_width * (9 / 16);
                const html_content_video = `<div id="smedia-overlay" style="display:none"></div>
			<div id="smedia-lead-collect-form" class="sm-lead-collect-form so-invisible">
				<button class="sm-close-btn" id="sm-close-btn"></button>
				<div class="sm-lead-collect-form-wrap">
					<div class="form-true">
						<div class="sm-lead-collect-form-video">
							<video id="sm-lead-video" class="video-js vjs-default-skin" autobuffer="true" autoplay controlslist="nodownload" muted controls width="${video_width}" height="${video_height}"></video>
							${video_title}
							${video_description}
						</div>
						<div class="sm-lead-collect-form-body ${this.so_config.imgOrVideo.video.show_form ? '' : `sm-hidden`}">
							${form_html}
							${form_spinner}
						</div>
					</div>
				</div>
			</div>`;
                const html_content_video_memo = `<div id="smedia-overlay" style="display:none"></div>
			<div id="smedia-lead-collect-form" class="sm-lead-collect-form so-invisible">
				<button class="sm-close-btn" id="sm-close-btn"></button>
				<div class="sm-lead-collect-form-wrap">
					<div class="form-true">
						<div class="sm-lead-collect-form-video">
							<video id="sm-lead-video" class="video-js vjs-default-skin" autobuffer="true" autoplay controlslist="nodownload" muted controls width="${video_width}" height="${video_height}"></video>
						</div>
						<div class="sm-lead-collect-form-body>
							<form id="sm-lead-form" method="post" action="${this.leadFormUrl}">
								${hidden_forms}
							</form>
							${this.so_config.memoSetting.heading.show ? smart_memo_heading : ''}
							${this.so_config.memoSetting.body.show ? smart_memo_body : ''}
							${this.so_config.memoSetting.button.show ? smart_memo_button : ''}
						</div>
					</div>
				</div>
			</div>`;
                return (!this.video ? html_content_image : (this.thisIsMemoVideo ? html_content_video_memo : html_content_video));
            }
            appendHtml(html) {
                if (!this.video) {
                    sMedia.dom.find("body").append(html);
                }
                else {
                    const head = document.getElementsByTagName("head")[0];
                    const video_css = `https://vjs.zencdn.net/7.8.4/video-js.css`;
                    const video_script = `https://vjs.zencdn.net/7.8.4/video.js`;
                    const yt_script = `https://cdn.jsdelivr.net/gh/videojs/videojs-youtube/dist/Youtube.min.js`;
                    sMedia.DomInstaller.InstallStyle(video_css, head, () => {
                        sMedia.DomInstaller.InstallScript(video_script, head, () => {
                            sMedia.DomInstaller.InstallScript(yt_script, head, () => {
                                sMedia.dom.find("body").append(html);
                                this.soVideoReady = true;
                            }, false);
                        }, false);
                    });
                }
            }
            appendCss(options) {
                const forthOrFifth = this.so_config.extraForm.fourth.show || this.so_config.extraForm.fifth.show;
                const eitherExtraForm = forthOrFifth || (this.thisIsResume && !forthOrFifth);
                const bothExtraForm = ((this.so_config.extraForm.fourth.show || this.thisIsResume) && this.so_config.extraForm.fifth.show);
                let btn_gradient = "";
                const BC1 = this.so_config.color.button_color[0];
                const BC2 = this.so_config.color.button_color[1];
                if (this.so_config.color.button_color.length > 1) {
                    btn_gradient =
                        `background-image: -webkit-linear-gradient(top, ${BC1}, ${BC2});
				background-image: -moz-linear-gradient(top, ${BC1}, ${BC2});
				background-image: -ms-linear-gradient(top, ${BC1}, ${BC2});
				background-image: -o-linear-gradient(top, ${BC1}, ${BC2});
				background-image: linear-gradient(to bottom, ${BC1}, ${BC2});`;
                }
                let btn_hover_gradient = "";
                const BCH1 = this.so_config.color.button_color_hover[0];
                const BCH2 = this.so_config.color.button_color_hover[1];
                if (this.so_config.color.button_color_hover.length > 1) {
                    btn_hover_gradient =
                        `background-image: -webkit-linear-gradient(top, ${BCH1}, ${BCH2});
				background-image: -moz-linear-gradient(top, ${BCH1}, ${BCH2});
				background-image: -ms-linear-gradient(top, ${BCH1}, ${BCH2});
				background-image: -o-linear-gradient(top, ${BCH1}, ${BCH2});
				background-image: linear-gradient(to bottom, ${BCH1}, ${BCH2});`;
                }
                let btn_active_gradient = "";
                const BCA1 = this.so_config.color.button_color_active[0];
                const BCA2 = this.so_config.color.button_color_active[1];
                if (this.so_config.color.button_color_active.length > 1) {
                    btn_active_gradient =
                        `background-image: -webkit-linear-gradient(top, ${BCA1}, ${BCA2});
				background-image: -moz-linear-gradient(top, ${BCA1}, ${BCA2});
				background-image: -ms-linear-gradient(top, ${BCA1}, ${BCA2});
				background-image: -o-linear-gradient(top, ${BCA1}, ${BCA2});
				background-image: linear-gradient(to bottom, ${BCA1}, ${BCA2});`;
                }
                const padding_bottom = (sMedia.Context.DomainConfig.cron == "autoparkbarrie") ? "40px" : "0px";
                let css = !!options.dynamic
                    ? `.sm-lead-collect-form {
					background-color: ${this.so_config.color.bg_color};
					${this.video ? `max-width: calc( 100vw - 32px );` : ``}
				}
				.sm-lead-collect-form-image {
					background-image: url('${options.bgFileUrl}');
				}
				${this.video ?
                        `.sm-row {
						display: flex;
						flex-direction: row;
						margin-left: -8px;
						width: calc( 100% + 16px );
					}
					#sm-lead-form {
						width: 100%;
						padding: 24px 32px;
					}
					.sm-lead-collect-form-video-desc {
						padding: 16px 32px;
						background-color: ${this.so_config.color.bg_color};
						color: ${this.so_config.color.text_color};
						font-size: 11px;
						line-height: 13px;
						font-style: normal;
						font-weight: 600;
						margin: 0;
					}
					.sm-lead-collect-form-video-title {
						color: #162433;
						font-size: 24px;
						padding: 24px 32px 0 32px;
						text-align: center;
						font-style: normal;
						font-weight: 600;
						line-height: 31px;
						margin: 0;
					}
					.sm-row .sm-col {
						width: 50%;
						padding: 0 8px
					}
					.sm-row .sm-col.sm-col-extra-form {
						width: 33.33%;
						padding: 0 8px
					}
					.video-js {
						width: 100% !important;
						position: relative;
						padding-bottom: 56.25% !important; /* 16:9 */
						height: 0 !important;
					}
					.sm-lead-collect-form-video .video-js .vjs-big-play-button {
						top: 50%;
						left: 50%;
						transform-origin: 50% 50%;
						transform: translate(-50%, -50%);
					}
					.sm-lead-collect-form-body form input,
					.sm-lead-collect-form-body form select {
						width: 100%;
						box-sizing: border-box;
						border: none;
						background: #ffffff;
						line-height: 52px;
						padding: 0 16px;
						color: #6A6D79;
						font-style: normal;
						font-weight: 400;
						font-size: 24px;
						margin: 0;
					}`
                        :
                            `.sm-row {
						margin: ${this.thisIsMemo ? `5px 0px` : `15px 0px`};
					}
					.sm-lead-collect-form-body {
						width: 401px;
						height: 450px;
						float: left;
						overflow: hidden;
					}
					.sm-lead-collect-form-body form {
						width: 87% !important;
						margin: ${eitherExtraForm ? (bothExtraForm ? '11px 0px 0px 27px !important' : '20px 27px !important') : '27px !important'};
					}`}
				.sm-lead-collect-form-body form label {
					color: ${this.so_config.color.text_color};
				}
				.sm-lead-collect-form-body form input,
				.sm-lead-collect-form-body form select {
					border: solid ${this.so_config.color.border_color} 2px;
					color: 	#28282B !important; /* MATTE BLACK */
				}
				.sm-lead-submit-btn {
					background: ${this.so_config.color.button_color[0]};
					${btn_gradient}
					color: ${this.so_config.color.button_text_color};
					border: solid ${this.so_config.color.border_color} 2px;
					${this.thisIsResume ? `margin: 0 !important;` : ''}
					${eitherExtraForm ? `font-size: 14px;` : ''}
				}
				.sm-lead-submit-btn:hover {
					background: ${this.so_config.color.button_color_hover[0]};
					${btn_hover_gradient}
				}
				.sm-lead-submit-btn:active {
					background: ${this.so_config.color.button_color_active[0]};
					${btn_active_gradient}
				}
				.sm-lead-submit-btn:disabled {
					background: ${this.so_config.color.button_color_hover[0]};
					${btn_hover_gradient}
				}
				.sm-fifth-dropdown {
					background-image: none;
					background-origin: unset;
					background-position: unset;
					background-repeat: unset;
					background-size: unset;
					line-height: normal !important;
				}
				.sm-dropdown-option {
				}
				.sm-fifth-dropdown-resume {
					/* padding: 0 10px !important; */
				}
				.sm-dropdown-option-resume {
				}




				@media (orientation: landscape) and (min-width: 900px) {

				}

				@media (orientation: landscape) and (max-width: 900px) {
					${this.video ?
                        `.sm-lead-collect-form-wrap > div {
						display: block;
					}
					.sm-lead-collect-form-video {
						flex-grow: 1;
						display: flex;
						flex-direction: column;
					}
					.sm-lead-collect-form-video-desc {
						flex-grow: 1;
					}
					.sm-lead-collect-form-body {
						width: 40%;
						display: flex;
						flex-direction: column;
						justify-content: center;
					}
					.sm-row {
						flex-direction: column;
					}
					.sm-row .sm-col {
						width: 100%;
						margin: 10px 0;
					}
					.sm-row .sm-col.sm-col-extra-form {
						width: 100%;
						margin: 10px 0;
					}` : ``}
				}

				@media screen and (max-width: 667px) {
					${this.video ?
                        `#sm-lead-form,
					.sm-lead-collect-form-video-desc,
					.sm-lead-collect-form-video-title {
						padding: 24px;
					}
					.sm-lead-collect-form-video-title {
						padding-bottom: 0;
					}
					.sm-row {
						flex-direction: column;
					}
					.sm-row .sm-col {
						width: 100%;
						margin: 10px 0;
					}
					.sm-row .sm-col.sm-col-extra-form {
						width: 100%;
						margin: 10px 0;
					}
					.sm-lead-collect-form-video-desc {
						font-size: 10px;
					}
					.sm-lead-collect-form-video-title {
						font-size: 24px;
					}
					.sm-lead-collect-form {
						width: calc( 100% - 32px );
						height: auto;
						padding-bottom: ${padding_bottom};
					}
					.sm-lead-collect-form-body form input,
					.sm-lead-collect-form-body form button,
					.sm-lead-collect-form-body form select {
						font-size: ${bothExtraForm ? '14px' : '18px'};
						line-height: 42px;
					}
					.sm-lead-collect-form-body form button {
						line-height: 38px;
					}` : ``}
				}

				@media (orientation: landscape) and (max-height: 450px) {
					${this.video ?
                        `.sm-lead-collect-form-body form input,
					.sm-lead-collect-form-body form button,
					.sm-lead-collect-form-body form select {
						font-size: 16px;
						line-height: 36px;
					}
					.sm-lead-collect-form-body form button{
						line-height: 32px;
					}
					.sm-row .sm-col {
						margin: 6px 0;
					}` : ``}
				}

				@media screen and (max-width: 449px) {
					.sm-lead-collect-form {
						padding-bottom: ${padding_bottom};
					}
				}

				@media (orientation: portrait) and (max-width: 400px) {
					${this.video ?
                        `.sm-lead-collect-form-body form input,
					.sm-lead-collect-form-body form button,
					.sm-lead-collect-form-body form select {
						line-height: 30px;
					}
					.sm-row .sm-col {
						margin: 10px 0;
					}
					.sm-lead-collect-form-video-title {
						line-height: 1.2;
					}` : ``}
				}`
                    : "";
                css += !!options.dynamic
                    ? ""
                    : `.so-invisible {
					left: -100% !important;
					opacity: 0 !important;
					z-index: -10000 !important;
				}
				.so-hidden-inputs {
					display: none;
				}
				#smedia-overlay {
					position:fixed;
					width:100%;
					height:100%;
					top: 0px;
					left: 0px;
					display: none;
					z-index: 4999999999;
					background: #000000;
					opacity: 0.5;
				}
				.sm-lead-collect-form {
					position:fixed;
					font-family: Helvetica !important;
					font-size: ${bothExtraForm ? '14px' : '18px'};
					width: 900px;
					height: auto;
					top: 50%;
					left: 50%;
					z-index: 5000000000;
					max-height: 100%;
					transform-origin: 50% 50%;
					transform: translate(-50%, -50%);
					letter-spacing: normal !important;
				}
				.sm-lead-collect-form-wrap {
					display: flex;
					max-height: calc( 100vh - 32px );
					overflow: hidden;
					overflow-y: auto;
				}
				.sm-lead-collect-form-image {
					width: 499px;
					height: 450px;
					background-repeat: no-repeat;
					background-position: center center;
					float: left;
				}
				.sm-lead-collect-form-body form input,
				.sm-lead-collect-form-body form select,
				.sm-lead-collect-form-body form button,
				.sm-lead-collect-form-body form label {
					width: 100%;
					display: inline-block;
					font-weight: bold;
					height: auto !important;
					border-radius: 7px;
				}
				.sm-lead-collect-form-body form label {
					font-size: ${bothExtraForm ? '14px' : '16px'};
					margin: 0 !important;
					padding: 0 !important;
				}
				.sm-lead-collect-form-body form input,
				.sm-lead-collect-form-body form select {
					width: 100%;
					padding: 0px 10px !important;
					line-height: 36px !important;
					margin: 10px 0px;
					background-color: #ffffff;
				}
				.sm-lead-collect-form-body form select {
					padding: 12px;
				}
				.sm-lead-submit-btn {
					text-decoration: none;
					line-height: 36px !important;
					display: inline-block;
					text-align: center;
					cursor: pointer;
					margin-top: 15px;
				}
				.sm-lead-submit-btn:hover {
					text-decoration: none;
				}
				.sm-lead-submit-btn:active {
					text-decoration: none;
				}
				.sm-lead-submit-btn:disabled {
					text-decoration: none;
				}
				.sm-close-btn {
					width: 39px;
					height: 39px;
					line-height: 39px;
					cursor: pointer;
					position: absolute !important;
					background-color: #000;
					text-align: center;
					display: inline-block;
					font-size: 23px;
					font-style: normal;
					color: #fff;
					font-family: Helvetica;
					top: -20px;
					right: -20px;
					margin: 0;
					border-radius: 100%;
					border: 1px solid #fff;
					padding: 0;
					z-index: 9999;
				}
				.sm-close-btn::after {
				  content: "X";
				  text-transform: uppercase;
				}
				.sm-close-btn:hover {
				  text-decoration: none;
				}
				.sm-loading-spinner {
					width: 36px;
					height: 36px;
					margin: -10px auto;
					display: none;
				}
				.sm-lead-video-submit-btn {
					margin-top: 3px !important;
					line-height: 32px !important;
					padding: ${bothExtraForm ? `0 !important` : `2px 0 !important`};
				}
				.sm-hidden {
					display: none;
				}
				.sm-static-lead-form {
					z-index: 0 !important;
					position: static;
					transform: none;
				}



				/* DISCLAIMER bothExtraForm eitherExtraForm */
				.sm-disclaimer {
					font-size: 8px;
					color: ${this.so_config.color.disclaimer_color};
					font-weight: normal;
					line-height: 80%;
					margin-top: 5px;
					padding: 2px;
				}


				/* RESUME */
				.sm-resume {
				}

				.resume-declaration {
					padding: 0;
					margin: 0;
					color: ${this.so_config.color.text_color};
					bottom: 0;
					top: -10px;
					font-style: italic;
					font-size: 10px;
				}


				/* SMART MEMO CSS */
				#sm-memo-heading-div {
					text-align: center;
				}

				.sm-memo-h3 {
					margin: 0;
					padding: 18px 32px 0 32px;
					font-family: Helvetica;
					font-size: 22px;
					color: ${this.so_config.color.heading_text_color};
				}

				.sm-memo-body-div {
					text-align: justify;
					font-size: 11px;
					line-height: 13px;
					padding: 10px 30px;
					font-style: normal;
					font-weight: 600;
					line-break: auto;
					margin: 0;
				}

				.sm-memo-body-text {
					margin: 0;
					letter-spacing: normal;
					color: ${this.so_config.color.body_text_color};
				}

				.sm-memo-submit-btn-div {
					margin: 0 !important;
					border-bottom-left-radius: 10px;
					border-bottom-right-radius: 10px;
					display: flex;
					justify-content: center;
					align-items: center;
				}

				.sm-first {
				}
				.sm-second {
				}
				.sm-third {
				}
				.sm-fourth {
				}
				.sm-fifth {
				}
				.smart-offer-input-field {
				}

				#sm-memo-submit-btn {
					position: relative;
					height: 44px;
					margin: 8px;
					padding: 0 20px;
					border-radius: 10px;
					font-size: 18px;
					min-width: 150px;
				}



				@media screen and (min-width: 901px) {
					.sm-lead-collect-form-wrap {
						${(this.thisIsMemo || this.video) ? `display: block;` : `display: flex;`}
					}
					.sm-lead-collect-form-body {
						width: 100%;
					}
					.sm-lead-collect-form {
						${this.thisIsMemo ? `width: 499px;` : ``}
					}

					.sm-lead-collect-form-image {
						${this.thisIsMemo ? `float: none;` : ``}
					}
				}

				@media screen and (min-width: 768px) and (max-width: 900px) {
					.sm-lead-collect-form-wrap {
						display: block;
					}
					.sm-lead-collect-form {
						width: 499px;
					}
					.sm-lead-collect-form-body {
						width: 499px !important;
					}
					.sm-lead-collect-form-image {
						float: none;
					}
				}

				@media screen and (min-width: 450px) and (max-width: 767px) {
					.sm-lead-collect-form-wrap {
						display: block;
					}
					.sm-lead-collect-form {
						width: 499px;
						height: auto;
					}
					.sm-lead-collect-form-body {
						width: 499px !important;
					}
					.sm-lead-collect-form-image {
						float: none;
					}

					${this.video ?
                        `.sm-row {
						display: block;
					}
					.sm-row .sm-col {
						width: 100%;
					}
					.video-form-break {
						display: none;
					}` : ``}
				}

				@media screen and (max-width: 449px) {
					.sm-lead-collect-form-wrap {
						display: block;
					}
					.sm-close-btn {
						top: 5px;
						right: 5px;
					}

					#sm-form-container {
						width: 100%;
						max-width: 360px;
					}

					.sm-lead-collect-form {
						width: 96%;
						max-width: 360px;
						height: auto;
					}

					.sm-lead-collect-form-image {
						width: 100%;
						max-width: 360px;
						height: 325px;
						background-size: 360px 325px;
						float: none;
					}

					.sm-lead-collect-form-body form input,
					.sm-lead-collect-form-body form select {
						width: 100%;
					}




					${this.video ?
                        `.sm-row {
						display: block;
					}
					.sm-row .sm-col {
						width: 100%;
					}
					.video-form-break {
						display: none;
					}` : ``}
				}`;
                if (eitherExtraForm) {
                    css +=
                        `.sm-row {
					margin: 0px !important;
					padding: 0px 1px !important;
				}
				.sm-lead-collect-form-body form input,
				.sm-lead-collect-form-body form select {
					${this.thisIsResume ? `margin: 8px 0px !important` : ''};
				}`;
                    if (bothExtraForm) {
                        css +=
                            `.sm-lead-collect-form-body form input,
					.sm-lead-collect-form-body form select {
						margin:3px 0px 9px 0px !important;
						line-height: 32px !important;
					}
					.sm-lead-collect-form-body form select {
						${this.video ? '' : `padding: 9px !important`};
					}`;
                    }
                    else {
                        css +=
                            `.sm-lead-collect-form-body form select {
						padding: 8px !important;
					}`;
                    }
                }
                css +=
                    `input.smart-offer-input-field::-webkit-input-placeholder {
				color: #8c8c8c;
				font-style: normal;
				font-weight: normal;
				font-size: 12px;
			}
			input.smart-offer-input-field::-ms-input-placeholder {
				color: #8c8c8c;
				font-style: normal;
				font-weight: normal;
				font-size: 12px;
			}
			input.smart-offer-input-field::placeholder {
				color: #8c8c8c;
				font-style: normal;
				font-weight: normal;
				font-size: 12px;
			}
			/* ::placeholder {
				color: #8c8c8c;
				font-style: normal;
				font-weight: normal;
				font-size: 12px;
			} */
			.placeholder {
				color: #8c8c8c !important;
				font-style: normal;
				font-weight: normal !important;
				/* font-size: inherit; */
				font-size: 12px;
				line-height: normal !important;
			}`;
                const smartOfferStyleElement = `<style id="smedia-smart-offer-style-${options.dynamic ? "dynamic" : "static"}">${css}</style>`;
                sMedia.dom.find("body").append(smartOfferStyleElement);
            }
            bindSmartMemoEvents() {
                sMedia.dom.find("#sm-memo-submit-btn").click(() => {
                    window.open(this.so_config.memoSetting.button.redirect_url, '_blank');
                    this.smartOfferLead.submitMemoClick();
                });
            }
        }
        Modules.smartOffer = new SmartOffer();
        sMedia.Context.OnReady(() => {
            Modules.smartOffer.Register();
        });
        sMedia.Context.OnClose(() => {
            Modules.smartOffer.Unregister();
        });
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class SmartOfferLead {
            constructor(so_config, sessionStorage, persistentStorage, leadFormUrl, storagePrefix) {
                this.form = null;
                this.initialized = false;
                this.closeTimeoutID = null;
                this.initialForm = null;
                this.uniqueUserId = sMedia.Context.Browser.uniqueUserId;
                this.cron = sMedia.Context.DomainConfig.cron;
                this.sessionId = sMedia.Context.Browser.sessionId;
                this.carDataParam = sMedia.Context.PageData.car_data;
                this.defaultPayload = {
                    mongo_dealer_id: sMedia.Context.DomainConfig.mongo_dealer_info.id || "",
                    service: "smart-offer",
                    uuid: this.uniqueUserId,
                    session: this.sessionId,
                    url: window.location.href,
                    dealership: this.cron,
                    browser: sMedia.Context.BrowserName,
                    template: '',
                    smId: '',
                    config_name: '',
                    svin: this.carDataParam ? this.carDataParam.svin : "",
                    carInfo: {
                        stock_type: this.carDataParam ? this.carDataParam.stock_type : "",
                        year: this.carDataParam ? this.carDataParam.year : "",
                        make: this.carDataParam ? this.carDataParam.make : "",
                        model: this.carDataParam ? this.carDataParam.model : "",
                        stock_no: this.carDataParam ? this.carDataParam.stock_number : "",
                        trim: this.carDataParam ? this.carDataParam.trim : "",
                        body_style: this.carDataParam ? this.carDataParam.body_style : "",
                        transmission: this.carDataParam ? this.carDataParam.transmission : "",
                        odo_status: (this.carDataParam && this.carDataParam.stock_type == "new") ? "original" : "unknown",
                        odometer: this.carDataParam ? this.carDataParam.kilometres : "",
                    }
                };
                this.so_config = so_config;
                this.sessionStorage = sessionStorage;
                this.persistentStorage = persistentStorage;
                this.leadFromUrl = leadFormUrl;
                this.storagePrefix = storagePrefix;
                this.defaultPayload.template = this.so_config.template;
                this.defaultPayload.smId = this.so_config.id;
                this.defaultPayload.config_name = this.so_config.name;
            }
            init() {
                const that = this;
                sMedia.dom.find("#smedia-overlay").click(() => {
                    that.close(true);
                });
                sMedia.dom.find("#sm-close-btn").click(() => {
                    that.close(true);
                });
                sMedia.dom.find("#sm-lead-form").submit(function (e) {
                    e.preventDefault();
                    const form = this;
                    let allowSubmit = true;
                    const smDebug = sMedia.getValueById('debug');
                    const smReferrer = sMedia.getValueById('referrer');
                    const trafficSource = sMedia.getValueById('smart-offer-traffic-source');
                    const smFirst = sMedia.getValueById('sm-first');
                    const smSecond = sMedia.getValueById('sm-second');
                    const smThird = sMedia.getValueById('sm-third');
                    const basicForm = that.so_config.basicForm;
                    const typeValue = {
                        [basicForm.first.type]: smFirst,
                        [basicForm.second.type]: smSecond,
                        [basicForm.third.type]: smThird
                    };
                    const smName = typeValue['text'];
                    const smEmail = typeValue['email'];
                    const smPhone = typeValue['tel'];
                    const smFourth = sMedia.getValueById('sm-fourth');
                    const smFifth = sMedia.getValueById('sm-fifth');
                    if (sMedia.isEmptyString(smName)) {
                        allowSubmit = false;
                        document.getElementById('sm-first').value = '';
                        alert("Name is required.");
                    }
                    if (sMedia.isEmptyString(smFifth)) {
                        const fifthSetting = !!(that.so_config && that.so_config.extraForm) ? that.so_config.extraForm.fifth : null;
                        if (fifthSetting &&
                            fifthSetting.show &&
                            fifthSetting.required &&
                            fifthSetting.type == 'dropdown') {
                            allowSubmit = false;
                            alert(`'${fifthSetting.text}' is required.`);
                        }
                    }
                    let contentType = "application/json";
                    let submitPayload;
                    if (that.so_config.template == "Smart Resume") {
                        that.leadFromUrl = that.leadFromUrl.replace('/new/', '/new-resume/');
                        contentType = "multipart/form-data";
                        const formData = new FormData();
                        formData.append('action', 'submit');
                        formData.append('mongo_dealer_id', that.defaultPayload.mongo_dealer_id);
                        formData.append('uuid', that.uniqueUserId);
                        formData.append('session', that.sessionId);
                        formData.append('url', window.location.href);
                        formData.append('dealership', that.cron);
                        formData.append('referrer', smReferrer);
                        formData.append('trafficSource', trafficSource);
                        formData.append('template', that.defaultPayload.template);
                        formData.append('smId', that.defaultPayload.smId);
                        formData.append('config_name', that.defaultPayload.config_name);
                        formData.append('name', smName);
                        formData.append('email', smEmail);
                        formData.append('phone', smPhone);
                        formData.append('fifth', smFifth);
                        const files = document.getElementById('sm-resume').files;
                        if (files && files[0]) {
                            const cvFile = files[0];
                            const cvName = cvFile.name;
                            const cvType = cvFile.type;
                            const cvSize = cvFile.size;
                            if (cvSize > 5000000) {
                                document.getElementById('sm-resume').value = '';
                                alert("File size larger than 5 mb");
                                allowSubmit = false;
                            }
                            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                            if (!allowedTypes.includes(cvType)) {
                                document.getElementById('sm-resume').value = '';
                                alert("Please upload doc, pdf, jpg or png file only with max size 5 MB");
                                allowSubmit = false;
                            }
                            formData.append('resume', cvFile, cvName);
                        }
                        submitPayload = formData;
                    }
                    else {
                        const extraPayload = {
                            action: "submit",
                            debug: smDebug,
                            referrer: smReferrer,
                            name: smName,
                            email: smEmail,
                            phone: smPhone,
                            trafficSource: trafficSource,
                            fourth: smFourth,
                            fifth: smFifth
                        };
                        submitPayload = { ...that.defaultPayload, ...extraPayload };
                    }
                    if (allowSubmit) {
                        that.disable(form);
                        new sMedia.Ajax().Post(that.leadFromUrl, submitPayload, (resp) => {
                            sMedia.storeSmartOfferSubmit(that.so_config, that.persistentStorage, that.storagePrefix);
                            sMedia.sendSoSubmitGA();
                            if (resp.success) {
                                const thankYouHtml = `<h2 style="margin: 100px 25px; text-align: center;">${that.so_config.thank_you}</h2>`;
                                sMedia.dom.find("#sm-form-container").html(thankYouHtml);
                            }
                            else {
                                console.error(`sMedia: Lead submit failed`, resp);
                            }
                            that.enable(form);
                            setTimeout(() => {
                                that.close(false);
                            }, 3000);
                        }, null, contentType);
                    }
                });
                this.initialized = true;
            }
            delayClose() {
                if (sMedia.dom.find("#sm-lead-form").serialize() !== this.initialForm) {
                    if (this.closeTimeoutID) {
                        clearTimeout(this.closeTimeoutID);
                    }
                    return;
                }
                this.close(true);
            }
            show() {
                if (!this.initialized) {
                    this.init();
                }
                sMedia.sendSoShownGA();
                sMedia.dom.find("#smedia-overlay").css("display", "block");
                sMedia.dom.find("#smedia-lead-collect-form").removeClass("so-invisible");
                this.initialForm = "";
                const extraPayload = {
                    action: "view",
                    debug: sMedia.getValueById('debug'),
                    referrer: sMedia.getValueById('referrer')
                };
                const viewPayload = { ...this.defaultPayload, ...extraPayload };
                new sMedia.Ajax().Post(this.leadFromUrl, viewPayload, (resp) => {
                    if (resp) {
                        sMedia.storeOfferShown(this.persistentStorage, this.storagePrefix);
                    }
                }, null, "application/json");
                sMedia.increaseShowCount(this.sessionStorage, this.persistentStorage, this.storagePrefix);
                this.bindSmartOfferEvents();
            }
            close(sendData = true) {
                if (sendData == true) {
                    const extraPayload = {
                        action: "close",
                        debug: sMedia.getValueById('debug'),
                        referrer: sMedia.getValueById('referrer')
                    };
                    new sMedia.Ajax().Post(this.leadFromUrl, { ...this.defaultPayload, ...extraPayload }, (resp) => {
                        if (resp && resp.response) {
                            console.log("sMedia: Smart Offer Closed");
                        }
                    }, null, "application/json");
                }
                sMedia.dom.find("#smedia-overlay").css("display", "none");
                sMedia.dom.find("#smedia-lead-collect-form").addClass("so-invisible");
            }
            submitMemoClick() {
                const extraPayload = {
                    action: "click",
                    debug: sMedia.getValueById('debug'),
                    referrer: sMedia.getValueById('referrer')
                };
                new sMedia.Ajax().Post(this.leadFromUrl, { ...this.defaultPayload, ...extraPayload }, (resp) => {
                    if (resp && resp.response) {
                        console.log("sMedia: Smart Memo Clicked.");
                    }
                }, null, "application/json");
                this.close(false);
            }
            disable(form) {
                sMedia.dom.find(form).find("input").attr("disabled", "disabled");
                sMedia.dom.find(form).find("button").attr("disabled", "disabled");
                sMedia.dom.find("#sm-loading-spinner").css("display", "block");
            }
            enable(form) {
                sMedia.dom.find(form).find("input").removeAttr("disabled");
                sMedia.dom.find(form).find("button").removeAttr("disabled");
                sMedia.dom.find("#sm-loading-spinner").css("display", "none");
            }
            bindSmartOfferEvents() { }
        }
        Modules.SmartOfferLead = SmartOfferLead;
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class SmartProfiler {
            constructor() {
                this.debug = false;
                this.soVideoReady = false;
                this.readyToShow = false;
                this.smartProfilerReady = true;
                this.showSmartProfiler = false;
                this.smartProfilerShown = false;
                this.sessPageVisits = 0;
                this.storagePrefix = 'sp';
                this.fireSmartProfiler = (enabledForPageType, player, firedByTimer = false) => {
                    if ((this.debug || this.showSmartProfiler) && enabledForPageType && !(firedByTimer && this.smartProfilerShown)) {
                        const rwait = setInterval(() => {
                            if (this.readyToShow && !sMedia.multipleInputsInViewPort() && !window.preventSO) {
                                clearInterval(rwait);
                                if (this.video) {
                                    player.play();
                                    setTimeout(() => {
                                        if (player.paused()) {
                                            player.muted(true);
                                            player.play();
                                        }
                                    }, 500);
                                }
                                this.smartProfilerLead.show();
                                this.smartProfilerShown = true;
                                this.exitIntentClose();
                                this.setInactivity();
                            }
                            else {
                                sMedia.debugLog(`sMedia: Smart Profiler is either not ready or other form visible`);
                            }
                        }, 2000);
                    }
                };
            }
            Register() {
                if (!sMedia.Context.DebugFlags.smartOffer) {
                    this.init();
                }
            }
            Unregister() { }
            init() {
                const browser = sMedia.Context.Browser;
                const pageType = sMedia.Context.PageType;
                this.debug = sMedia.Context.DebugFlags.smartProfiler;
                const domConfig = sMedia.Context.DomainConfig;
                const apiServer = sMedia.Context.DomainConfig.smedia_domains.smedia_api;
                this.leadFormUrl = `${apiServer}/v1/sp-lead-public/${domConfig.mongo_dealer_info.id}/`;
                const carDataParam = (sMedia.Context.PageData.car_data || {});
                const smartProfilers = (domConfig.services || {}).smart_profiler || [];
                const defaultConfigs = {
                    pages: {
                        all: false,
                        home: true,
                        new: false,
                        used: false,
                        certified: false,
                        customVDP: false,
                        otherPage: false,
                    },
                    customVDP: {
                        stockType: [],
                        year: [],
                        make: [],
                        model: [],
                        regex: []
                    },
                    basicForm: {
                        first: {
                            label: 'Name',
                            type: 'text',
                            placeholder: 'Enter Your Name',
                            required: true
                        },
                        second: {
                            label: 'Email',
                            type: 'email',
                            placeholder: 'Enter Email Address',
                            required: true
                        },
                        third: {
                            label: 'Phone',
                            type: 'tel',
                            placeholder: 'Enter Phone Number',
                            required: true
                        }
                    },
                    extraForm: {
                        fourth: {
                            value: {
                                current_vdp: false,
                                placeholder: "Year Make Model"
                            },
                            show: false,
                            text: "New Car Info",
                            required: false,
                            show_car_option: false
                        },
                        fifth: {
                            show: false,
                            text: "Location",
                            required: false,
                            type: "dropdown",
                            placeholder: "Preferred Location",
                            option: []
                        }
                    },
                    color: {
                        bg_color: "#EFEFEF",
                        text_color: "#404450",
                        heading_text_color: "#ffffff",
                        body_text_color: "#ffffff",
                        disclaimer_color: "#404450",
                        border_color: "#E5E5E5",
                        button_text_color: "#ffffff",
                        button_color: ["#000000", "#000000"],
                        button_color_hover: ["#222222", "#222222"],
                        button_color_active: ["#222222", "#222222"]
                    },
                    profiler_design: {
                        bg_color: "#EFEFEF",
                        bg_opacity: '88',
                        text_color: "#404450",
                        border_color: "#E5E5E5",
                        button_text_color: "#ffffff",
                        button_color: ["#000000", "#000000"],
                        button_color_hover: ["#222222", "#222222"],
                        button_color_active: ["#222222", "#222222"]
                    },
                    imgOrVideo: {
                        video: {
                            url: "https://www.youtube.com/watch?v=wCFi9s3LhBU&ab_channel=sMediaProofs",
                            title: "",
                            description: "",
                            show_form: true,
                        },
                        isVideo: false,
                        image: "https://test.smedia.ca/images/demo.png",
                        background: "https://test.smedia.ca/images/demo.png",
                        version: "v0"
                    },
                    response_email: {
                        active: true,
                        email_title: '',
                        subject: "Hello [name],<p>Please print the following coupon and bring it with you to claim.</p><img src=\"[image]\"/><p><br/>[dealership]",
                        email: "Hello [name],<p>Please print the following coupon and bring it with you to claim.</p><img src=\"[image]\"/><p><br/>[dealership]"
                    },
                    forward_to: {
                        email_list: [],
                        subject: "sMedia Coupon Lead"
                    },
                    special_to: {
                        email_list: [],
                        subject: "sMedia Coupon Lead",
                        provider_name: "sMedia Coupon",
                        source: "sMedia Coupon"
                    },
                    device_type: {
                        mobile: true,
                        desktop: true,
                        tablet: true
                    },
                    display: {
                        display_after: 3000,
                        retarget_after: 5000,
                        fb_retarget_after: 5000,
                        adword_retarget_after: 5000
                    },
                    check_price: {
                        active: false,
                        max: 10000000,
                        min: 0
                    },
                    shown_cap: {
                        active: false,
                        value: 3
                    },
                    fillup_cap: {
                        active: false,
                        value: 7
                    },
                    session_close: {
                        active: false,
                        value: 3
                    },
                    session_depth: {
                        active: false,
                        value: 0
                    },
                    inactivity: {
                        active: false,
                        value: 300000
                    },
                    exit_intent: {
                        active: false,
                        value: 600000
                    },
                    campaign_cap_google: {
                        active: false,
                        count: 3,
                        days: 7
                    },
                    campaign_cap_fb: {
                        active: false,
                        count: 3,
                        days: 7
                    },
                    show_cases: {
                        timer: {
                            active: true,
                        },
                        onclick: {
                            active: false,
                            selectors: []
                        },
                        static: {
                            active: false,
                            options: [
                                {
                                    url: 'https://www.abc.com/test-page',
                                    selector: '#someRandomElement > a'
                                }
                            ]
                        }
                    },
                    questions: [
                        {
                            question: "Let us help you find what you are looking for",
                            answers: {
                                'yes': 2,
                                'no': 0
                            },
                            id: 1,
                            nextId: 0
                        },
                        {
                            question: "Do you own a vehicle?",
                            answers: {
                                'yes': 3,
                                'no': 5
                            },
                            id: 2,
                            nextId: 0
                        },
                        {
                            question: "Do you want to sell your vehicle?",
                            answers: {
                                'yes': 4,
                                'no': 0
                            },
                            id: 3,
                            nextId: 0
                        },
                        {
                            question: "Do you want to add 250$ to the vehicle you are selling?",
                            answers: {
                                'yes': 0,
                                'no': 0
                            },
                            id: 4,
                            nextId: 0
                        },
                        {
                            question: "Do you want 250$ off your purchase?",
                            answers: {
                                'yes': 0,
                                'no': 0
                            },
                            id: 5,
                            nextId: 0
                        },
                    ],
                    name: "default smart profiler",
                    live: false,
                    priority: 5,
                    archive: false,
                    exit_intent_popup: false,
                    template: "Smart profiler Lead",
                    otherPage: [],
                    buttonText: "submit",
                    custom_timing: [],
                    disclaimer: "",
                    _id: "1658415304859",
                    createdAt: "",
                    updatedAt: "",
                    id: "1658415304859"
                };
                if (!smartProfilers.length) {
                    sMedia.debugLog("sMedia: No `SMART PROFILER` config found.");
                }
                for (const leadConfigs of smartProfilers) {
                    this.bgFileUrl = leadConfigs.imgOrVideo.image || null;
                    this.sessionStorage = sMedia.Context.HashFunction.Hash(`${sMedia.Context.Dealership}|${browser.uniqueUserId}|${browser.sessionId}|${leadConfigs.name}`);
                    this.persistentStorage = sMedia.Context.HashFunction.Hash(`${sMedia.Context.Dealership}|${browser.uniqueUserId}|${leadConfigs.name}`);
                    this.sp_config = Object.assign({}, defaultConfigs, leadConfigs || {});
                    this.smartProfilerLead = new Modules.SmartProfilerLead(this.sessionStorage, this.persistentStorage, this.leadFormUrl, this.sp_config, this.storagePrefix);
                    const isLive = this.sp_config.live || false;
                    this.debug = sMedia.Context.DebugFlags.smartProfiler;
                    this.showSmartProfiler = true;
                    this.smartProfilerShown = false;
                    if (!(isLive || this.debug)) {
                        sMedia.debugLog(`sMedia: Smart profiler is neither live in config ==> '${this.sp_config.name}' nor we are in debug mode. Hence smart profiler stopped for this config.`);
                        continue;
                    }
                    this.video = this.sp_config.imgOrVideo.isVideo;
                    const enabledForPageType = sMedia.isEnabledForThisPage(this.sp_config);
                    sMedia.debugLog(`sMedia: Smart profiler live status ==> ${isLive} in config ==> '${this.sp_config.name}'`);
                    sMedia.debugLog(`sMedia: Smart profiler enable status for this page ('${pageType}')  ==> '${enabledForPageType}' in config ==> '${this.sp_config.name}'`);
                    sMedia.debugLog(`sMedia: Smart profiler Video ==> ${this.video} in config ==> '${this.sp_config.name}'`);
                    if (!enabledForPageType) {
                        this.showSmartProfiler = false;
                        sMedia.debugLog(`sMedia: Smart profiler is not enabled for this page in config ==> '${this.sp_config.name}'. Hence smart profiler stopped for this config (even if in debug mode).`);
                        continue;
                    }
                    this.sessPageVisits = sMedia.setAndIncrementSessionDepth(this.sessionStorage, this.storagePrefix);
                    const metFBcap = sMedia.metFacebookCampaignCap(this.sp_config, this.persistentStorage, 'Smart Profiler', this.storagePrefix);
                    if (metFBcap) {
                        this.showSmartProfiler = false;
                        sMedia.debugLog("sMedia: Smart profiler will not be shown due to facebook campaign cap met");
                    }
                    const metGOOGLEcap = sMedia.metGoogleCampaignCap(this.sp_config, this.persistentStorage, 'Smart Profiler', this.storagePrefix);
                    if (metGOOGLEcap) {
                        this.showSmartProfiler = false;
                        sMedia.debugLog("sMedia: Smart profiler will not be shown due to google campaign cap met");
                    }
                    const metDailyShownCap = sMedia.dailyShownCapMet(this.sp_config, this.persistentStorage, this.storagePrefix);
                    if (metDailyShownCap) {
                        this.showSmartProfiler = false;
                        sMedia.debugLog(`sMedia: Smart profiler is not shown due to daily shown cap has been met.`);
                    }
                    const metSessionShownCap = sMedia.sessionShownCapMet(this.sp_config, this.sessionStorage, this.storagePrefix);
                    if (metSessionShownCap) {
                        this.showSmartProfiler = false;
                        sMedia.debugLog(`sMedia: Smart profiler is not shown due to session shown cap has been met.`);
                    }
                    const metSoFillUpCap = sMedia.metFillUpCap(this.sp_config, this.persistentStorage, this.storagePrefix);
                    if (metSoFillUpCap) {
                        this.showSmartProfiler = false;
                        sMedia.debugLog(`sMedia: Smart profiler is not shown due to fill up cap is met.`);
                    }
                    const showForThisDevice = sMedia.showBasedOnDeviceType(this.sp_config);
                    if (!showForThisDevice) {
                        this.showSmartProfiler = false;
                        sMedia.debugLog(`sMedia: Smart profiler is not enabled for device type ==> '${sMedia.Context.Browser.getDeviceType()}'.`);
                    }
                    const belowSessionDepth = sMedia.sessionDepthCheck(this.sp_config, this.sessPageVisits);
                    if (belowSessionDepth) {
                        this.showSmartProfiler = false;
                        sMedia.debugLog(`sMedia: Smart profiler will not be shown due to current session depth being ${this.sessPageVisits} while ${this.sp_config.session_depth.value} is required.`);
                    }
                    const showBasedOnPrice = sMedia.priceRangeMet(this.sp_config);
                    if (!showBasedOnPrice) {
                        this.showSmartProfiler = false;
                        sMedia.debugLog(`sMedia: Smart profiler is not being shown due to price range requirement not matched.`);
                    }
                    const imgOrVideoUrlExists = ((this.bgFileUrl.length > (sMedia.apiHost.length + 4)) || (!sMedia.isEmptyString(this.sp_config.imgOrVideo.video.url)));
                    if (!imgOrVideoUrlExists) {
                        this.showSmartProfiler = false;
                        sMedia.debugLog(`sMedia: Smart profiler is not being shown due URL for 'smart_profiler_image' or 'smart_profiler_video' is missing.`);
                    }
                    const smartProfilerTimeLimit = sMedia.getTimeLimit(this.sp_config);
                    console.log({ smartProfilerTimeLimit });
                    this.getHtml(domConfig, carDataParam, browser);
                    this.bindNextUiEvent();
                    this.getCss();
                    const setSOready = (state) => {
                        window.setTimeout(() => {
                            this.readyToShow = state;
                        }, 5000);
                    };
                    document.addEventListener("aiform.load", () => { this.readyToShow = false; });
                    document.addEventListener("aiform.close", () => setSOready(true));
                    document.addEventListener("aiform.complete", () => setSOready(true));
                    const wait = setInterval(() => {
                        if (this.smartProfilerReady && (!this.video || this.soVideoReady)) {
                            clearInterval(wait);
                            this.readyToShow = true;
                            let player = null;
                            if (this.video) {
                                this.readyToShow = false;
                                player = window.videojs("smart-profiler-video", {
                                    techOrder: ["youtube"],
                                    sources: [{
                                            type: "video/youtube",
                                            src: this.sp_config.imgOrVideo.video.url,
                                        }],
                                    youtube: {
                                        playsinline: 1,
                                        modestbranding: 1,
                                        autoplay: 1,
                                    },
                                }, () => {
                                    this.readyToShow = true;
                                    player.play();
                                });
                                player.on("firstplay", () => {
                                    player.muted(true);
                                    player.pause();
                                });
                            }
                            if (this.sp_config.show_cases.timer.active) {
                                window.setTimeout(this.fireSmartProfiler, smartProfilerTimeLimit, enabledForPageType, player, true);
                            }
                            if (this.sp_config.show_cases.onclick.active) {
                                const that = this;
                                const sels = this.sp_config.show_cases.onclick.selectors;
                                if (sels && sels.length) {
                                    sels.forEach((sel) => {
                                        const onclick_elements = document.querySelectorAll(sel);
                                        onclick_elements.forEach((elm) => {
                                            elm.addEventListener('click', function (e) {
                                                e.preventDefault();
                                                e.stopPropagation();
                                                that.fireSmartProfiler(enabledForPageType, player);
                                            });
                                        });
                                    });
                                }
                            }
                            if (this.sp_config.exit_intent_popup) {
                                const exit_intent_so_fire = (event, event_name) => {
                                    sMedia.debugLog(`sMedia: Exit intent discovered and SO fired for event ==> '${event_name}'`);
                                    event.preventDefault();
                                    event.stopPropagation();
                                    this.fireSmartProfiler(enabledForPageType, player);
                                };
                                document.addEventListener('mousemove', (event) => {
                                    if (!this.smartProfilerShown && event.clientY <= 0) {
                                        exit_intent_so_fire(event, 'mousemove');
                                    }
                                }, false);
                            }
                        }
                    }, 500);
                    if (enabledForPageType) {
                        sMedia.Context.AppStates.smart_profiler_enabled = true;
                        sMedia.debugLog(`sMedia: Smart profiler is enabled for this page in config ==> '${this.sp_config.name}' and hence other configs will be ignored in this page.`);
                        break;
                    }
                }
            }
            getHtml(domConfig, carDataParam, browser) {
                const carTitle = carDataParam ? `${carDataParam.year} ${carDataParam.make} ${carDataParam.model}`.replaceAll('undefined', '').trim().ucwords() : '';
                const trafficSource = sMedia.Cookie.get('__utmzz');
                const first = this.sp_config.basicForm.first;
                const second = this.sp_config.basicForm.second;
                const third = this.sp_config.basicForm.third;
                const fourth = this.sp_config.extraForm.fourth;
                const forthField = fourth.show ?
                    `<div class="${this.video ? `sp-col sp-col-extra-form` : `sp-row`}">
				${this.video ? '' : `<label for="sp-fourth" class="sp-label">${fourth.text}</label>`}
				<input type="text" id="sp-fourth" class="${this.video ? `ibm-font` : ''} sp-fourth sp-text sp-inputs" name="fourth"
				value="${fourth.value.current_vdp ? carTitle : ""}"
				placeholder="${fourth.value.placeholder}"
				${fourth.required ? 'required' : ''}>
			</div>` : "";
                const fifth = this.sp_config.extraForm.fifth;
                const fifthField = fifth.show ?
                    ((fifth.type == 'dropdown' && fifth.option.length) ?
                        this.getDropDown(fifth)
                        :
                            `<div class="${this.video ? `sp-col sp-col-extra-form` : `sp-row`}">
				${this.video ? '' : `<label for="sp-fifth" class="sp-label">${fifth.text}</label>`}
				<input type="${fifth.type}" id="sp-fifth" class="${this.video ? `ibm-font` : ''} sp-${fifth.type} sp-inputs" name="fifth"
				value="" placeholder="${fifth.placeholder}" ${fifth.required ? 'required' : ''}>
			</div>`) : "";
                const disclaimer = (this.sp_config.disclaimer && this.sp_config.disclaimer.length) ?
                    `<div class="sp-disclaimer-div" id="sp-disclaimer-div">
				<div class="sp-disclaimer-text" id="sp-disclaimer-text"><i>*${this.sp_config.disclaimer}</i></div>
			</div>`
                    : "";
                const leadForm = `<div class="smart-profiler-lead-form sp-hidden" id="smart-profiler-lead-form">
				<div class="smart-profiler-lead-image-div" id="smart-profiler-lead-image-div">
					<img class="smart-profiler-lead-image" id="smart-profiler-lead-image" src="${this.sp_config.imgOrVideo.image}" alt="offer image">
				</div>
				<div class="smart-profiler-lead-input-container" id="smart-profiler-lead-input-container">
					<div class="smart-profiler-lead-inputs" id="smart-profiler-lead-inputs">
						<div class="sp-row">
							<label for="sp-first">${first.label}</label>
							<input type="${first.type}" id="sp-first" class="sp-inputs sp-${first.type}" name="first" placeholder="${first.placeholder}" value="" ${first.required ? 'required' : ''}>
						</div>
						<div class="sp-row">
							<label for="sp-second">${second.label}</label>
							<input type="${second.type}" id="sp-second" class="sp-inputs sp-${second.type}" name="second" placeholder="${second.placeholder}" value="" ${second.required ? 'required' : ''}>
						</div>
						<div class="sp-row">
							<label for="sp-third">${third.label}</label>
							<input type="${third.type}" id="sp-third" class="sp-inputs sp-${third.type}" name="third" placeholder="${third.placeholder}" value="" ${third.required ? 'required' : ''}>
						</div>
						${forthField}
						${fifthField}
						<div class="sp-row sp-submit-btn-div">
							<button type="submit" class="sp-submit-btn">${this.sp_config.buttonText.toUpperCase()}</button>
						</div>
						${disclaimer}
					</div>
				</div>
				<div id="sp-loading-spinner" class="sp-loading-spinner sp-hidden">
					<img id="sp-loading-spinner-img" class="sp-loading-spinner-img" src="${sMedia.apiHost}/adwords3/templates/balls.svg"/>
				</div>
			</div>`;
                const hidden_forms = `<div class="smart-profiler-hidden-inputs sp-hidden" id="smart-profiler-hidden-inputs">
				<input type="hidden" name="dealership" id="dealership" value="${domConfig.cron || ""}">
				<input type="hidden" name="stock_type" id="stock_type" value="${carDataParam.stock_type || ""}">
				<input type="hidden" name="year" id="year" value="${carDataParam.year || ""}">
				<input type="hidden" name="make" id="make" value="${carDataParam.make || ""}">
				<input type="hidden" name="model" id="model" value="${carDataParam.model || ""}">
				<input type="hidden" name="trim" id="trim" value="${carDataParam.trim || ""}">
				<input type="hidden" name="title" id="title" value="${carDataParam.title || carTitle}">
				<input type="hidden" name="url" id="url" value="${carDataParam.url || window.location.href.split('#')[0]}">
				<input type="hidden" name="stock_number" id="stock_number" value="${carDataParam.stock_number || ""}">
				<input type="hidden" name="vin" id="vin" value="${carDataParam.vin || ""}">
				<input type="hidden" name="svin" id="svin" value="${carDataParam.svin || ""}">
				<input type="hidden" name="odometer" id="odometer" value="${carDataParam.kilometers || ""}">
				<input type="hidden" name="kilometres" id="kilometres" value="${carDataParam.kilometers || ""}">
				<input type="hidden" name="engine" id="engine" value="${carDataParam.engine || ""}">
				<input type="hidden" name="transmission" id="transmission" value="${carDataParam.transmission || ""}">
				<input type="hidden" name="body_style" id="body_style" value="${carDataParam.body_style || ""}">
				<input type="hidden" name="doors" id="doors" value="${carDataParam.doors || ""}">
				<input type="hidden" name="smedia_smart_lead_uuid" id="smedia_smart_lead_uuid" value="${browser.uniqueUserId || ""}">
				<input type="hidden" name="session_id" id="session_id" value="${browser.sessionId || ""}">
				<input type="hidden" name="referrer" id="referrer" value="${document.referrer || window.location.href.split('#')[0]}">
				<input type="hidden" name="mongo_dealer_id" id="mongo_dealer_id" value="${domConfig.mongo_dealer_info.id || ""}">
				<input type="hidden" name="template" id="template" value="${this.sp_config.template || ""}">
				<input type="hidden" name="config_id" id="config_id" value="${this.sp_config.id || ""}">
				<input type="hidden" name="config_name" id="config_name" value="${this.sp_config.name || ""}">
				<input type="hidden" name="debug" id="debug" value="${this.debug || ""}">
				<input type="hidden" name="smart-offer-traffic-source" id="smart-offer-traffic-source" value="${trafficSource || ""}">
			</div>`;
                let smartProfilerQAUi = '';
                this.sp_config.questions.forEach((qa) => {
                    smartProfilerQAUi += this.generateQABlock(qa);
                });
                const profilerFormDesktop = `<div class="smart-profiler-body" id="smart-profiler-body">
				<div class="smart-profiler-rectangle-169">
					<div class="smart-profiler-rectangle-151">
						<div class="smart-profiler-rectangle-152">
							<div id="smart-profiler-shown-frame" class="smart-profiler-rectangle-170">
								${smartProfilerQAUi}
								${leadForm}
							</div>
						</div>
					</div>
				</div>
			</div>`;
                const smart_profiler_desktop = `<div id="smedia-overlay" class="smart-profiler-overlay" style="display:none"></div>
			<div class="smart-profiler-container sp-hidden" id="smart-profiler-container">
				<button class="smart-profiler-close" id="smart-profiler-close"></button>
				<form class="smart-profiler-form" id="smart-profiler-form" name="smart-profiler-form" method="post">
					${hidden_forms}
					${profilerFormDesktop}
				</form>
			</div>`;
                const smart_profiler_video_html = ``;
                if (!this.video) {
                    sMedia.dom.find("body").append(smart_profiler_desktop);
                }
                else {
                    const head = document.getElementsByTagName("head")[0];
                    const video_css = `https://vjs.zencdn.net/7.8.4/video-js.css`;
                    const video_script = `https://vjs.zencdn.net/7.8.4/video.js`;
                    const yt_script = `https://cdn.jsdelivr.net/gh/videojs/videojs-youtube/dist/Youtube.min.js`;
                    sMedia.DomInstaller.InstallStyle(video_css, head, () => {
                        sMedia.DomInstaller.InstallScript(video_script, head, () => {
                            sMedia.DomInstaller.InstallScript(yt_script, head, () => {
                                sMedia.dom.find("body").append(smart_profiler_video_html);
                                this.soVideoReady = true;
                            }, false);
                        }, false);
                    });
                }
            }
            getCss() {
                const eitherExtraForm = this.sp_config.extraForm.fourth.show || this.sp_config.extraForm.fifth.show;
                const bothExtraForm = this.sp_config.extraForm.fourth.show && this.sp_config.extraForm.fifth.show;
                let profiler_btn_gradient = "";
                const BCP1 = this.sp_config.profiler_design.button_color[0];
                const BCP2 = this.sp_config.profiler_design.button_color[1];
                if (this.sp_config.profiler_design.button_color.length > 1) {
                    profiler_btn_gradient =
                        `background-image: -webkit-linear-gradient(top, ${BCP1}, ${BCP2});
				background-image: -moz-linear-gradient(top, ${BCP1}, ${BCP2});
				background-image: -ms-linear-gradient(top, ${BCP1}, ${BCP2});
				background-image: -o-linear-gradient(top, ${BCP1}, ${BCP2});
				background-image: linear-gradient(to bottom, ${BCP1}, ${BCP2});`;
                }
                let profiler_btn_hover_gradient = "";
                const BCPH1 = this.sp_config.profiler_design.button_color_hover[0];
                const BCPH2 = this.sp_config.profiler_design.button_color_hover[1];
                if (this.sp_config.profiler_design.button_color_hover.length > 1) {
                    profiler_btn_hover_gradient =
                        `background-image: -webkit-linear-gradient(top, ${BCPH1}, ${BCPH2});
				background-image: -moz-linear-gradient(top, ${BCPH1}, ${BCPH2});
				background-image: -ms-linear-gradient(top, ${BCPH1}, ${BCPH2});
				background-image: -o-linear-gradient(top, ${BCPH1}, ${BCPH2});
				background-image: linear-gradient(to bottom, ${BCPH1}, ${BCPH2});`;
                }
                let profiler_btn_active_gradient = "";
                const BCPA1 = this.sp_config.profiler_design.button_color_active[0];
                const BCPA2 = this.sp_config.profiler_design.button_color_active[1];
                if (this.sp_config.profiler_design.button_color_active.length > 1) {
                    profiler_btn_active_gradient =
                        `background-image: -webkit-linear-gradient(top, ${BCPA1}, ${BCPA2});
				background-image: -moz-linear-gradient(top, ${BCPA1}, ${BCPA2});
				background-image: -ms-linear-gradient(top, ${BCPA1}, ${BCPA2});
				background-image: -o-linear-gradient(top, ${BCPA1}, ${BCPA2});
				background-image: linear-gradient(to bottom, ${BCPA1}, ${BCPA2});`;
                }
                let btn_gradient = "";
                const BC1 = this.sp_config.color.button_color[0];
                const BC2 = this.sp_config.color.button_color[1];
                if (this.sp_config.color.button_color.length > 1) {
                    btn_gradient =
                        `background-image: -webkit-linear-gradient(top, ${BC1}, ${BC2});
				background-image: -moz-linear-gradient(top, ${BC1}, ${BC2});
				background-image: -ms-linear-gradient(top, ${BC1}, ${BC2});
				background-image: -o-linear-gradient(top, ${BC1}, ${BC2});
				background-image: linear-gradient(to bottom, ${BC1}, ${BC2});`;
                }
                let btn_hover_gradient = "";
                const BCH1 = this.sp_config.color.button_color_hover[0];
                const BCH2 = this.sp_config.color.button_color_hover[1];
                if (this.sp_config.color.button_color_hover.length > 1) {
                    btn_hover_gradient =
                        `background-image: -webkit-linear-gradient(top, ${BCH1}, ${BCH2});
				background-image: -moz-linear-gradient(top, ${BCH1}, ${BCH2});
				background-image: -ms-linear-gradient(top, ${BCH1}, ${BCH2});
				background-image: -o-linear-gradient(top, ${BCH1}, ${BCH2});
				background-image: linear-gradient(to bottom, ${BCH1}, ${BCH2});`;
                }
                let btn_active_gradient = "";
                const BCA1 = this.sp_config.color.button_color_active[0];
                const BCA2 = this.sp_config.color.button_color_active[1];
                if (this.sp_config.color.button_color_active.length > 1) {
                    btn_active_gradient =
                        `background-image: -webkit-linear-gradient(top, ${BCA1}, ${BCA2});
				background-image: -moz-linear-gradient(top, ${BCA1}, ${BCA2});
				background-image: -ms-linear-gradient(top, ${BCA1}, ${BCA2});
				background-image: -o-linear-gradient(top, ${BCA1}, ${BCA2});
				background-image: linear-gradient(to bottom, ${BCA1}, ${BCA2});`;
                }
                let css = `#smedia-overlay {
				position: fixed;
				width: 100%;
				height: 100%;
				top: 0;
				left: 0;
				display: none;
				z-index: 4999;
				background: #000000;
				opacity: 0.5;
			}
			.smart-profiler-container {
				position: fixed;
				font-family: Helvetica !important;
				font-style: normal;
				font-size: 18px;
				top: 50%;
				left: 50%;
				z-index: 5000;
				max-height: 100%;
				transform-origin: 50% 50%;
				transform: translate(-50%, -50%);
				letter-spacing: normal !important;
				/* outline: 8px solid gray; */
				width: 900px;
				height: 450px;
				/* border-radius: 16px; */
			}
			.smart-profiler-close {
				width: 32px;
				height: 32px;
				line-height: 20px;
				cursor: pointer;
				position: absolute !important;
				background-color: #333333;
				text-align: center;
				display: inline-block;
				font-size: 14px;
				font-weight: 400;
				font-style: normal;
				color: #F0F0F0;
				font-family: Helvetica;
				top: -16px;
				right: -16px;
				margin: 0;
				border-radius: 100%;
				border: 1px solid #F0F0F0;
				padding: 0;
				z-index: 9999;
			}
			.smart-profiler-close::after {
				content: "X";
				text-transform: uppercase;
			}
			.smart-profiler-close:hover {
				text-decoration: none;
			}
			.smart-profiler-form {
				width: 100%;
				height: 100%;
				/* border-radius: 16px; */
			}
			.smart-profiler-hidden-inputs {
			}
			.smart-profiler-body {
				height: 100%;
				width: 100%;
				/* border-radius: 16px; */
			}
			.smart-profiler-rectangle-169 {
				height: 100%;
				width: 100%;
				box-sizing: border-box;
				background: ${this.sp_config.profiler_design.bg_color};
				/* border-radius: 16px; */
			}
			.smart-profiler-rectangle-151 {
				height: 100%;
				width: 100%;
				background: ${this.sp_config.profiler_design.bg_color};
				/* border: 1px solid ${this.sp_config.profiler_design.border_color}; */
				/* border-radius: 16px; */
			}
			.smart-profiler-rectangle-152 {
				width: 100%;
				height: 100%;
				background-image: url('${this.sp_config.imgOrVideo.background}');
				background-repeat: no-repeat;
				background-size: cover;
				/* border-radius: 16px; */
			}
			.smart-profiler-rectangle-170 {
				width: 100%;
				height: 100%;
				background: ${this.sp_config.profiler_design.bg_color}${this.sp_config.profiler_design.bg_opacity};
				/* border-radius: 16px; */
			}
			.smart-profiler-qa-ui {
				width: 100%;
				height: 100%;
				display: flex;
				align-items: center;
				justify-content: center;
				padding: 20px;
				/* border-radius: 16px; */
			}
			.smart-profiler-qa {
				position: relative;
				display: flex;
				flex-direction: column;
				gap: 18px;
			}
			.smart-profiler-question-back {
			}
			.smart-profiler-question-div {
			}
			.smart-profiler-question {
				color: ${this.sp_config.profiler_design.text_color};
				margin: 0 0 16px;
				font-family: Helvetica !important;
				font-weight: 600;
    			font-size: 36px;
    			line-height: 40px;
    			text-align: center;
			}
			.smart-profiler-answer-div {
				position: relative;
				display: flex;
				flex-direction: column;
				align-content: center;
				flex-wrap: wrap;
				font-size: 16px;
				line-height: 24px;
				gap: 18px;
			}
			.smart-profiler-answer {
				box-sizing: border-box;
				min-width: 320px;
				max-width: 420px;
				min-height: 48px;
				padding: 8px;
				font-size: 16px;
				line-height: 24px;
				border: 2px solid ${this.sp_config.profiler_design.border_color};
				border-radius: 8px;
				color: ${this.sp_config.profiler_design.button_text_color};
				background: ${this.sp_config.profiler_design.button_color[0]};
				${profiler_btn_gradient}
			}
			.smart-profiler-answer:hover {
				background: ${this.sp_config.profiler_design.button_color_hover[0]};
				${profiler_btn_hover_gradient}
			}
			.smart-profiler-answer:active {
				background: ${this.sp_config.profiler_design.button_color_active[0]};
				${profiler_btn_active_gradient}
			}
			.smart-profiler-answer:disabled {
				background: ${this.sp_config.profiler_design.button_color_hover[0]};
				${profiler_btn_hover_gradient}
			}
			.skip-div {
				position: absolute;
				bottom: 12px;
				right: 18px;
				width: 48px;
				height: 28px;
			}
			.skip-btn {
				position: relative;
				width: 100%;
				height: 100%;
				font-weight: 500;
				font-size: 14px;
				line-height: 24px;
				color: #404450;
				background: #F0F0F0;
				border-radius: 8px;
				margin: 0;
				padding: 0;
				cursor: pointer;
			}
			.sp-hidden {
				display: none !important;
			}
			.smart-profiler-lead-form {
				display: flex;
    			flex-direction: row;
				width: 100%;
				height: 100%;
				/* border-radius: 16px; */
			}
			.smart-profiler-lead-image-div {
				width: 500px;
				height: 450px;
				/* border-radius: 16px 0 0 16px; */
			}
			.smart-profiler-lead-image {
				width: 500px;
				height: 450px;
				/* border-radius: 16px 0 0 16px; */
			}
			.smart-profiler-lead-input-container {
				width: 400px;
				height: 450px;
				background: ${this.sp_config.color.bg_color};
				display: flex;
				flex-direction: column;
				/* border-radius: 0 16px 16px 0; */
			}
			.smart-profiler-lead-inputs {
				display: flex;
				flex-direction: column;
				gap: ${eitherExtraForm ? (bothExtraForm ? '8px' : '12px') : '16px'};
				position: relative;
    			top: ${eitherExtraForm ? (bothExtraForm ? '16px' : '20px') : '36px'};
				height: calc(100% - ${eitherExtraForm ? (bothExtraForm ? '16px' : '20px') : '36px'});
				/* border-radius: 0 0 16px 0; */
			}
			.sp-label {
				margin-bottom: ${eitherExtraForm ? (bothExtraForm ? '2px' : '4px') : '6px'};
				padding: 0;
				font-size: 16px;
			}
			.sp-row {
				display: flex;
				flex-direction: column;
				padding: 0 8px;
				font-weight: 400;
				margin-left: 10px;
				margin-right: 10px;
			}
			.sp-col {
			}
			.sp-col-extra-form {
			}
			.sp-inputs {
				border: 2px solid;
				border-radius: 8px;
				height: ${eitherExtraForm ? (bothExtraForm ? '36px' : '40px') : '40px'};
				padding-left: 8px;
			}
			.sp-first {
			}
			.sp-second {
			}
			.sp-third {
			}
			.sp-fourth {
			}
			.sp-fifth {
			}
			.sp-fifth-dropdown {
			}
			.sp-dropdown-option {
				padding: 0;
				margin: 0;
			}
			.sp-submit-btn-div {
				margin-top: ${eitherExtraForm ? (bothExtraForm ? '6px' : '8px') : '16px'};
			}
			.sp-submit-btn {
				background: ${this.sp_config.color.button_color[0]};
				${btn_gradient}
				color: ${this.sp_config.color.button_text_color};
				border: solid ${this.sp_config.color.border_color} 2px;
				border-radius: 8px;
				height: ${eitherExtraForm ? (bothExtraForm ? '40px' : '40px') : '44px'};
				/* ${eitherExtraForm ? `font-size: 14px;` : ''} */
			}
			.sp-submit-btn:hover {
				background: ${this.sp_config.color.button_color_hover[0]};
				${btn_hover_gradient}
			}
			.sp-submit-btn:active {
				background: ${this.sp_config.color.button_color_active[0]};
				${btn_active_gradient}
			}
			.sp-submit-btn:disabled {
				background: ${this.sp_config.color.button_color_hover[0]};
				${btn_hover_gradient}
			}
			.sp-disclaimer-div {
				font-size: 8px;
				font-weight: normal;
				line-height: 80%;
				margin: 0 10px;
    			padding: 0 8px;
				position: absolute;
				bottom: 16px;
			}
			.sp-disclaimer-text {
				color: ${this.sp_config.color.disclaimer_color};
			}
			.sp-loading-spinner {
				width: 100%;
				height: 100%;
				background: ${this.sp_config.color.bg_color};
				display: flex;
				justify-content: center;
				flex-wrap: wrap;
				align-content: space-around;
				/* border-radius: 0 16px 16px 0; */
			}
			.sp-loading-spinner-img {
				width: 50%;
				height: 50%;
			}




			/* PLACE HOLDER & PLACE HOLDER ALIKE */
			.placeholder {
				color: #8c8c8c !important;
				font-style: normal;
				font-weight: normal !important;
				font-size: 16px;
			}
			input::-webkit-input-placeholder {
				color: #8c8c8c;
				font-style: normal;
				font-weight: normal;
				font-size: 16px;
			}
			input::-ms-input-placeholder {
				color: #8c8c8c;
				font-style: normal;
				font-weight: normal;
				font-size: 16px;
			}
			input::placeholder {
				color: #8c8c8c;
				font-style: normal;
				font-weight: normal;
				font-size: 16px;
			}
			::placeholder {
				color: #8c8c8c;
				font-style: normal;
				font-weight: normal;
				font-size: 16px;
			}`;
                css +=
                    `@media screen and (max-width: 400px) {
				.smart-profiler-container {
					width: 320px;
					height: auto;
					overflow-y: auto;
				}
				.smart-profiler-container-lead-page {
					height: ${bothExtraForm ? '750px' : '700px'} !important;
				}
				.smart-profiler-close {
					width: 20px;
					height: 20px;
					line-height: 20px;
					top: 4px;
					right: 4px;
				}
				.smart-profiler-rectangle-152 {
					background-image: none;
				}
				.smart-profiler-qa-ui {
					padding: 0;
				}
				.smart-profiler-qa {
					gap: 0;
				}
				.smart-profiler-question-back {
					background-image: url('${this.sp_config.imgOrVideo.background}');
					background-repeat: no-repeat;
					background-size: cover;
					width: 320px;
    				aspect-ratio: 2 / 1;
				}
				.smart-profiler-question-div {
					width: 320px;
					aspect-ratio: 2 / 1;
					display: flex;
					align-items: center;
					background: ${this.sp_config.profiler_design.bg_color}${this.sp_config.profiler_design.bg_opacity};
				}
				.smart-profiler-question {
					font-size: 24px;
					line-height: 28px;
					margin: 0;
					padding: 0;
				}
				.smart-profiler-answer-div {
					padding: 20px 20px 60px 20px;
					margin: 0;
					font-size: 12px;
				}
				.smart-profiler-answer {
					min-width: 240px;
					max-width: 296px;
					min-height: 48px;
					white-space: normal;
					font-size: 12px;
				}
				.smart-profiler-lead-form {
					flex-direction: column;
				}
				.smart-profiler-lead-image-div {
					width: 320px;
					height: 300px;
				}
				.smart-profiler-lead-image {
					width: 320px;
					height: 300px;
				}
				.smart-profiler-lead-input-container {
					width: 320px;
					height: ${bothExtraForm ? '450px' : '400px'} !important;
				}
				.smart-profiler-lead-inputs {
					gap: ${eitherExtraForm ? (bothExtraForm ? '8px' : '12px') : '16px'};
					top: ${eitherExtraForm ? (bothExtraForm ? '16px' : '20px') : '36px'};
					height: calc(${bothExtraForm ? '450px' : '400px'} - ${eitherExtraForm ? (bothExtraForm ? '16px' : '20px') : '36px'});
				}
			}



			@media screen and (min-width: 400px) and (max-width: 600px) {
				.smart-profiler-container {
					width: 375px;
					height: auto;
					overflow-y: auto;
				}
				.smart-profiler-container-lead-page {
					height: ${bothExtraForm ? '750px' : '750px'} !important;
				}
				.smart-profiler-close {
					width: 20px;
					height: 20px;
					line-height: 20px;
					top: 4px;
					right: 8px;
				}
				.smart-profiler-rectangle-152 {
					background-image: none;
				}
				.smart-profiler-qa-ui {
					padding: 0;
				}
				.smart-profiler-qa {
					gap: 0;
				}
				.smart-profiler-question-back {
					background-image: url('${this.sp_config.imgOrVideo.background}');
					background-repeat: no-repeat;
					background-size: cover;
					width: 375px;
    				aspect-ratio: 2 / 1;
				}
				.smart-profiler-question-div {
					width: 375px;
					aspect-ratio: 2 / 1;
					display: flex;
					align-items: center;
					background: ${this.sp_config.profiler_design.bg_color}${this.sp_config.profiler_design.bg_opacity};
				}
				.smart-profiler-question {
					font-size: 28px;
					line-height: 32px;
					margin: 0;
					padding: 0;
				}
				.smart-profiler-answer-div {
					padding: 20px 20px 60px 20px;
					margin: 0;
					font-size: 14px;
				}
				.smart-profiler-answer {
					min-width: 240px;
					max-width: 296px;
					min-height: 48px;
					white-space: normal;
					font-size: 14px;
				}
				.smart-profiler-lead-form {
					flex-direction: column;
				}
				.smart-profiler-lead-image-div {
					width: 375px;
					height: 350px;
				}
				.smart-profiler-lead-image {
					width: 375px;
					height: 350px;
				}
				.smart-profiler-lead-input-container {
					width: 375px;
					height: ${bothExtraForm ? '400px' : '400px'} !important;
				}
				.smart-profiler-lead-inputs {
					gap: ${eitherExtraForm ? (bothExtraForm ? '8px' : '12px') : '16px'};
					top: ${eitherExtraForm ? (bothExtraForm ? '16px' : '20px') : '36px'};
					height: calc(${bothExtraForm ? '400px' : '400px'} - ${eitherExtraForm ? (bothExtraForm ? '16px' : '20px') : '36px'});
				}
			}

			@media only screen and (min-width: 600px) and (max-width: 900px) {
				.smart-profiler-container {
					width: 500px;
					height: auto;
					overflow-y: auto;
				}
				.smart-profiler-container-lead-page {
					height: ${bothExtraForm ? '950px' : '900px'} !important;
				}
				.smart-profiler-close {
					width: 20px;
					height: 20px;
					line-height: 20px;
					top: 4px;
					right: 4px;
				}
				.smart-profiler-rectangle-152 {
					background-image: none;
				}
				.smart-profiler-qa-ui {
					padding: 0;
				}
				.smart-profiler-qa {
					gap: 0;
				}
				.smart-profiler-question-back {
					background-image: url('${this.sp_config.imgOrVideo.background}');
					background-repeat: no-repeat;
					background-size: cover;
					width: 500px;
    				aspect-ratio: 2 / 1;
				}
				.smart-profiler-question-div {
					width: 500px;
					aspect-ratio: 2 / 1;
					display: flex;
					align-items: center;
					background: ${this.sp_config.profiler_design.bg_color}${this.sp_config.profiler_design.bg_opacity};
				}
				.smart-profiler-question {
					font-size: 36px;
					line-height: 40px;
					margin: 0;
					padding: 0;
				}
				.smart-profiler-answer-div {
					padding: 20px 20px 60px 20px;
					margin: 0;
					font-size: 14px;
				}
				.smart-profiler-answer {
					min-width: 240px;
					max-width: 296px;
					min-height: 48px;
					white-space: normal;
					font-size: 14px;
				}
				.smart-profiler-lead-form {
					flex-direction: column;
				}
				.smart-profiler-lead-image-div {
					width: 500px;
					height: 450px;
				}
				.smart-profiler-lead-image {
					width: 500px;
					height: 450px;
				}
				.smart-profiler-lead-input-container {
					width: 500px;
					height: ${bothExtraForm ? '500px' : '450px'} !important;
				}
				.smart-profiler-lead-inputs {
					gap: ${eitherExtraForm ? (bothExtraForm ? '12px' : '12px') : '16px'};
					top: ${eitherExtraForm ? (bothExtraForm ? '16px' : '20px') : '36px'};
					height: calc(${bothExtraForm ? '500px' : '450px'} - ${eitherExtraForm ? (bothExtraForm ? '16px' : '20px') : '36px'});
				}
			}

			@media only screen and (min-width: 900px) {
			}
			`;
                const smart_profiler_css = `<style id="smedia-smart-profiler-style">${css}</style>`;
                sMedia.dom.find("body").append(smart_profiler_css);
            }
            getDropDown(fifth) {
                fifth.option.sort();
                let allOptions = `<option value="" class="sp-dropdown-option" disabled selected>${fifth.placeholder}</option>`;
                fifth.option.forEach((element) => {
                    allOptions += `<option value="${element}" class="sp-dropdown-option">${element}</option>`;
                });
                const fifthDropDown = `<div class="${this.video ? `sp-col sp-col-extra-form` : `sp-row`}">
				${this.video ? '' : `<label for="sp-fifth" class="sp-label">${fifth.text}</label>`}
				<select class="sp-fifth-dropdown placeholder sp-inputs"
				${this.video ? `style="padding-top: 2px !important; padding-bottom: 2px !important;"` : ''}
				name="fifth" id="sp-fifth"
				${fifth.required ? 'required' : ''}>
					${allOptions}
				</select>
			</div>`;
                return fifthDropDown;
            }
            generateQABlock(qa) {
                let ans_btns = '';
                for (const [key, value] of Object.entries(qa.answers)) {
                    ans_btns += `<input type="button" class="smart-profiler-answer show-next" data-current="${qa.id}" data-next="${value}" data-default="${qa.nextId}" data-qa="${qa.question}" data-qa-category="${qa.category}" data-qa-type="${qa.answerType}" value="${key}">`;
                }
                const qablock = `<div class="smart-profiler-qa-ui sp-hidden" id="sp-qa-ui-${qa.id}">
				<div class="smart-profiler-qa">
					<div class="smart-profiler-question-back">
						<div class="smart-profiler-question-div">
							<h1 class="smart-profiler-question">${qa.question}</h1>
						</div>
					</div>
					<div class="smart-profiler-answer-div">
						${ans_btns}
					</div>
				</div>
				<div class="skip-div">
					<button type="button" class="skip-btn show-next" data-current="${qa.id}" data-next="${qa.nextId}" data-default="${qa.nextId}" data-qa="${qa.question}" data-qa-category="${qa.category}" data-qa-type="${qa.answerType}" value="skip">skip</button>
				</div>
			</div>`;
                return qablock;
            }
            bindNextUiEvent() {
                document.querySelectorAll('.show-next').forEach((elm) => {
                    elm.addEventListener("click", () => {
                        const curQuesId = elm.getAttribute('data-current');
                        const uiElmemet = document.getElementById(`sp-qa-ui-${curQuesId}`);
                        const defaultId = elm.getAttribute('data-default');
                        const nextId = elm.getAttribute('data-next');
                        const currentAnswerObject = {
                            question: elm.getAttribute('data-qa'),
                            category: elm.getAttribute('data-qa-category'),
                            answerType: elm.getAttribute('data-qa-type'),
                            answer: elm.value,
                            fuzzyAnswer: '',
                            questionId: curQuesId,
                            nextId: nextId,
                            defaultId: defaultId,
                            sessionId: sMedia.Context.Browser.sessionId,
                            url: window.location.href,
                            timestamp: Date.now(),
                            shownAt: Number(uiElmemet.getAttribute('data-shown-at')) || Date.now()
                        };
                        sMedia.showProfilerNextView(curQuesId, nextId, defaultId);
                        sMedia.storeSmartProfilerAnswers(this.sp_config.id, currentAnswerObject);
                    });
                });
            }
            exitIntentClose() {
                if (this.sp_config.exit_intent.active) {
                    document.addEventListener("visibilitychange", () => {
                        window.setTimeout(() => {
                            this.smartProfilerLead.close(true);
                        }, this.sp_config.exit_intent.value);
                    }, { once: true });
                }
            }
            setInactivity() {
                if (this.sp_config.inactivity.active) {
                    window.setTimeout(() => {
                        this.smartProfilerLead.close(true);
                    }, this.sp_config.inactivity.value);
                }
            }
        }
        Modules.SmartProfiler = SmartProfiler;
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class SmartProfilerLead {
            constructor(sessionStorage, persistentStorage, leadFormUrl, sp_config, storagePrefix) {
                this.form = null;
                this.initialized = false;
                this.closeTimeoutID = null;
                this.initialForm = null;
                this.uniqueUserId = sMedia.Context.Browser.uniqueUserId;
                this.cron = sMedia.Context.DomainConfig.cron;
                this.sessionId = sMedia.Context.Browser.sessionId;
                this.carDataParam = sMedia.Context.PageData.car_data;
                this.defaultPayload = {
                    mongo_dealer_id: sMedia.Context.DomainConfig.mongo_dealer_info.id || "",
                    service: "smart-offer",
                    uuid: this.uniqueUserId,
                    session: this.sessionId,
                    url: window.location.href,
                    dealership: this.cron,
                    browser: sMedia.Context.BrowserName,
                    template: '',
                    smId: '',
                    config_name: '',
                    svin: this.carDataParam ? this.carDataParam.svin : "",
                    carInfo: {
                        stock_type: this.carDataParam ? this.carDataParam.stock_type : "",
                        year: this.carDataParam ? this.carDataParam.year : "",
                        make: this.carDataParam ? this.carDataParam.make : "",
                        model: this.carDataParam ? this.carDataParam.model : "",
                        stock_no: this.carDataParam ? this.carDataParam.stock_number : "",
                        trim: this.carDataParam ? this.carDataParam.trim : "",
                        body_style: this.carDataParam ? this.carDataParam.body_style : "",
                        transmission: this.carDataParam ? this.carDataParam.transmission : "",
                        odo_status: (this.carDataParam && this.carDataParam.stock_type == "new") ? "original" : "unknown",
                        odometer: this.carDataParam ? this.carDataParam.kilometres : "",
                    }
                };
                this.sessionStorage = sessionStorage;
                this.persistentStorage = persistentStorage;
                this.leadFromUrl = leadFormUrl;
                this.sp_config = sp_config;
                this.storagePrefix = storagePrefix;
                this.defaultPayload.template = this.sp_config.template;
                this.defaultPayload.smId = this.sp_config.id;
                this.defaultPayload.config_name = this.sp_config.name;
            }
            init() {
                const that = this;
                sMedia.dom.find("#smedia-overlay").click(() => {
                    that.close(true);
                });
                sMedia.dom.find("#smart-profiler-close").click(() => {
                    that.close(true);
                });
                sMedia.dom.find("#smart-profiler-form").submit(function (e) {
                    e.preventDefault();
                    const form = this;
                    let allowSubmit = true;
                    const smDebug = sMedia.getValueById('debug');
                    const smReferrer = sMedia.getValueById('referrer');
                    const trafficSource = sMedia.getValueById('smart-offer-traffic-source');
                    const spFirst = sMedia.getValueById('sm-first');
                    const spSecond = sMedia.getValueById('sm-second');
                    const spThird = sMedia.getValueById('sm-third');
                    const basicForm = that.sp_config.basicForm;
                    const typeValue = {
                        [basicForm.first.type]: spFirst,
                        [basicForm.second.type]: spSecond,
                        [basicForm.third.type]: spThird
                    };
                    const spName = typeValue['text'];
                    const spEmail = typeValue['email'];
                    const spPhone = typeValue['tel'];
                    const spFourth = sMedia.getValueById('sp-fourth');
                    const spFifth = sMedia.getValueById('sp-fifth');
                    if (sMedia.isEmptyString(spName)) {
                        allowSubmit = false;
                        document.getElementById('sp-first').value = '';
                        alert("Name can not be empty");
                    }
                    if (sMedia.isEmptyString(spFifth)) {
                        const fifthSetting = !!(that.sp_config && that.sp_config.extraForm) ? that.sp_config.extraForm.fifth : null;
                        if (fifthSetting &&
                            fifthSetting.show &&
                            fifthSetting.required &&
                            fifthSetting.type == 'dropdown') {
                            allowSubmit = false;
                            alert(`'${fifthSetting.text}' is required.`);
                        }
                    }
                    const QA = sMedia.fetchProfilerAnswers(that.sp_config.id);
                    const contentType = "application/json";
                    const extraPayload = {
                        action: "submit",
                        debug: smDebug,
                        referrer: smReferrer,
                        name: spName,
                        email: spEmail,
                        phone: spPhone,
                        trafficSource: trafficSource,
                        fourth: spFourth,
                        fifth: spFifth,
                        questionAnswer: QA
                    };
                    const submitPayload = { ...that.defaultPayload, ...extraPayload };
                    console.log({ submitPayload });
                    if (allowSubmit) {
                        that.disable(form);
                        new sMedia.Ajax().Post(that.leadFromUrl, submitPayload, (resp) => {
                            sMedia.storeSmartOfferSubmit(that.sp_config, that.persistentStorage, that.storagePrefix);
                            sMedia.sendSoSubmitGA();
                            if (resp.success) {
                                const thankYouHtml = `<h2 style="margin: 100px 25px; text-align: center;">${that.sp_config.thank_you}</h2>`;
                                sMedia.dom.find("#smart-profiler-lead-input-container").html(thankYouHtml);
                                sMedia.clearProfilerAnswers(that.sp_config.id);
                            }
                            else {
                                console.error(`sMedia: Lead submit failed`, resp);
                            }
                            that.enable(form);
                            setTimeout(() => {
                                that.close(false);
                            }, 3000);
                        }, null, contentType);
                    }
                });
                this.initialized = true;
            }
            delayClose() {
                if (sMedia.dom.find("#smart-profiler-form").serialize() !== this.initialForm) {
                    if (this.closeTimeoutID) {
                        clearTimeout(this.closeTimeoutID);
                    }
                    return;
                }
                this.close(true);
            }
            show() {
                if (!this.initialized) {
                    this.init();
                }
                sMedia.sendSoShownGA();
                sMedia.dom.find("#smedia-overlay").css("display", "block");
                sMedia.dom.find('#smart-profiler-container').removeClass('sp-hidden');
                const prevQA = sMedia.fetchProfilerAnswers(this.sp_config.id);
                if (prevQA.length > 0) {
                    const lastQA = prevQA.at(-1);
                    sMedia.showProfilerNextView(lastQA.questionId, lastQA.nextId, lastQA.defaultId);
                }
                else {
                    if (this.sp_config && this.sp_config.questions && this.sp_config.questions[0]) {
                        const init_id = this.sp_config.questions[0].id;
                        const initUi = document.getElementById(`sp-qa-ui-${init_id}`);
                        initUi.classList.remove('sp-hidden');
                        initUi.dataset.shownAt = Date.now().toString();
                    }
                    else {
                        sMedia.Context.LogService.Debug(`sMedia: Could not get initial questions id in smart profiler`);
                    }
                }
                this.initialForm = "";
                const extraPayload = {
                    action: "view",
                    debug: sMedia.getValueById('debug'),
                    referrer: sMedia.getValueById('referrer'),
                };
                const viewPayload = { ...this.defaultPayload, ...extraPayload };
                new sMedia.Ajax().Post(this.leadFromUrl, viewPayload, (resp) => {
                    if (resp) {
                        sMedia.storeOfferShown(this.persistentStorage, this.storagePrefix);
                    }
                }, null, "application/json");
                sMedia.increaseShowCount(this.sessionStorage, this.persistentStorage, this.storagePrefix);
                this.bindSmartProfilerEvents();
            }
            close(sendData) {
                if (sendData == true) {
                    const partialQA = sMedia.fetchProfilerAnswers(this.sp_config.id);
                    const extraPayload = {
                        action: "close",
                        debug: sMedia.getValueById('debug'),
                        referrer: sMedia.getValueById('referrer'),
                        questionAnswer: partialQA
                    };
                    const closePayload = { ...this.defaultPayload, ...extraPayload };
                    console.log({ closePayload });
                    new sMedia.Ajax().Post(this.leadFromUrl, closePayload, (resp) => {
                        if (resp && resp.response) {
                            sMedia.Context.LogService.Debug("sMedia: Smart profiler closed");
                        }
                    }, null, "application/json");
                }
                sMedia.dom.find("#smedia-overlay").css("display", "none");
                document.getElementById('smart-profiler-container').classList.add('sp-hidden');
            }
            disable(form) {
                sMedia.dom.find(form).find("input").attr("disabled", "disabled");
                sMedia.dom.find(form).find("button").attr("disabled", "disabled");
                document.getElementById('smart-profiler-lead-input-container').classList.add('sp-hidden');
                document.getElementById('sp-loading-spinner').classList.remove('sp-hidden');
            }
            enable(form) {
                sMedia.dom.find(form).find("input").removeAttr("disabled");
                sMedia.dom.find(form).find("button").removeAttr("disabled");
                document.getElementById('sp-loading-spinner').classList.add('sp-hidden');
                document.getElementById('smart-profiler-lead-input-container').classList.remove('sp-hidden');
            }
            bindSmartProfilerEvents() {
                const that = this;
                window.addEventListener('beforeunload', function (e) {
                    e.preventDefault();
                    if (!document.getElementById('smart-profiler-container').className.includes('sp-hidden')) {
                        that.close(true);
                    }
                });
                if (sMedia.Context.BrowserName) {
                    window.addEventListener('onbeforeunload', function (e) {
                        e.preventDefault();
                        if (!document.getElementById('smart-profiler-container').className.includes('sp-hidden')) {
                            that.close(true);
                        }
                    });
                }
            }
        }
        Modules.SmartProfilerLead = SmartProfilerLead;
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class Tracking {
            constructor() {
                this.viewContentFound = false;
            }
            Register() {
                const that = this;
                const cronConfig = sMedia.Context.DomainConfig.cron_config;
                const scrapperConfig = sMedia.Context.DomainConfig
                    .scrapper_config;
                const pageType = sMedia.Context.PageData.page_type;
                const carData = sMedia.Context.PageData.car_data;
                const dealerInfo = sMedia.Context.DomainConfig.dealer_info;
                const tagConfig = sMedia.Context.DomainConfig
                    .single_tag_config;
                const analyticsConfig = tagConfig.analytics && tagConfig.analytics[0]
                    ? tagConfig.analytics[0].account_id
                    : "";
                const facebookConfig = tagConfig.facebook && tagConfig.facebook[0]
                    ? tagConfig.facebook[0].account_id
                    : "";
                const trackerObject = new sMedia.Trackers(analyticsConfig, facebookConfig);
                const is_ga_installed = (analyticsId) => {
                    const trackers = typeof ga == "function" &&
                        !!ga.getAll &&
                        typeof ga.getAll == "function"
                        ? ga.getAll()
                        : [];
                    for (let i = 0, len = trackers.length; i < len; i++) {
                        if (trackers[i].get("trackingId") == analyticsId) {
                            return true;
                        }
                    }
                    return false;
                };
                const install_ga = () => {
                    const analyticObjects = tagConfig.analytics;
                    analyticObjects.forEach((analyticsElement) => {
                        if (!!analyticsElement.account_id) {
                            trackerObject.analytics_tracking_id =
                                analyticsElement.account_id.trim();
                            const is_duplicate = is_ga_installed(trackerObject.analytics_tracking_id);
                            trackerObject.ga_init();
                            const anaPageConfig = analyticsElement.config[pageType];
                            if (anaPageConfig) {
                                anaPageConfig.ga.forEach((cur_ga) => {
                                    switch (cur_ga) {
                                        case "pageview":
                                            if (!is_duplicate) {
                                                trackerObject.sendGa(true, cur_ga, sMedia.ANALYTICS_EVENTS[cur_ga]);
                                            }
                                            break;
                                        default:
                                            break;
                                    }
                                });
                            }
                            if (pageType === "vdp" &&
                                anaPageConfig.profitable_engagement) {
                                sMedia.Context.GlobalCallbacks.epm.push((_, count) => {
                                    that.smediaProfitableEngagement(trackerObject, count, anaPageConfig.install_analytics);
                                });
                            }
                            sMedia.dom.find("form").submit(function (_) {
                                trackerObject.sendGa(true, "event", sMedia.ANALYTICS_EVENTS.lead_from_submit);
                            });
                        }
                    });
                };
                const install_pixel = () => {
                    const fbObjects = tagConfig.facebook;
                    fbObjects.forEach((fbElement) => {
                        if (!!fbElement.account_id) {
                            trackerObject.fb_pixel_id = fbElement.account_id.trim();
                            const is_duplicate = is_fb_installed(trackerObject.fb_pixel_id);
                            trackerObject.fb_init();
                            const contentTypes = fbElement.config.vdp &&
                                fbElement.config.vdp.viewcontent &&
                                fbElement.config.vdp.viewcontent.length
                                ? fbElement.config.vdp.viewcontent
                                : ["vehicle"];
                            const pixel_content_id_field = !!dealerInfo.pixel_content_id_field
                                ? dealerInfo.pixel_content_id_field
                                : "stock_number";
                            let fbPageConfig;
                            switch (pageType) {
                                case "vdp":
                                    fbPageConfig = fbElement.config.vdp;
                                    break;
                                case "srp":
                                    fbPageConfig = fbElement.config.srp;
                                    break;
                                case "ty":
                                    fbPageConfig = fbElement.config.ty;
                                    break;
                                case "other":
                                    fbPageConfig = fbElement.config.other;
                                    break;
                            }
                            if (fbPageConfig && fbPageConfig.install_fbq) {
                                const eventMaps = {
                                    addtowishlist: "AddToWishlist",
                                    scheduletestdrive: "Schedule",
                                    contactus: "Contact",
                                    findlocation: "FindLocation",
                                    addtocart: "AddToCart",
                                    smedialead: "SmediaLead",
                                    customizevehicle: "CustomizeProduct",
                                    completeregistration: "CompleteRegistration",
                                    initiatecheckout: "InitiateCheckout",
                                    addedpaymentinfo: "AddPaymentInfo",
                                    purchase: "Purchase",
                                };
                                const fbq = (fbPageConfig || {}).fbq || [];
                                fbq.forEach((cur_fbq) => {
                                    const carDataParam = pageType === "vdp" &&
                                        carData &&
                                        carData.stock_number
                                        ? carData
                                        : null;
                                    const registerFacebookLead = () => {
                                        const configuration = (fbPageConfig.fbq_selectors || {})
                                            .lead || "";
                                        if (configuration.length) {
                                            formSubmittedConfigured(carDataParam, cronConfig, trackerObject, dealerInfo, pageType, contentTypes, configuration, "trackSingle", "click", pixel_content_id_field);
                                        }
                                        else {
                                            formSubmittedGeneric(carDataParam, cronConfig, trackerObject, dealerInfo, pageType, contentTypes, "trackSingle", "submit", pixel_content_id_field);
                                        }
                                    };
                                    switch (cur_fbq) {
                                        case "pageview":
                                            if (!is_duplicate) {
                                                trackerObject.fbq_sm("PageView", "trackSingle", trackerObject.fb_pixel_id);
                                            }
                                            break;
                                        case "viewcontent":
                                            if (pageType == "vdp") {
                                                fireViewContentEvent(carDataParam ||
                                                    {}, contentTypes, cronConfig, trackerObject, dealerInfo, pageType, "ViewContent", "trackSingle", pixel_content_id_field);
                                                this.viewContentFound = true;
                                            }
                                            break;
                                        case "epm":
                                            if (pageType == "vdp") {
                                                registerPixelEpmEvent(carDataParam, trackerObject, "ProfitableEngagement", "trackSingleCustom");
                                            }
                                            break;
                                        case "smedialead":
                                            [
                                                [
                                                    "aiform.complete",
                                                    {
                                                        page_type: pageType,
                                                        form: "aibutton",
                                                    },
                                                ],
                                                [
                                                    "smart_offer.submit",
                                                    {
                                                        page_type: pageType,
                                                        form: "smart_offer",
                                                    },
                                                ],
                                            ].forEach((x) => {
                                                fireSmediaFormSubmitEvent(x[0], "SmediaLead", carDataParam, cronConfig, trackerObject, dealerInfo, pageType, contentTypes, x[1], "trackSingleCustom", pixel_content_id_field);
                                            });
                                            break;
                                        case "lead":
                                            registerFacebookLead();
                                            break;
                                        case "addtowishlist":
                                        case "scheduletestdrive":
                                        case "contactus":
                                        case "findlocation":
                                        case "addtocart":
                                        case "customizevehicle":
                                        case "completeregistration":
                                        case "initiatecheckout":
                                        case "addedpaymentinfo":
                                        case "purchase":
                                            registerFacebookEvent(carDataParam, fbPageConfig, cur_fbq, eventMaps[cur_fbq], cronConfig, trackerObject, dealerInfo, pageType, contentTypes, "trackSingle", "click", pixel_content_id_field);
                                            break;
                                        case "search":
                                            if (pageType === "srp") {
                                                registerSearchEvent(fbPageConfig, "Search", cur_fbq, trackerObject, dealerInfo, pageType, contentTypes, "trackSingle", "click");
                                            }
                                            break;
                                        default:
                                            break;
                                    }
                                });
                            }
                        }
                    });
                };
                const is_fb_installed = (pixelId) => {
                    const trackers = typeof window.fbq == "function" &&
                        !!window.fbq.getState &&
                        typeof window.fbq.getState == "function"
                        ? window.fbq.getState().pixels
                        : [];
                    for (let i = 0, len = trackers.length; i < len; i++) {
                        if (trackers[i].id == pixelId) {
                            return true;
                        }
                    }
                    return false;
                };
                const install_trackers = (_) => {
                    if (tagConfig.analytics) {
                        install_ga();
                    }
                    if (tagConfig.facebook) {
                        install_pixel();
                    }
                };
                if (document.readyState === "complete") {
                    install_trackers(null);
                }
                else {
                    window.addEventListener("load", install_trackers);
                }
                this.updateTagState();
                if (pageType === "ty" &&
                    scrapperConfig.inpage_cont_match &&
                    tagConfig.facebook &&
                    tagConfig.facebook[0].config.ty.fbq) {
                    if (document.querySelector(scrapperConfig.inpage_cont_match)) {
                        this.smediaInpageLead(trackerObject, tagConfig.facebook[0].config.ty.fbq);
                    }
                }
            }
            smediaInpageLead(tag, fbqs) {
                fbqs.forEach((cur_fbq) => {
                    switch (cur_fbq) {
                        case "pageview":
                            tag.fbq_sm("PageView", "trackSingle", tag.fb_pixel_id);
                            break;
                        case "lead":
                            tag.fbq_sm("Lead", "trackSingle", tag.fb_pixel_id);
                            break;
                        default:
                            break;
                    }
                });
            }
            smediaProfitableEngagement(tracker, count, install_analytics = false) {
                const ev = sMedia.ANALYTICS_EVENTS[`profitable_engagement_${count}`];
                tracker.sendGa(install_analytics, "event", ev);
                if (count == 1) {
                    const epEvent = new CustomEvent("engaged_prospect", {
                        detail: null,
                    });
                    document.dispatchEvent(epEvent);
                }
            }
            updateTagState() {
                const payload = {
                    cron_name: sMedia.Context.Dealership,
                    page_type: sMedia.Context.PageData.page_type,
                    view_content: this.viewContentFound,
                    mongo_dealer_id: sMedia.Context.DomainConfig.mongo_dealer_info.id || "",
                };
                const tag_api = `${sMedia.apiHost}/api/tag_state_store.php`;
                new sMedia.Ajax().Post(tag_api, payload, () => { }, null, "application/x-www-form-urlencoded");
            }
            Unregister() { }
        }
        const registerPixelEpmEvent = (carDataParam, tag, event_name, trackingCategory = "track") => {
            sMedia.Context.GlobalCallbacks.epm.push((_, count) => {
                if (count === 1) {
                    const CD = carDataParam || {};
                    const epmPayload = {
                        stock_number: (CD.stock_number || "").trim(),
                        year: CD.year || "",
                        make: CD.make || "",
                        model: CD.year || "",
                        url: CD.url || window.location.href.split("#")[0],
                        event_owner: "sMedia",
                    };
                    tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, epmPayload);
                }
            });
        };
        const getcontentIdArray = (combined_feed_mode, stockNumber) => {
            return (combined_feed_mode
                ? [""]
                : ["", "-desktop", "-mobile", "-instagram"]).map((v) => `${stockNumber}${v}`);
        };
        const getViewContent = (carDataParam, contentType, combined_feed_mode, dealerInfo, pageType, content_id_field) => {
            const contentIdArray = getcontentIdArray(combined_feed_mode, (carDataParam[content_id_field] || "").trim());
            const viewContent = {
                content_ids: contentIdArray,
                content_type: contentType,
                stock_number: (carDataParam.stock_number || "").trim(),
                year: carDataParam.year,
                make: carDataParam.make,
                model: carDataParam.model,
                price: carDataParam.price
                    ? sMedia.priceToNumber(carDataParam.price)
                    : null,
                currency: dealerInfo.currency,
                state_of_vehicle: carDataParam.stock_type,
                exterior_color: carDataParam.color,
                transmission: carDataParam.transmission,
                body_style: carDataParam.body_style,
                fuel_type: carDataParam.fuel_type,
                drivetrain: carDataParam.drivetrain,
                country: dealerInfo.country_name,
                postal_code: dealerInfo.post_code,
                page_type: pageType,
                url: carDataParam.url || window.location.href.split("#")[0],
                vin: carDataParam.vin,
                event_owner: "sMedia",
            };
            return viewContent;
        };
        const isCombindedFeed = (cronConfig) => {
            return !!cronConfig.combined_feed_mode && cronConfig.combined_feed_mode;
        };
        const getElementBySelector = (thisPageConfig, selector_name) => {
            const findEl = !!(thisPageConfig.fbq_selectors || {})[selector_name]
                ? sMedia.escapeString(thisPageConfig.fbq_selectors[selector_name])
                : "nothing";
            return sMedia.dom.find(findEl);
        };
        const fireViewContentEvent = (carDataParam, contentTypes, cronConfig, tag, dealerInfo, pageType, event_name, trackingCategory, content_id_field) => {
            contentTypes.forEach((contentType) => {
                const viewContentPayload = getViewContent(carDataParam, contentType, isCombindedFeed(cronConfig), dealerInfo, pageType, content_id_field);
                tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, viewContentPayload);
            });
        };
        const registerSearchEvent = (thisPageConfig, event_name, selector_name, tag, dealerInfo, pageType, contentTypes, trackingCategory, on) => {
            getElementBySelector(thisPageConfig, selector_name).each((elm) => {
                elm.addEventListener(on, (event) => {
                    contentTypes.forEach((contentType) => {
                        const searchPayload = {
                            content_ids: [event_name],
                            content_type: contentType,
                            page_type: pageType,
                            country: dealerInfo.country_name,
                            postal_code: dealerInfo.post_code,
                            currency: dealerInfo.currency,
                            event_owner: "sMedia",
                        };
                        tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, searchPayload);
                    });
                });
            });
        };
        const registerFacebookEvent = (carDataParam, thisPageConfig, selector_name, event_name, cronConfig, tag, dealerInfo, pageType, contentTypes, trackingCategory, on, content_id_field) => {
            getElementBySelector(thisPageConfig, selector_name).each(function (elm) {
                elm.addEventListener(on, function (event) {
                    if (pageType === "vdp") {
                        contentTypes.forEach((contentType) => {
                            const eventPayload = getViewContent(carDataParam, contentType, isCombindedFeed(cronConfig), dealerInfo, pageType, content_id_field);
                            tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, eventPayload);
                        });
                    }
                    else {
                        contentTypes.forEach((contentType) => {
                            const otherEventPayload = {
                                content_type: contentType,
                                country: dealerInfo.country_name,
                                postal_code: dealerInfo.post_code,
                                page_type: pageType,
                                event_name: event_name,
                                url: window.location.href.split("#")[0],
                                event_owner: "sMedia",
                            };
                            tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, otherEventPayload);
                        });
                    }
                    const that = this;
                    window.setTimeout(() => {
                        sMedia.dom.el(that).unbind("click");
                    }, 1000);
                });
            });
        };
        const formSubmittedGeneric = (carDataParam, cronConfig, tag, dealerInfo, pageType, contentTypes, trackingCategory, on, content_id_field) => {
            sMedia.dom.find("form").each(function (elm) {
                elm.addEventListener(on, function (_) {
                    const event_name = "Lead";
                    if (pageType === "vdp") {
                        contentTypes.forEach((contentType) => {
                            const vdpPayload = getViewContent(carDataParam, contentType, isCombindedFeed(cronConfig), dealerInfo, pageType, content_id_field);
                            tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, vdpPayload);
                        });
                    }
                    else {
                        contentTypes.forEach((contentType) => {
                            const otherEventPayload = {
                                content_type: contentType,
                                country: dealerInfo.country_name,
                                postal_code: dealerInfo.post_code,
                                page_type: pageType,
                                event_name: event_name,
                                url: window.location.href,
                                event_owner: "sMedia",
                            };
                            tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, otherEventPayload);
                        });
                    }
                });
            });
        };
        const formSubmittedConfigured = (carDataParam, cronConfig, tag, dealerInfo, pageType, contentTypes, selector, trackingCategory, on, content_id_field) => {
            sMedia.dom.find(selector).each(function (elm) {
                elm.addEventListener(on, function (_) {
                    const event_name = "Lead";
                    if (pageType === "vdp") {
                        contentTypes.forEach((contentType) => {
                            const vdpPayload = getViewContent(carDataParam, contentType, isCombindedFeed(cronConfig), dealerInfo, pageType, content_id_field);
                            tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, vdpPayload);
                        });
                    }
                    else {
                        contentTypes.forEach((contentType) => {
                            const otherEventPayload = {
                                content_type: contentType,
                                country: dealerInfo.country_name,
                                postal_code: dealerInfo.post_code,
                                page_type: pageType,
                                event_name: event_name,
                                url: window.location.href.split("#")[0],
                                event_owner: "sMedia",
                            };
                            tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, otherEventPayload);
                        });
                    }
                });
            });
        };
        const fireSmediaFormSubmitEvent = (on, event_name, carDataParam, cronConfig, tag, dealerInfo, pageType, contentTypes, extraPayload, trackingCategory, content_id_field) => {
            document.addEventListener(on, () => {
                if (pageType === "vdp") {
                    contentTypes.forEach((contentType) => {
                        const parameters = getViewContent(carDataParam, contentType, isCombindedFeed(cronConfig), dealerInfo, pageType, content_id_field);
                        const vdpPayload = { ...parameters, ...extraPayload };
                        tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, vdpPayload);
                    });
                }
                else {
                    contentTypes.forEach((contentType) => {
                        const parameters = {
                            content_type: contentType,
                            country: dealerInfo.country_name,
                            postal_code: dealerInfo.post_code,
                            page_type: pageType,
                            event_name: event_name,
                            url: window.location.href.split("#")[0],
                            event_owner: "sMedia",
                        };
                        const otherPayload = {
                            ...parameters,
                            ...extraPayload,
                        };
                        tag.fbq_sm(event_name, trackingCategory, tag.fb_pixel_id, otherPayload);
                    });
                }
            });
        };
        Modules.tracking = new Tracking();
        sMedia.Context.OnReady(() => {
            Modules.tracking.Register();
        });
        sMedia.Context.OnClose(() => {
            Modules.tracking.Unregister();
        });
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class TradeSmart {
            Register() {
                const DC = sMedia.Context.DomainConfig;
                if (DC.dealer_info.tradesmart) {
                    this.installTradeSmart(DC.dealer_info.tradesmart_dealer_id, DC.smedia_domains.tradesmart);
                }
                else {
                    this.uninstallTradeSmart();
                }
            }
            installTradeSmart(tradeSmartId, tradeSmartApiHost) {
                const sm_ts_container = document.getElementById('smatp_trade_tool');
                const css_url = `${tradeSmartApiHost}/stylesheets/modal.css`;
                const js_url = `${tradeSmartApiHost}/javascripts/tool.js`;
                if (sm_ts_container) {
                    sm_ts_container.setAttribute("data-dealerid", tradeSmartId);
                    sMedia.DomInstaller.InstallStyle(css_url);
                    sMedia.DomInstaller.InstallScript(js_url);
                }
                function UrlExists(url, cb) {
                    const httpRequest = new XMLHttpRequest();
                    httpRequest.open('GET', url);
                    httpRequest.onreadystatechange = function () {
                        if (this.readyState == 4) {
                            if (this.status == 200) {
                                cb.apply(this.responseText, [200]);
                            }
                        }
                    };
                    httpRequest.send();
                }
                UrlExists(css_url, function (status) {
                    if (status === 200) {
                        console.log('sMedia : Trade Smart css load');
                    }
                    else {
                        console.log('sMedia : Trade Smart css is not load hide Powered by');
                        document.querySelector('smedia_powered_by').style.visibility = "hidden";
                        if (document.getElementById('trade-loading')) {
                            document.getElementById('trade-loading').style.display = "none";
                        }
                    }
                });
                UrlExists(js_url, function (status) {
                    if (status === 200) {
                        console.log('sMedia : Trade Smart javascripts load');
                    }
                    else {
                        console.log('sMedia : Trade Smart javascript is not loaded. Hiding powered by');
                        document.querySelector('smedia_powered_by').style.visibility = "hidden";
                        if (document.getElementById('trade-loading')) {
                            document.getElementById('trade-loading').style.display = "none";
                        }
                    }
                });
                this.HardCodeCSS();
            }
            ModifyTradeSmart() {
                console.log("sMedia : Removing tradesmart");
                const ts_span = document.querySelector('.smedia_powered_by');
                ts_span.parentNode.removeChild(ts_span);
                const new_ts_span = document.createElement('span');
                new_ts_span.classList.add('smedia_powered_by', 'smedia_powered_by_span');
                new_ts_span.innerHTML =
                    `Powered by: <a href="https://www.vroomance.com/" target="_blank" class="smedia_powered_by_anchor">
				<img src="${sMedia.apiHost}/vroomance.png" alt="Vroomance" class="smedia_powered_by_anchor_img">
			</a>`;
                const ts_div = document.querySelector('#smatp_trade_tool');
                ts_div.parentNode.insertBefore(new_ts_span, ts_div.nextSibling);
                console.log("sMedia : Readding tradesmart");
            }
            CallModifyTradeSmart() {
                if (document.querySelector('.smedia_powered_by')) {
                    this.ModifyTradeSmart();
                }
                else {
                    const that = this;
                    setTimeout(function () {
                        that.CallModifyTradeSmart();
                    }, 3000);
                }
            }
            HardCodeCSS() {
                if (document.querySelector('.smedia_powered_by a')) {
                    const ancTag = document.querySelector('.smedia_powered_by a');
                    const imgTag = document.querySelector('.smedia_powered_by a img');
                    ancTag.style.textDecoration = "none";
                    imgTag.style.display = "inline";
                    imgTag.style.height = "30px";
                    imgTag.style.marginBottom = "-5px";
                }
                else {
                    const that = this;
                    setTimeout(that.HardCodeCSS, 2000);
                }
            }
            uninstallTradeSmart() {
                sMedia.dom.find('#trade-loading').css('display', 'none');
                sMedia.dom.find('.smedia_powered_by').css('visibility', 'hidden');
            }
            Unregister() {
                this.uninstallTradeSmart();
            }
        }
        Modules.tradeSmart = new TradeSmart();
        sMedia.Context.OnReady(() => {
        });
        sMedia.Context.OnClose(() => {
        });
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class VinnAuto {
            Register() {
                const PT = sMedia.Context.PageType;
                const VA = sMedia.Context.DomainConfig.cron_config.vinnauto;
                const CD = sMedia.Context.PageData.car_data;
                if (PT == "vdp" && VA.button_status) {
                    if (this.vinnautoEligible(CD) && this.vinnautoLive(VA)) {
                        const crypto_url = `https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js`;
                        sMedia.DomInstaller.InstallScript(crypto_url, "head", () => {
                            this.installVinnAuto(VA, this.getVinnautoCarData(CD));
                        });
                    }
                }
            }
            vinnautoEligible(car_data) {
                if (sMedia.isEmptyString(car_data.vin)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : VIN is either missing or invalid.");
                    return false;
                }
                if (sMedia.isEmptyString(car_data.stock_number)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : Stock Number is missing.");
                }
                if (sMedia.isEmptyString(car_data.stock_type)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : Stock Type is missing");
                    return false;
                }
                if (sMedia.isEmptyString(car_data.year)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : Year is missing");
                    return false;
                }
                if (sMedia.isEmptyString(car_data.make)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : Make is missing");
                    return false;
                }
                if (sMedia.isEmptyString(car_data.model)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : Model is missing");
                    return false;
                }
                if (sMedia.isEmptyString(car_data.trim)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : Trim is missing.");
                }
                if (sMedia.isEmptyString(car_data.price) || !sMedia.isProperPrice(car_data.price)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : Improper price");
                    return false;
                }
                if (sMedia.isEmptyString(car_data.main_photo) && sMedia.isEmptyString(car_data.all_images)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : Main photo missing.");
                    return false;
                }
                return true;
            }
            vinnautoLive(vinnauto) {
                if (sMedia.isEmptyString(vinnauto.dealership_id)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : dealership id is missing");
                    return false;
                }
                if (sMedia.isEmptyString(vinnauto.VINN_SIGNING_SECRET)) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : VINN SIGNING SECRET missing");
                    return false;
                }
                if (vinnauto.button_debug) {
                    sMedia.Context.LogService.Debug("sMedia VINNAUTO : VINNAUTO debug is true and smedia_debug is false and hence vinnauto button is not shown. To show button turn off vinnauto button debug or to test it in debug mode turn on smedia_debug");
                    return false;
                }
                return true;
            }
            getVinnautoCarData(car_data) {
                let vinn_stock_type = "Used";
                if (car_data.stock_type == "new") {
                    vinn_stock_type = "New";
                }
                let main_photo = car_data.main_photo;
                if (!sMedia.isEmptyString(car_data.main_photo)) {
                    const all_images = car_data.all_images.split("|");
                    main_photo = all_images[0];
                }
                const vinn_car_data = {
                    vehicle: {
                        price: sMedia.priceToNumber(car_data.price),
                        vin: car_data.vin,
                        stock_number: car_data.stock_number,
                        status: vinn_stock_type,
                        year: car_data.year,
                        make: car_data.make,
                        model: car_data.model,
                        trim: car_data.trim,
                        main_photo: main_photo,
                        kilometers: sMedia.priceToNumber(car_data.kilometers),
                        exterior_color: car_data.color,
                        interior_color: car_data.interior_color,
                        fuel_type: car_data.fuel_type,
                        drive: car_data.drivetrain,
                        engine_size: car_data.engine,
                        transmission: car_data.transmission,
                        body: car_data.body_style,
                    },
                };
                return vinn_car_data;
            }
            installVinnAuto(vinnauto, vinn_car_data) {
                const vinn = vinn_car_data.vehicle.vin;
                const vinn_id = vinnauto.dealership_id;
                const vinn_secret = vinnauto.VINN_SIGNING_SECRET;
                const car_data_js = JSON.stringify(vinn_car_data).replace("/", "/");
                const payload = `${vinn_id}: ${car_data_js}`;
                const signature = CryptoJS.HmacSHA256(payload, vinn_secret);
                const vehicles = {
                    vinn: {
                        signature: signature,
                        body: car_data_js,
                    },
                };
                window.vinnCheckoutConfig = {
                    dealership: vinn_id,
                    getVehicle: function (vin) {
                        return vehicles[vin];
                    },
                };
                console.log({ vehicles });
                window.smediaCarData = JSON.parse(car_data_js);
                const elm = document.querySelector(vinnauto.button_container);
                const btn = document.createElement("div");
                btn.innerHTML = `<button ${vinnauto.button_code} data-vinn-widget=${vinn}> ${vinnauto.button_text} </button>`;
                elm.insertAdjacentElement(vinnauto.button_position, btn);
                const script_url = `https://vinnauto.com/checkout.v1.js`;
                sMedia.DomInstaller.InstallScript(script_url);
            }
            Unregister() { }
        }
        Modules.vinnAuto = new VinnAuto();
        sMedia.Context.OnReady(() => {
        });
        sMedia.Context.OnClose(() => {
        });
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
var sMedia;
(function (sMedia) {
    var Modules;
    (function (Modules) {
        class VisualScraper {
            Register() {
                if (sMedia.Context.DomainConfig.dealer_info.scrapper_type == 'VS') {
                    this.installVisualScraper(sMedia.apiHost);
                }
            }
            installVisualScraper(tmApiHost) {
                const ref_url = `${tmApiHost}/visual-scraper/client_vs.js?ref=${window.location.href.split('#')[0]}`;
                sMedia.DomInstaller.InstallScript(ref_url);
            }
            uninstallVisualScraper() {
                const del = document.getElementById('visual_scraper_ui');
                del.parentNode.removeChild(del);
            }
            Unregister() {
                if (document.getElementById('visual_scraper_ui')) {
                    this.uninstallVisualScraper();
                }
            }
        }
        Modules.visualScraper = new VisualScraper();
        sMedia.Context.OnReady(() => {
        });
        sMedia.Context.OnClose(() => {
        });
    })(Modules = sMedia.Modules || (sMedia.Modules = {}));
})(sMedia || (sMedia = {}));
String.prototype.padChar = function (length, char = '0', leftPad = true) {
    let s = String(this);
    while (s.length < length) {
        if (leftPad) {
            s = `${char}${s}`;
        }
        else {
            s = `${s}${char}`;
        }
    }
    return s;
};
String.prototype.ucfirst = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
};
String.prototype.ucwords = function () {
    const str = this.toLowerCase();
    return str.replace(/(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g, function (s) {
        return s.toUpperCase();
    });
};
String.prototype.removeLineBreaks = function () {
    return this.replace(/(?:\r\n|\r|\n)/g, ' ');
};
String.prototype.removeMultipleSpace = function () {
    return this.replace(/  +/g, ' ');
};
String.prototype.removeLineBreaksAndMultiSpaces = function () {
    return this.replace(/\s\s+/g, ' ').trim();
};
String.prototype.replaceArray = function (find, replace) {
    let replaceString = this;
    for (let i = 0, findLen = find.length; i < findLen; i++) {
        replaceString = replaceString.replace(find[i], replace[i]);
    }
    return replaceString;
};
String.prototype.splitAt = function (index) {
    return [this.substring(0, index), this.substring(index + 1)];
};
}

