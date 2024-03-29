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
                <?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('message'); 
                    ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("All Users");?></h4>
                                    <!--<a class="pull-right" href="<?php echo site_url("users/add_user"); ?>"><?php echo $this->lang->line("ADD NEW STORE");?></a>-->
                                
                                        
                                        
                                     <input type="submit" align="right" name="cod" value="<?php echo $this->lang->line("COD/SP");?>"  class="btn btn-fill btn-rose" >
                                    
                                      <input type="submit" align="right" name="prepaid" value="<?php echo $this->lang->line("PREPAID");?>"  class="btn btn-fill btn-rose" >
                                     <!--<input type="submit" align="right" name="request" value="<?php echo $this->lang->line("REQUEST");?>"  class="btn btn-fill btn-rose" >-->
                                     
                                    </from>
                                      
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables" style="margin-top: 50px;">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                
                                                    <th><?php echo $this->lang->line("ID");?></th>
                                                    <th><?php echo $this->lang->line("Store Name");?></th>
                                                    <th><?php echo $this->lang->line("Total Order");?></th>
                                                    <th><?php echo $this->lang->line("Total Value");?></th>
                                                    <th><?php echo $this->lang->line("Store Commission");?></th>
                                                    <!--<th><?php echo $this->lang->line("Status");?></th>-->
                                                    <th><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                     <th><?php echo $this->lang->line("ID");?></th>
                                                    <th><?php echo $this->lang->line("Store Name");?></th>
                                                    <th><?php echo $this->lang->line("Total Order");?></th>
                                                    <th><?php echo $this->lang->line("Total Value");?></th>
                                                    <th><?php echo $this->lang->line("Store Commission");?></th>
                                                    <!--<th><?php echo $this->lang->line("Status");?></th>-->
                                                    <th><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            
                                            <tbody>
												 
                                                <tr>
                                                 <?php foreach($sum as $cod){
                                                     
                                                 ?>  
                                                 
                                                        <td><?php echo $cod->store_id; ?></td>
                                                        
                                                        <td><?php echo $cod->store_name; ?></td>
                                                        <td class="text-center"><?php echo count($sum) ?></td>
                                                        <td class="text-center"><?= $cod->amt ?></td>
                                                        <td class="text-center"><?= $cod->Admin_Share ?></td>
                                                        <td>
                                                          <form  method="post" action="<?= site_url("users/store_request")?>">
                                                        
                                       <input type="hidden"  name="from_date" value="<?php echo $from_date?>" >
                                        <input type="hidden"  name="to_date" value="<?php echo $to_date?>" >
                                        
                                        <input type="hidden"  name="amount" value="<?php echo $cod->amt?>" >
                                        <input type="hidden"  name="admin_share" value="<?php echo $cod->Admin_Share?>" >
                                        <?php $id=$cod->store_id?>
                                        <input type="hidden"  name="id" value="<?php echo $id?>" >
                                        <?php if($cod->payment_request=="0"){?>
                                        <input type="submit"  name="t1" value="<?php echo $this->lang->line("Request Proceeds");?>"class="btn btn-fill btn-rose">
                                        <?php }else{
                                             $amt=$cod->amt;
                                          
                                             if($amt>0){?>
                                        
                                        <input type="submit"  name="t1" value="<?php echo $this->lang->line("Send Request");?>"class="btn btn-fill btn-rose"></td><?php }
                                           
                                                else
                                        {
                                        }
                                        }
                                        ?>
                                                        <!--<button type="submit" name="testing">demo</button></td>-->
                                                        </form> 
                                                 
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

</html>