<?php
require_once './config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM items WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Item</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Item Details</h2>
        <p>ID: <?php echo $row['id']; ?></p>
        <p>Name: <?php echo $row['name']; ?></p>
    </div>
</body>
</html>
