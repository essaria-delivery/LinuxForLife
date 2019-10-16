<?php
class Users_model extends CI_Model{
    public function get_users($filter=array()){
        $filter = "";
        if(!empty($filter))
        {
            if(key_exists("user_type")){
                $filter .=" and users.user_type_id = '".$filter["user_type"]."'";
            }
            if(key_exists("status")){
                $filter .=" and users.user_status = '".$filter["status"]."'";
            }
        }
        $q = $this->db->query("select * from users where 1 ".$filter);
        return $q->result();
    }
        public function get_alluser(){
        $q = $this->db->query("select * from store_login ");
        return $q->result();
    }
    
    public function get_commision_all($id){
       //$q = $this->db->query("Select commission.* from commission 
            //where  store_id = '".$id."");
           
        //return $q->result();
         $this->db->select('*');
          $this->db->from('commission');
          $this->db->where('store_id', $id);
          //$this->db->where('payment_method', $m);
        // $q = $this->db->query("select * from 'products' where 'product_id',$prod_id");
        //    
            $query = $this->db->get();
             return $query->result();
    }
    public function get_commision_sum_cod($id,$m,$new_fromDate,$new_toDate){
             $this->db->select('*');
            $this->db->select('admin_share, SUM(admin_share) AS Admin_Share', FALSE);
           $this->db->select('amount, SUM(amount) AS amt', FALSE);
            $this->db->from('commission');
            $this->db->where('store_id', $id);
            $this->db->where('payment_method',$m);
            $this->db->where('status', 0);
            $this->db->where('on_date >=', $new_fromDate);
            $this->db->where('on_date <=', $new_toDate);
            $query = $this->db->get();
            
             return $query->result();
    }
    
    public function get_online($id,$m,$new_fromDate,$new_toDate){
         $this->db->select('*');
         
            $this->db->from('commission');
            $this->db->where('store_id', $id);
            $this->db->where('payment_method',$m);
            $this->db->where('status', 0);
            $this->db->where('on_date >=', $new_fromDate);
            $this->db->where('on_date <=', $new_toDate);
            $query = $this->db->get();
            
             return $query->result();
    }
    
    public function update_status_request_online($id){
        
            $this->db->set('payment_request', 0); //value that used to update column 
            $this->db->where('id', $id);
            //$this->db->where('payment_method', $n); //which row want to upgrade  
            $this->db->update('commission');  //table name
            
             return ;
    }
    public function get_commision($id,$m){
       //$q = $this->db->query("Select commission.* from commission 
            //where  store_id = '".$id."");
           
        //return $q->result();
         $this->db->select('*');
          $this->db->from('commission');
           $this->db->where('store_id', $id);
           $this->db->where('payment_method', $m);
        // $q = $this->db->query("select * from 'products' where 'product_id',$prod_id");
        //    
            $query = $this->db->get();
             return $query->result();
    }
    
    public function get_commision_sum($id,$m){
            $this->db->select('amount, SUM(amount) AS AMOUNT', FALSE);
            //$this->db->from('commission');
            $this->db->where('store_id', $id);
            $this->db->where('payment_method', $m);
            $query = $this->db->get('commission');
            
             return $query->result();
    }
    public function get_commision_online($id,$n){
      //$q = $this->db->query("Select commission.* from commission 
            //where  store_id = '".$id."");
           
        //return $q->result();
         $this->db->select('*');
          $this->db->from('commission');
          $this->db->where('store_id', $id);
          $this->db->where('payment_method', $n);
        // $q = $this->db->query("select * from 'products' where 'product_id',$prod_id");
        //    
            $query = $this->db->get();
             return $query->result();
    }
    public function get_commision_sum_online($id,$n,$new_fromDate,$new_toDate){
         $this->db->select('*');
            $this->db->select('admin_share, SUM(admin_share) AS Admin_Share', FALSE);
           $this->db->select('amount, SUM(amount) AS amt', FALSE);
            $this->db->from('commission');
            $this->db->where('store_id', $id);
            $this->db->where('payment_method',$n);
            $this->db->where('status', 0);
            $this->db->where('on_date >=', $new_fromDate);
            $this->db->where('on_date <=', $new_toDate);
            $query = $this->db->get();
            
             return $query->result();
    }
    public function get_cod_request_store($id){
            $this->db->select('*');
         
            $this->db->from('admin_request');
            $this->db->where('create_by', 0);
            $this->db->where('create_to', $id);
            $query = $this->db->get();
            
             return $query->result();
    }
    public function get_online_request_from_store($id){
            $this->db->select('*');
         
            $this->db->from('request');
            $this->db->where('create_by',$id);
            $query = $this->db->get();
            
             return $query->result();
    }
    
    public function get_admin_payment($id){
            $this->db->select('*');
         
            $this->db->from('admin_transaction');
            $this->db->where('store_id', $id);
            $query = $this->db->get();
            
             return $query->result();
    }
    
    public function get_commision_sum1($id,$n,$new_fromDate,$new_toDate){
         $this->db->select('*');
            $this->db->select('admin_share, SUM(admin_share) AS Admin_Share', FALSE);
           $this->db->select('amount, SUM(amount) AS amt', FALSE);
            $this->db->from('commission');
            $this->db->where('store_id', $id);
            $this->db->where('payment_method',$n);
            $this->db->where('status', 0);
            $this->db->where('on_date >=', $new_fromDate);
            $this->db->where('on_date <=', $new_toDate);
            $query = $this->db->get();
            
             return $query->row();
    }
    public function update_status_online1($id,$from_date,$to_date){
        
            $this->db->set('status', 1); //value that used to update column 
            $this->db->where('store_id', $id);
             $this->db->where('payment_method',1); //which row want to upgrade
              $this->db->where('on_date >=', $from_date);
            $this->db->where('on_date <=', $to_date);
            $update=$this->db->update('commission');  //table name
            
             return $update;
    }
    
    public function get_commision_sum_by_online($id,$n){
            $this->db->select('amount, SUM(amount) AS AMOUNT', FALSE);
            //$this->db->from('commission');
            $this->db->where('store_id', $id);
             $this->db->where('payment_method', $n);
             $this->db->where('status', 0);
            $query = $this->db->get('commission');
            
             return $query->result();
    }
    public function get_commision_sum_by_online1($id,$n){
            $this->db->select('amount, SUM(amount) AS total', FALSE);
            //$this->db->from('commission');
            $this->db->where('store_id', $id);
             $this->db->where('payment_method', $n);
            $query = $this->db->get('commission');
            
             return $query->row();
    }
    
    
    public function update_status_online($id,$n){
        
            $this->db->set('status', 1); //value that used to update column 
            $this->db->where('store_id', $id);
             $this->db->where('payment_method', $n); //which row want to upgrade  
            $this->db->update('commission');  //table name
            
             return ;
    }
    public function get_user_by_id($id){
        $q = $this->db->query("select * from store_login where  user_id = '".$id."' limit 1");
        return $q->row();
    }
     public function get_mainuser_by_id($id){
        $q = $this->db->query("select * from users where  user_id = '".$id."' limit 1");
        return $q->row();
    }
    public function get_user_type(){
        $q = $this->db->query("select * from user_types");
        return $q->result();
    }
    public function get_user_type_id($id){
        $q = $this->db->query("select * from user_types where user_type_id = '".$id."'");
        return $q->row();
    }
    public function get_user_type_access($type_id){
        $q = $this->db->query("select * from user_type_access where user_type_id = '".$type_id."'");
        return $q->result();
    }
   
}
?>