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
                                $base=base_url();
                                $base=str_replace('store/','',$base);

                            ?>
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                            <?php if($this->session->userdata('language') == "arabic"){ ?>
                            <div class="col-md-3">
                            </div>
                            <?php } ?>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose" style=>
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Edit Store");?></h4>
                                    <div class="form-group" style="display:none;">
                                            <input type="text" name="store_id_login" class="form-control" placeholder="00" value="<?= $store= $this->session->userdata('user_id') ?>" required/>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 "><?php echo $this->lang->line("Store Name");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px">
                                                    <label class="control-label"></label>
                                                    <input type="text" id="user_fullname" name="user_fullname" value="<?php echo $user->user_fullname; ?>" placeholder="Store Name" class="form-control" required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 "><?php echo $this->lang->line("Store Owner");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px">
                                                    <label class="control-label"></label>
                                                    <input type="text" id="emp_fullname" name="emp_fullname" value="<?php echo $user->user_name; ?>" placeholder="Store Owner Name" class="form-control" required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 "><?php echo $this->lang->line("Mobile No");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" 
                                            id="mobile" name="mobile" value="<?php echo $user->user_phone; ?>" placeholder="Mobile No" required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                             <label class="col-md-3 label-on-left"><?php echo $this->lang->line("City");?>: *</label>
                                             <div class=" pac-card col-md-9" >
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px">
                                                    <label class="control-label"></label>
                                                    <input id="searchInput"  type="text"  name="city" class="form-control" placeholder="Enter a location" value="<?php echo $user->user_city; ?>" required>
                                                 
 
                                                    <div id="map" style="margin: 0px;">
                                                        <div id="infowindow-content">
                                                          <img src="" width="16" height="16" id="place-icon">
                                                          <span id="place-name"  class="title"></span><br>
                                                          <span id="place-address"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                        
                                        </div>
                                    </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 "><?php echo $this->lang->line("Email");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px">
                                                    <label class="control-label"></label>
                                                    <input type="email" class="form-control" value="<?php echo $user->user_email; ?>" id="user_email" name="user_email" placeholder="user@gmail.com" required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 "><?php echo $this->lang->line("Password");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px">
                                                    <label class="control-label"></label>
                                                    <input type="password" value="<?php echo $user->user_password; ?>" class="form-control" id="user_password" name="user_password" placeholder="password" required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="row"  style="margin-top: 50px">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Store Logo");?></label>
                                            <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail img-circle">
                                                    <img src="<?= $base.'uploads/profile/'.$user->user_image; ?>" alt="">
                                                   
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail img-circle" style=""></div>
                                                <div>
                                                    <span class="btn btn-round btn-rose btn-file">
                                                        <span class="fileinput-new"><?php echo $this->lang->line("Add Photo");?></span>
                                                        <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                        <input type="file" name="pro_pic">
                                                    <div class="ripple-container"></div></span>
                                                    <br>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 58.6719px; top: 35px; background-color: rgb(255, 255, 255); transform: scale(15.5488);"></div></div></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Main Banner");?></label>
                                            <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail img-circle">
                                                    <img src="<?= $base.'uploads/profile/'.$user->user_main_banner; ?>" alt="">
                                                    
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail img-circle" style=""></div>
                                                <div>
                                                    <span class="btn btn-round btn-rose btn-file">
                                                        <span class="fileinput-new"><?php echo $this->lang->line("Add Photo");?></span>
                                                        <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                        <input type="file" name="main_banner">
                                                    <div class="ripple-container"></div></span>
                                                    <br>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 58.6719px; top: 35px; background-color: rgb(255, 255, 255); transform: scale(15.5488);"></div></div></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="row" style="margin-top: 50px">-->
                                        <!--    <label class="col-md-3 "><?php echo $this->lang->line("Status");?> *</label>-->
                                        <!--    <div class="col-md-9">-->
                                        <!--        <div class="form-group label-floating is-empty" style="margin-top: -10px">-->
                                        <!--            <label class="control-label"></label>-->
                                        <!--           <input type="checkbox" class="form-control" id="status" name="status" style="width:50%;margin-top:4px;margin-left:-115px" <?php echo ($user->user_status == 1) ? "checked" : ""; ?>/>-->
                                        <!--        <span class="material-input"></span></div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="addcatg" value="<?php echo $this->lang->line("Submit");?>">
                                                </div>
                                            </div>
                                        </div>
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
    <style>
        .btn-group {
       
           margin: 0;
          padding: 5px;
       }
        
        
        
    </style>
    
    
</html>



