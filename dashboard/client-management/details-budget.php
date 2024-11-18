<?php

$budgetQuery        = "SELECT * FROM dealerships_invoice_data WHERE dealership='$cron_name';";
$result             = DbConnect::get_instance()->query($budgetQuery);
$dealership_data    = [];
$i                  = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $dealership_data[$i]['dealership']      = $cron_name;
    $dealership_data[$i]['url']             = $row['url'];
    $dealership_data[$i]['linedescription'] = $row['linedescription'];
    $dealership_data[$i]['budget']          = $row['budget'];
    $dealership_data[$i]['lineamount']      = $row['lineamount'];
    $i++;
}

$dealershipsBillingQuery        = "SELECT * FROM dealerships_billing WHERE dealership = '$cron_name';";
$dealershipsBillingQueryResult  = DbConnect::get_instance()->query($dealershipsBillingQuery);
$dealership_address             = [];

while ($row = mysqli_fetch_assoc($dealershipsBillingQueryResult)) {
    $dealership_address['dealership']               = $cron_name;
    $dealership_address['url']                      = $row['url'];
    $dealership_address['customer']                 = $row['customer'];
    $dealership_address['billaddrline1']            = $row['billaddrline1'];
    $dealership_address['billaddrcity']             = $row['billaddrcity'];
    $dealership_address['billaddrcountry']          = $row['billaddrcountry'];
    $dealership_address['billaddrsubdivisioncode']  = $row['billaddrsubdivisioncode'];
    $dealership_address['billaddrpostalcode']       = $row['billaddrpostalcode'];
    $dealership_address['billemaill']               = $row['billemaill'];
}

echo '<script>';
echo "var dealership_data = " . json_encode($dealership_data, JSON_PRETTY_PRINT) . "; \n ";
echo '</script>';
?>

