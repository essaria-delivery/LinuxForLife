<?php include "inc/connection.php"; 
$queryy="SELECT * FROM `web` WHERE `id`=1";
$resulty=mysqli_query($conn,$queryy);
$rowy=mysqli_fetch_array($resulty, MYSQLI_ASSOC);
$title=$rowy['title'];
$favicon=$rowy['favicon']; //../uploads/web/
?>

<?php
	//include("cart/includes/db.php");
	include("cart/includes/functions.php");

	
	if(isset($_POST['addd'])){
		$pid=$_POST['productid'];
		addtocart($pid,1);
		header("location:cart.php");
		//exit();
	}
	
?>


<?php /*
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByproduct_id = $db_handle->runQuery("SELECT * FROM products WHERE product_id='" . $_GET["product_id"] . "'");
			$itemArray = array($productByproduct_id[0]["product_id"]=>array('name'=>$productByproduct_id[0]["product_name"], 'product_id'=>$productByproduct_id[0]["product_id"], 'quantity'=>$_POST["quantity"], 'price'=>$productByproduct_id[0]["price"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByproduct_id[0]["product_id"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByproduct_id[0]["product_id"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["product_id"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
} */
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
        	function addtocart(pid){
        		document.form1.productid.value=pid;
        		document.form1.command.value='add';
        		document.form1.submit();
        	}
        </script>
      
   </head>
   <body>
    <?php include "inc/header.php"; ?>  
    <form name="form1" method="get">
    	<input type="hidden" name="productid" />
        <input type="hidden" name="command" />
    </form>
      
	  <section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <a href="#"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Shop</a>
               </div>
            </div>
         </div>
      </section>
      <section class="shop-list section-padding">
         <div class="container">
            <div class="row">
               <div class="col-md-3">
                  <div class="shop-filters">
                     <div id="accordion">
                        <?php 
                            $cat_id= $_REQUEST['cat_id'];
                            $query="SELECT * FROM `categories` WHERE `leval`=0";
                            $result=mysqli_query($conn,$query);
                            $i = 1;
                            while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
                        ?>
                         
                        <div class="card">
                           <div class="card-header" id="headingOne">
                              <h5 class="mb-0">
                                 <button class="btn btn-link" data-toggle="collapse" data-target="<?= '#collapseOne'.$i; ?>" aria-expanded="true" aria-controls="<?= 'collapseOne'.$i; ?>">
                                 <?= $row['title']; ?> <span class="mdi mdi-chevron-down float-right"></span>
                                 </button>
                              </h5>
                           </div>
                           <div id="<?= 'collapseOne'.$i; ?>" class="collapse <?php if($cat_id==$row['id']){ echo 'show'; } ?>" aria-labelledby="headingOne" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="list-group">
                                    <!--a href="#" class="list-group-item list-group-item-action active">
                                    All Fruits
                                    </a-->
                                    <?php 
                                        $query2="SELECT * FROM `categories` WHERE `parent`='".$row['id']."'";
                                        $result2=mysqli_query($conn,$query2);
                                        while($row2=mysqli_fetch_array($result2, MYSQLI_ASSOC)){
                                        
                                            echo "<a href='shop.php?cat_id=".$row2['id']."' class='list-group-item list-group-item-action'><span class='mdi mdi-chevron-right'></span>".$row2['title']."</a>";
                                        }
                                    ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php $i++; } ?>
                        <!--div class="card">
                           <div class="card-header" id="headingTwo">
                              <h5 class="mb-0">
                                 <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                 Vegetables <span class="mdi mdi-chevron-down float-right"></span>
                                 </button>
                              </h5>
                           </div>
                           <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">All Fruits</a>
                                    <a href="#" class="list-group-item list-group-item-action">Imported Fruits</a>
                                    <a href="#" class="list-group-item list-group-item-action">Seasonal Fruits</a>
                                    <a href="#" class="list-group-item list-group-item-action">Citrus</a>
                                    <a href="#" class="list-group-item list-group-item-action disabled">Cut Fresh & Herbs</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="card">
                           <div class="card-header" id="headingThree">
                              <h5 class="mb-0">
                                 <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                 Mangoes <span class="mdi mdi-chevron-down float-right"></span>
                                 </button>
                              </h5>
                           </div>
                           <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">All Fruits</a>
                                    <a href="#" class="list-group-item list-group-item-action">Imported Fruits</a>
                                    <a href="#" class="list-group-item list-group-item-action">Seasonal Fruits</a>
                                    <a href="#" class="list-group-item list-group-item-action">Citrus</a>
                                    <a href="#" class="list-group-item list-group-item-action disabled">Cut Fresh & Herbs</a>
                                 </div>
                              </div>
                           </div>
                        </div>
						<div class="card">
                           <div class="card-header" id="headingThree">
                              <h5 class="mb-0">
                                 <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                 Imported Fruits <span class="mdi mdi-chevron-down float-right"></span>
                                 </button>
                              </h5>
                           </div>
                           <div id="collapsefour" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">All Fruits</a>
                                    <a href="#" class="list-group-item list-group-item-action">Imported Fruits</a>
                                    <a href="#" class="list-group-item list-group-item-action">Seasonal Fruits</a>
                                    <a href="#" class="list-group-item list-group-item-action">Citrus</a>
                                    <a href="#" class="list-group-item list-group-item-action disabled">Cut Fresh & Herbs</a>
                                 </div>
                              </div>
                           </div>
                        </div-->
                     </div>
                  </div>
				  <div class="left-ad mt-4">
				  <img class="img-fluid" src="http://via.placeholder.com/254x444" alt="">
				  </div>
               </div>
               <div class="col-md-9">
                  <a href="#"><img class="img-fluid mb-3" src="img/shop.jpg" alt=""></a>
                  <!--div class="shop-head">
                     <a href="#"><span class="mdi mdi-home"></span> Home</a> <span class="mdi mdi-chevron-right"></span> <a href="#">Fruits & Vegetables</a> <span class="mdi mdi-chevron-right"></span> <a href="#">Fruits</a>
                     <div class="btn-group float-right mt-2">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort by Products &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                           <a class="dropdown-item" href="#">Relevance</a>
                           <a class="dropdown-item" href="#">Price (Low to High)</a>
                           <a class="dropdown-item" href="#">Price (High to Low)</a>
                           <a class="dropdown-item" href="#">Discount (High to Low)</a>
                           <a class="dropdown-item" href="#">Name (A to Z)</a>
                        </div>
                     </div>
                     <h5 class="mb-3">Fruits</h5>
                  </div-->
                  <div class="row no-gutters">
                    <?php
                    $cat_id= $_REQUEST['cat_id'];
                    
                    if(!empty($cat_id))
                	    $filter = "";
                        $limit = "10";
                        $page_limit = 10;
                        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
                        $start_from = ($page-1) * $limit;
                        
                        // if($in_stock){
                        //     $filter .=" and products.in_stock = 1 ";
                        // }
                        if($cat_id!=""){
                            $filter .=" and products.category_id = '".$cat_id."' ";
                        }
                        //if($search!=""){
                            //$filter .=" and products.product_name like '".$search."' ";
                        //}
                
                        $query4="Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
                                inner join categories on categories.id = products.category_id
                                left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                                left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                               left join deal_product dp on dp.product_id=products.product_id where 1 ".$filter."LIMIT ".$limit." OFFSET ".$start_from ;
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
                        $category_id = $product['category_id'];
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
                     <div class="col-md-4">
                        <div class="product">
                           <a href="single.php?pid=<?= $product_id ?>">
                              <div class="product-header">
                                 <span class="badge badge-success">50% OFF</span>
                                 <img class="img-fluid" src="../uploads/products/<?= $product_image;  ?>" alt="">
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
                                      <input type="submit" class="btn btn-secondary btn-sm float-right" name="addd" value="Add"  /><i class="mdi mdi-cart-outline"></i>
                                  </form>
                                 <p class="offer-price mb-0"><?= $price ?> <i class="mdi mdi-tag-outline"></i><br><span class="regular-price"><?= $product['price']; ?></span></p>
                              </div>
                           
                        </div>
                     </div>
                     <?php } ?>
                     
                  </div>
                  <nav>
                     <ul class="pagination justify-content-center mt-4">
                        <?php  
                            $sql = "SELECT COUNT(product_id) FROM products where category_id='.$cat_id.'";  //where category_id='.$cat_id.'
                            $rs_result = mysqli_query($conn,$sql);  
                            $row = mysqli_fetch_row($rs_result);  
                            $total_records = $row[0];  
                            $total_pages = ceil($total_records / $limit);  
                            $pagLink = "<div class='pagination'>";  
                            for ($i=1; $i<=$total_pages; $i++) {  
                                         $pagLink .= "<li class='page-item '><span class='page-link'>
                                         <a href='shop.php?cate_id=".$cat_id."?page=".$i."'>".$i."</a><span class='sr-only'>(current)</span></span></li>";  
                            };  
                            echo $pagLink ;
                            // echo "<br>1->".$_SERVER['QUERY_STRING'];
                            // echo "<br>2->".$_server['request_uri'];
                            // echo "<br>3->".$_SERVER['REQUEST_URI'];
                            // echo "<br>4->".$_SERVER['PHP_SELF'];
                            // echo "<br>5->".$_REQUEST['cat_id'];
                            ?>

                        <!--li class="page-item active">
                           <span class="page-link">
                           2
                           <span class="sr-only">(current)</span>
                           </span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                           <a class="page-link" href="#">Next</a>
                        </li-->
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </section>
      <section class="product-items-slider section-padding bg-white border-top">
         <div class="container">
            <div class="section-header">
               <h5 class="heading-design-h5">Best Offers View <span class="badge badge-primary">20% OFF</span>
                  <a class="float-right text-secondary" href="shop.php">View All</a>
               </h5>
            </div>
            <div class="owl-carousel owl-carousel-featured">
               <div class="item">
                  <div class="product">
                     <a href="single.php">
                        <div class="product-header">
                           <span class="badge badge-success">50% OFF</span>
                           <img class="img-fluid" src="img/item/7.jpg" alt="">
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

