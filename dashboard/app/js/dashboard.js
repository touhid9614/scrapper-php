/**
 * { function_description }
 *
 * @return     {Object}  { description_of_the_return_value }
 */
jQuery.fn.smToggleSwitch = function()
{
    this.each(function()
    {
        let ts = $(this);
        let input = $(ts.find('input').get(0));
        let checked = input.is(':checked');
        let value = checked == true ? 'Yes' : 'No';

        ts.removeClass('yes no');

        if (checked)
        {
            ts.addClass('yes')
        }
        else
        {
            ts.addClass('no')
        }

        let label = $('<label for="'+input.attr('id')+'"><span class="toggle"></span><span class="value">' + value + '</span></label>').insertAfter(input);

        input.click(function(e)
        {
            let input = $(this);
            input.parent().removeClass('yes no');

            if (input.is(':checked'))
            {
                input.parent().addClass('yes')
                label.find('.value').text('Yes');
            }
            else
            {
                input.parent().addClass('no');
                label.find('.value').text('No');
            }
        })
    })

    return this;
};


(function ($)
{
    var plot_options =
    {
        series:
        {
            lines:
            {
                show: true,
                lineWidth: 2
            },

            points:
            {
                show: true
            },

            shadowSize: 0
        },

        grid:
        {
            hoverable: true,
            clickable: true,
            borderColor: '#EDEDED',
            borderWidth: 1,
            labelMargin: 15,
            backgroundColor: '#FFF'
        },

        yaxis:
        {
            min: 0,
            color: '#EDEDED'
        },

        xaxis:
        {
            mode: 'categories',
            color: '#FFF'
        },

        legend:
        {
            show: false
        },

        tooltip: true,
        tooltipOpts:
        {
            content: '%x: %y',
            shifts:
            {
                x: -30,
                y: 25
            },

            defaultTheme: false
        }
    };

    var ctr_plot_options =
    {
        series:
        {
            lines:
            {
                show: true,
                lineWidth: 2
            },

            points:
            {
                show: true
            },

            shadowSize: 0
        },

        grid:
        {
            hoverable: true,
            clickable: true,
            borderColor: '#EDEDED',
            borderWidth: 1,
            labelMargin: 15,
            backgroundColor: '#FFF'
        },

        yaxis:
        {
            min: 0,
            color: '#EDEDED'
        },

        xaxis:
        {
            mode: 'categories',
            color: '#FFF'
        },

        legend:
        {
            show: false
        },

        tooltip: true,
        tooltipOpts:
        {
            content: '%x: %y%',
            shifts:
            {
                x: -30,
                y: 25
            },

            defaultTheme: false
        }
    };

    if (typeof sold_vs_engaged !== 'undefined' && sold_vs_engaged)
    {
        //Load sold vs engaged
        url = '/adwords3/sold-vs-engaged.php?dealership=' + escape(gup('dealership'));

        var request = $.ajax(
        {
            cache: false,
            url: url
        });

        request.done(function (data)
        {
            if (!data)
            {
                alert("There was an error processing your request!");
            }
            else
            {
                var lebels = [];
                var engagedUsers = [];
                var soldCars = [];

                $.each(data, function (key, value)
                {
                    lebels.push(key);
                    engagedUsers.push((value.engaged_users / value.vehicle_sold));
                    soldCars.push(value.vehicle_sold);
                });

                new Chartist.Line('#engaged-user-chart',
                {
                    labels: lebels,
                    series:
                    [
                        engagedUsers
                    ]
                });

//                new Chartist.Line('#sold-vehicle-chart',
//                {
//                    labels: lebels,
//                    series:
//                    [
//                        soldCars
//                    ]
//                });
            }
        });
    }

    if(typeof report_smart_offer !== 'undefined' && report_smart_offer) {
        url = 'ajax.php?act=monthlyFillUpView&dealership=' + escape(gup('dealership'));

        var request = $.ajax({
            cache: false,
            url: url
        });

        request.done(function (data) {
            if (typeof (data.error) != "undefined" && data.error !== null) {
                alert(data.error.message);
            } else {
                var lebels = [];
                var monthlyFillUps = [];
                var monthlyViews = [];

                $.each(data, function (key, value) {
                    lebels.push(key);
                    value.fillUp = (value.fillUp === undefined || value.fillUp == null || value.fillUp.length <= 0) ? 0 : value.fillUp;
                    value.view = (value.view === undefined || value.view == null || value.view.length <= 0) ? 0 : value.view;
                    monthlyFillUps.push(value.fillUp);
                    monthlyViews.push(value.view);
                });

                new Chartist.Line('#monthlyFillUps', {
                    labels: lebels,
                    series: [
                        monthlyFillUps
                    ]
                },);

                new Chartist.Line('#monthlyViews', {
                    labels: lebels,
                    series: [
                        monthlyViews
                    ]
                });
            }
        });

        request.fail(function (jqXHR, textStatus)
        {
            alert('Unable to load data, please refresh the page');
        });
    }

    if (typeof dashboard !== 'undefined' && dashboard) {

        $('#salesSelector').themePluginMultiSelect().on('change', function () {
            var rel = $(this).val();
            $('#salesSelectorItems .chart').removeClass('chart-active').addClass('chart-hidden');
            $('#salesSelectorItems .chart[data-sales-rel="' + rel + '"]').addClass('chart-active').removeClass('chart-hidden');
        });

        $('#salesSelector').trigger('change');
        $('#salesSelectorWrapper').addClass('ready');


        /**
         * Loads once monthly.
         */
        function load_monthly()
        {
           // show_progress('Loading 3 of 3');

            url = 'ajax.php?act=monthly&dealership=' + escape(gup('dealership'));

            var request = $.ajax({
                cache: false,
                url: url
            });

            request.done(function (data)
            {
                if (typeof (data.error) != "undefined" && data.error !== null)
                {
                    alert(data.error.message);
                }
                else
                {
                    var monthlyClicks = [{data: [], color: "#2baab1"}];
                    var monthlyImpressions = [{data: [], color: "#2baab1"}];
                    var monthlyCTR = [{data: [], color: "#2baab1"}];

                    $.each(data, function (key, value)
                    {
                        monthlyClicks[0].data.push([key, value.clicks]);
                        monthlyImpressions[0].data.push([key, value.impressiosn]);
                        monthlyCTR[0].data.push([key, value.ctr]);
                    });

                    $.plot('#monthlyClicks', monthlyClicks, plot_options);
                    $.plot('#monthlyImpressions', monthlyImpressions, plot_options);
                    $.plot('#monthlyCTR', monthlyCTR, ctr_plot_options);

                    hide_progress();
                }
            });

            request.fail(function (jqXHR, textStatus)
            {
                alert('Unable to load data, please refresh the page');
            });
        }


        /**
         * Loads once yearly.
         */
        function load_yearly()
        {
           // show_progress('Loading 2 of 3');

            url = 'ajax.php?act=yearly&dealership=' + escape(gup('dealership'));

            var request = $.ajax(
            {
                cache: false,
                url: url
            });

            request.done(function (data)
            {
                if (typeof (data.error) != "undefined" && data.error !== null)
                {
                    alert(data.error.message);
                }
                else
                {
                    var yearlyClicks = [{data: [], color: "#2baab1"}];
                    var yearlyImpressions = [{data: [], color: "#2baab1"}];
                    var yearlyCTR = [{data: [], color: "#2baab1"}];

                    $.each(data, function (key, value)
                    {
                        yearlyClicks[0].data.push([key, value.clicks]);
                        yearlyImpressions[0].data.push([key, value.impressiosn]);
                        yearlyCTR[0].data.push([key, value.ctr]);
                    });

                    $.plot('#yearlyClicks', yearlyClicks, plot_options);
                    $.plot('#yearlyImpressions', yearlyImpressions, plot_options);
                    $.plot('#yearlyCTR', yearlyCTR, ctr_plot_options);

                    load_monthly();
                }
            });

            request.fail(function (jqXHR, textStatus)
            {
                alert('Unable to load data, please refresh the page');
            });
        }


        /**
         * Loads summary.
         */
        function load_summary()
        {
           // show_progress('Loading 1 of 3');

            url = 'ajax.php?act=summary&dealership=' + escape(gup('dealership'));

            var request = $.ajax(
            {
                cache: false,
                url: url
            });

            request.done(function (data)
            {
                if (typeof (data.error) != "undefined" && data.error !== null)
                {
                    alert(data.error.message);
                }
                else
                {
                    $('#totalClicks').html(data.clicks);
                    $('#totalImpressions').html(data.impression);
                    $('#totalCTR').html(data.ctr + '%');
                    $('#totalCost').html('$' + data.cost);
                    $('#meterBudget').val(data.budget);
                    $('#meterBudget').liquidMeter(
                    {
                        shape: 'circle',
                        color: '#0088cc',
                        background: '#F9F9F9',
                        fontSize: '24px',
                        fontWeight: '600',
                        stroke: '#F2F2F2',
                        textColor: '#333',
                        liquidOpacity: 0.9,
                        liquidPalette: ['#333'],
                        speed: 3000,
                        animate: !$.browser.mobile
                    });

                    load_yearly();
                }
            });

            request.fail(function (jqXHR, textStatus)
            {
                alert('Unable to load data, please refresh the page');
            });
        }

        load_summary();
    }

    if (typeof bounce_rate_page !== 'undefined' && bounce_rate_page)
    {
        /**
         * Loads bounce rates.
         */
        function load_bounce_rates()
        {
            show_progress('Loading, It may take a while');

            url = 'ajax.php?act=bouncerate';

            var request = $.ajax(
            {
                cache: false,
                url: url
            });

            request.done(function (data)
            {
                if (typeof (data.error) != "undefined" && data.error !== null)
                {
                    alert(data.error.message);
                }
                else
                {
                    var avgBounceRate = [{data: [], color: "#2baab1"}];

                    $.each(data, function (key, value)
                    {
                        avgBounceRate[0].data.push([key, value]);
                    });

                    $.plot('#avgBounceRate', avgBounceRate, ctr_plot_options);

                    hide_progress();
                }
            });

            request.fail(function (jqXHR, textStatus)
            {
                alert('Unable to load data, please refresh the page');
            });
        }

        load_bounce_rates();
    }


    /**
     * { function_description }
     *
     * @param      {string}  name    The name
     */
    function gup(name)
    {
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(window.location.href);

        if (results == null)
        {
            return '';
        }
        else
        {
            return results[1];
        }
    }

    if (typeof auto_adjust !== 'undefined' && auto_adjust)
    {
        $(window).load(function () {
            auto_resize();
        });
    } else
    {
        $(window).resize(function () {
            if ($('#page-frame').length > 0) {
                var h = $(window).height() - 120;
                $('#page-frame').height(h);
            }
        });

        $(window).trigger('resize');
    }

    function auto_resize()
    {
        var h = $('#page-frame').contents().find("body").height() + 150;
        $('#page-frame').height(h);
        setTimeout(function () {
            auto_resize();
        }, 250);
    }

    $('.filter-select').change(function () {
        $('input[name="changed"]').val($(this).attr('name'));
        $('#filter-form').submit();
    });

    $('.car-result-data').click(function () {
        stock_number = $(this).attr('car-id');

        url = 'ajax.php?act=get_similar&dealership=' + escape(gup('dealership')) + '&stock_number=' + stock_number
                + '&distance=' + $('select[name="distance"]').val();

        var request = $.ajax({
            cache: false,
            url: url
        });

        request.done(function (data) {
            if (typeof (data.error) != "undefined" && data.error !== null) {
                alert(data.error.message);
            } else
            {
                html = build_row(data.car, true);

                is_odd = false;

                $.each(data.similars, function (stock_number, car) {
                    html += "\n";
                    html += build_row(car, is_odd);
                    is_odd = !is_odd;
                });

                $('#similar-container').html(html);
                $('#similar-vehicles').modal();

                stock_number = data.car.stock_number;

                //Pagination in here
                page_html = '';

                for (i = 1; i <= data.total_pages; i++)
                {
                    page_html += '<a class="similar_link';
                    if (i === data.page)
                        page_html += ' active';
                    page_html += '" href="#" car-id="' + stock_number + '" page="' + i + '">' + i + '</a>\n';
                }

                $('#page-container').html(page_html);
                $('.similar_link').click(function (e) {
                    e.preventDefault();
                    stock_number = $(this).attr('car-id');
                    page = $(this).attr('page');
                    load_page(page, stock_number);
                });
            }
        });

        request.fail(function (jqXHR, textStatus) {
            alert('Unable to load car data, please refresh the page');
        });
    });

    function load_page(page, stock_number)
    {
        url = 'ajax.php?act=get_similar&dealership=' + escape(gup('dealership')) + '&stock_number=' + stock_number
                + '&distance=' + $('select[name="distance"]').val() + '&page=' + page;

        var request = $.ajax({
            cache: false,
            url: url
        });

        $('#similar-container').html('');
        $('.loading-anim').addClass('loading');

        request.done(function (data) {
            if (typeof (data.error) != "undefined" && data.error !== null) {
                alert(data.error.message);
            } else
            {
                $('.loading-anim').removeClass('loading');
                html = build_row(data.car, true);

                is_odd = false;

                $.each(data.similars, function (stock_number, car) {
                    html += "\n";
                    html += build_row(car, is_odd);
                    is_odd = !is_odd;
                });

                $('#similar-container').html(html);
                $('#similar-vehicles').modal();

                stock_number = data.car.stock_number;

                //Pagination in here
                page_html = '';

                for (i = 1; i <= data.total_pages; i++)
                {
                    page_html += '<a class="similar_link';
                    if (i === data.page)
                        page_html += ' active';
                    page_html += '" href="#" car-id="' + stock_number + '" page="' + i + '">' + i + '</a>\n';
                }

                $('#page-container').html(page_html);
                $('.similar_link').click(function (e) {
                    e.preventDefault();
                    stock_number = $(this).attr('car-id');
                    page = $(this).attr('page');
                    load_page(page, stock_number);
                });
            }
        });

        request.fail(function (jqXHR, textStatus) {
            alert('Unable to load similar car data, please refresh the page');
        });
    }

    $(document).ready(function () {
        var loading = false;
        if ($('#search-result-body').length) //on comp-calc page
        {
            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() === $(document).height())  //user scrolled to bottom of the page?
                {
                    if (current_page < page_count && loading === false) //there's more data to load
                    {
                        loading = true; //prevent further ajax loading
                        $('.animation_image').show(); //show loading image

                        current_page++;
                        //load data from the server using a HTTP POST request
                        $.get('search_autoload_process.php?' + query_str + '&page=' + current_page, '', function (data) {

                            $('#search-result-body').append(data); //append received data into the element

                            //hide loading image
                            $('.animation_image').hide(); //hide loading image once data is received

                            loading = false;

                        }).fail(function (xhr, ajaxOptions, thrownError) { //any errors?
                            alert(thrownError); //alert with HTTP error
                            $('.animation_image').hide(); //hide loading image
                            loading = false;
                        });

                    }
                }
            });
        } else if ($('#similar-result-body').length) //on comp-calc page
        {
            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() === $(document).height())  //user scrolled to bottom of the page?
                {
                    if (current_page < page_count && loading === false) //there's more data to load
                    {
                        loading = true; //prevent further ajax loading
                        $('.animation_image').show(); //show loading image

                        current_page++;
                        //load data from the server using a HTTP POST request
                        $.get('similar_autoload_process.php?' + query_str + '&page=' + current_page, '', function (data) {

                            $('#similar-result-body').append(data); //append received data into the element

                            //hide loading image
                            $('.animation_image').hide(); //hide loading image once data is received

                            loading = false;

                        }).fail(function (xhr, ajaxOptions, thrownError) { //any errors?
                            alert(thrownError); //alert with HTTP error
                            $('.animation_image').hide(); //hide loading image
                            loading = false;
                        });

                    }
                }
            });
        }

        $('.happiness-value').change(function () {
            $(this).parent().removeClass(function (index, className) {
                return (className.match(/slider-\S+/g) || []).join(' ');
            });

            var emoContainer = $(this).attr('data-emo');

            if (emoContainer) {
                $(emoContainer).removeClass(function (index, className) {
                    return (className.match(/emo-\S+/g) || []).join(' ');
                });
            }

            if (this.value < 25) {
                $(this).parent().addClass('slider-danger');
                if (emoContainer)
                    $(emoContainer).addClass('emo-mad');
            } else if (this.value >= 25 && this.value <= 50) {
                $(this).parent().addClass('slider-warning');
                if (emoContainer)
                    $(emoContainer).addClass('emo-sad');
            } else if (this.value > 50 && this.value <= 75) {
                $(this).parent().addClass('slider-info');
                if (emoContainer)
                    $(emoContainer).addClass('emo-confused');
            } else if (this.value > 75 && this.value <= 90) {
                $(this).parent().addClass('slider-primary');
                if (emoContainer)
                    $(emoContainer).addClass('emo-smiling');
            } else if (this.value > 90) {
                $(this).parent().addClass('slider-success');
                if (emoContainer)
                    $(emoContainer).addClass('emo-happy');
            }
        });

        $('.happiness-value').change();

        $('.toggle-elem').change(function () {
            var elem            = $(this).attr('data-toggle');
            var add_class       = $(this).attr('data-add-class') || '';
            var remove_class    = $(this).attr('data-remove-class') || 'hidden';
            if(!elem) return;
            if ($(this).is(':checked')) {
                $(elem).removeClass(remove_class);
                $(elem).addClass(add_class);
            } else {
                $(elem).removeClass(add_class);
                $(elem).addClass(remove_class);
            }
        });

        $('#balance_val').change(function() {
            $('#new_label').html('New<br/>' + (100 - this.value) + '%');
            $('#used_label').html('Used<br/>' + this.value + '%');
        });

        $('#balance_val').change();

        $('#smart-offer-save').unbind('click').click(function(e){
            e.preventDefault();
            var form = $('#smartoffer form');
            var vso = form.find('input[name="video_smart_offer"]');
            var url = form.find('input[name="video_url"]');
            var desc = form.find('textarea[name="video_description"]');
            var title = form.find('input[name="video_title"]');
            $('.has-error').removeClass('has-error').find('.help-block').remove();
            if(vso.is(':checked')){
                if(/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/.test(url.val()) == false){
                    url.parents('.form-group').addClass('has-error')
                    $('<span class="help-block">Input a valid youtube video url</span>').insertAfter(url);
                    url.focus();
                    return;
                }
            }

            if(title.val() && title.val().length > 50) {
                title.parents('.form-group').addClass('has-error')
                $('<span class="help-block">Maximum 50 characters allowed. Total: ' + title.val().length + '</span>').insertAfter(title);
                title.focus();
                return;
            }

            if(desc.val() && desc.val().length > 750) {
                desc.parents('.form-group').addClass('has-error')
                $('<span class="help-block">Maximum 750 characters allowed. Total: ' + desc.val().length + '</span>').insertAfter(desc);
                desc.focus();
                return;
            }

            $('#exampleModal').modal();
        });
    });

    var datatableInit = function () {
        overview_table = $('#datatable-default').dataTable({
            lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
            columnDefs: [{orderable: false, targets: 'no-sort'/*[0, 11]*/}],
            order: [[1, 'asc']],
            fnDrawCallback: function (oSettings) {
                $('.dataTables_length label').remove();
                $('.dataTables_length').each(function () {
                    if ($("#btn-export").length === 0) {
                        $(this).append('<button id="btn-export" type="submit" class="btn btn-success" name="export" value="yes">Export to Excel</button>');
                    }
                });
            }
        });

        $('#datatable-default').on('page.dt', function (e, settings) {
            var api = new $.fn.dataTable.Api(settings);
            // Output the data for the visible rows to the browser's console
            // You might do something more useful with it!
            console.log(api.rows({page: 'current'}).data());
        });

        data_tables = $('.table-advanced').dataTable({
            lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
            columnDefs: [{orderable: false, targets: 'no-sort'/*[0, 11]*/}],
            order: [[0, 'asc']]
        });

		prediction_tables = $('.prediction-table').dataTable({
			lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
			columnDefs: [{orderable: false, targets: 'no-sort'/*[0, 11]*/}],
			order: [[4, 'desc']]
		});

		fb_table = $('.fb-table').dataTable({
			lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
			columnDefs: [{orderable: false, targets: 'no-sort'/*[0, 11]*/}],
			order: [[1, 'asc']]
		});

		data_tables = $('.table-advanced-new').dataTable({
			lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
			ordering: false
		});
    };

    $(function () {
        datatableInit();
    });

    $('.sm-toggle-switch').smToggleSwitch();


    $.validator.addMethod("regx", function(value, element, regexpr) {
        return regexpr.test(value);
    });
    /* Jquery validator */
    var validatorConfig = {
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                element.parent().siblings('.help-block').remove();
                error.insertAfter(element.parent());

            } else {
                element.siblings('.help-block').remove();
                error.insertAfter(element);
            }
        },
        success: function (error) {
            error.remove();
        }
    }

    $('#google_ad_campaign').validate(Object.assign({}, validatorConfig, {
        rules: {
            google_account_id: {
                regx: /^\d{3}-\d{3}-\d{4}$/,
                required: true
            },
        },
        messages: {
            google_account_id : {
                regx : "Enter 10 digit google account ID in xxx-xxx-xxxx format."
            }
        },
    }));

    $('#bing_ad_campaign').validate(Object.assign({}, validatorConfig, {
        rules: {
            bing_account_id: {
                regx: /^[1-9]\d{8}$/,
                required: true
            },
        },
        messages: {
            bing_account_id : {
                regx : "Enter 9 digit bing account ID."
            }
        },
    }));

    $('#reset-password').validate(Object.assign({}, validatorConfig, {
        rules : {
            new_pass : {
                minlength : 8
            },
            new_pass_repeat : {
                minlength : 8,
                equalTo : "#password"
            }
        }
    }));

    profile_image_uploader();

    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    var input = document.querySelector('input[type="tel"]');

    if(input){
        var iti = window.intlTelInput(input, {
            utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.3/js/utils.js",
        });

        input.addEventListener('change', function (e)
        {
            if (!iti.isValidNumber())
            {
                create_popover($('input[type="tel"]'), errorMap[iti.getValidationError()])
            }

        });

        input.addEventListener("countrychange", function() {
            input.value = '+' + iti.getSelectedCountryData().dialCode + ' ';
        });
    }
}).apply(this, [jQuery]);

