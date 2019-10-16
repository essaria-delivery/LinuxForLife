<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="//www.creative-tim.com/product/material-dashboard-pro" />

    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />

   
</head>

<body>
    <div class="wrapper">
        <!--sider -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        
        <div class="main-panel">
            <!--head -->
            <?php  $this->load->view("admin/common/header"); ?>
            <!--content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        
                      <div class="col-md-6">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
								    <?php echo $this->session->flashdata("message"); ?>
                                    <h4 class="card-title"> <?php echo $this->lang->line("Admin");?>
                        <small>  <?php echo $this->lang->line("List");?></small>:</h4>
                       
                    


                        <input type="submit" align="right" name="saveslider" value="<?php echo $this->lang->line("Payment");?>"  class="btn btn-fill btn-rose" data-toggle="modal" data-target="#myModal">
                       
                        <!--start mine-->
                        <div class="card-content">
                                    <!--<h4 class="card-title"><?php echo $this->lang->line("All Products");?></h4>-->
                                  <a class="pull-left" href="<?php echo site_url("admin/payment_from_store/".$id); ?>"><?php echo $this->lang->line("Payment");?></a>
                        
                        <!--end mine-->
                        
                        
                        
                        
                        
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                <th class="text-center"><?php echo $this->lang->line("Store ID");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Total Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Reason");?></th>
                                                    <th class=""><?php echo $this->lang->line("Status");?></th>
                                                  
                                            </tr>
                                            </thead>
                                            
                                            <tfoot>
                                               <tr>
                                                <?php foreach($sum_online as $online){ ?>
                                                 
                                                     
                                                     <th class="text-center"><?php echo $this->lang->line("Store ID");?></th>
                                                     <?php $no_amount=0;?>
                                                    <th class="text-center"><?php echo $this->lang->line("Net Total Amount");?>:<?php echo $this->config->item("currency");?>
                                                     <?php if($online->AMOUNT>$no_amount){?>
                                                    <?php echo $online->AMOUNT; ?>
                                                    
                                                     <?php 
                                                        
                                                      }
                                                      else 
                                                     {
                                                         echo "$no_amount";
                                                     } 
                                                     ?>
                                                    </th>
                                                    
                                                    <th class="text-center"><?php echo $this->lang->line("Reason");?></th>
                                                    <th class=""><?php echo $this->lang->line("Status");?></th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                                 <?php foreach($comms as $comm){?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $comm->store_id; ?></td>
                                                        
                                                        <td class="text-center"><?php echo $comm->amount; ?></td>
                                                        <td class="text-center"><?php echo $comm->reason; ?></td>
                                                         <td class="text-center"> <?php if($comm->status==0){?><div class="circle"><?php }else{?><div class="circle1"><?php }?></div></div></td>
                                                              
                                                    </tr>
                                                <?php } 
                                                }?>
                                           
                                            </tbody>
   
											</table>
	 <!--paypal start    
                 -->
             <?php if($online->AMOUNT>$no_amount)
                        {
                        ?> 
    <div class="modal fade" id="myModal" role="dialog">
      
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <!--<h4 class="modal-title">Modal Header</h4>-->
    
    
        <div class="col-md-6">
            <form  method="post" action='https://www.paypal.com/cgi-bin/webscr'
      id="payPalForm">
              <input type="hidden" name="email" value="<?php echo $client_id?>">
              <input type="hidden" name="login_password" value="1234">
              <!--<input type="hidden" name="name" value="<?php echo $comm->store_id;?>">-->
              
              <input type="hidden" name="price" value="<?php echo $online->AMOUNT;?>">
              
              <input type="hidden" name="business" value="<?php echo $client_id?>">
          <input type="hidden" name="cmd" value="_xclick">
          <input type="hidden" name="upload" value="1" /> 
         
          <input type="hidden" name="reason" value="test">
          <input type="hidden" name="amount" value="<?php echo $online->AMOUNT;?>">
          <input type="hidden" name="no_shipping" value="1">
          <input type="hidden" name="currency_code" value="INR">
          <input type="hidden" name="cancel_return" value="<?php echo base_url();?>photos/cancel">
          <input type="hidden" name="return" value="<?php echo base_url();?>photos/return/">
          
           <button type="submit" name="submit" id="save" onclick="submitTwicechk(this.form);" style="background: transparent;border: none;"><img src="<?php echo base_url();?>uploads/paypal.jpg" width="100%" height="100%" style="margin-top: 13px"></button>
           

            </form>
            
          </div>
          <style>
            .razorpay-payment-button{
                display:none !important;
            }
          </style>
<div class="col-md-6">
            <form action="<?php echo base_url();?>" method="POST">
 <!--Note that the amount is in paise = 50 INR -->
 <?php $amt=$online->AMOUNT*100 ?>
<script src="https://checkout.razorpay.com/v1/checkout.js" data-key="rzp_test_OjqPWNjTS6DCNH" data-amount="<?= $amt ?>" data-buttonimage="" data-name="Merchant Name" data-description="Purchase Description" data-image="https://your-awesome-site.com/your_logo.jpg" data-prefill.name="car" data-prefill.email="test@test.com" data-theme.color="#F37254"></script>
    <input type="hidden" value="Hidden Element" name="hidden">
    <button type="submit">
              <img src="<?php echo base_url();?>uploads/razorpay.jpg" width="100%" height="80%" style="margin-top:4px;">
            </button>
          
    </form>
            
          </div>
                                             
                                </div>
                                       
                                    <div class="modal-footer" style="margin-top: 200px;">
                                          <button type="button" class="btn btn-default" style="margin-top:10px" data-dismiss="modal">Close</button>
                                                     </div>
                                      </div>
                                                                           
                                    </div>

                                  </div>
    
    <?php 
                            

                        }
                        else
                        {
                        ?> 
    <div class="modal fade" id="myModal" role="dialog">
      
                                    <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title"> NO Amount for Pay </h4>
    
    
        <div class="col-md-6">
            <form  method="post" action='https://www.paypal.com/cgi-bin/webscr'
      id="payPalForm">
             
         
           

            </form>
            
          </div>
         
<div class="col-md-6">
            <form action="<?php echo base_url();?>" method="POST">
 <!--Note that the amount is in paise = 50 INR -->
 
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    
   
          
    </form>
            
          </div>
                                             
                                </div>
                                       
                                    <div class="modal-footer" style="margin-top: 40px;">
                                          <button type="button" class="btn btn-default" style="margin-top:-33px" data-dismiss="modal">Close</button>
                                                     </div>
                                      </div>
                                                                           
                                    </div>

                                  </div>
    
    <?php 
                            

                        }
                        ?>
                             
     
    <!--paypal end-->										
									</div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    
                    
        <div class="col-md-6">
          <div class="card">
                                <div class="card-header card-header-icon" data-background-color="red">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
								    <?php echo $this->session->flashdata("message"); ?>
                                    <h4 class="card-title"> <?php echo $this->lang->line("Store");?>
                        <small>  <?php echo $this->lang->line("List");?></small>:</h4>
                        
                        <!--start mine-->
                        <div class="card-content">
                        
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                 <th class="text-center"><?php echo $this->lang->line("Store ID");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Total Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Reason");?></th>
                                                    <th class=""><?php echo $this->lang->line("Status");?></th>
                                                
                                            </tr>
                                            </thead>
                                            <tfoot>
                                               <tr>
                                                <?php foreach($sum as $summ){ ?>
                                                 
                                                     
                                                     <th class="text-center"><?php echo $this->lang->line("Store ID");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Net Total Amount");?>:<?php echo $this->config->item("currency");?>
                                                    <?php echo $summ->AMOUNT; ?></th>
                                                    
                                                    <th class="text-center"><?php echo $this->lang->line("Reason");?></th>
                                                    <th class=""><?php echo $this->lang->line("Status");?></th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                                 <?php foreach($commission as $commision){
                                                 ?>
                                                        <td class="text-center"><?php echo $commision->store_id; ?></td>
                                                        
                                                        <td class="text-center"><?php echo $commision->amount; ?></td>
                                                        <td class="text-center"><?php echo $commision->reason; ?></td>
                                                         <td class="text-center"> <?php if($commision->status==0){?><div class="circle"><?php }else{?><div class="circle1"><?php }?></div></div></td>  
                                                 
                                                    </tr>
                                                
                                                <?php 
                                                }}?> 
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
                    
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->
                </div>
            </div>
            
            
            <!--footer -->
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <!--fixed -->
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>     
            <!--end other table-->
