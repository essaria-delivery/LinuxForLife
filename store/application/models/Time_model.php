<?php
class Time_model extends CI_Model{
        function get_time_slot(){
           $q = $this->db->query("Select * from time_slots limit 1");
            return $q->row();
        }
        
        function get_closing_date($date,$store_id){
           $q = $this->db->query("Select * from closing_hours WHERE store_id=".$store_id." AND date >= '".date("Y-m-d",strtotime($date))."'");
            return $q->result(); 
        }
        function get_closing_hours($date){
           $q = $this->db->query("Select * from closing_hours where date = '".date("Y-m-d",strtotime($date))."'");
            return $q->result(); 
        }
}
?>