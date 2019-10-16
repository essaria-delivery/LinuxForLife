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
                                    <h4 class="card-title"><?php echo $this->lang->line("Request");?>:<small><b>Store To Admin</b></small></h4>
                                    
                                     
                                    </from>
                                      
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables" style="margin-top: 50px;">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                              
                                                 <tr>
                                                    <th><?php echo $this->lang->line("From Date");?></th>
                                                     <th><?php echo $this->lang->line("To Date");?></th>
                                                     <th><?php echo $this->lang->line("Total Amount");?></th>
                                                    <th><?php echo $this->lang->line("Store Share");?></th>
                                                    <th><?php echo $this->lang->line("Create By");?> </th>
                                                    <th><?php echo $this->lang->line("Create To");?></th>
                                                    <th><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                     <th><?php echo $this->lang->line("From Date");?></th>
                                                     <th><?php echo $this->lang->line("To Date");?></th>
                                                     <th><?php echo $this->lang->line("Total Amount");?></th>
                                                    <th><?php echo $this->lang->line("Store Share");?></th>
                                                    <th><?php echo $this->lang->line("Create By");?> </th>
                                                    <th><?php echo $this->lang->line("Create To");?></th>
                                                    
                                                    <th><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            
                                            <tbody>
											     <tr>
											         <?php foreach($req_online as $req_online)
											         { ?>
                                                      <td><?php echo $req_online->from_date; ?></td>
                                                      <td><?php echo $req_online->to_date; ?></td>
                                                      <td><?= $req_online->amount ?></td>
                                                      <td><?= $req_online->admin_share ?></td>
                                                      <td><?= $req_online->create_by_store_name ?></td>
                                                      <td><?= $req_online->create_to ?></td>
                                                       <td>
                                                       <input type="submit" name="" value="<?php echo $this->lang->line("Bank Transfer");?>"  class="btn btn-fill btn-rose" data-toggle="modal" data-target="#myModal"></td>
                                                       </tr>
             <div class="container">
  <!--<h2>Large Modal</h2>-->
  <!-- Trigger the modal with a button -->
  <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Large Modal</button>-->

  <!-- Modal -->
  <?php 
             $no_amount=0;
             if($req_online->amount>$no_amount)
                        {
                        ?> 
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Transaction ID</h4>
        </div>
        <div class="modal-body">
         <form role="form" method="post" action="<?= site_url("users/pay_from_store/".$req_online->create_by)?>">
        <div class="col-md-9">
            <div class="form-group label-floating is-empty" style="margin-top: -10px">
                <label class="control-label"></label>
                <input type="text" name="trans_id" placeholder="Enter Transaction ID" class="form-control" required/>
                <input type="hidden" name="from_date" value="<?php echo $req_online->from_date?>" />
                <input type="hidden" name="to_date" value="<?php echo $req_online->to_date?>"/>
                <input type="hidden" name="amount" value="<?php echo $req_online->admin_share?>"/>
            <span class="material-input"></span></div>
        </div>
                                        
        </div>
        <div class="modal-footer">
            <button type="submit" name="req_pay" class="btn btn-primary">Submit</button>
            </form>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
   <div class="modal-footer" style="margin-top: 40px;">
                                          <button type="button" class="btn btn-default" style="margin-top:-33px" data-dismiss="modal">Close</button>
                                                     </div>
                                      </div>
                                                                           
                                    </div>

                                  </div>
    
    <?php 
                            

                        }
                        ?>
</div>
                             
     
    <!--paypal end-->										
									</div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    
                       </form> 
                    
                        <!-- end col-md-12 -->
                    </div>
                </div>
            </div>
            <!-- Foot -->
            <?php  $this->load->view("admin/common/footer") ?>
        </div>
    </div>                                                                                                                                                        
                                                      <?php } ?>
                                                
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
                
                
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                     <h4 class="card-title"><?php echo $this->lang->line("Request");?>:<small><b>Admin To Store</b></small></h4>
                                    
                                     
                                    </from>
                                      
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables" style="margin-top: 50px;">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                              
                                                 <tr>
                                                    <th><?php echo $this->lang->line("From Date");?></th>
                                                     <th><?php echo $this->lang->line("To Date");?></th>
                                                     <th><?php echo $this->lang->line("Total Amount");?></th>
                                                    <th><?php echo $this->lang->line("Admin Share");?></th>
                                                    <th><?php echo $this->lang->line("Create By");?> </th>
                                                    <th><?php echo $this->lang->line("Create To");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                     <th><?php echo $this->lang->line("From Date");?></th>
                                                     <th><?php echo $this->lang->line("To Date");?></th>
                                                     <th><?php echo $this->lang->line("Total Amount");?></th>
                                                    <th><?php echo $this->lang->line("Admin Share");?></th>
                                                    <th><?php echo $this->lang->line("Create By");?> </th>
                                                    <th><?php echo $this->lang->line("Create To");?></th>
                                                    
                                                    
                                                </tr>
                                            </tfoot>
                                            
                                            <tbody>
											     <tr>
											         <?php foreach($req_cod as $req_cod)
											         { ?>
                                                      <td><?php echo $req_cod->from_date; ?></td>
                                                      <td><?php echo $req_cod->to_date; ?></td>
                                                      <td><?= $req_cod->amount ?></td>
                                                      <td><?= $req_cod->admin_share ?></td>
                                                      <td><?= $req_cod->create_by_admin ?></td>
                                                      <td><?= $req_cod->create_to_store_name ?></td>
                                                        
                                                       
                                                      
                                                      </tr>

                                                      
                                                      <?php } ?>
                                                
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