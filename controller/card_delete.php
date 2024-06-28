<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE, GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('../connect/card_function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "DELETE") {
    if (isset($_GET['ID'])) {
        $deleteCard = deleteCard($_GET);
        echo $deleteCard;
    }
} elseif ($requestMethod == "GET") { // Thêm xử lý cho phương thức GET
    if (isset($_GET['ID'])) {
        $ID = $_GET['ID'];

        // Truy vấn dữ liệu của sách cần lấy
        $cardInfo = getCardInfo($ID);
        echo $cardInfo;
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
