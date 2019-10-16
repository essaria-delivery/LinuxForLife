<?php include "inc/connection.php"; 
$queryy="SELECT * FROM `web` WHERE `id`=1";
$resulty=mysqli_query($conn,$queryy);
$rowy=mysqli_fetch_array($resulty, MYSQLI_ASSOC);
$title=$rowy['title'];
$favicon=$rowy['favicon']; //../uploads/web/<?= $favicon ?>
?>

<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Askbootstrap">
      <meta name="author" content="Askbootstrap">
      <title><?= $title ?></title>
      <!-- Favicon Icon -->
      <link rel="icon" type="image/png" href="../uploads/web/<?= $favicon ?>">
      <!-- Bootstrap core CSS -->
      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Material Design Icons -->
      <link href="vendor/icons/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" />
      <!-- Select2 CSS -->
      <link href="vendor/select2/css/select2-bootstrap.css" />
      <link href="vendor/select2/css/select2.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="css/osahan.min.css" rel="stylesheet">
      <!-- Owl Carousel -->
      <link rel="stylesheet" href="vendor/owl-carousel/owl.carousel.css">
      <link rel="stylesheet" href="vendor/owl-carousel/owl.theme.css">
   </head>
   <body>
      <?php include "inc/header.php"; ?>
      <!-- Inner Header -->
      <section class="section-padding bg-dark inner-header">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h1 class="mt-0 mb-3 text-white">About Us</h1>
                  <div class="breadcrumbs">
                     <p class="mb-0 text-white"><a class="text-white" href="#">Home</a>  /  <span class="text-success">About Us</span></p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section class="section-padding bg-white" style="text-align:center">
      <?php  
        $result=mysqli_query($conn, "SELECT * FROM `pageapp` WHERE id=2") or die("SELECT * FROM `pageapp` WHERE id=2"."<br/><br/>".mysql_error());
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo $row['pg_descri'];
      ?>
      </section>
      <!-- End Inner Header -->
      <!-- About >
      <section class="section-padding bg-white">
         <div class="container">
            <div class="row">
               <div class="pl-4 col-lg-5 col-md-5 pr-4">
                  <img class="rounded img-fluid" src="img/about.jpg" alt="Card image cap">
               </div>
               <div class="col-lg-6 col-md-6 pl-5 pr-5">
                  <h2 class="mt-5 mb-5 text-secondary">Save more with GO! We give you the lowest prices on all your grocery needs.</h2>
                  <h5 class="mt-2">Our Vision</h5>
                  <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here,</p>
                  <h5 class="mt-4">Our Goal</h5>
                  <p>When looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, Lorem Ipsum has been the industry's standard dummy text ever since.</p>
               </div>
            </div>
         </div>
      </section>
      <!-- End About -->
      <!-- What We Provide>
      <section class="section-padding">
         <div class="section-title text-center mb-5">
            <h2>What We Provide?</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-lg-4 col-md-4">
                  <div class="mt-4 mb-4"><i class="text-success mdi mdi-shopping mdi-48px"></i></div>
                  <h5 class="mt-3 mb-3 text-secondary">Best Prices & Offers</h5>
                  <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
               </div>
               <div class="col-lg-4 col-md-4">
                  <div class="mt-4 mb-4"><i class="text-success mdi mdi-earth mdi-48px"></i></div>
                  <h5 class="mb-3 text-secondary">Wide Assortment</h5>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text eve.</p>
               </div>
               <div class="col-lg-4 col-md-4">
                  <div class="mt-4 mb-4"><i class="text-success mdi mdi-refresh mdi-48px"></i></div>
                  <h5 class="mt-3 mb-3 text-secondary">Easy Returns</h5>
                  <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using.</p>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-4 col-md-4">
                  <div class="mt-4 mb-4"><i class="text-success mdi mdi-truck-fast mdi-48px"></i></div>
                  <h5 class="mb-3 text-secondary">Free & Next Day Delivery</h5>
                  <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC.</p>
               </div>
               <div class="col-lg-4 col-md-4">
                  <div class="mt-4 mb-4"><i class="text-success mdi mdi-basket mdi-48px"></i></div>
                  <h5 class="mt-3 mb-3 text-secondary">100% Satisfaction Guarantee</h5>
                  <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
               </div>
               <div class="col-lg-4 col-md-4">
                  <div class="mt-4 mb-4"><i class="text-success mdi mdi mdi-tag-heart mdi-48px"></i></div>
                  <h5 class="mt-3 mb-3 text-secondary">Great Daily Deals Discount</h5>
                  <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using.</p>
               </div>
            </div>
         </div>
      </section>
      <!-- End What We Provide -->
      <!-- Our Team >
      <section class="section-padding bg-white">
         <div class="section-title text-center mb-5">
            <h2>Our Team</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-lg-4 col-md-4">
                  <div class="team-card text-center">
                     <img class="img-fluid mb-4" src="img/user/1.jpg" alt="">
                     <p class="mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.</p>
                     <h6 class="mb-0 text-success">- Stave Martin</h6>
                     <small>Manager</small>
                  </div>
               </div>
               <div class="col-lg-4 col-md-4">
                  <div class="team-card text-center">
                     <img class="img-fluid mb-4" src="img/user/2.jpg" alt="">
                     <p class="mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.</p>
                     <h6 class="mb-0 text-success">- Mark Smith</h6>
                     <small>Designer</small>
                  </div>
               </div>
               <div class="col-lg-4 col-md-4">
                  <div class="team-card text-center">
                     <img class="img-fluid mb-4" src="img/user/3.jpg" alt="">
                     <p class="mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.</p>
                     <h6 class="mb-0 text-success">- Ryan Printz</h6>
                     <small>Marketing</small>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- End Our Team -->
      <!-- Footer -->
      
      <?php include "inc/footer.php"; ?>
      
      <div class="cart-sidebar">
         <div class="cart-sidebar-header">
            <h5>
               My Cart <span class="text-success">(5 item)</span> <a data-toggle="offcanvas" class="float-right" href="#"><i class="mdi mdi-close"></i>
               </a>
            </h5>
         </div>
         <div class="cart-sidebar-body">
            <div class="cart-list-product">
               <a class="float-right remove-cart" href="#"><i class="mdi mdi-close"></i></a>
               <img class="img-fluid" src="img/item/11.jpg" alt="">
               <span class="badge badge-success">50% OFF</span>
               <h5><a href="#">Product Title Here</a></h5>
               <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
               <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i> <span class="regular-price">$800.99</span></p>
            </div>
            <div class="cart-list-product">
               <a class="float-right remove-cart" href="#"><i class="mdi mdi-close"></i></a>
               <img class="img-fluid" src="img/item/7.jpg" alt="">
               <span class="badge badge-success">50% OFF</span>
               <h5><a href="#">Product Title Here</a></h5>
               <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
               <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i> <span class="regular-price">$800.99</span></p>
            </div>
            <div class="cart-list-product">
               <a class="float-right remove-cart" href="#"><i class="mdi mdi-close"></i></a>
               <img class="img-fluid" src="img/item/9.jpg" alt="">
               <span class="badge badge-success">50% OFF</span>
               <h5><a href="#">Product Title Here</a></h5>
               <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
               <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i> <span class="regular-price">$800.99</span></p>
            </div>
            <div class="cart-list-product">
               <a class="float-right remove-cart" href="#"><i class="mdi mdi-close"></i></a>
               <img class="img-fluid" src="img/item/1.jpg" alt="">
               <span class="badge badge-success">50% OFF</span>
               <h5><a href="#">Product Title Here</a></h5>
               <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
               <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i> <span class="regular-price">$800.99</span></p>
            </div>
            <div class="cart-list-product">
               <a class="float-right remove-cart" href="#"><i class="mdi mdi-close"></i></a>
               <img class="img-fluid" src="img/item/2.jpg" alt="">
               <span class="badge badge-success">50% OFF</span>
               <h5><a href="#">Product Title Here</a></h5>
               <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
               <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i> <span class="regular-price">$800.99</span></p>
            </div>
         </div>
         <div class="cart-sidebar-footer">
            <div class="cart-store-details">
               <p>Sub Total <strong class="float-right">$900.69</strong></p>
               <p>Delivery Charges <strong class="float-right text-danger">+ $29.69</strong></p>
               <h6>Your total savings <strong class="float-right text-danger">$55 (42.31%)</strong></h6>
            </div>
            <a href="checkout.html"><button class="btn btn-secondary btn-lg btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span class="float-right"><strong>$1200.69</strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
         </div>
      </div>
      <!-- Bootstrap core JavaScript -->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- select2 Js -->
      <script src="vendor/select2/js/select2.min.js"></script>
      <!-- Owl Carousel -->
      <script src="vendor/owl-carousel/owl.carousel.js"></script>
      <!-- Custom -->
      <script src="js/custom.min.js"></script>
	  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120909275-1"></script>
	  <script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-120909275-1');
	  </script>
   </body>

</html>

