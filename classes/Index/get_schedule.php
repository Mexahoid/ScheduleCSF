<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <?php
        include './../Core/Logics.php';
        $logic = new Logics();
        $logic->Connect();
        $group = null;
        $oddity = null;
        $course = $_POST['course'];
        if(isset($_POST['group']))
            $group = $_POST['group'];
        if(isset($_POST['oddity']))
            $oddity = $_POST['oddity']; // отсюда надо брать TimePlaces
        $day = $_POST['day'];

        
        if($oddity != null)
            $timeplaces = $logic->GetTimeplacesOddity($oddity);
        else
            $timeplaces = $logic->GetTimeplaces();
        if($group != null)
            $groups = $logic->GetGroup($group, $course);
        else
            $groups = $logic->GetGroups($course);


        echo "<table border='1' id=\"Schedule\">";
            echo "<tr>";
                echo "<th colspan=\"" . (sizeof($groups) + 1) ."\">Расписание</th>";
            echo "</tr>";

            echo "<tr>";
                echo "<th class=\"TimeTD\">Время</th>";
                foreach ($groups as &$grp) {
                echo "<th>" . $grp['Name'] . "</th>";
                }
            echo "</tr>";


        foreach ($timeplaces as &$timeplace) {
            echo "<tr>";
            echo "<td class=\"TimeTD\">" . $timeplace['Start'] . "-" . $timeplace['Stop'] . "</td>";
            foreach ($groups as &$grp) {
                $sched = $logic->GetSchedule($timeplace['ID'], $course, $grp['ID'], $day);
                $r = "";
                if(isset($sched[0]['ID_Subject']) && isset($sched[0]['ID_Room']))
                {
                    $subj = $logic->GetSubjectByID($sched[0]['ID_Subject'])[0]['Name'];
                    $room = $logic->GetRoomByID($sched[0]['ID_Room'])[0]['Name'];
                    $r = $subj . ", " . $room;
                    echo "<td>" . $r . "</td>";
                }
                else
                    echo "<td></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </body>
</html>
                