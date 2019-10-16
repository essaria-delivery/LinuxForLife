<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 date_default_timezone_set('Asia/Kolkata');
class Api extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                // Your own constructor code
                header('Content-type: text/json');
                date_default_timezone_set('Asia/Kolkata');
                $this->load->database();
                $this->load->helper('sms_helper');
                 $this->load->helper(array('form', 'url'));
                 $this->db->query("SET time_zone='+05:30'");
        }
        public function index(){
            echo json_encode(array("api"=>"welcome"));
        }
        public function get_categories(){
            $store_id    = $this->input->post("store_id");
            $parent = 0 ;
            if($this->input->post("parent")){
                $parent    = $this->input->post("parent");
            }
        $categories = $this->get_categories_short($parent,0,$this,$store_id);
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
        
    }
     public function get_categories_short($parent,$level,$th,$store_id){
            $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent." AND a.store_id_login=".$store_id." AND a.status=1");
                        
                        $return_array = array();
                        
                        foreach($q->result() as $row){
                                    if ($row->Count > 0) {
                                        $sub_cat =  $this->get_categories_short($row->id, $level + 1,$th,$store_id);
                                        $row->sub_cat = $sub_cat;       
                                    } elseif ($row->Count==0) {
                                    
                                    }
                            $return_array[] = $row;
                        }
        return $return_array;
    }
        public function pincode(){
            $q =$this->db->query("Select * from pincode");
             echo json_encode($q->result());
        }
/* user registration */               
public function signup(){
       $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                /* add registers table validation */
                $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required|is_unique[registers.user_phone]');
                $this->form_validation->set_rules('user_email', 'User Email', 'trim|required|is_unique[registers.user_email]');
                 $this->form_validation->set_rules('password', 'Password', 'trim|required');
                
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = strip_tags($this->form_validation->error_string());
                    $data["error_arb"]="هناك خطأ ما";
                    
                }else
                {
                    
                    $date = date('d/m/y');
                    $this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"),
                                             "user_fullname"=>$this->input->post("user_name"),
                                             "user_email"=>$this->input->post("user_email"),
                                             "user_password"=>md5($this->input->post("password")),
                                            "status" => 1
                                            ));
                    $user_id =  $this->db->insert_id(); 
                    
                    $mobileNumber=$this->input->post("user_mobile");
                    $user_email=$this->input->post("user_email");
                    $password=$this->input->post("password");
                    $user_name=$this->input->post("user_name");
                    $data["responce"] = true; 
                    $data["message"] = "User Registered Successfully..";
                    $data["arb_message"] = "العضو المسجل بنجاح";
                    
                    $q = $this->db->query("Select * from `message` where `store_id`=0");
                    $row=$q->row();
                    $status =$row->msg_register;
                    $status1 =$row->mail_register;
                    
                    if($status==1)
                    {
                    
                    $message="You have Successfully Registered";
                    
                    
                    $send_msg=$this->sms($mobileNumber,$message);
                    }
                     if($status1==1)
                    {
                     // $message="You have Successfully Registered";
                      $subject="GoFresh: User Registration";
                       
                    $user['user']=array('user_email'=>$user_email,'password'=>$password,'mobile'=>$mobileNumber,'user_name'=>$user_name);
                    $send_email=$this->email_test_for_signup($user,$subject,$user_email);
                   
                    }
                    
           
                  }   
                  
           
                     echo json_encode($data);
}     

public function email_test_for_signup($data,$subject,$user_email){
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
       
        // $htmlContent = '<h1>'.$message.'</h1>';
        // $htmlContent .= '<p>Dear '.$user_name.'</p>';
        // $htmlContent .= '<p>'.$p.'</p>';
      
        //$data['user']=array('name'=>$user_name, 'msg'=>$message, 'email'=>$message);
       // $data = array();
       // $data['user']=array('name'=>$user_name);
        $mesg=$this->load->view('api/template/account',$data,true);
 
        $this->email->to($user_email);
        $this->email->from('noreply@thecodecafe.in','Demo With View');
        $this->email->subject($subject);
        $this->email->message($mesg);
        $response=$this->email->send();
        
        return $response;
        
        echo $this->email->print_debugger();
        // $this->email->message($htmlContent);
        //Send email
    }
    
 public function update_profile_pic(){
        $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                
                if(isset($_FILES["image"]) && $_FILES["image"]["size"] > 0){
                    $config['upload_path']          = './uploads/profile/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
    
                    if ( ! $this->upload->do_upload('image'))
                    {
                    $data["responce"] = false;  
                    $data["error"] = 'Error! : '.$this->upload->display_errors();
                           
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        $this->load->model("common_model");
                        $this->common_model->data_update("registers", array(
                                            "user_image"=>$img_data['file_name']
                                            ),array("user_id"=>$this->input->post("user_id")));
                                            
                        $data["responce"] = true;
                        $data["data"] = $img_data['file_name'];
                    }
                    
                    }else{
                $data["responce"] = false;  
                    $data["error"] = 'Please choose profile image';
                
                    }
               
               
                  }                  
           
                     echo json_encode($data);
        
        }     

public function change_password(){
            $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
                $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->load->model("common_model");
                    $q = $this->db->query("select * from registers where user_id = '".$this->input->post("user_id")."' and  user_password = '".md5($this->input->post("current_password"))."' limit 1");
                    $user = $q->row();
                    
                    if(!empty($user)){
                    $this->common_model->data_update("registers", array(
                                            "user_password"=>md5($this->input->post("new_password"))
                                            ),array("user_id"=>$user->user_id));
                    
                    $data["responce"] = true;
                    }else{
                    $data["responce"] = false;  
                    $data["error"] = 'Current password do not match';
                    }
                  }                  
           
                     echo json_encode($data);
}      

public function update_userdata(){
          $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                 $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|required');
                
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $insert_array=  array(
                                            "user_fullname"=>$this->input->post("user_fullname"),
                                            "user_phone"=>$this->input->post("user_mobile")
                                            
                                            );
                     
                    $this->load->model("common_model");
                    //$this->db->where(array("user_id",$this->input->post("user_id")));
                        if(isset($_FILES["image"]) && $_FILES["image"]["size"] > 0){
                    $config['upload_path']          = './uploads/profile/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                   
                    if ( ! $this->upload->do_upload('image'))
                    {
                    $data["responce"] = false;  
                    $data["error"] = 'Error! : '.$this->upload->display_errors();
                           
                    }
                    else
                    {
                         $img_data = $this->upload->data();
                         $image_name = $img_data['file_name'];
                         $insert_array["user_image"]=$image_name;
                    }
                    
                    } 
                    
                   $this->common_model->data_update("registers",$insert_array,array("user_id"=>$this->input->post("user_id")));
                    
                      $q = $this->db->query("Select * from `registers` where(user_id='".$this->input->post('user_id')."' ) Limit 1");  
                      $row = $q->row();
                    $data["responce"] = true;
                    $data["data"] = array("user_id"=>$row->user_id,"user_fullname"=>$row->user_fullname,"user_email"=>$row->user_email,"user_phone"=>$row->user_phone,"user_image"=>$row->user_image,"pincode"=>$row->pincode,"socity_id"=>$row->socity_id,"house_no"=>$row->house_no) ;
                  }                  
           
                     echo json_encode($data);
}           
/* user login json */
     
