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
  
  <style type="text/css">
        .ui-datepicker-trigger{
            height: 25px !important;
            width: 25px !important
        }
        #ui-datepicker-div{
            background-color: #fff;
            padding:20px;
        }
        a.ui-datepicker-next.ui-corner-all {
            float: right;
        }
        .ui-datepicker-title
        {
            text-align:center;
        }
        th {
            text-align: center;
            padding:4px;
        }
        .ui-datepicker-next::after {
          content: " >>";
        }
        .ui-datepicker-prev::before {
          content: " <<";
        }
    </style>  
   
    
    
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

                 <?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('success_req'); 
                        $base=base_url();
                        $base=str_replace('store/','',$base);
                    ?>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("");?>:</h4>
                                    <!--<a class="button" style="" href="<?php echo site_url("admin/addcategories"); ?>">-->
                                    <!--    <?php echo $this->lang->line("DATE");?>-->
                                    <!--</a><BR>-->
                                    <form  method="post" action="">
                                        
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" name="from_date" class="form-control datepicker" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" name="to_date" class="form-control datepicker" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="row" style="display:none">
                                            <div class="col-md-12">
                                                
                                                <div class="card">
                                                    <div class="card-content">
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <legend><?php echo $this->lang->line("Progress Bars");?></legend>
                                                                <div class="progress progress-line-primary">
                                                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                                                                        <span class="sr-only">60% Complete</span>
                                                                    </div>
                                                                </div>
                                                                <div class="progress progress-line-info">
                                                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                                        <span class="sr-only">60% Complete</span>
                                                                    </div>
                                                                </div>
                                                                <div class="progress progress-line-danger">
                                                                    <div class="progress-bar progress-bar-success" style="width: 35%">
                                                                        <span class="sr-only">35% Complete (success)</span>
                                                                    </div>
                                                                    <div class="progress-bar progress-bar-warning" style="width: 20%">
                                                                        <span class="sr-only">20% Complete (warning)</span>
                                                                    </div>
                                                                    <div class="progress-bar progress-bar-danger" style="width: 10%">
                                                                        <span class="sr-only">10% Complete (danger)</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <legend><?php echo $this->lang->line("Sliders");?></legend>
                                                                <div id="sliderRegular" class="slider"></div>
                                                                <div id="sliderDouble" class="slider slider-info"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card -->
                                            </div>
                                        </div>
                                     <input type="submit" align="right" name="cod" value="<?php echo $this->lang->line("COD/SP");?>"  class="btn btn-fill btn-rose" >
                                    
                                      <input type="submit" align="right" name="prepaid" value="<?php echo $this->lang->line("PREPAID");?>"  class="btn btn-fill btn-rose" >
                                     <input type="submit" align="right" name="request" value="<?php echo $this->lang->line("REQUEST");?>"  class="btn btn-fill btn-rose" >
                                      <input type="submit" align="right" name="trans" value="<?php echo $this->lang->line("Transaction Details");?>"  class="btn btn-fill btn-rose" >
                                    </from>
                       
                                    <!--<a class="button" style="float: left;" href="<?php echo site_url("admin/addcategories"); ?>">-->
                                    <!--    <?php echo $this->lang->line("PREPAID");?></a><br>-->
                                       <!-- <a class="button" style="float: left;margin-top: -20px !important;margin-left: 40px;" href="<?php echo site_url("admin/addcategories"); ?>">-->
                                       <!--<?php echo $this->lang->line("COD/SP");?></a>-->
   
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                       <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%;padding-top: 50px !important;" >
                                            <thead>
                                                 <tr>
                                                    <th><?php echo $this->lang->line("ID");?></th>
                                                    <th><?php echo $this->lang->line("Store Name");?></th>
                                                    <th><?php echo $this->lang->line("Total Order");?></th>
                                                     <th><?php echo $this->lang->line("Order Date");?></th>
                                                    <th><?php echo $this->lang->line("Total Value");?></th>
                                                    <th><?php echo $this->lang->line("Commission");?></th>
                                                    <th  class=""><?php echo $this->lang->line("Status");?></th>
                                                    <!--<th class="text-right"><?php echo $this->lang->line("Action");?></th>-->
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                     <th><?php echo $this->lang->line("ID");?></th>
                                                    <th><?php echo $this->lang->line("Store Name");?></th>
                                                    <th><?php echo $this->lang->line("Total Order");?></th>
                                                    <th><?php echo $this->lang->line("Order Date");?></th>
                                                    <th><?php echo $this->lang->line("Total Value");?></th>
                                                    <th><?php echo $this->lang->line("Admin Commission");?></th>
                                                    <th  class=""><?php echo $this->lang->line("Status");?></th>
                                                    <!--<th class="text-right"><?php echo $this->lang->line("Action");?></th>-->
                                                </tr>
                                            </tfoot>
                                            
                                            <tbody>
												 
                                                <tr>
                                                 <?php foreach($all as $commision){
                                                     
                                                 ?>  
                                                 <td class="text-center"><?php echo $commision->id; ?></td>
                                                        <td class="text-center"><?php echo $commision->store_name; ?></td>
                                                        
                                                        <td class="text-center"><?php echo $commision->reason; ?></td>
                                                        <td class="text-center"><?php echo $commision->on_date; ?></td>
                                                        <td class="text-center"><?php echo $commision->amount; ?></td>
                                                        <td class="text-center"><?php echo $commision->admin_share; ?></td>
                                                          <td> <?php if($commision->status==0){?><span class='label label-danger'>Pending</span><?php }else{?><span class='label label-success'>Paid</span><?php }?></div></div></td>  
                                                 
                                                    </tr>
                                                
                                                <?php 
                                                }?> 
                                                
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
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery-ui.min.js"); ?>" type="text/javascript"></script>
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
<!--<script src="https://maps.googleapis.com/maps/api/js"></script>-->
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
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
</script>
 <style> 
 .circle {
   background-color: red;
  border-radius: 50%;
  width: 10px;
  height: 10px; 
 }
  .circle1 {
   background-color: grey;
  border-radius: 50%;
  width: 10px;
  height: 10px; 
 }
</html>



