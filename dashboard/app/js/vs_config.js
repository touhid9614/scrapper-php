$(document).ready(function () 
{
    var counter = 0;

    $("#addrow").on("click", function () 
    {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" required class="form-control" name="page_type[]" /></td>';
        cols += '<td><input type="text" required class="form-control" name="page_type_heading[]" /></td>';
        cols += '<td><input type="text" class="form-control" name="required_param[]" /></td>';
        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';

        newRow.append(cols);

        $("table.order-list").append(newRow);

        counter++;
    });

    $("table.order-list").on("click", ".ibtnDel", function (event) 
    {
        $(this).closest("tr").remove();   
        counter -= 1
    });
});