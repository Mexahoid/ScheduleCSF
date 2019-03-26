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

if(isset($_POST['indexLogic'])) {
    switch ($_POST['indexLogic']){
        case 'getCourses':
            $arr = $logic->GetCourses();
            echo json_encode($arr);
            break;
        case 'getGroups':
            $course = $_POST['arguments'][0];
            $arr = $logic->GetGroups($course);
            echo json_encode($arr);
            break;
        case 'getDays':
            $arr = $logic->GetDays();
            echo json_encode($arr);
            break;
        default:
            echo 'Не нашел определения для '.$_POST['indexLogic'].'!';
            break;
    }

}