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

if( !isset($_POST['subjectLogic']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

if( !isset($aResult['error']) ) {
    switch ($_POST['subjectLogic']){
        case 'add':
            $newSubject = $_POST['arguments'][0];
            $logic->AddSubject($newSubject);
            echo "Добавил новую дисциплину";
            break;
        case 'change':
            $oldSubject = $_POST['arguments'][0];
            $newSubject = $_POST['arguments'][1];
            $logic->ChangeSubject($oldSubject, $newSubject);
            echo "Изменил дисциплину";
            break;
        case 'delete':
            $oldSubject = $_POST['arguments'][0];
            $logic->DeleteSubject($oldSubject);
            echo "Удалил дисциплину";
            break;
        default:
            echo 'Не нашел определения для '.$_POST['subjectLogic'].'!';
            break;
    }

}