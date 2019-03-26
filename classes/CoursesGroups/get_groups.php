<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <?php
        include './../Core/Logics.php';
        $course=$_GET["c"];
        $logic = new Logics();
        $logic->Connect();

        echo "<table border='1'>";
        echo "<tr>";
        $str = "<th>Группы курса ";
        $str .= $course;
        $str .= "</th>";
            echo $str;
        echo "</tr>";
        $arr = $logic->GetGroups($course);


        foreach ($arr as &$value) {
            echo "<tr>";
                echo "<td>" . $value['Name'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </body>
</html>