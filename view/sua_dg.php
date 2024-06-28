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

// Kiểm tra xem có readerId được truyền qua URL không
if(isset($_GET['readerId'])) {
    $readerId = $_GET['readerId'];

    // Truy vấn dữ liệu của độc giả cần sửa
    $sql = "SELECT * FROM docgia2 WHERE readerId = $readerId";
    $result = $conn->query($sql);

    // Kiểm tra kết quả truy vấn
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $readername = $row["readername"];
        $lop = $row["lop"];
        $gender = $row["gender"];
        $email = $row["email"];
        $phone = $row["phone"];
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
    <title>SỬA ĐỘC GIẢ</title>
    <!-- Thêm các link CSS cần thiết -->
    <link rel="stylesheet" href="../css.css">
</head>
<body>

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">SỬA ĐỘC GIẢ </h2>
                    <!-- Form sửa độc giả với phương thức POST -->
                    <form id="edit-reader-form" method="PUT" action="http://localhost/BTL/controller/update_dg.php">
                        <input type="hidden" name="readerId" value="<?php echo isset($readerId) ? $readerId : ''; ?>">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên Độc Giả</th>
                                    <th>Lớp</th>
                                    <th>Giới Tính</th>
                                    <th>Email</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Cập Nhật</th>
                                    <th>Back</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo isset($readerId) ? $readerId : ''; ?></td> <!-- Hiển thị readerId -->
                                    <td><input type="text" name="readername" value="<?php echo isset($readername) ? $readername : ''; ?>" required></td>
                                    <td><input type="text" name="lop" value="<?php echo isset($lop) ? $lop : ''; ?>" required></td>
                                    <td><input type="text" name="gender" value="<?php echo isset($gender) ? $gender : ''; ?>" required></td>
                                    <td><input type="text" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required></td>
                                    <td><input type="number" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>" required></td>
                                    <td>
                                        <!-- Nút cập nhật độc giả -->
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </td>
                                    <td>
                                        <!-- Nút quay lại -->
                                        <a href="viewdg.php" class="btn btn-secondary">Back</a>
                                    </td>
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

