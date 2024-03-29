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
                                            <input type="text" name="store_id_login" class="form-control" placeholder="00" value="<?=_get_current_user_id($this);?>"/>
                                        </div>
                            <!--////-->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose" style=>
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Add Product");?></h4>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 "><?php echo $this->lang->line("Product Name");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="prod_title" placeholder="Product Title" class="form-control" required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        <!--.........-->
                                         <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Parent Category :");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px;">
                                                    <label class="control-label"></label>
                                                    <select class="text-input form-control" name="parent" required>
                                                        <option id="<?= $store ?>" value=""><?php echo $this->lang->line("Select Category");?></option>
                                                        <?php  
                                                            
                                                            echo printCategory(0,0,$this,$store);
                                                            function printCategory($parent,$leval,$th,$store){
                                                           
                                                            $q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`status`=1 and a.`parent`=" . $parent." AND a.store_id_login=".$store);
                                                            $rows = $q->result();
                                    
                                                            foreach($rows as $row){
                                                                if ($row->count > 0) {
                                                                        
                                                                            //print_r($row) ;
                                                                            //echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
                                                                            printRow($row,true);
                                                                            printCategory($row->id, $leval + 1,$th,$store);
                                                                            
                                                                        } elseif ($row->count == 0) {
                                                                            printRow($row,false);
                                                                            //print_r($row);
                                                                        }
                                                                }
                                    
                                                            }
                                                             
                                                            function printRow($d,$bool){
                                                                  
                                                           // foreach($data as $d){
                                                            ?>
                                                            <option value="<?php echo $d->id; ?>" <?php if($d->parent == "0" && $d->leval == "0" && $bool){echo "disabled";} ?> <?php if(isset($_REQUEST["parent"]) && $_REQUEST["parent"]==$d->id){echo "selected"; } ?> ><?php for($i=0; $i<$d->leval; $i++){ echo "_"; } echo $d->title; ?></option>
                                                                
                                                             <?php } ?> 
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Description");?></label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px;">
                                                    <textarea name="product_description" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;  " required></textarea>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Image");?>:</label>
                                            <div class="col-md-9">
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img width="100%" height="100%" src="" />
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            
                                                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                            <input type="file" name="prod_img" required>
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                <input type="radio" name="prod_status" value="1"  checked/>
                                                <label style="margin-left:20px"><?php echo $this->lang->line("In Stock");?></label>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                <input type="radio" name="prod_status"  value="0"  />
                                                <label style="margin-left:20px"><?php echo $this->lang->line("Deactive"); ?></label>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <!--.....-->
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("mrp");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px;">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="mrp"  class="form-control" placeholder="00.00" required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        <div class="row" style="margin-top: -10px;">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Price");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px;">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="price"  class="form-control" placeholder="00.00" required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        <!--<div class="row" style="margin-top: -10px;">-->
                                        <!--    <label class="col-md-3 label-on-left"><?php echo $this->lang->line("TAX (%)");?>: *</label>-->
                                        <!--    <div class="col-md-9">-->
                                        <!--        <div class="form-group label-floating is-empty" style="margin-top: -10px;">-->
                                        <!--            <label class="control-label"></label>-->
                                        <!--            <input type="text" name="tax"  class="form-control" placeholder="00.00"/>-->
                                        <!--        <span class="material-input"></span></div>-->
                                        <!--    </div>-->
                                        <!--</div>-->

                                        <div class="row" style="margin-top: -10px;">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Unit");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px;">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="qty" class="form-control" placeholder="00" required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                          
                                        <div class="row" style="margin-top: -10px;">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Unit Value");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px;">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="unit" class="form-control" placeholder="KG/ BAG/ NOS/ QTY / etc " required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                       
                                        
                                        <!--<div class="row" style="margin-top: -10px;">-->
                                        <!--    <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Rewards");?> :</label>-->
                                        <!--    <div class="col-md-9">-->
                                        <!--        <div class="form-group label-floating is-empty" style="margin-top: -10px;">-->
                                        <!--            <label class="control-label"></label>-->
                                        <!--            <input type="text" name="rewards" class="form-control" placeholder="00"/>-->
                                        <!--        <span class="material-input"></span></div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                          <div class="row" style="margin-top: -10px;">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Stock Qty");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty" style="margin-top: -10px;">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="stk_qty" class="form-control" placeholder="00" required/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <!--....-->
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button" style="margin-top: -10px;">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="addcatg" value="<?php echo $this->lang->line("Add Product");?>">
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
</html>