<form class="form-horizontal form-bordered">
    <div class="row">
        <div class="col-md-12">
            <table id="table" class="table table-bordered table-striped">
                <tr>
                    <th>Dealership Name</th>
                    <td colspan="2">
                        <?= $cron_name ?>
                    </td>
                </tr>
                <tr>
                    <th>Website URL</th>
                    <td colspan="2">
                        <input type="hidden" class="form-control" placeholder="Website URL" name="update_website_url" value="<?= $dealership_address['url'] ?>">
                        <i><?= URLPrint($dealership_address['url']) ?></i>
                    </td>
                </tr>
                <tr>
                    <th>Billing Address</th>
                    <td>
                        <input type="text" class="form-control" id="bill_address" placeholder="Billing Address" name="update_billing_address" required value="<?= checkAndSet($dealership_address['billaddrline1']) ?>">
                        <p id="bill_address_p" class="tstyle"><?= checkAndSet($dealership_address['billaddrline1']) ?></p>
                    </td>
                    <td>
                        <button type="button" id="address_btn" class="btn btn-success">Modify</button>
                    </td>
                </tr>
                <tr>
                    <th>City Name</th>
                    <td>
                        <input type="text" class="form-control" id="city" placeholder="City Name" name="update_city_name" required value="<?= checkAndSet($dealership_address['billaddrcity']) ?>">
                        <p id="city_p" class="tstyle"><?= checkAndSet($dealership_address['billaddrcity']) ?></p>
                    </td>
                    <td>
                        <button type="button" id="city_btn" class="btn btn-success">Modify</button>
                    </td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>
                        <input type="text" class="form-control" id="country" placeholder="Country" name="update_country" required value="<?= checkAndSet($dealership_address['billaddrcountry']) ?>">
                        <p id="country_p" class="tstyle"><?= checkAndSet($dealership_address['billaddrcountry']) ?></p>
                    </td>
                    <td>
                        <button type="button" id="country_btn" name="country" class="btn btn-success">Modify</button>
                    </td>
                </tr>
                <tr>
                    <th>Sub Division Code</th>
                    <td>
                        <input type="text" class="form-control" id="sub_division" placeholder="Sub Division Code" name="update_sub_division_code" required value="<?= checkAndSet($dealership_address['billaddrsubdivisioncode']) ?>">
                        <p id="sub_division_p" class="tstyle"><?= checkAndSet($dealership_address['billaddrsubdivisioncode']) ?></p>
                    </td>
                    <td>
                        <button type="button" id="sub_division_btn" class="btn btn-success">Modify</button>
                    </td>
                </tr>
                <tr>
                    <th>Postal Code</th>
                    <td>
                        <input type="text" class="form-control" id="postal" placeholder="Postal Code" name="update_postal_code" required value="<?= checkAndSet($dealership_address['billaddrpostalcode']) ?>">
                        <p id="postal_p" class="tstyle"><?= checkAndSet($dealership_address['billaddrpostalcode']) ?></p>
                    </td>
                    <td>
                        <button type="button" id="postal_btn" class="btn btn-success">Modify</button>
                    </td>
                </tr>
                <tr>
                    <th>Billing Email</th>
                    <td>
                        <i><input type="text" class="form-control" id="email" placeholder="Billing Email" name="update_billing_email" required value="<?= URLPrint($dealership_address['billemaill']) ?>"></i>
                        <p id="email_p" class="tstyle"><i><?= URLPrint($dealership_address['billemaill']) ?></i></p>
                    </td>
                    <td>
                        <button type="button" id="email_btn" class="btn btn-success">Modify</button>
                    </td>
                </tr>
            </table>

            <button type="button" id="billing_address_update" class="btn btn-primary">Update Address</button>

            <br>
            <br>
            <table class="table table-bordered table-striped table-advanced">
                <thead>
                    <tr>
                        <th>Line Description</th>
                        <th>Budget</th>
                        <th>Line Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dealership_data as $key => $value) : ?>
                        <tr>
                            <td>
                                <input type="hidden" id="<?= $key ?>_description" class="form-control" placeholder="Line Description" name="update_line_description[<?= $key ?>]" value="$dealership_data[$key]['linedescription']">
                                <?= $dealership_data[$key]['linedescription'] ?>
                            </td>
                            <td>
                                <input type="text" id="<?= $key ?>_budget" class="form-control disappear" placeholder="Budget" name="update_budget[<?= $key ?>]" required value="<?= checkAndSet($dealership_data[$key]['budget']) ?>">
                                <p id="<?= $key ?>_budget_p"><?= checkAndSet($dealership_data[$key]['budget']) ?></p>
                            </td>
                            <td>
                                <input type="text" id="<?= $key ?>_amount" class="form-control disappear" placeholder="Line Amount" name="update_line_amount[<?= $key ?>]" required value="<?= checkAndSet($dealership_data[$key]['lineamount']) ?>">
                                <p id="<?= $key ?>_amount_p"><?= checkAndSet($dealership_data[$key]['lineamount']) ?></p>
                            </td>
                            <td>
                                <button type="button" id="<?= $key ?>_btn" class="btn btn-success" onclick="editThisRow('<?= $key ?>')">Modify</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button type="button" id="invoice_update" class="btn btn-primary">Update Budget</button>
        </div>
    </div>
</form>

<style type="text/css">
    #bill_address,
    #city,
    #country,
    #sub_division,
    #postal,
    #email,
    #invoice_update,
    #billing_address_update,
    .disappear {
        display: none;
    }

    .tstyle {
        padding-top: 8px;
    }
</style>

