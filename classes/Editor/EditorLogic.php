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

if(isset($_POST['editorLogic'])) {
    switch ($_POST['editorLogic']){
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
        case 'getSubjects':
            $arr = $logic->GetSubjects();
            echo json_encode($arr);
            break;
        case 'getRooms':
            $arr = $logic->GetRooms();
            echo json_encode($arr);
            break;
        case 'save':
            $time = $_POST['arguments'][0];
            $day = $_POST['arguments'][1];
            $group = $_POST['arguments'][2];
            $room = $_POST['arguments'][3];
            $subj = $_POST['arguments'][4];
            
            
            $arr = $logic->SetSchedule($time, $day, $group, $room, $subj);
            echo json_encode($arr);
            break;
        case 'change':
            $time = $_POST['arguments'][0];
            $day = $_POST['arguments'][1];
            $group = $_POST['arguments'][2];
            $room = $_POST['arguments'][3];
            $subj = $_POST['arguments'][4];
            
            
            $arr = $logic->ChangeSchedule($time, $day, $group, $room, $subj);
            echo json_encode($arr);
            break;
        case 'delete':
            $time = $_POST['arguments'][0];
            $day = $_POST['arguments'][1];
            $group = $_POST['arguments'][2];
            $room = $_POST['arguments'][3];
            $subj = $_POST['arguments'][4];
            
            
            $arr = $logic->DeleteSchedule($time, $day, $group, $room, $subj);
            echo json_encode($arr);
            break;
        default:
            echo 'Не нашел определения для '.$_POST['editorLogic'].'!';
            break;
    }

}