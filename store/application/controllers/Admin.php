<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->helper('login_helper');
        $this->load->helper('sms_helper');
    }
    function signout(){
        $this->session->sess_destroy();
        redirect("admin");
    }
	public function index()
	{
// 		if(_is_user_login($this)){
//             redirect(_get_user_redirect($this));
//         }else{
            
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
                   
                    $q = $this->db->query("Select * from `store_login` where (`user_email`='".$this->input->post("email")."') and user_password='".md5($this->input->post("password"))."' limit 1");
                    
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
                                                   'user_name'  => $row->user_fullname,
                                                   'user_email'     => $row->user_email,
                                                   'logged_in' => TRUE,
                                                   'user_id'=>$row->user_id,
                                                   'user_type_id'=>$row->user_type_id
                                                  );
                            $this->session->set_userdata($newdata);
                            redirect(_get_user_redirect($this));
                         
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
            
            $this->load->view("admin/login",$data);
        // }
	}
    public function dashboard(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            
            $date = date("Y-m-d");
            $user_id=_get_current_user_id($this);
            $data["today_orders"] = $this->product_model->get_sale_orders(" and sale.on_date = '".$date."' ",$user_id);
             $nexday = date('Y-m-d', strtotime(' +1 day'));
            $data["nextday_orders"] = $this->product_model->get_sale_orders(" and sale.on_date = '".$nexday."' ",$user_id);
            $this->load->view("admin/dashboard",$data);
        }
        else
        {
            redirect("admin");
        }
    }

    public function orders(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            $fromdate = date("Y-m-d");
            $todate = date("Y-m-d");
            $data['date_range_lable'] = $this->input->post('date_range_lable');
           
             $filter = "";
             $user_id=_get_current_user_id($this);
            if($this->input->post("date_range")!=""){
				$filter = $this->input->post("date_range");
			    $dates = explode(",",$filter);                
                $fromdate =  date("Y-m-d", strtotime($dates[0]));
                $todate =  date("Y-m-d", strtotime($dates[1])); 
                $filter = " and sale.on_date >= '".$fromdate."' and sale.on_date <= '".$todate."' ";
            }
            $data["today_orders"] = $this->product_model->get_sale_orders($filter,$user_id);
            
            $this->load->view("admin/orders/orderslist",$data);
        }
        else
        {
            redirect("admin");
        }
    }

    public function confirm_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set status = 1 where sale_id = '".$order_id."'");
                 $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                                $message["title"] = "Confirmed  Order";
                                $message["body"] = "Your order Number '".$order->sale_id."' confirmed successfully";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_gcm_code != ""){
                            $result = $this->send_notification(array($user->user_gcm_code),$message ,"android");
                            }
                             if($user->user_ios_token != ""){
                            $result = $this->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order confirmed. </div>');
            }
            redirect("admin/orders");
        }
        else
        {
            redirect("admin");
        }
    }
     public function demo(){
    $this->load->view('admin/template/account');
     }
    public function delivered_order($order_id){
        if(_is_user_login($this)){
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
            redirect("admin/orders");
        }
        else
        {
            redirect("admin");
        }
    }

    public function cancle_order($order_id){
        if(_is_user_login($this)){
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
                
                                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order Cancle. </div>');
            }
            redirect("admin/orders");
        }
        else
        {
            redirect("admin");
        }
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
    
    
    public function delete_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("delete from sale where sale_id = '".$order_id."'");
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order deleted. </div>');
            }
            redirect("admin/orders");
        }
        else
        {
            redirect("admin");
        }
    }

    public function orderdetails($order_id){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            $data["order"] = $this->product_model->get_sale_order_by_id($order_id);
            $data["order_items"] = $this->product_model->get_sale_order_items($order_id);
            $this->load->view("admin/orders/orderdetails",$data);
        }
        else
        {
            redirect("admin");
        }
    }

    public function change_status(){
        $table = $this->input->post("table");
        $id = $this->input->post("id");
        $on_off = $this->input->post("on_off");
        $id_field = $this->input->post("id_field");
        $status = $this->input->post("status");
        
        $this->db->update($table,array("$status"=>$on_off),array("$id_field"=>$id));
    }
    
   
/*=========USER MANAGEMENT==============*/   
    public function user_types(){
        $data = array();
        if(isset($_POST))
            {
                
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
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
                        $user_type = $this->input->post("user_type");
                        
                            $this->load->model("common_model");
                            $this->common_model->data_insert("user_types",array("user_type_title"=>$user_type));
                            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Type added Successfully
                                </div>') ;
                             redirect("admin/user_types/");   
                        
                }
            }
        
        $this->load->model("users_model");
        $data["user_types"] = $this->users_model->get_user_type();
        $this->load->view("admin/user_types",$data);
    }

    public function user_type_delete($type_id){
        $data = array();
            $this->load->model("users_model");
            $usertype  = $this->users_model->get_user_type_id($type_id);
           if($usertype){
                $this->db->query("Delete from user_types where user_type_id = '".$usertype->user_type_id."'");
                redirect("admin/user_types");
           }
    }

    public function user_access($user_type_id){
        if($_POST){
           //print_r($_POST);     
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_type_id', 'User Type', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		   if($this->form_validation->error_string()!=""){
        		      	$data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                 }
      		    }else{
      		        //$user_type_id = $this->input->post("user_type_id");
      		        $this->load->model("common_model");
                    $this->common_model->data_remove("user_type_access",array("user_type_id"=>$user_type_id));
                    
                    $sql = "Insert into user_type_access(user_type_id,class,method,access) values";
                    $sql_insert = array();
                    foreach(array_keys($_POST["permission"]) as $controller){
                        foreach($_POST["permission"][$controller] as $key=>$methods){
                            if($key=="all"){
                                $key = "*";
                            }
                            $sql_insert[] = "($user_type_id,'$controller','$key',1)";
                        }
                    }
                    $sql .= implode(',',$sql_insert)." ON DUPLICATE KEY UPDATE access=1";
                    $this->db->query($sql);
      		    }
        }
        $data['user_type_id'] = $user_type_id;
        $data["controllers"] = $this->config->item("controllers");
        $this->load->model("users_model");
        $data["user_access"] = $this->users_model->get_user_type_access($user_type_id);
        
        //$data["user_types"] = $this->users_model->get_user_type();
        $this->load->view("admin/user_access",$data);
    }
