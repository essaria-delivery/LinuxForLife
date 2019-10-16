<?php include "connection.php"; 
session_start();
$queryz="SELECT * FROM `web` WHERE `id`=1";
$resultz=mysqli_query($conn,$queryz);
$rowz=mysqli_fetch_array($resultz, MYSQLI_ASSOC);
$logo=$rowz['logo'];

if(isset($_POST['setlocation']))
{
    extract($_POST);
    $urlencode= str_replace(",","",$selectlocation);
    $urlencode=urlencode($urlencode);
    $response=json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$urlencode."&key=AIzaSyBQ-YSVmQS8h0Pv3hs_YwLZ65ifZqZ23X0"));
    $lat=$response->results[0]->geometry->location->lat;
    $lon=$response->results[0]->geometry->location->lng;
    
    $address=explode(",",$selectlocation);
    $_SESSION['location']=array('lat'=>$lat, 'lng'=>$lon, 'address'=>$address[0]);
    header("Refresh:0");
}
?>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQ-YSVmQS8h0Pv3hs_YwLZ65ifZqZ23X0&libraries=places"></script>

<script>
    

/* script */
function initialize() {
   var latlng = new google.maps.LatLng(28.5355161,77.39102649999995);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 13
    });
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      draggable: true,
      anchorPoint: new google.maps.Point(0, -29)
   });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var geocoder = new google.maps.Geocoder();
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();   
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
  
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
       
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);          
    
        bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);
       
    });
    // this function will work on marker move event into map 
    google.maps.event.addListener(marker, 'dragend', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {        
              bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
          }
        }
        });
    });
}
function bindDataToForm(address,lat,lng){
   document.getElementById('location').value = address;
   document.getElementById('lat').value = lat;
   document.getElementById('lng').value = lng;
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<style>
    @media (max-width: 575.98px)
    {
        .location-top{
            display: block;
            margin-right: 100px;
        }
        .location-text{
            display: none;
        }
        #demo
        {
            margin-left: 0px !important;
            width:100% !important;
            margin-top: 70% !important;
            
        }
    }
    
    @media (max-width: 991.98px) and (min-width: 768px)
    {
        .location-top{
            display: block;
        }
        .location-text{
            display: none;
        }
    }
    #demo
    {
      height:320px;
    }
</style>

<div class="modal fade login-modal-main" id="bd-example-modal">
         <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-body">
                  <div class="login-modal">
                     <div class="row">
                        <div class="col-lg-6 pad-right-0">
                           <div class="login-modal-left">
                           </div>
                        </div>
                        <div class="col-lg-6 pad-left-0">
                           <button type="button" class="close close-top-right" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true"><i class="mdi mdi-closed"></i></span>
                           <span class="sr-only">Close</span>
                           </button>
                           
                              <div class="login-modal-right">
                                 <!-- Tab panes -->
                                 <div class="tab-content">
                                    <div class="tab-pane active" id="login" role="tabpanel">
                                       <h5 class="heading-design-h5">Login to your account</h5>
                                       <form action="inc/check_form.php" method="post">
                                       <fieldset class="form-group">
                                          <label>Enter Email</label>
                                          <input type="email" name="email" class="form-control" placeholder="demo@gmail.com">
                                       </fieldset>
                                       <fieldset class="form-group">
                                          <label>Enter Password</label>
                                          <input type="password" name="pass" class="form-control" placeholder="********">
                                       </fieldset>
                                       <fieldset class="form-group">
                                          <!--<button type="submit" class="btn btn-lg btn-secondary btn-block">Enter to your account</button>-->
                                          <input type="submit" name="login" value="Enter to your account" class="btn btn-lg btn-secondary btn-block">
                                       </fieldset>
                                       <div class="login-with-sites text-center">
                                          <!--<p>or Login with your social profile:</p>-->
                                          <!--<button class="btn-facebook login-icons btn-lg"><i class="mdi mdi-facebook"></i> Facebook</button>-->
                                          <!--<button class="btn-google login-icons btn-lg"><i class="mdi mdi-google"></i> Google</button>-->
                                          <!--<button class="btn-twitter login-icons btn-lg"><i class="mdi mdi-twitter"></i> Twitter</button>-->
                                       </div>
                                       <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" id="customCheck1">
                                          <label class="custom-control-label" for="customCheck1">Remember me</label>
                                       </div>
                                       </form>
                                    </div>
                                    
                                    <div class="tab-pane" id="register" role="tabpanel">
                                       <h5 class="heading-design-h5">Register Now!</h5>
                                       <form action="inc/check_form.php" method="post">
                                       <fieldset class="form-group">
                                          <label>Enter Name</label>
                                          <input type="text" name="Name" class="form-control" placeholder="Your Full Name">
                                       </fieldset>
                                       <fieldset class="form-group">
                                          <label>Enter Email</label>
                                          <input type="email" name="email" class="form-control" placeholder="Your Email ">
                                       </fieldset>
                                       <fieldset class="form-group">
                                          <label>Enter Mobile</label>
                                          <input type="number" name="mobile" class="form-control" placeholder="Your Mobile">
                                       </fieldset>
                                       <fieldset class="form-group">
                                          <label>Enter Password </label>
                                          <input type="password" name="pass" class="form-control" placeholder="Password">
                                       </fieldset>
                                       <fieldset class="form-group">
                                          <button type="submit" name="signup" value="Create Your Account" class="btn btn-lg btn-secondary btn-block">Create Your Account</button>
                                       </fieldset>
                                       <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" id="customCheck2">
                                          <label class="custom-control-label" for="customCheck2">I Agree with <a href="#">Term and Conditions</a></label>
                                       </div>
                                       </form>
                                    </div>
                                 </div>
                                 <div class="clearfix"></div>
                                 <div class="text-center login-footer-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                       <li class="nav-item">
                                          <a class="nav-link active" data-toggle="tab" href="#login" role="tab"><i class="mdi mdi-lock"></i> LOGIN</a>
                                       </li>
                                       <li class="nav-item">
                                          <a class="nav-link" data-toggle="tab" href="#register" role="tab"><i class="mdi mdi-pencil"></i> REGISTER</a>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--div class="navbar-top bg-success pt-2 pb-2">
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-12 text-center">
                  <a href="shop.php" class="mb-0 text-white">
                  20% cashback for new users | Code: <strong><span class="text-light">OGOFERS13 <span class="mdi mdi-tag-faces"></span></span> </strong>  
                  </a>
               </div>
            </div>
         </div>
      </div-->
      <nav class="navbar navbar-light navbar-expand-lg bg-dark bg-faded osahan-menu">
         <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="../uploads/web/Go-Logo_White.png" alt="logo" style="width: 45px;">
            </a>
			<!--<a class="location-top" href="#"><i class="mdi mdi-map-marker-circle" aria-hidden="true"></i> Select Location</a>-->
              <button type="button" class="location-top" data-toggle="collapse" data-target="#demo" style="background: none;border: none;">
                  <i class="mdi mdi-map-marker-circle" aria-hidden="true"></i>
                  <?php 
                  if(isset($_SESSION['location']))
                  {
                      $lable=$_SESSION['location']['address'];
                  }
                  else
                  {
                      $lable="Select Location";
                  }
                  echo "<span class='location-text'>".$lable."</span>";
                  ?>
                  
              </button>
              <div id="demo" class="collapse" style="z-index: 9;overflow-y:scroll;position: absolute;margin-top: 14.5%;margin-left: 8%;padding:8px 12px;background-color: #fff;border-radius: 3px;box-shadow: 0 2px 4px 0 rgba(0,0,0,.5);color: #333;width: 440px;">
                  <div class="margin-auto mt-4 mb-4 text-center">
                      <b>Where do you want the delivery ?</b>
                  </div>
                  <div class="margin-auto mb-4 text-center">
                      <form action="" method="post" style="width:100%">
                        <div class="input-group">
                        
                            <span class="input-group-btn categories-dropdown"></span>
                            <input class="form-control" placeholder="Search products in Your City" aria-label="Search Delivery Location" type="text" name="selectlocation" id="searchInput">
                            <div id="map" style="margin: 0px;position:absolute;z-index:999999">
                                        <div id="infowindow-content">
                                          <img src="" width="16" height="16" id="place-icon">
                                          <span id="place-name"  class="title"></span><br>
                                          <span id="place-address"></span>
                                        </div>
                            </div>
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit" name="setlocation" style="height: 100%;">
                                    <i class="mdi mdi-file-find"></i> Search
                                </button>
                            </span>
                            
                        
                        </div>
                      </form>
                  </div>
                  
                  <div class="margin-auto mt-4 mb-4 text-center row" >
                      <?php 
                      if(isset($_SESSION['location'])){
                            $lat=$_SESSION['location']['lat'];
                            $lng=$_SESSION['location']['lng'];
                      
                            $qry = "SELECT *, ( 6371 * acos( cos( radians(".$lat.") ) * cos( radians( lat ) ) * 
                            cos( radians( lon ) - radians(".$lng.") ) + sin( radians(".$lat.") ) * 
                            sin( radians( lat ) ) ) ) AS distance FROM store_login HAVING
                            distance < delivery_range ORDER BY distance";
                            $res4 = mysqli_query($conn, $qry);
                            while($data=mysqli_fetch_assoc($res4))
                            { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="owl-item" style="width: 139px;">
                                        <div class="item">
                                        <div class="category-item">
                                         <a href="shop.php?cat_id=14">
                                            <img class="img-fluid" src="<?= $base_url ?>uploads/profile/<?= $data['user_image'] ?>" alt="">
                                            <h6><?= $data['user_fullname'] ?></h6>
                                             
                                            <p>2 SUB CATE</p>
                                         </a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                
                       <?php }
                          
                      }
                      else
                      {
                          echo "Select Delivery Address";
                      }
                      ?>
                      
                  </div>
                
              </div>
			
            <button class="navbar-toggler navbar-toggler-white" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="navbar-collapse" id="navbarNavDropdown">
               <div class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto top-categories-search-main">
                  <div class="top-categories-search">
                     <div class="input-group">
                        <span class="input-group-btn categories-dropdown">
                        <!--<input type="text" name="search-area" id="searchInput"  class="form-control">-->
                           <!--<select class="form-control-select">-->
                           <!--   <option selected="selected">Your City</option>-->
                           <!--   <option value="0">New Delhi</option>-->
                           <!--   <option value="2">Bengaluru</option>-->
                           <!--   <option value="3">Hyderabad</option>-->
                           <!--   <option value="4">Kolkata</option>-->
                           <!--</select>-->
                           
                        </span>
                        <input class="form-control" placeholder="Search products in Your City" aria-label="Search products in Your City" type="text" >
                        <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button"><i class="mdi mdi-file-find"></i> Search</button>
                        </span>
                     </div>
                  </div>
               </div>
               <div class="my-2 my-lg-0">
                  <ul class="list-inline main-nav-right">
                      <?php 
                            if(isset($_SESSION['login'])){
                                $first_name=explode(" ",$_SESSION['login']['user_name']);
                      ?>
                      <li class="list-inline-item dropdown osahan-top-dropdown">
                        <a class="btn btn-theme-round dropdown-toggle dropdown-toggle-top-user" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!--<img alt="logo" src="img/user.jpg">-->
                        <strong>Hi&nbsp;</strong><?= $first_name[0] ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-list-design">
                           <a href="my-profile.html" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-account-outline"></i>  My Profile</a>
                           <a href="my-address.html" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-map-marker-circle"></i>  My Address</a>
                           <a href="wishlist.html" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-heart-outline"></i>  Wish List </a>
                           <a href="orderlist.html" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-format-list-bulleted"></i>  Order List</a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="logout.php"><i class="mdi mdi-lock"></i> Logout</a>	
                        </div>
                      </li>
                      <?php }else{ ?>
                     <li class="list-inline-item">
                        <a href="#" data-target="#bd-example-modal" data-toggle="modal" class="btn btn-link"><i class="mdi mdi-account-circle"></i> Login/Sign Up</a>
                     </li>
                     <?php } ?>
                     
                     <li class="list-inline-item cart-btn">
                        <a href="#" data-toggle="offcanvas" class="btn btn-link border-none"><i class="mdi mdi-cart"></i> My Cart <small class="cart-value">5</small></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </nav>
      <nav class="navbar navbar-expand-lg navbar-light osahan-menu-2 pad-none-mobile">
         <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarText">
               <ul class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto">
                  <li class="nav-item">
                     <a class="nav-link shop" href="index.php"><span class="mdi mdi-store"></span> Super Store</a>
                  </li>
				  <li class="nav-item">
                     <a href="index.php" class="nav-link">Home</a>
                  </li>
				  <li class="nav-item">
                     <a href="about.php" class="nav-link">About Us</a>
                  </li>
                  <!--li class="nav-item">
                     <a class="nav-link" href="shop.php">Fruits & Vegetables</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="shop.php">Grocery & Staples</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="shop.php">Home & Kitchen</a>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Pages
                     </a>
                     <div class="dropdown-menu">
                        <a class="dropdown-item" href="shop.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Shop Grid</a>
                        <a class="dropdown-item" href="single.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Single Product</a>
                        <a class="dropdown-item" href="cart.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Shopping Cart</a>
                        <a class="dropdown-item" href="checkout.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Checkout</a> 
                     </div>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     My Account
                     </a>
                     <div class="dropdown-menu">
                        <a class="dropdown-item" href="my-profile.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i>  My Profile</a>
                        <a class="dropdown-item" href="my-address.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i>  My Address</a>
                        <a class="dropdown-item" href="wishlist.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i>  Wish List </a>
                        <a class="dropdown-item" href="orderlist.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i>  Order List</a> 
                     </div>
                  </li-->
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     More Pages
                     </a>
                     <div class="dropdown-menu">
                        <a class="dropdown-item" href="about.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i>  About Us</a>
                        <a class="dropdown-item" href="contact.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i>  Contact Us</a>
                        <a class="dropdown-item" href="faq.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i>  FAQ </a>
                        <a class="dropdown-item" href="not-found.php"><i class="mdi mdi-chevron-right" aria-hidden="true"></i>  404 Error</a> 
                     </div>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="contact.php">Contact</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>