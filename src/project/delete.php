
<?php
require_once './config.php';
session_start();
$id = $_GET['id'];

$sql = "DELETE FROM items WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
