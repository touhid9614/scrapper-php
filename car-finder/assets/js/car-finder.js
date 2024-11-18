(function($)
{
    var busy = true;
    var page = 1;
    
    $(document).ready(function(){
        
        page = $('#page_number').val();
        
        /*
        $(window).scroll(function(){
            if($(window).scrollTop() === $(document).height() - $(window).height())
            {
                load_infinite();
            }
        });
        */
        
        $('select').change(function(){
            load_new_filters();
        });
        
        $('input').change(function(){
            load_new_filters();
        });
        
        busy = false;
    });
    
    function load_new_filters()
    {
        if(busy) return;
        busy = true;
        page = 1;
        $('.car-container').html('');
        do_load();
    }
    
    function load_infinite()
    {
        if(busy) return;
        busy = true;
        page++;
        do_load();
    }
    
    function do_load()
    {
        var data = $('#filter-form').serialize();
        data += '&page=' + page + '&t=' + $.now();
        pause_edit();
        var url = 'ajax.php?action=cars&' + data;
        $.ajax({
            dataType: "json",
            url: url,
            data: '',
            success: function(data){
                html = '<div class="result-count">\n' + data.count + '\n</div>';
                $.each(data.cars, function(i, car){
                    html += '\n';
                    html += car_to_html(car);
                });
                html += '\n' + data.pagination;
                $('.car-container').append(html);
                resume_edit();
                busy = false;
            }
        });
    }
    
    function pause_edit()
    {
        $('select').attr('disabled', 'disabled');
        $('input').attr('disabled', 'disabled');
        $('#ajax-loader').css('display', 'block');
    }
    
    function resume_edit()
    {
        $('select').removeAttr('disabled');
        $('input').removeAttr('disabled');
        $('#ajax-loader').css('display', 'none');
    }
    
    function car_to_html(car)
    {
        var html = '';
        
        if(car)
        {
            html += "<div class=\"car\">\n";
            html += "<div>\n";
            html += "<a class=\"title\" href=\"" + car.url + "\">"
            html += car.title + "</a>\n";
            html += "</div>\n";
            html += "<div class=\"content clearfix\">\n";
            html += "<div class=\"image\">\n";
            var image = car.image;
            if(image === '') image = 'assets-new/images/img0008.png';
            html += "<img src=\"" + image + "\" alt=\"\"/>\n";
            html += "</div>\n";
            html += "<div class=\"details\">\n";
            html += "<a href=\"" + car.url + "\">" + car.url + "</a>\n";
            if(car.odometer !== '')
            {
                html += "<span class=\"odometer\">" + car.odometer + "</span>\n";
            }
            if(car.days !== '')
            {
                html += "<span class=\"days\">" + car.days + "</span>\n";
            }
            if(car.distance !== '')
            {
                html += "<span class=\"distance\">" + car.distance + "</span>\n";
            }
            html += "</div>\n";
            html += "</div>\n";
            html += "</div>";
        }
        
        return html;
    }
    
})(jQuery);