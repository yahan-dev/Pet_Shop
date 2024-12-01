<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$cart_id = $_GET['cart_id'];

$sql = "DELETE FROM cart WHERE id='$cart_id'";
if ($conn->query($sql) === TRUE) {
    header("Location: cart.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>