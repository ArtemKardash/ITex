<?php
require 'Connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $time_start = $_POST['time']; 
    $time_end = $_POST['time2'];

    $start_time = date('H:i', strtotime($time_start));
    $end_time = date('H:i', strtotime($time_end));

    $request = $dbh->prepare("SELECT id_client, name, start, stop FROM client JOIN seanse ON seanse.fid_client = client.id_client WHERE (? BETWEEN seanse.start AND seanse.stop) OR (? BETWEEN seanse.start AND seanse.stop)");
    $request->execute([$start_time, $end_time]);
    $clients = $request->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2> Клієнти, які працювали у заданому проміжку часу (з $time_start по $time_end)</h2>";
    if (count($clients) > 0) {
        foreach ($clients as $client) {
            echo "<p style='font-size: 20px'> Клієнт: {$client['name']}, ID: {$client['id_client']}, Час початку: {$client['start']}, Час виходу: {$client['stop']}</p>";
        }
    } else {
        echo "<p style='font-size: 20px'>Немає клієнтів у заданому проміжку часу.</p>";
    }
}
?>