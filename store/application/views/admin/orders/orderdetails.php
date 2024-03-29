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
        <!--sider -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        
        <div class="main-panel">
            <!--head -->
            <?php  $this->load->view("admin/common/header"); ?>
            <!--content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Order Detail");?></h4>
                                    <!--a class="pull-right" href="<?php echo site_url(""); ?>">ADD NEW STORE</a-->
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="3" class="text-center"><?php echo $this->lang->line("Order Details");?></th>
                                                    
                                                    <!--th class="text-center" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th-->
                                                </tr>
                                            </thead>
                                            <!--tfoot>
                                                <tr>
                                                    <th class="text-center">Product Name</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Start Date</th>
                                                    <th class="text-center">Start Time</th>
                                                    <th class="text-center">End Date</th>
                                                    <th class="text-center">End Time</th>
                                                    <th class="text-center">Expire</th>
                                                    <th class="text-center" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot-->
                                            <tbody>
                                                <tr>
                                                    <td colspan="3">
                                                        <table class="table">
                                                            <tr>
                                                                <td valign="top">
                                                                <strong> <?php echo $this->lang->line("Order Id : ");?><?php echo $order->sale_id; ?></strong>
                                                                <br />

                                                                <strong>  <?php echo $this->lang->line("Order Date : ");?><?php echo $order->on_date; ?></strong>
                                                                <br />

                                                                </td>
                                                                <td>
                                                                    <strong> <?php echo $this->lang->line("Delivery Details :");?></strong><br />
                                                                    <strong>  <?php echo $this->lang->line("Contact : ");?><?php echo $order->user_fullname ; ?>, <br/> <?php echo $this->lang->line("Contact : ");?> <?php echo $order->user_phone; ?></strong>
                                                                    <br />
                                                                    <strong>  <?php echo $this->lang->line("Address :");?></strong>
                                                                    <address>
                                                                        <?php echo $order->socity_name; ?><br />
                                                                        <?php echo $order->house_no; ?>
                                                                    </address>
                                                                    <br />
                                                                     <?php echo $this->lang->line("Delivery Time :");?> <?php echo $order->delivery_time_from." to ".$order->delivery_time_to; ?></p>
                                                                 </td>
                                                                
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th><?php echo $this->lang->line("Product Name");?></th>
                                                    <th><?php echo $this->lang->line("Qty");?></th>
                                                    <th> <?php echo $this->lang->line("Total Price");?><?php echo $this->config->item("currency");?></th>
                                                </tr>
                                                <?php
                                                    $total_price = 0;
                                                    foreach($order_items as $items){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $items->product_name; ?><br />
                                                            <?php echo $items->unit_value." ".$items->unit. " (".$this->config->item("currency")." $items->price ) "; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $items->qty ; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $items->qty * $items->price;
                                                                $total_price = $total_price + ($items->qty * $items->price);
                                                                 ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                ?>
                                                <tr>
                                                    <td colspan="2"><strong class="pull-right"> <?php echo $this->lang->line("Total :");?></strong></td>
                                                    <td >
                                                        <strong class=""><?php echo $total_price; ?>  <?php echo $this->config->item("currency");?></strong>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2"><strong class="pull-right"><?php echo $this->lang->line("Delivery Charges");?> :</strong></td>
                                                    <td >
                                                        <strong class=""><?php echo $order->delivery_charge; ?> <?php echo $this->config->item("currency");?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><strong class="pull-right"><?php echo $this->lang->line("Net Total Amount");?> :</strong></td>
                                                    <td >
                                                        <strong class=""><?php echo $net = $total_price + $order->delivery_charge; ?><?php echo $this->config->item("currency");?> </strong>
                                                    </td>
                                                </tr>
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
                    <!-- end row -->
                </div>
            </div>
            <!--footer -->
            <?php  $this->load->view("admin/common/footer"); ?>
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


































