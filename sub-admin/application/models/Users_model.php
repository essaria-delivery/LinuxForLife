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
        $q = $this->db->query("select * from delivery_boy");
        return $q->result();
    }
    
    public function get_allstore(){
        $set_data=$this->session->all_userdata();
        $store=$set_data['sub_admin']['user_id'];
        $q = $this->db->query("select * from store_login where create_by=".$store);
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
     public function get_boy_by_id_store($id){
        $q = $this->db->query("select store_id from delivery_assign_store where  boy_id ='".$id."'");
        return $q->result();
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
   
}
?>