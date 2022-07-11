<?php

include_once "../classes/Students.php";
$students = new Students();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($_POST['cate']) {
            case 'login':
                header("Content-Type:application/json");
                echo json_encode($students->login($_POST));
                break;
            case 'savemodule':
                echo json_encode($students->saveModules($_POST));
                break;
        }
        break;
    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {

            case 'loadbyid':
                // header("Content-Type:application/json");
                break;
            case 'load':
                header("Content-Type:application/json");
                echo json_encode($students->get($_GET));
                break;

            case 'loadregisteredmodule':
                header("Content-Type:application/json");
                echo json_encode($students->getRegisteredModules($_GET));
                break;

            default:
                echo json_encode(['error' => "value of parameter category not known"]);
                break;
        }
        break;
    default:
        echo json_encode(['error' => $_SERVER['REQUEST_METHOD'] . "Request method not allowed"]);
        break;
}

?>