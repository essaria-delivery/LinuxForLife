<?php include "inc/connection.php"; 
$queryy="SELECT * FROM `web` WHERE `id`=1";
$resulty=mysqli_query($conn,$queryy);
$rowy=mysqli_fetch_array($resulty, MYSQLI_ASSOC);
$title=$rowy['title'];
$favicon=$rowy['favicon']; //../uploads/web/
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
    <?php include "inc/header.php" ?>
      <section class="account-page section-padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-9 mx-auto">
                  <div class="row no-gutters">
                     <div class="col-md-4">
                        <div class="card account-left">
                           <div class="user-profile-header">
                              <img alt="logo" src="img/user/1.jpg">
                              <h5 class="mb-1 text-secondary"><strong>Hi </strong> OSAHAN</h5>
                              <p> +91 8568079956</p>
                           </div>
                           <div class="list-group">
                              <a href="my-profile.php" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-account-outline"></i>  My Profile</a>
                              <a href="my-address.php" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-map-marker-circle"></i>  My Address</a>
                              <a href="wishlist.php" class="list-group-item list-group-item-action active"><i aria-hidden="true" class="mdi mdi-heart-outline"></i>  Wish List </a>
                              <a href="orderlist.php" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-format-list-bulleted"></i>  Order List</a> 
                              <a href="#" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-lock"></i>  Logout</a> 
                           </div>
                        </div>
                     </div>
                     <div class="col-md-8">
                        <div class="card card-body account-right">
                           <div class="widget">
                              <div class="section-header">
                                 <h5 class="heading-design-h5">
                                    Wishlist
                                 </h5>
                              </div>
                              <div class="row no-gutters">
                                 <div class="col-md-6">
                                    <div class="product">
                                       <a href="#">
                                          <div class="product-header">
                                             <span class="badge badge-success">50% OFF</span>
                                             <img alt="" src="img/item/1.jpg" class="img-fluid">
                                             <span class="veg text-success mdi mdi-circle"></span>
                                          </div>
                                          <div class="product-body">
                                             <h5>Product Title Here</h5>
                                             <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                                          </div>
                                          <div class="product-footer">
                                             <button class="btn btn-secondary btn-sm float-right" type="button"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                                             <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="product">
                                       <a href="#">
                                          <div class="product-header">
                                             <span class="badge badge-success">50% OFF</span>
                                             <img alt="" src="img/item/2.jpg" class="img-fluid">
                                             <span class="veg text-success mdi mdi-circle"></span>
                                          </div>
                                          <div class="product-body">
                                             <h5>Product Title Here</h5>
                                             <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                                          </div>
                                          <div class="product-footer">
                                             <button class="btn btn-secondary btn-sm float-right" type="button"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                                             <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              <div class="row no-gutters">
                                 <div class="col-md-6">
                                    <div class="product">
                                       <a href="#">
                                          <div class="product-header">
                                             <span class="badge badge-success">50% OFF</span>
                                             <img alt="" src="img/item/9.jpg" class="img-fluid">
                                             <span class="veg text-success mdi mdi-circle"></span>
                                          </div>
                                          <div class="product-body">
                                             <h5>Product Title Here</h5>
                                             <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                                          </div>
                                          <div class="product-footer">
                                             <button class="btn btn-secondary btn-sm float-right" type="button"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                                             <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="product">
                                       <a href="#">
                                          <div class="product-header">
                                             <span class="badge badge-success">50% OFF</span>
                                             <img alt="" src="img/item/5.jpg" class="img-fluid">
                                             <span class="veg text-success mdi mdi-circle"></span>
                                          </div>
                                          <div class="product-body">
                                             <h5>Product Title Here</h5>
                                             <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                                          </div>
                                          <div class="product-footer">
                                             <button class="btn btn-secondary btn-sm float-right" type="button"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                                             <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
							  <nav>
								 <ul class="pagination justify-content-center mt-4">
									<li class="page-item disabled">
									   <span class="page-link">Previous</span>
									</li>
									<li class="page-item"><a href="#" class="page-link">1</a></li>
									<li class="page-item active">
									   <span class="page-link">
									   2
									   <span class="sr-only">(current)</span>
									   </span>
									</li>
									<li class="page-item"><a href="#" class="page-link">3</a></li>
									<li class="page-item">
									   <a href="#" class="page-link">Next</a>
									</li>
								 </ul>
							  </nav>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section class="section-padding bg-white border-top">
         <div class="container">
            <div class="row">
               <div class="col-lg-4 col-sm-6">
                  <div class="feature-box">
                     <i class="mdi mdi-truck-fast"></i>
                     <h6>Free & Next Day Delivery</h6>
                     <p>Lorem ipsum dolor sit amet, cons...</p>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6">
                  <div class="feature-box">
                     <i class="mdi mdi-basket"></i>
                     <h6>100% Satisfaction Guarantee</h6>
                     <p>Rorem Ipsum Dolor sit amet, cons...</p>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6">
                  <div class="feature-box">
                     <i class="mdi mdi-tag-heart"></i>
                     <h6>Great Daily Deals Discount</h6>
                     <p>Sorem Ipsum Dolor sit amet, Cons...</p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Footer -->
      <?php include "inc/footer.php" ?>
      <!-- End Copyright -->
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
            <a href="checkout.php"><button class="btn btn-secondary btn-lg btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span class="float-right"><strong>$1200.69</strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
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

