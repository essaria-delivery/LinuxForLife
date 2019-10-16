<?php include "inc/connection.php"; 
$queryy="SELECT * FROM `web` WHERE `id`=1";
$resulty=mysqli_query($conn,$queryy);
$rowy=mysqli_fetch_array($resulty, MYSQLI_ASSOC);
$title=$rowy['title'];
$favicon=$rowy['favicon']; //../uploads/web/
?>

<?php
	include("cart/includes/functions.php");
if(isset($_POST['addd'])){
		$pid=$_POST['productid'];
		addtocart($pid,1);
		header("location:cart.php");
		//exit();
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

    <script>
        $(window).load(function(){        
            $('#myModal').modal('show');
        }); 
    </script>

        <script language="javascript">
        	function addtocart(pid){
        		document.form1.productid.value=pid;
        		document.form1.command.value='add';
        		document.form1.submit();
        	}
        </script>  
        <style>
            .product {
                margin: 2px;
                border-radius: 12px;
            }
            
            .product-body h5 {
                font-size: 14px;
                height: 50px;
            }
            input.btn.btn-secondary.btn-sm.float-right {
                                                background-color: #00800000 !important;
                                                border: 2px solid orange;
                                                color: orange;
                                            }
            input.btn.btn-secondary.btn-sm.float-right:hover {
                                                background-color: orange !important;
                                                border: 2px solid orange;
                                                color: white;
                                            }
            section.top-category.section-padding {
                                                width: 90%;
                                                margin-left: 5%;
                                            }
            section.top-category.section-padding {
                                                width: 90% !important;
                                                margin-left: 5% !important;
                                            }
            section.carousel-slider-main.text-center.border-top.border-bottom.bg-white {
                                                    width: 90%;
                                                    margin-left: 5%;
                                                }
        </style>
   </head>
   <body>
      <?php include "inc/header.php"; ?>
      <?php include "inc/connection.php"; ?>
          <form name="form1" method="get">
        	<input type="hidden" name="productid" />
            <input type="hidden" name="command" />
        </form>
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
              </div>
              <div class="modal-body">
                <p>Some text in the modal.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
        
          </div>
        </div>
        
        <?php 
            $query="SELECT * FROM `categories` WHERE `leval`=0";
            $result=mysqli_query($conn,$query);
        
        ?>
      
      <section class="top-category section-padding">
         <div class="container">
            <div class="owl-carousel owl-carousel-category">
                <?php 
                while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
                ?>    
                
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php?cat_id=<?= $row['id'] ?>">
                        <img class="img-fluid" src="../uploads/category/<?= $row['image'] ?>" alt="">
                        <h6><?= $row['title']; ?></h6>
                        <?php 
                            $query2="SELECT * FROM `categories` WHERE `parent`='".$row['id']."'";
                            $result2=mysqli_query($conn,$query2);
                        
                            $rowcount=mysqli_num_rows($result2);
                        ?> 
                        <p><?= $rowcount ?> SUB CATE</p>
                     </a>
                  </div>
               </div>
               <?php } 
            //   echo $_SERVER['QUERY_STRING']; 
            //   echo $_REQUEST['pahe'];
               ?>
               <!--div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/2.jpg" alt="">
                        <h6>Grocery & Staples</h6>
                        <p>95 Items</p>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/3.jpg" alt="">
                        <h6>Beverages</h6>
                        <p>65 Items</p>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/4.jpg" alt="">
                        <h6>Home & Kitchen</h6>
                        <p>965 Items</p>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/5.jpg" alt="">
                        <h6>Furnishing & Home Needs</h6>
                        <p>125 Items</p>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/6.jpg" alt="">
                        <h6>Household Needs</h6>
                        <p>325 Items</p>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/7.jpg" alt="">
                        <h6>Personal Care</h6>
                        <p>156 Items</p>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/8.jpg" alt="">
                        <h6>Breakfast & Dairy</h6>
                        <p>857 Items</p>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/9.jpg" alt="">
                        <h6>Biscuits, Snacks & Chocolates</h6>
                        <p>48 Items</p>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/10.jpg" alt="">
                        <h6>Noodles, Sauces & Instant Food</h6>
                        <p>156 Items</p>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/11.jpg" alt="">
                        <h6>Pet Care</h6>
                        <p>568 Items</p>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="category-item">
                     <a href="shop.php">
                        <img class="img-fluid" src="img/small/12.jpg" alt="">
                        <h6>Meats, Frozen & Seafood</h6>
                        <p>156 Items</p>
                     </a>
                  </div>
               </div-->
            </div>
         </div>
      </section>
      
      
