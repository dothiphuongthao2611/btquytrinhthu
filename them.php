<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THÊM SÁCH MỚI</title>
    <!-- Thêm các link CSS cần thiết -->
    <link rel="stylesheet" href="./css.css">
</head>
<body>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">THÊM SÁCH MỚI</h2>
                    <!-- Form thêm sách -->
                    <form id="add-book-form" method="POST" action="./controller/create.php">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>Tên sách</th>
                                    <th>Ngôn ngữ</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thể loại</th>
                                    <th>Nhà xuất bản</th>
                                    <th>Năm xuất bản</th>
                                    <th>Thêm</th>
                                    <th>Back</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="bookName" required></td>
                                    <td><input type="text" name="language" required></td>
                                    <td><input type="number" name="price" required></td>
                                    <td><input type="number" name="quantity" required></td>
                                    <td><input type="text" name="category" required></td>
                                    <td><input type="text" name="publisher" required></td>
                                    <td><input type="number" name="year" required></td>
                                    <td>
                                        <!-- Nút thêm sách -->
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                    </td>
                                    <td>
                                     <!-- Nút quay lại -->
                                      <a href="thu.php" class="btn btn-secondary">Back</a>
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
