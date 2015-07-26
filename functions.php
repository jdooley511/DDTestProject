<?php

function db_connect() {
    // Database configuration
    $hostname = 'localhost';
    $username = 'root';
    $password = 'please';    

    try {
        $db = new PDO("mysql:host=$hostname;dbname=mysql", $username, $password);
        return $db;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

?>