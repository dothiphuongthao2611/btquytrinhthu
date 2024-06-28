<?php
require '../connect/dbcon.php';

function error422($message) {
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    http_response_code(422);
    echo json_encode($data);
    exit();
}

function storeReader($ReaderInput) {
    global $conn;

    $name = mysqli_real_escape_string($conn, $ReaderInput['readername']);
    $lop = mysqli_real_escape_string($conn, $ReaderInput['lop']);
    $gender = mysqli_real_escape_string($conn, $ReaderInput['gender']);
    $email = mysqli_real_escape_string($conn, $ReaderInput['email']);
    $phone = isset($ReaderInput['phone']) ? trim($ReaderInput['phone']) : '';

    // Loại bỏ các ký tự không phải số khỏi số điện thoại
    $phone = preg_replace('/[^0-9]/', '', $phone);

    // Kiểm tra độ dài của số điện thoại
    if (strlen($phone) !== 10) {
        return error422('Vui long nhap so đien thoai gom đung 10 chu so');
    }

    // Kiểm tra tính hợp lệ của địa chỉ email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return error422('Please enter a valid email address');
    }

    // Chuyển đổi số điện thoại về định dạng số nguyên để lưu vào cơ sở dữ liệu
    $phone = (int) $phone;

    // Kiểm tra lại tính hợp lệ của các trường nhập liệu
    if (empty(trim($name)) || empty(trim($lop)) || empty(trim($gender)) ) {
        return error422('Vui lòng điền đầy đủ thông tin người đọc');
    }

    $query = "INSERT INTO docgia2 (readername, lop, gender, email, phone)
              VALUES ('$name', '$lop', '$gender', '$email', '$phone')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // $data = [
        //     'status' => 201,
        //     'message' => 'Reader created successfully',
        // ];
        // http_response_code(201);
        // echo json_encode($data);
        header("../view/them_dg.php");
        exit;
    } else {
        $data = [
            'status' => 500,
            'message' => 'Server Error',
        ];
        http_response_code(500);
        echo json_encode($data);
    }
}




function getReaderList() {
    global $conn;

    $query = "SELECT * FROM docgia2";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'Danh sach nguoi doc duoc truy xuat thanh cong',
            'data' => mysqli_fetch_all($result, MYSQLI_ASSOC)
        ];
        http_response_code(200);
        echo json_encode($data);
    } else {
        $data = [
            'status' => 404,
            'message' => 'Server Error',
        ];
        http_response_code(404);
        echo json_encode($data);
    }
}

function getReader($readerParams) {
    global $conn;

    if (empty($readerParams['readerId'])) {
        return error422('Vui lòng nhập ID người đọc');
    }

    $readerId = mysqli_real_escape_string($conn, $readerParams['readerId']);
    $query = "SELECT * FROM docgia2 WHERE readerId = '$readerId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = [
            'status' => 200,
            'message' => 'Thong tin nguoi doc duoc truy xuat thanh cong',
            'data' => mysqli_fetch_assoc($result)
        ];
        http_response_code(200);
        echo json_encode($data);
    } else {
        $data = [
            'status' => 404,
            'message' => 'Server Error',
        ];
        http_response_code(404);
        echo json_encode($data);
    }
}

function updateReader($readerInput, $readerParams) {
    global $conn;

    if (empty($readerParams['readerId'])) {
        return error422('Vui lòng nhập ID người đọc');
    }

    $readerId = mysqli_real_escape_string($conn, $readerParams['readerId']);
    $name = mysqli_real_escape_string($conn, $readerInput['readername']);
    $lop = mysqli_real_escape_string($conn, $readerInput['lop']);
    $gender = mysqli_real_escape_string($conn, $readerInput['gender']);
    $email = mysqli_real_escape_string($conn, $readerInput['email']);
    $phone = isset($readerInput['phone']) ? intval(trim($readerInput['phone'])) : 0;

    if (empty(trim($name)) || empty(trim($lop)) || empty(trim($gender)) || empty(trim($email)) ||  strlen((string) $phone) < 10) {
        return error422('Vui lòng điền đầy đủ và chính xác thông tin người đọc');
    }

    $query = "UPDATE docgia2
              SET readername = '$name', lop = '$lop', gender = '$gender', email = '$email', phone = '$phone'
              WHERE readerId = '$readerId'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // $data = [
        //     'status' => 201,
        //     'message' => 'update successfully',
        // ];
        // http_response_code(201);
        // echo json_encode($data);
        header("../view/them_dg.php");
        exit;
    } else {
        $data = [
            'status' => 500,
            'message' => 'Server Error',
        ];
        http_response_code(500);
        echo json_encode($data);
    }
}

function deletereader($readerParams){
    global $conn;
    if (!isset($readerParams['readerId'])) {
        return error422('readerId not found in URL');
    } elseif ($readerParams['readerId'] == null) {
        return error422('Enter the readerId');
    }
    $readerId = mysqli_real_escape_string($conn, $readerParams['readerId']);
    $query = "DELETE FROM docgia2 WHERE readerId='$readerId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'Book deleted successfully',
        ];
        header("HTTP/1.0 200 OK");
        echo json_encode($data);
    } else {
        $data = [
            'status' => 404,
            'message' => 'Book not found or could not be deleted',
        ];
        header("HTTP/1.0 404 Not found");
        echo json_encode($data);
    }
}

?>
