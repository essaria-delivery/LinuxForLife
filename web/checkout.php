<?php include "inc/connection.php"; 
$queryy="SELECT * FROM `web` WHERE `id`=1";
$resulty=mysqli_query($conn,$queryy);
$rowy=mysqli_fetch_array($resulty, MYSQLI_ASSOC);
$title=$rowy['title'];
$favicon=$rowy['favicon']; //../uploads/web/<?= $favicon ?>


<?php
    include("inc/connection.php");
	include("cart/includes/functions.php");
	session_start();
function get_order_total2(){
	    include("inc/connection.php");
		$max=count($_SESSION['cart']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=$_SESSION['cart'][$i]['qty'];
			$query4="Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
                                inner join categories on categories.id = products.category_id
                                left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                                left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                               left join deal_product dp on dp.product_id=products.product_id where products.product_id='".$pid."' ";
                        $result4=mysqli_query($conn,$query4);
            $product = mysqli_fetch_array($result4, MYSQLI_ASSOC);
            $present = date('m/d/Y h:i:s a', time());
                        $date1 = $product['start_date']." ".$product['start_time'];
					    $date2 = $product['end_date']." ".$product['end_time'];
                            if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
        					 {
        					    if(empty($product['deal_price']))   ///Runing
        					    {
        						   $price= $product['price'];
        					    }else{
        							 $price= $product['deal_price'];
        					    }
        					 }else{
        					  $price= $product['price'];//expired
        					 }
			
			$p=$price;
			//get_price($pid);
			$sum+=$p*$q;
		}
		return $sum;
	}
	
	if(isset($_POST['insert'])){
	    include("inc/connection.php");
	    $today = date("d/m/Y");
	    echo $_POST['customRadio'];

	    
	    $sql = "INSERT INTO `sale`(`sale_id`, `user_id`, `on_date`, `delivery_time_from`, `delivery_time_to`, `status`, `note`, `is_paid`, `total_amount`, `total_rewards`, `total_kg`, `total_items`, `socity_id`, `delivery_address`, `location_id`, `delivery_charge`, `new_store_id`, `assign_to`, `payment_method`) 
	    VALUES (,,'".$today."',".$delivery_time_from.",'".$delivery_time_to."','0','','0','','','','','','','','','','','COD')";
	    $result1=mysqli_query($conn,$sql);
	    if($result1){
	        header('location:index.php');
	    }
	    else{
	        echo("Error description: " . mysqli_error($conn));
	    }
	}

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
      <section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <a href="#"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Checkout</a>
               </div>
            </div>
         </div>
      </section>
      <section class="checkout-page section-padding">
         <div class="container">
            <div class="row">
               <div class="col-md-8">
                  <div class="checkout-step">
                      <form action="" method="post" >
                         <div class="accordion" id="accordionExample">
                            <div class="card checkout-step-one">
                               <div class="card-header" id="headingOne">
                                  <h5 class="mb-0">
                                     <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                     <span class="number">1</span> Phone Number Verification
                                     </button>
                                  </h5>
                               </div>
                               <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                  <div class="card-body">
                                     <p>We need your phone number so that we can update you about your order.</p>
                                     
                                        <div class="form-row align-items-center">
                                           <div class="col-auto">
                                              <label class="sr-only">phone number</label>
                                              <div class="input-group mb-2">
                                                 <div class="input-group-prepend">
                                                    <div class="input-group-text"><span class="mdi mdi-cellphone-iphone"></span></div>
                                                 </div>
                                                 <input name="phone" type="number" class="form-control" placeholder="Enter phone number">
                                              </div>
                                           </div>
                                           <div class="col-auto">
                                              <button type="button" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="btn btn-secondary mb-2 btn-lg">NEXT</button>
                                           </div>
                                        </div>
                                  </div>
                               </div>
                            </div>
                            <div class="card checkout-step-two">
                               <div class="card-header" id="headingTwo">
                                  <h5 class="mb-0">
                                     <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                     <span class="number">2</span> Delivery Address
                                     </button>
                                  </h5>
                               </div>
                               <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                  <div class="card-body">
                                        <div class="row">
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">First Name <span class="required">*</span></label>
                                                 <input name"fname" class="form-control border-form-control" value="" placeholder="Gurdeep" type="text">
                                              </div>
                                           </div>
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">Last Name <span class="required">*</span></label> 
                                                 <input name"lname" class="form-control border-form-control" value="" placeholder="Osahan" type="text">
                                              </div>
                                           </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">Email Address <span class="required">*</span></label>
                                                 <input name"email" class="form-control border-form-control " value="" placeholder="iam@gmail.com" type="email">
                                              </div>
                                           </div>
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">Location<span class="required">*</span></label>
                                                 <select class="select2 form-control border-form-control">
                                                     <option value="">Select City</option>
                                                     <?php 
                                                        $queryx="SELECT * FROM `socity`";
                                                        $resultx=mysqli_query($conn,$queryx);
                                                        While($rowx=mysqli_fetch_array($resultx, MYSQLI_ASSOC))
                                                        {
                                                     ?>
                                                    
                                                    <option value="<?= $rowx['socity_name'] ?>"><?= $rowx['socity_name'] ?></option>
                                                    <?php } ?>
                                                 </select>
                                              </div>
                                           </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-sm-4">
                                              <div class="form-group">
                                                 <label class="control-label">Delivery Date <span class="required">*</span></label>
                                                 <input name"date" class="form-control border-form-control" value="" placeholder="Gurdeep" type="date">
                                              </div>
                                           </div>
                                           <div class="col-sm-4">
                                              <div class="form-group">
                                                 <label class="control-label">Delivery Time - From <span class="required">*</span></label> 
                                                 <input name"timefrom" class="form-control border-form-control"pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$" value="" placeholder="Osahan" type="time">
                                              </div>
                                           </div>
                                           <div class="col-sm-4">
                                              <div class="form-group">
                                                 <label class="control-label">Delivery Time - To <span class="required">*</span></label> 
                                                 <input name"timeto" class="form-control border-form-control" pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$" value="" placeholder="Osahan" type="time">
                                              </div>
                                           </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">Block or Landmark <span class="required">*</span></label>
                                                 <input name="block" class="form-control border-form-control" value="" placeholder="Block" type="number">
                                              </div>
                                           </div>
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">House or Building No. <span class="required">*</span></label>
                                                 <input name="house" class="form-control border-form-control" value="" placeholder="Block" type="number">
                                              </div>
                                           </div>
                                        </div>
                                        <!--div class="row">
                                           <div class="col-sm-12">
                                              <div class="form-group">
                                                 <label class="control-label">Block & House Number <span class="required">*</span></label>
                                                 <textarea class="form-control border-form-control"></textarea>
                                                 <small class="text-danger">Please provide the number and street.</small>
                                              </div>
                                           </div>
                                        </div>
                                        
                                        
                                        
                                        <!--div class="heading-part">
                                           <h3 class="sub-heading">Billing Address</h3>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">First Name <span class="required">*</span></label>
                                                 <input class="form-control border-form-control" value="" placeholder="Gurdeep" type="text">
                                              </div>
                                           </div>
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">Last Name <span class="required">*</span></label>
                                                 <input class="form-control border-form-control" value="" placeholder="Osahan" type="text">
                                              </div>
                                           </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">Phone <span class="required">*</span></label>
                                                 <input class="form-control border-form-control" value="" placeholder="123 456 7890" type="number">
                                              </div>
                                           </div>
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">Email Address <span class="required">*</span></label>
                                                 <input class="form-control border-form-control " value="" placeholder="iamosahan@gmail.com" disabled="" type="email">
                                              </div>
                                           </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-sm-6">
                                              <div class="form-group">
                                                 <label class="control-label">Country <span class="required">*</span></label>
                                                 <select class="select2 form-control border-form-control">
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
                                                 <select class="select2 form-control border-form-control">
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
                                                 <select class="select2 form-control border-form-control">
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
                                                 <label class="control-label">Billing Landmark <span class="required">*</span></label>
                                                 <textarea class="form-control border-form-control"></textarea>
                                                 <small class="text-danger">
                                                 Please include landmark (e.g : Opposite Bank) as the carrier service may find it easier to locate your address.
                                                 </small>
                                              </div>
                                           </div>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                           <input type="checkbox" class="custom-control-input" id="customCheckbill">
                                           <label class="custom-control-label" for="customCheckbill">Use my delivery address as my billing address</label>
                                        </div-->
                                        <button type="button" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="btn btn-secondary mb-2 btn-lg">NEXT</button>

                                  </div>
                               </div>
                            </div>
                            <div class="card">
                               <div class="card-header" id="headingThree">
                                  <h5 class="mb-0">
                                     <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                     <span class="number">3</span> Payment
                                     </button>
                                  </h5>
                               </div>
                               <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                  <div class="card-body">
                                     
                                        <div class="form-group">
                                           <label class="control-label">Card Number</label>
                                           <input class="form-control border-form-control" value="" placeholder="0000 0000 0000 0000" type="text">
                                        </div>
                                        <div class="row">
                                           <div class="col-sm-3">
                                              <div class="form-group">
                                                 <label class="control-label">Month</label>
                                                 <input class="form-control border-form-control" value="" placeholder="01" type="text">
                                              </div>
                                           </div>
                                           <div class="col-sm-3">
                                              <div class="form-group">
                                                 <label class="control-label">Year</label>
                                                 <input class="form-control border-form-control" value="" placeholder="15" type="text">
                                              </div>
                                           </div>
                                           <div class="col-sm-3">
                                           </div>
                                           <div class="col-sm-3">
                                              <div class="form-group">
                                                 <label class="control-label">CVV</label>
                                                 <input class="form-control border-form-control" value="" placeholder="135" type="text">
                                              </div>
                                           </div>
                                        </div>
                                        <hr>
                                        <div class="custom-control custom-radio">
                                           <input type="radio" id="customRadio1" value="Cash On Delivery" name="customRadio" class="custom-control-input">
                                           <input type="radio" id="customRadio1" value="Cash On Delivery" name="customRadio" class="custom-control-input">
                                           <label class="custom-control-label" for="customRadio1">Would you like to pay by Cash on Delivery?</label>
                                        </div>
                                        <button  type="submit" name="insert" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour" class="btn btn-secondary mb-2 btn-lg">NEXT</button>
                                     
                                  </div>
                               </div>
                            </div>
                            <div class="card">
                               <div class="card-header" id="headingThree">
                                  <h5 class="mb-0">
                                     <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                     <span class="number">4</span> Order Complete
                                     </button>
                                  </h5>
                               </div>
                               <div id="collapsefour" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                  <div class="card-body">
                                     <div class="text-center">
                                        <div class="col-lg-10 col-md-10 mx-auto order-done">
                                           <i class="mdi mdi-check-circle-outline text-secondary"></i>
                                           <h4 class="text-success">Congrats! Your Order has been Accepted..</h4>
                                           <p>
                                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque lobortis tincidunt est, et euismod purus suscipit quis. Etiam euismod ornare elementum. Sed ex est, Sed ex est, consectetur eget consectetur, Lorem ipsum dolor sit amet...
                                           </p>
                                        </div>
                                        <div class="text-center">
                                           <a href="shop.html"><button type="submit" class="btn btn-secondary mb-2 btn-lg">Return to store</button></a>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </form>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card">
                      
                     <h5 class="card-header">My Cart <span class="text-secondary float-right">(<?php if(is_array($_SESSION['cart'])){ $max=count($_SESSION['cart']); for($i=1;$i<$max;$i++){ $i;} echo $i;} else { echo 0; }?> item)</span></h5>
                     <div class="card-body pt-0 pr-0 pl-0 pb-0">
                         <?php
                         if(is_array($_SESSION['cart'])){
                                	echo '<tr>
                                             <th class="cart_product">Product</th>
                                             <th>Description</th>
                                             <th>Avail.</th>
                                             <th>Unit price</th>
                                             <th>Qty</th>
                                             <th>Total</th>
                                             <th class="action"><i class="mdi mdi-delete-forever"></i></th>
                                          </tr>';
                    				$max=count($_SESSION['cart']);
                    				for($i=0;$i<$max;$i++){
                    					$pid=$_SESSION['cart'][$i]['productid'];
                    					$q=$_SESSION['cart'][$i]['qty'];
                    				    $result=mysqli_query($conn, "select * from products where product_id = $pid") or die("select * from products where product_id=$pid"."<br/><br/>".mysql_error());
                                        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
                                        
                    					if($q==0) continue;
                         
                         ?>
                        <div class="cart-list-product">
                           <a class="float-right remove-cart" href="#"><i class="mdi mdi-close"></i></a>
                           <img class="img-fluid" src="../uploads/products/<?= $row['product_image']; ?>" alt="">
                           <!--span class="badge badge-success">50% OFF</span-->
                           <h5><a href="#"><?= $row['product_name']; ?></a></h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - <?= $row['unit_value']." ".$row['unit']; ?></h6>
                           <p class="offer-price mb-0"><?= $row['price']; ?><i class="mdi mdi-tag-outline"></i> <span class="regular-price"><?= $row['price']; ?></span></p>
                           <p class="offer-price mb-0">Quantity : <?= $q ?></p>
                           
                        </div>
                        <?php } 
                                 } 
                                 else{
                                        echo "<h3 style='text-align:center;color:red'>Products Not Available in Cart !</h3> ";
                                    }
                        ?>
                        <!--div class="cart-list-product">
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
                        </div-->
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
      <section class="section-padding footer bg-white border-top">
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-md-3">
                  <h4 class="mb-5 mt-0"><a class="logo" href="index-2.html"><img src="img/logo-footer.png" alt="Osahan Grocery"></a></h4>
                  <p class="mb-0"><a class="text-dark" href="#"><i class="mdi mdi-phone"></i> +61 525 240 310</a></p>
                  <p class="mb-0"><a class="text-dark" href="#"><i class="mdi mdi-cellphone-iphone"></i> 12345 67890, 56847-98562</a></p>
                  <p class="mb-0"><a class="text-success" href="#"><i class="mdi mdi-email"></i> iamosahan@gmail.com</a></p>
                  <p class="mb-0"><a class="text-primary" href="#"><i class="mdi mdi-web"></i> www.askbootstrap.com</a></p>
               </div>
               <div class="col-lg-2 col-md-2">
                  <h6 class="mb-4">TOP CITIES </h6>
                  <ul>
                  <li><a href="#">New Delhi</a></li>
                  <li><a href="#">Bengaluru</a></li>
                  <li><a href="#">Hyderabad</a></li>
                  <li><a href="#">Kolkata</a></li>
                  <li><a href="#">Gurugram</a></li>
                  <ul>
               </div>
               <div class="col-lg-2 col-md-2">
                  <h6 class="mb-4">CATEGORIES</h6>
                  <ul>
                  <li><a href="#">Vegetables</a></li>
                  <li><a href="#">Grocery & Staples</a></li>
                  <li><a href="#">Breakfast & Dairy</a></li>
                  <li><a href="#">Soft Drinks</a></li>
                  <li><a href="#">Biscuits & Cookies</a></li>
                  <ul>
               </div>
               <div class="col-lg-2 col-md-2">
                  <h6 class="mb-4">ABOUT US</h6>
                  <ul>
                  <li><a href="#">Company Information</a></li>
                  <li><a href="#">Careers</a></li>
                  <li><a href="#">Store Location</a></li>
                  <li><a href="#">Affillate Program</a></li>
                  <li><a href="#">Copyright</a></li>
                  <ul>
               </div>
               <div class="col-lg-3 col-md-3">
                  <h6 class="mb-4">Download App</h6>
                  <div class="app">
                     <a href="#"><img src="img/google.png" alt=""></a>
                     <a href="#"><img src="img/apple.png" alt=""></a>
                  </div>
                  <h6 class="mb-3 mt-4">GET IN TOUCH</h6>
                  <div class="footer-social">
                     <a class="btn-facebook" href="#"><i class="mdi mdi-facebook"></i></a>
                     <a class="btn-twitter" href="#"><i class="mdi mdi-twitter"></i></a>
                     <a class="btn-instagram" href="#"><i class="mdi mdi-instagram"></i></a>
                     <a class="btn-whatsapp" href="#"><i class="mdi mdi-whatsapp"></i></a>
                     <a class="btn-messenger" href="#"><i class="mdi mdi-facebook-messenger"></i></a>
                     <a class="btn-google" href="#"><i class="mdi mdi-google"></i></a>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- End Footer -->
      <!-- Copyright -->
      <section class="pt-4 pb-4 footer-bottom">
         <div class="container">
            <div class="row no-gutters">
               <div class="col-lg-6 col-sm-6">
                  <p class="mt-1 mb-0">&copy; Copyright 2018 <strong class="text-dark">Osahan Grocery</strong>. All Rights Reserved<br>
				  <small class="mt-0 mb-0">Made with <i class="mdi mdi-heart text-danger"></i> by <a href="https://askbootstrap.com/" target="_blank" class="text-primary">Ask Bootstrap</a>
                  </small>
				  </p>
               </div>
               <div class="col-lg-6 col-sm-6 text-right">
                  <img alt="osahan logo" src="img/payment_methods.png">
               </div>
            </div>
         </div>
      </section>
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

