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

if(isset($_POST['courseLogic']) ) {
    switch ($_POST['courseLogic']){
        case 'add':
            $newCourse = $_POST['arguments'][0];
            $logic->AddCourse($newCourse);
            echo "Добавил курс";
            break;
        case 'change':
            $oldCourse = $_POST['arguments'][0];
            $newCourse = $_POST['arguments'][1];
            $logic->ChangeCourse($oldCourse, $newCourse);
            echo "Изменил курс";
            break;
        case 'delete':
            $oldCourse = $_POST['arguments'][0];
            $logic->DeleteCourse($oldCourse);
            echo "Удалил курс";
            break;
        case 'get':
            echo json_encode($logic->GetCourses());
            break;
        default:
            echo 'Не нашел определения для '.$_POST['courseLogic'].'!';
            break;
    }
}

if(isset($_POST['groupLogic']) ) {
    switch ($_POST['groupLogic']){
        case 'add':
            $course = $_POST['arguments'][0];
            $newGroup = $_POST['arguments'][1];
            $logic->AddGroup($course, $newGroup);
            echo "Добавил группу";
            break;
        case 'change':
            $course = $_POST['arguments'][0];
            $oldGroup = $_POST['arguments'][1];
            $newGroup = $_POST['arguments'][2];
            $logic->ChangeGroup($course, $oldGroup, $newGroup);
            echo "Изменил группу";
            break;
        case 'delete':
            $course = $_POST['arguments'][0];
            $oldGroup = $_POST['arguments'][1];
            $logic->DeleteGroup($course, $oldGroup);
            echo "Удалил группу";
            break;
        default:
            echo 'Не нашел определения для '.$_POST['groupLogic'].'!';
            break;
    }

}