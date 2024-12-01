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
        $cart_message = "Please log in or register to add items to the cart";
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
    <link rel="stylesheet" href="assets/bootstrap/TEST/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abel&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Albert+Sans&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anek+Gurmukhi&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bruno+Ace+SC&amp;display=swap">
    
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
            top: 16px;
            right:  25px;
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

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="57" style="background: rgb(255,255,255);">
    <nav class="navbar navbar-expand-lg fixed-top navbar-light" id="mainNav" style="font-family: Abel, sans-serif;font-size: 8px;">
        <div class="container">
            <a class="navbar-brand" href="#page-top" style="font-family: 'Bruno Ace SC', serif;">Paw pulse</a>
            <button data-bs-toggle="collapse" data-bs-target="#navbarResponsive" class="navbar-toggler navbar-toggler-right" type="button" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-align-justify"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link fs-6 fw-semibold" href="#page-top" style="font-family: Abel, sans-serif;letter-spacing: 1px;">HOME</a>
                    </li>
                    <li class="nav-item fw-lighter">
                        <a class="nav-link fw-semibold" href="#portfolio" style="font-family: Abel, sans-serif;letter-spacing: 1px;font-size: 16.4px;">SERVICES</a>
                    </li>
                    <li class="nav-item fw-lighter">
                        <a class="nav-link fw-semibold" href="#products" style="font-family: Abel, sans-serif;font-size: 16.4px;letter-spacing: 1px;">PRODUCTS</a>
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
                    <button class="btn btn-dark ms-2" data-bss-hover-animate="pulse" type="submit" style="margin-left: 7px;font-family: Abel, sans-serif;width: 69.4062px;">LOG ON</button>
                </form>
            </div>
        </div>
        <?php if (isset($_SESSION['username'])) { ?>  
         <?php } ?>
    </nav>

    <section style="height: 600px;margin-top: 0px;margin-bottom: 0px;padding-top: 0px;padding-bottom: 0px;">
        <img class="img-fluid d-md-none" src="assets/img/HEADER.jpg">
        <div data-bss-scroll-zoom="true" data-bss-scroll-zoom-speed="2" style="background-image: url(&quot;assets/img/artistic-shot-companion-dog-darkness-looking-into-light.jpg&quot;);background-position: center;background-size: cover;padding-top: 1px;padding-bottom: 1px;height: 700px;">
            <div class="text-center d-flex d-lg-flex flex-column align-items-center justify-content-md-center align-items-md-center justify-content-lg-center align-items-lg-center hero-content" style="padding-left: 19px;padding-right: 19px;padding-top: 20px;padding-bottom: 20px;">
                <h1 class="fw-bolder h1 h1-test h1-test2 h2 h1-test3 h1MD h1XS h1LG h1XL h1XXL" style="font-family: Abel, sans-serif;color: rgb(191,185,174);/*margin-right: 342px;*/border-color: rgb(228,224,215);margin-left: 470px;">Paw Pulse, Where Pets Thrive</h1>
                <p class="fw-bolder para-1 para-test1 test-para1 lett abc para-test2 para-test3 para-test4 paraXS paraMD paraLG paraXL paraXXL paraSM paraLaptop para-2 para-3 para-4 para-5 para-6 para-7 para-n para-n2 h1MD" style="font-family: Abel, sans-serif;/*padding-right: 7px;*//*margin-top: 0px;*//*margin-bottom: 0px;*//*padding-top: 15px;*//*padding-bottom: 15px;*//*margin-left: 7px;*//*margin-right: 7px;*/color: rgb(180,171,171);filter: blur(0px) brightness(200%) contrast(110%) saturate(91%);">one-stop destination for all things pet-related.&nbsp;From top-quality supplies to personalized grooming services, making Paw Pulse the heartbeat of pet care excellence.</p>
                <h2 class="auto-typeXS auto-typeSM auto-typeMD auto-typeLG auto-typeXL auto-typeXXL">Pet Care</h2>
            </div>
            <button class="btn btn-primary btnLG btnXL btnXXL mb-xl-5 mt-xl-5 mt-xxl-5 mb-xxl-5" data-bss-hover-animate="pulse" type="button" style="/*margin-left: 472px;*//*margin-top: 131px;*/width: 61px;height: 34px;border: 2px solid rgb(241,241,241);">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20" fill="none" style="font-size: 28px;margin: -4px;text-align: center;margin-top: -11px;">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 7.29289C5.68342 6.90237 6.31658 6.90237 6.70711 7.29289L10 10.5858L13.2929 7.29289C13.6834 6.90237 14.3166 6.90237 14.7071 7.29289C15.0976 7.68342 15.0976 8.31658 14.7071 8.70711L10.7071 12.7071C10.3166 13.0976 9.68342 13.0976 9.29289 12.7071L5.29289 8.70711C4.90237 8.31658 4.90237 7.68342 5.29289 7.29289Z" fill="currentColor"></path>
                </svg>
            </button>
            <a class="btn btn-link btn-circle" role="button" href="#products" style="padding-top: 302px;">
                <i class="fa fa-angle-double-down animated"></i>
            </a>
        </div>
    </section>

    <section id="products" class="my-xxl-5 mt-xl-0 mt-lg-0" style="padding-top: 180px;height: 740px;">
        <div class="container" style="padding-top: 76px;">
            <div class="row my-xl-0 py-xl-0 ms-xl-0 me-xl-0">
                <div class="col-md-6 text-center">
                    <div class="glass-container"></div>
                    <div id="b_category_1" class="parallax"></div>
                    <div id="b_category_2" class="parallax"></div>
                    <div id="b_category_3" class="parallax"></div>
                    <div id="b_category_4" class="parallax"></div>
                    <div id="b_category_5" class="parallax"></div>
                    <div id="b_category_6" class="parallax"></div>
                    <div id="b_category_7" class="parallax"></div>
                    <div id="dog" class="parallax"></div>
                </div>
                <div class="col-md-6" style="padding-left: 39px;padding-right: 39px;">


                    <h2 class="text-uppercase section-heading text-center" style="color: rgb(49,54,63);">Test Heading</h2>


                    <h3 class="text-center text-muted section-subheading" style="margin-left: 16px;margin-right: 16px;margin-top: 31px;margin-bottom: 31px;">Nesciunt adipisci repudiandae alias eos veniam optio? Repellendus vitae mollitia quis delectus ab consectetur eius eos inventore, fugiat necessitatibus aperiam earum culpa</h3>
                    <div class="col-lg-12 text-center">
                        <div class="col-lg-12 text-center">
                            <div id="success"></div>
                            <form action="index.php" method="post">
                            <button class="btn btn-primary btn-xl text-uppercase" id="sendMessageButton" type="submit">PRODUCTS</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">


                    <h2 class="text-uppercase section-heading" style="color: rgb(49,54,63);">veterinarians</h2>



                    <h3 class="text-muted section-subheading">Professionals who diagnose, treat and help prevent diseases and injuries in animals</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4 portfolio-item">
                    <a class="portfolio-link" href="#portfolioModal1" data-bs-toggle="modal">
                        <div class="portfolio-hover" style="border-radius: 0px;border-top-left-radius: 15px;border-top-right-radius: 15px;background: rgba(185,180,199,0.73);">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/doc-1.jpg" style="border-radius: 15px;">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Dr.Jhon</h4>
                        <p class="text-muted">Illustration</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 portfolio-item">
                    <a class="portfolio-link" href="#portfolioModal2" data-bs-toggle="modal">
                        <div class="portfolio-hover" style="border-radius: 15px;border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;background: rgba(185,180,199,0.73);">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/doc-2.jpg" style="border-radius: 15px;border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Dr.Connie</h4>
                        <p class="text-muted">Graphic Design</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 portfolio-item">
                    <a class="portfolio-link" href="#portfolioModal3" data-bs-toggle="modal">
                        <div class="portfolio-hover" style="border-radius: 15px;border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;background: rgba(185,180,199,0.73);">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/doc-3.jpg" style="border-radius: 15px;border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Dr.Martine</h4>
                        <p class="text-muted">Identity</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="about" style="background: #31363f;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="text-uppercase" style="color: rgb(238,238,238);">About</h2>
                    <h3 class="text section-subheading" style="color: rgba(204,210,215,0.75);">&nbsp;Learn more about our passion for pets and commitment to exceptional care at PAW PAULSE<br><br></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-group timeline">
                        <li class="list-group-item">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="assets/img/about/1.jpg">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 style="color: rgb(185,180,199);">2009-2011</h4>
                                    <h4 class="subheading" style="color: rgb(185,180,199);">Our Humble Beginnings</h4>
                                </div>
                                <div class="timeline-body">
