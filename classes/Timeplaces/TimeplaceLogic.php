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

if(isset($_POST['timeplaceLogic'])) {
    switch ($_POST['timeplaceLogic']){
        case 'add':
            $newStart = $_POST['arguments'][0];
            $newStop = $_POST['arguments'][1];
            $newOddity = $_POST['arguments'][2];
            $logic->AddTimeplace($newStart, $newStop, $newOddity);
            echo "Добавил время";
            break;
        case 'change':
            $oldID = $_POST['arguments'][0];
            $newStart = $_POST['arguments'][1];
            $newStop = $_POST['arguments'][2];
            $newOddity = $_POST['arguments'][3];
            $logic->ChangeTimeplace($oldID, $newStart, $newStop, $newOddity);
            echo "Изменил время";
            break;
        case 'delete':
            $oldID = $_POST['arguments'][0];
            $logic->DeleteTimeplace($oldID);
            echo "Удалил время";
            break;
        default:
            echo 'Не нашел определения для '.$_POST['timeplaceLogic'].'!';
            break;
    }
}


if(isset($_POST['dayLogic'])) {
    switch ($_POST['dayLogic']){
        case 'add':
            $newDay = $_POST['arguments'][0];
            $logic->AddDay($newDay);
            echo "Добавил день";
            break;
        case 'change':
            $oldDay = $_POST['arguments'][0];
            $newDay = $_POST['arguments'][1];
            $logic->ChangeDay($oldDay, $newDay);
            echo "Изменил день";
            break;
        case 'delete':
            $oldDay = $_POST['arguments'][0];
            $logic->DeleteDay($oldDay);
            echo "Удалил день";
            break;
        default:
            echo 'Не нашел определения для '.$_POST['dayLogic'].'!';
            break;
    }
}