/**
 * Creates a bootstrap popover.
 *
 * @param      {<type>}  message  The message
 */
function create_popover(popover, message)
{
    var options =
        {
            placement:'top',
            trigger:'manual',
            html:true,
            content: message
        };

    //popover.popover('destroy');
    popover.popover(options);
    popover.popover('show');
}

function build_row(car, is_odd)
{
    price_text = '<span class="green">' + car.price + '</span>';
    price_rank_text = '<span class="green">' + car.status.price_rank + '</span>/' + (car.status.total + 1);
    km_rank_text = '<span class="green">' + car.status.km_rank + '</span>/' + (car.status.total + 1);

    if (car.price === 'Please Call')
    {
        price_text = '<span>n/a</span>';
        price_rank_text = 'n/a';
        km_rank_text = 'n/a';
    }

    temp = '<tr class="car-result-data ';
    if (is_odd)
        temp += 'odd';
    else
        temp += 'even';
    temp += '">\n';
    temp += '<td class="title">\n';
    temp += '<span>' + car.year + ' ' + car.make + ' ' + car.model + '</span>\n';
    temp += '<span>#' + car.stock_number + '</span>\n';
    temp += '</td>\n';
    temp += '<td class="image">\n';
    if (car.img)
    {
        temp += '<img src="' + car.img + '" alt="">\n';
    }
    temp += '</td>\n';
    temp += '<td>\n';
    temp += price_text + '\n';
    temp += '</td>\n';
    temp += '<td>\n';
    temp += '<span>' + price_rank_text + '</span>\n';
    temp += '</td>\n';
    temp += '<td>\n';
    temp += '<span>' + km_rank_text + '</span>\n';
    temp += '</td>\n';
    temp += '</tr>';

    return temp;
}

