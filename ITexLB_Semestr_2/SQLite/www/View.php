<?php
    $DBLog = new PDO('sqlite:LogDB.sqlite');
    $DBLog->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $Logs = $DBLog->query("SELECT * FROM logs")->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Логи запитів:</h2>";
    if ($Logs) {
        foreach ($Logs as $log) {
            echo "<p><b>Тип:</b> {$log['Query']}<br>";
            echo "<b>Параметри:</b> {$log['Params']}<br>";
            echo "<b>Дата:</b> {$log['LocalTime']}</p><hr>";
        }
    } else {
        echo "Пусто.";
    }
?>