<script type="text/javascript">
    var addressCount = 0;

    $("#address_btn").click(function() {
        $('#bill_address_p').toggle();
        $('#bill_address').toggle();

        if ($('#address_btn').text() == 'Modify') {
            $('#address_btn').html('Discard').removeClass('btn-success').addClass('btn-danger');
            addressCount++;
        } else {
            $('#address_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
            addressCount--;
        }

        if (addressCount) {
            $('#billing_address_update').show();
        } else {
            $('#billing_address_update').hide();
        }
    });

    $("#city_btn").click(function() {
        $('#city_p').toggle();
        $('#city').toggle();

        if ($('#city_btn').text() == 'Modify') {
            $('#city_btn').html('Discard').removeClass('btn-success').addClass('btn-danger');
            addressCount++;
        } else {
            $('#city_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
            addressCount--;
        }

        if (addressCount) {
            $('#billing_address_update').show();
        } else {
            $('#billing_address_update').hide();
        }
    });

    $("#country_btn").click(function() {
        $('#country_p').toggle();
        $('#country').toggle();

        if ($('#country_btn').text() == 'Modify') {
            $('#country_btn').html('Discard').removeClass('btn-success').addClass('btn-danger');
            addressCount++;
        } else {
            $('#country_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
            addressCount--;
        }

        if (addressCount) {
            $('#billing_address_update').show();
        } else {
            $('#billing_address_update').hide();
        }
    });

    $("#sub_division_btn").click(function() {
        $('#sub_division_p').toggle();
        $('#sub_division').toggle();

        if ($('#sub_division_btn').text() == 'Modify') {
            $('#sub_division_btn').html('Discard').removeClass('btn-success').addClass('btn-danger');
            addressCount++;
        } else {
            $('#sub_division_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
            addressCount--;
        }

        if (addressCount) {
            $('#billing_address_update').show();
        } else {
            $('#billing_address_update').hide();
        }
    });

    $("#postal_btn").click(function() {
        $('#postal_p').toggle();
        $('#postal').toggle();

        if ($('#postal_btn').text() == 'Modify') {
            $('#postal_btn').html('Discard').removeClass('btn-success').addClass('btn-danger');
            addressCount++;
        } else {
            $('#postal_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
            addressCount--;
        }

        if (addressCount) {
            $('#billing_address_update').show();
        } else {
            $('#billing_address_update').hide();
        }
    });

    $("#email_btn").click(function() {
        $('#email_p').toggle();
        $('#email').toggle();

        if ($('#email_btn').text() == 'Modify') {
            $('#email_btn').html('Discard').removeClass('btn-success').addClass('btn-danger');
            addressCount++;
        } else {
            $('#email_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
            addressCount--;
        }

        if (addressCount) {
            $('#billing_address_update').show();
        } else {
            $('#billing_address_update').hide();
        }
    });

    var lineCount = 0;
    var changeTheseKeyedRows = [];

    function editThisRow(key) {
        $(`#${key}_budget`).toggle();
        $(`#${key}_amount`).toggle();
        $(`#${key}_budget_p`).toggle();
        $(`#${key}_amount_p`).toggle();

        if ($(`#${key}_btn`).text() == 'Modify') {
            $(`#${key}_btn`).html('Discard').removeClass('btn-success').addClass('btn-danger');
            $('#invoice_update').show();
            lineCount++;
            changeTheseKeyedRows.push(key);
        } else {
            $(`#${key}_btn`).html('Modify').removeClass('btn-danger').addClass('btn-success');
            lineCount--;
            changeTheseKeyedRows.splice(changeTheseKeyedRows.indexOf(key), 1);
        }

        if (!lineCount) {
            $('#invoice_update').hide();
        }
    }

    $("#billing_address_update").click(function() {
        var update_dealership_name   = $('input[name="update_dealership_name"]').val();
        var update_website_url       = $('input[name="update_website_url"]').val();
        var update_billing_address   = $('input[name="update_billing_address"]').val();
        var update_city_name         = $('input[name="update_city_name"]').val();
        var update_country           = $('input[name="update_country"]').val();
        var update_sub_division_code = $('input[name="update_sub_division_code"]').val();
        var update_postal_code       = $('input[name="update_postal_code"]').val();
        var update_billing_email     = $('input[name="update_billing_email"]').val();
        var isFieldEmpty             = false;

        if (update_billing_address == "") {
            isFieldEmpty = true;
            alert("Billing address is required!");
        }

        if (update_city_name == "") {
            isFieldEmpty = true;
            alert("City name required!");
        }

        if (update_country == "") {
            isFieldEmpty = true;
            alert("Country name is required!");
        }

        if (update_sub_division_code == "") {
            isFieldEmpty = true;
            alert("Sub division code is required!");
        }

        if (update_postal_code == "") {
            isFieldEmpty = true;
            alert("Postal code is required!");
        }

        if (update_billing_email == "") {
            isFieldEmpty = true;
            alert("Billing email is required!");
        }

        if (isFieldEmpty == false) {
            var updateBillingAddress = `update_dealership_name=${update_dealership_name}&update_website_url=${update_website_url}&update_billing_address=${update_billing_address}&update_city_name=${update_city_name}&update_country=${update_country}&update_sub_division_code=${update_sub_division_code}&update_postal_code=${update_postal_code}&update_billing_email=${update_billing_email}`;

            $('#bill_address , #city , #country , #sub_division , #postal , #email').hide();
            $('#bill_address_p , #city_p , #country_p , #sub_division_p , #postal_p , #email_p').show();

            if ($('#bill_address_btn').text() == 'Discard') {
                $('#bill_address_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
                $("#bill_address_p").text(update_billing_address);
            }

            if ($('#city_btn').text() == 'Discard') {
                $('#city_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
                $("#city_p").text(update_city_name);
            }

            if ($('#country_btn').text() == 'Discard') {
                $('#country_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
                $("#country_p").text(update_country);
            }

            if ($('#sub_division_btn').text() == 'Discard') {
                $('#sub_division_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
                $("#sub_division_p").text(update_sub_division_code);
            }

            if ($('#postal_btn').text() == 'Discard') {
                $('#postal_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
                $("#postal_p").text(update_postal_code);
            }

            if ($('#email_btn').text() == 'Discard') {
                $('#email_btn').html('Modify').removeClass('btn-danger').addClass('btn-success');
                $("#email_p").text(update_billing_email);
            }

            var request = $.ajax({
                cache : false,
                url   : 'client-management/change-billing-address.php',
                method: 'POST',
                data  : updateBillingAddress
            });

            request.done(function(data) {
                console.log({ data });
            });

            var request2 = $.ajax({
                cache : false,
                url   : '../dork-exporter/get_invoice/updateAddressInSpreedSheet.php',
                method: 'POST',
                data  : updateBillingAddress
            });

            request2.done(function(data) {
                console.log({ data });
            });
        }
    });

    $("#invoice_update").click(function() {
        var isFieldsOkay           = true;
        var update_dealership_name = $('input[name="update_dealership_name"]').val();
        var update_website_url     = $('input[name="update_website_url"]').val();

        for (var key in changeTheseKeyedRows) {
            var this_budget = $(`#${changeTheseKeyedRows[key]}_budget`).val();
            var this_line_amount = $(`#${changeTheseKeyedRows[key]}_amount`).val();

            if (this_budget == "") {
                isFieldsOkay = false;
                alert("Budget can't be empty. Enter 0 instead.");
                break;
            }

            if (this_line_amount == "") {
                isFieldsOkay = false;
                alert("Line amount can't be empty. Enter 0 instead.");
                break;
            }

            dealership_data[changeTheseKeyedRows[key]]['budget']     = this_budget;
            dealership_data[changeTheseKeyedRows[key]]['lineamount'] = this_line_amount;
        }

        console.log(dealership_data);

        if (isFieldsOkay) {
            /* show in ui first, then update db, then update spreadsheet */
            // UI
            for (var key in changeTheseKeyedRows) {
                var curr = parseInt(changeTheseKeyedRows[key]);
                console.log(curr, dealership_data[curr]);

                if ($(`#${curr}_btn`).text() == 'Modify') {
                    $(`#${curr}_btn`).html('Discard').removeClass('btn-success').addClass('btn-danger');
                } else {
                    $(`#${curr}_btn`).html('Modify').removeClass('btn-danger').addClass('btn-success');
                }
            }

            $('#invoice_update').hide();


            // DB
            var updateBudgetString = `dealership_data=${JSON.stringify(dealership_data)}`;

            var request = $.ajax({
                cache : false,
                url   : './client-management/change-budget.php',
                method: 'POST',
                data  : updateBudgetString
            });

            request.done(function(data) {
                console.log({ data });
            });


            // SPREADSHEET
            var request2 = $.ajax({
                cache : false,
                url   : '../dork-exporter/get_invoice/updateBudgetInSpreedSheet.php',
                method: 'POST',
                data  : updateBudgetString
            });

            request2.done(function(data) {
                console.log({ data });
            });

            location.reload();
        }
    });
</script>