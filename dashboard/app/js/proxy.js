/* jshint -W104 */
/* jshint -W119 */

/*function showEditModal(email, name, role)
{
    $("#edit_email").val(email);
    $("#modal_title").text("User : " + email);
    $("#edit_name").val(name);
    $("div.modal-select select").val(role).change();

    $.magnificPopup.open(
    {
        items:
        {
            src: '#modalForm' // ID of modal that you want to show
        },

        type: 'inline'
    });
}*/

function addProxyInfo()
{
    $.magnificPopup.open(
    {
        items:
        {
            src: '#proxyAddForm' // ID of modal that you want to show
        },

        type: 'inline'
    });

    let orderIdError  = true;
    let dueDateError  = true;
    let quantityError = true;
    let priceError    = true;

    $('#new_order_id').on('change', function ()
    {
        var new_order_id = $('#new_email').val();

        if (new_order_id.length === 0)
        {
            setProxyError($('#new_order_id'), $('#order_id_error_msg'), "This field is required");
            orderIdError = true;
        }
        else
        {
            if (/\s/.exec(new_order_id))
            {
                setProxyError($('#new_order_id'), $('#order_id_error_msg'), "No white space is allowed");
                orderIdError = true;
            }
            else
            {
                removeProxyError($('#new_order_id'), $('#order_id_error_msg'));
                orderIdError = false;
            }
        }
    });

    $('#new_due_date').on('change', function ()
    {
        var new_due_date = $('#new_due_date').val();

        if (new_due_date.length === 0)
        {
            setProxyError($('#new_due_date'), $('#due_date_error_msg'), "This field is required");
            dueDateError = true;
        }
        else
        {
            removeProxyError($('#new_due_date'), $('#due_date_error_msg'));
            dueDateError = false;
        }
    });

    $('#new_quantity').on('change', function ()
    {
        var new_quantity = $('#new_quantity').val();

        if (new_quantity.length < 1)
        {
            setProxyError($('#new_quantity'), $('#quantity_error_msg'), "Minimum 1 IP is required");
            quantityError = true;
        }
        else
        {
            removeProxyError($('#new_quantity'), $('#quantity_error_msg'));
            quantityError = false;
        }
    });

    $('#new_price').on('change', function ()
    {
        var new_price = $('#new_price').val();

        if (new_price.length < 1)
        {
            setProxyError($('#new_price'), $('#price_error_msg'), "Minimum 1 usd is required");
            priceError = true;
        }
        else
        {
            removeProxyError($('#new_price'), $('#price_error_msg'));
            priceError = false;
        }
    });
}

function setProxyError(field, msgId, msg)
{
    field.css('border-color','red');
    msgId.text(msg);
}

function removeProxyError(field, msgId)
{
    field.css('border-color', '');
    msgId.text('');
}

$(document).on("click", ".open-homeEvents", function () {
    let delete_id = $(this).data('id');
    let text      = `Do You Want to deactivate proxy purchase order with order id:: <b>${delete_id}</b> ?`;

    $('#delete_id').html(delete_id);
    $('#acc_id').html(text);
    document.getElementById("delete_id").value = delete_id;
});