/*============USRE MANAGEMENT===============*/

  
/* ========== Categories =========== */
    public function addcategories()
	{
	   if(_is_user_login($this)){
	       
            $data["error"] = "";
            $data["active"] = "addcat";
            $data["store_id"]=_get_current_user_id($this);
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
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
                    $this->load->model("category_model");
                    $this->category_model->add_category(); 
                   // $data["allcat"] = $this->category_model->get_categories();
                     $data["allcat"] =$this->category_model->get_store_categories();
                     

                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                   redirect('admin/listcategories_store');
                    
                    
               	}
               
            }
	   	$this->load->view('admin/categories/addcatm1',$data);
        }
        
        else
        {
            redirect('admin');
        }
        //	$this->load->view('admin/categories/listcatm1',$data);
	}
    
    public function editcategory($id)
	{
	   if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `categories` WHERE id=".$id);
            $data["getcat"] = $q->row();
            
	        $data["error"] = "";
            $data["active"] = "listcat";
            if(isset($_REQUEST["savecat"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                // $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
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
                    $this->load->model("category_model");
                    $this->category_model->edit_category($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/listcategories_store');
               	}
            }
	   	   $this->load->view('admin/categories/editcatm1',$data);
        }
        else
        {
            redirect('admin');
        }
	}
    
    public function listcategories()
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "listcat";
         $this->load->model("category_model");
          $data["allcat"] = $this->category_model->get_categories();
           $this->load->view('admin/categories/listcatm1',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function listcategories_store()
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "listcat";
         $this->load->model("category_model");
          $data["allcat"] = $this->category_model->get_store_categories();
           $this->load->view('admin/categories/listcatm1',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    //mine
    // function liscat()
    // {
    //     if(_is_user_login($this))
    //     {

            
    //         $this->load->view("admin/categories/listcatm");
    //     }
    // else
    //     {
    //         redirect('admin');
    //     }
    
    //  }
    
    
    
    //mine
    
    public function deletecat($id)
	{
	   if(_is_user_login($this)){
	        
            $this->db->delete("categories",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('admin/listcategories_store');
        }
        else
        {
            redirect('admin');
        }
    }

      
/* ========== End Categories ========== */    
/* ========== Products ==========*/
    public function products(){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $data["products"]  = $this->product_model->get_products1();
            $this->load->view("admin/product/listm1",$data); 
        }
        else
            {
                redirect("admin");
            }
    }
 
// start  mine- products list by store_id//

public function products1(){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $data["products"]  = $this->product_model->get_products1();
            $this->load->view("admin/product/listm1",$data); 
        }
        else
            {
                redirect("admin");
            }
}
// end  mine- products list by store_id//

    public function edit_products($prod_id){
	    if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
        		}
        		else
        		{
                    $this->load->model("common_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"), 
                    "product_description"=>$this->input->post("product_description"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "mrp"=>$this->input->post("mrp"),
                    "price"=>$this->input->post("price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"), 
                    "rewards"=>$this->input->post("rewards")
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = '../uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_update("products",$array,array("product_id"=>$prod_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/products');
               	}
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->get_product_by_id($prod_id);
           
            $this->load->view("admin/product/edit",$data);
        }
        else
        {
            redirect('admin');
        }
    
    }

    public function add_products(){
	    if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                 $this->form_validation->set_rules('price', 'price', 'trim|required');
                $this->form_validation->set_rules('qty', 'qty', 'trim|required'); 
                
                if ($this->form_validation->run() == FALSE)
        		{
        		      if($this->form_validation->error_string()!="") { 
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
        		}
        		else
        		{
                    if($this->input->post("rewards")=="")
                    {
                        $rewards=0;
                    }
                    else
                    {
                        $rewards=$this->input->post("rewards");
                    }
                    $this->load->model("common_model");
                    //$this->load->model("Users_model");
                    // print_r($data["purchasesm"]  = $this->Users_model->get_user_by_id_store3());
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                   // "product_arb_name"=>$this->input->post("arb_prod_title"), 
                   // "product_arb_description"=>$this->input->post("arb_product_description"), 
                    "category_id"=>$this->input->post("parent"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "product_description"=>$this->input->post("product_description"),
                    "price"=>$this->input->post("price"),
                    "mrp"=>$this->input->post("mrp"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"), 
                  //  "arb_unit"=>$this->input->post("arb_unit"), 
                    "tax"=>0, 
                   // "rewards"=>$rewards,
                   "store_id_login"=>$this->input->post("store_id_login")
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = '../uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            // $array["product_image"]=$img_data['file_name'];
                            $array["product_image"]=$_FILES["prod_img"]["name"];
                        }
                        
                   }
                    
                    $in_id = $this->common_model->data_insert("products",$array); 
                    // $purchaasr=$this->db->query("Insert into purchase(product_id, qty, unit, date, store_id_login) values('".$in_id."', 1, '".$this->input->post("unit")."', '".date('d-m-y h:i:s ')."', '"._get_current_user_id($this)."')");
                    // if($purchaasr){ $m=1; }else{ $m=0; }
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully..."'.$in_id.'"
                                    </div>');
                                    
                    $this->load->model("common_model");
                        $array = array(
                        "product_id"=>$in_id,
                        "qty"=>$this->input->post("stk_qty"),
                       
                        "unit"=>$this->input->post("unit"),
                       "store_id_login"=>$this->input->post("store_id_login")
                        );
                    $this->common_model->data_insert("purchase",$array);                 
                   // redirect('admin/add_purchasestore/'.$in_id);
                   redirect('admin/products/');
                  // $this->load->view("admin/product/listm1",$data);
                }
                //$this->load->view("admin/product/addm1");
            }
            
            $this->load->view("admin/product/addm2");
        }
        else
        {
            redirect('admin');
        }
    
    }

// start mine purchase//
public function add_purchasestore($prod_id){
        if(_is_user_login($this)){
            //start add in purchase table//
            if(isset($_POST['addcatg']))
                {
                    $this->load->library('form_validation');
                  // $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
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
                                          <strong>Success!</strong> Your request added successfully..."'._get_current_user_id($this).'"
                                        </div>');
                        redirect("admin/products1");
                    }
                    
                    $this->load->model("product_model");
                    //$data["purchases"]  = $this->product_model->get_purchase_list();;
                    //$data["products"]  = $this->product_model->get_products();
                   // $this->load->view("admin/product/purchase",$data);  
                    
                }
            //end add data in purchase table//
    	   
          
                    $this->load->model("product_model");
                    print_r($data["purchases"]  = $this->product_model->get_purchasestore_by_id($prod_id));
                    
                   //$data["products"]  = $this->product_model->get_products();
                
                    //$this->load->view("admin/product/purchase",$data); 
                
            $this->load->view("admin/product/addm1",$data); 
            
        }
        else
        {
            redirect("admin");
        }
        
    }
