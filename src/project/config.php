<?php


$host = 'mysql';
$username = 'root';
$password = 'root';
$database = 'test';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
