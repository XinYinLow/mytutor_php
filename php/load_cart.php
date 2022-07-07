<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
$email = $_POST['email'];
$sqlloadcart = "SELECT tbl_carts.cart_id, tbl_carts.subject_id, tbl_carts.cart_qty, tbl_subjects.subject_name, tbl_subjects.subject_price FROM tbl_carts INNER JOIN tbl_subjects ON tbl_carts.subject_id = tbl_subjects.subject_id WHERE tbl_carts.users_email = '$email' AND tbl_carts.cart_status IS NULL";
$result = $conn->query($sqlloadcart);
$number_of_result = $result->num_rows;
if ($result->num_rows > 0) {
    //do something
    $total_payable = 0;
    $carts["cart"] = array();
    while ($rows = $result->fetch_assoc()) {
        
        $slist = array();
        $slist['cart_id'] = $rows['cart_id'];
        $slist['subject_name'] = $rows['subject_name'];
        $subprice = $rows['subject_price'];
        $slist['price'] = number_format((float)$subprice, 2, '.', '');
        $slist['cart_qty'] = $rows['cart_qty'];
        $slist['subject_id'] = $rows['subject_id'];
        $price = $rows['cart_qty'] * $subprice;
        $total_payable = $total_payable + $price;
        $slist['pricetotal'] = number_format((float)$price, 2, '.', ''); 
        array_push($carts["cart"],$slist);
    }
    $response = array('status' => 'success', 'data' => $carts, 'total' => $total_payable);
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