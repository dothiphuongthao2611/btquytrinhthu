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
if(isset($_GET['id_phieu_muon'])) {
    $id_phieu_muon = $_GET['id_phieu_muon'];

    // Truy vấn dữ liệu của sách cần sửa
    $sql = "SELECT * FROM phieu_muon WHERE id_phieu_muon = $id_phieu_muon";
    $result = $conn->query($sql);

    // Kiểm tra kết quả truy vấn
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bookId = $row["bookId"];
        $readerID = $row["readerID"];
        $so_luong = $row["so_luong"];
        $phi_muon = $row["phi_muon"];
        $ngay_muon = $row["ngay_muon"];
        $ngay_tra = $row["ngay_tra"];
        $tinh_trang = $row["tinh_trang"];

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
    <title>Sửa sách</title>
    <!-- Thêm các link CSS cần thiết -->
    <link rel="stylesheet" href="./css.css">
</head>
<body>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">TRẢ PHIẾU MƯỢN</h2>
                    <!-- Form sửa sách với phương thức POST -->
                    <form id="edit-book-form" method="PUT" action="http://localhost/BTL/controller/tra_phieu.php">
                        <input type="hidden" name="id_phieu_muon" value="<?php echo isset($id_phieu_muon) ? $id_phieu_muon : ''; ?>">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>BookID</th>
                                    <th>ReaderID</th>
                                    <th>Số Lượng</th>
                                    <th>Phí Mượn</th>
                                    <th>Ngày Mượn</th>
                                    <th>Ngày Trả</th>
                                    <th>Tình Trạng</th>
                                    <th>Trả Phiếu</th>
                                    <th>Back</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo isset($id_phieu_muon) ? $id_phieu_muon : ''; ?></td> <!-- Hiển thị id_phieu_muon -->
                                    <td><input type="number" name="bookId" value="<?php echo isset($bookId) ? $bookId : ''; ?>" readonly required></td>
                                    <td><input type="number" name="readerID" value="<?php echo isset($readerID) ? $readerID : ''; ?>" readonly required></td>
                                    <td><input type="number" name="so_luong" value="<?php echo isset($so_luong) ? $so_luong : ''; ?>" readonly required></td>
                                    <td><input type="text" name="phi_muon" value="<?php echo isset($phi_muon) ? $phi_muon : ''; ?>" readonly required></td>
                                    <td><input type="date" name="ngay_muon" value="<?php echo isset($ngay_muon) ? $ngay_muon : ''; ?>" readonly required></td>
                                    <td><input type="date" name="ngay_tra" value="<?php echo isset($ngay_tra) ? $ngay_tra : ''; ?>" readonly required></td>
                                    <td><input type="text" name="tinh_trang" value="<?php echo isset($tinh_trang) ? $tinh_trang : ''; ?>" readonly required></td> <!-- Sử dụng thuộc tính readonly -->


                                    <td>
                                        <!-- Nút cập nhật sách -->
                                        <button type="submit" class="btn btn-primary">Trả Phiếu</button>
                                    </td>
                                    <td>
                                        <!-- Nút quay lại -->
                                        <a href="index_phieu_muon.php" class="btn btn-secondary">Back</a>
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

