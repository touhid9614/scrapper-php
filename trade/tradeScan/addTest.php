<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php

$year = 1;
$make = 1;
$model = 1;
$trim = 1;

?>
<div class="container">
    <h2>Add test Case</h2>

    <div class="card ">
        <div class="card-header">Test :: 1</div>
        <div class="card-body">
            <form method="post">
                    <div class="table-responsive">
                        <table class="table" >
                            <thead class="thead-light">
                            <tr >
                                <th scope="col" style="vertical-align: middle !important;">Year</th>
                                <th scope="col" style="vertical-align: middle !important;">Make</th>
                                <th scope="col"style="vertical-align: middle !important;">Model</th>
                                <th scope="col" style="vertical-align: middle !important;">Trim</th>
                            </tr>
                            </thead>
                            <tbody >
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="2014" aria-label="Only Year" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <table class="table" >
                                        <tr>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="2014" aria-label="Only Year" aria-describedby="button-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" placeholder="2014" aria-label="Only Year" aria-describedby="button-addon2">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <table class="table">
                                                                <tbody id="trim-body-<?= $year.'_'.$make.'_'.$model ?>">
                                                                    <tr id="trim-data-<?= $year.'_'.$make.'_'.$model.'_'.$trim ?>">
                                                                        <td>
                                                                            <div class="input-group mb-3">
                                                                                <input type="text" class="form-control" placeholder="Trim" aria-label="Only Trim" aria-describedby="button-addon2">
                                                                                <div class="input-group-append">
                                                                                    <button class="btn btn-outline-secondary" id='trim-add'  type="button" >
                                                                                        <i class="fa fa-plus"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                </table>

                                            </td>

                                        </tr>

                                    </table>

                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="2014" aria-label="Only Year" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="2014" aria-label="Only Year" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="2014" aria-label="Only Year" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="2014" aria-label="Only Year" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <input name="update_neg_keyword" type="submit" value="Update"
                               class="btn btn-secondary">
                    </div>
            </form>

        </div>

    </div>
</div>

</body>
<script>

    //var negrow = <?php //echo $negId ?>;
    var year = <?php echo $year ?>;
    var make = <?php echo $make ?>;
    var model = <?php echo $model ?>;
    var trim = <?php echo $trim ?>;

    $(document).on("click", "#trim-add", function () {
        var new_trim_row = `<tr id="trim-data-` + year + `_` + make + `_`+ model + `_` + trim +`"> <td>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Trim" aria-label="Only Trim"  aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary delete-trim"   type="button">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                </td></tr>`;
        // alert('#trim-body-'+ year + '_' + make + '_'+ model  );
        $('#trim-body-'+ year + '_' + make + '_'+ model  ).append(new_trim_row);
        trim++;
        return false;
    });

    // Remove criterion
    $(document).on("click", ".delete-trim", function () {
         // alert("deleting row#"+trim);
        if (trim > 1) {
            $(this).closest('tr').remove();
            trim--;
        }
        return false;
    });
</script>
</html>
