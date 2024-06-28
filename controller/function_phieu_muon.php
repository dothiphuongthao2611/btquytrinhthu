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

function storePhieuMuon($PhieuMuonInput) {
    global $conn;
    $bookId = (int)$PhieuMuonInput['bookId'];
    $readerID = (int)$PhieuMuonInput['readerID'];
    $so_luong = (int)$PhieuMuonInput['so_luong'];
    $phi_muon = mysqli_real_escape_string($conn, $PhieuMuonInput['phi_muon']);

    // Thêm cột tinh_trang với giá trị mặc định là "Đang Mượn"
    $tinh_trang = 'Đang Mượn';

    // Chuyển đổi ngày mượn và ngày trả thành định dạng ngày tháng
    if (!empty($PhieuMuonInput['ngay_muon']) && $PhieuMuonInput['ngay_muon'] !== '0') {
        $ngay_muon = date('Y-m-d', strtotime($PhieuMuonInput['ngay_muon']));
    } else {
        return error422('Vui lòng nhập ngày mượn');
    }

    if (!empty($PhieuMuonInput['ngay_tra']) && $PhieuMuonInput['ngay_tra'] !== '0') {
        $ngay_tra = date('Y-m-d', strtotime($PhieuMuonInput['ngay_tra']));
    } else {
        return error422('Vui lòng nhập ngày trả');
    }

    if ($bookId <= 0) {
        return error422('Vui lòng nhập bookID');
    } elseif ($readerID <= 0) {
        return error422('Vui lòng nhập readerID');
    } elseif ($so_luong <= 0) {
        return error422('Vui lòng nhập số lượng');
    } elseif (empty(trim($phi_muon))) {
        return error422('Vui lòng nhập phí mượn ');
    } else {
        // Sử dụng prepared statement để thêm dữ liệu vào cơ sở dữ liệu
        $query = "INSERT INTO phieu_muon (bookId, readerID, so_luong, phi_muon, ngay_muon, ngay_tra, tinh_trang) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iiissss', $bookId, $readerID, $so_luong, $phi_muon, $ngay_muon, $ngay_tra, $tinh_trang);
        $result = $stmt->execute();

        if ($result) {
            // $data=[
            //     'status' => 201,
            //     'message' => 'Phiếu Mượn created successfully',
            // ];
            // header("HTTP/1.0 201 Created");
            // echo json_encode($data);
            header("Location: ../index_phieu_muon.php");
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




function getPhieuMuonList(){
    global $conn;
    $requesstMethod = $_SERVER["REQUEST_METHOD"];

    $query = "SELECT * FROM phieu_muon";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        if(mysqli_num_rows($query_run) > 0){
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => $requesstMethod . ' PhieuMuonList successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            echo json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => $requesstMethod . ' No book found',
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


function getPhieuMuon($PhieuMuonParams){
    global $conn;
    if ($PhieuMuonParams['id_phieu_muon'] == null) {
        return error422('Enter your id_phieu_muon');
    }

    $id_phieu_muon = mysqli_real_escape_string($conn, $PhieuMuonParams['id_phieu_muon']);
    $query = "SELECT * FROM phieu_muon WHERE id_phieu_muon=? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $id_phieu_muon);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_assoc($result);
            $data = [
                'status' => 200,
                'message' => 'Phiếu Mượn Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Phiếu Mượn found',
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

function updatePhieuMuon($PhieuMuonInput, $PhieuMuonParams) {
    global $conn;

    // Check if id_phieu_muon exists in $PhieuMuonParams
    if (!isset($PhieuMuonParams['id_phieu_muon'])) {
        return error422('id_phieu_muon not found in URL');
    } elseif (empty($PhieuMuonParams['id_phieu_muon'])) {
        return error422('Enter the id_phieu_muon');
    }

    // Sanitize id_phieu_muon to prevent SQL injection
    $id_phieu_muon = mysqli_real_escape_string($conn, $PhieuMuonParams['id_phieu_muon']);

    $bookId = (int)$PhieuMuonInput['bookId'];
    $readerID = (int)$PhieuMuonInput['readerID'];
    $so_luong = (int)$PhieuMuonInput['so_luong'];
    $phi_muon = mysqli_real_escape_string($conn, $PhieuMuonInput['phi_muon']);

    // Chuyển đổi ngày mượn và ngày trả thành định dạng ngày tháng
    if (!empty($PhieuMuonInput['ngay_muon']) && $PhieuMuonInput['ngay_muon'] !== '0') {
        $ngay_muon = date('Y-m-d', strtotime($PhieuMuonInput['ngay_muon']));
    } else {
        return error422('Vui lòng nhập ngày mượn');
    }

    if (!empty($PhieuMuonInput['ngay_tra']) && $PhieuMuonInput['ngay_tra'] !== '0') {
        $ngay_tra = date('Y-m-d', strtotime($PhieuMuonInput['ngay_tra']));
    } else {
        return error422('Vui lòng nhập ngày trả');
    }

    if ($bookId <= 0) {
        return error422('Vui lòng nhập bookID');
    } elseif ($readerID <= 0) {
        return error422('Vui lòng nhập readerID');
    } elseif ($so_luong <= 0) {
        return error422('Vui lòng nhập số lượng');
    } elseif (empty(trim($phi_muon))) {
        return error422('Vui lòng nhập phí mượn ');
    } elseif (empty($ngay_muon)) {
        return error422('Vui lòng nhập ngày mượn');
    } elseif (empty($ngay_tra)) {
        return error422('Vui lòng nhập ngày trả');
    } else {
        // Execute SQL query to update book information
        $query = "UPDATE phieu_muon
                  SET bookId='$bookId',
                  readerID='$readerID',
                  so_luong='$so_luong',
                  phi_muon='$phi_muon',
                  ngay_muon='$ngay_muon',
                  ngay_tra='$ngay_tra'
                  WHERE id_phieu_muon='$id_phieu_muon'";

        $result = mysqli_query($conn, $query);

        // Check query execution result
        if ($result) {
            // Return success message
            // $data = [
            //     'status' => 200,
            //     'message' => 'Phiếu Mượn Updated successfully',
            // ];
            // header("HTTP/1.0 200 OK");
            // echo json_encode($data);
            header("Location: ../index_phieu_muon.php");
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



function deletePhieuMuon($PhieuMuonParams){
    global $conn;
    if (!isset($PhieuMuonParams['id_phieu_muon'])) {
        return error422('id_phieu_muon not found in URL');
    } elseif ($PhieuMuonParams['id_phieu_muon'] == null) {
        return error422('Enter the id_phieu_muon');
    }
    $id_phieu_muon = mysqli_real_escape_string($conn, $PhieuMuonParams['id_phieu_muon']);
    $query = "DELETE FROM phieu_muon WHERE id_phieu_muon='$id_phieu_muon' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'Phiếu Mượn deleted successfully',
        ];
        header("HTTP/1.0 200 OK");
        echo json_encode($data);
    } else {
        $data = [
            'status' => 404,
            'message' => 'Phiếu Mượn not found or could not be deleted',
        ];
        header("HTTP/1.0 404 Not found");
        echo json_encode($data);
    }
}
function tra_phieu($PhieuMuonParams) {
    global $conn;

    // Kiểm tra xem id_phieu_muon có được truyền qua URL không
    if (!isset($PhieuMuonParams['id_phieu_muon']) || empty($PhieuMuonParams['id_phieu_muon'])) {
        return error422('id_phieu_muon not found in URL');
    }

    // Lấy id_phieu_muon từ tham số
    $id_phieu_muon = mysqli_real_escape_string($conn, $PhieuMuonParams['id_phieu_muon']);

    // Kiểm tra xem phiếu mượn có tồn tại không
    $check_query = "SELECT * FROM phieu_muon WHERE id_phieu_muon = '$id_phieu_muon'";
    $check_result = mysqli_query($conn, $check_query);

    if (!$check_result || mysqli_num_rows($check_result) == 0) {
        return error422('Phiếu Mượn not found');
    }

    // Kiểm tra xem phiếu mượn có đang ở trạng thái "Đã Trả" hay không
    $check_status = "SELECT tinh_trang FROM phieu_muon WHERE id_phieu_muon = '$id_phieu_muon'";
    $status_result = mysqli_query($conn, $check_status);
    $row = mysqli_fetch_assoc($status_result);
    $tinh_trang = $row['tinh_trang'];

    if ($tinh_trang == 'Đã Trả') {
        return error422('Phiếu Mượn is already returned');
    }

    // Cập nhật cột tinh_trang thành "Đã Trả"
    $update_query = "UPDATE phieu_muon SET tinh_trang = 'Đã Trả' WHERE id_phieu_muon = '$id_phieu_muon'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        // Trả về thông báo thành công và dữ liệu mới của phiếu mượn
        $data = [
            'status' => 200,
            'message' => 'Trả Thành Công',
            'data' => [
                'id_phieu_muon' => $id_phieu_muon,
                'tinh_trang' => 'Đã Trả'
            ]
        ];
        header("HTTP/1.0 200 OK");
        echo json_encode($data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Server Error',
        ];
        header("HTTP/1.0 500 Server Error");
        echo json_encode($data);
    }
}


?>
