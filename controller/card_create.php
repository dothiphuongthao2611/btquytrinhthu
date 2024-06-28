<?php
error_reporting(0);
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST'); // Sửa từ 'Access-Control-Allow-Method' thành 'Access-Control-Allow-Methods'
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
include('../connect/card_function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'POST') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $storeCard = storeCard($_POST);
    } else {
        $storeCard = storeCard($inputData);

    }
    echo $storeCard;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed', // Sửa 'messager' thành 'message'
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>
