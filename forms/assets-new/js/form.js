var sMedia = sMedia || {};

(function ($)
{
    $.fn.sizeChanged = function (handleFunction)
    {
        var element = this;
        var lastWidth = element.width();
        var lastHeight = element.height();

        setInterval(function ()
        {
            if (lastWidth === element.width() && lastHeight === element.height())
            {
                return;
            }

            if (typeof (handleFunction) === 'function')
            {
                handleFunction({ width: lastWidth, height: lastHeight },
                    { width: element.width(), height: element.height() });

                lastWidth = element.width();
                lastHeight = element.height();
            }
        }, 100);

        return element;
    };

}(jQuery));



$(function ()
{
    var form   =
        {
            action  : 'loaded',
            width   : $('section#form-section div.body').outerWidth(),
            height  : $('section#form-section div.body').outerHeight(),
            name    : $('title').html().replace('sMedia Form :: ', '')
        };

    window.parent.postMessage(form, '*');

    $('input[name="form"]').val(form.name);

    $('section#form-section div.body').sizeChanged(function()
    {
        if ($('section#form-section').css('display') === 'none')
        {
            return;
        }

        form   =
            {
                action  : 'resize',
                width   : $('section#form-section div.body').outerWidth(),
                height  : $('section#form-section div.body').outerHeight(),
                name    : $('title').html().replace('sMedia Form :: ', '')
            };

        if (form.width > 0 && form.height > 0)
        {
            window.parent.postMessage(form, '*');
        }
    });

    $('section#thank-you-section div.body').sizeChanged(function()
    {
        if ($('section#thank-you-section').css('display') === 'none')
        {
            return;
        }

        form   =
            {
                action  : 'resize',
                width   : $('section#thank-you-section div.body').outerWidth(),
                height  : $('section#thank-you-section div.body').outerHeight(),
                name    : $('title').html().replace('sMedia Form :: ', '')
            };

        if (form.width > 0 && form.height > 0)
        {
            window.parent.postMessage(form, '*');
        }
    });

    $('[name="first_name"]').blur(function(e)
    {
        if (isFieldEmpty(document.getElementsByName('first_name')[0]))
        {
            document.getElementsByName('first_name')[0].style.borderColor = 'red';
            showPopover('first_name', 'What\'s your first name?');}
        else
        {
            if (document.getElementById("cs_first_name_error_popover"))
            {
                removeElement("cs_first_name_error_popover");
            }

            document.getElementsByName('first_name')[0].style.borderColor = 'green';
        }
    });

    $('[name="last_name"]').blur(function(e)
    {
        if (isFieldEmpty(document.getElementsByName('last_name')[0]))
        {
            document.getElementsByName('last_name')[0].style.borderColor = "red";
            showPopover('last_name', 'Enter your last name - let\'s make things official');
        }
        else
        {
            if (document.getElementById("cs_last_name_error_popover"))
            {
                removeElement("cs_last_name_error_popover");
            }

            document.getElementsByName('last_name')[0].style.borderColor = "green";
        }
    });


    $('[name="email_address"]').blur(function(e)
    {
        if (!validateEmail(document.getElementsByName('email_address')[0]))
        {
            document.getElementsByName('email_address')[0].style.borderColor = "red";
            showPopover('email_address', 'Tell us your email address');
        }
        else
        {
            if (document.getElementById("cs_email_address_error_popover"))
            {
                removeElement("cs_email_address_error_popover");
            }

            document.getElementsByName('email_address')[0].style.borderColor = "green";
        }
    });


    $('#phone_number').blur(function(e)
    {
        if (!validatePhone(document.getElementsById('phone_number')))
        {
            document.getElementsById('phone_number').style.borderColor = "red";
            showPopover('phone_number', 'Entering your phone number helps us to get in touch faster.');
        }
        else
        {
            if (document.getElementById("cs_phone_number_error_popover"))
            {
                removeElement("cs_phone_number_error_popover");
            }

            document.getElementsById('phone_number').style.borderColor = "green";
        }
    });


    $('[name="car_year"]').blur(function(e)
    {
        if (isFieldEmpty(document.getElementsByName('car_year')[0]))
        {
            document.getElementsByName('car_year')[0].style.borderColor = "red";
            showPopover('year_make_model', 'Let\'s get to know your car');
        }
        else
        {
            if (document.getElementById("cs_year_make_model_error_popover"))
            {
                removeElement("cs_year_make_model_error_popover");
            }
            document.getElementsByName('car_year')[0].style.borderColor = "green";
        }
    });


    $('[name="car_make"]').blur(function(e)
    {
        if (isFieldEmpty(document.getElementsByName('car_make')[0]))
        {
            document.getElementsByName('car_make')[0].style.borderColor = "red";
            showPopover('year_make_model', 'Let\'s get to know your car');
        }
        else
        {
            if (document.getElementById("cs_year_make_model_error_popover"))
            {
                removeElement("cs_year_make_model_error_popover");
            }

            document.getElementsByName('car_make')[0].style.borderColor = "green";
        }
    });

    $('[name="car_model"]').blur(function(e)
    {
        if (isFieldEmpty(document.getElementsByName('car_model')[0]))
        {
            document.getElementsByName('car_model')[0].style.borderColor = "red";
            showPopover('year_make_model', 'Let\'s get to know your car');
        }
        else
        {
            if (document.getElementById("cs_year_make_model_error_popover"))
            {
                removeElement("cs_year_make_model_error_popover");
            }

            document.getElementsByName('car_model')[0].style.borderColor = "green";
        }
    });

    $('form').submit(function(e)
    {
        e.preventDefault();

        if (!$(this).valid())
        {
            return false;
        }

        var isValid = true;

        //Validate Email
        // if (!validateEmail(document.getElementsByName('email_address')[0]))
        // {
        //     document.getElementsByName('email_address')[0].style.borderColor = "red";
        //     isValid = false;
        // }
        // else
        // {
        //     document.getElementsByName('email_address')[0].style.borderColor = '';
        // }

        //Validate Phone
        if (!validatePhone(document.getElementsByName('phone_number')[0]))
        {
            document.getElementsByName('phone_number')[0].style.borderColor = "red";
            isValid = false;
        }
        else
        {
            document.getElementsByName('phone_number')[0].style.borderColor = '';
        }

        if (!isValid)
        {
            $('div.alerts').removeClass('hidden');

            return false;
        }
        else
        {
            $('div.alerts').addClass('hidden');
        }

        window.parent.postMessage({ action: 'loading' }, '*');

        post_data = $(this).serialize();
        console.log("post_data" + post_data);

        $.ajax({
            type  : "POST",
            url   : "https://tm.smedia.ca/services/sm-ai-buttons.php",
            data  : post_data,
            crossDomain   : true
        })
            .done(function(data, textStatus, jqXHR)
            {
                console.log("data=" + data);

                if(data.success)
                {
					if(!data.redirect_url) {
						$('#thank-you-section').css('display', 'block');
					}
                    $('#form-section').css('display', 'none');

                    form   =
                        {
                            action  : 'loaded',
                            width   : $('section#thank-you-section div.body').outerWidth(),
                            height  : $('section#thank-you-section div.body').outerHeight(),
                            name    : $('title').html().replace('sMedia Form :: ', '')
                        };

                    window.parent.postMessage(form, '*');
                    window.parent.postMessage(
						{
							action: "fillup",
							redirect_url: data.redirect_url,
						},
						"*"
					);

                }
                else
                {
                    submission_error(data.message);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown)
            {
                submission_error(textStatus);
            })
            .always(function()
            {

            });

        return false;
    });

    $('#form-close-btn').click(function () {
        window.parent.postMessage({action  : 'close',}, '*');
    });

    sMedia.Form =
        {
            device          : function(data)
            {
                $('body').removeClass('desktop');
                $('body').removeClass('mobile');
                $('body').addClass(data.device);
            },

            set_params      : function(params)
            {
                $.each(params.data, function( key, value )
                {
					if (key === 'text_value' && !!value) {
                    {
                        $('button.action-btn').html(value);
                    }

                    if (key === 'disclaimer' && value !== '')
                    {
                        $("div.security-label").after('<div class="disclaimer-text">' + value + '</div>');

                        return;
                    }

                    if ($('input[name=' + key + ']').length > 0)
                    {
                        $('input[name=' + key + ']').val(value);
                    }
                    else
                    {
                        elem = document.createElement('input');
                        elem.type = 'hidden';
                        elem.name = key;
                        elem.value = value;
                        document.getElementsByTagName("form")[0].appendChild(elem);
                    }
                });
            }
        };

    window.addEventListener("message", receiveMessage, false);

    function receiveMessage(event)
    {
        console.log("IFrame Message received");
        console.log(event.data);

        if (typeof sMedia.Form[event.data.action] === 'function')
        {
            sMedia.Form[event.data.action](event.data);
        }
    }


    function submission_error(error)
    {
        form        =
            {
                action  : 'loaded',
                width   : $('section#form-section div.body').outerWidth(),
                height  : $('section#form-section div.body').outerHeight(),
                name    : $('title').html().replace('sMedia Form :: ', '')
            };

        window.parent.postMessage(form, '*');

        alert('Unable to submit. Error: ' + error);
    }


    /**
     * Track form abandonment
     */
    $(':input').blur(function ()
    {
        form        =
            {
                action  : 'input_changed',
                status  : null,
                field   : $(this).attr('name')
            };

        if ($(this).val().length > 0)
        {
            form.status = 'Completed';
        }
        else
        {
            form.status = 'Skipped';
        }

        window.parent.postMessage(form, '*');
    });
});


function isFieldEmpty(elem)
{
    let myVar = elem.value;

    if (myVar === '' || myVar === null || myVar === undefined)
    {
        return true;
    }

    return false;
}


var popovers        =
{
    first_name      : false,
    last_name       : false,
    email_address   : false,
    phone_number    : false
};


function showPopover(elementName, message)
{
    var trigger             = document.getElementsByName(elementName)[0];
    var popoverID           = "cs_" + elementName + "_error_popover";

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

    for (var elm in popovers)
    {
        if (popovers[elm])
        {
            removeElement('cs_' + elm + '_error_popover');
            popovers[elm]   = false;
        }
    }

    popovers[elementName]   = true;
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
