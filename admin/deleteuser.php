<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "php-train";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$stmt = $conn->prepare("DELETE FROM users WHERE email='" . $_GET['userEmail'] . "'");
$stmt->execute();

header('location: users.php');
