<?php
$host     = 'localhost';
$db       = 'vac078';
$user     = 'root';
$password = 'Data@2020';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
    $connect = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo $e->getMessage();
}

session_start();