// end mine purchase//
//start mine add product
function add_product(){
       if(_is_user_login($this)){
       
            $this->load->view("admin/product/add2");
        }
        else
        {
            redirect('admin');
        }
    
}
// end mine add product

    public function delete_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from products where product_id = '".$id."'");
            $this->db->query("Delete from purchase where product_id = '".$id."'");
            redirect("admin/products");
        }
        else
        {
            redirect("admin");
        }
}
/* ========== Products ==========*/  
/* ========== Purchase ==========*/
    public function add_purchase(){
        if(_is_user_login($this)){
    	    
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
                    $data["purchases"]  = $this->product_model->get_purchase_list();;
                    $data["products"]  = $this->product_model->get_products();
                    $this->load->view("admin/product/purchase",$data);  
                    
                }
        }
        else
        {
            redirect("admin");
        }
        
    }

    public function edit_purchase($id){
        if(_is_user_login($this)){
    	    
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
            		   echo $new_qty=$this->input->post("new_qty");
            		   $qty=$this->input->post("qty");
            		   $net_qty=$new_qty+$qty;
            		   
          		  
                        $this->load->model("common_model");
                        $array = array(
                        "product_id"=>$this->input->post("product_id"),
                        "qty"=>$net_qty,
                        
                        // "price"=>$this->input->post("price"),
                        "unit"=>$this->input->post("unit")
                        );
                        $this->common_model->data_update("purchase",$array,array("purchase_id"=>$id));
                        
                        $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                        redirect("admin/stock");
                    }
                    
                    $this->load->model("product_model");
                   $data["purchase"]  = $this->product_model->get_purchase_by_id($id);
                    $data["products"]  = $this->product_model->get_products();
                    $this->load->view("admin/product/edit_purchase",$data);  
                    
                }
        }
        else
        {
            redirect("admin");
        }
    }

    public function delete_purchase($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from purchase where purchase_id = '".$id."'");
            redirect("admin/add_purchase");
        }
        else
        {
            redirect("admin");
        }
    }
/* ========== Purchase END ==========*/

    public function socity(){
        if(_is_user_login($this)){
	    
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
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/socity");
                }
                
                $this->load->model("product_model");
                $data["socities"]  = $this->product_model->get_socities();
                $this->load->view("admin/socity/list",$data);  
                
            }
        }
        else
        {
            redirect("admin");
        }
        
    }
    public function edit_socity($id){
        if(_is_user_login($this)){
	    
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
                    $this->common_model->data_update("socity",$array,array("socity_id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/socity");
                }
                
                $this->load->model("product_model");
                $data["socity"]  = $this->product_model->get_socity_by_id($id);
                $this->load->view("admin/socity/edit",$data);  
                
            }
        }
        else
        {
            redirect("admin");
        }
        
    }
    public function delete_socity($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from socity where socity_id = '".$id."'");
            redirect("admin/socity");
        }
        else
        {
            redirect("admin");
        }
    }

    public function registers(){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $users = $this->product_model->get_all_users();
            $this->load->view("admin/allusers",array("users"=>$users));
        }
        else
        {
            redirect("admin");
        }
    }
 
 /* ========== Page app setting =========*/
    public function addpage_app(){
	    if(_is_user_login($this))
        {
	       
            $data["error"] = "";
            $data["active"] = "addpageapp"; 
            
            if(isset($_REQUEST["addpageapp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('page_title', 'Page  Title', 'trim|required');
                $this->form_validation->set_rules('page_descri', 'Page Description', 'trim|required');
                if ($this->form_validation->run() == FALSE)
        		{
        		  if($this->form_validation->error_string()!="")
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
        		}
        		else
        		{
                    $this->load->model("page_app_model");
                    $this->page_app_model->add_page(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Page added successfully...</div>');
                    redirect('admin/addpage_app');
               	}
            }
            $this->load->view('admin/page_app/addpage_app',$data);
        }
        else
        {
            redirect("admin");
        }
    }
    
    public function allpageapp()
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "allpage";
           
           $this->load->model("page_app_model");
           $data["allpages"] = $this->page_app_model->get_pages();
           
           $this->load->view('admin/page_app/allpage_app',$data);
        }
        else
        {
            redirect("admin");
        }
    }

    public function editpage_app($id)
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "allpage";
           
           $this->load->model("page_app_model");
           $data["onepage"] = $this->page_app_model->one_page($id);
           
           if(isset($_REQUEST["savepageapp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
                $this->form_validation->set_rules('page_id', 'Page Id', 'trim|required');
                $this->form_validation->set_rules('page_descri', 'Page Description', 'trim|required');
                if ($this->form_validation->run() == FALSE)
        		{
        		  if($this->form_validation->error_string()!="")
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
        		}
        		else
        		{
                    $this->load->model("page_app_model");
                    $this->page_app_model->set_page(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your page saved successfully...</div>');
                    redirect('admin/allpageapp');
               	}
            }
           $this->load->view('admin/page_app/editpage_app',$data);
        }
        else
        {
            redirect("admin");
        }
    }

    public function deletepageapp($id)
	{
	   if(_is_user_login($this)){
	        
            $this->db->delete("pageapp",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your page deleted successfully...
                                    </div>');
            redirect('admin/allpage_app');
        }
        else
        {
            redirect("admin");
        }
    }

/* ========== End page page setting ========*/

    public function setting(){
        if(_is_user_login($this)){
    	      $this->load->model("setting_model"); 
                    $data["settings"]  = $this->setting_model->get_settings(); 
                  
                    $this->load->view("admin/setting/settings",$data);  
                    
                
        }
        else
        {
            redirect("admin");
        }
    }

    public function edit_settings($id){
        if(_is_user_login($this)){
    	    
                if(isset($_POST))
                {
                    $this->load->library('form_validation');
                     
                    $this->form_validation->set_rules('value', 'Amount', 'trim|required');
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
                        "title"=>$this->input->post("title"), 
                        "value"=>$this->input->post("value")
                        );
                        
                        $this->common_model->data_update("settings",$array,array("id"=>$id));
                        
                        $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                        redirect("admin/setting");
                    }
                    
                    $this->load->model("setting_model");
                    $data["editsetting"]  = $this->setting_model->get_setting_by_id($id);
                    $this->load->view("admin/setting/edit_settings",$data);  
                    
                }
        }
        else
        {
            redirect("admin");
        }
    }
    
    public function stock(){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            //$data["stock_list"] = $this->product_model->get_leftstock();
            $data["purchases"]  = $this->product_model->get_purchase_list();
            //$data["products"]  = $this->product_model->get_products();
           // $this->load->view("admin/product/stock",$data);
            $this->load->view("admin/product/stock_alerts",$data);
        }
        else
        {
            redirect("admin");
        }
    }
