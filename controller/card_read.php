<?php
 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Methods:Get');
 header('Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Request-With');
 include('../connect/card_function.php');
 $requesstMethod=$_SERVER["REQUEST_METHOD"];

if ($requesstMethod == "GET") {
  if (isset($_GET['ID'])) {
      $card = getCard($_GET);
      echo $card . PHP_EOL; // Thêm dấu phân cách
  } else {
      $cardList = getCardList();
      echo $cardList;
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