<?php

    $data = array();
    $_POST = $_REQUEST;
   
        $query3="SELECT dp.*,p.*,c.title from deal_product dp inner JOIN products p on dp.product_name = p.product_name INNER JOIN categories c on c.id=p.category_id";
        $result3=mysqli_query($conn,$query3);
      
      
      //$q = $this->db->query("SELECT dp.*,p.*,c.title from deal_product dp inner JOIN products p on dp.product_name = p.product_name INNER JOIN categories c on c.id=p.category_id");

    $data['responce']="true";
   //$data['Deal_of_the_day'][]=array();
    

?>
      
      
      <section class="carousel-slider-main text-center border-top border-bottom bg-white">
         <div class="owl-carousel owl-carousel-slider">
            <?php  
                $result=mysqli_query($conn, "SELECT * FROM `slider` WHERE slider_status=1") or die("SELECT * FROM `slider` WHERE slider_status=1"."<br/><br/>".mysql_error());
                while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {
            ?>
            <div class="item" style="margin: 0 auto;width: 80em;">
               <a href="shop.php?cat_id=<?= $row['sub_cat'] ?>"><img class="img-fluid" style="max-width: 100%;height: 400px !important;" src="../uploads/sliders/<?= $row['slider_image'] ?>" alt="First slide"></a>
            </div>
            <?php } ?>
            <!--div class="item">
               <a href="shop.php"><img class="img-fluid" src="img/slider/slider2.jpg" alt="First slide"></a>
            </div-->
         </div>
      </section>
      <section class="product-items-slider section-padding">
         <div class="container">
            <div class="section-header">
               <h5 class="heading-design-h5">Top Savers Today <span class="badge badge-primary">20% OFF</span>
                  <a class="float-right text-secondary" href="shop.php">View All</a>
               </h5>
            </div>
            <div class="owl-carousel owl-carousel-featured">
                <?php
                
                while ($product = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
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
		
      
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $category_id = '0';
            $product_description =$product['product_description'];
            $deal_price =$product['deal_price'];
            $start_date =$product['start_date'];
            $start_time =$product['start_time'];
            $end_date =$product['end_date'];
            $end_time =$product['end_time'];
            $price =  $price;
            $product_image = $product['product_image'];
            $status =  '';
            $in_stock = $product['in_stock'];
            $unit_value = $product['unit_value'];
            $unit = $product['unit'];
            $increament = $product['increament'];
            $rewards = $product['rewards'];
            $stock = '0';
            $title = $product['title'];
           
            ?>
               <div class="item">
                  <div class="product">
                     <a href="single.php?pid=<?= $product_id ?>">
                        <div class="product-header">
                           <img class="img-fluid" src="../uploads/products/<?= $product_image ?>" alt="">
                           <span class="veg text-success mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5><?= $product_name ?></h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - <?= $unit ?></h6>
                        </div>
                     </a>
                        <div class="product-footer">
                           <form action="" method="post">
                                      <input type="hidden" name="productid" value="<?= $product_id ?>" />
                                      <input type="submit" class="btn btn-secondary btn-sm float-right" name="addd" value="Add To Cart"  />
                                  </form>
                           <p class="offer-price mb-0">Rs. <?= $deal_price ?><i class="mdi mdi-tag-outline"></i><br><span class="regular-price">Rs. <?= $price ?></span></p>
                        </div>
                     
                  </div>
               </div>
               <?php } ?> 
               <!--div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/2.jpg" alt="">
                           <span class="non-veg text-danger mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5>Product Title Here</h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                        </div>
                        <div class="product-footer">
                           <button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                           <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/3.jpg" alt="">
                           <span class="non-veg text-danger mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5>Product Title Here</h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                        </div>
                        <div class="product-footer">
                           <button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                           <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/4.jpg" alt="">
                           <span class="veg text-success mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5>Product Title Here</h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                        </div>
                        <div class="product-footer">
                           <button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                           <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/5.jpg" alt="">
                           <span class="veg text-success mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5>Product Title Here</h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                        </div>
                        <div class="product-footer">
                           <button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                           <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/6.jpg" alt="">
                           <span class="veg text-success mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5>Product Title Here</h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                        </div>
                        <div class="product-footer">
                           <button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                           <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                        </div>
                     </a>
                  </div>
               </div-->
            </div>
         </div>
      </section>
      <!--section class="offer-product">
         <div class="container">
            <div class="row no-gutters">
               <div class="col-md-6">
                  <a href="#"><img class="img-fluid" src="img/ad/1.jpg" alt=""></a>
               </div>
               <div class="col-md-6">
                  <a href="#"><img class="img-fluid" src="img/ad/2.jpg" alt=""></a>
               </div>
            </div>
         </div>
      </section-->
      <section class="carousel-slider-main text-center border-top border-bottom bg-white">
         <div class="owl-carousel owl-carousel-slider">
            <?php  
                $result2=mysqli_query($conn, "SELECT * FROM `banner` WHERE slider_status=1") or die("SELECT * FROM `banner` WHERE slider_status=1"."<br/><br/>".mysql_error());
                while($row2=mysqli_fetch_array($result2, MYSQLI_ASSOC))
                    {
            ?>
            <div class="item" style="margin: 0 auto;width: 80em;">
               <a href="shop.php?cat_id=<?= $row2['sub_cat'] ?>"><img class="img-fluid" style="max-width: 100%;height: 400px !important;"  src="../uploads/sliders/<?= $row2['slider_image'] ?>" style="width:100%;height:100%" alt="First slide"></a>
            </div>
            <?php } ?>
            <!--div class="item">
               <a href="shop.php"><img class="img-fluid" src="img/slider/slider2.jpg" alt="First slide"></a>
            </div-->
         </div>
      </section>
      <section class="product-items-slider section-padding">
         <div class="container">
            <div class="section-header">
               <h5 class="heading-design-h5">TOP SELLEING PRODUCTS <span class="badge badge-info">20% OFF</span>
                  <a class="float-right text-secondary" href="shop.php">View All</a>
               </h5>
            </div>
            <div class="owl-carousel owl-carousel-featured">
                
