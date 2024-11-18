$(document).ready(function()
{
    $('.copy_disable').bind("cut copy paste", function(e)
    {
        e.preventDefault();
        e.stopPropagation();

        $('.copy_disable').bind("contextmenu", function(e)
        {
            e.preventDefault();
            e.stopPropagation();
        });
    });
});
