<?php
//error_reporting(0);
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT, GET'); // Thêm phương thức GET
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
include('../connect/function_phieu_muon.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'PUT') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $updatePhieuMuon = updatePhieuMuon($_PUT, $_GET);
    } else {
        $updatePhieuMuon = updatePhieuMuon($inputData, $_GET);
    }
    echo $updatePhieuMuon;
} elseif ($requestMethod == 'GET') { // Xử lý phương thức GET
    // Lấy dữ liệu từ URL và gọi hàm updateBook
    $updatePhieuMuon = updatePhieuMuon($_GET, $_GET);
    echo $updatePhieuMuon;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>
