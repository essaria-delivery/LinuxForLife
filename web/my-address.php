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
      <!--nav class="navbar navbar-light navbar-expand-lg bg-dark bg-faded osahan-menu">
         <div class="container-fluid">
            <a class="navbar-brand" href="index-2.php"> <img src="img/logo.png" alt="logo"> </a>
			<a class="location-top" href="#"><i class="mdi mdi-map-marker-circle" aria-hidden="true"></i> New York</a>
            <button class="navbar-toggler navbar-toggler-white" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse" id="navbarNavDropdown">
               <div class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto top-categories-search-main">
                  <div class="top-categories-search">
                     <div class="input-group">
                        <span class="input-group-btn categories-dropdown">
                           <select class="form-control-select">
                              <option selected="selected">Your City</option>
                              <option value="0">New Delhi</option>
                              <option value="2">Bengaluru</option>
                              <option value="3">Hyderabad</option>
                              <option value="4">Kolkata</option>
                           </select>
                        </span>
                        <input class="form-control" placeholder="Search products in Your City" aria-label="Search products in Your City" type="text">
                        <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button"><i class="mdi mdi-file-find"></i> Search</button>
                        </span>
                     </div>
                  </div>
               </div>
               <div class="my-2 my-lg-0">
                  <ul class="list-inline main-nav-right">
                     <li class="list-inline-item dropdown osahan-top-dropdown">
                        <a class="btn btn-theme-round dropdown-toggle dropdown-toggle-top-user" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img alt="logo" src="img/user.jpg"><strong>Hi</strong> Osahan
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-list-design">
                           <a href="my-profile.php" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-account-outline"></i>  My Profile</a>
                           <a href="my-address.php" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-map-marker-circle"></i>  My Address</a>
                           <a href="wishlist.php" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-heart-outline"></i>  Wish List </a>
                           <a href="orderlist.php" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-format-list-bulleted"></i>  Order List</a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#"><i class="mdi mdi-lock"></i> Logout</a>	
                        </div>
                     </li>
                     <li class="list-inline-item cart-btn">
                        <a href="#" data-toggle="offcanvas" class="btn btn-link border-none"><i class="mdi mdi-cart"></i> My Cart <small class="cart-value">5</small></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </nav>
      <nav class="navbar navbar-expand-lg navbar-light osahan-menu-2 pad-none-mobile mb-0">
         <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarText">
               <ul class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto">
                  <li class="nav-item">
                     <a class="nav-link shop" href="index-2.php"><span class="mdi mdi-store"></span> Super Store</a>
                  </li>
				  <li class="nav-item">
                     <a href="index-2.php" class="nav-link">Home</a>
                  </li>
				  <li class="nav-item">
                     <a href="about.php" class="nav-link">About Us</a>
                  </li>
                  <li class="nav-item">
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
                  </li>
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
      </nav-->
      <?php include "inc/header.php" ?>
      <section class="account-page section-padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-9 mx-auto">
                  <div class="row no-gutters">
                     <div class="col-md-4">
                        <div class="card account-left">
                           <div class="user-profile-header">
                              <img alt="logo" src="img/user.jpg">
                              <h5 class="mb-1 text-secondary"><strong>Hi </strong> OSAHAN</h5>
                              <p> +91 8568079956</p>
                           </div>
                           <div class="list-group">
                              <a href="my-profile.php" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-account-outline"></i>  My Profile</a>
                              <a href="my-address.php" class="list-group-item list-group-item-action active"><i aria-hidden="true" class="mdi mdi-map-marker-circle"></i>  My Address</a>
                              <a href="wishlist.php" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-heart-outline"></i>  Wish List </a>
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
                                    Contact Address
                                 </h5>
                              </div>
                              <form>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="form-group">
                                          <label class="control-label">Company <span class="required">*</span></label>
                                          <input class="form-control border-form-control" value="Osahan Company Ltd." placeholder="" type="text">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label class="control-label">Country <span class="required">*</span></label>
                                          <select  class="select2 form-control border-form-control">
                                             <option value="">Select Country</option>
                                             <option value="AF">Afghanistan</option>
                                             <option value="AX">Åland Islands</option>
                                             <option value="AL">Albania</option>
                                             <option value="DZ">Algeria</option>
                                             <option value="AS">American Samoa</option>
                                             <option value="AD">Andorra</option>
                                             <option value="AO">Angola</option>
                                             <option value="AI">Anguilla</option>
                                             <option value="AQ">Antarctica</option>
                                             <option value="AG">Antigua and Barbuda</option>
                                             <option value="AR">Argentina</option>
                                             <option value="AM">Armenia</option>
                                             <option value="AW">Aruba</option>
                                             <option value="AU">Australia</option>
                                             <option value="AT">Austria</option>
                                             <option value="AZ">Azerbaijan</option>
                                             <option value="BS">Bahamas</option>
                                             <option value="BH">Bahrain</option>
                                             <option value="BD">Bangladesh</option>
                                             <option value="BB">Barbados</option>
                                             <option value="BY">Belarus</option>
                                             <option value="BE">Belgium</option>
                                             <option value="BZ">Belize</option>
                                             <option value="BJ">Benin</option>
                                             <option value="BM">Bermuda</option>
                                             <option value="BT">Bhutan</option>
                                             <option value="BO">Bolivia, Plurinational State of</option>
                                             <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                             <option value="BA">Bosnia and Herzegovina</option>
                                             <option value="BW">Botswana</option>
                                             <option value="BV">Bouvet Island</option>
                                             <option value="BR">Brazil</option>
                                             <option value="IO">British Indian Ocean Territory</option>
                                             <option value="BN">Brunei Darussalam</option>
                                             <option value="BG">Bulgaria</option>
                                             <option value="BF">Burkina Faso</option>
                                             <option value="BI">Burundi</option>
                                             <option value="KH">Cambodia</option>
                                             <option value="CM">Cameroon</option>
                                             <option value="CA">Canada</option>
                                             <option value="CV">Cape Verde</option>
                                             <option value="KY">Cayman Islands</option>
                                             <option value="CF">Central African Republic</option>
                                             <option value="TD">Chad</option>
                                             <option value="CL">Chile</option>
                                             <option value="CN">China</option>
                                             <option value="CX">Christmas Island</option>
                                             <option value="CC">Cocos (Keeling) Islands</option>
                                             <option value="CO">Colombia</option>
                                             <option value="KM">Comoros</option>
                                             <option value="CG">Congo</option>
                                             <option value="CD">Congo, the Democratic Republic of the</option>
                                             <option value="CK">Cook Islands</option>
                                             <option value="CR">Costa Rica</option>
                                             <option value="CI">Côte d'Ivoire</option>
                                             <option value="HR">Croatia</option>
                                             <option value="CU">Cuba</option>
                                             <option value="CW">Curaçao</option>
                                             <option value="CY">Cyprus</option>
                                             <option value="CZ">Czech Republic</option>
                                             <option value="DK">Denmark</option>
                                             <option value="DJ">Djibouti</option>
                                             <option value="DM">Dominica</option>
                                             <option value="DO">Dominican Republic</option>
                                             <option value="EC">Ecuador</option>
                                             <option value="EG">Egypt</option>
                                             <option value="SV">El Salvador</option>
                                             <option value="GQ">Equatorial Guinea</option>
                                             <option value="ER">Eritrea</option>
                                             <option value="EE">Estonia</option>
                                             <option value="ET">Ethiopia</option>
                                             <option value="FK">Falkland Islands (Malvinas)</option>
                                             <option value="FO">Faroe Islands</option>
                                             <option value="FJ">Fiji</option>
                                             <option value="FI">Finland</option>
                                             <option value="FR">France</option>
                                             <option value="GF">French Guiana</option>
                                             <option value="PF">French Polynesia</option>
                                             <option value="TF">French Southern Territories</option>
                                             <option value="GA">Gabon</option>
                                             <option value="GM">Gambia</option>
                                             <option value="GE">Georgia</option>
                                             <option value="DE">Germany</option>
                                             <option value="GH">Ghana</option>
                                             <option value="GI">Gibraltar</option>
                                             <option value="GR">Greece</option>
                                             <option value="GL">Greenland</option>
                                             <option value="GD">Grenada</option>
                                             <option value="GP">Guadeloupe</option>
                                             <option value="GU">Guam</option>
                                             <option value="GT">Guatemala</option>
                                             <option value="GG">Guernsey</option>
                                             <option value="GN">Guinea</option>
                                             <option value="GW">Guinea-Bissau</option>
                                             <option value="GY">Guyana</option>
                                             <option value="HT">Haiti</option>
                                             <option value="HM">Heard Island and McDonald Islands</option>
                                             <option value="VA">Holy See (Vatican City State)</option>
                                             <option value="HN">Honduras</option>
                                             <option value="HK">Hong Kong</option>
                                             <option value="HU">Hungary</option>
                                             <option value="IS">Iceland</option>
                                             <option value="IN">India</option>
                                             <option value="ID">Indonesia</option>
                                             <option value="IR">Iran, Islamic Republic of</option>
                                             <option value="IQ">Iraq</option>
                                             <option value="IE">Ireland</option>
                                             <option value="IM">Isle of Man</option>
                                             <option value="IL">Israel</option>
                                             <option value="IT">Italy</option>
                                             <option value="JM">Jamaica</option>
                                             <option value="JP">Japan</option>
                                             <option value="JE">Jersey</option>
                                             <option value="JO">Jordan</option>
                                             <option value="KZ">Kazakhstan</option>
                                             <option value="KE">Kenya</option>
                                             <option value="KI">Kiribati</option>
                                             <option value="KP">Korea, Democratic People's Republic of</option>
                                             <option value="KR">Korea, Republic of</option>
                                             <option value="KW">Kuwait</option>
                                             <option value="KG">Kyrgyzstan</option>
                                             <option value="LA">Lao People's Democratic Republic</option>
                                             <option value="LV">Latvia</option>
                                             <option value="LB">Lebanon</option>
                                             <option value="LS">Lesotho</option>
                                             <option value="LR">Liberia</option>
                                             <option value="LY">Libya</option>
                                             <option value="LI">Liechtenstein</option>
                                             <option value="LT">Lithuania</option>
                                             <option value="LU">Luxembourg</option>
                                             <option value="MO">Macao</option>
                                             <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                             <option value="MG">Madagascar</option>
                                             <option value="MW">Malawi</option>
                                             <option value="MY">Malaysia</option>
                                             <option value="MV">Maldives</option>
                                             <option value="ML">Mali</option>
                                             <option value="MT">Malta</option>
                                             <option value="MH">Marshall Islands</option>
                                             <option value="MQ">Martinique</option>
                                             <option value="MR">Mauritania</option>
                                             <option value="MU">Mauritius</option>
                                             <option value="YT">Mayotte</option>
                                             <option value="MX">Mexico</option>
                                             <option value="FM">Micronesia, Federated States of</option>
                                             <option value="MD">Moldova, Republic of</option>
                                             <option value="MC">Monaco</option>
                                             <option value="MN">Mongolia</option>
                                             <option value="ME">Montenegro</option>
                                             <option value="MS">Montserrat</option>
                                             <option value="MA">Morocco</option>
                                             <option value="MZ">Mozambique</option>
                                             <option value="MM">Myanmar</option>
                                             <option value="NA">Namibia</option>
                                             <option value="NR">Nauru</option>
                                             <option value="NP">Nepal</option>
                                             <option value="NL">Netherlands</option>
                                             <option value="NC">New Caledonia</option>
                                             <option value="NZ">New Zealand</option>
                                             <option value="NI">Nicaragua</option>
                                             <option value="NE">Niger</option>
                                             <option value="NG">Nigeria</option>
                                             <option value="NU">Niue</option>
                                             <option value="NF">Norfolk Island</option>
                                             <option value="MP">Northern Mariana Islands</option>
                                             <option value="NO">Norway</option>
                                             <option value="OM">Oman</option>
                                             <option value="PK">Pakistan</option>
                                             <option value="PW">Palau</option>
                                             <option value="PS">Palestinian Territory, Occupied</option>
                                             <option value="PA">Panama</option>
                                             <option value="PG">Papua New Guinea</option>
                                             <option value="PY">Paraguay</option>
                                             <option value="PE">Peru</option>
                                             <option value="PH">Philippines</option>
                                             <option value="PN">Pitcairn</option>
                                             <option value="PL">Poland</option>
                                             <option value="PT">Portugal</option>
                                             <option value="PR">Puerto Rico</option>
                                             <option value="QA">Qatar</option>
                                             <option value="RE">Réunion</option>
                                             <option value="RO">Romania</option>
                                             <option value="RU">Russian Federation</option>
                                             <option value="RW">Rwanda</option>
                                             <option value="BL">Saint Barthélemy</option>
                                             <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                             <option value="KN">Saint Kitts and Nevis</option>
                                             <option value="LC">Saint Lucia</option>
                                             <option value="MF">Saint Martin (French part)</option>
                                             <option value="PM">Saint Pierre and Miquelon</option>
                                             <option value="VC">Saint Vincent and the Grenadines</option>
                                             <option value="WS">Samoa</option>
                                             <option value="SM">San Marino</option>
                                             <option value="ST">Sao Tome and Principe</option>
                                             <option value="SA">Saudi Arabia</option>
                                             <option value="SN">Senegal</option>
                                             <option value="RS">Serbia</option>
                                             <option value="SC">Seychelles</option>
                                             <option value="SL">Sierra Leone</option>
                                             <option value="SG">Singapore</option>
                                             <option value="SX">Sint Maarten (Dutch part)</option>
                                             <option value="SK">Slovakia</option>
                                             <option value="SI">Slovenia</option>
                                             <option value="SB">Solomon Islands</option>
                                             <option value="SO">Somalia</option>
                                             <option value="ZA">South Africa</option>
                                             <option value="GS">South Georgia and the South Sandwich Islands</option>
                                             <option value="SS">South Sudan</option>
                                             <option value="ES">Spain</option>
                                             <option value="LK">Sri Lanka</option>
                                             <option value="SD">Sudan</option>
                                             <option value="SR">Suriname</option>
                                             <option value="SJ">Svalbard and Jan Mayen</option>
                                             <option value="SZ">Swaziland</option>
                                             <option value="SE">Sweden</option>
                                             <option value="CH">Switzerland</option>
                                             <option value="SY">Syrian Arab Republic</option>
                                             <option value="TW">Taiwan, Province of China</option>
                                             <option value="TJ">Tajikistan</option>
                                             <option value="TZ">Tanzania, United Republic of</option>
                                             <option value="TH">Thailand</option>
                                             <option value="TL">Timor-Leste</option>
                                             <option value="TG">Togo</option>
                                             <option value="TK">Tokelau</option>
                                             <option value="TO">Tonga</option>
                                             <option value="TT">Trinidad and Tobago</option>
                                             <option value="TN">Tunisia</option>
                                             <option value="TR">Turkey</option>
                                             <option value="TM">Turkmenistan</option>
                                             <option value="TC">Turks and Caicos Islands</option>
                                             <option value="TV">Tuvalu</option>
                                             <option value="UG">Uganda</option>
                                             <option value="UA">Ukraine</option>
                                             <option value="AE">United Arab Emirates</option>
                                             <option value="GB">United Kingdom</option>
                                             <option value="US">United States</option>
                                             <option value="UM">United States Minor Outlying Islands</option>
                                             <option value="UY">Uruguay</option>
                                             <option value="UZ">Uzbekistan</option>
                                             <option value="VU">Vanuatu</option>
                                             <option value="VE">Venezuela, Bolivarian Republic of</option>
                                             <option value="VN">Viet Nam</option>
                                             <option value="VG">Virgin Islands, British</option>
                                             <option value="VI">Virgin Islands, U.S.</option>
                                             <option value="WF">Wallis and Futuna</option>
                                             <option value="EH">Western Sahara</option>
                                             <option value="YE">Yemen</option>
                                             <option value="ZM">Zambia</option>
                                             <option value="ZW">Zimbabwe</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label class="control-label">City <span class="required">*</span></label>
                                          <select  class="select2 form-control border-form-control">
                                             <option value="">Select City</option>
                                             <option value="AF">Alaska</option>
                                             <option value="AX">New Hampshire</option>
                                             <option value="AL">Oregon</option>
                                             <option value="DZ">Toronto</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label class="control-label">Zip Code <span class="required">*</span></label>
                                          <input class="form-control border-form-control" value="" placeholder="123456" type="number">
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label class="control-label">State <span class="required">*</span></label>
                                          <select  class="select2 form-control border-form-control">
                                             <option value="">Select State</option>
                                             <option value="AF">California</option>
                                             <option value="AX">Florida</option>
                                             <option value="AL">Georgia</option>
                                             <option value="DZ">Idaho</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="form-group">
                                          <label class="control-label">Address 1 <span class="required">*</span></label>
                                          <textarea class="form-control border-form-control"></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="form-group">
                                          <label class="control-label">Address 2 <span class="required">*</span></label>
                                          <textarea class="form-control border-form-control"></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="custom-control custom-checkbox mb-3">
                                          <input type="checkbox" class="custom-control-input" id="customCheck1">
                                          <label class="custom-control-label" for="customCheck1">Same as Contact Address</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12 text-right">
                                       <button type="button" class="btn btn-danger btn-lg"> Cencel </button>
                                       <button type="button" class="btn btn-success btn-lg"> Update Address </button>
                                    </div>
                                 </div>
                              </form>
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

