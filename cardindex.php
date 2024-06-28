<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÝ THẺ MƯỢN SÁCH</title>
    <link rel="stylesheet" href="./css.css">
    <link rel="stylesheet" href="./css_menu.css">
    <!-- Thêm các link CSS và thư viện JavaScript cần thiết -->
    <!-- Thêm CSS cho button delete -->

    <style>
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        .pagination a {
            padding: 8px 16px;
            margin: 0 5px;
            border: 1px solid #ccc;
            text-decoration: none;
            color: black;
            border-radius: 5px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<div class="menu">
        <a href="menu.php">NHÓM 4</a>
        <a href="thu.php">QUẢN LÝ SÁCH</a>
        <a href="./view/viewdg.php">QUẢN LÝ ĐỘC GIẢ</a>
        <a href="index_phieu_muon.php">QUẢN LÝ MƯỢN TRẢ</a>
        <a href="cardindex.php">QUẢN LÝ THẺ MƯỢN</a>
    </div>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">DANH SÁCH THẺ</h2>
                    <a href="menu.php" class="btn btn-primary1 mb-3 add-button">HOME</a>

                    <!-- Nút thêm -->
                    <!-- <a href="themthe.php" class="btn btn-primary mb-3">Thêm thẻ</a> -->
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Độc Giả</th>
                                <th>Ngày Đăng Ký</th>
                                <th>Ngày Hết Hạn</th>
                                <th>Hành động</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dữ liệu sách từ cơ sở dữ liệu -->
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

                            $limit = 5; // Số lượng sách trên mỗi trang
                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                            $start = ($currentPage - 1) * $limit;

                            // Truy vấn dữ liệu từ cơ sở dữ liệu với LIMIT và OFFSET
                            $sql = "SELECT * FROM qlythe LIMIT $start, $limit";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row["ID"]; ?></td>
                                <td><?php echo $row["IDDocGia"]; ?></td>

                                <td><?php echo date('d-m-Y', strtotime($row["NgayDangKy"])); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row["NgayHetHan"])); ?></td>

                                <td>
                                <a href="cardthem.php" class="btn btn-danger mb-3">Thêm thẻ</a>
                                    <!-- Nút sửa -->
                                    <a href="./cardsua.php?ID=<?php echo $row["ID"]; ?>" class="btn btn-danger">Sửa</a>
                                    <!-- Nút xoá -->
                                    <button class="btn btn-danger delete-button" data-cardid="<?php echo $row["ID"]; ?>">Xoá</button>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="9">Không có dữ liệu</td>
                            </tr>
                            <?php
                            }
                             // Tính tổng số trang
                             $sqlTotal = "SELECT COUNT(*) AS total FROM qlythe";
                             $resultTotal = $conn->query($sqlTotal);
                             $rowTotal = $resultTotal->fetch_assoc();
                             $totalPages = ceil($rowTotal["total"] / $limit);

                             $conn->close();
                            ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $activeClass = ($i == $currentPage) ? 'active' : '';
                            echo '<a href="cardindex.php?page=' . $i . '" class="' . $activeClass . '">' . $i . '</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Thêm thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Bắt sự kiện click cho nút delete
            $('.delete-button').click(function() {
                // Lấy ID từ thuộc tính data-cardid
                var ID = $(this).data('cardid');
                // Hiển thị cảnh báo xác nhận
                if (confirm("Bạn có chắc chắn muốn xóa thẻ này không?")) {
                    // Gửi yêu cầu DELETE bằng AJAX
                    $.ajax({
                        url: `http://localhost/BTL/controller/card_delete.php?ID=${ID}`,
                        type: 'DELETE',
                        success: function(response) {
                            alert("Xóa thẻ thành công!");
                            // Tải lại trang sau khi xóa
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert("Đã xảy ra lỗi khi xóa thẻ!");
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
