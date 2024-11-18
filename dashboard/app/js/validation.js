/**
 * { EMAIL }
 *
 * 1. Email id must contain the @ and . character
 * 2. There must be at least one character before and after the @.
 * 3. There must be at least two characters after . (dot).
 * 4. There must be at least one character between @ and . (dot).
 * 5. An email should not start with "."
 * 6. Email can't contain three consecutive dots (...)
 *
 *
 * { function_description }
 *
 * @param      {<type>}   email   The email
 * @return     {boolean}  { description_of_the_return_value }
 */
function validateEmail(email) {
    if (!isEmpty(email) && emailRegexCheck(email) && emailRegexCheck(email, true) && emailPositioningCheck(email)) {
        return true;
    } else {
        return false;
    }
}

/**
 * { function_description }
 *
 * @param      {<type>}   email             The email
 * @param      {boolean}  [isStrict=false]  Indicates if strict
 * @return     {boolean}  { description_of_the_return_value }
 */
function emailRegexCheck(email, isStrict = false) {
    var strictEmailRegex = /^(?=[A-z0-9][A-z0-9@._%+-]{5,253}$)[A-z0-9._%+-]{1,64}@(?:(?=[A-z0-9-]{1,63}\.)[A-z0-9]+(?:-[A-z0-9]+)*\.){1,8}[A-z]{2,7}$/;
    var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,7})+$/;
    if (isStrict) {
        emailRegex = strictEmailRegex;
    }
    if (email.match(emailRegex)) {
        return true;
    } else {
        return false;
    }
}

/**
 * { function_description }
 *
 * @param      {<type>}   email   The email
 * @return     {boolean}  { description_of_the_return_value }
 */
function emailPositioningCheck(email) {
    var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");
    var len = email.length;
    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= len) {
        return false;
    }
    return true;
}

/**
 * Determines if empty.
 *
 * @param      {<type>}   email   The email
 * @return     {boolean}  True if empty, False otherwise.
 */
function isEmpty(email) {
    if (email == "" || !email) {
        return true;
    }
    return false;
}

/**
 * { PHONE NUMBER }
 *
 * 1. Matches US and Canadian phone number only. Country code (+1) is optional.
 *
 * { function_description }
 *
 * @param      {<type>}   phone   The phone
 * @return     {boolean}  { description_of_the_return_value }
 */
function validatePhone(phone) {
    // // Be in form +1-306-664-6411 or 1-306-664-6411 or 1306-664-6411 or 306-664-6411 or 13066646411 or 13066646411 format
    var phoneRegex = /(\+1|\+1-|1|1-)?\(?\d{3}\)?-? *\d{3}-? *-?\d{4}/;

    if (phone.match(phoneRegex)) {
        return true;
    } else {
        return false;
    }
}