<?php
require_once './config.php';


// Số mục trên mỗi trang
$itemsPerPage = 10;

// Trang hiện tại, mặc định là 1 nếu không được đặt
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính toán vị trí bắt đầu của mục trên trang hiện tại
$start = ($page - 1) * $itemsPerPage;

// Truy vấn để lấy danh sách mục với phân trang
$sql = "SELECT * FROM items LIMIT $start, $itemsPerPage";

$result = $conn->query($sql);

// Truy vấn để đếm tổng số mục
$totalItems = $conn->query("SELECT COUNT(*) AS total FROM items")->fetch_assoc()['total'];

// Tính toán tổng số trang
$totalPages = ceil($totalItems / $itemsPerPage);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD with Pagination</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Items List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th><a href="create.php" class="btn btn-primary">Create</a></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>
                            <?php  
                                if(isset($row['id'])){
                                    $itemId = $row['id'];
                                    echo "<a href='read.php?id=$itemId' class='btn btn-primary'>Read</a>";
                                }
                            ?>
                        </td>
                        <td>
                            <?php  
                                if(isset($row['id'])){
                                    $itemId = $row['id'];
                                    echo "<a href='edit.php?id=$itemId' class='btn btn-primary'>Update</a>";
                                }
                            ?>
                        </td>
                        <td>
                            <?php  
                                if(isset($row['id'])){
                                    $itemId = $row['id'];
                                    echo "<a href='delete.php?id=$itemId' class='btn btn-danger'>Delete</a>";
                                }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <!-- Pagination Links -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>
</html>
