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
	
	if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
		remove_product($_REQUEST['pid']);
	}
	else if($_REQUEST['command']=='clear'){
		unset($_SESSION['cart']);
	}
	else if($_REQUEST['command']=='update'){
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=intval($_REQUEST['product'.$pid]);
			if($q>0 && $q<=999){
				$_SESSION['cart'][$i]['qty']=$q;
			}
			else{
				$msg='Some proudcts not updated!, quantity must be a number between 1 and 999';
			}
		}
	}
	
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
      
        <script language="javascript">
        	function del(pid){
        		if(confirm('Do you really mean to delete this item')){
        			document.form1.pid.value=pid;
        			document.form1.command.value='delete';
        			document.form1.submit();
        		}
        	}
        	function clear_cart(){
        		if(confirm('This will empty your shopping cart, continue?')){
        			document.form1.command.value='clear';
        			document.form1.submit();
        		}
        	}
        	function update_cart(){
        		document.form1.command.value='update';
        		document.form1.submit();
        	}
        
        </script>
      
   </head>
   <body>
      <?php include "inc/header.php"; ?>
      
	  <section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <a href="#"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Cart</a>
               </div>
            </div>
         </div>
      </section>
      <section class="cart-page section-padding">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="card card-body cart-table">
                     <div class="table-responsive">
                       <form name="form1">
                            <input type="hidden" name="pid" />
                            <input type="hidden" name="command" />
                        <table class="table cart_summary">
                           <thead>
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
                              
                           </thead>
                           <tbody>
                               
                              <tr>
                                 <td class="cart_product"><a href="#"><img class="img-fluid" src="../uploads/products/<?= $row['product_image']; ?>" alt=""></a></td>
                                 <td class="cart_description">
                                    <h5 class="product-name"><a href="#"><?= $row['product_name']; ?></a></h5>
                                    <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - <?= $row['unit_value']."".$row['unit']; ?></h6>
                                 </td>
                                 <td class="availability in-stock"><span class="badge badge-success">In stock</span></td>
                                 <td class="price"><span><?= $row['price']; ?></span></td>
                                 <td class="qty">
                                    <div class="input-group">
                                       <span class="input-group-btn"><button disabled="disabled" class="btn btn-theme-round btn-number" type="button">-</button></span>
                                       <input type="text"  name="product<?php echo $pid?>" value="<?php echo $q?>" maxlength="3" size="2" class="form-control border-form-control form-control-sm input-number" >
                                       <span class="input-group-btn"><button class="btn btn-theme-round btn-number" type="button">+</button>
                                       </span>
                                    </div>
                                 </td>
                                 <td class="price"><span><?= $row['price']*$q; ?></span></td>
                                 <td class="action">
                                    <a class="btn btn-sm btn-danger" data-original-title="Remove" href="javascript:del(<?php echo $pid?>)" title="" data-placement="top" data-toggle="tooltip"><i class="mdi mdi-close-circle-outline"></i></a>
                                 </td>
                              </tr>
                              <!--tr>
                                 <td class="cart_product"><a href="#"><img alt="Product" src="img/item/10.jpg" class="img-fluid"></a></td>
                                 <td class="cart_description">
                                    <h5 class="product-name"><a href="#">Ipsums Dolors Untra </a></h5>
                                    <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                                 </td>
                                 <td class="availability out-of-stock"><span class="badge badge-primary">No stock</span></td>
                                 <td class="price"><span>$00.00</span></td>
                                 <td class="qty">
                                    <div class="input-group">
                                       <span class="input-group-btn"><button disabled="disabled" class="btn btn-theme-round btn-number" type="button">-</button></span>
                                       <input type="text" max="10" min="1" value="1" class="form-control border-form-control form-control-sm input-number" name="quant[1]">
                                       <span class="input-group-btn"><button class="btn btn-theme-round btn-number" type="button">+</button>
                                       </span>
                                    </div>
                                 </td>
                                 <td class="price"><span>00.00</span></td>
                                 <td class="action">
                                    <a class="btn btn-sm btn-danger" data-original-title="Remove" href="#" title="" data-placement="top" data-toggle="tooltip"><i class="mdi mdi-close-circle-outline"></i></a>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="cart_product"><a href="#"><img alt="Product" src="img/item/9.jpg" class="img-fluid"></a></td>
                                 <td class="cart_description">
                                    <h5 class="product-name"><a href="#">Ipsums Dolors Untra </a></h5>
                                    <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                                 </td>
                                 <td class="availability in-stock"><span class="badge badge-warning">In stock</span></td>
                                 <td class="price"><span>$99.00</span></td>
                                 <td class="qty">
                                    <div class="input-group">
                                       <span class="input-group-btn"><button disabled="disabled" class="btn btn-theme-round btn-number" type="button">-</button></span>
                                       <input type="text" max="10" min="1" value="1" class="form-control border-form-control form-control-sm input-number" name="quant[1]">
                                       <span class="input-group-btn"><button class="btn btn-theme-round btn-number" type="button">+</button>
                                       </span>
                                    </div>
                                 </td>
                                 <td class="price"><span>$188.00</span></td>
                                 <td class="action">
                                    <a class="btn btn-sm btn-danger" data-original-title="Remove" href="#" title="" data-placement="top" data-toggle="tooltip"><i class="mdi mdi-close-circle-outline"></i></a>
                                 </td>
                              </tr-->
                           </tbody>
                           <?php } ?>
                           
                           
                           <tfoot>
                              <!--tr>
                                 <td colspan="1"></td>
                                 <td colspan="4">
                                    <form class="form-inline float-right">
                                       <div class="form-group">
                                          <input type="text" placeholder="Enter discount code" class="form-control border-form-control form-control-sm">
                                       </div>
                                       &nbsp;
                                       <button class="btn btn-success float-left btn-sm" type="submit">Apply</button>
                                    </form>
                                 </td>
                                 <td colspan="2">Discount : $237.88 </td>
                              </tr>
                              <tr>
                                 <td colspan="2"></td>
                                 <td class="text-right"  colspan="3">Total products (tax incl.)</td>
                                 <td colspan="2">$437.88 </td>
                              </tr-->
                              <tr>
                                 <td colspan="3" align="text-left"><input type="button" value="Clear Cart" onclick="clear_cart()" style="background-color:#e96125;color:white"><input type="button" value="Update Cart" onclick="update_cart()" style="background-color:#e96125;color:white"><input type="button" value="Place Order" onclick="window.location='checkout.php'" style="background-color:#e96125;color:white"></td>
                                 <td class="text-right" colspan="2"><strong>Total</strong></td>
                                 <td class="text-danger" colspan="2"><strong><?php $total= get_order_total2(); echo $total ?> </strong></td>
                              </tr>
                           </tfoot>
                         <?php } 
                         else{
                                echo "<h3 style='text-align:center;color:red'>Products Not Available in Cart !</h3> ";
                            }
                         ?>  
                        </table>
                       </form>
                     </div>
                     <a href="checkout.php"><button class="btn btn-secondary btn-lg btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span class="float-right"><strong><?= $total ?></strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
                  </div>
                  
                  <!--div class="card mt-2">
                     <h5 class="card-header">My Cart (Design Two)<span class="text-secondary float-right">(5 item)</span></h5>
                     <div class="card-body pt-0 pr-0 pl-0 pb-0">
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
                     <div class="card-footer cart-sidebar-footer">
                        <div class="cart-store-details">
                           <p>Sub Total <strong class="float-right">$900.69</strong></p>
                           <p>Delivery Charges <strong class="float-right text-danger">+ $29.69</strong></p>
                           <h6>Your total savings <strong class="float-right text-danger">$55 (42.31%)</strong></h6>
                        </div>
                        <a href="checkout.php"><button class="btn btn-secondary btn-lg btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span class="float-right"><strong>$1200.69</strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
                     </div>
                  </div-->
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

