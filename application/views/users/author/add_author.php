<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title>Admin | Dashboard</title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
    <!--// start city address by mine//-->
    
    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
     

    //   function initMap() {
        
    //     var map = new google.maps.Map(document.getElementById('map'), {
    //       center: {lat: -33.8688, lng: 151.2195},
    //       zoom: 13
    //     });
    //     alert("hii");
    //     var card = document.getElementById('pac-card');
    //     var input = document.getElementById('pac-input');
    //     var types = document.getElementById('type-selector');
    //     var strictBounds = document.getElementById('strict-bounds-selector');

    //     map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

    //     var autocomplete = new google.maps.places.Autocomplete(input);

    //     // Bind the map's bounds (viewport) property to the autocomplete object,
    //     // so that the autocomplete requests use the current map bounds for the
    //     // bounds option in the request.
    //     autocomplete.bindTo('bounds', map);

    //     // Set the data fields to return when the user selects a place.
    //     autocomplete.setFields(
    //         ['address_components', 'geometry', 'icon', 'name']);

    //     var infowindow = new google.maps.InfoWindow();
    //     var infowindowContent = document.getElementById('infowindow-content');
    //     infowindow.setContent(infowindowContent);
    //     var marker = new google.maps.Marker({
    //       map: map,
    //       anchorPoint: new google.maps.Point(0, -29)
    //     });

    //     autocomplete.addListener('place_changed', function() {
    //       infowindow.close();
    //       marker.setVisible(false);
    //       var place = autocomplete.getPlace();
    //       if (!place.geometry) {
    //         // User entered the name of a Place that was not suggested and
    //         // pressed the Enter key, or the Place Details request failed.
    //         window.alert("No details available for input: '" + place.name + "'");
    //         return;
    //       }

    //       // If the place has a geometry, then present it on a map.
    //       if (place.geometry.viewport) {
    //         map.fitBounds(place.geometry.viewport);
    //       } else {
    //         map.setCenter(place.geometry.location);
    //         map.setZoom(17);  // Why 17? Because it looks good.
    //       }
    //       marker.setPosition(place.geometry.location);
    //       marker.setVisible(true);

    //       var address = '';
    //       if (place.address_components) {
    //         address = [
    //           (place.address_components[0] && place.address_components[0].short_name || ''),
    //           (place.address_components[1] && place.address_components[1].short_name || ''),
    //           (place.address_components[2] && place.address_components[2].short_name || '')
    //         ].join(' ');
    //       }

    //       infowindowContent.children['place-icon'].src = place.icon;
    //       infowindowContent.children['place-name'].textContent = place.name;
    //       infowindowContent.children['place-address'].textContent = address;
    //       infowindow.open(map, marker);
    //     });

    //     // Sets a listener on a radio button to change the filter type on Places
    //     // Autocomplete.
    //     function setupClickListener(id, types) {
    //       var radioButton = document.getElementById(id);
    //       radioButton.addEventListener('click', function() {
    //         autocomplete.setTypes(types);
    //       });
    //     }

    //     setupClickListener('changetype-all', []);
    //     setupClickListener('changetype-address', ['address']);
    //     setupClickListener('changetype-establishment', ['establishment']);
    //     setupClickListener('changetype-geocode', ['geocode']);

    //     document.getElementById('use-strict-bounds')
    //         .addEventListener('click', function() {
    //           console.log('Checkbox clicked! New state=' + this.checked);
    //           autocomplete.setOptions({strictBounds: this.checked});
    //         });
    //   }
    // </script>
    <!--//   <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQ-YSVmQS8h0Pv3hs_YwLZ65ifZqZ23X0&libraries=places=initMap" ></script>-->
      
<!--// end city address by mine//-->
<!--start --other>
<!-end other--->


<title>Autocomplete search address form using google map and get data into form example </title>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQ-YSVmQS8h0Pv3hs_YwLZ65ifZqZ23X0&libraries=places"></script>
</head>

 
<script>
/* script */
function initialize() {
   var latlng = new google.maps.LatLng(28.5355161,77.39102649999995);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 13
    });
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      draggable: true,
      anchorPoint: new google.maps.Point(0, -29)
   });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var geocoder = new google.maps.Geocoder();
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();   
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
  
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
       
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);          
    
        bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);
       
    });
    // this function will work on marker move event into map 
    google.maps.event.addListener(marker, 'dragend', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {        
              bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
          }
        }
        });
    });
}
function bindDataToForm(address,lat,lng){
   document.getElementById('location').value = address;
   document.getElementById('lat').value = lat;
   document.getElementById('lng').value = lng;
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
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
                    <div class="row" style="padding-top: 50px;">
                        <form form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <?php echo $this->session->flashdata("message"); ?>
                               <?php if(isset($error) && $error!=""){ echo $error; } ?>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Add Store");?></h4>
                                        <div class="row"  style="padding-top:50px;">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Sub-Admin Name");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="emp_fullname" class="form-control" placeholder="<?php echo $this->lang->line("Sub-Admin Name");?>" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <!--<div class="row">-->
                                        <!--    <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Employee Name");?></label>-->
                                        <!--    <div class="col-md-9">-->
                                        <!--        <div class="form-group label-floating is-empty">-->
                                        <!--            <label class="control-label"></label>-->
                                        <!--            <input type="text" name="user_fullname" class="form-control" placeholder="<?php echo $this->lang->line("Employee Name");?>" />-->
                                        <!--        <span class="material-input"></span></div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Mobile No");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" name="mobile" placeholder="<?php echo $this->lang->line("Mobile No");?>" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("City");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select name="city"  class="form-control">
                                                        <option value="0"> ---- Select City ---- </option>
                                                        <?php 
                                                            $q = $this->db->query("SELECT * FROM `city` ");
                                                                $rows = $q->result();
                                                                foreach ($rows as $city) {
                                                        ?>
                                                        < <option value="<?= $city->city_id ?>" ><?= $city->city_name ?></option>
                                                        <?php } ?>
                                                        
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("User Email");?> </label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="email"  class="form-control" name="user_email" placeholder="user@gmail.com"  />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Password");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input class="form-control" type="password" name="user_password" placeholder="<?php echo $this->lang->line("Password");?>" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Profile Image");?></label>
                                            <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail img-circle">
                                                <img src="../../assets/img/placeholder.jpg" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail img-circle" style=""></div>
                                            <div>
                                                <span class="btn btn-round btn-rose btn-file">
                                                    <span class="fileinput-new"><?php echo $this->lang->line("Add Photo");?></span>
                                                    <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                    <input type="hidden" value="" name=""><input type="file" name="pro_pic">
                                                <div class="ripple-container"></div></span>
                                                <br>
                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 58.6719px; top: 35px; background-color: rgb(255, 255, 255); transform: scale(15.5488);"></div></div></a>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left" for="status"><?php echo $this->lang->line("Status");?></label>
                                            <div class="col-md-9">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="status" />
                                                        
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit"  value="<?php echo $this->lang->line("Submit");?>" class="btn btn-fill btn-rose" />
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="row">-->
                                        <!--    <label class="col-md-3"></label>-->
                                        <!--    <div class="col-md-9">-->
                                        <!--        <div class="form-group form-button">-->
                                        <!--            <button type="submit class="btn btn-fill btn-rose" ><?php echo $this->lang->line("Submit");?> </button>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
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
<script src="<?php echo base_url($this->config->item('new_theme')); ?>/ckeditor/ckeditor.js" type="text/javascript"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
     
        <script type="text/javascript">
            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                ckeditor.replace('editor1');
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
            });
        </script>
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
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
</script>



</html>