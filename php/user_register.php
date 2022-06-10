<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
$name = addslashes($_POST['name']);
$phn = addslashes($_POST['phone']);
$email = $_POST['email'];
$ads = $_POST['ads'];
$password = sha1($_POST['password']);
$base64image = $_POST['image'];

$sqlinsert = "INSERT INTO `tbl_users`(`users_name`, `users_phoneno`, `users_email`, `users_ads`, `users_password`) 
VALUES ('$name','$phn','$email','$ads','$password')";
if ($conn->query($sqlinsert) === TRUE) {
    $response = array('status' => 'success', 'data' => null);
    $filename = mysqli_insert_id($conn);
    $decoded_string = base64_decode($base64image);
    $path = '../assets/users/' . $filename . '.jpg';
    $is_written = file_put_contents($path, $decoded_string);
    sendJsonResponse($response);
} else {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
?>