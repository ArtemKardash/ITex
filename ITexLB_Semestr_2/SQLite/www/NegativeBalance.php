<?php
require 'Connection.php';
require 'AddRequest.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    LogRequest("NegativeBalance", []);
    $request = $dbh->prepare("SELECT name, balance FROM client WHERE balance < 0");
    $request->execute();
    $Balance = $request->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2> Список клієнтів з від'ємним балансом: </h2>";
    if ($Balance) {
        foreach ($Balance as $B) {
            echo "<p style='font-size: 20px'>Клієнт: {$B['name']}, Баланс: {$B['balance']} <br></p>";
        }
    } else {
        echo "<p style='font-size: 20px'> Немає клієнтів з від'ємним балансом! </p>";
    }
}
?>