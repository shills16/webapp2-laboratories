<?php

$host = 'localhost'; 
$db = 'posts'; 
$user = 'root'; 
$password = ''; 

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        echo "Connected successfully!";
    }
    
} catch (PDOException $e) {
    echo $e->getMessage();
}
