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
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('message'); 
                    ?>
                            <?php
                                $store=$this->session->userdata('user_id');
                                $q = $this->db->query("SELECT * FROM `language_setting`  WHERE `id`=1 " );
                                $rows = $q->row();
                                if($rows->status==1)
                                {
                                    $setting=0;
                                }
                                else
                                {
                                    $setting='style="display:none"';
                                }
                            ?>
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <?php if($this->session->userdata('language') == "arabic"){ ?>
                            <div class="col-md-3">
                            </div>
                            <?php } ?>
                            <!--/////-->
                            <div class="form-group" style="display:none;">
                                            <input type="text" name="store_id_login" class="form-control"  value="<?=_get_current_user_id($this);?>"/>
                                        </div>
                            <!--////-->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose" style=>
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("");?></h4>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3" style="margin-left:156px;margin-top: -35px;"><?php echo $this->lang->line("Message");?> </label>
                                            <label class="col-md-3" style="margin-left:279px;margin-top: -35px;"><?php echo $this->lang->line("Email");?> </label>
                                            </div>
                                          
                                         <div class="row">
                                            <label class="col-md-2 form-group label-on-left"><?php echo $this->lang->line("New Order");?></label>
                                            
                                             <div class="col-md-2" >
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="checkbox" name="order_sms" class="form-control"
                                                    <?php 
                                                    if($message->msg_new_order==1)
                                                    {
                                                       ?>checked   /> 
                                                    
                                                    <?php }?>
                                                    
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="checkbox" name="order_mail" class="form-control" 
                                                     <?php 
                                                    if($message->mail_new_order==1)
                                                    {
                                                       ?>checked   /> 
                                                    
                                                    <?php }?>
                                                    
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                            
                                         </div>  
                                         <div class="row">
                                            <label class="col-md-2 form-group label-on-left"><?php echo $this->lang->line("Order Assign");?></label>
                                            
                                             <div class="col-md-2" >
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="checkbox" name="assign_sms"  class="form-control"
                                                     <?php 
                                                    if($message->msg_order_assign==1)
                                                    {
                                                       ?>checked   /> 
                                                    
                                                    <?php }?>
                                                    
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="checkbox" name="assign_mail" class="form-control"
                                                      <?php 
                                                    if($message->mail_order_assign==1)
                                                    {
                                                       ?>checked   /> 
                                                    
                                                    <?php }?>
                                                    
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                            
                                         </div>  
                                         <div class="row">
                                            <label class="col-md-2 form-group label-on-left"><?php echo $this->lang->line("Compelete Order");?></label>
                                            
                                             <div class="col-md-2" >
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="checkbox" name="complete_sms"  class="form-control"   <?php 
                                                    if($message->msg_complete_order==1)
                                                    {
                                                       ?>checked   /> 
                                                    
                                                    <?php }?>
                                                    
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="checkbox" name="complete_mail" class="form-control" <?php 
                                                    if($message->mail_complete_order==1)
                                                    {
                                                       ?>checked   /> 
                                                    
                                                    <?php }?>
                                                    
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                            
                                         </div>  
                                       
                                                
                                          <div class="row" style="margin-top: 40px">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button" style="margin-top: -10px;">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="alert" value="<?php echo $this->lang->line("Submit");?>">
                                                </div>
                                            </div>
                                        </div>      
                                            </div>
                                        </div>
                                        
                                        <!--.........-->
                                        
                                        <!--....-->
                                        
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    
                    
                </div>
            </div>
            
            
           
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    
    
    
    
    <?php  $this->load->view("admin/common/fixed"); ?>

</body>
<!--   Core JS Files   -->
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



