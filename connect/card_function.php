<?php
require '../connect/dbcon.php';

function error422($message){
  $data=[
    'status' =>422,
    'messager' => $message,
  ];
  header("HTTP/1.0 422 Method Not Allowed");
  echo json_encode($data);
  exit();
}

function storeCard($CardInput) {
  global $conn;
  $IDDocGia = (int)$CardInput['IDDocGia']; // Assuming Iddocgia is passed in $CardInput

  // Chuyển đổi ngày mượn và ngày trả thành định dạng ngày tháng
  if (!empty($CardInput['NgayDangKy']) && $CardInput['NgayDangKy'] !== '0') {
      $NgayDangKy = date('Y-m-d', strtotime($CardInput['NgayDangKy']));
  } else {
      return error422('Vui lòng nhập ngày đăng ký');
  }

  if (!empty($CardInput['NgayHetHan']) && $CardInput['NgayHetHan'] !== '0') {
      $NgayHetHan = date('Y-m-d', strtotime($CardInput['NgayHetHan']));
  } else {
      return error422('Vui lòng nhập ngày hết hạn');
  }

  if ($IDDocGia <= 0) {
      return error422('Vui lòng nhập Iddocgia');
  } else {
      // Sử dụng prepared statement để thêm dữ liệu vào cơ sở dữ liệu
      $query = "INSERT INTO qlythe (IDDocGia, NgayDangKy, NgayHetHan) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($query);
      $stmt->bind_param('iss', $IDDocGia, $NgayDangKy, $NgayHetHan);
      $result = $stmt->execute();

      if ($result) {
          // $data=[
          //     'status' => 201,
          //     'message' => 'Card created successfully',
          // ];
          // header("HTTP/1.0 201 Created");
          // echo json_encode($data);
        header("Location: ../cardindex.php");
                    exit();
      } else {
          $data=[
              'status' => 500,
              'message' => 'Server Error',
          ];
          header("HTTP/1.0 500 Server Error");
          echo json_encode($data);
      }
  }
}

function getCardList(){
    global $conn;
    $requesstMethod = $_SERVER["REQUEST_METHOD"];

    $query = "SELECT * FROM qlythe";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        if(mysqli_num_rows($query_run) > 0){
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => $requesstMethod . ' Cardlist successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            echo json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => $requesstMethod . ' No card found',
            ];
            header("HTTP/1.0 404 Not Found");
            echo json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => $requesstMethod . ' Internal server error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode($data);
    }
}


function getCard($cardParams){
    global $conn;
    if ($cardParams['ID'] == null) {
        return error422('Enter your card ID');
    }

    $ID = mysqli_real_escape_string($conn, $cardParams['ID']);
    $query = "SELECT * FROM qlythe WHERE ID=? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $ID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_assoc($result);
            $data = [
                'status' => 200,
                'message' => 'Card Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No card found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal server error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function updateCard($CardInput, $CardParams) {
  global $conn;

  // Check if id_phieu_muon exists in $PhieuMuonParams
  if (!isset($CardParams['ID'])) {
      return error422('ID not found in URL');
  } elseif (empty($CardParams['ID'])) {
      return error422('Enter the ID');
  }

  // Sanitize id_phieu_muon to prevent SQL injection
  $ID = mysqli_real_escape_string($conn, $CardParams['ID']);

  $IDDocGia = (int)$CardInput['IDDocGia'];

  // Chuyển đổi ngày mượn và ngày trả thành định dạng ngày tháng
  if (!empty($CardInput['NgayDangKy']) && $CardInput['NgayDangKy'] !== '0') {
      $NgayDangKy = date('Y-m-d', strtotime($CardInput['NgayDangKy']));
  } else {
      return error422('Vui lòng nhập ngày mượn');
  }if (!empty($CardInput['NgayHetHan']) && $CardInput['NgayHetHan'] !== '0') {
    $NgayHetHan = date('Y-m-d', strtotime($CardInput['NgayHetHan']));
} else {
    return error422('Vui lòng nhập ngày trả');
}

if ($IDDocGia <= 0) {
    return error422('Vui lòng nhập IDDocGia');

} elseif (empty($NgayDangKy)) {
    return error422('Vui lòng nhập ngày mượn');
} elseif (empty($NgayHetHan)) {
    return error422('Vui lòng nhập ngày trả');
} else {
    // Execute SQL query to update book information
    $query = "UPDATE qlythe
              SET IDDocGia='$IDDocGia',

              NgayDangKy='$NgayDangKy',
              NgayHetHan='$NgayHetHan'
              WHERE ID='$ID'";

    $result = mysqli_query($conn, $query);

    // Check query execution result
    if ($result) {
        // Return success message
        // $data = [
        //     'status' => 200,
        //     'message' => 'Card Updated successfully',
        // ];
        // header("HTTP/1.0 200 OK");
        // echo json_encode($data);
        header("Location: ../cardindex.php");
        exit();
    } else {
        // Handle error if query fails
        $data = [
            'status' => 500,
            'message' => 'Server Error',
        ];
        header("HTTP/1.0 500 Server Error");
        echo json_encode($data);
    }
}
}


function deleteCard($CardParams){
  global $conn;
  if (!isset($CardParams['ID'])) {
      return error422('ID not found in URL');
  } elseif ($CardParams['ID'] == null) {
      return error422('Enter the ID');
  }
  $ID = mysqli_real_escape_string($conn, $CardParams['ID']);
  $query = "DELETE FROM qlythe WHERE ID='$ID' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if ($result) {
      $data = [
          'status' => 200,
          'message' => 'Card deleted successfully',
      ];
      header("HTTP/1.0 200 OK");
      echo json_encode($data);
  } else {
      $data = [
          'status' => 404,
          'message' => 'Card not found or could not be deleted',
      ];
      header("HTTP/1.0 404 Not found");
      echo json_encode($data);
  }
}

?>
