<?php
/**
 * Created by PhpStorm.
 * User: Mexahoid
 * Date: 23.03.2019
 * Time: 18:13
 */

include "./../Core/Logics.php";

$logic = new Logics();
$logic->Connect();

if( !isset($_POST['roomLogic']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

if( !isset($aResult['error']) ) {
    switch ($_POST['roomLogic']){
        case 'add':
            $newRoom = $_POST['arguments'][0];
            $logic->AddRoom($newRoom);
            echo "Добавил аудиторию";
            break;
        case 'change':
            $oldRoom = $_POST['arguments'][0];
            $newRoom = $_POST['arguments'][1];
            $logic->ChangeRoom($oldRoom, $newRoom);
            echo "Изменил аудиторию";
            break;
        case 'delete':
            $oldRoom = $_POST['arguments'][0];
            $logic->DeleteRoom($oldRoom);
            echo "Удалил аудиторию";
            break;
        default:
            echo 'Не нашел определения для '.$_POST['roomLogic'].'!';
            break;
    }

}