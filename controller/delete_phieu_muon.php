<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE, GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
include('../connect/function_phieu_muon.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "DELETE") {
    if (isset($_GET['id_phieu_muon'])) {
        $deletePhieuMuon = deletePhieuMuon($_GET);
        echo $deletePhieuMuon;
    }
} elseif ($requestMethod == "GET") {
    if (isset($_GET['id_phieu_muon'])) {
        $id_phieu_muon = $_GET['id_phieu_muon'];
        $PhieuMuonInfo = getPhieuMuonInfo($id_phieu_muon);
        echo json_encode($PhieuMuonInfo);
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
