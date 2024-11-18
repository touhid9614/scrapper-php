
$("#date_range").change(function () {
    if (this.value == "custom") {
        $("#custom_date_range").show();
    } else {
        $("#custom_date_range").hide();
    }
});


(function ($) {
    'use strict';
    var datatableInit = function () {
        var $table = $('#button-statistics');
        // format function for row details
        var fnFormatDetails = function (datatable, tr) {
            var data = JSON.parse($(tr).attr('data-details'));//datatable.fnGetData(tr);

            var table_rowdata = '<div class="row ml-none mr-none"><div class="col-md-12 ml-none mr-none"><table class="table table-striped mb-none">';
            table_rowdata += "<tr><th>Button Name</th><th>Clicks</th><th>Fillups</th></tr>";
            $.each(data, function (k, v) {
                table_rowdata += '<tr class="b-top-none">';
                table_rowdata += '<td><label class="mb-none">' + k + '</label></td>';
                table_rowdata += '<td>' + v.clicks + '</td>';
                table_rowdata += '<td>' + v.fillups + '</td>';
                table_rowdata += '</tr>';
            });

            table_rowdata += '</table></div></div>';

            return table_rowdata;
        };


        // insert the expand/collapse column
        var th = document.createElement('th');
        var td = document.createElement('td');
        td.innerHTML = '<i data-toggle class="fa fa-plus-square-o text-primary h5 m-none" style="cursor: pointer;"></i>';
        td.className = "text-center";
        $table
                .find('thead tr').each(function () {
            this.insertBefore(th, this.childNodes[0]);
        });
        $table
                .find('tbody tr').each(function () {
            this.insertBefore(td.cloneNode(true), this.childNodes[0]);
        });


        // initialize
        var datatable = $table.dataTable({
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0]
                }],
            aaSorting: [
                [1, 'asc']
            ]
        });
        // add a listener
        $table.on('click', 'i[data-toggle]', function () {
            var $this = $(this),
                    tr = $(this).closest('tr').get(0);
            if (datatable.fnIsOpen(tr)) {
                console.log('Close');
                $this.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                datatable.fnClose(tr);
            } else {
                console.log('Open');
                $this.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                datatable.fnOpen(tr, fnFormatDetails(datatable, tr), 'details');
            }
        });
    };
    $(function () {
        datatableInit();
    });
}).apply(this, [jQuery]);