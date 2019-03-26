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

if(isset($_POST['importexportLogic'])) {
    switch ($_POST['importexportLogic']) {
        case 'import':
            $data = $_POST['arguments'][0];

            $rows = explode("\n", $data);
            $course_row = explode(";", $rows[0]);

            $NO_ADDING = false;
            $logic->ClearAll();

            // ============== Получение списка курсов, первая строка
            $groupcount = 0;
            $currcourse = 1;
            $coursesgroups = [];
            for ($i = 2; $i < sizeof($course_row); $i++) {
                if ($course_row[$i] != "") {
                    if ($currcourse != 0) {
                        $coursesgroups[$currcourse] = $groupcount;
                    }
                    $groupcount = 0;
                    $currcourse = explode(" ", $course_row[$i])[0];
                }
                $groupcount++;
            }

            $courses = [];
            $courses[0] = key($coursesgroups);
            next($coursesgroups);
            for ($i = 1; $i < sizeof($coursesgroups); $i++){
                $courses[$i] = key($coursesgroups);
                next($coursesgroups);
            }

            // ============= Получение списка групп, вторая строка

            $group_row = explode(";", $rows[1]);
            $currgroup = 0;
            $counter = 1;
            $currcourse = 0; // будет выступать как счетчик
            $groups = [];
            $currgroup = 0;
            for ($i = 2; $i < sizeof($group_row); $i++) {

                if ($group_row[$i] == "\r")
                    break;
                if ($group_row[$i] != "") {
                    $currgroup = explode(" ", $group_row[$i])[0];
                    $counter = 1;
                    $groups[$currcourse] = strval($currgroup) . '.' . $counter;
                } else {
                    $groups[$currcourse] = strval($currgroup) . '.' . $counter;
                }
                $currcourse++;
                $counter++;
            }

            $counter = 0;

            $test = [];

            if(!$NO_ADDING)
            {
            for ($i = 0; $i < sizeof($courses); $i++){
                $logic->AddCourse($courses[$i]);

                $bound = $counter + $coursesgroups[$courses[$i]];
                for($j = $counter; $j < $bound; $j++)
                {
                    $test[$j] = $groups[$j];
                    $logic->AddGroup($courses[$i], $groups[$j]);
                }
                $counter += $coursesgroups[$courses[$i]];
            }
            }


            // ============= Получение дней и пар

            $daycount = 0;  // Количество дней
            $days = [];
            $timecount = 1;

            for($i = 2; $i < sizeof($rows); $i++){
                if(substr($rows[$i], 0, 1) != ";" && substr($rows[$i], 0, 1) != "")
                {
                    $days[$daycount++] = mb_convert_encoding(explode(";", $rows[$i])[0], "Windows-1252", "UTF-8");
                    $timecount = 1;
                }
                else
                    $timecount++;
            }

            if(!$NO_ADDING) {
                for ($i = 0; $i < sizeof($days); $i++) {
                    $logic->AddDay($days[$i]);
                }
            }



            // Получить часы пар

            $times = [];
            $counter = 0;
            $times[$counter++] = explode(";", $rows[2])[1];
            for($i = 3; $i < 2 + $timecount; $i++){
                if(substr($rows[$i], 0, 2) != ";;")
                {
                    $times[$counter++] = explode(";", $rows[$i])[1];
                }
            }

            $times_start = [];
            $times_stop = [];

            for ($i = 0; $i < sizeof($times); $i++){
                $spl = explode("-", $times[$i]);
                $start = strval($spl[0]);
                if(strlen($start) == 3)
                    $start = "0" . $start;
                $start = substr_replace($start, ":", 2, 0);

                $stop = strval($spl[1]);
                if(strlen($stop) == 3)
                    $stop = "0" . $stop;
                $stop = substr_replace($stop, ":", 2, 0);

                $times_start[$i] = $start;
                $times_stop[$i] = $stop;
            }


            if(!$NO_ADDING) {
                for ($i = 0; $i < sizeof($times_start); $i++) {
                    $logic->AddTimeplace($times_start[$i], $times_stop[$i], 0);
                    $logic->AddTimeplace($times_start[$i], $times_stop[$i], 1);
                }
            }



            // Получить аудитории и названия предметов

            $rooms = [];
            $subjects = [];

            for($i = 2; $i < sizeof($rows); $i++){
                $substr = explode(";", $rows[$i]);
                for ($j = 2; $j < sizeof($substr); $j++){
                    $subj_room = explode(",", $substr[$j]);
                    if($subj_room != null && sizeof($subj_room) == 2){

                        $add = true;
                        for ($k = 0; $k < sizeof($rooms); $k++){
                            if($rooms[$k] == mb_convert_encoding($subj_room[1], "Windows-1252", "UTF-8"))
                            {
                                $add = false;
                                break;
                            }
                        }
                        if($add){
                            $rooms[sizeof($rooms)] = mb_convert_encoding($subj_room[1], "Windows-1252", "UTF-8");
                        }

                        $add = true;
                        for ($k = 0; $k < sizeof($subjects); $k++){
                            if($subjects[$k] == mb_convert_encoding($subj_room[0], "Windows-1252", "UTF-8"))
                            {
                                $add = false;
                                break;
                            }
                        }
                        if($add){
                            $subjects[sizeof($subjects)] = mb_convert_encoding($subj_room[0], "Windows-1252", "UTF-8");
                        }
                    }
                }
            }

            if(!$NO_ADDING) {
                for ($i = 0; $i < sizeof($rooms); $i++) {
                    $logic->AddRoom($rooms[$i]);
                }

                for ($i = 0; $i < sizeof($subjects); $i++) {
                    $logic->AddSubject($subjects[$i]);
                }
            }


            // ========== Добавление расписания в целом

           $lessons = [];
            for($i = 2; $i < sizeof($rows); $i++){
                for($j = 0; $j < sizeof($days); $j++){
                    for($k = 0; $k < $timecount; $k++){
                        $row = explode(";", $rows[$i++]);
                        for($h = 2; $h < sizeof($row); $h++){
                            if($row[$h] != "" && $row[$h] != "\r"){
                                $subj_room = explode(",", mb_convert_encoding($row[$h],"Windows-1252", "UTF-8"));
                                $day = $days[$j];
                                $oddity = $k % 2;
                                $group = $groups[$h - 2];
                                $start = $times_start[$k / 2];
                                $stop = $times_stop[$k / 2];
                                $subj = $subj_room[0];
                                $room = $subj_room[1];

                                $lessons[sizeof($lessons)] = [$subj, $room, $day, $oddity, $group, $start, $stop];

                            }
                        }
                    }
                }
            }

            if(!$NO_ADDING){
                for ($i = 0; $i < sizeof($lessons); $i++){
                    $timeid = ($logic->GetIDByTimeplace($lessons[$i][5], $lessons[$i][6], $lessons[$i][3]))[0]["ID"];
                    $day = $lessons[$i][2];
                    $group = ($logic->GetIDByGroup($lessons[$i][4]))[0]["ID"];
                    $room = $lessons[$i][1];
                    $subject = $lessons[$i][0];
                    $logic->SetSchedule($timeid, $day, $group, $room, $subject);
                }
            }

            echo json_encode($groups);

            
            //$logic->AddRoom($newRoom);
            break;
        case 'export':

            $courses = $logic->GetCourses();        // ID Number
            $rooms = $logic->GetRooms();            // ID Name
            $days = $logic->GetDays();              // ID Name
            $timeplaces = $logic->GetTimeplaces();  // ID Start Stop Odd
            $subjects = $logic->GetSubjects();      // ID Name
            $groups = [];                           // ID Name ID_Course

            for($i = 0; $i < sizeof($courses); $i++){
                $groups[$courses[$i]["Number"]] = $logic->GetGroups($courses[$i]["Number"]);
            }

            $schedule = $logic->TakeSchedule();     // ID_Timeplace ID_Day ID_Group ID_Room ID_Subject
/*
            // Сначала сформировать шапку

            $row_top = "Дни недели;Часы звонков;";
            for ($i = 0; $i < sizeof($courses); $i++){
                $row_top .= $courses[$i]["Number"] . " курс;";
                for ($j = 1; $j < sizeof($groups[$courses[$i]["Number"]]); $j++){
                    $row_top .= ";";
                }
            }

            // Теперь воткнуть группы

            $row_groups = ";;";

            $groupcount = 0;

            for ($i = 0; $i < sizeof($courses); $i++){
                $currgroup = -1;
                for ($j = 0; $j < sizeof($groups[$courses[$i]["Number"]]); $j++){
                    $group = $groups[$courses[$i]["Number"]][$j]["Name"];
                    $gr_nums = explode(".", $group);
                    if($currgroup == -1)
                    {
                        $currgroup = $gr_nums[0];
                        $row_groups .= $currgroup . " группа;";
                    }
                    else{
                        if($currgroup == $gr_nums[0]){
                            $row_groups .= ";";
                        }
                        else{
                            $currgroup = $gr_nums[0];
                            $row_groups .= $currgroup . " группа;";
                        }
                    }
                    $groupcount++;
                }
            }

            // По дням теперь

            $last_rows = [];

            for ($i = 0; $i < sizeof($days); $i++){
                $first_row = $days[$i]["Name"] . ";";
                $second_row = ";;";
                for ($j = 0; $j < sizeof($timeplaces) / 2; $j++){
                    $start = $timeplaces[$j * 2]["Start"];
                    $stop = $timeplaces[$j * 2]["Stop"];

                    $sstart = substr_replace($start, "", 5, 3);
                    $sstart = substr_replace($sstart, "", 2, 1);
                    $sstop = substr_replace($stop, "", 5, 3);
                    $sstop = substr_replace($sstop, "", 2, 1);

                    if (substr($sstart, 0, 1) == "0")
                        $sstart = substr_replace($sstart, "", 0, 1);
                    if (substr($sstop, 0, 1) == "0")
                        $sstop = substr_replace($sstop, "", 0, 1);

                    $time = $sstart . "-" . $sstop . ";";
                    $first_row .= $time; // second уже ;;

                    $groups_t = [];

                    for ($l = 0; $l < sizeof($courses); $l++){
                        for ($o = 0; $o < sizeof($groups[$courses[$l]["Number"]]); $o++){
                            $groups_t[sizeof($groups_t)] = $groups[$courses[$l]["Number"]][$o];
                        }
                    }

                    for($h = 0; $h < $groupcount; $h++){
                        $groupid = $groups_t[$h]["ID"];
                        $dayid = $days[$i]["ID"];
                        $timeid = $timeplaces[$j * 2]["ID"];

                        for($l = 0; $l < sizeof($schedule); $l++){
                            if($schedule[$l]["ID_Group"] == $groupid && $schedule[$l]["ID_Day"] == $dayid && $schedule[$l]["ID_Timeplace"] == $timeid){
                                $room_id = $schedule[$l]["ID_Room"];
                                $subject_id = $schedule[$l]["ID_Subject"];

                                $room = "";
                                $subject = "";

                                for ($o = 0; $o < sizeof($subjects); $o++){
                                    if($subjects[$o]["ID"] == $subject_id){
                                        $subject = $subjects[$o]["Name"];
                                        break;
                                    }
                                }
                                for ($o = 0; $o < sizeof($rooms); $o++){
                                    if($rooms[$o]["ID"] == $room_id){
                                        $room = $rooms[$o]["Name"];
                                        break;
                                    }
                                }

                                if($subject == "" || $room == "")
                                    break;

                                $first_row .= $subject . ", " . $room . ";";
                                break;
                            }
                        }
                        if($l == sizeof($schedule))
                            $first_row .= ";";


                        $timeid = $timeplaces[$j * 2 + 1]["ID"];

                        for($l = 0; $l < sizeof($schedule); $l++){
                            if($schedule[$l]["ID_Group"] == $groupid && $schedule[$l]["ID_Day"] == $dayid && $schedule[$l]["ID_Timeplace"] == $timeid){
                                $room_id = $schedule[$l]["ID_Room"];
                                $subject_id = $schedule[$l]["ID_Subject"];


                                $room = "";
                                $subject = "";

                                for ($o = 0; $o < sizeof($subjects); $o++){
                                    if($subjects[$o]["ID"] == $subject_id){
                                        $subject = $subjects[$o]["Name"];
                                        break;
                                    }
                                }
                                for ($o = 0; $o < sizeof($rooms); $o++){
                                    if($rooms[$o]["ID"] == $room_id){
                                        $room = $rooms[$o]["Name"];
                                        break;
                                    }
                                }
                                if($subject == "" || $room == "")
                                    break;
                                $second_row .= $subject . ", " . $room . ";";

                                break;
                            }
                        }
                        if($l == sizeof($schedule))
                            $second_row .= ";";
                    }
                }
                $last_rows[sizeof($last_rows)] = $first_row . "\r\n";
                $last_rows[sizeof($last_rows)] = $second_row. "\r\n";
            }

            $final = $row_top . "\r\n" . $row_groups . "\r\n";
            for($i = 0; $i < sizeof($last_rows); $i++){
                $final .= $last_rows[$i];
            }
*/

            echo json_encode($rooms);

            break;
        default:
            echo 'Не нашел определения для '.$_POST['roomLogic'].'!';
            break;
    }

}