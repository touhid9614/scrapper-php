<?php
include_once('./db_connect.php');
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if (isset($_GET['operation'])) {
    try {
        $result = null;
        switch ($_GET['operation']) {
            case 'get_json':
                $node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
                $result = generate_json($node, $conn);
                break;
            case 'get_node':
                $node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;

                $data = [];

                if ($node) {
                    $sql = "SELECT * FROM test_case WHERE id=$node;";
                    $res = mysqli_query($conn, $sql);
                    if ($res && $res->num_rows) {
                        $row = mysqli_fetch_assoc($res);
                        $car_data = json_decode($row['car_data']);
                    }
                }

                if (isset($car_data)) {
                    $data = [];
                    $data[] = ['id' => 'root', 'parent' => '#', 'text' => $row['name'], 'type' => 'default', 'state' => ['opened' => true]];
                    foreach ($car_data as $year => $makes) {
                        $data[] = ['id' => $year, 'parent' => 'root', 'text' => $year, 'type' => 'year', 'icon' => 'i-year', 'state' => ['opened' => true]];
                        foreach ($makes as $make => $models) {
                            $data[] = ['id' => "$year-$make", 'parent' => "$year", 'text' => $make, 'type' => 'make', 'icon' => 'i-make'];
                            foreach ($models as $model => $trims) {
                                $data[] = ['id' => "$year-$make-$model", 'parent' => "$year-$make", 'text' => $model, 'type' => 'model', 'icon' => 'i-model'];
                                foreach ($trims as $trim) {
                                    $data[] = ['id' => "$year-$make-$model-$trim", 'parent' => "$year-$make-$model", 'text' => $trim, 'type' => 'trim', 'icon' => 'i-trim'];
                                }
                            }
                        }
                    }
                }

                $result = $data;
                break;
            case 'save_json':
                $node = isset($_POST['id']) && $_POST['id'] !== '#' ? (int)$_POST['id'] : 0;
                $json = isset($_POST['json']) && !empty($_POST['json']) ? $_POST['json'] : '{}';
                $result = json_decode($json);
                $sql = "UPDATE test_case SET car_data='$json', result_insert=0 WHERE id=$node;";
                mysqli_query($conn, $sql);
                delete_results($node, $conn);
                break;
            case 'save_location':
                $node = isset($_POST['id']) && $_POST['id'] !== '#' ? (int)$_POST['id'] : 0;
                $json = isset($_POST['json']) && !empty($_POST['json']) ? $_POST['json'] : '{}';
                $result = json_decode($json);
                $sql = "UPDATE test_case SET location_data='$json', result_insert=0 WHERE id=$node;";
                mysqli_query($conn, $sql);
                delete_results($node, $conn);
                break;
            case 'create_test':
                $text = isset($_GET['text']) && !empty($_GET['text']) ? $_GET['text'] : null;

                if ($text) {
                    $sql = "INSERT INTO `test_case` (`name`, `active`, `result_insert`, `car_data`, `location_data` ) VALUES('$text', 0, 0, '{}', '{}')";
                    mysqli_query($conn, $sql);
                    $result = [
                        'id' => mysqli_insert_id($conn),
                        'sql' => $sql,
                    ];
                }

                echo json_encode($result);
                die;
                break;
            case 'delete_test':
                $node = isset($_POST['id']) ? (int)$_POST['id'] : 0;

                if ($node) {
                    $sql = "DELETE FROM test_case WHERE id=$node";
                    mysqli_query($conn, $sql);
                }

                break;
            default:
                throw new Exception('Unsupported operation: ' . $_GET['operation']);
                break;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result);
    } catch (Exception $e) {
        header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
        header('Status:  500 Server Error');
        echo $e->getMessage();
    }
    die();
}

function delete_results($test_case_id, $conn)
{
    $sql = "DELETE FROM result_test_case WHERE test_case_id=$test_case_id";
    mysqli_query($conn, $sql);
}

function get_children_ids($parent_id, $conn)
{
    $search_nodes = [$parent_id];
    $child_nodes = [];
    while (count($search_nodes) > 0) {
        $ids = implode(',', $search_nodes);
        $search_nodes = [];

        $sql = "SELECT id FROM `treeview_items` WHERE `parent_id` IN ({$ids})";

        $res = mysqli_query($conn, $sql);
        if ($res->num_rows) {
            while ($row = mysqli_fetch_assoc($res)) {
                $search_nodes[] = $row['id'];
                $child_nodes[] = $row['id'];
            }
        }
    }

    return $child_nodes;
}

function get_children_rows($parent_id, $conn)
{
    $search_nodes = [$parent_id];
    $child_nodes = [];
    while (count($search_nodes) > 0) {
        $ids = implode(',', $search_nodes);
        $search_nodes = [];

        $sql = "SELECT * FROM `treeview_items` WHERE `parent_id` IN ({$ids})";

        $res = mysqli_query($conn, $sql);
        if ($res->num_rows) {
            while ($row = mysqli_fetch_assoc($res)) {
                $search_nodes[] = $row['id'];
                $child_nodes[] = $row;
            }
        }
    }

    return $child_nodes;
}

function generate_json($id, $conn)
{
    $json = [];

    $sql = "SELECT * FROM `treeview_items` WHERE `parent_id`=$id and `type`='year'";
    $year_res = mysqli_query($conn, $sql);

    if ($year_res->num_rows) {
        while ($year = mysqli_fetch_assoc($year_res)) {
            $json[$year['text']] = [];
            $sql = "SELECT * FROM `treeview_items` WHERE `parent_id`={$year['id']} and `type`='make'";
            $make_res = mysqli_query($conn, $sql);
            if ($make_res->num_rows) {
                while ($make = mysqli_fetch_assoc($make_res)) {
                    $json[$year['text']][$make['text']] = [];
                    $sql = "SELECT * FROM `treeview_items` WHERE `parent_id`={$make['id']} and `type`='model'";
                    $model_res = mysqli_query($conn, $sql);
                    if ($model_res->num_rows) {
                        while ($model = mysqli_fetch_assoc($model_res)) {
                            $json[$year['text']][$make['text']][$model['text']] = [];
                            $sql = "SELECT * FROM `treeview_items` WHERE `parent_id`={$model['id']} and `type`='trim'";
                            $trim_res = mysqli_query($conn, $sql);
                            if ($trim_res->num_rows) {
                                while ($trim = mysqli_fetch_assoc($trim_res)) {
                                    $json[$year['text']][$make['text']][$model['text']][] = $trim['text'];
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return $json;
}

function update_car_data($id, $conn)
{
    $json = generate_json($id, $conn);
    $sql = "UPDATE `test_case` SET `car_data`='$json' WHERE `id`=$id";
    mysqli_query($conn, $sql);
}