function show_progress(message)
{
    $('.loading-dialog-div').css('display', 'block');
    $('.loading-dialog-animation-div').css('display', 'block');
    $('.loading-dialog-animation-div').html(message);

    if (message == null) {
        $('.loading-dialog-animation-div').width(0);
        $('.loading-dialog-animation-div').css('padding-right', '0px');
    } else {
        $('.loading-dialog-animation-div').width(200);
        $('.loading-dialog-animation-div').css('padding-right', '15px');
    }

    align_progress_dialog();
}

function hide_progress()
{
    $('.loading-dialog-div').css('display', 'none');
    $('.loading-dialog-animation-div').css('display', 'none');
}

function align_progress_dialog()
{
    var viewport_height = $(window).innerHeight();
    var viewport_width = $(window).innerWidth();

    $('.loading-dialog-animation-div').css('left', parseInt((viewport_width - $('.loading-dialog-animation-div').outerWidth()) / 2) + 'px');
    $('.loading-dialog-animation-div').css('top', parseInt((viewport_height - $('.loading-dialog-animation-div').outerHeight()) / 2) + 'px');
}

if (typeof String.prototype.startsWith != 'function') {
    String.prototype.startsWith = function (str) {
        return this.indexOf(str) === 0;
    };
}

function website_to_url(website)
{
    atag = website;

    if (atag)
    {
        if (!atag.startsWith('http://') || !atag.startsWith('https://'))
        {
            atag = 'http://' + atag;
        }

        atag = '<a href="' + atag + '" target="_blank">' + website + '</a>';
    }

    return atag;
}

