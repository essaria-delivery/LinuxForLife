<?php
class Product_model extends CI_Model{
      function get_products($in_stock=false,$cat_id="",$search="", $page = ""){
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and products.product_name like '%".$search."%'";
            }
            $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
            inner join categories on categories.id = products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            where 1 ".$filter." ".$limit);
            $products = $q->result();
            //inner join product_price on product_price.product_id = products.product_id
            
            
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
            return $products; 
      }
      function get_products1(){
        //     $this->db->select('*');
        //   $this->db->from('products');
           //$this->db->where('store_id_login', _get_current_user_id($this));
            
            
            
            
            //inner join product_price on product_price.product_id = products.product_id
            
            $q=$this->db->query("Select products.*, categories.title from products 
            inner join categories on categories.id = products.category_id
            where products.store_id_login ="._get_current_user_id($this));
           //$query = $this->db->get();
            
            return $q->result();
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
           return $products; 
      }
      
// start mine puchase_products
function get_purchasestore_by_id($prod_id){
          $this->db->select('*');
          $this->db->from('products');
           $this->db->where('product_id', $prod_id);
        // $q = $this->db->query("select * from 'products' where 'product_id',$prod_id");
        //    
            $query = $this->db->get();
             return $query->row();
      }


// end mine products//
       function city(){
            $q = $this->db->query("SELECT * FROM `city`");
            return $q->row();
      }

      function get_product_by_id($prod_id){
            $q = $this->db->query("Select products.*, categories.title from products 
            inner join categories on categories.id = products.category_id
            where 1 and products.product_id = '".$prod_id."' limit 1");
            return $q->row();
            
      }
      function get_purchase_list(){

        $q = $this->db->query("Select purchase.*, products.product_name from purchase 
            inner join products on products.product_id = purchase.product_id
            where 1");
            return $q->result();
            
      }
      function get_purchase_by_id($id){
        $q = $this->db->query("Select purchase.* from purchase 
            where 1 and purchase_id = '".$id."' limit 1");
            return $q->row();
      }
      function get_product_price($in_stock=false,$prod_id=""){
            $filter = "";
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($prod_id!=""){
                $filter .=" and products.product_id = '".$prod_id."' ";
            }
            $q = $this->db->query("Select product_price.* from product_price 
            inner join products on products.product_id = product_price.product_id 
            where 1 ".$filter);
            return $q->result();
      }  
      function get_prices_by_ids($ids){
            $q = $this->db->query("Select product_price.* from product_price 
            where 1 and price_id in (".$ids.")");
            return $q->result();
      }
      function get_price_by_id($price_id){
        $q = $this->db->query("Select * from product_price 
            where 1 and price_id = '".$price_id."'");
            return $q->row();
      }
      function get_socity_by_id($id){
        $q = $this->db->query("Select * from socity 
            where 1 and socity_id = '".$id."'");
            return $q->row();
      }
      function get_socities(){
        
        $q = $this->db->query("Select * from socity");
            return $q->result();
      }

 function get_user(){
        
        $q = $this->db->query("Select * from registers");
            return $q->result();
      }

 function all_products_list($u_id){
        
        $q = $this->db->query("Select * from products where store_id_login=".$u_id);
            return $q->result();
      }

      function get_sale_by_user($user_id){
            $q = $this->db->query("Select sale.*, registers.user_phone as customer_number, registers.user_fullname as customer_name from sale
            inner join registers on registers.user_id = sale.user_id
            where sale.new_store_id = '".$user_id."' ORDER BY sale.sale_id DESC");
            return $q->result();
      }
      
      function get_sale_orders($filter="", $user_id){
         $sql = "Select distinct sale.*,registers.user_fullname, registers.user_phone,registers.pincode,
         registers.socity_id,registers.house_no, socity.socity_name, user_location.socity_id, sale.new_store_id ,
         user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile  from sale 
            inner join registers on registers.user_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join socity on socity.socity_id = user_location.socity_id
            left outer join users on users.user_id = user_location.store_id
             where sale.new_store_id ='".$user_id."'
             ".$filter." ORDER BY sale_id DESC";
            $q = $this->db->query($sql);
            return $q->result();
      } 
      
      function get_sale_order_by_id($order_id){
            $q = $this->db->query("Select distinct sale.*,registers.user_fullname,registers.user_phone,registers.pincode,registers.socity_id,registers.house_no, socity.socity_name, user_location.socity_id, user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile from sale 
            inner join registers on registers.user_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join socity on socity.socity_id = user_location.socity_id
            where sale_id = ".$order_id." limit 1");
            return $q->row();
      } 
      function get_sale_order_items($sale_id){
        $q = $this->db->query("Select sale_items.*,products.product_image, products.product_name from sale_items 
        inner join products on products.product_id = sale_items.product_id
        where sale_id = '".$sale_id."'");
            return $q->result();
      }
      
      function get_leftstock(){
        $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock from products 
        left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
           where store_id_login =". _get_current_user_id($this));
        return $q->result();
      }
      
      function get_all_users(){
         $sql = "Select registers.*, ifnull(sale_order.total_amount, 0) as total_amount,total_orders  from registers 
            
            left outer join (Select sum(total_amount) as total_amount, count(sale_id) as total_orders, user_id from sale group by user_id) as sale_order on sale_order.user_id = registers.user_id
            where 1 order by user_id DESC";
            $q = $this->db->query($sql);
            
            return $q->result();
      }
      function delivery_boy_order($delivery_boy_id){
            $q = $this->db->query("Select * from sale where assign_to = '".$delivery_boy_id."'");
            return $q->result();
      }
      
      function coupon($data)
      {
          
          $this->db->insert('coupons',$data);
          return true;
      }
      function coupon_list()
      {
        //   $query = $this->db->get('coupons');
        //   return $query->result();
          $this->db->select('*');
          $this->db->from('coupons');
          $this->db->where('store_id_login', _get_current_user_id($this));
          $query = $this->db->get();
          return $query->result();
      }
      function coupon_store_list()
      {
          $this->db->select('*');
          $this->db->from('coupons');
          $this->db->where('store_id_login', _get_current_user_id($this));
          $query = $this->db->get();
          return $query->result();
      
      }
      
      function getCoupon($id)
      {
        $this->db->select('*');
        $this->db->from('coupons');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row_array(); 

      }
      
      function editCoupon($id,$data)
      {
        $this->db->where('id', $id);
        $this->db->update('coupons', $data);
        return true;
      }
      
      function deleteCoupon($id)
      {
         $this->db->where('id', $id);
        $this->db->delete('coupons');
        return true;
      }
      
       function adddealproduct($data)
      {
        $this->db->insert('deal_product',$data);
        return true;
      }

       function getdealproducts()
      {

        // $query = $this->db->get('deal_product');
        // return $query->result();
        $this->db->select('*');
          $this->db->from('deal_product');
          $this->db->where('store_id_login', _get_current_user_id($this));
          $query = $this->db->get();
          return $query->result();
      }
      
      function getdealproduct($id)
      {
          $this->db->where('id',$id);
          $query=$this->db->get('deal_product');
          return $query->row();
      }
      
      function edit_deal_product($id,$data)
      {
          $this->db->where('id',$id);
          $this->db->update('deal_product',$data);
          return true;
      }
      
      function lookup($keyword){ 
        $store_id=$this->session->user_id;
        $this->db->select('*')->from('products');
        $this->db->where('store_id_login',$store_id);
        $this->db->like('product_name',$keyword,'after'); 

        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      }
      
      function sms_store_list()
      {
          $this->db->select('*');
          $this->db->from('message');
          $this->db->where('store_id', _get_current_user_id($this));
          $query = $this->db->get();
          return $query->row();
      
      }
   function get_m_products($product)
      {
           $a=array();
            $new_product = json_decode($product);
             foreach($new_product as $new_products)
            {
                $q = $this->db->query("select * from  products where product_id ='".$new_product->product_id."'" );
            $list = $q->result();
            array_push($a,$list);
            }
      
      }
       function get_complain()
      {
        $this->db->select('*');
        $this->db->from('user_complain');
        
        $query = $this->db->get();
        return $query->result(); 

      }
}
?>