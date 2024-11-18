(function($) {
    $(document).ready(function() {
        $(window).resize();
        $(window).on("message", function(e) {
            var data = e.originalEvent.data;
            $('input[name="path"]').val(data);
            $('input[name="act"]').val('get');
            $('input[name="onclick"]').val('');
            data = $('#hook-form').serialize();
            var request = $.ajax({
                cache: false,
                url: 'ajax.php',
                method: 'POST',
                data: data
            });
            request.done(function(data) {
                if (typeof(data.error) != "undefined" && data.error !== null) {
                    alert(data.error.message);
                } else {
                    if (data.has_tracker) {
                        $('input[name="onclick"]').val(data.tracker);
                    }
                }
            });
            request.fail(function(jqXHR, textStatus) {
                alert('Unable to load data, please refresh the page');
            });
        });
        $('#hook-form').submit(function() {
            $('input[name="act"]').val('save');
            data = $(this).serialize();
            var request = $.ajax({
                cache: false,
                url: 'ajax.php',
                method: 'POST',
                data: data
            });
            request.done(function(data) {
                if (typeof(data.error) != "undefined" && data.error !== null) {
                    alert(data.error.message);
                } else {
                    alert(data.message);
                }
            });
            request.fail(function(jqXHR, textStatus) {
                alert('Unable to save data, please refresh the page');
            });
            return false;
        });
    });
    $(window).resize(function() {
        h = $(this).height();
        h1 = $('.address-bar').outerHeight(true);
        h2 = $('.hook-editor').outerHeight(true);
        height = h - (h1 + h2 + 10);
        $('#content-frame').height(height);
    });
})(jQuery);