<?php
	   $data = array();
    $_POST = $_REQUEST;

    $query4="select p.*,dp.start_date,dp.start_time,dp.end_time,dp.end_date,dp.deal_price,c.title,count(si.product_id) as top,si.product_id from products p INNER join sale_items si on p.product_id=si.product_id INNER join categories c ON c.id=p.category_id left join deal_product dp on dp.product_id=si.product_id GROUP BY si.product_id order by top DESC LIMIT 8";
        $result4=mysqli_query($conn,$query4);

   while ($product = mysqli_fetch_array($result4, MYSQLI_ASSOC)) {
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
		
      
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $category_id = '0';
            $product_description =$product['product_description'];
            $deal_price =$product['deal_price'];
            $start_date =$product['start_date'];
            $start_time =$product['start_time'];
            $end_date =$product['end_date'];
            $end_time =$product['end_time'];
            $price =  $price;
            $product_image = $product['product_image'];
            $status =  '';
            $in_stock = $product['in_stock'];
            $unit_value = $product['unit_value'];
            $unit = $product['unit'];
            $increament = $product['increament'];
            $rewards = $product['rewards'];
            $stock = '0';
            $title = $product['title'];
  ?>

                
               <div class="item">
                  <div class="product">
                     <a href="single.php?pid=<?= $product_id ?>">
                        <div class="product-header">
                           <!--<span class="badge badge-success">50% OFF</span>-->
                           <img class="img-fluid" src="../uploads/products/<?= $product_image ?>" alt="">
                           <span class="veg text-success mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5><?= $product_name ?></h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - <?= $unit ?></h6>
                        </div>
                        <div class="product-footer">
                           <form action="" method="post">
                                      <input type="hidden" name="productid" value="<?= $product_id ?>" />
                                      <input type="submit" class="btn btn-secondary btn-sm float-right" name="addd" value="Add To Cart"  />
                                  </form>
                           <?php if(!empty($product['deal_price'])) { ?><p class="offer-price mb-0"><?= $deal_price ?> <i class="mdi mdi-tag-outline"></i><br><span class="regular-price"><?= $price ?></span></p> <?php } ?>
                            <?php if(empty($product['deal_price'])) { ?><p class="offer-price mb-0"><?= $price ?> <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">&nbsp;</span></p> <?php } ?>
                        </div>
                     </a>
                  </div>
               </div>
               <?php } ?>
               <!--div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/8.jpg" alt="">
                           <span class="non-veg text-danger mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5>Product Title Here</h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                        </div>
                        <div class="product-footer">
                           <button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                           <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/9.jpg" alt="">
                           <span class="non-veg text-danger mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5>Product Title Here</h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                        </div>
                        <div class="product-footer">
                           <button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                           <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/10.jpg" alt="">
                           <span class="veg text-success mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5>Product Title Here</h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                        </div>
                        <div class="product-footer">
                           <button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                           <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/11.jpg" alt="">
                           <span class="veg text-success mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5>Product Title Here</h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                        </div>
                        <div class="product-footer">
                           <button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                           <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/12.jpg" alt="">
                           <span class="veg text-success mdi mdi-circle"></span>
                        </div>
                        <div class="product-body">
                           <h5>Product Title Here</h5>
                           <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
                        </div>
                        <div class="product-footer">
                           <button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
                           <p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
                        </div>
                     </a>
                  </div>
               </div-->
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

