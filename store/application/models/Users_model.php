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
        $q = $this->db->query("select * from delivery_boy where store_id="._get_current_user_id($this));
        return $q->result();
    }
    public function get_user_by_id($id){
        $q = $this->db->query("select * from delivery_boy where  id ='".$id."' limit 1");
        return $q->row();
    }
    public function get_user_type(){
        $q = $this->db->query("select * from delivery_boy");
        return $q->result();
    }



 public function get_user_type_store(){
        $q = $this->db->query("select * from users");
        return $q->result();
    }

  public function get_user_type_id_user($id){
        $q = $this->db->query("select * from users where user_id ='".$id."'");
        return $q->row();
    }
   public function get_user_by_id_store($id){
        $q = $this->db->query("select * from delivery_boy where  id ='".$id."' limit 1");
        return $q->row();
    }

    public function get_user_by_id_store2($id){
        $q = $this->db->query("select * from store_login where  user_id ='".$id."' limit 1");
        return $q->row();
    }
     public function get_user_by_id_store3($id){
        $q = $this->db->query("select * from store_login where  user_id ='".$id."' limit 1");
        return $q->row();
    }

    public function get_user_type_id($id){
        $q = $this->db->query("select * from user_types where user_type_id = '".$id."'");
        return $q->row();
    }
    public function get_user_type_access($type_id){
        $q = $this->db->query("select * from user_type_access where user_type_id = '".$type_id."'");
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
     public function get_cod_order($id,$new_fromDate,$new_toDate){
       //$q = $this->db->query("Select commission.* from commission 
            //where  store_id = '".$id."");
           
        //return $q->result();
         $this->db->select('*');
         $this->db->select('total_amount, SUM(total_amount) AS amt', FALSE);
          $this->db->from('sale');
          $this->db->where('new_store_id',$id);
          $this->db->where('on_date >=', $new_fromDate);
            $this->db->where('on_date <=', $new_toDate);
           //$this->db->where("(on_date=$new_fromDate OR on_date=$new_fromDate)", NULL, FALSE);
          // where dat >= '$fromtime' and dat <= '$totime' ";

            $this->db->where("(payment_method='Store Pick Up' OR payment_method='Cash On Delivery')", NULL, FALSE);
            //  $this->db->select('amount, SUM(amount) AS AMOUNT', FALSE);
            $query = $this->db->get();
             return $query->result();
             
             //return num_rows($query);
           // return $query->num_rows();
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
     public function get_commision_sum($id,$m,$new_fromDate,$new_toDate){
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
    public function get_commision_sum1($id,$m,$new_fromDate,$new_toDate){
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
            
             return $query->row();
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
    
    
    
     public function get_commision_sum_by_online($id,$n,$new_fromDate,$new_toDate){
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
    public function get_online($id,$n,$new_fromDate,$new_toDate){
         $this->db->select('*');
         
            $this->db->from('commission');
            $this->db->where('store_id', $id);
            $this->db->where('payment_method',$n);
            $this->db->where('status', 0);
            $this->db->where('on_date >=', $new_fromDate);
            $this->db->where('on_date <=', $new_toDate);
            $query = $this->db->get();
            
             return $query->result();
    }
     public function get_cod_request_admin_to_store($id){
            $this->db->select('*');
         
            $this->db->from('admin_request');
            $this->db->where('create_by',0);
            $this->db->where('create_to',$id);
            $query = $this->db->get();
            
             return $query->result();
    }
    public function get_online_request_store_to_admin($id){
            $this->db->select('*');
         
            $this->db->from('request');
            
            $this->db->where('create_by',$id);
            $query = $this->db->get();
            
             return $query->result();
    }
    public function get_store_payment($id){
            $this->db->select('*');
         
            $this->db->from('store_transaction');
            $this->db->where('store_id', $id);
            $query = $this->db->get();
            
             return $query->result();
    }
     public function get_commision_sum_by_cod($id,$n){
            $this->db->select('amount, SUM(amount) AS total', FALSE);
            //$this->db->from('commission');
            $this->db->where('store_id', $id);
             $this->db->where('payment_method', $n);
              $this->db->where('status', 0);
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
    public function update_status_online1($id,$from_date,$to_date){
        
            $this->db->set('status', 1); //value that used to update column 
            $this->db->set('payment_request', NULL);
            $this->db->where('store_id', $id);
            $this->db->set('payment_request', NULL);
             $this->db->where('payment_method',0); //which row want to upgrade
              $this->db->where('on_date >=', $from_date);
            $this->db->where('on_date <=', $to_date);
            $update=$this->db->update('commission');  //table name
            
             return $update;
    }
    public function update_status_request_online($id){
        
            $this->db->set('payment_request', 0); //value that used to update column 
            $this->db->where('id', $id);
            //$this->db->where('payment_method', $n); //which row want to upgrade  
            $this->db->update('commission');  //table name
            
             return ;
    }
   
}
?>