/* ========== End page page setting ========*/
   public function testnoti(){
        $token =  "flbcqPKhZSk:APA91bE1akFG5ixG8DS8E1rG0tza67cTzwaohJm5NjrDu0HqZfmHKsBOubtu78njQNuTLHr5lbFtd888FmazUVzmD6wSZ6IJPSM9gaYOfVLvcESVrqvo0qaZgNi4lVqteM1xgzQe5-yL";
    }

    public function notification(){
        if(_is_user_login($this)){
	    
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
                      $message["title"] = $this->config->item("company_title");
                                $message["message"] = $this->input->post("descri");
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s");  
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            //$result = $gcm->send_topics("/topics/rabbitapp",$message ,"ios"); 
                            
                            $result = $gcm->send_topics("/topics/grocery",$message ,"android");
                            
                            $q = $this->db->query("Select user_ios_token from users");
                            $registers = $q->result();
                      foreach($registers as $regs){
                         if($regs->user_ios_token!="")
                                 $registatoin_ids[] = $regs->user_ios_token;
                     }
                     if(count($registatoin_ids) > 1000){
                      
                      $chunk_array = array_chunk($registatoin_ids,1000);
                      foreach($chunk_array as $chunk){
                       $result = $gcm->send_notification($chunk, $message,"ios");
                      }
                      
                     }else{
    
                       $result = $gcm->send_notification($registatoin_ids, $message,"ios");
                        }  
                            
                             redirect("admin/notification");
                  }
                   
                   $this->load->view("admin/product/notification");
                
            }
        }
        else
        {
            redirect("admin");
        }    
    }
    
    public function time_slot(){
        if(_is_user_login($this)){
                $this->load->model("time_model");
                $timeslot = $this->time_model->get_time_slot();
                
                $this->load->library('form_validation');
                $this->form_validation->set_rules('opening_time', 'Opening Hour', 'trim|required');
                $this->form_validation->set_rules('closing_time', 'Closing Hour', 'trim|required');
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
        		  if(empty($timeslot)){
                    $q = $this->db->query("Insert into time_slots(opening_time,closing_time,time_slot) values('".date("H:i:s",strtotime($this->input->post('opening_time')))."','".date("H:i:s",strtotime($this->input->post('closing_time')))."','".$this->input->post('interval')."')");
                  }else{
                    $q = $this->db->query("Update time_slots set opening_time = '".date("H:i:s",strtotime($this->input->post('opening_time')))."' ,closing_time = '".date("H:i:s",strtotime($this->input->post('closing_time')))."',time_slot = '".$this->input->post('interval')."' ");
                  }  
                }            
            
            $timeslot = $this->time_model->get_time_slot();
            $this->load->view("admin/timeslot/editm",array("schedule"=>$timeslot));
        }
        else
        {
            redirect("admin");
        }
    }

    public function closing_hours(){
        if(_is_user_login($this)){
            $this->load->library('form_validation');
                    $this->form_validation->set_rules('date', 'Date', 'trim|required');
                    $this->form_validation->set_rules('opening_time', 'Start Hour', 'trim|required');
                    $this->form_validation->set_rules('closing_time', 'End Hour', 'trim|required');
                    
                    $store_id=_get_current_user_id($this);
                    
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
                          $array = array("date"=>date("Y-m-d",strtotime($this->input->post("date"))),
                          "from_time"=>date("H:i:s",strtotime($this->input->post("opening_time"))),
                          "to_time"=>date("H:i:s",strtotime($this->input->post("closing_time"))),
                          "store_id"=>$store_id
                          ); 
                          $this->db->insert("closing_hours",$array); 
                    }
            
             $this->load->model("time_model");
             $timeslot = $this->time_model->get_closing_date(date("Y-m-d"),$store_id);
             $this->load->view("admin/timeslot/closing_hours",array("schedule"=>$timeslot));
        }
        else
        {
            redirect("admin");
        }
    }
    
     
    public function delete_closing_date($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from closing_hours where id = '".$id."'");
            redirect("admin/closing_hours");
        }
        else
        {
            redirect("admin");
        }
    }

    public function addslider()
	{
	   if(_is_user_login($this)){
	       
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
        		{
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
        		}
        		else
        		{
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    // "slider_url"=>$this->input->post("slider_url"),
                                    "store_id_login"=>$this->input->post("store_id_login")
                                    );
                    
                        if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = '../uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                       
                       $this->db->insert("slider",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/listslider');
               	}
            }
	   	$this->load->view('admin/slider/addslider',$data);
        }
        else
        {
            redirect("admin");
        }
	}
 
    public function listslider()
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->get_slider();
           $this->load->view('admin/slider/listslider2',$data);
        }
        else
        {
            redirect("admin");
        }
    }

    public function editslider($id)
	{
	    if(_is_user_login($this))
        {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_slider_by_id($id);
           
	        $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
        		{
        		  if($this->form_validation->error_string()!="")
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
        		}
        		else
        		{
                    $this->load->model("slider_model");
                    $this->slider_model->edit_slider($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/listslider');
               	}
            }
	   	   $this->load->view('admin/slider/editslider2',$data);
        }
        else
        {
            redirect("admin");
        }
	}
    public function deleteslider($id){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("slider_model");
            $slider  = $this->slider_model->get_slider_by_id($id);
           if($slider){
                $this->db->query("Delete from slider where id = '".$slider->id."'");
                unlink("uploads/sliders/".$slider->slider_image);
                redirect("admin/listslider");
           }
        }
        else
        {
            redirect("admin");
        }
    }  
   
   public function banner()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->banner();
           $this->load->view('admin/banner/listslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    public function add_Banner()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
                {
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    // "slider_url"=>$this->input->post("slider_url"),
                                    "sub_cat"=>$this->input->post("sub_cat"),
                                    "store_id_login"=>$this->input->post("store_id_login")
                                    );
                    
                        if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = '../uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                       
                       $this->db->insert("banner",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/banner');
                }
            }
        $this->load->view('admin/banner/addslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function edit_banner($id)
    {
       if(_is_user_login($this))
       {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_banner($id);
           
            $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("slider_model");
                    $this->slider_model->edit_banner($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/banner');
                }
            }
           $this->load->view('admin/banner/editslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
     public function delete_banner($id){
        if(_is_user_login($this))
        {
            $data = array();
            $this->db->query("Delete from banner where id = '".$id."'");
            unlink("uploads/sliders/".$slider->slider_image);
            redirect("admin/banner");
        }
        else
        {
            redirect('admin');
        }   
           
    }
    
    public function feature_banner()
    {
       if(_is_user_login($this)){
           $data["error"] = "";
           $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->feature_banner();
           $this->load->view('admin/feature_banner/listslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function add_feature_Banner()
    {
       if(_is_user_login($this)){
           
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
                {
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    "slider_url"=>$this->input->post("slider_url"),
                                    "sub_cat"=>$this->input->post("sub_cat"),
                                    "store_id_login"=>$this->input->post("store_id_login")
                                    );
                    
                        if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = './uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                       
                       $this->db->insert("feature_slider",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/feature_banner');
                }
            }
        $this->load->view('admin/feature_banner/addslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }
        
    public function edit_feature_banner($id)
    {
       if(_is_user_login($this))
       {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_feature_banner($id);
           
            $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
                {
                  if($this->form_validation->error_string()!="")
                      $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                }
                else
                {
                    $this->load->model("slider_model");
                    $this->slider_model->edit_feature_banner($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/feature_banner');
                }
            }
           $this->load->view('admin/feature_banner/editslider2',$data);
        }
        else
        {
            redirect('admin');
        }
    }

    public function delete_feature_banner($id){
        if(_is_user_login($this)){
            $data = array();
            $this->db->query("Delete from feature_slider where id = '".$id."'");
            unlink("uploads/sliders/".$slider->slider_image);
            redirect("admin/feature_banner");
        }
        else
        {
            redirect('admin');
        }   
    }
   
    public function city(){
        if(_is_user_login($this)){


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
                    redirect("admin/city");
                } 
                
            }
        
            $ct  = $this->db->query("select * from `city`");
            $data["cities"] = $ct->result();
            $this->load->view("admin/socity/city_list",$data);  
        }
        else{
            redirect("admin");
        }
        
    }

    public function delete_city($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from city where city_id = '".$id."'");
            redirect("admin/city");
        }
        else
        {
            redirect('admin');
        }
    }
    
    // start coupan by mine
    public function coupons(){
        if(_is_user_login($this)){
            $this->load->helper('form');
            $this->load->model('product_model');
            $this->load->library('session');
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('from', 'From', 'required|callback_date_valid');
            $this->form_validation->set_rules('to', 'To', 'required|callback_date_valid');
            
            $this->form_validation->set_rules('value', 'Value', 'required|numeric');
            $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
            $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

            $data= array();
            $data['coupons'] = $this->product_model->coupon_list();
            if($this->form_validation->run() == FALSE)
            {
                $this->form_validation->set_error_delimiters('<div class="text-danger">not wor', '</div>');
                
                $this->load->view("admin/coupons/coupon_list2",$data); 
                 
            }
            else{
                $data = array(
                'coupon_name'=>$this->input->post('coupon_title'),
                'coupon_code'=> $this->input->post('coupon_code'),
                'valid_from'=> $this->input->post('from'),
                'valid_to'=> $this->input->post('to'),
                'validity_type'=> $this->input->post('product_type'),
                'product_name'=> $this->input->post('printable_name'),
                'discount_type'=> $this->input->post('discount_type'),
                'discount_value'=> $this->input->post('value'),
                'cart_value'=> $this->input->post('cart_value'),
                'uses_restriction'=> $this->input->post('restriction')
                 );
                 //print_r($data);
                 if($this->product_model->coupon($data))
                 {
                     $this->session->set_flashdata('addmessage','Coupon added Successfully.');
                    $data['coupons'] = $this->product_model->coupon_list();
                    $this->load->view("admin/coupons/coupon_list2",$data);
                 }
            }
        }
        else
        {
            redirect('admin');
        }
        
    }
    // end mine
    
    
    public function add_coupons(){
        if(_is_user_login($this))
        {
            $this->load->helper('form');
            $this->load->model('product_model');
            $this->load->library('session');
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('from', 'From', 'required');
            $this->form_validation->set_rules('to', 'To', 'required');
            
            $this->form_validation->set_rules('value', 'Value', 'required|numeric');
            $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
            $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

            $data= array();
            $data['coupons'] = $this->product_model->coupon_list();
            if($this->form_validation->run() == FALSE)
            {
                $this->form_validation->set_error_delimiters('<div class="text-danger">not wor', '</div>');
                
                $this->load->view("admin/coupons/add_coupons",$data); 
                 
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
                'uses_restriction'=> $this->input->post('restriction'),
                "store_id_login"=>$this->input->post("store_id_login")
                 );
                 //print_r($data);
                 if($this->product_model->coupon($data))
                 {
                     $data["active"] = "listcat";
                     $this->session->set_flashdata('addmessage','Coupon added Successfully.');
                   // $data['coupons'] = $this->product_model->coupon_list();
                    
                   // $this->load->view("admin/coupons/add_coupons",$data);
                    
                    
                    //redirect('admin/coupons');
                    
                     
                 }
                     //$data["active"] = "addcat";
                     $this->load->model("product_model");
                     $data['coupons'] = $this->product_model->coupon_store_list();
                     $this->load->view("admin/coupons/coupon_list2",$data);
                // redirect('admin/coupons');
            }
        }
    }
    
    
    function editCoupon($id){ 
        if(_is_user_login($this)){
            //echo $id;die();
            $this->load->helper('form');
            $this->load->library('form_validation');
           
            $this->load->model('product_model');

            $this->load->model('product_model');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
            $this->form_validation->set_rules('from', 'From', 'required');
            $this->form_validation->set_rules('to', 'To', 'required');

            $this->form_validation->set_rules('value', 'Value', 'required|numeric');
            $this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
            $this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');

            $data= array();
            if($this->form_validation->run() == FALSE)
            {
                $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
                $data['coupon'] = $this->product_model->getCoupon($id);
                $this->load->view("admin/coupons/editcoupon",$data); 
                 
            }
            else{
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
                 print_r($data);
                 if($this->product_model->editCoupon($id,$data)){
                    $this->session->set_flashdata('addmessage','Coupon edited Successfully.');
                    redirect("admin/coupons");
                }
            }
        }
        else
        {
            redirect('admin');
        }
    }
    
  
  function deleteCoupon($id)
    {
        if(_is_user_login($this)){
            $this->load->model('product_model');
            if($this->product_model->deleteCoupon($id))
            {
                $this->session->set_flashdata('addmessage','One Coupon deleted Successfully.');
                redirect("admin/coupons");
            }
        }
        else
        {
            redirect('admin');
        }
    }  
    
    function dealofday()
    {

        $this->load->model("product_model");
        $data["deal_products"]  = $this->product_model->getdealproducts(); 

        $this->load->view('admin/deal/deal_list2',$data);
    }
    
    function add_dealproduct(){
        $this->load->helper('form');

        if(_is_user_login($this)){
       
          

            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Product', 'trim|required');
                $this->form_validation->set_rules('deal_price', 'Price', 'trim|required');
                $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
                $this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); 
                $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');  
                
                if ($this->form_validation->run() == FALSE)
                {
                      if($this->form_validation->error_string()!="") { 
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
                }
                else
                {
                    $this->load->model("product_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "deal_price"=>$this->input->post("deal_price"),
                    "start_date"=>$this->input->post("start_date"),
                    "start_time"=>$this->input->post("start_time"),
                    "end_date"=>$this->input->post("end_date"),
                    "end_time"=>$this->input->post("end_time"),
                    "store_id_login"=>$this->input->post("store_id_login")
                    
                    );
                    
                    
                    $this->product_model->adddealproduct($array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/dealofday');
                }
            }
            
            $this->load->view("admin/deal/add2");
        }
        else
        {
            redirect('admin');
        }
    
    }
    
    function edit_deal_product($id){
       if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                 $this->form_validation->set_rules('prod_title', 'Product', 'trim|required');
                $this->form_validation->set_rules('deal_price', 'Price', 'trim|required');
                $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
                $this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); 
                $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');  
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    $this->load->model("product_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "deal_price"=>$this->input->post("deal_price"),
                    "start_date"=>$this->input->post("start_date"),
                    "start_time"=>$this->input->post("start_time"),
                    "end_date"=>$this->input->post("end_date"),
                    "end_time"=>$this->input->post("end_time")
                    
                    );
                    
                   $this->product_model->edit_deal_product($id,$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/dealofday');
                }
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->getdealproduct($id);
            $this->load->view("admin/deal/edit2",$data);
        }
        else
        {
            redirect('admin');
        }
    }

    function delete_deal_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from deal_product where id = '".$id."'");
            redirect("admin/dealofday");
        }
        else
        {
            redirect('admin');
        }
    }
    
    
     public function payment(){
        if(_is_user_login($this)){
        $data["paypal"]=$this->db->query("SELECT *FROM `paypal` where `store_id_login`='"._get_current_user_id($this)."'");
       // print_r($data);
       // "Select * from `store_login` where `user_id`='"._get_current_user_id($this)."'"
       // $data["razor"]=$this->db->query("SELECT status FROM `razorpay` where id = 2");
       $data["razor"]=$this->db->query("SELECT*FROM `razorpay` where `store_id_login`='"._get_current_user_id($this)."'");
        $this->load->view("admin/payment/list",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function paypal_detail(){
        
        if(_is_user_login($this)){
               
            $data["error"] = "";
            $data["active"] = "pp";
            if(isset($_POST["pp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('client_id', 'Client ID', 'trim|required');
                
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
                    $client_id = $this->input->post("client_id");
                    //$emp_fullname = $this->input->post("emp_fullname");
                    $status = ($this->input->post("status")=="on")? 1 : 0;
                    $array = array(
                        'client_id'=>$client_id,
                        'status'=>$status
                        );
                    
                    $this->load->model("common_model");
                    $s_id=_get_current_user_id($this);
                    $this->common_model->data_update("paypal",$array,array("store_id_login"=>$s_id)); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/payment');
                }
            }
                

            //$data["paypal"]=$this->db->query("SELECT * FROM `paypal` where id = 1");
            $data["paypal"]=$this->db->query("SELECT * FROM `paypal` where store_id_login='"._get_current_user_id($this)."'");
            $this->load->view("admin/payment/edit_paypal",$data);
        }
        else
        {
            redirect('admin');
        }
         
    }
    
    public function razorpay_detail(){
        if(_is_user_login($this)){
            $data["error"] = "";
            $data["active"] = "pp";
            if(isset($_POST["pp"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('api_key', 'Client ID', 'trim|required');
                
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
                    $api_key = $this->input->post("api_key");
                    //$emp_fullname = $this->input->post("emp_fullname");
                    $status = ($this->input->post("status")=="on")? 1 : 0;
                    $array = array(
                        'api_key'=>$api_key,
                        'status'=>$status
                        );
                    
                    $this->load->model("common_model");
                    $s_id=_get_current_user_id($this);
                    $this->common_model->data_update("razorpay",$array,array("store_id_login"=>$s_id)); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request Send successfully...
                                    </div>');
                    redirect('admin/payment');
                }
            }
            

            $data["razor"]=$this->db->query("SELECT * FROM `razorpay` where `store_id_login`='"._get_current_user_id($this)."'");
            $this->load->view("admin/payment/edit_razorpay",$data);
        }
        else
        {
            redirect('admin');
        }
         
    }
    
    
    
     public function list_commision1($status){
    if(_is_user_login($this)){
       
        
        
    //     $data = array();
    //     $q1 = $this->db->query("Select * from `paypal` where `store_id_login`='"._get_current_user_id($this)."'");
    //     $row1=$q1->row();
    //     $client_id =$row1->client_id;
        
    //      $q2 = $this->db->query("Select * from `razorpay` where `store_id_login`='"._get_current_user_id($this)."'");
    //     $row2=$q2->row();
    //     $api_key =$row2->api_key; 

    //         $q = $this->db->query("Select * from `store_login` where `user_id`='"._get_current_user_id($this)."'");
    //          $row=$q->row();
                     
    //           $row->user_id; 
    //           $id=$row->user_id;
    //           $m=0;
    //           $n=1;
                
    //          $this->load->model("users_model");
    //         $data["commission"] = $this->users_model->get_commision($id,$m);
    //         $data["sum"] = $this->users_model->get_commision_sum($id,$m);
    //         $data["comms"] = $this->users_model->get_commision_online($id,$n);
    //         $data["sum_online"] = $this->users_model->get_commision_sum_by_online($id,$n);
    //         $data["id"] =$id;
    //         $data["client_id"] = $client_id;
    //         $data["api_key"] = $api_key;
    //         //echo $status;
    //         if($status == 1)
    //         {
    //             $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
    //                                     <i class="fa fa-check"></i>
    //                                   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    //                                   <strong>Success!</strong> Payment has been done successfully!!!
    //                                 </div>');
    //         }
           // $this->load->view("users/table_new",$data);
            $this->load->view("users/table_new");
        }
        else
        {
            redirect('admin');
        }
    }
    public function list_commision($status){
    if(_is_user_login($this)){
         $data = array();
        // $q1 = $this->db->query("Select * from `paypal` where `store_id_login`='"._get_current_user_id($this)."'");
        // $row1=$q1->row();
        // $client_id =$row1->client_id;
        
        //  $q2 = $this->db->query("Select * from `razorpay` where `store_id_login`='"._get_current_user_id($this)."'");
        // $row2=$q2->row();
        // $api_key =$row2->api_key; 

            $q = $this->db->query("Select * from `store_login` where `user_id`='"._get_current_user_id($this)."'");
             $row=$q->row();
                     
              $row->user_id; 
              $id=$row->user_id;
              $m=0;
              $n=1;
              
            $this->load->model("users_model");
            $data["all"] = $this->users_model->get_commision_all($id);
            $from_date=$this->input->post("from_date");
            $to_date=$this->input->post("to_date"); 
             $new_fromDate = date("Y-m-d", strtotime($from_date));
             $new_fromDate;
            $new_toDate = date("Y-m-d", strtotime($to_date));
            $new_toDate;
              
                if(isset($_POST["cod"]))
                {
                   
                   //echo "hii";
                    $this->load->model("users_model");
                //   print_r($data["cod_order"] = $this->users_model->get_cod_order($id, $new_fromDate,$new_toDate));
                //   // print_r($data);
                //   $data["commission"] = $this->users_model->get_commision($id,$m);
                    $data["sum"] = $this->users_model->get_commision_sum($id,$m,$new_fromDate,$new_toDate);
                    $data["from_date"] =$new_fromDate;
                    $data["to_date"] =$new_toDate;
                    $this->load->view("users/commisionlist_cod",$data,$new_fromDate,$new_toDate);
                    //redirect('admin/payment');
                   
            
                    // $data["id"] =$id;

                } 
                else if(isset($_POST["prepaid"]))
                {
                   //echo "hii";
                    $this->load->model("users_model");
                      //$data["comms"] = $this->users_model->get_commision_online($id,$n);
                    $data["sum_online"] = $this->users_model->get_commision_sum_by_online($id,$n,$new_fromDate,$new_toDate);
                     
                     // $data["comms"] = $this->users_model->get_commision_online($id,$n);
            
                    // $data["sum_online"] = $this->users_model->get_commision_sum_by_online($id,$n);
                    $data["from_date"] =$new_fromDate;
                    $data["to_date"] =$new_toDate;
                    $this->load->view("users/commisionlist_online",$data);
                   
                }
                else if(isset($_POST["request"]))
                {
                   //echo "hii";
                    $this->load->model("users_model");
                      //$data["comms"] = $this->users_model->get_commision_online($id,$n);
                    $data["req_cod"] = $this->users_model->get_cod_request_admin_to_store($id);
                    $data["req_online"] = $this->users_model->get_online_request_store_to_admin($id);
                    
                     //$req_cod = $this->users_model->get_cod_request_store($id);
                     //var_dump($req_cod);
                    //echo "hii";
                   $this->load->view("users/cod_request_list",$data);
                   
                }
                else if(isset($_POST["trans"]))
                {
                   //echo "hii";
                    $this->load->model("users_model");
                      //$data["comms"] = $this->users_model->get_commision_online($id,$n);
                    $data["req_cod"] = $this->users_model->get_store_payment($id);
                    
                     //$req_cod = $this->users_model->get_cod_request_store($id);
                     //var_dump($req_cod);
                    //echo "hii";
                   $this->load->view("users/store_transaction",$data);
                   
                }
                else{
                    
                     if($status == 1)
                        {
                            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                                    <i class="fa fa-check"></i>
                                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                  <strong>Success!</strong> Request successfully Sent!!!
                                                </div>');
                        }
                       
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
            
            echo $amount = $this->input->post('amount');
            echo $admin_share = $this->input->post('admin_share');
             $q = $this->db->query("Select * from `store_login` where `user_id`='"._get_current_user_id($this)."'");
             $row=$q->row();
                     
              $row->user_id; 
              $id=$row->user_id;
              $store_name=$row->user_fullname;
              $m=0;
              $n=1;
              
            $query = $this->db->query("Select * from `request` where `create_by`='"._get_current_user_id($this)."'");
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
                        "create_by"=>$id,
                        "create_by_store_name"=>$store_name,
                        "create_to"=>"Admin");
                      $this->common_model->data_insert("request",$array);
              } 
               
                    $this->load->model("users_model");
                  //print_r($data["pay_request"]= $this->users_model->get_online($id,$n,$from_date,$to_date));
                    $pay_request= $this->users_model->get_online($id,$n,$from_date,$to_date);
                    // echo $myArray;
            
                        foreach($pay_request as $request)
                        {
                            echo "hii";
                            $request->id;
                          
                            $this->load->model("users_model");   
                            $data["request"] = $this->users_model->update_status_request_online($request->id);
                            
                        }
                            redirect('admin/list_commision/1');     
             
        }
        else
            {
                redirect("admin");
            }
    
    }
    
    public function pay_from_store($id){
    if(_is_user_login($this)){
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
                        
                      $this->common_model->data_insert("store_transaction",$array);
                      $this->db->query("Delete from admin_request where create_to =".$id);
        
        redirect('admin/list_commision/0');
        
        
            
        }
        
        
        
        
         $this->load->model("users_model");
           //echo "hii"; 
         echo $trans_id=$this->input->post('trans_id');
         echo $from_date = $this->input->post('from_date');
        echo $to_date = $this->input->post('to_date');
        echo $amount = $this->input->post('amount');
        $m=0;
         $query = $this->db->query("Select * from `store_login` where `user_id`=".$id);
         $query=$query->row();
         $store_name=$query->user_fullname;
         $sum= $this->users_model->get_commision_sum1($id,$m,$from_date,$to_date);
         echo $sum->Admin_Share;
        
            if($amount==$sum->Admin_Share){
             echo base_url();
              echo "hii";
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
                        
                      $this->common_model->data_insert("store_transaction",$array);
        
            
       
             }
          redirect('admin/list_commision/0');
    
    }  
        else
        {
            redirect('admin');
        }
    }
    
    
    public function payment_from_store($id){
    if(_is_user_login($this)){
        
         $this->load->model("users_model");
           //echo "hii"; 
         $pay_amount=$this->input->post('pay');
         $pay_amount=(int)$pay_amount;
          echo $pay_amount;
         echo "<br><br>"."$id";
            // $this->load->model("common_model");
            //         $array = array( 
            //         "product_name"=>$this->input->post("pay"),
            //         "product_name"=>$this->input->post("store_id")
            //         );
        $n=0;
     
     $sum_online = $this->users_model->get_commision_sum_by_cod($id,$n);
     
       $amt=(double)$sum_online->total*100;
       echo"<br><br>".gettype($amt);
       
      $pay_amount=(double)$pay_amount;
      echo"<br><br>".gettype($pay_amount);
      
      echo $amt."==".$pay_amount;
      
      $amt=(int)$amt;
      $pay_amount=(int)$pay_amount;
      
      
      if($amt==$pay_amount){
           //echo base_url();
       
        $this->load->model("users_model");   
        $data["pay"] = $this->users_model->update_status_online($id,$n);
        
       // echo "success";
       
      }
       redirect('admin/list_commision/1');
      
    }
      
      //print_r($sum_online);
        
        else
        {
            redirect('admin');
        }
    }
    //
    public function payment_from_store_cod($id){
    if(_is_user_login($this)){
         $this->load->model("users_model");
           //echo "hii"; 
         $pay_amount=$this->input->post('pay');
         $pay_amount=(int)$pay_amount;
          echo $pay_amount;
         echo "<br><br>"."$id";
            // $this->load->model("common_model");
            //         $array = array( 
            //         "product_name"=>$this->input->post("pay"),
            //         "product_name"=>$this->input->post("store_id")
            //         );
        $n=0;
     
     $sum_online = $this->users_model->get_commision_sum_of_cod($id,$n);
     
       $amt=(double)$sum_online->total*100;
       echo"<br><br>".gettype($amt);
       
      $pay_amount=(double)$pay_amount;
      echo"<br><br>".gettype($pay_amount);
      
      echo $amt."==".$pay_amount;
      
      $amt=(int)$amt;
      $pay_amount=(int)$pay_amount;
      
      
      if($amt==$pay_amount){
           //echo base_url();
       
        $this->load->model("users_model");   
        $data["pay"] = $this->users_model->update_status_online($id,$n);
        
       // echo "success";
       
      }
       redirect('admin/list_commision/1');
      
    }
      
      //print_r($sum_online);
        
        else
        {
            redirect('admin');
        }
    }
    function lookup(){  
        $this->load->model("product_model");  
        $this->load->helper("url");  
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');  
        $data['response'] = 'false'; //Set default response  
        if($type=='Category')
        {
            
        } 
        elseif ($type=='Sub Category') {
            
        }
        else{
            $query = $this->product_model->lookup($keyword); //Search DB 
        }
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
                $data['message'][] = array(   
                                          
                                        'value' => $row->product_name 
                                         
                                     );  //Add a row to array  
            }  
        }
        //print_r( $data['message']);
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        }  
        else 
        {  
            $this->load->view('admin/coupons/coupon_list',$data); //Load html view of search results  
        }  
    }  
    
    
    
    
    //   public function sms(){
	   //  if(_is_user_login($this)){
	   //      if(isset($_POST['alert']))
	   //      {
	      
                
    //              $msg_new_order=($this->input->post("order_sms")=="on")?1:0;
    //              $mail_new_order=($this->input->post("order_mail")=="on")?1:0;
    //              $msg_order_assign=($this->input->post("assign_sms")=="on")?1:0;
    //              $mail_order_assign=($this->input->post("assign_mail")=="on")?1:0;
    //              $msg_complete_order=($this->input->post("complete_sms")=="on")?1:0;
    //              $mail_complete_order=($this->input->post("complete_mail")=="on")?1:0;
    //             $store_id=$this->input->post("store_id_login");
    //                 $this->load->model("common_model");
    //                 $array = array( 
                     
    //                   "msg_new_order"=>$msg_new_order,
    //                   "mail_new_order"=>$mail_new_order,
    //                   "msg_order_assign"=>$msg_order_assign,
    //                   "mail_order_assign"=>$mail_order_assign,
    //                   "msg_complete_order"=>$msg_complete_order,
    //                     "mail_complete_order"=>$mail_complete_order,
    //                  "store_id"=>$store_id
                    
    //               // "rewards"=>$this->input->post("rewards")
    //                 );
                    
    //                 $check=$this->common_model->data_update("message",$array,array("store_id"=>$store_id));
    //                 $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
    //                                     <i class="fa fa-check"></i>
    //                                   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    //                                   <strong>Success!</strong> Your request added successfully...
    //                                 </div>'.$check);
                
    //               } 
	         
    //         $this->load->model("product_model");
    //         $data["message"]  = $this->product_model->sms_store_list();
           
    //         $this->load->view("admin/sms/sms_alert",$data); 
    //     }
    //     else
    //         {
    //             redirect("admin");
    //         }
    
    // }
    
    function complain()
    {
      if(_is_user_login($this)){
           $data["error"] = "";
           //$data["active"] = "listcat";
           $this->load->model("product_model");
           $data["comp"] = $this->product_model->get_complain();
           $this->load->view('admin/complain/complain',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    
     public function add_user(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            if($_POST){
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('emp_fullname', 'Full Name', 'required');
                $this->form_validation->set_rules('user_email', 'Email Id', 'required');
                $this->form_validation->set_rules('user_password', 'Password', 'required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		  
        			$data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    
        		}
        		else
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
                                //redirect("admin/list_user");
                                redirect('admin/list_user');
                        
                }

            }
                            $this->load->view("admin/assign_db2",$data);
           // $data["user_types"] = $this->users_model->get_user_type();
           // $this->load->view("admin/list",$data);
        }
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
                           redirect("admin/list_user");                
                
            }         
            $this->load->view("admin/edit_db",$data);
        }
    }
    
    
    
     function delete_user($user_id){
        $data = array();
            $this->load->model("users_model");
            $user  = $this->users_model->get_user_by_id($user_id);
           if($user){
                $this->db->query("Delete from delivery_boy where id = '".$user->id."'");
                redirect("admin/list_user");
           }
    }
    public function list_user()
	{
		if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            $data['users'] = $this->users_model->get_alluser();
            //var_dump($data);
            //echo _get_current_user_id($this);
            $this->load->view("admin/list",$data);
        }
    }
    
    public function edit_store_user1($user_id){
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
        $this->load->view("admin/edit_store_user",$data);
    }
    }

    public function edit_store_user($user_id){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("users_model");
            
            // $this->db->where('name', $name);
            $data["user_types"] = //$this->users_model->get_user_type();
            
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
                        $image = "";
                        $main_banner = "";
                        
                       // $status = ($this->input->post("status")=="on")? 1 : 0;
                        
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
                                        $update_array["user_image"]=$image;
                                        // base_url()."/uploads/profile/".
                                    }
                                    
                                }
                        else
                        {
                            $image = '';
                        }
                        
                        if($_FILES["main_banner"]["size"] > 0){
                                    $config['upload_path']          = '../uploads/profile/';
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
                               // "user_status"=>$status,
                                "user_city"=>$user_city,
                                // "user_main_banner"=>$main_banner,
                               // "delivery_range"=>$delivery_range,
                                "lat"=>$lat,
                                "lon"=>$lon,
                              //  "profit_percent"=>$percentage,
                              //  "account_type"=>$account_type
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
                                redirect("admin/dashboard");
                        
                }
            }
            
            
            $this->load->view("admin/edit_store_user",$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function delivery_charge(){
        if(_is_user_login($this)){
            $this->load->library('form_validation');
                    $this->form_validation->set_rules('cart_to', 'Cart Value To', 'trim|required');
                    $this->form_validation->set_rules('cart_from', 'Cart Value From', 'trim|required');
                    $this->form_validation->set_rules('charge', 'Delivery Charge', 'trim|required');
                    
                    $store_id=_get_current_user_id($this);
                    
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
                        $array = array("cart_from"=>$this->input->post("cart_from"),
                                        "cart_to"=>$this->input->post("cart_to"),
                                        "charge_amount"=>$this->input->post("charge"),
                                        "store_id"=>$store_id
                                       ); 
                          $this->db->insert("delivery_charge",$array); 
                    }
            
            $q1 = $this->db->query("Select * from `delivery_charge` where `store_id`='"._get_current_user_id($this)."'");
            $data["charges"] = $q1->result();
             
            $this->load->view("admin/delivery_charge/charges",$data);
        }
        else
        {
            redirect("admin");
        }
    }
    
     
    public function delete_delivery_charge($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from delivery_charge where charge_id = '".$id."'");
            redirect("admin/delivery_charge");
        }
        else
        {
            redirect("admin");
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