<!--here-->
                                    <p class="text-center  section-subheading" style="color: rgba(204,210,215,0.75); font-family: Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif;" >Embark on a Journey with Beginnings Pet Shop! Your trusted destination for finding your furry soulmate and everything they need to thrive.<br><br></p>
                               
                               
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item timeline-inverted">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="assets/img/about/2.jpg">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 style="color: rgb(185,180,199);">March 2011</h4>
                                    <h4 class="subheading" style="color: rgb(185,180,199);">Shop is Born</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-center  section-subheading" style="color: rgba(204,210,215,0.75); font-family: Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif;">Where New Beginnings Start: Explore Our Pet Shop for everything your new companion needs to thrive and flourish</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="assets/img/about/3.jpg">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 style="color: rgb(185,180,199);">December 2012</h4>
                                    <h4 class="subheading" style="color: rgb(185,180,199);">Transition to Full Service</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text" style="color: rgba(204,210,215,0.75); font-family: Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif;">Shop Transit: Your Comprehensive Pet Care Solution, from essentials to luxury, all under one roof!</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item timeline-inverted">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="assets/img/about/4.jpg">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 style="color: rgb(185,180,199);">July 2014</h4>
                                    <h4 class="subheading" style="color: rgb(185,180,199);">Phase Two Expansion</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text" style="color: rgba(204,210,215,0.75); font-family: Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif;">Offering an enriched array of services, premium products, and expert care to meet all your pet's needs</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item timeline-inverted">
                            <div class="timeline-image" style="background: rgb(49,54,63);">
                                <h4 style="color: rgb(185,180,199);">Be Part<br>&nbsp;Of Our<br>&nbsp;Story!</h4>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" style="background: url(&quot;assets/img/map-image.png&quot;), rgb(49,54,63);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="text-uppercase section-heading" style="color: rgb(185,180,199);">Contact Us</h2>
                    <h3 class="text section-subheading" style="color: rgba(204,210,215,0.75);">Lorem ipsum dolor sit amet consectetur.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="contactForm" name="contactForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input class="form-control" type="text" id="name" placeholder="Your Name *" required="">
                                    <small class="form-text text-danger flex-grow-1 lead"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <input class="form-control" type="email" id="email" placeholder="Your Email *" required="">
                                    <small class="form-text text-danger lead"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <input class="form-control" type="tel" placeholder="Your Phone *" required="">
                                    <small class="form-text text-danger lead"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <textarea class="form-control" id="message" placeholder="Your Message *" required=""></textarea>
                                    <small class="form-text text-danger lead"></small>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button class="btn btn-primary btn-xl text-uppercase" id="sendMessageButton" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer style="background: #b9b4c7;">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright&nbsp;© Brand 2024</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#" style="background: rgb(185,180,199);">
                                <i class="fa fa-twitter text-white" data-bss-hover-animate="tada"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" style="background: rgb(185,180,199);">
                                <i class="fa fa-facebook" data-bss-hover-animate="tada"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" style="background: rgb(185,180,199);">
                                <i class="fa fa-linkedin" data-bss-hover-animate="tada"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li class="list-inline-item" style="color: #ffffff;">
                            <a href="#" style="color: #352f44;">Privacy Policy</a>
                        </li>
                        <li class="list-inline-item" style="color: #ffffff;">
                            <a href="#" style="color: rgb(53,47,68);">Terms of Use</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <div class="modal fade text-center portfolio-modal" role="dialog" tabindex="-1" id="portfolioModal1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="modal-body">
                                <h2 class="text-uppercase">Dr.jhone peter</h2>
                                <p class="text-muted item-intro">Lorem ipsum dolor sit amet consectetur.</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/doc-1.jpg">
                                <p>Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p>
                                <ul class="list-unstyled">
                                    <li>Date: January 2017</li>
                                    <li>Client: Threads</li>
                                    <li>Category: Illustration</li>
                                </ul>
                                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">&nbsp;Appointment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-center portfolio-modal" role="dialog" tabindex="-1" id="portfolioModal2">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="modal-body">
                                <h2 class="text-uppercase">DR.CONNIE PAGE</h2>
                                <p class="text-muted item-intro">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/doc-2.jpg">
                                <p>Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p>
                                <ul class="list-unstyled">
                                    <li>Date: January 2017</li>
                                    <li>Client: Threads</li>
                                    <li>Category: Illustration</li>
                                </ul>
                                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Appointment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-center portfolio-modal" role="dialog" tabindex="-1" id="portfolioModal3">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="modal-body">
                                <h2 class="text-uppercase">
                                    <strong>Dr.Martine meds</strong>
                                </h2>
                                <p class="text-muted item-intro">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/doc-3.jpg">
                                <p>Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p>
                                <ul class="list-unstyled">
                                    <li>Date: January 2017</li>
                                    <li>Client: Threads</li>
                                    <li>Category: Illustration</li>
                                </ul>
                                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Appointment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/baguetteBox.min.js"></script>
    <script src="assets/js/creative.js"></script>
    <script src="assets/js/scriptAutoType.js"></script>
    <script src="assets/js/scriptParallax.js"></script>
</body>

</html>