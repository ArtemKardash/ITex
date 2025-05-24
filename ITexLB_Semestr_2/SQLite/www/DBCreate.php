<?php
    $DBLog = new PDO('sqlite:LogDB.sqlite');
    $DBLog->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $DBLog->exec("
            CREATE TABLE IF NOT EXISTS logs (
            ID INTEGER PRIMARY KEY AUTOINCREMENT,
            Query TEXT,
            Params TEXT,
            LocalTime TEXT
        );
    ");
    echo "БД створено!";
?>
