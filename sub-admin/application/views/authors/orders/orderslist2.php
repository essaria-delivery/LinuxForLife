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
    
    <style>
        .modal-backdrop{
            display:none;
        }
    </style>
    
</head>

<body>
    <div class="wrapper">
        <!--sider -->
        <?php  $this->load->view("authors/common/sidebar"); ?>
        
        <div class="main-panel">
            <!--head -->
            <?php  $this->load->view("authors/common/header"); ?>
            <!--content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Orders List");?></h4>
                                    <!--a class="text-right" href="<?php echo site_url("main/add_products"); ?>">ADD</a-->
                                    <div  class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><?php echo 'S.No';?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Phone");?> </th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Store");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Payment Method");?></th>
                                                    <th class="text-center"><?php echo "Assign To" ;?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center"><?php echo 'S.No';?></th>
                                                     <th class="text-center"><?php echo $this->lang->line("Order");?>ID</th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Phone");?> </th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Store");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Payment Method");?></th>
                                                    <th class="text-center"><?php echo "Assign To" ;?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php $i=1; foreach($today_orders as $order){ ?>
                                                <?php if(in_array($order->new_store_id, $store_values)){ ?>
          
                                                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $order->sale_id; ?></td>
                    <td><?php echo $order->user_fullname;?></td>
                    <td><?php echo $order->user_phone; ?></td>
                    <td><?php echo $order->on_date.'<br>'.date("H:i A", strtotime($order->delivery_time_from))." - ".date("H:i A", strtotime($order->delivery_time_to)); ; ?></td>
                    <td><?php echo $order->total_amount; ?></td>
                    <td><?php echo $order->store_name."(<b>".$order->new_store_id."</b>)" ?></td>
                    <td><?php echo $order->payment_method;; ?></td>
                    <td><?php echo $order->assign_to; ?></td>
                    <td>
                        <?php if($order->status == 0){
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
                    </td>
                    
                    <input type="hidden" name="t1" value="<?php echo $order->user_id; ?>">

                    </td>
                    <td><a href="<?php echo site_url("main/orderdetails/".$order->sale_id); ?>" class="btn btn-success"> <?php echo $this->lang->line("Details");?></a>
<div class="dropdown">
  <button class="btn btn-success dropdown-toggle" type="button"   data-toggle="dropdown"> <?php echo $this->lang->line("Action");?>
  <span class="caret"></span>
  </button>
    <ul class="dropdown-menu">
        <div class="container">
      
        </div>
        
        <?php
        
            if($order->status == 0)
            {
                echo "<li><a href='".site_url("main/cancle_order/".$order->sale_id)."'>Cancel</a></li>";
                 
                echo "<li><a href='".site_url("main/confirm_order/".$order->sale_id)."'>Confirm</a></li>";
            }
                    
            else if($order->status == 1)
            {
                echo "<li><a href='".site_url("main/delivered_order/".$order->sale_id)."'>Ready to Pick Up</a></li>";
            } 
            else if($order->status == 5)
            {
               echo "<li><a href='".site_url("main/delivered_order_complete/".$order->sale_id)."'>Complete</a></li>";
            } 
            if($order->status == 5 && $order->assign_to=="0")
            {
				echo "<li><a  data-toggle='modal' data-target='#myModal".$order->sale_id."' href='$order->sale_id'>Assign Order</a></li>";
            }
        ?>
        <li>
            <a href="<?php echo site_url("main/delete_order/".$order->sale_id); ?>">
                <?php echo $this->lang->line("Delete");?>
            </a>
        </li>
    </ul>
</div>



                    </td>
                </tr>
            <?php
           $i++ ; }
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
                    <!-- end row -->
                </div>
            </div>
            <!--footer -->
            <?php  $this->load->view("authors/common/footer"); ?>
        </div>
    </div>
    <!--fixed -->
    <?php  $this->load->view("authors/common/fixed"); ?>
    
    <?php foreach($today_orders as $order){ ?>
     <?php if(in_array($order->new_store_id, $store_values)){ ?>
    <div class="modal fade" id="myModal<?= $order->sale_id ?>" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" style="width: 50%; display: block;margin: auto;">
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
                            <form role="form" method="post" action="<?= site_url("main/assign/".$order->sale_id) ?>" >
                              <div class="box-body">
                              <?php 
                                //echo $this->session->flashdata("message");
                               ?>
                               <?php //if(isset($error) && $error!=""){ echo $error; } 
                        $q = $this->db->query("SELECT * FROM delivery_boy WHERE work_status=1");
                              
                                $boy_rows = $q->result();
                                //print_r($boy_rows);
                              
                               ?>
                                <div class="form-group">
                                    <div class="row">
                                
                                    <div class="col-md-12">
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
    <?php
          }
                                                }
          ?>
    
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

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
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