<!--   Core JS Files   -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery-3.1.1.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery-ui.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/bootstrap.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/material.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/perfect-scrollbar.jquery.min.js"); ?>" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.validate.min.js"); ?>"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/moment.min.js"); ?>"></script>
<!--  Charts Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/chartist.min.js"); ?>"></script>
<!--  Plugin for the Wizard -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.bootstrap-wizard.js"); ?>"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/bootstrap-notify.js"); ?>"></script>
<!--   Sharrre Library    -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.sharrre.js"); ?>"></script>
<!-- DateTimePicker Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/bootstrap-datetimepicker.js"); ?>"></script>
<!-- Vector Map plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery-jvectormap.js"); ?>"></script>
<!-- Sliders Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/nouislider.min.js"); ?>"></script>
<!--  Google Maps Plugin    -->
<!--<script src="https://maps.googleapis.com/maps/api/js"></script>-->
<!-- Select Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.select-bootstrap.js"); ?>"></script>
<!--  DataTables.net Plugin    -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.datatables.js"); ?>"></script>
<!-- Sweet Alert 2 plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/sweetalert2.js"); ?>"></script>
<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jasny-bootstrap.min.js"); ?>"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/fullcalendar.min.js"); ?>"></script>
<!-- TagsInput Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.tagsinput.js"); ?>"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/material-dashboard.js"); ?>"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>


  <style> 
 .circle {
   background-color: red;
  border-radius: 50%;
  width: 20px;
  height: 20px; 
 }
  .circle1 {
   background-color: grey;
  border-radius: 50%;
  width: 20px;
  height: 20px; 
 }
  </style>






</html>