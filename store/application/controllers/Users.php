<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor code
                header('Content-type: text/json');
                date_default_timezone_set('Asia/Kolkata');
                $this->load->database();
                $this->load->helper('login_helper');
                $this->load->helper('sms_helper');
                $this->load->helper(array('form', 'url'));
                $this->db->query("SET time_zone='+05:30'");
    }
	public function index()
	{
		if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            $data["users"] = $this->users_model->get_alluser();
            $this->load->view("users/list",$data);
        }
    }
    public function add_user(){
        if(_is_user_login($this)){
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
                        $store_id = _get_current_user_id($this);
                        $status = ($this->input->post("status")=="on")? 1 : 0;
                        
                            $this->load->model("common_model");
                            $this->common_model->data_insert("delivery_boy",
                                array(
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_password"=>$user_password,
                                "user_phone"=>$user_phone,
                                "store_id"=>$store_id,
                                "user_status"=>$status));
                                         $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                 <span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Delivery Boy Added Successfully
                                </div>');
                        
                }
            }
            
            $data["user_types"] = $this->users_model->get_user_type();
            $this->load->view("admin/assign",$data);
        }
    }




 public function assign($order_sale_id,$id,$store){
     if(_is_user_login($this)){
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
        
            if($_POST){
                
                $emp_fullname = $this->input->post("assign_to");
                    

                        $update_array = array(
                                "assign_to"=>$emp_fullname);
                       
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("sale",$update_array,array("sale_id"=>$order_sale_id));
                            $this->db->query("update sale set status = 2 where sale_id = '".$order_sale_id."'");
                            
                            
                            
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Successfully Assigned
                                </div>');
                                
                                
                    $qq = $this->db->query("Select * from `registers` where `user_id`=".$id);
                    $roww=$qq->row();
                    $mobileNumber =$roww->user_phone;
                    $email1 =$roww->user_email;
                    $order = $this->db->query("Select * from `sale` where `sale_id`=".$order_sale_id);
                    $order=$order->row();
                    $date =$order->on_date;
                    $date_from =$order->delivery_time_from;
                   echo $date_to =$order->delivery_time_to;
                   echo  $DB_name =$order->assign_to;
                   echo  $total_amount =$order->total_amount;
                    //echo  $status =$order->status;
                     $q = $this->db->query("SELECT * FROM delivery_boy where store_id=".$store." and user_name='".$emp_fullname."'");
                              
                                $boy = $q->row();
                                $contact =$boy->user_phone;
                                $boy_email =$boy->user_email;
                    $sms_alert = $this->db->query("Select * from `message` where `store_id`=0");
                     $rows=$sms_alert->row();
                    $status_OA_msg =$rows->msg_order_assign;
                    echo $status_OA_mail =$rows->mail_order_assign;
                    
                    if($status_OA_msg==1)
                    {
                    
                    $message="Dispatched: Your Order No.# ".$order_sale_id." will be delivered on or before ".$date." \n Delivery Boy Name:".$DB_name." and  Contact:".$contact." ";
                         
                    
                    $send_msg=$this->sms($mobileNumber,$message);
                    }
                    if($status_OA_mail==1)
                    {
                       //$message="Thanks for your order";
                      
                    //     $location = $ld->row(); 
                    //     $address =$location->address;
                    //     $house_no =$location->house_no;
                        //echo "hii";
                    //   echo $subject="Order No. ".$order_sale_id." out of deliver";
                    //  echo  $p= "Your order No #".$order_sale_id." will delivere  ".$date_from." to ".$date_to." on ".$date." \n Delivery boy ".$DB_name." on delivery Thanks for being with Us";
                    
                    $subject="Order Dispatched";
                    
                        $data['order']=array('order_id'=>$order_sale_id,'boy_contact'=>$contact, 'fromtime'=>$date_from, 'totime'=>$date_to,'date'=>$date,'total_price'=>$total_amount,'boy_email'=>$boy_email,'DB_name'=>$DB_name);
                    
                        $send_email=$this->email_test_order_out($data,$subject,$email1);
                   
                    }
                                
                redirect("admin/orders");                                  
            }         
            $this->load->view("users/assign",$data);
        }
    }
    public function email_test_order_out($data,$subject,$email1){
        $this->load->library('email');
        
        $config['useragent']    = 'PHPMailer';
        $config['default_email'] = "noreply@thecodecafe.in";
        $config['email_host'] = "noreply@thecodecafe.in";
        $config['default_email_title'] = "Registration Confirm";
        $config['mailtype'] = "html";
        $config['wordwrap'] = TRUE;
        $config['charset'] = "utf-8";
        
        $this->email->initialize($config);
        //Email content
       
        
        $mesg=$this->load->view('admin/template/assign',$data,true);
        
 
        $this->email->to($email1);
        $this->email->from('noreply@thecodecafe.in','Demo With View');
        $this->email->subject($subject);
        $this->email->message($mesg);
        $response=$this->email->send();
        
        //Send email
        
         return $response;
        
        echo $this->email->print_debugger();
    }
    
     public function demo()
    {
        $this->load->view('users/template/complte');
    }
   // public function email_test($subject=1,$p=2){
    //     $this->load->library('email');
        
    //     $config['useragent']    = 'PHPMailer';
    //     $config['default_email'] = "noreply@thecodecafe.in";
    //     $config['email_host'] = "noreply@thecodecafe.in";
    //     $config['default_email_title'] = "Registration Confirm";
    //     $config['mailtype'] = "html";
    //     $config['wordwrap'] = TRUE;
    //     $config['charset'] = "utf-8";
        
    //     $this->email->initialize($config);
    //       $htmlContent = '<h1>'.$subject.'</h1>';
    //     // $htmlContent .= '<p>Dear '.$subject.'</p>';
    //     //  $htmlContent .= '<p>'.$p.'</p>';
    //     //$mesg=$this->load->view('users/template/m',true);
    //     $this->email->to('yadavmadhuri0444@gmail.com');
    //     $this->email->from('noreply@thecodecafe.in','Demo With View');
    //     $this->email->subject($subject);
    //     $this->email->message($htmlContent);
    //   // $this->email->message("$mesg");
    //     $response=$this->email->send();
        
    //     echo $response;
    //     //echo $this->email->print_debugger();
    // }
    public function email_test_other($subject=1,$p=2){
        $this->load->library('email');
        
        $config['useragent']    = 'PHPMailer';
        $config['default_email'] = "kumarrishabh050@gmail.com";
        $config['email_host'] = "kumarrishabh050@gmail.com";
        $config['default_email_title'] = "Registration Confirm";
        $config['mailtype'] = "html";
        $config['wordwrap'] = TRUE;
        $config['charset'] = "utf-8";
        
        $this->email->initialize($config);
        echo "hii2";
        $this->email->to('kumarrishabh050@gmail.com');
        $this->email->from('kumarrishabh050@gmail.com','Demo With View');
        $this->email->message("hello");
        $response=$this->email->send();
        
        echo $response;
    }
   
    
    
    
     public function delivered_order_complete($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
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
                            
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
                                  
                    
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
                    // if($status_CO_mail==1)
                    // {
                    // $subject=" Order No.# ".$order_id." Delivered";
                    // $send_email=$this->email_test_compelete($subject,$data,$email_user);
                    // }
                    
            }
            redirect("admin/orders");
        }
        else{
            redirect("admin");
        }
    }

 public function email_test_compelete($subject,$data,$email_user){
        $this->load->library('email');
        
        $config['useragent']    = 'PHPMailer';
        $config['default_email'] = "noreply@thecodecafe.in";
        $config['email_host'] = "noreply@thecodecafe.in";
        $config['default_email_title'] = "Registration Confirm";
        $config['mailtype'] = "html";
        $config['wordwrap'] = TRUE;
        $config['charset'] = "utf-8";
        
        $this->email->initialize($config);
        //Email content
       
        
        $mesg=$this->load->view('admin/template/compelete_order',$data,true);
        
 
        $this->email->to($email_user);
        $this->email->from('noreply@thecodecafe.in','Demo With View');
        $this->email->subject("$subject");
        $this->email->message($mesg);
        $response=$this->email->send();
        
        //Send email
        
         return $response;
        
        echo $this->email->print_debugger();
    }

  public function edit_user($user_id){
        if(_is_user_login($this)){
            //error_reporting(0);
            $data = array();
            $this->load->model("users_model");
            //$data["user_types"] = $this->users_model->get_user_type_store();
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
                    

                        $update_array = array(
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_phone"=>$user_phone,
                                "user_status"=>$status);
                        $user_password = $this->input->post("user_password");
                        if($user->user_password != $user_password){
                            
                        $update_array["user_password"]= $user_password;

                        }
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("delivery_boy",$update_array,array("id"=>$user->id));
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Updated Successfully
                                </div>');
                           redirect("users");                
                
            }         
            $this->load->view("users/edit_user",$data);
        }
    }
    
    
    public function edit_store_user($user_id){
        if(_is_user_login($this)){
            //error_reporting(0);
            $data = array();
            $this->load->model("users_model");
            //$data["user_types"] = $this->users_model->get_user_type_store();
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
                                "user_fullname"=>$user_fullname,
                                "user_name"=>$emp_fullname,
                                "user_email"=>$user_email,
                                "user_phone"=>$user_phone,
                                //"user_status"=>$status,
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
                               // "user_status"=>$status,
                                "user_city"=>$user_city);
                        }
                    

                        $user_password = $this->input->post("user_password");
                        if($user->user_password != $user_password){
                            
                        $update_array["user_password"]= md5($user_password);

                        }
                        
                            $this->load->model("common_model");
                            $this->common_model->data_update("store_login",$update_array,array("user_id"=>$user_id)
                                );
                            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Added Successfully
                                </div>');
                                redirect("admin/dashboard");
                        
                }
            }
        $this->load->view("users/edit_user",$data);
    }
    }


    function delete_user($user_id){
        $data = array();
            $this->load->model("users_model");
            $user  = $this->users_model->get_user_by_id($user_id);
           if($user){
                $this->db->query("Delete from delivery_boy where id = '".$user->id."'");
                redirect("users");
           }
    }
    
    function modify_password($token){
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
                        $this->load->view("users/modify_password",$data);
        }else{
            echo "No access token found";
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