function unix_to_time(UNIX_timestamp)
{
    var a = new Date(UNIX_timestamp * 1000);
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var year = a.getFullYear();
    var month = months[a.getMonth()];
    var date = a.getDate();
    var hour = a.getHours();
    var min = a.getMinutes();
    var sec = a.getSeconds();
    var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec;
    return time;
}

function show_note(note)
{
    var note_elem_id = '#note-' + note.id;
    var note_con_id = '#note-content-' + note.id;

    if ($(note_elem_id).length > 0)
    {
        $(note_con_id).html(note.note);
    } else
    {
        html = '<div id="note-' + note.id + '" note-id="' + note.id + '" class="note-element clearfix">\n' +
                '<div class="note-name">\n' +
                note.created_by.name + ' <span class="note-time">at ' + unix_to_time(note.created_at) + '</span>' +
                '</div>\n' +
                '<div id="note-content-' + note.id + '" class="note-content">\n' +
                note.note +
                '</div>\n' +
                '</div>\n';
        $('.notes-container').append(html);

        if (note.editable)
        {
            $(note_elem_id).addClass('note-editable');
            $(note_elem_id).click(function () {

                var id = $(this).attr('note-id');

                $('#note_id').val(id);
                $('#note').val($.trim($('#note-content-' + id).html()));
            });
        }
    }
}

