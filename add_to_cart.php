<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php?added_to_cart=failure");
    exit();
}

$product_id = $_GET['product_id'];
$username = $_SESSION['username'];

// Get user ID from the session
$sql = "SELECT id FROM users WHERE username='$username'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$user_id = $user['id'];

// Check if the product is already in the cart
$sql = "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // If the product is already in the cart, increment the quantity
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_id='$product_id'";
} else {
    // If the product is not in the cart, insert it
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', 1)";
}

if ($conn->query($sql) === TRUE) {
    header("Location: index.php?added_to_cart=success");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>