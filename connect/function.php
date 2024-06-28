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

function storeBook($BookInput) {
    global $conn;
    $name = mysqli_real_escape_string($conn, $BookInput['bookName']);
    $language = mysqli_real_escape_string($conn, $BookInput['language']);
    $category = mysqli_real_escape_string($conn, $BookInput['category']);
    $publisher = mysqli_real_escape_string($conn, $BookInput['publisher']);
    $year = mysqli_real_escape_string($conn, $BookInput['year']);
    $price = (int) $BookInput['price'];
    $quantity = (int) $BookInput['quantity'];

    if (empty(trim($name))) {
        return error422('Enter book name');
    } elseif (empty(trim($language))) {
        return error422('Enter language');
    } elseif (empty(trim($category))) {
        return error422('Enter category');
    } elseif (empty(trim($publisher))) {
        return error422('Enter publisher');
    } elseif (empty(trim($year))) {
        return error422('Enter year');
    } elseif ($price <= 0) {
        return error422('Enter valid price');
    } elseif ($quantity <= 0) {
        return error422('Enter valid quantity');
    } else {
        // Lưu thông tin sách vào cơ sở dữ liệu
        $query = "INSERT INTO themsach (bookName, language, price, quantity, category, publisher, year) VALUES ('$name', '$language',$price, $quantity, '$category',  '$publisher', '$year')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $data=[
                'status' => 201,
                'message' => 'Book created successfully',
            ];
            header("HTTP/1.0 201 Created");

            echo json_encode($data);
            // header("Location: ../thu.php");
            //         exit();
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




function getBookList(){
    global $conn;
    $requesstMethod = $_SERVER["REQUEST_METHOD"];

    $query = "SELECT * FROM themsach";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        if(mysqli_num_rows($query_run) > 0){
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => $requesstMethod . ' Booklist successfully',
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


function getBook($bookParams){
    global $conn;
    if ($bookParams['bookID'] == null) {
        return error422('Enter your book ID');
    }

    $bookId = mysqli_real_escape_string($conn, $bookParams['bookID']);
    $query = "SELECT * FROM themsach WHERE bookID=? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $bookId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_assoc($result);
            $data = [
                'status' => 200,
                'message' => 'Book Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No book found',
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

function updateBook($bookInput, $bookParams) {
    global $conn;

    // Check if bookID exists in $bookParams
    if (!isset($bookParams['bookID'])) {
        return error422('BookId not found in URL');
    } elseif (empty($bookParams['bookID'])) {
        return error422('Enter the BookId');
    }

    // Sanitize bookID to prevent SQL injection
    $bookID = mysqli_real_escape_string($conn, $bookParams['bookID']);

    // Sanitize and validate input fields
    $name = mysqli_real_escape_string($conn, $bookInput['bookName']);
    $language = mysqli_real_escape_string($conn, $bookInput['language']);
    $category = mysqli_real_escape_string($conn, $bookInput['category']);
    $publisher = mysqli_real_escape_string($conn, $bookInput['publisher']);
    $year = mysqli_real_escape_string($conn, $bookInput['year']);
    $price = (int) $bookInput['price'];
    $quantity = (int) $bookInput['quantity'];

    // Check for required input fields
    if (empty(trim($name))) {
        return error422('Enter book name');
    } elseif (empty(trim($language))) {
        return error422('Enter language');
    } elseif (empty(trim($category))) {
        return error422('Enter category');
    } elseif (empty(trim($publisher))) {
        return error422('Enter publisher');
    } elseif (empty(trim($year))) {
        return error422('Enter year');
    } elseif ($price <= 0) {
        return error422('Enter valid price');
    } elseif ($quantity <= 0) {
        return error422('Enter valid quantity');
    } else {
        // Execute SQL query to update book information
        $query = "UPDATE themsach
                  SET bookName='$name',
                      language='$language',
                      category='$category',
                      publisher='$publisher',
                      year='$year',
                      price=$price,
                      quantity=$quantity
                  WHERE bookID='$bookID'";

        $result = mysqli_query($conn, $query);

        // Check query execution result
        if ($result) {
            //Return success message
            $data = [
                'status' => 201,
                'message' => 'Book Updated successfully',
            ];
            header("HTTP/1.0 201 Updated");
            echo json_encode($data);
            // header("Location: ../thu.php");
            //         exit();
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


function deletebook($bookParams){
    global $conn;
    if (!isset($bookParams['bookID'])) {
        return error422('BookId not found in URL');
    } elseif ($bookParams['bookID'] == null) {
        return error422('Enter the BookId');
    }
    $bookID = mysqli_real_escape_string($conn, $bookParams['bookID']);
    $query = "DELETE FROM themsach WHERE bookID='$bookID' LIMIT 1";
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
