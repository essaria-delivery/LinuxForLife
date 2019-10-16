<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                $this->load->database();
                $this->load->helper('login_helper');
    }
    public function index()
    {
        if($this->session->userdata('admin_data')){
            $data = array();
            $this->load->model("users_model");
            $data["users"] = $this->users_model->get_alluser();
            
            $this->db->select('*');
            $this->db->from('membership');
            $query = $this->db->get();
            $data['plans']=$query->result();
            
            $this->load->view("users/list2",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function list_commision1($id){
    if($this->session->userdata('admin_data')){
            $data = array();
             $data = array();
            
            $q = $this->db->query("Select * from `paypal` where `store_id_login`='$id'");
             $row=$q->row();
               //$store_email=$row->user_email;        
               $client_id =$row->client_id;
             $this->load->model("users_model");
             $m=0;
             $n=1;
           $data["commission"] = $this->users_model->get_commision($id,$m);
          // print_r($data);
            // $q=$data->payment_method;
             $data["comms"] = $this->users_model->get_commision_online($id,$n);
           //print_r($data);
            $data["sum"] = $this->users_model->get_commision_sum($id,$m);
            $data["sum_online"] = $this->users_model->get_commision_sum_by_online($id,$n);
            $data["id"] =$id;
            $data["client_id"] =$client_id;
          // print_r($data);
            $this->load->view("users/comision_list2",$data);
            
        }
        
        
        else
        {
            redirect('admin');
        }
    }
    public function list_commision($id){
    if($this->session->userdata('admin_data')){
            $data = array();
             
            
            $q = $this->db->query("Select * from `paypal` where `store_id_login`='$id'");
             $row=$q->row();
              $this->load->model("users_model");
            $data["all"] = $this->users_model->get_commision_all($id);
            $from_date=$this->input->post("from_date");
            $to_date=$this->input->post("to_date"); 
             $new_fromDate = date("Y-m-d", strtotime($from_date));
             $new_fromDate;
            $new_toDate = date("Y-m-d", strtotime($to_date));
            $new_toDate;
            
             $m=0;
             $n=1;
                if(isset($_POST["cod"]))
                {
                   
                   //echo "hii";
                    $this->load->model("users_model");
                //   print_r($data["cod_order"] = $this->users_model->get_cod_order($id, $new_fromDate,$new_toDate));
                //   // print_r($data);
                //   $data["commission"] = $this->users_model->get_commision($id,$m);
                    $data["sum"] = $this->users_model->get_commision_sum_cod($id,$m,$new_fromDate,$new_toDate);
                    $data["from_date"] =$new_fromDate;
                    $data["to_date"] =$new_toDate;
                    $this->load->view("users/commisionlist_cod",$data);
                    //redirect('admin/payment');
                   
            
                    // $data["id"] =$id;

                } 
                else if(isset($_POST["prepaid"]))
                {
                   //echo "hii";
                    $this->load->model("users_model");
                      //$data["comms"] = $this->users_model->get_commision_online($id,$n);
                    $data["sum_online"] = $this->users_model->get_commision_sum_online($id,$n,$new_fromDate,$new_toDate);
                     
                     // $data["comms"] = $this->users_model->get_commision_online($id,$n);
            
                    // $data["sum_online"] = $this->users_model->get_commision_sum_by_online($id,$n);
                    $data["from_date"] =$new_fromDate;
                    $data["to_date"] =$new_toDate;
                    $this->load->view("users/commisionlist_online",$data);
                   
                }
                // else if(isset($_POST["request"]))
                // {
                //   //echo "hii";
                //     $this->load->model("users_model");
                //       //$data["comms"] = $this->users_model->get_commision_online($id,$n);
                //       $id1=0;
                //     $data["req_cod"] = $this->users_model->get_cod_request_store($id1);
                    
                //     $this->load->view("users/cod_request_list",$data);
                   
                // }
                else if(isset($_POST["request"]))
                {
                  //echo "hii";
                    $this->load->model("users_model");
                      //$data["comms"] = $this->users_model->get_commision_online($id,$n);
                      $id1=0;
                    $data["req_online"] = $this->users_model->get_online_request_from_store($id);
                    $data["req_cod"] = $this->users_model->get_cod_request_store($id);
                    
                    $this->load->view("users/cod_request_list",$data);
                   
                }
                 else if(isset($_POST["trans"]))
                {
                   //echo "hii";
                    $this->load->model("users_model");
                      //$data["comms"] = $this->users_model->get_commision_online($id,$n);
                    $data["req_cod"] = $this->users_model->get_admin_payment($id);
                    
                     //$req_cod = $this->users_model->get_cod_request_store($id);
                     //var_dump($req_cod);
                    //echo "hii";
                   $this->load->view("users/admin_transaction",$data);
                   
                }
                
                else{
                    
                       
                        $this->load->view("users/commisionlist_all",$data);
                    }
           
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function store_request(){
        if(_is_user_login($this))
        {
            
            echo $from_date = $this->input->post('from_date');
            echo $to_date = $this->input->post('to_date');
            echo $id = $this->input->post('id');
            echo $amount = $this->input->post('amount');
            echo $admin_share = $this->input->post('admin_share');
             $q = $this->db->query("Select * from `store_login` where `user_id`=".$id);
             $row=$q->row();
                     
             $store_name= $row->user_fullname; 
            //   $id=$row->user_id;
              $m=0;
              $n=1;
              
            $query = $this->db->query("Select * from `admin_request` where `create_by`=0");
             $q1=$query->num_rows();
             echo $q1;
           
              if($q1==0)
              {
                  $this->load->model("common_model");
                       
                        $array = array( 
                        "from_date"=>$from_date, 
                        "to_date"=>$to_date, 
                        "amount"=>$amount,
                        "admin_share"=>$admin_share,
                        "create_by"=>"0",
                        "create_by_admin"=>"Admin",
                         "create_to_store_name"=>$store_name,
                        "create_to"=>$id);
                      $this->common_model->data_insert("admin_request",$array);
              } 
               
                    $this->load->model("users_model");
                  //print_r($data["pay_request"]= $this->users_model->get_online($id,$n,$from_date,$to_date));
                    $pay_request= $this->users_model->get_online($id,$m,$from_date,$to_date);
                    // echo $myArray;
            
                        foreach($pay_request as $request)
                        {
                            echo "hii";
                            $request->id;
                          
                            $this->load->model("users_model");   
                            $data["request"] = $this->users_model->update_status_request_online($request->id);
                            
                        }
                            redirect('users/list_commision/'.$id);     
             
        }
        else
            {
                redirect("admin");
            }
    
    }
     public function pay_from_store($id){
    if(_is_user_login($this)){
         $this->load->model("users_model");
         $query = $this->db->query("Select * from `store_login` where `user_id`=".$id);
         $query=$query->row();
         $store_name=$query->user_fullname;
         if(isset($_POST["req_pay"]))
        {
         $this->load->model("users_model");  
         echo $trans_id=$this->input->post('trans_id');
         echo $from_date = $this->input->post('from_date');
        echo $to_date = $this->input->post('to_date');
        echo $amount = $this->input->post('amount');
        $data["pay"] = $this->users_model->update_status_online1($id,$from_date,$to_date);
             $this->load->model("common_model");
                       
                        $array = array( 
                        "from_date"=>$from_date, 
                        "to_date"=>$to_date, 
                        "amount"=>$amount,
                        "transaction_id"=>$trans_id,
                        "store_name"=>$store_name,
                        "store_id"=>$id);
                        
                      $this->common_model->data_insert("admin_transaction",$array);
                      $this->db->query("Delete from request where create_by =".$id);
        
        redirect('users/list_commision/'.$id);
        
        
            
        }
         
         
         
         
         
           //echo "hii"; 
         echo $trans_id=$this->input->post('trans_id');
         echo $from_date = $this->input->post('from_date');
        echo $to_date = $this->input->post('to_date');
        echo $amount = $this->input->post('amount');
        $n=1;
         $sum= $this->users_model->get_commision_sum1($id,$n,$from_date,$to_date);
         echo $sum1=$sum->Admin_Share;
        echo"<br><br>".gettype($amount);
        echo"<br><br>".gettype($sum1);
        
        $amount=(double)$amount;
        $sum1=(double)$sum1;
        echo"<br><br>".gettype($amount);
         echo"<br><br>".gettype($sum1);
        echo $amount."==".$sum1;
            if($amount==$sum1){
             //echo base_url();
                //echo hiii;
            $this->load->model("users_model");   
            $data["pay"] = $this->users_model->update_status_online1($id,$from_date,$to_date);
             $this->load->model("common_model");
                       
                        $array = array( 
                        "from_date"=>$from_date, 
                        "to_date"=>$to_date, 
                        "amount"=>$amount,
                        "transaction_id"=>$trans_id,
                        "store_name"=>$store_name,
                        "store_id"=>$id);
                        
                      $this->common_model->data_insert("admin_transaction",$array);
        
            
       
             }
        redirect('users/list_commision/'.$id);
    
    }  
        else
        {
            redirect('admin');
        }
    }
    public function payment_from_admin($id){
    if($this->session->userdata('admin_data')){
         $this->load->model("users_model");
                         
        $n=1;
     
     $sum_online = $this->users_model->get_commision_sum_by_online1($id,$n);
     
      echo $sum_online->total;
      $pay=100;
      $payment=$pay-$sum_online->total;
      echo "<br><br>".$payment;
      if(($sum_online->total)>$payment)
      {
        $this->load->model("users_model");   
        $data["pay"] = $this->users_model->update_status_online($id,$n);
        print_r($data);
        echo "success";
      }
    }
      
      //print_r($sum_online);
        
        else
        {
            redirect('admin');
        }
    }
      
      
          
      

    public function add_user(){
        if($this->session->userdata('admin_data')){
            $data = array();
            $this->load->model("users_model");
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_email', 'Email Id', 'trim|required');
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                    $q0 = $this->db->query("Select * from store_login where user_phone=".$this->input->post("mobile")." AND user_email='".$this->input->post("user_email")."'");
                    $both=$q0->result();
                    
                    $q1 = $this->db->query("Select * from store_login where user_phone=".$this->input->post("mobile"));
                    $phone=$q1->result();
                    
                    $q2 = $this->db->query("Select * from store_login where user_email='".$this->input->post("user_email")."'");
                    $email=$q2->result();
                    
                    if(count($both)>0)
                    {
                        //$data["message"]="mobile number /email id already exists.";
                        
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> mobile number /email id already exist
                                </div>';
                    }
                    else if(count($phone)>0)
                    {
                        //$data["message"]="Mobile Number Nust be Unique .";
                        
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Mobile Number Nust be Unique
                                </div>';
                    }
                    else if(count($email)>0)
                    {
                        //$data["message"]="Email Number Nust be Unique .";
                        
                        $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Email Number Nust be Unique 
                                </div>';
                    }
                    
                    else{
                            $user_fullname = $this->input->post("user_fullname");
                            $emp_fullname = $this->input->post("emp_fullname");
                            $user_email = $this->input->post("user_email");
                            $user_password = $this->input->post("user_password");
                            $user_phone = $this->input->post("mobile");
                            
                            $delivery_range = $this->input->post("delivery_range");
                            $user_city = $this->input->post("city");
                            $status = ($this->input->post("status")=="on")? 1 : 0;
                            //$profit_percent = $this->input->post("percent");
                            
                            $account_type = $this->input->post("account_type");
                                if($account_type=='percentage')
                                {
                                  $account_type="percentage";
                                  $percentage=$this->input->post("other");
                                  
                                }
                                if($account_type=="plan")
                                {
                                  $account_type="plan";
                                  $percentage='N/A';
                                }
                            
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
                                            $image=$_FILES["pro_pic"]['name'];
                                        }
                                        
                                    }
    
                            else{
                                $image="";
                            }
                            
                            if($_FILES["main_banner"]["size"] > 0){
                                        $config['upload_path']          = './uploads/profile/';
                                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                        $this->load->library('upload', $config);
                        
                                        if ( ! $this->upload->do_upload('main_banner'))
                                        {
                                                $error = array('error' => $this->upload->display_errors());
                                                $main_banner="";
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
                                
                                // $account_type = $this->input->post("account_type");
                                // if($account_type=='percentage')
                                // {
                                //   $account_type="percentage";
                                //   $percentage=$this->input->post("percent");
                                  
                                // }
                                // if($account_type=="plan")
                                // {
                                //   $account_type="plan";
                                //   $percentage='N/A';
                                // }
                                
                                $percentage=$this->input->post("percent");
                                $account_type = '0';
                                $id=$this->common_model->data_insert("store_login",
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
                                    "profit_percent"=>$percentage,
                                    "create_by"=>'0',
                                    "account_type"=>$account_type
                                    ));
                                    
                                    
                                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                             <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                             <span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> User Added Successfully
                                    </div>');
                                
                                  
                
                            //$this->load->view("users/list2");
                                        //  print_r($data["user"] = $this->users_model->get_user_by_id($id));
                            
                            $this->common_model->data_insert("time_slots",
                                                    array(
                                           
                                                    "store_id"=>"$id"));
                                                    
                            $this->common_model->data_insert("closing_hours",
                                    array(
                                    "store_id"=>"$id"));
            
            
                            //  start sms by me
              
                            redirect('Users/index');
                        }
                        
                }

            }
            
            $this->db->select('*');
            $this->db->from('membership');
            $query = $this->db->get();
            $data['plans']=$query->result();
            
            $data["user_types"] = $this->users_model->get_user_type();
            $this->load->view("users/add_user2",$data);

             
            //$this->load->view("users/locationm");
            
        }
         
        
        else
        {
           
            redirect('admin');
        }
    }

    public function edit_user($user_id){
        if($this->session->userdata('admin_data')){
            $data = array();
            $this->load->model("users_model");
            
            // $this->db->where('name', $name);
            $data["user_types"] = //$this->users_model->get_user_type();
            
            $user = $this->users_model->get_user_by_id($user_id);
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
                        $delivery_range = $this->input->post("delivery_range");
                        $percentage = $this->input->post("profid");
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        $image = "";
                        $main_banner = "";
                        
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
                                        $update_array["user_image"]=$image;
                                        // base_url()."/uploads/profile/".
                                    }
                                    
                                }
                        else
                        {
                            $image = '';
                        }
                        
                        if($_FILES["main_banner"]["size"] > 0){
                                    $config['upload_path']          = './uploads/profile/';
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                    $this->load->library('upload', $config);
                    
                                    if ( ! $this->upload->do_upload('main_banner'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                            $main_banner="";
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        //$array["user_image"]=$img_data['file_name'];
                                        $main_banner=$_FILES["main_banner"]['name'];
                                        $update_array["user_main_banner"]=$main_banner;
                                    }
                                    
                                }

                        else{
                            $main_banner="";
                        }
                        
                        $urlencode= str_replace(",","",$user_city);
                            $urlencode=urlencode("$urlencode"). "\n";
                            //echo $urlencode= str_replace("",",",$urlencode);
                            $response=json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$urlencode."&key=AIzaSyBQ-YSVmQS8h0Pv3hs_YwLZ65ifZqZ23X0"));
                            $lat=$response->results[0]->geometry->location->lat;
                            $lon=$response->results[0]->geometry->location->lng;
                        
                        $update_array = array(
                                "user_fullname"=>$user_fullname,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                               // "user_image"=>$image,
                                "user_phone"=>$user_phone,
                                "user_status"=>$status,
                                "user_city"=>$user_city,
                               // "user_main_banner"=>$main_banner,
                                "delivery_range"=>$delivery_range,
                                "lat"=>$lat,
                                "lon"=>$lon,
                                "profit_percent"=>$percentage,
                                "account_type"=>$account_type
                                );

                        
                        $user_password = $this->input->post("user_password");
                        if($user->user_password != $user_password){
                            
                        $update_array["user_password"]= md5($user_password);

                        }
                         if($image!="")
                        {
                            $update_array["user_image"]=$image;
                        }
                        if($main_banner!="")
                        {
                            $update_array["user_main_banner"]=$main_banner;
                        }
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("store_login",$update_array,array("user_id"=>$user_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                                redirect("users");
                        
                }
            }
            
            
            $this->load->view("users/edit_user2",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function edit_mainuser($user_id){
        if($this->session->userdata('admin_data')){
            $data = array();
            $this->load->model("users_model");
            $data["user_types"] = $this->users_model->get_user_type();
            $user = $this->users_model->get_mainuser_by_id($user_id);
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
                        $status = '1';
                        //$status = ($this->input->post("status")=="on")? 1 : 0;
                        
                        if($_FILES["pro_pic"]["size"] > 0)
                        {
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

                            $update_array = array(
                                "user_fullname"=>$user_fullname,
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
                                "user_fullname"=>$user_fullname,
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
                            $this->common_model->data_update("users",$update_array,array("user_id"=>$user_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                                redirect("admin/dashboard");
                        
                }
            }
            
            
            $this->load->view("users/edit_mainuser",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function delete_user($user_id){
        if($this->session->userdata('admin_data')){
            $data = array();
            $this->load->model("users_model");
            $user  = $this->users_model->get_user_by_id($user_id);
            if($user){
                $this->db->query("Delete  from store_login where user_id = '".$user_id."'");
                redirect("users");
            }
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function modify_password($token){
        $data = array();
        $q = $this->db->query("Select * from registers where varified_token = '".$token."' limit 1");
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
                                   $this->db->update("registers",array("user_password"=>md5($this->input->post("n_password")),"varified_token"=>""),array("user_id"=>$user->user_id));
                                   $data["success"] = true;                             
                                                                   
                        }
                        $this->load->view("users/modify_password",$data);
        }else{
            echo "No access token found";
        }
    }
    
    public function sales_rep_list()
    {
        if($this->session->userdata('admin_data')){
            $data = array();
            $this->load->model("users_model");
            $q=$this->db->query("Select * from sales_rep_login");
            $data["users"] = $q->result();
            $this->load->view("users/sales_rep_list",$data);
        }
        else
        {
            redirect('admin');
        }

    }
    
    public function add_sales_rep(){
        if($this->session->userdata('admin_data')){
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
            $this->load->view("users/add_sale_rep",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    
    public function assing_sales(){
        if($this->session->userdata('admin_data')){
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
            $this->load->view("users/assgin_sales",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function author()
    {
        if($this->session->userdata('admin_data')){
            $data = array();
            $qry = $this->db->get('authors');
            $data["users"]=$qry->result();
            $this->load->view("users/author/list_author",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function add_author(){
        if($this->session->userdata('admin_data')){
            $data = array();
            $this->load->model("users_model");
            if($_POST){
                $this->load->library('form_validation');
                
                
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
                                        $image=$_FILES["pro_pic"]['name'];
                                    }
                                    
                                }

                        else{
                            $image="";
                        }
                        

                            $this->load->model("common_model");
                            $id=$this->common_model->data_insert("authors",
                                array(
                                "user_fullname"=> 0,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_image"=>$image,
                                "user_password"=>md5($user_password),
                                "user_phone"=>$user_phone,
                                "user_login_status"=>'1',
                                "user_status"=>$status,
                                "user_city"=>$user_city
                                ));
                                
                                
                         $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                         <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                         <span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Sub-Admin Added Successfully
                                </div>');
                            
                              
            
                        //$this->load->view("users/list2");
                                     print_r($data["user"] = $this->users_model->get_user_by_id($id));
                //start paypal insert by mine
                          $this->common_model->data_insert("razorpay",
                                array(
                                "api_key"=>"",
                                "status"=>"",
                                "store_id_login"=>"$id"));
                         $this->common_model->data_insert("paypal",
                                array(
                                "client_id"=>"",
                                "sb_id"=>"",
                                "status"=>"",
                                "store_id_login"=>"$id"));
          // close paypal insert by mine 
                        redirect('Users/author');
                        
                }

            }
            
            
            
            $data["user_types"] = $this->users_model->get_user_type();
             $this->load->view("users/author/add_author",$data);

             
            //$this->load->view("users/locationm");
            
        }
         
        else
        {
            redirect('admin');
        }
    }

    public function edit_author($user_id){
        if($this->session->userdata('admin_data')){
            $data = array();
            
            $this->db->select('*');
            $this->db->from('authors');
            $this->db->where('user_id', $user_id);
            $user=$this->db->get();
            
            $data["user"] = $user->row();
            if($_POST){
                $this->load->library('form_validation');
                
               
                $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                        $u_id= $this->input->post("u_id");
                       
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
                                        $image=base_url()."/uploads/profile/".$img_data['file_name'];
                                    }
                                    
                                    $update_array = array(
                                    "user_fullname"=>0,
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
                            $ck=$this->common_model->data_update("authors",$update_array,array("user_id"=>$u_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong>Sub-Admin Edit Successfully'.$ck.'
                                </div>');
                                redirect("users/author");
                        
                }
            }
            
            $q = $this->db->query("SELECT * FROM `city` ");
                 $data['rows'] = $q->result();
                 
                 //var_dump($rows);
                //  foreach($rows as $city)
                //  {
                //      echo $city->city_id." : 1 <br>";
                //  }
            $this->load->view("users/author/edit_author",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function delete_author($user_id){
        if($this->session->userdata('admin_data')){
            $data = array();
                $this->db->query("Delete  from authors where user_id = '".$user_id."'");
                $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong>Sub-Admin Delete Successfully
                                </div>');
                redirect("users/author");
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function all_plans()
    {
        if($this->session->userdata('admin_data')){
            $data = array();
            $this->db->select('*');
            $this->db->from('membership');
            $query = $this->db->get();
            $data['plans']=$query->result();
            
            $this->load->view("users/plans/plan_list",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function add_plans(){
        if($this->session->userdata('admin_data')){
            $data = array();
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('Plan_Name', 'Plan Name', 'trim|required');
                $this->form_validation->set_rules('Plan_Description', 'Plan Description', 'trim|required');
                $this->form_validation->set_rules('Plan_Amount', 'Plan Amount', 'trim|required');
                $this->form_validation->set_rules('Plan_Time', 'Plan Time', 'trim|required');
                $this->form_validation->set_rules('plan_type', 'Plan type', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $this->session->set_flashdata("message",'<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>');
                    
                }else
                {
                    
                        $Plan_Name = $this->input->post("Plan_Name");
                        $Plan_Description = $this->input->post("Plan_Description");
                        $Plan_Amount = $this->input->post("Plan_Amount");
                        $Plan_Time = $this->input->post("Plan_Time");
                        $plan_type = $this->input->post("plan_type");

                        $this->load->model("common_model");
                        $this->load->model("common_model");
                        $id=$this->common_model->data_insert("membership",
                            array(
                            "plan_name"=>$Plan_Name,
                            "plan_amount"=>$Plan_Amount,
                            "plan_time"=>$Plan_Time,
                            "plan_desc"=>$Plan_Description,
                            "plan_time_type"=>$plan_type
                            ));
                                
                                
                         $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                         <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                         <span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> New Plan Added Successfully
                                </div>');

                        redirect('Users/all_plans');
                }

            }
             
            $this->load->view("users/plans/add_plan");
            
        }
         
        
        else
        {
           
            redirect('admin');
        }
    }

    public function edit_plans($user_id){
        if($this->session->userdata('admin_data')){
            $data = array();
            $this->load->model("users_model");
            
            $this->db->where('plan_id',$user_id);
            $user = $this->db->get('membership');
            $data["user"] = $user->row();
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('Plan_Name', 'Plan Name', 'trim|required');
                $this->form_validation->set_rules('Plan_Description', 'Plan Description', 'trim|required');
                $this->form_validation->set_rules('Plan_Amount', 'Plan Amount', 'trim|required');
                $this->form_validation->set_rules('Plan_Time', 'Plan Time', 'trim|required');
                $this->form_validation->set_rules('plan_type', 'Plan type', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                  
                    $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
                }else
                {
                        $Plan_Name = $this->input->post("Plan_Name");
                        $Plan_Description = $this->input->post("Plan_Description");
                        $Plan_Amount = $this->input->post("Plan_Amount");
                        $Plan_Time = $this->input->post("Plan_Time");
                        $plan_type = $this->input->post("plan_type");
                        
                        $update_array = array(
                                            "plan_name"=>$Plan_Name,
                                            "plan_amount"=>$Plan_Amount,
                                            "plan_time"=>$Plan_Time,
                                            "plan_desc"=>$Plan_Description,
                                            "plan_time_type"=>$plan_type
                                        );
                        
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("membership",$update_array,array("plan_id"=>$user_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Plan Edit Successfully
                                </div>');
                                redirect("Users/all_plans");
                        
                }
            }
            
            
            $this->load->view("users/plans/edit_plans",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function delete_plans($user_id){
        if($this->session->userdata('admin_data')){
            $data = array();
            $this->load->model("users_model");
            $user  = $this->users_model->get_user_by_id($user_id);
            if($user){
                $this->db->query("Delete  from store_login where user_id = '".$user_id."'");
                redirect("users");
            }
        }
        else
        {
            redirect('admin');
        }
    }
    
}