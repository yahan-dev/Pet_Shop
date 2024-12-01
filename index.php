<?php
session_start();
include 'connection.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$cart_message = "";
$show_modal = false;
$cart_not_empty = false;

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // Get user ID from the session
    $sql = "SELECT id FROM users WHERE username='$username'";
    $user_result = $conn->query($sql);
    
    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $user_id = $user['id'];

        // Check if the cart is not empty
        $sql = "SELECT COUNT(*) as cart_count FROM cart WHERE user_id='$user_id'";
        $cart_result = $conn->query($sql);
        
        if ($cart_result->num_rows > 0) {
            $cart_count = $cart_result->fetch_assoc();
            $cart_not_empty = $cart_count['cart_count'] > 0;
        }
    }
}

if (isset($_GET['added_to_cart'])) {
    if ($_GET['added_to_cart'] == 'success') {
        $cart_message = "Item added to cart successfully";
    } else {
        $cart_message ="<p>You need to be logged in to view this page. Please <a href='form/log_reg.php'>log in</a> or <a href='form/log_reg.php'>register</a> to become a user and purchase a product.</p>";

    }
    $show_modal = true;
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Brand</title>
    
    <link rel="stylesheet" href="styles.css">
    
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abel&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Albert+Sans&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bruno+Ace+SC&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/baguetteBox.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     

    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/bs-theme-overrides.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/stylesParallax.css">
    <link rel="stylesheet" href="assets/css/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/query.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    <style>
        .cart-link {
            position: relative;
            display: inline-block;
        }
        .red-dot {
            position: absolute;
            top:  6px;
            right: 9px;
            height: 10px;
            width: 10px;
            background-color: red;
            border-radius: 50%;
        }
    </style>
     <script>
        // Check if cart is not empty and show red dot in cart icon
        document.addEventListener('DOMContentLoaded', function() {
            var cartCount = <?php echo !empty($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>;
            if (cartCount > 0) {
                document.querySelector('.cart-dot').style.display = 'block';
            }
        });
    </script>
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="57"  style="background-color: black;">
<<nav class="navbar navbar-expand-lg fixed-top navbar-light" id="mainNav" style="font-family: Abel, sans-serif;font-size: 8px;">
        <div class="container">
            <a class="navbar-brand" href="#page-top" style="font-family: 'Bruno Ace SC', serif; font-size: 18px;">Paw pulse</a>
            <button data-bs-toggle="collapse" data-bs-target="#navbarResponsive" class="navbar-toggler navbar-toggler-right" type="button" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-align-justify"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link fs-6 fw-semibold" href="main.php" style="font-family: Abel, sans-serif;letter-spacing: 1px;">HOME</a>
                    </li>
                    <li class="nav-item fw-lighter">
                        <a class="nav-link fw-semibold" href="#services" style="font-family: Abel, sans-serif;letter-spacing: 1px;font-size: 16.4px;">SERVICES</a>
                    </li>
                    <li class="nav-item fw-lighter">
                        <a class="nav-link fw-semibold" href="index.php" style="font-family: Abel, sans-serif;font-size: 16.4px;letter-spacing: 1px;">PRODUCTS</a>
                    </li>
                    <li class="nav-item fw-lighter">
                        <a class="nav-link fw-semibold" href="#contact" style="font-family: Abel, sans-serif;font-size: 16.4px;letter-spacing: 1px;">CONTACT US</a>
                    </li>

                   <li class="nav-item">
                        <div class="cart-container" data-bss-hover-animate="tada">
                        <?php if (isset($_SESSION['username'])) { ?>
                            <a class="nav-link fw-normal cart-link" data-bss-hover-animate="tada" href="cart.php" style="font-family: Abel, sans-serif;font-size: 15.4px;line-height: 21.1px;padding-left: 0px;padding-right: 0px;margin-top: -2px;margin-bottom: -2px; color:#b9b4c7;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-cart-fill fs-4" style="font-size: 25px;transform: translate(14px);padding-left: 0px;padding-right: 0px;margin-right: 27px;">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"></path>
                                </svg>
                                <?php if ($cart_not_empty) { ?>
                                 <span class="red-dot"></span>
                                 <?php } ?>
                            </a>
                            <?php } ?>
                        </div>
                    </li>
                </ul>
                <form action="form/log_reg.php" method="get">
                    <button class="btn btn-dark ms-2" data-bss-hover-animate="pulse" type="submit" style="margin-left: 7px; margin-top: 15px; font-family: Abel, sans-serif;width: 75px; border-radius: 20px;">LOG ON</button>
                </form>
            </div>
        </div>
        <?php if (isset($_SESSION['username'])) { ?>  
         <?php } ?>
    </nav>
<br>
<br>
<br>
<br>
<br>
<br>   
<div class="demo">
        <div class="container">
            <div class="row">
                <?php while($row = $result->fetch_assoc()) { ?>
                    <div class="col-md-3 col-sm-6" style="margin-top: 15px;">
                        <div class="pricingTable">
                            <div class="pricingTable-header">
                                <!-- You can customize the pricing header as needed -->
                                <div class="price-value">$<?php echo $row['price']; ?> <span class="month">per month</span></div>
                            </div>
                            <h3 class="heading"><?php echo $row['name']; ?></h3>
                            <div class="pricing-content">
                                <!-- Display product image dynamically -->
                                <img src="show_image.php?product_id=<?php echo $row['id']; ?>" alt="<?php echo $row['name']; ?>" style="width: 150px; height: 150px;">
                            </div>
                            <div style="padding: 5px 15px 15px 15px; text-align: center;">
                                <span ><?php echo $row['description']; ?></span>
                            </div>
                            <div class="pricingTable-signup" style="margin-top: 50px;">
                                <!-- Form to add product to cart -->
                                <a href="add_to_cart.php?product_id=<?php echo $row['id']; ?>">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                <?php }; ?>
            </div>
        </div>
    </div>
        

<!-- Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Cart Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $cart_message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php if ($show_modal) { ?>
    <script>
        $(document).ready(function() {
            $('#cartModal').modal('show');
        });
    </script>
    <?php } ?>
    <a href="logout.php">logout</a> |

  
    <a href="cart.php">cart</a>

   
    
    
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/baguetteBox.min.js"></script>
    <script src="assets/js/creative.js"></script>
    <script src="assets/js/scriptAutoType.js"></script>
    <script src="assets/js/scriptParallax.js"></script>
</body>

</html>