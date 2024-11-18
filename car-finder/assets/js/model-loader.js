
(function($)
{
    var last_make = '';
    
    $(document).ready(function(){
        $('select[name=make]').change(function(){
            var make = $(this).val();
            
            if(make !== last_make)
            {
                last_make = make;
                make = escape(make);
                
                url = 'ajax.php?action=models&make=' + make;
                $('select[name=model]').attr('disabled', 'disabled');
                $('button[type=submit]').attr('disabled', 'disabled');
                $('button[type=submit]').css('background-color', '#aaa');
                $.ajax({
                    dataType: "json",
                    url: url,
                    data: '',
                    success: function(data){
                        $('select[name=model]').removeAttr('disabled');
                        $('button[type=submit]').removeAttr('disabled');
                        $('button[type=submit]').css('background-color', '#4486F8');
                        $('select[name=model]').html('<option value="" selected>Model (any)</option>');
                        $.each(data, function(i, model){
                            $('select[name=model]').append('\n<option value="' + model + '">' + model + '</option>');
                        });
                    }
                });
            }
        });
        $('input[data-type="number"]').keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                 // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) || 
                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    });
})(jQuery);