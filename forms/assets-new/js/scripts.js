$(function () 
{
    // Add smedia class to body for jquery-ui with css scope
    $('body').addClass('smedia');

    // Open modals
    $('.open-modal').click(function (e) 
    {
        e.preventDefault();

        var modal_id = $(this).data('target');

        console.log(modal_id);

        $('#' + modal_id).addClass('is-active');
    });

    // Close modals
    $('.modal-close').click(function (e) 
    {
        e.preventDefault();

        $(this).parents('.modal').removeClass('is-active');
    });

    $("form").each(function () 
    {
        $(this).validate(
        {
            invalidHandler: function (event, validator) 
            {
                var errors = validator.numberOfInvalids();
                if (errors) 
                {
                    $(this).find(".errors-alerts").removeClass('is-hidden');
                    $(this).find(".alerts").removeClass('hidden');
                } 
                else 
                {
                    $(this).find(".errors-alerts").addClass('is-hidden');
                    $(this).find(".alerts").addClass('hidden');
                }
            },

            submitHandler: function(form) 
            {

            },

            errorClass: "is-danger",
            errorPlacement: function(error, element) 
            {

            }
        });
    });


    $('.clear-action-addressLine1').click(function () 
    {
        $('#addressLine1').val('');
    });

    $("#datepickerDemoJQuery").datepicker(
    {
       dateFormat: "d MM yy"
    });
});