<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("theme_admin")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("theme_admin")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <!--  Social tags      -->
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
    
     
    
    
</head>

<body>
    

    <div class="wrapper">
        <!-- side -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel" <?php if($this->session->userdata('language') == "arabic"){ echo 'style="float:left"'; } ?>>
            <!-- head-->
            <?php  $this->load->view("admin/common/header"); ?>
            <!-- content -->
            <div class="content">
                <div class="container-fluid">

                 
                    
                    <div class="row">
					
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
									<?php echo $this->session->flashdata("message"); ?>
                                    <h3 class="card-title"> <?php echo $this->lang->line("Orders :");?></h3>
                                    <div class="toolbar">
									
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                              <tr>
                                                    <th class="text-center"><?php echo "S.No."; ?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Phone");?> </th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Store");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Payment Method");?></th>
                                                    
												    <th class="text-center"> <?php echo $this->lang->line("Assign to");?></th>

                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>

												
											</tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center"><?php echo "S.No."; ?></th>
                                                     <th class="text-center"><?php echo $this->lang->line("Order");?>ID</th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Phone");?> </th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Store");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Payment Method");?></th>
                                                    <th class="text-center"> <?php echo $this->lang->line("Assign to");?></th>

                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php $i=1; foreach($today_orders as $order){ ?>
                                                <tr>
                                                    <div class="modal fade" id="myModal<?= $order->sale_id ?>" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" style="width:50%">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <!--<h4 class="modal-title">Modal Header</h4>-->
            </div>
            <div class="modal-body">
                
              <div class="col-md-12">
                  
                    <div class="box">
                        <div class="box-header">
                           
                        </div>
                        <div class="box-body">
                        <div class="form-group" style="display:none;">
                                            <input type="text" name="store_id_login" class="form-control" placeholder="00" value="<?= $store= $this->session->userdata('user_id') ?>"/>
                                        </div>
                            <form role="form" method="post" action="<?= site_url("users/assign/".$order->sale_id."/".$order->user_id."/".$store) ?>" >
                              <div class="box-body">
                              <?php 
                                echo $this->session->flashdata("message");
                               ?>
                               <?php if(isset($error) && $error!=""){
                            echo $error;
                            
                        } 
                        $q = $this->db->query("SELECT * FROM delivery_boy where store_id=".$store);
                              
                                $boy_rows = $q->result();
                                //print_r($boy_rows);
                              
                               ?>
                                <div class="form-group">
                                    <div class="row">
                                
                                    <div class="col-md-6">
                                        <label for="user_type">Select Delivery Boy</label>
                                        <select class="form-control select2" name="assign_to" id="assign_to" style="width: 100%;" required>
                                                <option value>- - Select Boy - - </option>
                                                <?php 
                                                    foreach($boy_rows as $boy){
                                                ?>
                                                <option value="<?= $boy->user_name ?>"><?= $boy->user_name ?></option>
                                               <?php } ?>
                                        </select>
                                    </div> 
                                    </div>
                                </div>
                               
                              </div><!-- /.box-body -->
            
                              <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                            </form>
                        </div>
                    </div>
                </div>  
                
            </div>
            <div class="modal-footer">
                
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $order->sale_id; ?></td>
                    <td><?php echo $order->user_fullname;?></td>
                    <td><?php echo $order->user_phone; ?></td>
                    <td><?php echo $order->on_date.'<br>'.date("H:i A", strtotime($order->delivery_time_from))." - ".date("H:i A", strtotime($order->delivery_time_to)); ; ?></td>
                    <td><?php echo $order->total_amount; ?></td>
                    <td><?php echo $order->new_store_id ?></td>
                    <td><?php echo $order->payment_method;; ?></td>
                    <td><?php echo $order->assign_to; ?></td>
                    <td>
                    <?php 
                        if($order->status == 0){
                            echo "<span class='label label-default'>Pending</span>";
                        }else if($order->status == 1){
                            echo "<span class='label label-success'>Confirm</span>";
                        }else if($order->status == 2){
                            echo "<span class='label label-info'>Picked Up</span>";
                        }else if($order->status == 3){
                            echo "<span class='label label-danger'>cancel</span>";
                        }else if($order->status == 4){
                            echo "<span class='label label-success'>Complete</span>";
                        }else if($order->status == 5){
                            echo "<span class='label label-info'>Ready To Pickup</span>";
                        }  ?>

                    
                    <input type="hidden" name="t1" value="<?php echo $order->user_id; ?>">

                    </td>
                    <td><a href="<?php echo site_url("admin/orderdetails/".$order->sale_id); ?>" class="btn btn-success"> <?php echo $this->lang->line("Details");?></a>
<div class="dropdown">
  <button class="btn btn-success dropdown-toggle" type="button"   data-toggle="dropdown"> <?php echo $this->lang->line("Action");?>
  <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <div class="container">
  <!--<h2>Large Modal</h2>-->
  <!-- Trigger the modal with a button -->
  <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Large Modal</button>-->

  <!-- Modal -->
  
    </div>
        
        <?php if($order->status == 0)
        {
            
             echo "<li><a href='".site_url("admin/cancle_order/".$order->sale_id)."'>Cancel</a></li>";
             
            
            echo "<li><a href='".site_url("admin/confirm_order/".$order->sale_id)."'>Confirm</a></li>";
            
        }
                    
            else if($order->status == 1)
            
            {
                // echo "<li><a  data-toggle='modal' data-target='#myModal".$order->sale_id."' href='$order->sale_id'>Assign Order</a></li>";
                echo "<li><a href='".site_url("admin/delivered_order/".$order->sale_id)."'>Ready to Pick Up</a></li>";
            
            } 
            
            else if($order->status == 5)
            
            {
                //  echo "<li><a href='".site_url("admin/delivered_order/".$order->sale_id)."'>Out</a></li>";
               echo "<li><a href='".site_url("users/delivered_order_complete/".$order->sale_id)."'>Complete</a></li>";
            } 
            // if($order->assign_to=="0"){
												// echo "<li><a href='".site_url("users/assign/".$order->sale_id)."'>Assign Order</a></li>";
												// }
            
            ?>
    <li><a href="<?php echo site_url("admin/delete_order/".$order->sale_id); ?>"> <?php echo $this->lang->line("Delete");?></a></li>
  </ul>
</div>



                    </td>
                </tr>
            <?php $i++;
          }
          ?>
                                            </tbody>
											</table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    

                </div>
            </div>
            <!-- Foot -->
            <?php  $this->load->view("admin/common/common_footer") ?>
        </div>
    </div>
    <!-- content -->
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>
<!--   Core JS Files   -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery-3.1.1.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery-ui.min.js" ); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/bootstrap.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/material.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/perfect-scrollbar.jquery.min.js"); ?>" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.validate.min.js"); ?>"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/moment.min.js"); ?>"></script>
<!--  Charts Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/chartist.min.js"); ?>"></script>
<!--  Plugin for the Wizard -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.bootstrap-wizard.js"); ?>"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/bootstrap-notify.js"); ?>"></script>
<!--   Sharrre Library    -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.sharrre.js"); ?>"></script>
<!-- DateTimePicker Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/bootstrap-datetimepicker.js"); ?>"></script>
<!-- Vector Map plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery-jvectormap.js"); ?>"></script>
<!-- Sliders Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/nouislider.min.js"); ?>"></script>
<!--  Google Maps Plugin    -->
<!--<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.select-bootstrap.js"); ?>"></script>-->
<!-- Select Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.select-bootstrap.js"); ?>"></script>
<!--  DataTables.net Plugin    -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.datatables.js"); ?>"></script>
<!-- Sweet Alert 2 plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/sweetalert2.js"); ?>"></script>
<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jasny-bootstrap.min.js"); ?>"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/fullcalendar.min.js"); ?>"></script>
<!-- TagsInput Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.tagsinput.js"); ?>"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/material-dashboard.js"); ?>"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        demo.initVectorMap();
    });
</script>

    
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            } );
        } );
    </script>
</html>

















