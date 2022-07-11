<?php

include_once "../classes/Modules.php";
$modules = new Modules();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($_POST['cate']) {

            case 'register':
                echo json_encode([]);
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
                echo json_encode($modules->get($_GET));
                break;

            default:
                echo json_encode(['error'=>"value of parameter category not known"]);
                break;
        }
        break;
    default:
        echo json_encode(['error'=>$_SERVER['REQUEST_METHOD'] . "Request method not allowed"]);
        break;
}

?>