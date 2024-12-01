<?php
include 'connection.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $sql = "SELECT image FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        header("Content-type: image/jpeg"); // Adjust content type based on your image format
        echo $row['image'];
    } else {
        // Handle image not found case or provide a placeholder image
        // For example, redirect to a default image
        header("Location: assets/img/b-1.png ");
        exit;
    }
} else {
    // Handle invalid product ID case
    echo "Invalid product ID.";
}

$conn->close();
?>
