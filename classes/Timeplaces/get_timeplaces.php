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
            echo "<th colspan='4'>Учебные занятия</th>";
        echo "</tr>";
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Начало</th>";
            echo "<th>Конец</th>";
            echo "<th>Ч/З</th>";
        echo "</tr>";
        $arr = $logic->GetTimeplaces();


        foreach ($arr as &$value) {
            echo "<tr>";
                echo "<td>" . $value['ID'] . "</td>";
                echo "<td>" . $value['Start'] . "</td>";
                echo "<td>" . $value['Stop'] . "</td>";
                echo "<td>" . ($value['Odd'] ? "Знам" : "Числ"). "</td>";
            echo "</tr>";
        }
        echo "</table>";
    ?>
</body>
</html>