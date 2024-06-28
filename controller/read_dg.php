<?php
 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Methods:Get');
 header('Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Request-With');
 include('../connect/function_dg.php');
  $requesstMethod=$_SERVER["REQUEST_METHOD"];//lấy phương thức yêu cầu của HTTP hiện tại

if ($requesstMethod == "GET") {
  if (isset($_GET['readerId'])) {
      $redaer = getReader($_GET);
      echo $redaer . PHP_EOL; // Thêm dấu phân cách
  } else {
      $readerList = getReaderList();
      echo $readerList;
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