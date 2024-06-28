<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost"; // Tên máy chủ MySQL
$username = "root"; // Tên người dùng MySQL
$password = ""; // Mật khẩu MySQL
$dbname = "java"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra xem có bookID được truyền qua URL không
if(isset($_GET['bookID'])) {
    $bookID = $_GET['bookID'];

    // Truy vấn dữ liệu của sách cần sửa
    $sql = "SELECT * FROM themsach WHERE bookID = $bookID";
    $result = $conn->query($sql);

    // Kiểm tra kết quả truy vấn
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bookName = $row["bookName"];
        $language = $row["language"];
        $price = $row["price"];
        $quantity = $row["quantity"];
        $category = $row["category"];
        $publisher = $row["publisher"];
        $year = $row["year"];
    } else {
        echo "Không có dữ liệu";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SỬA SÁCH</title>
    <!-- Thêm các link CSS cần thiết -->
    <link rel="stylesheet" href="./css.css">
</head>
<body>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">SỬA SÁCH</h2>
                    <!-- Form sửa sách với phương thức POST -->
                    <form id="edit-book-form" method="PUT" action="http://localhost/BTL/controller/update.php">
                        <input type="hidden" name="bookID" value="<?php echo isset($bookID) ? $bookID : ''; ?>">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sách</th>
                                    <th>Ngôn ngữ</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thể loại</th>
                                    <th>Nhà xuất bản</th>
                                    <th>Năm xuất bản</th>
                                    <th>Hành Động</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo isset($bookID) ? $bookID : ''; ?></td> <!-- Hiển thị bookID -->
                                    <td><input type="text" name="bookName" value="<?php echo isset($bookName) ? $bookName : ''; ?>" required></td>
                                    <td><input type="text" name="language" value="<?php echo isset($language) ? $language : ''; ?>" required></td>
                                    <td><input type="number" name="price" value="<?php echo isset($price) ? $price : ''; ?>" required></td>
                                    <td><input type="number" name="quantity" value="<?php echo isset($quantity) ? $quantity : ''; ?>" required></td>
                                    <td><input type="text" name="category" value="<?php echo isset($category) ? $category : ''; ?>" required></td>
                                    <td><input type="text" name="publisher" value="<?php echo isset($publisher) ? $publisher : ''; ?>" required></td>
                                    <td><input type="number" name="year" value="<?php echo isset($year) ? $year : ''; ?>" required></td>
                                    <td>
                                        <!-- Nút cập nhật sách -->
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>


                                        <!-- Nút quay lại -->
                                        <a href="thu.php" class="btn btn-secondary1">Back</a>

                                </tr>
                                <!-- Các hàng dữ liệu khác có thể được thêm vào đây -->
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>
</html>

