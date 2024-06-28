<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phiếu mượn mới</title>
    <!-- Thêm các link CSS cần thiết -->
    <link rel="stylesheet" href="./css.css">
</head>
<body>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">THÊM PHIẾU MƯỢN </h2>
                    <!-- Form thêm sách -->
                    <form id="add-book-form1" method="POST" action="./controller/them_moi_phieu_muon.php">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>BookID</th>
                                    <th>ReaderID</th>
                                    <th>Số Lượng</th>
                                    <th>Phí Mượn</th>
                                    <th>Ngày Mượn</th>
                                    <th>Ngày Trả</th>
                                    <th>Thêm</th>
                                    <th>Back</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="number" name="bookId" required></td>
                                    <td><input type="number" name="readerID" required></td>
                                    <td><input type="number" name="so_luong" required></td>
                                    <td><input type="text" name="phi_muon" required></td>
                                    <td><input type="date" name="ngay_muon" required></td>
                                    <td><input type="date" name="ngay_tra" required></td>
                                    <!-- <td><input type="hidden" name="tinh_trang" value="Đang Mượn"></td> -->
                                    <td>
                                        <!-- Nút thêm sách -->
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                    </td>
                                    <td>
                                        <!-- Nút quay lại -->
                                        <a href="index_phieu_muon.php" class="btn btn-secondary">Back</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
