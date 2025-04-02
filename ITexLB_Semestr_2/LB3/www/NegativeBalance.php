<?php
require 'Connection.php';

$request = $dbh->prepare("SELECT name, balance FROM client WHERE balance < 0");
$request->execute();
$Balance = $request->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($Balance);
?>