<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper');
                $this->load->library('session');
    }
    
    
    function signout(){
        //$this->session->sess_destroy();
        $this->session->unset_userdata('sub_admin');
        redirect("main");
    }
    
    function checkdata(){
        $this->load->library('session');
        error_reporting(0);
        
        var_dump($this->session->all_userdata());
        $set_data=$this->session->all_userdata();
        echo "<br><br>this : ".$set_data['sub_admin']['user_id'];
    }
    
    public function index()
    {
        $data = array("error"=>"");       
            if(isset($_POST))
            {
                
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                   if($this->form_validation->error_string()!=""){
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    }
                }else
                {
                   
                $q = $this->db->query("Select * from `authors` where (`user_email`='".$this->input->post("email")."')
                 and user_password='".md5($this->input->post("password"))."' and user_status='1'");
                    
                   // print_r($q) ; 
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->user_status == "0")
                        {
                            $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Your account currently inactive.</div>';
                        }
                        else
                        {
                            $newdata = array(
                                                   'user_name'  => $row->user_name,
                                                   'user_email' => $row->user_email,
                                                   'logged_in' => TRUE,
                                                   'user_id'=>$row->user_id,
                                                   'user_type_id'=>$row->user_type_id
                                                  );
                            $this->session->set_userdata('sub_admin',$newdata);
                            
                            redirect("main/dashboard");
                         
                        }
                    }
                    else
                    {
                        $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Invalid User and password. </div>';
                    }
                   
                    
                }
            }
            else
            {
                $this->session->sess_destroy();
            }
            $data["active"] = "login";
            
            $this->load->view("authors/login",$data);
        
    }
    
    public function dashboard()
    {
        if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("product_model");
            $date = date("Y-m-d");
            $data["today_orders"] = $this->product_model->get_sale_orders(" and sale.on_date = '".$date."' ");
             $nexday = date('Y-m-d', strtotime(' +1 day'));
            $data["nextday_orders"] = $this->product_model->get_sale_orders(" and sale.on_date = '".$nexday."' ");
            $this->load->view("authors/dashboard",$data);
        }
        else
        {
            redirect('main');
        }
    }
    
    public function users()
    {
        if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("users_model");
            $data["users"] = $this->users_model->get_allstore();
            $this->load->view("authors/list",$data);
        }
        else
        {
            redirect('main');
        }
    }
    
    public function list_commision($id){
    if($this->session->userdata('sub_admin')){
            $data = array();
             $this->load->model("users_model");
            $data["commission"] = $this->users_model->get_commision($id);
            $data["sum"] = $this->users_model->get_commision_sum($id);
          // print_r($data);
            $this->load->view("authors/comision_list2",$data);
        }
        else
        {
            redirect('main');
        }
    }

    public function add_user(){
        if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("users_model");
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_fullname', 'Store Name', 'trim|required');
                $this->form_validation->set_rules('emp_fullname', 'Store Owner Name', 'trim|required');
                $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');
                $this->form_validation->set_rules('city', 'City', 'trim|required');
                $this->form_validation->set_rules('percent', 'Admin Share', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email Id', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                $this->form_validation->set_rules('delivery_range', 'Deliery Range', 'trim|required');
                
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                        $set_data=$this->session->all_userdata();
                    
                        $user_fullname = $this->input->post("user_fullname");
                        $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                        $user_phone = $this->input->post("mobile");
                        $user_city = $this->input->post("city");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        $profit_percent = $this->input->post("percent");
                        $delivery_range = $this->input->post("delivery_range");
                        $main_banner=$this->input->post("main_banner");
                        $create_by=$set_data['sub_admin']['user_id'];
                        
                        if($_FILES["pro_pic"]["size"] > 0){
                                    
                                    $config2['upload_path']          = '../uploads/profile/';
                                    $config2['allowed_types']        = 'gif|jpg|png|jpeg';
                                    
                                    $this->load->library('upload', $config2);
                                    $this->upload->initialize($config2);
                                    
                    
                                    if ( ! $this->upload->do_upload('pro_pic'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                            $image="";
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $image=$_FILES["pro_pic"]['name'];
                                    }
                                    
                                }

                        else{
                            $image="";
                        }
                        if($_FILES["main_banner"]["size"] > 0){
                                    
                                    $config2['upload_path']          = '../uploads/profile/';
                                    $config2['allowed_types']        = 'gif|jpg|png|jpeg';
                                    
                                    $this->load->library('upload', $config2);
                                    $this->upload->initialize($config2);
                                    
                    
                                    if ( ! $this->upload->do_upload('main_banner'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                            $image="";
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $main_banner=$_FILES["main_banner"]['name'];
                                    }
                                    
                                }

                        else{
                            $main_banner="";
                        }
                        

                            $this->load->model("common_model");
                            //mine
                            
          
                            //end
                            $urlencode= str_replace(",","",$user_city);
                            $urlencode=urlencode("$urlencode"). "\n";
                            //echo $urlencode= str_replace("",",",$urlencode);
                            $response=json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$urlencode."&key=AIzaSyBQ-YSVmQS8h0Pv3hs_YwLZ65ifZqZ23X0"));
                            $lat=$response->results[0]->geometry->location->lat;
                            $lon=$response->results[0]->geometry->location->lng;
                            //var_dump($response);
                            
                            $this->common_model->data_insert("store_login",
                                array(
                                "user_fullname"=>$user_fullname,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_image"=>$image,
                                "user_password"=>md5($user_password),
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_city"=>$user_city,
                                "user_main_banner"=>$main_banner,
                                "delivery_range"=>$delivery_range,
                                "lat"=>$lat,
                                "lon"=>$lon,
                                "profit_percent"=>$profit_percent,
                                "create_by"=>$create_by
                                ));
                                
                                
                         $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                         <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                         <span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                        
                        $this->common_model->data_insert("time_slots",
                                                array(
                                                "store_id"=>"$id"));
                                                
                        $this->common_model->data_insert("closing_hours",
                                                array(
                                                "store_id"=>"$id"));
            
                        //$this->load->view("authors/list2");
                        redirect('main/users');
                        
                }
            }
            
            $data["user_types"] = $this->users_model->get_user_type();
            $this->load->view("authors/add_user",$data);

            
            //$this->load->view("authors/locationm");
            
        }
         
        
        else
        {
           
            redirect('main');
        }
    }

    public function edit_user($user_id){
        if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("users_model");
            $data["user_types"] = $this->users_model->get_user_type();
            $user = $this->users_model->get_user_by_id_store2($user_id);
            $data["user"] = $user;
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                        $user_fullname = $this->input->post("user_fullname");
                        $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                        $user_phone = $this->input->post("mobile");
                        $user_city = $this->input->post("city");
                        $percent=$this->input->post("percent");
                        $delivery_range = $this->input->post("range");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        $image="";
                        $banner_image="";
                        
                        if($_FILES["pro_pic"]["size"] > 0){
                                    $config['upload_path']          = '../uploads/profile/';
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                    $this->load->library('upload', $config);
                    
                                    if ( ! $this->upload->do_upload('pro_pic'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $image=$img_data['file_name'];
                                    }
                        }
                        else
                        {
                            
                        }
                        
                        if($_FILES["main_banner"]["size"] > 0){
                                    $config['upload_path']          = '../uploads/profile/';
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                    $this->load->library('upload', $config);
                    
                                    if ( ! $this->upload->do_upload('main_banner'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                    }
                                    else
                                    {
                                        $main_banner_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $banner_image=$main_banner_data['file_name'];
                                        //base_url()."/uploads/profile/".
                                    }
                        }
                        else
                        {
                            
                        }

                        $update_array = array(
                        "user_fullname"=>$user_fullname,
                        "user_name"=>$emp_fullname,
                        "user_email"=>$user_email,
                        "user_phone"=>$user_phone,
                        "profit_percent"=>$percent,
                        "delivery_range"=>$delivery_range,
                        "user_status"=>$status,
                        "user_city"=>$user_city);
                            
                        $user_password = $this->input->post("user_password");
                        if($user->user_password != $user_password){
                            
                            $update_array["user_password"]= md5($user_password);

                        }
                        if($image!="")
                        {
                            $update_array["user_image"]=$image;
                        }
                        if($banner_image!="")
                        {
                            $update_array["user_main_banner"]=$banner_image;
                        }

                        
                            $this->load->model("common_model");
                            $check=$this->common_model->data_update("store_login",$update_array,array("user_id"=>$user_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully'.$check.'
                                </div>');
                                redirect("main/users");
                        
                }
            }
            
            
            $this->load->view("authors/edit_user",$data);
        }
        else
        {
            redirect('main');
        }
    }
    
    public function edit_mainuser($user_id){
        if($this->session->userdata('sub_admin')){
            $data = array();
            $user=$this->db->query("SELECT * FROM authors WHERE user_id='".$user_id."'");
            $data["user"] = $user->row();
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('emp_fullname', 'Sub-admin Name', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                        $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                        $user_phone = $this->input->post("mobile"); 
                        $user_city = $this->input->post("city");
                        $status = '1';
                        //$status = ($this->input->post("status")=="on")? 1 : 0;
                        
                        if($_FILES["pro_pic"]["size"] > 0)
                        {
                            $config['upload_path']          = '../uploads/profile/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('pro_pic'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                //$array["user_image"]=$img_data['file_name'];
                                $image=$img_data['file_name'];
                            }

                            $update_array = array(
                                "user_fullname"=>'0',
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_image"=>$image,
                                "user_city"=>$user_city);
                                    
                        }

                        else
                        {
                            $update_array = array(
                                "user_fullname"=>'0',
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_city"=>$user_city);
                        }
                    

                        $user_password = $this->input->post("user_password");
                        if($user->user_password != $user_password){
                            
                        $update_array["user_password"]= md5($user_password);

                        }
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("authors",$update_array,array("user_id"=>$user_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                                redirect("main/dashboard");
                        
                }
            }
            
            
            $this->load->view("authors/edit_mainuser",$data);
        }
        else
        {
            redirect('main');
        }
    }
    
    public function delete_user($user_id){
        if($this->session->userdata('sub_admin')){

                $this->db->query("Delete  from store_login where user_id = '".$user_id."'");
                
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Delete Successfully
                                </div>');
                               
                redirect("main/users");
            }

        else
        {
            redirect('main');
        }
    }
    
    public function modify_password($token){
        $data = array();
        $q = $this->db->query("Select * from users where varified_token = '".$token."' limit 1");
        if($q->num_rows() > 0){
                        $data = array();
                        $this->load->library('form_validation');
                        $this->form_validation->set_rules('n_password', 'New password', 'trim|required');
                        $this->form_validation->set_rules('r_password', 'Re password', 'trim|required|matches[n_password]');
                        if ($this->form_validation->run() == FALSE) 
                        {
                            if($this->form_validation->error_string()!=""){
                                  
                                    $data["response"] = "error";
                                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                                </div>';
                                                }
                                    
                        }else
                        {
                                   $user = $q->row();
                                   $this->db->update("users",array("user_password"=>md5($this->input->post("n_password")),"varified_token"=>""),array("user_id"=>$user->user_id));
                                   $data["success"] = true;                             
                                                                   
                        }
                        $this->load->view("authors/modify_password",$data);
        }
        else{
            echo "No access token found";
        }
    }
    
    public function sales_rep_list()
    {
        if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("users_model");
            $q=$this->db->query("Select * from sales_rep_login");
            $data["users"] = $q->result();
            $this->load->view("authors/sales_rep_list",$data);
        }
        else
        {
            redirect('main');
        }

    }
    
    public function add_sales_rep(){
        if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("users_model");
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email Id', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                    
                        $user_fullname = $this->input->post("user_fullname");
                        $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                        $user_phone = $this->input->post("mobile");
                        $user_city = $this->input->post("city");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        
                        if($_FILES["pro_pic"]["size"] > 0){
                                    $config['upload_path']          = './uploads/profile/';
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                    $this->load->library('upload', $config);
                    
                                    if ( ! $this->upload->do_upload('pro_pic'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                            $image="";
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $image=$img_data["pro_pic"]['file_name'];
                                    }
                                    
                                }

                        else{
                            $image="";
                        }
                        

                            $this->load->model("common_model");
                            $this->common_model->data_insert("sales_rep_login",
                                array(
                                "user_fullname"=>$user_fullname,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_image"=>$image,
                                "user_password"=>md5($user_password),
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_city"=>$user_city));
                                
                                
                                         $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                 <span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                        
                }
            }
            
            $data["user_types"] = $this->users_model->get_user_type();
            $this->load->view("authors/add_sale_rep",$data);
        }
        else
        {
            redirect('main');
        }
    }
    
    public function edit_sales_rep($user_id){
        if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("users_model");
            $data["user_types"] = $this->users_model->get_user_type();
            $u = $this->db->query("Select * from sales_rep_login where user_id ='".$user_id."'");
            $user = $u->result();
            $data["user"] = $user;
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                        $user_fullname = $this->input->post("user_fullname");
                           $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                         $user_phone = $this->input->post("mobile"); 
                          $user_city = $this->input->post("city");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        
                        if($_FILES["pro_pic"]["size"] > 0){
                                    $config['upload_path']          = './uploads/profile/';
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                    $this->load->library('upload', $config);
                    
                                    if ( ! $this->upload->do_upload('pro_pic'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $image=$img_data['file_name'];
                                    }
                                    
                                }
                    

                        $update_array = array(
                                "user_fullname"=>$user_fullname,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_image"=>$image,
                                "user_city"=>$user_city);
                        $user_password = $this->input->post("user_password");
                        if($user->user_password != $user_password){
                            
                        $update_array["user_password"]= md5($user_password);

                        }
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("sales_rep_login",$update_array,array("user_id"=>$user_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                                redirect("users/sales_rep_list");
                        
                }
            }
            
            
            $this->load->view("authors/edit_sales_rep",$data);
        }
        else
        {
            redirect('main');
        }
    }
    
    public function assing_sales(){
        if($this->session->userdata('sub_admin')){
            $data = array();
            ini_set('allow_url_fopen',1);
            $this->load->model("users_model");
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email Id', 'trim|required');
                $this->form_validation->set_rules('mobile', 'Phone Number', 'trim|required');
                $this->form_validation->set_rules('user_address', 'Address', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                    
                        $user_fullname = $this->input->post("user_name");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_address");
                        $user_phone = $this->input->post("mobile");
                        $sales_man = $this->input->post("sales_man");
                        //$addres = $this->input->post("user_address");
                        $d = date('d/m/y');
                        $addres = $this->input->post("user_address");
                        $latitude="";
                        $longitude="";
                        
                        // $prepAddr = str_replace(' ','+',$addres);
                        // $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr);
                        // $output = json_decode($geocode);
                        
                        
                        //     $latitude = $output->results[1]->geometry->location->lat;
                        //     $longitude = $output->results[1]->geometry->location->lng;
                        

                        
                        // $address2 = str_replace(" ","+",$addres);
                        // //$address2 = str_replace(",", "", $address);
                        // $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address2&sensor=false&region=India");
                        // $jsons = json_decode($json);
                    
                        // $latitude = $jsons->results[0]->geometry->location->lat;
                        // $longitude = $jsons->results[0]->geometry->location->lng;

                            
                        //   echo "latitude - ".$latitude;
                        //   echo "longitude - ".$longitude;
                        

                            $this->load->model("common_model");
                            $this->common_model->data_insert("assign_client",
                                array(
                                "name"=>$user_fullname,
                                "email"=>$user_email,
                                "phone"=>$user_phone,
                                "lat"=>$latitude,
                                "lon"=>$longitude,
                                "sale_user_id"=>$sales_man,
                                "address"=>$addres,
                                "on_date"=>$d));
                                
                                
                                         $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                 <span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                            
                        
                }
            }
            
            $data["user_types"] = $this->users_model->get_user_type();
            $this->load->view("authors/assgin_sales",$data);
        }
        else
        {
            redirect('main');
        }
    }
    
    public function socity(){
        if($this->session->userdata('sub_admin')){
            
                if(isset($_POST))
                {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('pincode', 'pincode', 'trim|required');
                    $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                     $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required');

                    if ($this->form_validation->run() == FALSE)
                    {
                      if($this->form_validation->error_string()!="")
                          $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>');
                    }
                    else
                    {
                  
                        $this->load->model("common_model");
                        $array = array(
                        "socity_name"=>$this->input->post("socity_name"),
                        "pincode"=>$this->input->post("pincode"),
                          "delivery_charge"=>$this->input->post("delivery")

                        );
                        $this->common_model->data_insert("socity",$array);
                        
                        $data=$this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                        redirect("main/socity");
                    }
                    
                    $this->load->model("product_model");
                    $data["socities"]  = $this->product_model->get_socities();
                    $this->load->view("authors/socity/list",$data);  
                    
                }
        }
        else
        {
            redirect('main');
        }
            
    }
    public function delete_socity($id){
        if($this->session->userdata('sub_admin')){
            // $this->db->query("Delete from socity where socity_id = '".$id."'");
            $this -> db -> where('socity_id', $id);
            $this -> db -> delete('socity');
            
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Society Delete Successfull...
                                        </div>');
            redirect("main/socity");
        }
        else
        {
            redirect('main');
        }
    }
    
    
    public function city(){
        if($this->session->userdata('sub_admin')){


            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('city_name', 'City Name', 'trim|required');

                if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "city_name"=>$this->input->post("city_name")
                    );
                    $this->common_model->data_insert("city",$array);
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("main/city");
                } 
                
            }
        
            $ct  = $this->db->query("select * from `city`");
            $data["cities"] = $ct->result();
            $this->load->view("authors/socity/city_list",$data);  
        }
        else{
            redirect("main");
        }
        
    }

    public function delete_city($id){
        if($this->session->userdata('sub_admin')){
            $this->db->query("Delete from city where city_id = '".$id."'");
            redirect("main/city");
        }
        else
        {
            redirect('main');
        }
    }
    
    public function all_delivery()
	{
		if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("users_model");
            $data["users"] = $this->users_model->get_alluser();
            $this->load->view("authors/dboy/list",$data);
        }
        else
        {
            redirect('main');
        }
    }
    public function delete_store()
	{
		if($this->session->userdata('sub_admin')){
            $data = array();
            
            $this->load->model("common_model");
            $this->db->query("Delete from delivery_assign_store where store_id =264");
            return;
        }
        else
        {
            redirect('main');
        }
    }
    public function add_dboy(){
        if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("users_model");
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('emp_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email Id', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		  
        			$data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
        		}else
                {
                        $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                        $user_phone = $this->input->post("mobile");
                        $charge=$this->input->post("charge");
                        $stores=$this->input->post("stores");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        
                            $this->load->model("common_model");
                            $b_id=$this->common_model->data_insert("delivery_boy",
                                array(
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_password"=>$user_password,
                                "user_phone"=>$user_phone,
                                "charge"=>$charge,
                                "user_status"=>$status));
                                
                                if(!empty($stores)){

                                    $storesCount = count($this->input->post("stores"));
                            
                                    for($i = 0; $i < $storesCount; $i++)
                                    {
                                        // $sess = $this->session->all_userdata();
                                        // $z = $sess['sub_admin']['user_id'];
                                        $s=$_POST['stores'][$i];
                                        $this->common_model->data_insert("delivery_assign_store",
                                            array(
                                            "boy_id"=>$b_id,
                                            "store_id"=>$s));
                                    }
                                }
                                
                                         $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                 <span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Delivery Boy Added Successfully
                                </div>');
                        
                }
            }
            
            $data["user_types"] = $this->users_model->get_user_type();
            $stores=$this->db->query("Select * from store_login");
            $data["stores"]=$stores->result();
            
            $this->load->view("authors/dboy/add_user2",$data);
        }
        else
        {
            redirect('main');
        }
    }
    
    public function edit_dboy($user_id){
        if($this->session->userdata('sub_admin')){
            //error_reporting(0);
            $data = array();
            $this->load->model("users_model");
           // $data["user_types"] = $this->users_model->get_user_type_store();
            
            $data["boy_assign"] = $this->users_model->get_boy_by_id_store($user_id);
            $user = $this->users_model->get_user_by_id_store($user_id);
            $data["user"] = $user;
        
            if($_POST){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                $emp_fullname = $this->input->post("emp_fullname");
                        $user_email = $this->input->post("user_email");
                        $user_password = $this->input->post("user_password");
                        $user_phone = $this->input->post("mobile"); 
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        $charge=$this->input->post("charge");

                        $update_array = array(
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_phone"=>$user_phone,
                                "charge"=>$charge,
                                "user_status"=>$status);
                        $user_password = $this->input->post("user_password");
                        if($user->user_password != $user_password){
                            
                        $update_array["user_password"]= $user_password;

                        }
                        $this->db->query("Delete from delivery_assign_store where boy_id = '".$user_id."'");
                            if(!empty($stores)){

                                    $storesCount = count($this->input->post("stores"));
                            
                                    for($i = 0; $i < $storesCount; $i++)
                                    {
                                        // $sess = $this->session->all_userdata();
                                        // $z = $sess['sub_admin']['user_id'];
                                        $s=$_POST['stores'][$i];
                                        $this->common_model->data_insert("delivery_assign_store",
                                            array(
                                            "boy_id"=>$b_id,
                                            "store_id"=>$s));
                                    }
                                }
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("delivery_boy",$update_array,array("id"=>$user->id));
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Updated Successfully
                                </div>');
                           redirect("main/all_delivery");                
                
            }
            $stores=$this->db->query("Select * from store_login");
            $data["stores"]=$stores->result();
            $this->load->view("authors/dboy/edit_user2",$data);
            // echo var_dump($data["boy_assign"]);
        }
        else
        {
            redirect('main');
        }
    }
    
    public function delete_dboy($user_id){
        if($this->session->userdata('sub_admin')){
            $data = array();
                    $this->db->query("Delete from delivery_boy where id = '".$user_id."'");
                    $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Delivery Boy Delete Successfully
                                </div>');
                               
                    redirect("main/all_delivery");
        }
        else
        {
            redirect('main');
        }
    }
    
    function notification(){
        if($this->session->userdata('sub_admin')){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('descri', 'Description', 'trim|required');
                  if ($this->form_validation->run() == FALSE)
                  {
                              if($this->form_validation->error_string()!="")
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                  }else{
                            // $message["title"] = 'Minerva Grocery';
                            $message= $this->input->post("descri");
                            ///$message["created_at"] = date("Y-m-d h:i:s");
                            
                            //$msg = $this->input->post("descri");
                            
                            $message=array('title' => 'Minerva Grocery', 'body' => $message ,'sound'=>'Default','image'=>'Notification Image' );
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            //$result = $gcm->send_topics("/topics/rabbitapp",$message ,"ios"); 
                            
                            //$result = $gcm->send_topics("Minerva_Grocery",$message ,"android");
                            //$result = $gcm->send_notification("Minerva_Grocery", $message,"android");
                            
                                                                        $q = $this->db->query("Select user_ios_token from registers");
                                                                        $registers = $q->result();
                                                                  foreach($registers as $regs){
                                                                         if($regs->user_ios_token!=""){
                                                                                 $registatoin_ids[] = $regs->user_ios_token;
                                                                                 $result = $gcm->send_notification($regs->user_ios_token, $message,"android");
                                                                         }
                                                                  }
                    //  if(count($registatoin_ids) > 1000){
                      
                    //   $chunk_array = array_chunk($registatoin_ids,1000);
                    //   foreach($chunk_array as $chunk){
                    //     $result = $gcm->send_notification($chunk, $message,"android");
                    //   }
                      
                    //  }
                    //  else{
    
                    //   //$result = $gcm->send_notification($registatoin_ids, $message,"android");
                    //     }  
                            
                             redirect("main/notification");
                  }
                   
                   $this->load->view("authors/notification");
                
            }
        }
        else
        {
            redirect('main');
        }
        
    }
    
    public function help()
    {
        if($this->session->userdata('sub_admin')){
           
            $data["error"] = "";
            $data["active"] = "addcat";
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('mobile', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('email', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
                }
                else
                { 
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('main/help');
                }
            }
            $this->load->view('authors/help/form');
        }
        else
        {
            redirect('main');
        }
    }
    
    public function orders(){
        error_reporting(0);
        if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("product_model");
            $fromdate = date("Y-m-d");
            $todate = date("Y-m-d");
            $data['date_range_lable'] = $this->input->post('date_range_lable');
           
            $filter = "";
             $user_id=_get_current_user_id($this); //$sess = $this->session->all_userdata(); $sess['sub_admin']['user_id'];
            if($this->input->post("date_range")!=""){
				$filter = $this->input->post("date_range");
			    $dates = explode(",",$filter);                
                $fromdate =  date("Y-m-d", strtotime($dates[0]));
                $todate =  date("Y-m-d", strtotime($dates[1])); 
                $filter = " and sale.on_date >= '".$fromdate."' and sale.on_date <= '".$todate."' ";
            }
            $data["today_orders"] = $this->product_model->get_sale_orders($filter,$user_id);
            
            $sess = $this->session->all_userdata();
            $z = $sess['sub_admin']['user_id'];
            $stores=$this->db->query("SELECT * FROM store_login WHERE create_by='".$z."'");
            $all_stores = $stores->result();
            
            // var_dump($all_stores);
            foreach($all_stores as $alstr)
            {
                 $st[]= $alstr->user_id;
            }
            
            $data['store_values']=$st;
            
            // var_dump($st);
            
            
            $this->load->view("authors/orders/orderslist2",$data);
            
        }
        else
        {
            redirect('main');
        }
    }
    
    public function confirm_order($order_id){
        if($this->session->userdata('sub_admin')){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 1 where sale_id = '".$order_id."'");
                 $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                                $message["title"] = "Confirmed  Order";
                                $message["message"] = "Your order Number '".$order->sale_id."' confirmed successfully";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order confirmed. </div>');
            }
            redirect("main/orders");
        }
        else{
            redirect("main");
        }
    }
    
    public function delivered_order($order_id){
        if($this->session->userdata('sub_admin')){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 5 where sale_id = '".$order_id."'");
                
                $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                        $message["title"] = "Delivered  Order";
                        $message["message"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                        $message["image"] = "";
                        $message["created_at"] = date("Y-m-d h:i:s"); 
                        $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
            }
            redirect("main/orders");
        }
        else{
            redirect("main");
        }
    }
    
    public function assign($order_sale_id){
     if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("users_model");
            // keep remember for me
            // $order=sale _id;
            // $id=user_id;
            // keep remember for me
            //$data["user_types"] = $this->users_model->get_user_type_store();
            //$user = $this->users_model->get_user_by_id_store($user_id);
            //$data["user"] = $user;
            $data["user_types"] = $this->users_model->get_user_type();
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_sale_id);
            if($_POST){
                
                $emp_fullname = $this->input->post("assign_to");

                        $update_array = array("assign_to"=>$emp_fullname);
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("sale",$update_array,array("sale_id"=>$order_sale_id));
                            
                        $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                        $user = $q->row(); 
                         
                        $q = $this->db->query("Select * from delivery_boy where user_name = '".$emp_fullname."'");
                        $boy = $q->row(); 
                  
                                $message["title"] = "Assign Order";
                                $message["body"] = "Your order Number '".$order->sale_id."' Now Assign For Delivery ";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            $result = $this->send_notification($user->user_ios_token,$message ,"android");
                            
                            
                                $message2["title"] = "Delivery Boy";
                                $message2["body"] = "New Order Assigned. Order Number is '".$order->sale_id."'";
                                $message2["image"] = "";
                                $message2["created_at"] = date("Y-m-d h:i:s"); 
                                $message2["obj"] = "";
                            $result = $this->send_dboy_notification($boy->device_id,$message2 ,"android");
                            
                                $sms_alert = $this->db->query("Select * from `message` where id='1'");
                                $rows=$sms_alert->row();
                                $msg_status =$rows->msg_order_assign;
                                $email_status =$rows->mail_order_assign;
                            
                            if($msg_status==1)
                            {
                                $customermobileNumber=$user->user_phone;
                                $dboymobilenumber=$boy->user_phone;
                                
                                $message="Your order Number '".$order_sale_id."' is now assigned to a Delivery boy. You will soon get a new message when the delivery boy takes an order from the store";
                                
                                $message2="You Get New Order For Delivery. New order No. is #".$order_sale_id;
                            
                                $send_msg=$this->sms($customermobileNumber,$message);
                                $send_msg2=$this->sms($dboymobilenumber,$message2);
                            }
                            
                            if($status_NO_email==1)
                            {
                                // $address =$location->address;
                                // $house_no =$location->house_no;
                                // $subject="Order No. ".$id." Succesfully Placed";
                                // $send_email=$this->email_test($order,$id,$user_email,$subject);
                           
                            }
                            
                                
                redirect("main/orders");
            }         
            $this->load->view("users/assign",$data);
        }
    }
    
    public function cancle_order($order_id){
        if($this->session->userdata('sub_admin')){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 3 where sale_id = '".$order_id."'");
                
                 $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                 $user = $q->row(); 
                 
                 $q = $this->db->query("Select * from store_login where user_id = '".$order->new_store_id."'");
                 $store = $q->row(); 
                  
                                $message["title"] = "Cancel Order";
                                $message["body"] = "Your order Number '".$order->sale_id."' cancel ";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";  
                            
                            $result = $this->send_notification($user->user_ios_token,$message ,"android");
                            
                            
                                $message2["title"] = "HHP STORE MANAGER";
                                $message2["body"] = "Your order Number '".$order->sale_id."' cancel ";
                                $message2["image"] = "";
                                $message2["created_at"] = date("Y-m-d h:i:s"); 
                                $message2["obj"] = "";
                            $result = $this->send_store_notification($store->user_ios_token,$message2 ,"android");
                            
                                $sms_alert = $this->db->query("Select * from `message` where id='1'");
                                $rows=$sms_alert->row();
                                $msg_status =$rows->msg_cancel;
                                $email_status =$rows->mail_cancel;
                            
                            if($msg_status==1)
                            {
                                $customermobileNumber=$user->user_phone;
                                
                                $message="Sorry For Inconvenience. \n Your Order No. #".$order_id." has been cancelled.";
                            
                                $send_msg=$this->sms($customermobileNumber,$message);
                            }
                            
                            if($status_NO_email==1)
                            {
                                // $address =$location->address;
                                // $house_no =$location->house_no;
                                // $subject="Order No. ".$id." Succesfully Placed";
                                // $send_email=$this->email_test($order,$id,$user_email,$subject);
                           
                            }
                
                        $this->db->select('*');
                        $this->db->from('sale_items');
                        $this->db->where('sale_id', $order_id);
                        $cancel_items=$this->db->get();
                        $cancel_items=$cancel_items->result();
                        foreach($cancel_items as $items)
                        {
                            $item_list = array(
                        	'product_id' => $items->product_id,
                        	'qty' => $items->qty,
                        	'unit' => $items->unit,
                        	'date' => date('Y-m-d H:i:s'),
                        	'store_id_login' => ""
                        	);
                            $this->db->insert('purchase',$item_list);
                        }
                
                
                        $this->session->set_flashdata("message",'
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>Success!</strong> Order Cancle. 
                        </div>');
            }
            redirect("main/orders");
        }
        else
        {
            redirect("main");
        }
    }
    
    public function delete_order($order_id){
        if($this->session->userdata('sub_admin')){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("delete from sale where sale_id = '".$order_id."'");
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order deleted. </div>');
            }
            redirect("main/orders");
        }
        else
        {
            redirect("main");
        }
    }
    
    public function orderdetails($order_id){
        if($this->session->userdata('sub_admin')){
            $data = array();
            $this->load->model("product_model");
            $data["order"] = $this->product_model->get_sale_order_by_id($order_id);
            $data["order_items"] = $this->product_model->get_sale_order_items($order_id);
            $this->load->view("authors/orders/orderdetails2",$data);
        }
        else
        {
            redirect("main");
        }
    }
    
    public function delivered_order_complete($order_id){
        if($this->session->userdata('sub_admin')){
            error_reporting(0);
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            
                $this->db->query("update sale set status = 4 where sale_id = '".$order_id."'");
                $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale
                where sale_id = '".$order_id."'"); 
                
                
                $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                $q = $this->db->query("Select * from store_login where user_id = '".$order->new_store_id."'");
                $store = $q->row();
                        
                        $rewrd_by_profile=$user->rewards;
                        $rewrd_by_order=$user2->total_rewards;

                        $new_rewards=$rewrd_by_profile+$rewrd_by_order;
                        $this->db->query("update registers set rewards = '".$new_rewards."' where user_id = '".$user2->user_id."'");

                        $message["title"] = "Delivered  Order";
                        $message["body"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                        $message["image"] = "";
                        $message["created_at"] = date("Y-m-d h:i:s");
                        $message["obj"] = "";
                        $result = $this->send_notification(array($user->user_ios_token),$message ,"android");
                        
                        
                        $message2["title"] = "HHP Store Manager";
                        $message2["body"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                        $message2["image"] = "";
                        $message2["created_at"] = date("Y-m-d h:i:s");
                        $message2["obj"] = "";
                        $result = $this->send_store_notification(array($store->user_ios_token),$message2 ,"ios");
                                  
                    
                     $mobileNumber =$user->user_phone;
                    //  echo $email_user =$user->user_email;
                    // echo $name_user =$user->user_fullname;
                    // echo $order_id;
                    // $email =$row->user_email;
                    
                    $sms_alert = $this->db->query("Select * from `message` where `id`=1");
                     $rows=$sms_alert->row();
                    $status_CO_msg =$rows->msg_complete_order;
                    $status_CO_mail =$rows->mail_complete_order;
                    
                    $user = $q->row();
                    
                    if($status_CO_msg==1)
                    {
                    
                    $message="Delivered: Your Order Id:# ".$order_id." is Successfully delivered. \n\nThank You For Being With Us";
                    
                    $send_msg=$this->sms($mobileNumber,$message);
                    }
                    redirect("main/orders");
                    if($status_CO_mail==1)
                    {
                        $subject=" Order No.# ".$order_id." Delivered";
                        //print_r($data['order']=array('user_name'=>$name_user,'order_id'=>$order_id));
                        $send_email=$this->email_test_compelete($subject,$data,$email_user);
                    }
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
                redirect("main/orders");
        }
        else{
            redirect("main");
        }
    }
    
    public function send($type, $fields){
        $url = 'https://fcm.googleapis.com/fcm/send';
        
       $api_key = "AAAARfFtOQ8:APA91bEatiWt8r4nhFOa9cBzd4nSBHXsg-CPFEGJuS_rKrLUBVNq8mSFr7Q417CgA1fOy7I9WBhQc70Mr7vDWBg63eUcK_F1m_oFouJR5lEgi1iTyVqq9W6jLtoYdjVgWJyZj9DN5621";
        
        
        $headers = array(
            'Authorization: key=' .$api_key ,
            'Content-Type: application/json'
        );
        
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        
        // Close connection
        curl_close($ch);
        
        return $result;
    }
    public function send_notification($registatoin_ids, $message, $type) {
        
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
            'notification' => $message,
        ); 
        if($type == "android")
        {
            $fields = array(
                        'to' => $registatoin_ids,
                        'notification' => $message,
                        'priority' => 'high',
                        'content_available' => true
                    );

        }
      return  $this->send($type, $fields);
    }

    public function send_store($type, $fields){
        $url = 'https://fcm.googleapis.com/fcm/send';
        
       $api_key = "AAAATJjR5I0:APA91bG1EpbTjql6fjO0ds7bZDFrXHcVWFCs4V5ByGwehpIxciGIbRkzhGf7KeSpe50Un96OloJX-UxJjWpYD3zrVI0yA0lG__CqngaO09QVkpY_L82lZZiacfEmsm8CwqR6v20lpOw3";
        
        
        $headers = array(
            'Authorization: key=' .$api_key ,
            'Content-Type: application/json'
        );
        
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        
        // Close connection
        curl_close($ch);
        
        return $result;
    }
    public function send_store_notification($registatoin_ids, $message, $type) {
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
            'notification' => $message,
        ); 
        if($type == "android")
        {
            $fields = array(
                        'to' => $registatoin_ids,
                        'notification' => $message,
                        'priority' => 'high',
                        'content_available' => true
                    );
        }
      return  $this->send_store($type, $fields);
    }
    
    public function send_dboy($type, $fields){
        $url = 'https://fcm.googleapis.com/fcm/send';
        
       $api_key = "AAAAKFad69c:APA91bGk4tuEtZAvKUNyAQQsnf67e9iMGlbH-4D_tgJGamF8dNh539_yc3lxzuPdj12HBYnamRCsFQXbhEQV8BeabwzsXgYIPqroREvToShWACvUMUIntmFi807Qa62QqwoJgPn1Loj8";
        
        
        $headers = array(
            'Authorization: key=' .$api_key ,
            'Content-Type: application/json'
        );
        
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        
        // Close connection
        curl_close($ch);
        
        return $result;
    }
    public function send_dboy_notification($registatoin_ids, $message, $type) {
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
            'notification' => $message,
        ); 
        if($type == "android")
        {
            $fields = array(
                        'to' => $registatoin_ids,
                        'notification' => $message,
                        'priority' => 'high',
                        'content_available' => true
                    );
        }
      return  $this->send_dboy($type, $fields);
    }
   
    public function sms($mobileNumber,$message){
    {  
        // start sms
                $getAuthKey = "248410A5Gk22m01V5bf545e5";
                $getSenderId = "HHPSTR";
               // $getInvitationMsg = "Your Registration Successful"; 

                $authKey = $getAuthKey;
              // $mobileNumber1 = 8859593839;
                $senderId = $getSenderId;
              //  $message = $getInvitationMsg;
                $route = "4";
                $postData = array(
                    'authkey' => $authKey,
                    'mobiles' => $mobileNumber,
                    'message' => $message,
                    'sender' => $senderId,
                    'route' => $route
                );

                $url="https://control.msg91.com/api/sendhttp.php";

                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postData
                    //,CURLOPT_FOLLOWLOCATION => true
                ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
                    // end sms
                    
                    return $output;
                    }
    }
    
    
}