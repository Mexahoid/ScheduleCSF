<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <?php
        include './../Core/Logics.php';

        $logic = new Logics();
        $logic->Connect();

        echo "<table border='1'>";
        echo "<tr>";
            echo "<th>Курсы</th>";
        echo "</tr>";
        $arr = $logic->GetCourses();


        foreach ($arr as &$value) {
            echo "<tr>";
                echo "<td>" . $value['Number'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </body>
</html>