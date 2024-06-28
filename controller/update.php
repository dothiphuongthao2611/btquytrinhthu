<?php
//error_reporting(0);
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT, GET'); // Thêm phương thức GET
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
include('../connect/function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'PUT') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $updateBook = updateBook($_PUT, $_GET);
    } else {
        $updateBook = updateBook($inputData, $_GET);
    }
    echo $updateBook;
} elseif ($requestMethod == 'GET') { // Xử lý phương thức GET
    // Lấy dữ liệu từ URL và gọi hàm updateBook
    $updateBook = updateBook($_GET, $_GET);
    echo $updateBook;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>
