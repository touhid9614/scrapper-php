<?php
include_once('./db_connect.php');
$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
$test_cases = [];
$sql = "SELECT * FROM `test_case`";
$res = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
$test_cases = [];
$location_data = [
    'location1' => [
        'country' => '',
        'state' => '',
        'city' => '',
        'latitude' => '',
        'longitude' => '',
    ]
];

if ($res->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $test_cases[] = $row;
        if ($row['id'] == $node && !empty($row['location_data']) && $row['location_data'] != "{}") {
            $location_data = json_decode($row['location_data'], true);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dist/style.min.css"/>
    <link rel="stylesheet" href="css/fontello.css"/>
    <script src="dist/jstree.js"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script>
        current_node = '<?= $node ?>';
    </script>
    <title>Test Cases</title>
    <style>
        body {
            font-size: 16px;
        }

        #box {
            display: flex;
            background: hsl(210, 75%, 95%);
            min-height: 100vh;
        }

        #list {
            list-style: none;
            background: hsl(210, 60%, 75%);
            margin: 0;
            padding: 0;
        }

        #sidebar {
            background: hsl(210, 60%, 75%);
            padding: 80px 0;
        }

        #sidebar .title {
            padding: 0 40px;
        }

        #list li {
            position: relative;
        }

        #list li a {
            color: hsl(20, 100%, 100%);
            font-size: 18px;
            display: block;
            padding: 8px 40px;
            width: 100%;
        }

        #list li.active a {
            background: hsla(0, 0%, 0%, .1)
        }

        #content-box {
            padding: 80px 40px;
        }

        #tree-container {
            padding: 0 !important;
        }

        .jstree-default .jstree-wholerow-clicked {
            background: transparent;
        }

        #new {
            padding: 40px;
        }

        #new .input-box {
            display: flex;
        }

        #new input {
            border: none;
            padding: 5px;
            vertical-align: middle;
            margin-right: 5px;
        }

        #new button,
        .delete_test {
            border: none;
            padding: 1px 10px;
            font-size: 20px;
            font-weight: bold;
            vertical-align: middle;
        }

        .delete_test {
            display: none;
            position: absolute;
            right: 40px;
            top: 5px;
            padding: 1px 12px
        }

        #location .row {
            margin-bottom: 8px;
        }

        input[type="text"].error {
            border-color: red;
        }

        .notes {
            padding: 50px !important;
        }
        .margin10{
            margin: 10px 10px 40px !important;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div id="box" class="row">
        <div id="sidebar" class="col-md-2">
            <div class="title">
                <h2>Test Cases</h2>
            </div>
            <ul id="list">
                <?php $count = 0; ?>
                <?php foreach ($test_cases as $test_case) {
                    $count++; ?>
                    <li <?php echo $node == $test_case['id'] ? 'class="active"' : '' ?>>
                        <a href="?id=<?= $test_case['id'] ?>"><?= str_pad($count, 2, '0', STR_PAD_LEFT) ?>
                            . <?= $test_case['name'] ?></a>
                        <button data-id="<?= $test_case['id'] ?>" class="delete_test btn">&ndash;</button>
                    </li>
                <?php } ?>
            </ul>
            <div id="new">
                <div>
                    <label>Add New Test Case</label>
                </div>
                <div class="input-box">
                    <input id="new-test" class="form-control" type="text" name="new-test"/>
                    <button id="create-new" class="btn">+</button>
                </div>
            </div>
        </div>
        <div id="content-box" class="col-md-10">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link active" id="car-data-tab" data-toggle="tab" href="#car-data" role="tab"
                       aria-controls="car-data" aria-selected="true">Car Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="location-tab" data-toggle="tab" href="#location" role="tab"
                       aria-controls="location" aria-selected="false">Location</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="result-tab" data-toggle="tab" href="#result" role="tab"
                       aria-controls="result" aria-selected="false">Result</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent" style="padding:40px 0">
                <div class="tab-pane fade active in" id="car-data" role="tabpanel" aria-labelledby="car-data-tab">
                    <div class="row">
                        <div id="tree-container" class="margin10 col-md-12"></div>
                        <h5 class="notes">* Please atleast add Year and Make to build result.</h5>
                    </div>

                </div>
                <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">
                    <div class="row">
                        <div class="col-md-2">Country</div>
                        <div class="col-md-2">State</div>
                        <div class="col-md-2">City</div>
                        <div class="col-md-2">Latitude</div>
                        <div class="col-md-2">Longitude</div>
                        <div class="col-md-2"></div>
                    </div>
                    <?php foreach ($location_data as $location) { ?>
                        <div class="row location-list">
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="country"
                                       value="<?= $location['country'] ?>"/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="state" value="<?= $location['state'] ?>"/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="city" value="<?= $location['city'] ?>"/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="latitude"
                                       value="<?= $location['latitude'] ?>"/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="longitude"
                                       value="<?= $location['longitude'] ?>"/>
                            </div>
                            <div class="col-md-2">
                                <button class="btn delete_location">&ndash;</button>
                                <button class="btn add_location">+</button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="show-errors" class="" role="alert">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn" id="save_location">Save Locations</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="result" role="tabpanel" aria-labelledby="result-tab">
                    <div id="result-container" class="col-md-12">
                        <?php include_once("../tradeScan/result.php") ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</body>

</html>
<script type="text/javascript">
    $('#location').on('click', '.delete_location', function (e) {
        e.preventDefault();
        $(this).closest('.row').remove();
    });

    $('#location').on('click', '.add_location', function (e) {
        var row = $(this).closest('.row');
        var newRow = row.clone();
        newRow.find('input').val('');
        newRow.insertAfter(row);
    });

    $('#save_location').unbind('click').click(function (e) {
        e.preventDefault();
        var emptyInput = $('#location input').filter(function () {
            return $(this).val() == "";
        }).addClass('error');
        if (emptyInput.length) {
            $("#show-errors").addClass('alert alert-danger').html('All fields are required');
            return;
        }
        $("#show-errors").removeClass('alert alert-danger').html('');
        var locations = {}
        $('.location-list').each(function (n) {
            locations['location' + (n + 1)] = {}
            $(this).find('input').each(function () {
                locations['location' + (n + 1)][$(this).attr('name')] = $(this).val();
            });
        });
        $('#box').block({
            'message': 'Saving Locations...'
        });
        $.post('response.php?operation=save_location', {
            'json': JSON.stringify(locations),
            'id': current_node,
        })
            .done(function (d) {
                $('#result').html('');
                $('#box').unblock();
            })
            .fail(function () {
                $('#box').unblock();
            });

    });

    $('#location').on('keyup', 'input', function (e) {
        if ($(this).val()) {
            $(this).removeClass('error');
        } else {

            $(this).addClass('error');
        }
        var emptyInput = $('#location input').filter(function () {
            return $(this).val() == "";
        });
        if (emptyInput.length == 0) {
            $("#show-errors").removeClass('alert alert-danger').html('');
            return;
        }
    })

    function create_test() {
        var text = $('#new-test').val();
        if (text) {

            $('#box').block({
                message: "Loading..."
            });
            $.getJSON('response.php?operation=create_test', {
                'text': text,
            })
                .done(function (d) {
                    location.reload();
                })
                .fail(function () {
                    $('#box').unblock();
                });
        }
    }

    $(document).ready(function () {
        $('#create-new').click(function (e) {
            create_test();
        });

        $('#new-test').keyup(function (e) {
            if (e.keyCode == 13) {
                create_test();
            }
        });

        $('.delete_test').click(function (e) {
            e.preventDefault();
            hell_yeah = confirm("Are you sure?");
            id = $(this).attr('data-id');
            if (id && hell_yeah) {
                $('#box').block({
                    message: "Loading..."
                });
                $.post('response.php?operation=delete_test', {
                    'id': id,
                })
                    .done(function (d) {
                        location.reload();
                    })
                    .fail(function () {
                        $('#box').unblock();
                    });
            }
        })
        $('#tree-container').jstree({
            'core': {
                'data': {
                    'url': 'response.php?operation=get_node&id=<?= $node ?>',
                    /* 'data': function(node) {
                        return {
                            'id': node.id
                        };
                    }, */
                    "dataType": "json"
                },
                'check_callback': true,
                'themes': {
                    'responsive': false
                }
            },
            'contextmenu': {
                'items': function (node) {
                    var tmp = $.jstree.defaults.contextmenu.items();
                    delete tmp.ccp;
                    submenu = {
                        "create_year": {
                            "separator_after": true,
                            "label": "Year",
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                inst.create_node(obj, {
                                    text: "",
                                    type: "year",
                                }, "last", function (new_node) {
                                    setTimeout(function () {
                                        inst.edit(new_node);
                                    }, 0);
                                });
                            }
                        },
                        "create_make": {
                            "label": "Make",
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                inst.create_node(obj, {
                                    text: "",
                                    type: "make"
                                }, "last", function (new_node) {
                                    setTimeout(function () {
                                        inst.edit(new_node);
                                    }, 0);
                                });
                            }
                        },
                        "create_model": {
                            "label": "Model",
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                inst.create_node(obj, {
                                    text: "",
                                    type: "model"
                                }, "last", function (new_node) {
                                    setTimeout(function () {
                                        inst.edit(new_node);
                                    }, 0);
                                });
                            }
                        },
                        "create_trim": {
                            "label": "trim",
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                inst.create_node(obj, {
                                    text: "",
                                    type: "trim"
                                }, "last", function (new_node) {
                                    setTimeout(function () {
                                        inst.edit(new_node);
                                    }, 0);
                                });
                            }
                        }
                    };

                    if (this.get_type(node) === "default") {
                        tmp.create.label = "New Year";
                        tmp.create.action = submenu.create_year.action;
                    } else if (this.get_type(node) === "year") {
                        tmp.create.label = "New Make";
                        tmp.create.action = submenu.create_make.action;
                    } else if (this.get_type(node) === "make") {
                        tmp.create.label = "New Model";
                        tmp.create.action = submenu.create_model.action;
                    } else if (this.get_type(node) === "model") {
                        tmp.create.label = "New Trim";
                        tmp.create.action = submenu.create_trim.action;
                    } else if (this.get_type(node) === "trim") {
                        delete tmp.create;
                    }
                    return tmp;
                }
            },
            'types': {
                '#': {
                    'valid_children': ['year']
                },
                'year': {
                    "icon": "i-year",
                    'valid_children': ['make'],
                },
                'make': {
                    "icon": "i-make",
                    'valid_children': ['model']
                },
                'model': {
                    "icon": "i-model",
                    'valid_children': ['trim']
                },
                'trim': {
                    "icon": "i-trim",
                    'valid_children': []
                },
            },
            'plugins': ["contextmenu", "dn,", "search", "state", "types", "wholerow", "unique"]
        })
            .on('create_node.jstree', function (e, data) {
                /* $('#box').block({
                    message: "Loading..."
                });
                $.getJSON('response.php?operation=create_node', {
                        'id': data.node.parent,
                        'position': data.position,
                        'text': data.node.text,
                        'type': data.node.type
                    })
                    .done(function(d) {
                        data.instance.set_id(data.node, d.id);
                        $('#box').unblock();
                    })
                    .fail(function() {
                        data.instance.refresh();
                        $('#box').unblock();
                    }); */

            }).on('rename_node.jstree', function (e, data) {
            var json = get_json();
            console.log(json);
            $('#box').block({
                message: "Loading..."
            });
            $.post('response.php?operation=save_json', {
                'json': JSON.stringify(json),
                'id': current_node,
            })
                .done(function (d) {
                    $('#result').html('');
                    $('#box').unblock();
                })
                .fail(function () {
                    $('#box').unblock();
                });
        }).on('delete_node.jstree', function (e, data) {
            var json = get_json();
            $('#box').block({
                message: "Loading..."
            });
            $.post('response.php?operation=save_json', {
                'json': JSON.stringify(json),
                'id': current_node,
            })
                .done(function (d) {
                    $('#result').html('');
                    $('#box').unblock();
                })
                .fail(function () {
                    $('#box').unblock();
                });
        });
    });

    function get_json() {
        var v = $('#tree-container').jstree(true).get_json('#', {
            flat: true
        })
        json = {};
        var id, year, make, model;
        for (let n in v) {
            if (v[n].type == 'year') {
                year = v[n].text;
                json[year] = {};
            } else if (v[n].type == 'make') {
                make = v[n].text;
                json[year][make] = {};
            } else if (v[n].type == 'model') {
                model = v[n].text;
                json[year][make][model] = [];
            } else if (v[n].type == 'trim') {
                json[year][make][model].push(v[n].text);
            }
        }
        return json;
    }
</script>
