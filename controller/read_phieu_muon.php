<?php
 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Methods:GET');
 header('Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Request-With');
 include('../connect/function_phieu_muon.php'); $requesstMethod=$_SERVER["REQUEST_METHOD"];

if ($requesstMethod == "GET") {
  if (isset($_GET['id_phieu_muon'])) {
      $PhieuMuon = getPhieuMuon($_GET);
      echo $PhieuMuon . PHP_EOL; // Thêm dấu phân cách
  } else {
      $PhieuMuonList = getPhieuMuonList();
      echo $PhieuMuonList;
  }
} else {
  $data = [
      'status' => 405,
      'messager' => $requesstMethod . ' Method Not Allowed',
  ];
  header("HTTP/1.0 405 Method Not Allowed");
  echo json_encode($data);
}

?>