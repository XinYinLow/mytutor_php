<?php
$servername = "localhost";
$username = "moneymon_281279";
$password = "$9(,yi0ky[Gv";
$dbname = "moneymon_281279_mytutor_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>