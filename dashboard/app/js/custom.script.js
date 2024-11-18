/**
 * Adds a parameter to url.
 *
 * @param      {<type>}  element  The element
 * @param      {string}  id       The identifier
 */
function addParamToURL(element, id)
{
    var status = $("#" + id).val();

    $(element).attr('href', function ()
    {
        return this.href + '&status=' + status;
    });
}

 
/**
 * Changes dealerships active status
 *
 * @param      {string}  dealership  The dealership
 */
function changeDealershipStatus(dealership)
{
    var status = $("#status_" + dealership).val();
    jQuery.ajax(
    {
        url: 'change-dealership-status.php',
        method: 'POST',
        data: 'dealership=' + dealership + '&status=' + status
    }).done(function ()
    {
        location.reload();
    });
}


$(document).ready(function ()
{
    var tabhash = localStorage.getItem("tabhash");

    if (tabhash) 
    {
        $("a[href='" + tabhash + "']").tab("show");
    }

    $(document.body).on("click", "a[data-toggle]", function () 
    {
        localStorage.setItem("tabhash", this.getAttribute("href"));
    });
});



$(function () 
{
    $('#dynamic_select').on('change', function () 
    {
        var str = '?dealership=';
        var url = str + $(this).val(); // get selected value

        if (url) 
        { // require a URL
            window.location = url; // redirect
        }

        return false;
    });
});


/**
 * { function_description }
 *
 * @param      {<type>}   form    The form
 * @return     {boolean}  { description_of_the_return_value }
 */
function confSubmit(form) 
{
    if (confirm("Are you sure you want to Cleart Data & Launch Button?")) 
    {
        form.submit();
    } 
    else 
    {
        return false;
    } 
}