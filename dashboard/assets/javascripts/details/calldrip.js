let callDripSelector    = '#general > form > div:nth-child(5) > div:nth-child(1) > div > div > select';
let popoverTimeOut      = 5000;

$(document).ready(function()
{
    $('.timepicker').timepicker(
    {
        timeFormat: 'HH:mm'
    });
});

try
{
    $('#sale_num').popover('hide');
}
catch(err)
{

}

var calldrip = document.querySelector(callDripSelector);

if (calldrip && calldrip.value == 1)
{
    $('#calldrip_area').show();
    $('#calldrip_area input').prop('required', true);
}
else
{
    $('#calldrip_area input').prop('required', false);
    $('#calldrip_area').hide();
}


/**
 * Shows the hide call drip.
 */
function showHideCallDrip()
{
    var calldrip = document.querySelector(callDripSelector);
    if (calldrip && calldrip.value == 1)
    {
        $('#calldrip_area').show();
        $('#calldrip_area input').prop('required', true);

    }
    else
    {
        $('#calldrip_area input').prop('required', false);
        $('#calldrip_area').hide();
        if (document.getElementById("details_submit_btn").className.includes("disable-submit-btn"))
        {
            document.getElementById("details_submit_btn").classList.remove("disable-submit-btn");
        }
    }
}


/**
 * Adds a new column.
 *
 * @param      {<type>}  param   The parameter
 */
function addNewColumn(param) 
{
    $(param.parentElement.parentElement.parentElement).append('<div class="col-md-12" style="margin-bottom: 10px">\n' +
        '<div class="col-md-3">\n' +
        '<input name="salesman_numbers[]" onmouseout="validatePhoneNumber(this)" class="form-control" type="text" placeholder="XXX-XXX-XXXX or +1XXX-XXX-XXXX" required/>\n' +
        '</div>\n' +
        '<div class="col-md-3">\n' +
        '<input name="calldrip_start_times[]" class="form-control timepicker" value="00:00" placeholder="Start Time" required/>\n' +
        '</div>\n' +
        '<div class="col-md-3">\n' +
        '<input name="calldrip_end_times[]" class="form-control timepicker" value="23:59" placeholder="End Time" required/>\n' +
        '</div>\n' +
        '<div class="col-md-1">\n' +
        '<button class="btn" type="button" onclick="addNewColumn(this)"><i class="fa fa-plus"></i></button>\n' +
        '</div>\n' +
        '<div class="col-md-1">\n' +
        '<button class="btn" onclick="deleteColumn(this)" type="button"><i class="fa fa-trash"></i></button>\n' +
        '</div>\n' +
        '</div>');
    $('.timepicker').timepicker(
    {
        timeFormat: 'HH:mm'
    });
}


/**
 * { function_description }
 *
 * @param      {<type>}  param   The parameter
 */
function deleteColumn(param) 
{
    $(param.parentElement.parentElement).remove();
}


var popovers            =
{
    salesman_numbers    : false
};


/**
 * Shows the popover.
 *
 * @param      {string}  [elementName="salesman_numbers"]                                      The element name
 * @param      {string}  [message="Please provide valid american or caandian phone numbers."]  The message
 */
function showPopover(elementName = "salesman_numbers", message = "Please provide valid american or caandian phone numbers.")
{
    var trigger             = document.getElementsByName(elementName)[0];
    var popoverID           = elementName + "_error";

    if (document.getElementById(popoverID))
    {
        return;
    }

    var popover             = document.createElement('div');

    popover.setAttribute("id", popoverID);
    popover.classList.add('cs-popover', 'cs-popover-bottom');

    popover.innerText       = message;

    var triggerRect         = trigger.getBoundingClientRect();
    var triggerTop          = triggerRect.top;
    var triggerLeft         = triggerRect.left;
    var triggerHeight       = triggerRect.height;
    var triggerWidth        = triggerRect.width;

    popover.style.top       = `${triggerTop + triggerHeight}px`;
    popover.style.left      = `${triggerLeft}px`;
    popover.style.width     = `${triggerWidth - 10}px`;
    popover.style.height    = `${triggerHeight - 22}px`;
    popover.style.position  = 'fixed';

    document.body.appendChild(popover);

    popovers[elementName]   = true;
}


/**
 * { function_description }
 */
function validatePhoneNumber(num)
{
    // Be in form +1306-664-6411 or 306-664-6411
    var phoneRegex = /^(\+1|1\s?)?((\([0-9]{3}\))|[0-9]{3})[\s\-]?[\0-9]{3}[\s\-]?[0-9]{4}$/;

    var calldrip = document.querySelector(callDripSelector);

    if (calldrip && calldrip.value == 0)
    {
        return;
    }

    var invalid = false;

    if (!num.value.match(phoneRegex))
    {
        invalid = true;
        $(num).popover({content: "Please provide valid american or caandian phone numbers.", placement:"top"});
        $('.popover').css('color', 'red');
    }

    if (invalid)
    {
        document.getElementById("details_submit_btn").classList.add("disable-submit-btn");
        $(num).popover({content: "Please provide valid american or caandian phone numbers.", placement:"top"});
        $('.popover').css('color', 'red');
    }
    else
    {
        if (document.getElementById("details_submit_btn").className.includes("disable-submit-btn"))
        {
            document.getElementById("details_submit_btn").classList.remove("disable-submit-btn");
        }

        try
        {
            $(num).popover('hide');

        }
        catch(err)
        {

        }
    }
}


/**
 * { Removes an element. }
 *
 * @param      {<type>}  elementId  The element identifier
 */
function removeElement(elementId)
{
    document.getElementById(elementId).remove();
}


/**
 * Gets the page profile picture.
 *
 * @param      {<type>}  pageId  The page identifier
 */
function getPage(pageId)
{
    if (typeof pageId == 'number')
    {
        pageId = pageId.toString();
    }

    if (!pageId || pageId == '')
    {
        pageId = '251738238196252';
    }

    var image_url_old = `https://graph.facebook.com/${pageId}/picture?app_id=1624969190861580`;
    var new_image_url = image_url_old.replace('251738238196252', pageId);
    var page_url = `https://www.facebook.com/${pageId}`;

	$("#fb_page_image").attr("src", new_image_url);

	window.addEventListener('load', function () {
		const elm = document.getElementById("fb_page_image");
		if (elm) {
			document.getElementById("fb_page_image").addEventListener('click', function () {
				window.open(page_url, '_blank');
			});
		}
	});
}

window.onload = function()
{
    var pageId = $("#fb_page_id").val();
    getPage(pageId);
};