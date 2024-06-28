<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THÊM THẺ MỚI</title>
    <link rel="stylesheet" href="./css.css">
    <!-- Thêm các link CSS cần thiết -->
    <link rel="stylesheet" href="path/to/your/css/style.css">
</head>
<body>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">THÊM THẺ MỚI</h2>
                    <!-- Form thêm sách -->
                    <form id="add-book-form" method="POST" action="./controller/card_create.php">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>ID Độc Giả</th>
                                    <th>Ngày Đăng Ký</th>
                                    <th>Ngày Hết Hạn</th>
                                    <th>Thêm</th>
                                    <th>Back</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="number" name="IDDocGia" required></td>
                                    <td><input type="date" name="NgayDangKy" required></td>
                                    <td><input type="date" name="NgayHetHan" required></td>

                                    <td>
                                        <!-- Nút thêm sách -->
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                    </td>
                                    <td>
                                     <!-- Nút quay lại -->
                                      <a href="cardindex.php" class="btn btn-secondary">Back</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </script>
</body>
</html>
