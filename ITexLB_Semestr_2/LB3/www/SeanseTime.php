<?php
require 'Connection.php';

$time_start = $_POST['time']; 
$time_end = $_POST['time2'];

$start_time = date('H:i', strtotime($time_start));
$end_time = date('H:i', strtotime($time_end));

$request = $dbh->prepare("SELECT id_client, name, start, stop FROM client JOIN seanse ON seanse.fid_client = client.id_client WHERE (? BETWEEN seanse.start AND seanse.stop) OR (? BETWEEN seanse.start AND seanse.stop)");
$request->execute([$start_time, $end_time]);
$clients = $request->fetchAll(PDO::FETCH_ASSOC);

$xml = new SimpleXMLElement('<clients/>');

if (count($clients) > 0) {
    foreach ($clients as $client) {
        $clientXML = $xml->addChild('client');
        $clientXML->addChild('id', $client['id_client']);
        $clientXML->addChild('name', $client['name']);
        $clientXML->addChild('start', $client['start']);
        $clientXML->addChild('stop', $client['stop']);
    }
} else {
    $xml->addChild('message', 'Немає клієнтів у заданому проміжку часу.');
}

header('Content-Type: application/xml');
echo $xml->asXML();
?>