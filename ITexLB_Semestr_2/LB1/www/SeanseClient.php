<?php
require 'Connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client = $_POST['Client'];

    $request = $dbh->prepare("SELECT seanse.* FROM seanse JOIN client ON seanse.fid_client = client.id_client WHERE client.name = ?");
    $request->execute([$client]);
    $seansetime = $request->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Сеанси клієнта $client: </h2>";
    foreach ($seansetime as $time) {
        echo "<p style='font-size: 20px'> Початок сеансу: {$time['start']} <br> Кінець сеансу: {$time['stop']} <br> Вхідний трафік: {$time['in_traffic']}<br> Вихідний трафік: {$time['out_traffic']}</p>";
    }
}
?>
