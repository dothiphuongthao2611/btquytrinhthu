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
if(isset($_GET['ID'])) {
    $ID = $_GET['ID'];

    // Truy vấn dữ liệu của sách cần sửa
    $sql = "SELECT * FROM qlythe WHERE ID = $ID";
    $result = $conn->query($sql);

    // Kiểm tra kết quả truy vấn
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $IDDocGia = $row["IDDocGia"];
        $NgayDangKy = $row["NgayDangKy"];
        $NgayHetHan = $row["NgayHetHan"];


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
    <title>SỬA THẺ</title>
    <link rel="stylesheet" href="./css.css">
    <!-- Thêm các link CSS cần thiết -->
    <link rel="stylesheet" href="path/to/your/css/style.css">
</head>
<body>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">SỬA THẺ</h2>
                    <!-- Form sửa sách với phương thức POST -->
                    <form id="edit-book-form" method="PUT" action="http://localhost/BTL/controller/card_update.php">
                        <input type="hidden" name="ID" value="<?php echo isset($ID) ? $ID : ''; ?>">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>IDDocGia</th>
                                    <th>Ngày Đăng Ký</th>
                                    <th>Ngày Hết Hạn</th>
                                    <th>Cập Nhật</th>
                                    <th>Back</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo isset($ID) ? $ID : ''; ?></td> <!-- Hiển thị id_phieu_muon -->
                                    <td><input type="number" name="IDDocGia" value="<?php echo isset($IDDocGia) ? $IDDocGia : ''; ?>" required></td>

                                    <td><input type="date" name="NgayDangKy" value="<?php echo isset($NgayDangKy) ? $NgayDangKy : ''; ?>" required></td>
                                    <td><input type="date" name="NgayHetHan" value="<?php echo isset($NgayHetHan) ? $NgayHetHan : ''; ?>" required></td>



                                    <td>
                                        <!-- Nút cập nhật sách -->
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </td>
                                    <td>
                                        <!-- Nút quay lại -->
                                        <a href="cardindex.php" class="btn btn-secondary">Back</a>
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