<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE, GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
include('../connect/function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "DELETE") {
    if (isset($_GET['bookID'])) {
        $deleteBook = deleteBook($_GET);
        echo $deleteBook;
    }
} elseif ($requestMethod == "GET") { // Thêm xử lý cho phương thức GET
    if (isset($_GET['bookID'])) {
        $bookID = $_GET['bookID'];

        // Truy vấn dữ liệu của sách cần lấy
        $bookInfo = getBookInfo($bookID);
        echo $bookInfo;
    }
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>
