var vaildForm = false;

/**
 * { EMAIL }
 * 
 * 1. Email id must contain the @ and . character
 * 2. There must be at least one character before and after the @.
 * 3. There must be at least two characters after . (dot).
 * 4. There must be at least one character between @ and . (dot).
 * 5. An email should not be start with "."
 * 6. Email can't contain three consecutive dots (...)
 *  
 */


var strictEmailRegex 	= /^(?=[A-z0-9][A-z0-9@._%+-]{5,253}$)[A-z0-9._%+-]{1,64}@(?:(?=[A-z0-9-]{1,63}\.)[A-z0-9]+(?:-[A-z0-9]+)*\.){1,8}[A-z]{2,7}$/;
var simpleEmailRegex 	= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,7})+$/;


function validateEmail(email)
{
	if(!isEmpty(email))
	{
		if (emailRegexCheck(email))
		{
			if (emailRegexCheck(email, true))
			{
				var isOkay = emailPositioningCheck(email);
				
				if (isOkay)
				{
					vaildForm = true;

					return true;
				}
				else
				{
					console.log("Invalid Email. Position of @ and (.) isn't standard.");

					if (vaildForm)	
					{
						vaildForm = false;
					}

					return false;
				}
			}
			else
			{
				console.log("Invalid Email. Strict regex failed!");

				if (vaildForm)	
				{
					vaildForm = false;
				}

				return false;
			}
		}
		else
		{
			console.log("Invalid Email. Simple regex failed!");

			if (vaildForm)	
			{
				vaildForm = false;
			}

			return false;
		}
	}
	else
	{
		console.log("Email can't be empty.");

		if (vaildForm)
		{
			vaildForm = false;
		}

		return false;
	}
}


function emailRegexCheck(email, isStrict = false)
{
	var emailRegex = simpleEmailRegex;

	if (isStrict)
	{
		emailRegex = strictEmailRegex;
	}

	if(email.value.match(emailRegex))
	{
		return true;
	}
	else
	{
		return false;
	}
}


function emailPositioningCheck(email)
{
	var atpos 	= email.value.indexOf("@");  
	var dotpos 	= email.value.lastIndexOf(".");
	var len 	= email.value.length;


	if (atpos < 1 || dotpos < atpos+2 || dotpos+2 >= len)
	{
		var str = "Please enter a valid e-mail address. \n Postion of @ : " + atpos + "\n Position of dot(.) : " + dotpos;
		console.log(str);
		return false;
	}

	return true;
}


function isEmpty(email)
{
	if (email.value == "" || !email.value)
	{
		return true;
	}

	return false;
}


/**
 * { PHONE NUMBER }
 * 
 * 1. Matches US and Canadian phone number only. Country code (+1) is optional.
 * 
 */


var phoneRegex = /^((\+1)|1|(1-)|(\+1-)\s?)?((\([0-9]{3}\))|[0-9]{3})[\s\-]?[\0-9]{3}[\s\-]?[0-9]{4}$/;

function validatePhone(phone)
{
	if (phone.value.match(phoneRegex))
	{
        phone.removeAttribute('title');
        validForm = true;

        return true;      
	}
	else
	{
        phone.setAttribute('title' , 'Please provide a valid North American or Canadian phone number');
        console.log("Not a valid Phone Number");

        if (vaildForm)
        {
        	vaildForm = false;
        }

        return false;
	}
}