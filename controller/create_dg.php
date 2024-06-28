<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Include file chứa các hàm xử lý
include('../connect/function_dg.php');

// Xác định phương thức yêu cầu
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Xử lý yêu cầu POST
if ($requestMethod == 'POST') {
    // Lấy dữ liệu đầu vào từ request
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra nếu dữ liệu rỗng
    if (empty($inputData)) {
        // Gọi hàm storeReader với dữ liệu từ $_POST
        $storeReader = storeReader($_POST);
    } else {
        // Gọi hàm storeReader với dữ liệu từ JSON
        $storeReader = storeReader($inputData);
    }

    // Trả về kết quả dưới dạng JSON
    echo json_encode($storeReader);
} else {
    // Nếu không phải yêu cầu POST, trả về lỗi 405
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    http_response_code(405);
    echo json_encode($data);
}
?>
