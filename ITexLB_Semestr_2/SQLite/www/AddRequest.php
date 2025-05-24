<?php
    function LogRequest($QueryType, $QueryParams) {
        date_default_timezone_set('Europe/Kyiv');
        $DBLog = new PDO('sqlite:LogDB.sqlite');
        $DBLog->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $request = $DBLog->prepare("INSERT INTO logs (Query, Params, LocalTime) VALUES (?, ?, ?)");
        $request->execute([$QueryType, json_encode($QueryParams, JSON_UNESCAPED_UNICODE), date('d.m.Y H:i:s')]);
    }
?>