function profile_image_uploader() {
    var file = document.getElementById('profile-image');
    var upload_status = document.getElementById('upload_status');
    if (file) {

        var upload_image = function (e) {
            if (!file.files.length) {
                return;
            }
            var formData = new FormData()
            formData.append('image', file.files[0]);
            formData.append('btn', 'update_image');
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4) {
                    try {
                        var resp = JSON.parse(request.response);
                    }
                    catch (e) {
                        var resp = {
                            status: 'error',
                            data: 'Unknown error occurred: [' + request.responseText + ']'
                        };
                    }

                    if (resp.error === false) {
                        var image = document.querySelector('.thumb-info img');
                        image.src = resp.image[0];
                        var thumb = document.querySelector('.profile-picture img');
                        thumb.src = resp.image[1];
                    }
                    else {
                        alert(resp.error);
                    }

                    upload_status.innerText = '';
                    file.value = null;
                }
            };

            request.upload.addEventListener('progress', function (e) {
                var progress = Math.ceil(e.loaded / e.total) * 100;
                var status = '';

                if (progress == 100)
                {
                    status = 'Processing ...';
                }
                else{
                    status = 'Uploading '+progress+'%';
                }

                upload_status.innerText = status;

            }, false);

            var group = document.getElementById('dynamic_select');

            request.open('POST', 'user_profile.php' + (group == null ? '' : '?dealership=' + group.value));
            request.send(formData);
        }

        file.addEventListener('change', upload_image);

    }
}