public function login(){
            $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                 $this->form_validation->set_rules('user_email', 'Email Id',  'trim|required');
                 $this->form_validation->set_rules('password', 'Password', 'trim|required');
               
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] =  strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    //users.user_email='".$this->input->post('user_email')."' or
                    $q = $this->db->query("Select * from registers where(user_email='".$this->input->post('user_email')."' ) and user_password='".md5($this->input->post('password'))."' Limit 1");
                    
                    
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->status == "0")
                        {
                                $data["responce"] = false;  
                              $data["error"] = 'Your account currently inactive.Please Contact Admin';
                              $data["error_arb"] = 'حسابك غير نشط حاليًا. الرجاء الاتصال بالمسؤول';
                            
                        }
                       
                        else
                        {
                              $data["responce"] = true;  
              $data["data"] = array("user_id"=>$row->user_id,"user_fullname"=>$row->user_fullname,
                "user_email"=>$row->user_email,"user_phone"=>$row->user_phone,"user_image"=>$row->user_image,"wallet"=>$row->wallet,"rewards"=>$row->rewards) ;
                               
                        }
                    }
                    else
                    {
                              $data["responce"] = false;  
                              $data["error"] = 'Invalide Username or Passwords';
                              $data["error_arb"] = 'اسم المستخدم أو كلمة المرور غير صالحة';
                    }
                   
                    
                }
           echo json_encode($data);
            
        }
          function city()
                   {
                     $q = $this->db->query("SELECT * FROM `city`");
                     $city["city"] = $q->result();
                     echo json_encode($city);
                     } 
        function store()
                   {
         $data = array(); 
            $_POST = $_REQUEST;          
            $getdata =$this->input->post('city_id');
            if($getdata!='')  {      
 $q = $this->db->query("Select user_fullname ,user_id FROM `users` where (user_city='".$this->input->post('city_id')."')");
  $data["data"] = $q->result();                  
  echo json_encode($data);
               }
               else
               {
              $data["data"] ="Error";                 
  echo json_encode($data);  
               }}

        function get_products(){
                $this->load->model("product_model");
                $cat_id = "";
                $order = "";
                if($this->input->post("cat_id")){
                    $cat_id = $this->input->post("cat_id");
                }
                if($this->input->post("order")){
                    $order = $this->input->post("order");
                }
                $search= $this->input->post("search");
                
                $data["responce"] = true;  
                $datas = $this->product_model->get_products(false,$cat_id,$search,$this->input->post("page"),$order);
                //print_r( $datas);exit();
                foreach ($datas as  $product) {
                    $present = date('m/d/Y h:i:s a', time());
                      $date1 = $product->start_date." ".$product->start_time;
                      $date2 = $product->end_date." ".$product->end_time;

                     if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                     {
                        
                       if(empty($product->deal_price))   ///Runing
                       {
                           $price= $product->price;
                       }else{
                             $price= $product->deal_price;
                       }
                    
                     }else{
                      $price= $product->price;//expired
                     } 
                            
                  $data['data'][] = array(
                  'product_id' => $product->product_id,
                  'product_name'=> $product->product_name,
                  'product_name_arb'=> $product->product_arb_name,
                  'product_description_arb'=>$product->product_arb_description,
                  'category_id'=> $product->category_id,
                  'product_description'=>$product->product_description,
                  'deal_price'=>'',
                  'start_date'=>"",
                  'start_time'=>"",
                  'end_date'=>"",
                  'end_time'=>"",
                  'price' =>$price,
                  'mrp' =>$product->mrp,
                  'product_image'=>$product->product_image,
                  //'tax'=>$product->tax,
                  'status' => '0',
                  'in_stock' =>$product->in_stock,
                  'unit_value'=>$product->unit_value,
                  'unit'=>$product->unit,
                  'increament'=>$product->increament,
                  'rewards'=>$product->rewards,
                  'stock'=>$product->stock,
                  'title'=>$product->title
                 );
                }

                echo json_encode($data);
        }       
        
        function get_products_suggestion(){
            $name=$this->input->post('data');
            $stores=$this->input->post('stores');
            
            $lat=$this->input->post('lat');
            $lng=$this->input->post('lng');
            $q=$this->db->query("SELECT user_id,delivery_range,user_fullname, ( 6371 * acos( cos( radians(".$lat.") ) * cos( radians( lat ) ) * 
            cos( radians( lon ) - radians(".$lng.") ) + sin( radians(".$lat.") ) * 
            sin( radians( lat ) ) ) ) AS distance FROM store_login HAVING
            distance < delivery_range ORDER BY distance");
            
            $stores=$q->result();
            
            
            $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id"))
                {
                    $cat_id = $this->input->post("cat_id");
                }
                $search= $this->input->post("search");
                
                //$data["responce"] = true;  
                $data["data"] = $this->product_model->get_products_suggestion(false,$cat_id,$search,$this->input->post("page"),$stores);
                $newdata = array_values(array_filter($data['data']));
                // echo json_encode((object)array_values(array_filter($data['data'])));
                echo json_encode($data);
            
            // var_dump($stores); 

        }
        
        function get_products_demo(){
            
            $name=$this->input->post('data');
            // foreach($name as $done)
            // {
            //     echo $done;
            // }
            // var_dump($name);
            echo $name['0'];
        }
        
        function get_time_slot(){ 
            error_reporting(0);
            $this->load->library('form_validation');
                $this->form_validation->set_rules('date', 'date',  'trim|required');
                $this->form_validation->set_rules('store_id', 'Store ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $date = date("Y-m-d",strtotime($this->input->post("date")));
                    $store_id = $this->input->post("store_id");
                    
                    $time = date("H:i:s");
                    
                    
                            
                    $this->load->model("time_model");
                    
                    $time_slot = $this->time_model->get_time_slot($store_id);
                    
                    if(count($time_slot)>0)
                    {
                        
                        $cloasing_hours =  $this->time_model->get_closing_hours($date,$store_id);
                        
                        
                        $begin = new DateTime($time_slot->opening_time);
                        $end   = new DateTime($time_slot->closing_time);
                        
                        $interval = DateInterval::createFromDateString($time_slot->time_slot.' min');
                        
                        $times    = new DatePeriod($begin, $interval, $end);
                        $time_array = array();
                        foreach ($times as $time) {
                            if(!empty($cloasing_hours)){
                                foreach($cloasing_hours as $c_hr){
                                if($date == date("Y-m-d")){
                                    if(strtotime($time->format('h:i A')) > strtotime(date("h:i A")) &&  strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){
                                        
                                    }else{
                                        $time_array[] =  $time->format('h:i A'). ' - '. 
                                        $time->add($interval)->format('h:i A')
                                         ;
                                    }
                                
                                }else{
                                    if(strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){
                                        
                                    }else{
                                        $time_array[] =  $time->format('h:i A'). ' - '. 
                                        $time->add($interval)->format('h:i A')
                                         ;
                                    }
                                }
                                
                                }
                            }else{
                                if(strtotime($date) == strtotime(date("Y-m-d"))){
                                    if(strtotime($time->format('h:i A')) > strtotime(date("h:i A"))){
                                    $time_array[] =  $time->format('h:i A'). ' - '. 
                                        $time->add($interval)->format('h:i A');
                                    } 
                                }else{
                                        $time_array[] =  $time->format('h:i A'). ' - '. 
                                        $time->add($interval)->format('h:i A')
                                     ;
                                     }
                            }
                        }
                        $data["responce"] = true;
                        $data["times"] = $time_array;
                    }
                    else
                    {
                        $data["responce"] = false;
                        $data["times"] = $time_array;
                    }
                        
                }
                echo json_encode($data);
            
        } 
         
        function text_for_send_order(){
            echo json_encode(array("data"=>"<p>Our delivery boy will come withing your choosen time and will deliver your order. \n 
            </p>"));
        }
        function send_order(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                 $this->form_validation->set_rules('date', 'Date',  'trim|required');
                 $this->form_validation->set_rules('time', 'Time',  'trim|required');
                 $this->form_validation->set_rules('data', 'data',  'trim|required');
                  $this->form_validation->set_rules('location', 'Location',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                     $ld = $this->db->query("select user_location.*, socity.* from user_location
                    inner join socity on socity.socity_id = user_location.socity_id
                     where user_location.location_id = '".$this->input->post("location")."' limit 1");
                    $location = $ld->row(); 
                    
                    $store_id= $this->input->post("store_id");
                    $payment_method= $this->input->post("payment_method");
                    $sales_id= $this->input->post("sales_id");
                    $date = date("Y-m-d", strtotime($this->input->post("date")));
                    //$timeslot = explode("-",$this->input->post("timeslot"));
                    
                    $times = explode('-',$this->input->post("time"));
                    $fromtime = date("h:i a",strtotime(trim($times[0]))) ;
                    $totime = date("h:i a",strtotime(trim($times[1])));
                    
                //   temp store_id//
                $temp_store_id=234;
                 //   temp store_id//
                
                    $user_id = $this->input->post("user_id");
                    $insert_array = array("user_id"=>$user_id,
                    "on_date"=>$date,
                    "delivery_time_from"=>$fromtime,
                    "delivery_time_to"=>$totime,
                    "delivery_address"=>$location->house_no."\n, ".$location->house_no,
                    "socity_id" => $location->socity_id, 
                    "delivery_charge" => $location->delivery_charge,
                    "location_id" => $location->location_id, 
                    "payment_method" => $payment_method,
                    "new_store_id" => $temp_store_id
                    );
                    $this->load->model("common_model");
                    $id = $this->common_model->data_insert("sale",$insert_array);
                    
                    $data_post = $this->input->post("data");
                    $data_array = json_decode($data_post);
                    $total_rewards = 0;
                    $total_price = 0;
                    $total_kg = 0;
                    $total_items = array();
                    foreach($data_array as $dt){
                        $qty_in_kg = $dt->qty; 
                        if($dt->unit=="gram"){
                            $qty_in_kg =  ($dt->qty * $dt->unit_value) / 1000;     
                        }
                        $total_rewards = $total_rewards + ($dt->qty * $dt->rewards);
                        $total_price = $total_price + ($dt->qty * $dt->price);
                        $total_kg = $total_kg + $qty_in_kg;
                        $total_items[$dt->product_id] = $dt->product_id;    
                        
                        $array = array("product_id"=>$dt->product_id,
                        "qty"=>$dt->qty,
                        "unit"=>$dt->unit,
                        "unit_value"=>$dt->unit_value,
                        "sale_id"=>$id,
                        "price"=>$dt->price,
                        "qty_in_kg"=>$qty_in_kg,
                        "rewards" =>$dt->rewards
                        );
                        $this->common_model->data_insert("sale_items",$array);
                         
                    }
                   
                     
                     if($this->input->post("total_ammount")!="" || $this->input->post("total_ammount")!=0)
                     {
                        $total_price=$this->input->post("total_ammount");
                     }
                     $total_price = $total_price + $location->delivery_charge;

                    $this->db->query("Update sale set total_amount = '".$total_price."', total_kg = '".$total_kg."', total_items = '".count($total_items)."', total_rewards = '".$total_rewards."' where sale_id = '".$id."'");
                    
                    
                    $data["responce"] = true;  
                    
                            $this->load->model("product_model");
                
                 $commision= $this->product_model->get_store_list_by_id($temp_store_id);
                 $p=$commision->profit_percent;

                    $data["data"] = addslashes( "<p> profit percent value #".$p." is that \nYour order No #".$id." is send success fully \n Our delivery person will delivered order \n                         between ".$fromtime." to ".$totime." on ".$date." \n Please keep <strong>".$total_price."</strong> on delivery Thanks for being with Us.</p>" );

                    $data["data_arb"] = addslashes( "<p> تم إرسال طلبك رقم  #".$id." بنجاح . سوف يقوم موظف التسليم الخاص بنا بتسليم الطلب بين الساعة  ".$fromtime."ص و  ".$totime." ص في  ".$date." \n . الرجاء الاحتفاظ بالرقم  <strong>".$total_price."</strong> عند التسليم . شكراً لكونك معنا..
                </p>" );
                //start commision part mine
                    
            

                  $method="Cash On Delivery";
                  //$method1="Store Pick Up";
                  if($payment_method==$method)
                  {
                      $cod=0;
                      $status=0;
                    //$net = $total_price + $location->delivery_charge;
                    $percent=(($total_price-$location->delivery_charge)*$p) / 100;
                      $insert_array1 = array(
                         "amount" => $percent,
                          "reason" => $id,
                         "store_id" => $temp_store_id,
                         "payment_method" => $cod,
                         "status" => $status
                         );
                         
                    }
                    
                   
                  
                  else{
                      $online=1;
                      $status=0;
                      $total=$total_price-$location->delivery_charge;
                      $percent=($total * 10) / 100;
                      $q=$total-$percent;
                      $insert_array1 = array(
                         "amount" => $q,
                          "reason" => $id,
                         "store_id" => $temp_store_id,
                         "payment_method" => $online,
                         "status" => $status
                         );
                       
                      
                  }
                  $this->load->model("common_model");
                    $id1 = $this->common_model->data_insert("commission",$insert_array1);
                   
                    // //end commision part mine
                $q = $this->db->query("Select * from `registers` where `user_id`=36");
                     $row=$q->row();
                    $mobileNumber =$row->user_phone;
                    $user_email =$row->user_email;
                    $user_name =$row->user_fullname;
                    $sms_alert = $this->db->query("Select * from `message` where `store_id`=234");
                     $rows=$sms_alert->row();
                    $status_NO_msg =$rows->msg_new_order;
                    $status_NO_email =$rows->mail_new_order;
                
                    if($status_NO_msg==1)
                    {
                    
                    $message="Your order No #".$id." is send success fully \n Our delivery person will delivered order \n between ".$fromtime." to ".$totime." on ".$date." \n Please keep ".$total_price." on delivery Thanks for being with Us";
                    
                    $send_msg=$this->sms($mobileNumber,$message);
                    }
                     if($status_NO_email==1)
                    {
                       $message="Thanks for your order";
                       $subject="Order No. ".$id." Succesfully Placed";
                        $p= "Your order No #".$id." is send success fully \n Our delivery person will delivered order \n between ".$fromtime." to ".$totime." on ".$date." \n Please keep ".$total_price." on delivery Thanks for being with Us";
                    
                       // $send_email=$this->email_test($user_name,$message, $p,$subject,$user_email);
                   
                    }
               
               
                }
                
            echo json_encode($data);    
        } 
        
 
        
        function my_orders(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->load->model("product_model");
                    $data = $this->product_model->get_sale_by_user($this->input->post("user_id"));
                }
                echo json_encode($data);
        }
        
        function delivered_complete(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }
                else
                {
                    $this->load->model("product_model");
                    $data = $this->product_model->get_sale_by_user2($this->input->post("user_id"));
                    //$data->on_date;
                //     $dt = new DateTime();
                //   $dt->format('Y-m-d H:i:s');
                //     $present = date('m/d/Y h:i:s a', time()); 
                //     $data1['date']=$dt;
               
                $i=0;
                $res=array();
                foreach ($data as  $datas) 
                        {
                            $present = date('Y-m-d');
                            $present1=strtotime($present.'-7 days');
                            $date1 = $datas->on_date;
                            array_push($res,$datas);

                           if($present1 < strtotime($date1))
                           {
                             $com="yes";
                             }else{
                                    $com="no";
                             }
                          
                         $res[$i]->com=$com;
                           $i++;
                        }
                         
                        
                }
                    
                
                echo json_encode($data);
        }
        function order_details(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->load->model("product_model");
                    $data = $this->product_model->get_sale_order_items($this->input->post("sale_id"));
                }
                echo json_encode($data);
        }
        function cancel_order(){
            $this->load->library('form_validation');
                $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->db->query("Update sale set status = 3 where user_id = '".$this->input->post("user_id")."' and  sale_id = '".$this->input->post("sale_id")."' ");
                    
                    $this->db->select('*');
                    $this->db->from('sale_items');
                    $this->db->where('sale_id', $this->input->post("sale_id"));
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
                    
                    $this->load->model("product_model");
                    $order = $this->product_model->get_sale_order_by_id($this->input->post("sale_id"));
                    
                    $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                    $user = $q->row(); 
                     
                    $q = $this->db->query("Select * from store_login where user_id = '".$order->new_store_id."'");
                    $store = $q->row(); 
                      
                            $message1["title"] = "Cancel Order";
                            $message1["body"] = "Your order Number '".$order->sale_id."' cancel ";
                            $message1["image"] = "";
                            $message1["created_at"] = date("Y-m-d h:i:s"); 
                            $message1["obj"] = "";  
                        
                        $result = $this->send_notification($user->user_ios_token,$message1 ,"android");
                        
                        
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
                            
                            $message_new="Sorry For Inconvenience. \n Your Order No. #".$this->input->post("sale_id")." has been cancelled.";
                        
                            $send_msg=$this->sms($customermobileNumber,$message_new);
                        }
                        
                        if($email_status==1)
                        {
                            // $address =$location->address;
                            // $house_no =$location->house_no;
                            // $subject="Order No. ".$id." Succesfully Placed";
                            // $send_email=$this->email_test($order,$id,$user_email,$subject);
                       
                        }
                    
                    
                    $data["responce"] = true;
                    $data["message"] = "Your order cancel successfully";
                }
                echo json_encode($data);
        }
        
        function get_society(){
                
                    $this->load->model("product_model");
                    $data  = $this->product_model->get_socities();
                
                echo json_encode($data);
        }
         
        function get_varients_by_id(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('ComaSepratedIdsString', 'IDS',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $this->load->model("product_model");
                    $data  = $this->product_model->get_prices_by_ids($this->input->post("ComaSepratedIdsString"));
                }
                echo json_encode($data);
        }
        
        
        function get_sliders(){
            // $q = $this->db->query("Select * from slider");
            $store=$this->input->post("store_id");
            $this->db->select('*');
                    $this->db->from('slider');
                    $this->db->where('store_id_login', $store);
                    $this->db->where('slider_status',1);
                    $query = $this->db->get();
                    $data['count']=$query->num_rows();
                    $data['data']=$query->result();
                    
            
            echo json_encode($data);
        } 
        function get_banner(){
            // $q = $this->db->query("Select * from banner");
            $store=$this->input->post("store_id");
            $this->db->select('*');
                    $this->db->from('banner');
                    $this->db->where('store_id_login', $store);
                    $this->db->where('slider_status',1);
                    $query = $this->db->get();
                    $data['count']=$query->num_rows();
                    $data['data']=$query->result();
                    
            echo json_encode($data);
        }
        
        function get_feature_banner(){
            $q = $this->db->query("Select * from feature_slider");
            echo json_encode($q->result());
        }
        
        
        function get_limit_settings(){
            $q = $this->db->query("Select * from settings");
            echo json_encode($q->result());
        }
        
        function get_address_by_id(){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
                {
                    $data["response"] = false;  
                    $data["data"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    
                    $q = $this->db->query("Select user_location from user_location where location_id = '".$insert_id."'");
                    $data["response"] = true;  
                    $data["data"] = $q->result();
                }
            echo json_encode($data);
            
        }
         
        public function add_address(){
            $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'Pincode',  'trim|required');
                $this->form_validation->set_rules('pincode', 'Pincode ID', 'trim|required');
                $this->form_validation->set_rules('house_no', 'House',  'trim|required');
                $this->form_validation->set_rules('address', 'Address',  'trim|required');
                $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'trim|required');
                $this->form_validation->set_rules('receiver_mobile', 'Receiver Mobile', 'trim|required'); 
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $user_id = $this->input->post("user_id");
                    $pincode = $this->input->post("pincode");
                    $address = $this->input->post("address");
                    $lat = $this->input->post("lat");
                    $lng = $this->input->post("lng");
                    $socity_id = '0';
                    $house_no = $this->input->post("house_no");
                    $receiver_name = $this->input->post("receiver_name");
                    $receiver_mobile = $this->input->post("receiver_mobile");
                    
                    $array = array(
                    "user_id" => $user_id,
                    "pincode" => $pincode,
                    "socity_id" => $socity_id,
                    "house_no" => $house_no,
                    "address" => $address,
                    "lat" => $lat,
                    "lng" => $lng,
                    "receiver_name" => $receiver_name,
                    "receiver_mobile" => $receiver_mobile
                    );
                    
                    $this->db->insert("user_location",$array);
                    $insert_id = $this->db->insert_id();
                    $q = $this->db->query("Select * from user_location where location_id = '".$insert_id."'");
                    $data["responce"] = true;
                    $data["data"] = $q->row();
                    
                }
                echo json_encode($data);
        }
        
        public function edit_address(){
            $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
                $this->form_validation->set_rules('house_no', 'House Number', 'trim|required');
                $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'trim|required');
                $this->form_validation->set_rules('receiver_mobile', 'Receiver Mobile', 'trim|required'); 
                $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
                 
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $pincode = $this->input->post("pincode");
                    $address = $this->input->post("address");
                    $lat = $this->input->post("lat");
                    $lng = $this->input->post("lng");
                    $socity_id = '0';
                    $house_no = $this->input->post("house_no");
                    $receiver_name = $this->input->post("receiver_name");
                    $receiver_mobile = $this->input->post("receiver_mobile");
                    $location_id = $this->input->post("location_id");
                    
                    $insert_array=  array(
                                            "pincode" => $pincode,
                                            "socity_id" => $socity_id,
                                            "house_no" => $house_no,
                                            "address" => $address,
                                            "lat" => $lat,
                                            "lng" => $lng,
                                            "receiver_name" => $receiver_name,
                                            "receiver_mobile" => $receiver_mobile
                                            );
                     
                    $this->load->model("common_model");
                     
                    
                    $this->common_model->data_update("user_location",$insert_array,array("location_id"=>$location_id));
                    
                      
                    $data["responce"] = true;
                    $data["data"] = "Your Address Update successfully";  
                  }                  
           
                     echo json_encode($data);
        }
        
        
         /* Delete Address */
     public function delete_address()
    {
        $this->load->library('form_validation');
                 $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
       
        if ($this->form_validation->run() == FALSE)
                {
                      $data["responce"] = false;
                      $data["error"] = 'field is required';
                }
       
       else{
            
            $this->db->delete("user_location",array("location_id"=>$this->input->post("location_id")));
             
             $data["responce"] = true;
             $data["message"] = 'Your Address deleted successfully...';
        }
        echo json_encode($data);
    }
    /* End Delete  Address */
        
        
        function get_address(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User',  'trim|required');
                
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $user_id = $this->input->post("user_id");
                    
                    $q = $this->db->query("Select * from user_location where user_id = '".$user_id."'");
                    $data["responce"] = true;
                    $data["data"] = $q->result();
                }
                echo json_encode($data);
        }
        
        function check_address(){
            error_reporting(0);
                $this->load->library('form_validation');
                $this->form_validation->set_rules('location_id', 'Location ID',  'trim|required');
                $this->form_validation->set_rules('store_id', 'Store ID',  'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = strip_tags($this->form_validation->error_string());
                    
                }else
                {
                    $location_id = $this->input->post("location_id");
                    $store_id = $this->input->post("store_id");
                    
                    $q = $this->db->query("Select * from user_location where location_id = '".$location_id."'");
                    $location = $q->row();
                    
                    $q2=$this->db->query("SELECT *, ( 6371 * acos( cos( radians(".$location->lat.") ) * cos( radians( lat ) ) * 
                    cos( radians( lon ) - radians(".$location->lng.") ) + sin( radians(".$location->lat.") ) * 
                    sin( radians( lat ) ) ) ) AS distance FROM store_login where user_id=".$store_id." HAVING
                    distance < delivery_range ORDER BY distance");
                    
                    $stores_result=$q2->row();
                    if(count($store_id)==0)
                    {
                        $data["responce"] = false;
                        $data["msg"] = "Location Not Suitable";
                    }
                    else{
                        $data["responce"] = true;
                        $data["msg"] = "Location Set";
                    }
                    
                }
                echo json_encode($data);
        }
         
         
     /* contact us */
     public function support(){
        
         $q = $this->db->query("select * from `pageapp` WHERE id =1"); 
         
          
         $data["responce"] = true;
        $data['data'] = $q->result();
        
                
           echo json_encode($data);  
     }
     /* end contact us */
 
     /* about us */
      public function aboutus(){
        
         $q = $this->db->query("select * from `pageapp` where id=2"); 
         
          
         $data["responce"] = true;     
        $data['data'] = $q->result();
        
                
           echo json_encode($data);  
     }
     /* end about us */
 
     /* about us */
      public function terms(){
        
         $q = $this->db->query("select * from `pageapp` where id=3"); 
         
          
         $data["responce"] = true;     
        $data['data'] = $q->result();
        
                
           echo json_encode($data);  
     }
     /* end about us */
     
     /* start FAQ*/
     public function faq(){
        $q = $this->db->query("select * from `pageapp` where id=4");
        $data["responce"] = true;     
        $data['data'] = $q->result();
                
        echo json_encode($data);  
     }
     /* End FAQ */
  
    public function register_fcm(){
            $data = array();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
            $this->form_validation->set_rules('token', 'Token', 'trim|required');
            $this->form_validation->set_rules('device', 'Device', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
        {
                $data["responce"] = false;
               $data["error"] = $this->form_validation->error_string();
                                
        }else
            {   
                $device = $this->input->post("device");
                $token =  $this->input->post("token");
                $user_id =$this->input->post("user_id");
                
                $field = "";
                if($device=="android"){
                    $field = "user_ios_token";
                }else if($device=="ios"){
                    $field = "user_ios_token";
                }
                if($field!=""){
                    $this->db->query("update registers set ".$field." = '".$token."' where user_id = '".$user_id."'");
                    $data["responce"] = true;    
                }else{
                    $data["responce"] = false;
                    $data["error"] = "Device type is not set";
                }
                
                
            }
            echo json_encode($data);
    }
     public function test_fcm(){
        $message["title"] = "test";
        $message["message"] = "grocery test";
        $message["image"] = "";
        $message["created_at"] = date("Y-m-d");  
    
    $this->load->helper('gcm_helper');
    $gcm = new GCM();   
    // $result = $gcm->send_notification(array("AIzaSyCeC9WQR38Sbg7EAM40YVxZGgVSOOAxwjE"),$message ,"android");
    // $result= $gcm->send_topics("/topics/grocery",$message ,"android");
    // $result = $gcm->send_notification(array("AIzaSyCeC9WQR38Sbg7EAM40YVxZGgVSOOAxwjE"),$message ,"android");
     $result = $gcm->send_topics("gorocer",$message ,"android"); 
    //print_r($result);
    echo $result;
    }      
     
     /* Forgot Password */
    
    
    
       public function forgot_password(){
            $data = array();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
            {
                      $data["responce"] = false;  
                      $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                            
            }
            else
            {
                   $request = $this->db->query("Select * from registers where user_email = '".$this->input->post("email")."' limit 1");
                   if($request->num_rows() > 0){
                                
                                $user = $request->row();
                                //$token = uniqid(uniqid());
                                //$this->db->update("registers",array("varified_token"=>$token),array("user_id"=>$user->user_id)); 
                                //$this->load->library('email');
                                //$this->email->from($this->config->item('default_email'), $this->config->item('email_host'));
                                
                                $code=mt_rand(1000,9999);
                                $email=$this->input->post('email');
                                $token=md5($code);
                                $update=$this->db->query("UPDATE `registers` SET varified_token='".$token."' where user_email='".$email."' "); 
                                $email = $user->user_email;
                                $name = $user->user_fullname;
                                $return = $this->send_email_verified_mail($email,$token,$name);
                                
                                
                               
                                if ($return){
                                    $data["responce"] = true;
                                    $data["error"] = 'Success! : email Send Sucessfully On Registered Mail';
                                    $data["error_arb"] = 'نجاح! : أرسل البريد الاسترداد إلى عنوان البريد الإلكتروني الخاص بك يرجى التحقق من الارتباط.';
                                }else{
                                    $data["responce"] = false;  
                                    $data["error"] = 'Warning! : Something is wrong with system.';
                                    $data["error_arb"] = 'خطـأ!. : لا يوجد مستخدم مسجل بهذا البريد الإلكتروني.';
                                      
                                }
                   }else{
                         $data["responce"] = false;  
                         $data["error"] = 'Warning! : No user found with this email.';
                         $data["error_arb"] = 'خطـأ! : لا يوجد مستخدم مسجل بهذا البريد الإلكتروني.';
                   }
                }
                echo json_encode($data);
        }
        
        
       public function send_email_verified_mail($email,$token,$name){
          $message = $this->load->view('users/modify_password',array("name"=>$name,"active_link"=>site_url("index.php/users/verify_email?email=".$email."&token=".$token)),TRUE);
                            
                            $config['mailtype'] = 'html';
                			$this->email->initialize($config);
                			$this->email->to($email);
                			$this->email->from('noreply@hhpstores.com','HHPstores');
                			$this->email->subject('Forgot password request');
                			$this->email->message('Hi '.$name.'<br> Your password forgot request is accepted plase visit following link to change your password.<br><br>
                                '.site_url().'/users/modify_password/'.$token);
                                
                             return $this->email->send();
                            echo $this->email->print_debugger();
                      
        }
    /* End Forgot Password */   
        
    public function show_wallet(){
            $data = array(); 
            $_POST = $_REQUEST;
            if($this->input->post('user_id')==""){
                
            }
            else{
                $q = $this->db->query("Select * from registers where(user_id='".$this->input->post('user_id')."' ) Limit 1");
                
                if ($q->num_rows() > 0)
                    {
                        
                        $row = $q->row(); 
                       
                            $data["responce"] = true;  
                            $data= array("status" => true, "wallet"=>$row->wallet) ;
                               
                    }
                    else{
                        $data= array("status" => false, "wallet"=>0 ) ;
                    }
            }
            echo json_encode($data);
        }
        
    public function rewards(){
            $data = array(); 
            $_GET = $_REQUEST;
            if($this->input->get('user_id')==""){
                $data= array("success" => unsucess, "total_rewards"=> 0 ) ;
            }
            else{
                // $q = $this->db->query("Select sum(total_rewards) AS total_rewards from `delivered_order` where(user_id='".$this->input->get('user_id')."' )");
                $q = $this->db->query("Select rewards from `registers` where(user_id='".$this->input->get('user_id')."' )");
                error_reporting(0);
                if ($q->num_rows() > 0)
                    {
                        
                        $row = $q->row(); 
                       
                            $data["responce"] = true;  
                            $data= array("success" => success, "total_rewards"=>$row->rewards) ;
                               
                    }
                    else{
                        $data= array("success" => hastalavista, "total_rewards"=> 0 ) ;
                    }
            }
            echo json_encode($data);
        }
        
    public function shift(){
            $data = array(); 
            $_POST = $_REQUEST;
            if($this->input->post('user_id')==""){
                $data= array("success" => unsucess, "total_rewards"=> 0 ) ;
            }
            else{
                error_reporting(0);
                $amount=$this->input->post('amount');
                $rewards=$this->input->post('rewards');
                //$user_id=$this->input->post('user_id');
                //$final_amount=$amount+$rewards;
                //$reward_value = $rewards*.50; 
                $final_rewards= 0;
                            
                            
                $select= $this->db->query("SELECT * from rewards where id=1");
                if ($select->num_rows() > 0)
                    {
                       $row = $select->row_array(); 
                       $point= $row['point'];
                    }
                    
                $reward_value = $point*$rewards;
                $final_amount=$amount+$reward_value;
                $data["wallet_amount"]= [array("final_amount"=>$final_amount, "final_rewards"=>0,"amount"=>$amount,"rewards"=>$rewards,"pont"=>$point)];
                $this->db->query("delete from delivered_order where user_id = '".$this->input->post('user_id')."'");
                $this->db->query("UPDATE `registers` SET wallet='".$final_amount."', rewards='0' where(user_id='".$this->input->post('user_id')."' )"); 
            }
            echo json_encode($data);
        }
        
    public function try_wallet_on_checkout(){
            $data = array(); 
            $_POST = $_REQUEST;
            if($this->input->post('wallet_amount')>=$this->input->post('total_amount')){
                $wallet_amount=$this->input->post('wallet_amount');
                $amount=$this->input->post('total_amount');
                
                $final_amount=$wallet_amount-$amount;
                $balance=0;
                
                $data["final_amount"]= [array("wallet"=>$final_amount, "total"=>$balance, "used_wallet" => $amount)];
            }
            if($this->input->post('wallet_amount')<=$this->input->post('total_amount')){
                $wallet_amount=$this->input->post('wallet_amount');
                $amount=$this->input->post('total_amount');
                
                $final_amount=0;
                $balance=$amount-$wallet_amount;
                
                $data["final_amount"]= [array("wallet"=>$final_amount, "total"=>$balance, "used_wallet" => $wallet_amount)];
            }
            else{
                
            }
            echo json_encode($data);
        }
        
        
    public function recharge_wallet(){
        error_reporting(0);
        $data = array(); 
        $_POST = $_REQUEST;
        
        $q = $this->db->query("Select wallet from `registers` where(user_id='".$this->input->post('user_id')."' )");
            
            if ($q->num_rows() > 0)
                {
                  
                  $row = $q->row(); 
                  
                  $current_amount=$q->row()->wallet;
                  $request_amount=$this->input->post('wallet_amount');
                  
                  $new_amount=$current_amount+$request_amount;
                  $this->db->query("UPDATE `registers` SET wallet='".$new_amount."' where(user_id='".$this->input->post('user_id')."' )"); 
                  
                  $data= array("success" => success, "wallet_amount"=>"$new_amount") ;
                }
        echo json_encode($data);
    }
    
    public function test_array()
    {
        $response=$this->input->post('data');
        $response = json_decode($response);
            foreach($response as $tt)
            {
                $data[]= $tt->name;
            }

        // var_dump($response);
        echo json_encode($data);
        
    }
    
    public function recommended_product()
    {
        error_reporting(0);
        $data = array();
        $_POST = $_REQUEST;
        $store_id=$this->input->post('store_id');
        if($store_id!="")
        {
            
            $q = $this->db->query("select p.*,dp.start_date,dp.start_time,dp.end_time,dp.deal_price,c.title,count(si.product_id) as top,si.product_id from products p 
            INNER join sale_items si on p.product_id=si.product_id 
            INNER join categories c ON c.id=p.category_id 
            left join deal_product dp on dp.product_id=si.product_id 
            WHERE p.store_id_login='".$store_id."'
            GROUP BY si.product_id order by top DESC LIMIT 30");
            $data['responce']="true";
            
            foreach($q->result() as $product)
            {
                $present = date('m/d/Y h:i:s a', time());
                          $date1 = $product->start_date." ".$product->start_time;
                          $date2 = $product->start_date." ".$product->end_time;
    
                         if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                         {
                            
                           if(empty($product->deal_price))   ///Runing
                           {
                               $price= $product->price;
                           }else{
                                 $price= $product->deal_price;
                           }
                        
                         }else{
                          $price= $product->price;//expired
                         } 
          
                    $data['recommended_product'][] = array(
                        'product_id' => $product->product_id,
                        'product_name'=> $product->product_name,
                        'product_name_arb'=> $product->product_arb_name,
                        'product_description_arb'=>$product->product_arb_description,
                        'category_id' => $product->category_id,
                        'product_description'=>$product->product_description,
                        'deal_price'=>'',
                        'start_date'=>'',
                        'start_time'=>'',
                        'end_date'=>'',
                        'end_time'=>'',
                        'price' =>$price,
                        'mrp'=>$product->mrp,
                        'product_image'=>$product->product_image,
                        'status' => '',
                        'in_stock' =>$product->in_stock,
                        'unit_value'=>$product->unit_value,
                        'unit'=>$product->unit,
                        'increament'=>$product->increament,
                        'rewards'=>$product->rewards,
                        'stock' => '',
                        'title'=>$product->title
               
                    );
            }
        }
        else
        {
            $data['responce']=false;
            $data['recommended_product']=array();
            
        }
        echo json_encode($data);
    }
  
    public function get_all_top_selling_product()
    {
        $data = array();
        $_POST = $_REQUEST;
        error_reporting(0);
        if($this->input->post('top_selling_product')){
        //$q = $this->db->query("select p.*,dp.start_date,dp.start_time,dp.end_time,dp.deal_price,c.title,count(si.product_id) as top,si.product_id from products p INNER join //sale_items si on p.product_id=si.product_id INNER join categories c ON c.id=p.category_id left join deal_product dp on dp.product_id=si.product_id GROUP BY si.product_id //order by top DESC LIMIT 8");
    
  
        $q = $this->db->query("Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
            inner join categories on categories.id = products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            left join deal_product dp on dp.product_id=products.product_id where 1 ".$filter." ".$limit);
            //$products =$q->result();  
    
        $data[responce]="true";
        foreach($q->result() as $product)
        {
            $present = date('m/d/Y h:i:s a', time());
                  $date1 = $product->start_date." ".$product->start_time;
                  $date2 = $product->end_date." ".$product->end_time;

                if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                {
                    
                    if(empty($product->deal_price))   ///Runing
                    {
                        $price= $product->price;
                    }
                    else{
                         $price= $product->deal_price;
                    }
                
                }
                else{
                    $price= $product->price;//expired
                } 
       
            $data[top_selling_product][] = array(
                'product_id' => $product->product_id,
                'product_name'=> $product->product_name,
                'product_name_arb'=> $product->product_arb_name,
                'product_description_arb'=>$product->product_arb_description,
                'category_id' => $product->category_id,
                'product_description'=>$product->product_description,
                'deal_price'=>'',
                'start_date'=>'',
                'start_time'=>'',
                'end_date'=>'',
                'end_time'=>'',
                'price' =>$price,
                'mrp' =>$product->mrp,
                'product_image'=>$product->product_image,
                'status' => '',
                'in_stock' =>$product->in_stock,
                'unit_value'=>$product->unit_value,
                'unit'=>$product->unit,
                'increament'=>$product->increament,
                'rewards'=>$product->rewards,
                'stock' => $product->stock,
                'title'=>$product->title
            );
        }
    }
    echo json_encode($data);
    }

  public function deal_product()
  {
    
    $data = array();
    $store_id=$this->input->post('s_id');
    //error_reporting(1);
     
    $q = $this->db->query("SELECT deal_product.*,products.*,categories.title,categories.id as cat_id from deal_product 
    inner JOIN products on deal_product.product_name = products.product_name 
    INNER JOIN categories on categories.id=products.category_id 
    where deal_product.store_id_login=".$store_id);
    
    // $this->db->query("SELECT dp.*,p.*,c.title from deal_product dp inner JOIN products p on dp.product_name = p.product_name INNER JOIN categories c on c.id=p.category_id limit 4");
   
    $data['responce']="true";
    // $data['Deal_of_the_day']=array();
    foreach ($q->result() as $product) {

        $present = date('d/m/Y H:i ', time());
        $present_new = strtotime(date('d/m/Y H:i'));
        $date1 = $product->start_date." ".$product->start_time;
        $date2 = $product->end_date." ".$product->end_time;

        if($date1 <= $present && $present <=$date2)
            { 
                $status = 1;    //running
                $price=$product->deal_price;
            }
        else if($date1 > $present)
            { 
                $status = 2;    //is going to
                $price=$product->price;
            }
        else
            {   
                $status = 0;    //expired
                $price=$product->price;
            }
            
            $time_interval=($date2 - $present_new) * 1000;

         // if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
         // {
         //   $status = 1;//running 
         // }else if(strtotime($date1) > strtotime($present)){
         //  $status = 2;//is going to
         // }else{
         //  $status = 0;//expired
         // } 

      $data['Deal_of_the_day'][] = array(
            'product_id' => $product->product_id,
            'product_name'=> $product->product_name,
            'product_name_arb'=> $product->product_arb_name,
            'product_description_arb'=>$product->product_arb_description,
            'product_description'=>$product->product_description,
            'deal_price'=>$price,
            'start_date'=>$product->start_date,
            'start_time'=>$product->start_time,
            'end_date'=>$product->end_date,
            'end_time'=>$product->end_time,
            'time_interval'=>$time_interval,
            'price' =>$price,
            'mrp' =>$product->mrp,
            'product_image'=>$product->product_image,
            'status' => $status,
            'in_stock' =>$product->in_stock,
            'unit_value'=>$product->unit_value,
            'unit'=>$product->unit,
            'increament'=>$product->increament,
            'rewards'=>$product->rewards,
            'title'=>$product->title
           
        );
        // $data['Deal_of_the_day'][]= $product;
    }
  echo json_encode($data);

  }
   
  public function get_all_deal_product()
  {

    $data = array();
    $_POST = $_REQUEST;
    error_reporting(0);
   
    if($this->input->post('dealproduct'))
    {
      $q = $this->db->query("Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from deal_product dp
			left join  products on products.product_name=dp.product_name
            inner join categories on categories.id = products.category_id
            left outer join (select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            where 1 ".$filter." ".$limit);
      
      
    //   $this->db->query("SELECT dp.*,p.*,c.title from deal_product dp 
    //   inner JOIN products p on dp.product_name = p.product_name 
    //   INNER JOIN categories c on c.id=p.category_id");
   }
    $data['responce']="true";
   //$data['Deal_of_the_day'][]=array();
    foreach ($q->result() as $product) {
     $present = date('d/m/Y H:i:s ', time());
                      $date1 = $product->start_date." ".$product->start_time;
                      $date2 = $product->end_date." ".$product->end_time;

                     if($date1 <= $present&&$present <=$date2)
                     {
                        
                       if(empty($product->deal_price))   ///Runing
                       {
                           $price= $product->price;
                       }else{
                             $price= $product->deal_price;
                       }
                    
                     }
                     else{
                      $price= $product->price;//expired
                     } 
                     
        
      $data['Deal_of_the_day'][] = array(
            'product_id' => $product->product_id,
            'product_name'=> $product->product_name,
            'product_name_arb'=> $product->product_arb_name,
            'product_description_arb'=>$product->product_arb_description,
            'category_id' =>$product->category_id,
            'product_description'=>$product->product_description,
            'deal_price'=>$product->deal_price,
            'start_date'=>$product->start_date,
            'start_time'=>$product->start_time,
            'end_date'=>$product->end_date,
            'end_time'=>$product->end_time,
            'mrp'=>$product->mrp,
            'price' =>  $price,
            'product_image'=>$product->product_image,
            'status' =>$product->in_stock,
            'in_stock' =>$product->in_stock,
            'unit_value'=>$product->unit_value,
            'unit'=>$product->unit,
            'increament'=>$product->increament,
            'rewards'=>$product->rewards,
            'stock' =>$product->stock,
            'title'=>$product->title
           
        );
    }
  echo json_encode($data);

  }
  public function icon(){
            $parent = 0 ;
            if($this->input->post("parent")){
                $parent    = $this->input->post("parent");
            }
        $categories = $this->get_header_categories_short($parent,0,$this) ;
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
        
    }

    
    public function get_header_categories_short($parent,$level,$th){
            $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `header_categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `header_categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `header_products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent);
                        
                        $return_array = array();
                        
                        foreach($q->result() as $row){
                                    if ($row->Count > 0) {
                                        $sub_cat =  $this->get_header_categories_short($row->id, $level + 1,$th);
                                        $row->sub_cat = $sub_cat;       
                                    } elseif ($row->Count==0) {
                                    
                                    }
                            $return_array[] = $row;
                        }
        return $return_array;
    }
    
    function get_header_products(){
                 $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id")){
                    $cat_id = $this->input->post("cat_id");
                }
              $search= $this->input->post("search");
                
                $data["responce"] = true;  
   $datas = $this->product_model->get_header_products(false,$cat_id,$search,$this->input->post("page"));

foreach ($datas as $product) {
 $data['data'][] =  array(
            'product_id' => $product->product_id,
                  'product_name'=> $product->product_name,
                  'product_name_arb'=> $product->product_arb_name,
                  'product_description_arb'=>$product->product_arb_description,
                  'category_id'=> $product->category_id,
                  'product_description'=>$product->product_description,
                  'deal_price'=>"",
                  'start_date'=>"",
                  'start_time'=>"",
                  'end_date'=>"",
                  'end_time'=>"",
                  'price' =>$product->price,
                  'product_image'=>$product->product_image,
                  'status' => '0',
                  'in_stock' =>$product->in_stock,
                  'unit_value'=>$product->unit_value,
                  'unit'=>$product->unit,
                  'increament'=>$product->increament,
                  'rewards'=>$product->rewards,
                  'stock'=>$product->stock,
                  'title'=>$product->title
           
        );
}
                echo json_encode($data);
        }
        
        public function coupons(){
    
            $q = $this->db->query("select * from `coupons`"); 
            $data["responce"] = true;     
            $data['data'] = $q->result();
            echo json_encode($data);  
         }
         
         public function get_coupons(){
            $q = $this->db->query("SELECT * FROM `coupons` where coupon_code='".$this->input->post("coupon_code")."' AND store_id_login='".$this->input->post("store_id")."'");
            
            if(count($q->result())>0)
            {
                foreach($q->result() as $row)
                {
                    
                    $date1 = str_replace('/', '-', $row->valid_from);
                    $date2 = str_replace('/', '-', $row->valid_to);
                    $date_from= date('Y-m-d', strtotime($date1));
                    $date_to  = date('Y-m-d', strtotime($date2));
                    if(strtotime($date_from)<= strtotime(date('Y-m-d')) && strtotime($date_to)>= strtotime(date('Y-m-d')))
                    {
                        if($row->cart_value<=$this->input->post("payable_amount"))
                        {
                            $payable_amount=$this->input->post("payable_amount");
                            $coupon_amount=$row->discount_value;
                            $new_amount=$payable_amount-$coupon_amount;
                            $data["responce"] = true;
                            $data["msg"] = "Coupon code apply successfully ";
                            $data["Total_amount"] = $new_amount;
                            $data["coupon_value"] = $coupon_amount;
                        }
                        else
                        {
                            $data["responce"] = false;
                            $data["msg"] = "Your Cart Amount is not Enough For This Coupon ";
                            $data["Total_amount"] = $this->input->post("payable_amount");
                            $data["coupon_value"] = 0;
                        }
                    }
                    else{
                     $data["responce"] = false;
                     $data["msg"] = "This coupon is Expired";
                     $data["Total_amount"] = $this->input->post("payable_amount");
                     $data["coupon_value"] = 0;
                    }
                }
            }
            else{
                $data["responce"] = false;
                $data["msg"] = "Coupon not Invalid For This Store";
                $data["Total_amount"] = $this->input->post("payable_amount");
                $data["coupon_value"] = 0;
            }
            
            echo json_encode($data);
         }
         
         public function get_sub_cat(){
            $parent = 0 ;
            if($this->input->post("sub_cat")!=0){
                $q = $this->db->query("SELECT * FROM `categories` where id='".$this->input->post("sub_cat")."'");
                    $data["responce"] = true;
                     $data["subcat"] = $q->result();
                     echo json_encode($data);
            }
            else{
                $data["responce"] = false;
                $data["subcat"]="";
                echo json_encode($data);
            }
        
        
        }
        
        public function delivery_boy(){
    
            $q = $this->db->query("select id,user_name from `delivery_boy` where user_status=1");
            $data['delivery_boy'] = $q->result();
            
            echo json_encode($data); 
         }
         
         public function delivery_boy_login2(){
            error_reporting(1);
            $data = array();
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_password', 'Password', 'required');  
            
                
                    $q = $this->db->query("Select * from delivery_boy WHERE `user_password`='".$this->input->post('user_password')."'");
                    $rows=$q->result();
                    if ($rows>0)
                    {
                        $run = $q->result(); 
                        $access = $run->user_status;
                        if($access==0)
                        {
                            $data["responce"] = false;  
                            $data["data"] = 'Your account currently inactive.Please Contact Admin';
                            
                        }else
                        {
                            //$error_reporting(0);
                            $data["responce"] = true;  
                            // $q = $this->db->query("Select id,user_name from delivery_boy where user_password='".$this->input->post('user_password')."'");
                            $product=$rows;
                            $data['product']= $product;
                               
                        }
                    }
                    else
                    {
                              $data["responce"] = false;  
                              $data["data"] = 'Invalide Username or Passwords';
                    }
                   
                    
                
           echo json_encode($data);
            
        }
        
        public function delivery_boy_login()
        {
            
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('user_password', $this->input->post("user_password"));
                    $query = $this->db->get();
                    $user=$query->num_rows();
            
            if($user!=0)
            {
                $rows=$query->row();
                if($rows->user_status==0)
                {
                    $data["reson"] = $this->input->post("user_password");
                    $data["responce"] = false;  
                    $data["data"] = 'Your account currently inactive.Please Contact Admin';
                }
                else
                {
                    $data["responce"] = true;  
                    $data['product'][]= $rows;
                    $data["data"] = 'login successfull';
                    $product[]=$rows;
                    $data['product']= $product;
                }
                
            }
            else
            {
                $data["reson"] = $this->input->post("user_password");
                $data["responce"] = false;  
                $data["data"] = 'login not successfull';
            }
            echo json_encode($data);
            
        }
        
        public function add_purchase(){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
                $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
                $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
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
                    "product_id"=>$this->input->post("product_id"),
                    "qty"=>$this->input->post("qty"),
                    "price"=>$this->input->post("price"),
                    "unit"=>$this->input->post("unit"),
                    "store_id_login"=>$this->input->post("store_id_login")
                    );
                    $this->common_model->data_insert("purchase",$array);
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/add_purchase");
                }
                
                $this->load->model("product_model");
                $data["purchases"]  = $this->product_model->get_purchase_list();
                $data["products"]  = $this->product_model->get_products();
                $this->load->view("admin/product/purchase",$data);  
                
            }
        }
    

        public function stock() 
        {
                $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id")){
                    $cat_id = $this->input->post("cat_id");
                }
                $search= $this->input->post("search");
                $user_id=$this->input->post("user_id");
                $page=$this->input->post("page");
                
                $datas = $this->product_model->stock_products($user_id);
                //print_r( $datas);exit();
                foreach ($datas as  $product){
                    $present = date('m/d/Y h:i:s a', time());
                      $date1 = $product->start_date." ".$product->start_time;
                      $date2 = $product->end_date." ".$product->end_time;

                     if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                     {
                        
                       if(empty($product->deal_price))   ///Runing
                       {
                           $price= $product->price;
                       }else{
                             $price= $product->deal_price;
                       }
                    
                     }else{
                      $price= $product->price;//expired
                     } 
                            
                  $data['products'][] = array(
                  'product_id' => $product->product_id,
                  'product_name'=> $product->product_name
                  
                 );
                }
                
                echo json_encode($data);
        }
        
        public function stock_insert()
        {
             $this->load->library('form_validation');
             
                $this->input->post('product_id');
                $this->input->post('qty');
                $this->input->post('unit');
                if (!$this->input->post('product_id'))
                {
                         $data["data"] = 'Please select the product';
                }
                else
                {
              
                    $this->load->model("common_model");
                    $array = array(
                    "product_id"=>$this->input->post("product_id"),
                    "qty"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"),
                    "store_id_login"=>$this->input->post("store_id_login")
                    );
                    $this->common_model->data_insert("purchase",$array);
                    
                        $data['product'][] = array("msg"=>'Your Stock is Updated');  
                        
                }
                echo json_encode($data);
                // $this->load->model("product_model");
                // $data["purchases"]  = $this->product_model->get_purchase_list();
                // $data["products"]  = $this->product_model->get_products();
        }
        
        public function assign()
        {
            $order=$this->input->post("order_id");
            $order=$this->input->post("d_boy");
            $this->load->model("common_model");
            $this->common_model->data_update("sale",$update_array,array("sale_id"=>$order));
        }
        
        public function delivery_boy_order()
        {
            $delivery_boy_id=$this->input->post("d_id");
            $date = date("d-m-Y", strtotime('-3 day'));
            $this->load->model("product_model");
            $filter="";
            
            if($this->input->post("filter")=="1")
            {
                $todate =  date('Y-m-d'); 
                $filter = "and sale.on_date = '".$todate."' and status='4'";
            }
            if($this->input->post("filter")=="2")
            {
                //$f = date('Y-m-d');
                $fromdate =  date('Y-m-d', strtotime( "previous monday" ));
                $todate =  date('Y-m-d'); 
                $filter = "and sale.on_date BETWEEN '".$fromdate."' AND '".$todate."' and status='4' ";
            }
            if($this->input->post("filter")=="3")
            {
                $todate =  date('Y-m-d');
                $fromdate =  $date_from= date('Y-m-01', strtotime($todate));
                $filter = "and sale.on_date BETWEEN '".$fromdate."' AND '".$todate."' and  status='4' ";
            }
            $data = $this->product_model->delivery_boy_order($delivery_boy_id, $filter);
            
            $this->db->query("DELETE FROM signature WHERE `date` < '.$date.'");
            //$data['assign_orders'] = $q->result();
            echo json_encode($data);
        }
        
        public function assign_order()
        {
            $order_id = $this->input->post("order_id");
            $boy_name = $this->input->post("boy_name");
                    
            $update_array = array("assign_to"=>$boy_name);
                       
            $this->load->model("common_model");
            //$q= $this->common_model->data_update("sale",$update_array,array("sale_id"=>$order_id));
            $hit=$this->db->query("UPDATE sale SET `assign_to`='".$boy_name."' where `sale_id`='".$order_id."'" );
            if($hit){
                $data['assign'][]=array("msg"=>"Assign Successfully");
            }
            else{
                $data['assign'][]=array("msg"=>"Assign Not Successfully");
            }
            echo json_encode($data);
        }
        
        public function mark_delivered()
        {   
            
            $this->load->library('form_validation');
            $signature = $this->input->post("signature");
            
                if (empty($_FILES['signature']['name']))
                {
                    $this->form_validation->set_rules('signature', 'signature', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
            {
                $data["error"] = $data["error"] = array("error"=>"not found");
            }
            else
            {
                    $add = array(
                                    "order_id"=>$this->input->post("id")
                                    );
                    
                        if($_FILES["signature"]["size"] > 0){
                            $config['upload_path']          = './uploads/signature/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('signature'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["signature"]=$img_data['file_name'];
                            }
                            
                       }
                       
                    $q =$this->db->insert("signature",$add);
                    if($q){
                        $data=array("msg"=>"Upload Successfull");
                    }
                    else{
                        $data=array("msg"=>"Upload Not Successfull");
                    }
                }
            
                echo json_encode($data);
                
        }
        
        public function mark_delivered2(){
            
            error_reporting(0);
        	
        	$order_id=$this->input->post("id");
            
            $q2 = $this->db->query("Select * from sale where sale_id = '".$order_id."' AND status ='4'");
                $user2 = $q2->result();
            if(count($user2)>0)
            {
                $data=array("success"=>"0", "msg"=>"This Order Already Complete");
            }
            else
            {
                $img = $this->input->post("signature");
            	$img = str_replace('data:image/png;base64,', '', $img);
            	$img = str_replace(' ', '+', $img);
            	$image = base64_decode($img);
            
                if ($image) {
            
                    // move_uploaded_file($_FILES["signature"]["tmp_name"], "./uploads/signature/" . $_FILES["signature"]["name"]);
                                
                                header('Content-Type: bitmap; charset=utf-8');
                                $path="/uploads/signature/" . uniqid() . '.png';
                                $filelocation = ".".$path;
                                file_put_contents($filelocation, $image);
            
    
                    $order_id=$this->input->post("id");
                    
                    $q =$this->db->query("INSERT INTO signature (order_id, signature) VALUES ('$order_id', '$path')");
                    
                    //$this->db->insert("signature",$add);
                        if($q){
    
                            $data=array("success"=>"1", "msg"=>"Upload Successfull");
                            
                            $this->db->query("UPDATE `sale` SET `status`=4 WHERE `sale_id`='".$order_id."'");
                            $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
                                    SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale where sale_id = '".$order_id."'");
                            
                            $q2 = $this->db->query("Select user_id from sale where sale_id = '".$order_id."'");
                            $user2 = $q2->row();
                             
                             $q = $this->db->query("Select * from registers where user_id = '".$user2->user_id."'");
                             $user = $q->row();
                             $mobileNumber->$user->user_phone;
                             
                             $message="Order Complete Thanks for being with Us";
                            $send_msg=$this->sms($mobileNumber,$message);
                           
    
                        }
                        else{
                            $data=array("success"=>"0", "msg"=>"Upload Not Successfull");
                        }
                }
                else
                {
                    $data=array("success"=>"0", "msg"=>"Image Type Not Right");
                }
            }
            echo json_encode($data);
        }


        public function ads()
            {
                $qry=$this->db->query("SELECT * FROM `ads`");
                $data=$qry->result();
                echo json_encode($data); 
            }
        public function paypal()
            {
                $qry=$this->db->query("SELECT * FROM `paypal`");
                $data['paypal']=$qry->result();
                echo json_encode($data); 
            } 
        public function razorpay()
            {
                $qry=$this->db->query("SELECT * FROM `razorpay`");
                $data=$qry->result();
                echo json_encode($data); 
            }
            public function get_all_categories(){
                $store_id    = $this->input->post("store_id");
                $parent = 0 ;
                if($this->input->post("parent")){
                    $parent    = $this->input->post("parent");
                }
                $categories = $this->get_all_categories_shot($parent,0,$this,$store_id) ;
                $data["responce"] = true;
                $data["data"] = $categories;
                echo json_encode($data);
                
            }
             public function get_all_categories_shot($parent,$level,$th,$store_id){
                    $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent." AND a.store_id_login=".$store_id." AND a.status=1");
                                
                                $return_array = array();
                                
                                foreach($q->result() as $row){
                                            if ($row->Count > 0) {
                                                $sub_cat =  $this->get_all_categories_shot($row->id, $level + 1,$th,$store_id);
                                                $row->sub_cat = $sub_cat;       
                                            } elseif ($row->Count==0) {
                                            
                                            }
                                    $return_array[] = $row;
                                }
                return $return_array;
            }

            public function cart(){

              $user_id=$this->input->post("user_id");
              $pro_id=$this->input->post("product_id");
              $store_id=$this->input->post("store_id");
              $qty=$this->input->post("qty");
                
                if($user_id){
                  $cart_create =$this->db->query("INSERT INTO cart (qty, user_id, product_id, store_id) VALUES ('$qty', '$user_id', '$pro_id', '$store_id')");
                    $id=$this->db->insert_id();
                    $cart_detail = $this->db->query("select * from cart where cart_id = '".$id."'");
                    $user = $cart_detail->result();
                  if($cart_create){
                    $data['responce'] = true;
                    $data['msg'] = "Add Cart Successfull";
                    $data['data'] = $user;
                  }
                  else{
                    $data['responce'] = false;
                    $data['msg'] = "Add Cart Not Successfull";
                    $data['data']="";
                  }
                }
                else{
                    $data['responce'] = false;
                    $data['msg'] = "Add Cart Not Successfull";
                    $data['data']="";
                  }
                  
                 echo json_encode($data);

            }
            
            public function view_cart(){
              error_reporting(0);
              $user_id=$this->input->post("user_id");
                
                  if($user_id)
                  {

                    $sm=0;
                    $cart_productr = $this->db->query("select * from cart where user_id = '".$this->input->post("user_id")."'");
                    $user = $cart_productr->result();
                    
                    $cart_quantity= $cart_productr->num_rows();
                    if ($cart_quantity > 0)
                    {
                        $i=1;
                      foreach ($user as $user) 
                      {
                          $this->db->select('user_id, user_fullname, user_image');
                          $this->db->from('store_login');
                          $this->db->where('user_id', $user->store_id);
                          $store_detail = $this->db->get();
                          $store_detail = $store_detail->row();
                            
                            $id= $user->product_id;
                            $qty=$user->qty;
                            $store_id=$user->store_id;
                            $cart_id=$user->cart_id;
                            $q = $this->db->query("Select products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
                            left join categories on categories.id = products.category_id
                            left join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                            left join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id 
                            left join deal_product dp on dp.product_id=products.product_id
                            WHERE products.product_id='".$id."'");
                            $products =$q->result();


                        foreach ($products as $product) 
                        {
                            $present = date('m/d/Y h:i:s a', time());
                            $date1 = $product->start_date." ".$product->start_time;
                            $date2 = $product->end_date." ".$product->end_time;

                           if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                           {
                              
                             if(empty($product->deal_price))   ///Runing
                             {
                                 $price= $product->price;
                             }else{
                                   $price= $product->deal_price;
                             }
                          
                           }else{
                            $price= $product->price;//expired
                           }
                            
                            $data['responce'] = true;
                            $data['total_item']=$i;
                            $data['store_details'] = $store_detail;
                            $sum['total']=$price*$qty;
                            $sm=$sm+($price*$qty);
                            // array_push($data['total_amount'], $sm);
                            $data['total_amount']=$sm;
                            $data['data'][] = array(
                          'product_id' => $product->product_id,
                          'product_name'=> $product->product_name,
                          'category_id'=> $product->category_id,
                          'product_description'=>$product->product_description,
                          'deal_price'=>'',
                          'start_date'=>"",
                          'start_time'=>"",
                          'end_date'=>"",
                          'end_time'=>"",
                          'price' =>$price,
                          'mrp' =>$product->mrp,
                          'product_image'=>$product->product_image,
                          //'tax'=>$product->tax,
                          'status' => '0',
                          'in_stock' =>$product->in_stock,
                          'unit_value'=>$product->unit_value,
                          'unit'=>$product->unit,
                          'increament'=>$product->increament,
                          'rewards'=>$product->rewards,
                          'stock'=>$product->stock,
                          'title'=>$product->title,
                          'qty'=>$qty,
                          'cart_id'=>$cart_id,
                          'total_product_amount'=>$qty*$price
                         );
                        } $i++;
                      }
                    }
                    else if($cart_quantity < 1)
                    {
                      $data['total_item']=$sm;
                      $data['total_item']=0;
                      $data['responce'] = false;
                      $data['msg'] = "Your Cart is Empty ";
                    }
                  }
                else{
                    $data['responce'] = false;
                    $data['msg'] = "Cart Not Available ";
                  }
                  
                 echo json_encode($data);
            }
            
            public function check_cart(){
                
                $product_id = $this->input->post("product_id");
                $user_id = $this->input->post("user_id");
                
                $this->db->select('*');
                $this->db->from('cart');
                $this->db->where('product_id', $product_id);
                $this->db->where('user_id', $user_id);
                $q=$this->db->get();
                
                $da=$q->num_rows();
                
                if($da==0)
                {
                    $data['responce'] = false;
                    $data['qty']="";
                    $data['cart_id']="";
                }
                else{
                    $data['responce'] = true;
                    $data['qty']=$q->row()->qty;
                    $data['cart_id']=$q->row()->cart_id;
                    
                }
                
                echo json_encode($data);
            }
            
            public function count_cart(){
              error_reporting(0);
              $user_id=$this->input->post("user_id");
                
                  if($user_id)
                  {


                    $cart_productr = $this->db->query("select * from cart where user_id = '".$this->input->post("user_id")."'");
                    $user = $cart_productr->result();
                    $cart_quantity= $cart_productr->num_rows();
                    if ($cart_quantity > 0)
                    {
                        $data['total_item']=$cart_quantity;
                    }
                    else
                    {
                      $data['total_item']="0";
                    }
                  }
                else{
                    $data['total_item'] = "0";
                  }
                  
                 echo json_encode($data);
            }

            public function delete_from_cart(){
              $user_id=$this->input->post("user_id");
              $cart_id=$this->input->post("cart_id");

              $done=$this->db->query("delete from cart where cart_id = '".$cart_id."'");
              if($done)
              {
                    $data['responce'] = true;
                    $data['msg'] = "Product Delete From Cart Successfully";
                  }
                  
                 echo json_encode($data);
            }
            
            public function delete_cart(){
              $user_id=$this->input->post("user_id");
              $cart_id=$this->input->post("cart_id");

              $done=$this->db->query("delete from cart where user_id = '".$user_id."'");
                if($done)
                {
                    $data['responce'] = true;
                    $data['msg'] = "Empty Cart Successfully";
                }
                  
                 echo json_encode($data);
              }

            public function payment_success()
            {
              $order_id=$this->input->post("order_id");
              $amount=$this->input->post("amount");

              $this->db->query("UPDATE `sale` SET `is_paid`='".$amount."' WHERE `sale_id`='".$order_id."'");

            }

            public function update_cart(){

              $cart_id=$this->input->post("cart_id");
              $qty=$this->input->post("qty");
              
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cart_id', 'Cart ID', 'trim|required');
                $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }
                else
                {
                    $cart_update =$this->db->query("UPDATE `cart` SET `qty`='".$qty."' WHERE `cart_id`='".$cart_id."'");
    
                      if($cart_update){
                        $data['responce'] = true;
                        $data['msg'] = "Add update Successfull";
                      }
                      else{
                        $data['responce'] = false;
                        $data['msg'] = "Add Cart Not Successfull";
                      }
                }
                
                  
                
                 echo json_encode($data);

            }

            public function get_categories22(){
                $parent = 0 ;
                if($this->input->post("parent")){
                    $parent    = $this->input->post("parent");
                }
                $categories = $this->get_categories_short22($parent,0,$this) ;
                $data["responce"] = true;
                $data["data"] = $categories;
                echo json_encode($data);
                
            }
             public function get_categories_short22($parent,$level,$th){
                    $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                                 LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                                 WHERE a.`parent`=" . $parent." LIMIT 9");
                                
                                $return_array = array();
                                
                                foreach($q->result() as $row){
                                            if ($row->Count > 0) {
                                                $sub_cat =  $this->get_categories_short($row->id, $level + 1,$th);
                                                $row->sub_cat = $sub_cat;       
                                            } elseif ($row->Count==0) {
                                            
                                            }
                                    $return_array[] = $row;
                                }
                return $return_array;
            }
            
            public function get_categoriesz(){
                    $parent = 0 ;
                    if($this->input->post("parent")){
                        $parent    = $this->input->post("parent");
                    }
                $categories = $this->get_categories_shortz($parent,0,$this) ;
                $data["responce"] = true;
                $data["data"] = $categories;
                echo json_encode($data);
                
            }
             public function get_categories_shortz($parent,$level,$th){
                    $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                                 LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                                 WHERE a.`parent`=" . $parent. "");
                                
                                $return_array = array();
                                
                                foreach($q->result() as $row){
                                            if ($row->Count > 0) {
                                                $sub_cat =  $this->get_categories_shortz($row->id, $level + 1,$th);
                                                $row->sub_cat = $sub_cat;       
                                            } elseif ($row->Count==0) {
                                            
                                            }
                                    $return_array[] = $row;
                                }
                return $return_array;
            }

            public function ios_send_order(){
            error_reporting(0);
              $total_rewards = "";
              $total_price = "";
              $total_kg = "";
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                 $this->form_validation->set_rules('date', 'Date',  'trim|required');
                 $this->form_validation->set_rules('time', 'Time',  'trim|required');
                  $this->form_validation->set_rules('location', 'Location',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
                }else
                {
                     $ld = $this->db->query("select * from user_location where location_id = '".$this->input->post("location")."' limit 1");
                    $location = $ld->row(); 
                    
                    $delivery_charge=$this->input->post("delivery_charge");
                    $total_order_amount=$this->input->post("total_order_amount");
                    $store_id= $this->input->post("store_id");
                    $payment_method= $this->input->post("payment_method");
                    $date = date("Y-m-d", strtotime($this->input->post("date")));
                    //$timeslot = explode("-",$this->input->post("timeslot"));
                    
                    $times = explode('-',$this->input->post("time"));
                    $fromtime = date("h:i a",strtotime(trim($times[0]))) ;
                    $totime = date("h:i a",strtotime(trim($times[1])));
                    
                    // if coupon code using 
                    $previous_amount= $this->input->post("previous_amount");
                    $coupon_code= $this->input->post("coupon_code");
                    $used_amount= $this->input->post("used_amount");
                    //  ----------------//
                   
                    $user_id = $this->input->post("user_id");
                    $insert_array = array(
                    "user_id"=>$user_id,
                    "on_date"=>$date,
                    "delivery_time_from"=>$fromtime,
                    "delivery_time_to"=>$totime,
                    "delivery_address"=>$location->house_no."\n, ".$location->address,
                    "socity_id" => 0, 
                    "delivery_charge" => $delivery_charge,
                    "location_id" => $location->location_id, 
                    "payment_method" => $payment_method,
                    "new_store_id" => $store_id,
                    "previous_amount" => $previous_amount,
                    "coupon_code" => $coupon_code,
                    "used_amount" => $used_amount
                    );
                    
                    $this->load->model("common_model");
                    $id = $this->common_model->data_insert("sale",$insert_array);

                     $cart= $this->db->query("select * from cart WHERE user_id='".$user_id."'");
                     $cart_value= $cart->result();
                     foreach ($cart_value as $cart_value) {

                      $q = $this->db->query("Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
                          inner join categories on categories.id = products.category_id
                          left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
                          left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
                          left join deal_product dp on dp.product_id=products.product_id where products.product_id =  '".$cart_value->product_id."'");
                          $products =$q->result();
                          foreach ($products as  $product) 
                        {
                            $present = date('m/d/Y h:i:s a', time());
                            $date1 = $product->start_date." ".$product->start_time;
                            $date2 = $product->end_date." ".$product->end_time;

                           if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                           {
                              
                             if(empty($product->deal_price))   ///Runing
                             {
                                 $price= $product->price;
                             }else{
                                   $price= $product->deal_price;
                             }
                          
                           }else{
                            $price= $product->price;//expired
                           }


                           $qty_in_kg = $cart_value->qty; 
                        if($product->unit=="gram"){
                            $qty_in_kg =  ($cart_value->qty * $product->unit_value) / 1000;     
                        }
                        $total_rewards = $total_rewards + ($cart_value->qty * $product->rewards);
                        $total_price = $total_price + ($cart_value->qty * $product->price);
                        $total_kg = $total_kg + $qty_in_kg;
                        $total_items[$product->product_id] = $product->product_id;


                        $array = array("product_id"=>$product->product_id,
                        "qty"=>$cart_value->qty,
                        "unit"=>$product->unit,
                        "unit_value"=>$product->unit_value,
                        "sale_id"=>$id,
                        "price"=>$product->price,
                        "qty_in_kg"=>$qty_in_kg,
                        "rewards" =>$product->rewards,
                        "product_name" =>$product->product_name,
                        "product_image" =>$product->product_image
                        );
                        $this->common_model->data_insert("sale_items",$array);

                        }
                      
                     }

                     $total_price = $total_order_amount + $delivery_charge;
                    $this->db->query("Update sale set total_amount = '".$total_order_amount."', total_kg = '".$total_kg."', total_items = '".count($total_items)."', total_rewards = '".$total_rewards."' where sale_id = '".$id."'");
                  
                    // $commision= $this->product_model->get_store_list_by_id($store_id);
                    // $p=$commision->profit_percent;
                    // $user_fullname=$commision->user_fullname;
                    $data["responce"] = true;  
                    $data["data"] = addslashes( "<p>Your order No #".$id." is send success fully \n Our delivery person will delivered order \n 
                    between ".$fromtime." to ".$totime." on ".$date." \n
                    Please keep <strong>".$total_price."</strong> on delivery
                    Thanks for being with Us.</p>" );
                    //start delete cart itmes
                    
                    $done=$this->db->query("delete from cart where user_id = '".$user_id."'");
                    $store_detail=$this->db->query("select * from store_login where user_id = '".$store_id."'");
                    
                    $store_detail = $store_detail->row();
                    $user_fullname=$store_detail->user_fullname;
                    $store_share_charge=$store_detail->profit_percent;
                    $store_mobile=$store_detail->user_phone;
                    $store_device_token=$store_detail->user_ios_token;
                    //end delete cart itmes
                      //start commision part mine
                  
                  $method="Pay On Delivery";
                  $method1="Store Pick Up";
                  //$user_fullname= "Shri Ram Store";
                  if($payment_method==$method ||$payment_method==$method1)
                  {
                      $cod=0;
                      $status=0;
                      
                      if($store_share_charge>0)
                      {
                          $percent=($total_price*$store_share_charge) / 100;
                      }
                      else
                      {
                          $percent=0;
                      }
                        
              
                        $total=$total_price;
                        
                        $insert_array1 = array(
                         "amount" => $total,
                         "admin_share" => $percent,
                         "reason" => "order by id=".$id,
                         "store_id" =>$store_id ,
                         "store_name" => $user_fullname,
                         "payment_method" => $cod,
                         "on_date" => $date,
                         "status" => $status
                         );
                         
                    }
                    
                   
                  
                  else{
                      $online=1;
                      $status=0;
                      
                      if($store_share_charge>0)
                      {
                          $percent=($total_price*$store_share_charge) / 100;
                      }
                      else
                      {
                          $percent=0;
                      }
                      
                        $insert_array1 = array(
                         "amount" => $total_price,
                         "admin_share" => $q,
                         "reason" => "order by id=".$id,
                         "store_id" => $store_id,
                         "store_name" => $user_fullname,
                         "payment_method" => $online,
                         "on_date" => $date,
                         "status" => $status
                         );
                      
                  }
                  
                  
                  $this->load->model("common_model");
                  $id1 = $this->common_model->data_insert("commission",$insert_array1);
                  //end commision part mine

                  //start notification for customer
                  
                        $new_notify = "You Placed The New order";
                        $message11=array('title' => 'HHP Store', 'body' => $new_notify ,'sound'=>'Default','image'=>'Notification Image');
                        
                        $q = $this->db->query("Select user_ios_token from registers where user_id = '".$user_id."'");
                        $registers_customer = $q->row();
                        $token=$registers_customer->user_ios_token;
                        $result = $this->send_notification($token, $message11,"android");
                    //End notification for customer
                  
                    //start notification for store
                        $new_notify="New Order Received. Order ID Is #".$id;
                        $message11=array('title' => 'HHP Store Manager', 'body' => $new_notify ,'sound'=>'Default','image'=>'Notification Image');
                        
                        $result = $this->send_store_notification($store_device_token, $message11,"android");
                    //End notification for store
                    
                    //start msg for store
                        $sms_alert = $this->db->query("Select * from `message` where id='1'");
                        $rows=$sms_alert->row();
                        $status_NO_msg =$rows->msg_new_order;
                        $status_NO_email =$rows->mail_new_order;
                    
                        if($status_NO_msg==1)
                        {
                            $q = $this->db->query("Select * from registers where user_id = '".$user_id."'");
                            $rows=$q->row();
                            $customermobileNumber=$rows->user_phone;
                            
                            $message="Your order No #".$id." is successfully Placed \n Our delivery person will delivered order \n between ".$fromtime." to ".$totime." on ".$date." \n Your Total Amount of Order  is ".$total_price." \n Thanks for being with Us";
                        
                            $send_msg=$this->sms($customermobileNumber,$message);
                        }
                    //End msg for store    
                  
                
                // $q= $this->db->query("Select * from `registers` where `user_id`=".$user_id);
                //     $row=$q->row();
                //     $mobileNumber =$row->user_phone;
                //     $user_email =$row->user_email;
                //     $user_name =$row->user_fullname;
                //     
                     if($status_NO_email==1)
                        {
                      //$message="Thanks for your order";
                        //$location = $ld->row();
                        $address =$location->address;
                        $house_no =$location->house_no;
                      $subject="Order No. ".$id." Succesfully Placed";
                        //$p= "Your order No #".$id." is send success fully \n Our delivery person will delivered order \n between ".$fromtime." to ".$totime." on ".$date." \n Please keep ".$total_price." on delivery Thanks for being with Us";
                        $order['order']=array('id'=>$id, 'fromtime'=>$fromtime, 'totime'=>$totime,'date'=>$date,'total_price'=>$total_price,'user_name'=>$user_name,'subject'=>$subject,'address'=>$address,'house_no'=>$house_no);
                    
                        $send_email=$this->email_test($order,$id,$user_email,$subject);
                   
                    }
               
                    
                }
                echo json_encode($data);
        }
        
    public function demo()
    {
        //$this->load->view('api/template/email');
        $t=$this->input->post("store");
        $data['t']=$t;
        var_dump($data);
    }
     public function email_test($data,$id,$user_email,$subject){
        $this->load->library('email');
        
        $config['useragent']    = 'PHPMailer';
        $config['default_email'] = "noreply@hhpstores.com";
        $config['email_host'] = "noreply@hhpstores.com";
        $config['default_email_title'] = "Registration Confirm";
        $config['mailtype'] = "html";
        $config['wordwrap'] = TRUE;
        $config['charset'] = "utf-8";
        
        $this->email->initialize($config);
        //Email content
       
        // $htmlContent = '<h1>'.$message.'</h1>';
        // $htmlContent .= '<p>Dear '.$user_name.'</p>';
         //$htmlContent = '<p>'.$id.'</p>';
      
        //$data['user']=array('name'=>$user_name, 'msg'=>$message, 'email'=>$message);
       // $data = array();
       // $data['user']=array('name'=>$user_name);
       
        $item_id = $this->db->query("select * from sale_items where sale_id =".$id);
                    $data['items'] = $item_id->result(); 
        $mesg=$this->load->view('api/template/order',$data,true);
 
        $this->email->to($user_email);
        $this->email->from('noreply@hhpstores.com','HHP stores');
        $this->email->subject($subject);
       // $this->email->message($htmlContent);
        $this->email->message($mesg);
        $response=$this->email->send();
       
       
        
        //Send email
        
         return $response;
        
        echo $this->email->print_debugger();
    }
    
    // public function email_test_other($subject=1,$p=2){
    //     $this->load->library('email');
        
    //     $config['useragent']    = 'PHPMailer';
    //     $config['default_email'] = "noreply@thecodecafe.in";
    //     $config['email_host'] = "noreply@thecodecafe.in";
    //     $config['default_email_title'] = "Registration Confirm";
    //     $config['mailtype'] = "html";
    //     $config['wordwrap'] = TRUE;
    //     $config['charset'] = "utf-8";
        
    //     $this->email->initialize($config);
        
    //     $this->email->to('yadavmadhuri0444@gmail.com');
    //     $this->email->from('noreply@thecodecafe.in','Demo With View');
    //     $this->email->message("hello");
    //     $response=$this->email->send();
        
    //     echo $response;
    // }
    
   
        
     
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
        
        function add_coupons(){

        $this->load->helper('form');
        $this->load->model('product_model');
        $this->load->library('session');
       
        $this->load->library('form_validation');
        $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
        $this->form_validation->set_rules('from', 'From', 'required'); //|callback_date_valid
        $this->form_validation->set_rules('to', 'To', 'required'); //|callback_date_valid
        
        $this->form_validation->set_rules('value', 'Value', 'required|numeric');
        $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
        $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

        $data= array();
        if($this->form_validation->run() == FALSE)
        {
            $data["responce"] = false;  
            $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
             
        }else{
            $data = array(
            'coupon_name'=>$this->input->post('coupon_title'),
            'coupon_code'=> $this->input->post('coupon_code'),
            'valid_from'=> $this->input->post('from'),
            'valid_to'=> $this->input->post('to'),
            'validity_type'=> "",
            'product_name'=> "",
            'discount_type'=> "",
            'discount_value'=> $this->input->post('value'),
            'cart_value'=> $this->input->post('cart_value'),
            'uses_restriction'=> $this->input->post('restriction')
             );
             //print_r($data);
             if($this->product_model->coupon($data))
             {
                 $data["responce"] = true;  
                 $data["msg"] = 'Coupon Create Successfull';
             }
        }
       //$data['coupons'] = $this->product_model->coupon_list();
        echo json_encode($data);
        
    } 
    
        
    public function user_profile_detail(){
        error_reporting(0);
            $q =$this->db->query("Select * from registers where user_id = '".$this->input->post('detail_id')."'");
            $data['detail']=$q->result();
            //$q =$this->db->query("Select registers.*, user_location.* from registers left join user_location on user_location.user_id=registers.user_id where registers.user_id = '".$this->input->post('user_id')."'");
            $que =$this->db->query("Select user_location.* , socity.socity_name from user_location left join socity on socity.socity_id=user_location.socity_id where user_location.user_id = '".$this->input->post('detail_id')."'");
            foreach($que->result() as $addresses)
            {
                 $get[] = $addresses->receiver_name." , ".$addresses->house_no." ".$addresses->socity_name." ".$addresses->pincode."";
            }
            $data['address']=$get;
            echo json_encode($data);
        }
        
    public function purchase_history(){
        //error_reporting(0);
            $q =$this->db->query("Select * from sale where user_id = '".$this->input->post('user_id')."'");
            $data['purchase_history']=$q->result();
            echo json_encode($data);
        }
        
    public function order_by_salesman(){
        $create_by=$this->input->post("sales_id");
        $q =$this->db->query("Select * from sale where created_by = '".$create_by."'");
        $data['order']=$q->result();
        echo json_encode($data);
    }
        
    public function user_detail(){

            $this->load->model("product_model");
            $qry=$this->db->query("SELECT * FROM `registers` where user_id = '".$this->input->post('user_id')."'");
            $data["user"] = $qry->result();
            //$data["order"] = $this->product_model->get_sale_orders(" and sale.user_id = '".$user_id."' AND sale.status=4 ");
            echo json_encode($data);
            
    }
    public function wallet_at_checkout(){

    		 $id=$this->input->post('user_id');
             $q=$this->db->query("SELECT * FROM `registers` where user_id = '".$id."'");
             $row = $q->row();
             $profile_amount= $row->wallet;
             $wallet_amount=$this->input->post('wallet_amount');
             $new_wallet_amount=$profile_amount-$wallet_amount;

             $this->db->query("UPDATE registers set wallet = '".$new_wallet_amount."' WHERE user_id = '".$this->input->post('user_id')."'");

        }
        
    public function store_nearby(){
        
        $lat=$this->input->post('lat');
        $lng=$this->input->post('lng');
        $range='20';
        $q=$this->db->query("SELECT *, ( 6371 * acos( cos( radians(".$lat.") ) * cos( radians( lat ) ) * 
        cos( radians( lon ) - radians(".$lng.") ) + sin( radians(".$lat.") ) * 
        sin( radians( lat ) ) ) ) AS distance FROM store_login 
        WHERE user_status='1' 
        HAVING distance < delivery_range ORDER BY distance");
        
        $data["stores"]=$q->result();
        
        echo json_encode($data);
        
    }
    
    public function get_cate(){
            $store_id    = $this->input->post("store_id");
            $parent = 0 ;
            if($this->input->post("parent")){
                $parent    = $this->input->post("parent");
            }
        $categories = $this->cate_short($parent,0,$this,$store_id);
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
        
    }
    public function cate_short($parent,$level,$th,$store_id){
            $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent." AND a.store_id_login=".$store_id." AND a.status=1");
                        
                        $return_array = array();
                        
                        foreach($q->result() as $row){
                                    if ($row->Count > 0) {
                                        $sub_cat =  $this->cate_short($row->id, $level + 1,$th,$store_id);
                                        $row->sub_cat = $sub_cat;       
                                    } elseif ($row->Count==0) {
                                    
                                    }
                            $return_array[] = $row;
                        }
        return $return_array;
    }
    
    public function dp_filter_price()
    {
    
    $data = array();
    //$_POST = $_REQUEST;
    $store_id=$this->input->post('s_id');
    $order=$this->input->post('order');
    //error_reporting(1);
    $filter="";
    if($order==0)
    {
        $filter='ORDER BY deal_product.deal_price ASC';
    }
    if($order==1)
    {
        $filter='ORDER BY deal_product.deal_price DESC';
    }
    
    $q = $this->db->query("SELECT deal_product.*,products.*,categories.title,categories.id as cat_id from deal_product 
    inner JOIN products on deal_product.product_name = products.product_name 
    INNER JOIN categories on categories.id=products.category_id 
    where deal_product.store_id_login=".$store_id." ".$filter);
    
    // $this->db->query("SELECT dp.*,p.*,c.title from deal_product dp inner JOIN products p on dp.product_name = p.product_name INNER JOIN categories c on c.id=p.category_id limit 4");
   
    
    // $data['Deal_of_the_day']=array();
    foreach ($q->result() as $product) {

        $present = date('d-m-Y H:i');
        $present2 = strtotime(date('d-m-Y H:i'));
        $date1 = $product->start_date." ".$product->start_time;
        $date2 = $product->end_date." ".$product->end_time;
        $start_date = strtotime(str_replace("/", "-", $product->start_date." ".$product->start_time));
        $end_date = strtotime(str_replace("/", "-", $product->end_date." ".$product->end_time));

        // if($date1<=$present && $present<=$date2)
        //     { 
        //         $status = 1;    //running
        //         $price=$product->deal_price;
        //     }
        // else if($date1 > $present)
        //     { 
        //         $status = 2;    //is going to
        //         $price=$product->price;
        //     }
        // else
        //     {   
        //         $status = 0;    //expired
        //         $price=$product->price;
        //     }
        if($start_date <= $present2 && $present2<=$end_date )
            { 
                $status = 1;//running 
                $price=$product->deal_price;
            }
        else if($start_date > $present2)
            { 
                $status = 2;//is going to 
                $price=$product->price;
            }
        else
            {   
                $status = 0;//expired
                $price=$product->price;
            }
            
        $time_interval=($end_date-$present2)*1000;

         // if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
         // {
         //   $status = 1;//running 
         // }else if(strtotime($date1) > strtotime($present)){
         //  $status = 2;//is going to
         // }else{
         //  $status = 0;//expired
         // } 
        
        $data['responce']="false";
        
        if($status != 0)
        {
            $data['Deal_of_the_day'][] = array(
                    'product_id' => $product->product_id,
                    'product_name'=> $product->product_name,
                    'product_name_arb'=> $product->product_arb_name,
                    'product_description_arb'=>$product->product_arb_description,
                    'product_description'=>$product->product_description,
                    'deal_price'=>$price,
                    'start_date'=>$product->start_date,
                    'start_time'=>$product->start_time,
                    'end_date'=>$product->end_date,
                    'end_time'=>$product->end_time,
                    'time_interval'=>$time_interval,
                    'price' =>$price,
                    'mrp' =>$product->mrp,
                    'product_image'=>$product->product_image,
                    'status' => $status,
                    'in_stock' =>$product->in_stock,
                    'unit_value'=>$product->unit_value,
                    'unit'=>$product->unit,
                    'increament'=>$product->increament,
                    'rewards'=>$product->rewards,
                    'title'=>$product->title
                   
                );
            $data['responce']="true";
        }
                
        //$data['Deal_of_the_day'][]= $product;
    }
  echo json_encode($data);

  }
    
public function re_order(){
              error_reporting(0);
              //$user_id=$this->input->post("user_id");
                $order_id=$this->input->post("order_id");
                $sale_items = $this->db->query("select * from sale_items where sale_id =".$order_id);
                $count=$sale_items->num_rows();
                $sale_items=$sale_items->result();
               
               if($count<1)
               {
                $data['responce'] = false;   
                $data['message'] = "invalid order_id";  
                
               }
               else
               {
                 $i=1;
                foreach ($sale_items as $sale_item) 
                      {
                            
                            $id= $sale_item->product_id;
                            $order= $this->db->query("select * from sale where sale_id =".$order_id);
                            $order=$order->row();
                            $store_id= $order->new_store_id;
                          $store= $this->db->query("select user_id, user_fullname, user_image from store_login where user_id =".$store_id);
                          $store=$store->row();
                        //   $store_image= $store->user_image;
                        //   $name= $store->user_name;
                            // $store_name= $store->user_fullname;
                            
                          $q = $this->db->query("Select products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
            left join categories on categories.id = products.category_id
            left join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id 
            left join deal_product dp on dp.product_id=products.product_id
            WHERE products.product_id='".$id."'");
                          $products =$q->result();
                          
                foreach ($products as  $product) 
                        {
                            $present = date('m/d/Y h:i:s a', time());
                            $date1 = $product->start_date." ".$product->start_time;
                            $date2 = $product->end_date." ".$product->end_time;

                           if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
                           {
                              
                             if(empty($product->deal_price))   ///Runing
                             {
                                 $price= $product->price;
                             }else{
                                   $price= $product->deal_price;
                             }
                          
                           }else{
                            $price= $product->price;//expired
                           }
                            if($product->stock<1)
                            {
                            $stock="0";
                            }
                            else
                            {
                                $stock="1";
                            }
                            $data['responce'] = true;
                            $data['total_item']=$i;
                            $data['store_detail'] = $store;
                            $sum['total']=$price*$qty;
                            $sm=$sm+($price*$qty);
                            // array_push($data['total_amount'], $sm);
                           // $data['total_amount']=$sm;
                            $data['data'][] = array(
                          'product_id' => $product->product_id,
                          'product_name'=> $product->product_name,
                          'category_id'=> $product->category_id,
                          'product_description'=>$product->product_description,
                          'deal_price'=>'',
                          'start_date'=>"",
                          'start_time'=>"",
                          'end_date'=>"",
                          'end_time'=>"",
                          'price' =>$price,
                          'mrp' =>$product->mrp,
                          'product_image'=>$product->product_image,
                          //'tax'=>$product->tax,
                          'status' => '0',
                          'in_stock' =>$product->in_stock,
                          'unit_value'=>$product->unit_value,
                          'unit'=>$product->unit,
                          'increament'=>$product->increament,
                          'rewards'=>$product->rewards,
                          'stock'=>$stock,
                          'title'=>$product->title
                        //   'qty'=>$qty,
                        //   'cart_id'=>$cart_id,
                        //   'total_product_amount'=>$qty*$price
                         );
                        }  $i++;        
                
                      }
               }
                      echo json_encode($data);
            }

public function complain(){
            
                //$order_id=$this->input->post("order_id");
                $complain = $this->db->query("select * from complain");
                $complain=$complain->result();
                 echo json_encode($complain);
                      
            } 
            
            
public function product(){
        error_reporting(0);
         $sale_id=$this->input->post("order_id");
         if($sale_id!=0){
         $product = $this->db->query("select * from  sale_items where sale_id =".$sale_id );
          
          $data["responce"] = true;
         $data["list"] =$product->result();
         echo json_encode($data);
          
      }
      
       else{
                $data["responce"] = false;
                $data["list"]="";
                echo json_encode($data);
            }   
           
    }
    
   public function products_complain(){
    
         $data=array();
         
                $product_id = $this->input->post("product_id");
                $user_id = $this->input->post("user_id");
                $complain_id=$this->input->post("complain_id");
                if($product_id!="" && $user_id!="" && $complain_id!="" )
                 {    
             $user = $this->db->query("select * from  registers where user_id =".$user_id );
              $user_detail=$user->row();
                     
              $user_name=$user_detail->user_fullname; 
              $user_no=$user_detail->user_phone; 
              
                $product = $this->db->query("select * from  products where product_id =".$product_id );  
                 $prod_detail=$product->row();
                     
              $prod_image=$prod_detail->product_image; 
              $prod_name=$prod_detail->product_name; 
                $complain = $this->db->query("select * from  complain where complain_id =".$complain_id );  
                $comp_detail=$complain->row();
                     
                  $complain_name=$comp_detail->complain; 
                  
              
                $com_id= $this->db->insert("user_complain", array("product_id"=>$product_id,
                                            "product_image"=>$prod_image,
                                            "product_name"=>$prod_name,
                                             "user_id"=>$user_id,
                                              "user_name"=>$user_name,
                                             "user_contact"=>$user_no,
                                             "complain"=>$complain_name,
                                             "complain_id"=>$complain_id ));
                $data["responce"] = true;
                $data["message"] = "success";
               
                 }            
       
                else{
                $data["responce"] = false;
                $data["message"] = 'Not success';
            }             
                  
            echo json_encode($data);
         } 
    
    public function delivery_charge_detail(){
    
        $data=array();
         
        $user_id = $this->input->post("user_id");
             
        $this->db->select('*');
        $this->db->from('delivery_charge');
        $this->db->where('store_id', $user_id);
        $charge_detail=$this->db->get();
        
        if(count($charge_detail->result())>0)
        {
            $data['response']=true;  
            $data['charges']=$charge_detail->result();
        }
        else
        {
            $data['response']=false;  
            $data['charges']=array();
        }
        
        echo json_encode($data);
    
    }
    
    public function status_notification($user_id,$message){
        
        
        $message=array('title' => 'HHP Store', 'body' => $message ,'sound'=>'Default','image'=>'Notification Image');
                            
            $this->load->helper('gcm_helper');
            $gcm = new GCM();
            $q = $this->db->query("Select user_ios_token from registers where user_id='".$user_id."'");
            $registers = $q->row();
            $result = $this->send_notification($registers->user_ios_token, $message,"android");
            return $result;
    }
    
    public function home_banner()
    {
        
                    $this->db->select('*');
                    $this->db->from('app_dashboard_banner');
                    $this->db->where('slider_status',1);
                    $query = $this->db->get();
                    $data['count']=$query->num_rows();
                    $data['data']=$query->result();
                    
            
            echo json_encode($data);
    }
    
    public function pickup()
    {
        $order_id=$this->input->post("sale_id");
        
        $this->db->query("update sale set status = 2 where sale_id = '".$order_id."'");
        
        $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            
            $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
            $user = $q->row();
            
            $q = $this->db->query("Select * from store_login where user_id = '".$order->new_store_id."'");
            $store = $q->row();
            
            $q = $this->db->query("Select * from delivery_boy where user_name = '".$order->assign_to."'");
            $boy = $q->row();

                $message["title"] = "Delivered  Order";
                $message["body"] = "Your order Number '".$order->sale_id."'PickUp By Delivery Boy";
                $message["image"] = "";
                $message["created_at"] = date("Y-m-d h:i:s");
                $message["obj"] = "";
                $result = $this->send_notification(array($user->user_ios_token),$message ,"android");
                
                
                $message2["title"] = "HHP Store Manager";
                $message2["body"] = "Delivery Boy Picked The order Number '".$order->sale_id."' ";
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
                $status_CO_msg =$rows->msg_pickupby_dboy;
                $status_CO_mail =$rows->mail_pickupby_dboy;
                
                if($status_CO_msg==1)
                {
                
                $message="Your order Number '".$order_id."' is out For Delivery. Your Delivery Boy is ".$boy->user_name.". Now you can call him on ".$boy->user_phone." to know about your Order status.";
                
                $send_msg=$this->sms($mobileNumber,$message);
                }

                if($status_CO_mail==1)
                {
                    // $subject=" Order No.# ".$order_id." Delivered";
                    // print_r($data['order']=array('user_name'=>$name_user,'order_id'=>$order_id));
                    // $send_email=$this->email_test_compelete($subject,$data,$email_user);
                }
        
                                            
            $data['status']=true;
        
        echo json_encode($data);
    }
    
    public function change_boy_status()
    {
        $boy_id=$this->input->post("delivery_boy_id");
        $status=$this->input->post("delivery_boy_status");
        
        $this->load->model("common_model");
        $update=$this->common_model->data_update("delivery_boy", array("work_status"=>$status),
                                            array("id"=>$boy_id));
                                            
        if($status==1)
        {
            $data['status']=true;
        }
        if($status==0)
        {
            $data['status']=false;
        }
        echo json_encode($data);
    }
    
    public function confirm_by_store()
    {
        $order_id=$this->input->post("sale_id");
        
        $this->db->query("update sale set status = 1 where sale_id = '".$order_id."'");
                                            
            $data['status']=true;
        
        echo json_encode($data);
    }
    
    public function rtp_by_store()
    {
        $order_id=$this->input->post("sale_id");
        
        $this->db->query("update sale set status = 5 where sale_id = '".$order_id."'");
                                            
            $data['status']=true;
        
        echo json_encode($data);
    }
    
    public function cancel_by_store()
    {
        $order_id=$this->input->post("sale_id");
        
        $this->db->query("update sale set status = 3 where sale_id = '".$order_id."'");
        
                    $this->load->model("product_model");
                    $order = $this->product_model->get_sale_order_by_id($this->input->post("sale_id"));
                    
                    $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                    $user = $q->row(); 
                     
                    $q = $this->db->query("Select * from store_login where user_id = '".$order->new_store_id."'");
                    $store = $q->row(); 
                      
                            $message1["title"] = "Cancel Order";
                            $message1["body"] = "Your order Number '".$order->sale_id."' cancel ";
                            $message1["image"] = "";
                            $message1["created_at"] = date("Y-m-d h:i:s"); 
                            $message1["obj"] = "";  
                        
                        $result = $this->send_notification($user->user_ios_token,$message1 ,"android");
                        
                        
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
                            
                            $message_new="Sorry For Inconvenience. \n Your Order No. #".$this->input->post("sale_id")." has been cancelled.";
                        
                            $send_msg=$this->sms($customermobileNumber,$message_new);
                        }
                        
                        if($status_NO_email==1)
                        {
                            // $address =$location->address;
                            // $house_no =$location->house_no;
                            // $subject="Order No. ".$id." Succesfully Placed";
                            // $send_email=$this->email_test($order,$id,$user_email,$subject);
                       
                        }
                                            
        $data['status']=true;
        
        echo json_encode($data);
    }
    
    public function get_deliveryboy_deviceid(){
            $data = array();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
            $this->form_validation->set_rules('token', 'Token', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
            {
                $data["responce"] = false;
               $data["error"] = $this->form_validation->error_string();
            }else
            {   
                $token =  $this->input->post("token");
                $user_id =$this->input->post("user_id");
                
                $this->db->query("update delivery_boy set device_id = '".$token."' where id = '".$user_id."'");
                $data["responce"] = true;    
            }
            echo json_encode($data);
    }
    
    public function get_store_manager_deviceid(){
            $data = array();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
            $this->form_validation->set_rules('token', 'Token', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
            {
                $data["responce"] = false;
               $data["error"] = $this->form_validation->error_string();
            }else
            {   
                $token =  $this->input->post("token");
                $user_id =$this->input->post("user_id");
                
                $this->db->query("update store_login set user_ios_token = '".$token."' where user_id = '".$user_id."'");
                $data["responce"] = true;    
            }
            echo json_encode($data);
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
    
}