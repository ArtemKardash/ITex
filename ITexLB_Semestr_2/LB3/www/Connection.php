<?php
    $db_driver = "mysql"; 
    $host = "mysql_db"; 
    $database = "lb_pdo_netstat";
    $dsn = "$db_driver:host=$host; dbname=$database";
    $username = "root"; 
    $password = "root";
    $options = array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

    try {   
        $dbh = new PDO ($dsn, $username, $password, $options);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>"; 
        die();
    }             
?>