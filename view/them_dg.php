<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THÊM ĐỘC GIẢ MỚI</title>
    <!-- Thêm các link CSS cần thiết -->
    <link rel="stylesheet" href="../css.css">
</head>
<body>

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">THÊM ĐỘC GIẢ MỚI</h2>
                    <!-- Form thêm độc giả -->
                    <form id="add-reader-form" method="POST" action="../controller/create_dg.php">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>Tên Độc Giả</th>
                                    <th>Lớp</th>
                                    <th>Giới Tính</th>
                                    <th>Email</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Hành Động</th>
                                    <th>Back</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="readername" required></td>
                                    <td><input type="text" name="lop" required></td>
                                    <td><input type="text" name="gender" required></td>
                                    <td><input type="text" name="email" required></td>
                                    <td><input type="number" name="phone" required></td>
                                    <td>
                                        <!-- Nút thêm độc giả -->
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                    </td>
                                    <td>
                                     <!-- Nút quay lại -->
                                      <a href="viewdg.php" class="btn btn-secondary">Back</a>
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
