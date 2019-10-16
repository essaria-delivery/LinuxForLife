<?php
class Product_model extends CI_Model{
      function get_products($in_stock=false,$cat_id="",$search="", $page = "",$order){
            
            $filter = "";
            $filter2="";
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
                $filter .=" and products.product_name like '".$search."' "; //ORDER BY stamp DESC
            }
            
            if($order==0)
            {
                $filter2='ORDER BY products.price ASC';
            }
            if($order==1)
            {
                $filter2='ORDER BY products.price DESC';
            }
            if($order==2)
            {
                $filter2='ORDER BY products.product_name ASC';
            }
            if($order==3)
            {
                $filter2='ORDER BY products.product_name DESC';
            }
            
            
            
            $q = $this->db->query("Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
            inner join categories on categories.id = products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
           left join deal_product dp on dp.product_id=products.product_id where 1 ".$filter." ".$filter2." ".$limit);
            $products =$q->result();
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
      
      function stock_products($user_id){
            
            
            $q = $this->db->query("Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
            inner join categories on categories.id = products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
           left join deal_product dp on dp.product_id=products.product_id where products.store_id_login= ".$user_id);
            $products =$q->result();
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
      
      function get_header_products($in_stock=false,$cat_id="",$search="", $page = ""){
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and header_products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and header_products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and header_products.product_name like '".$search."' ";
            }
            $q = $this->db->query("Select header_products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,header_categories.title from header_products 
            inner join header_categories on header_categories.id = header_products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = header_products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = header_products.product_id
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
      
      function get_products_suggestion($in_stock=false,$cat_id="",$search, $page = "",$stores){
            $name=$this->input->post('product_name');
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
                $filter .=" and products.product_name like '.$search%.'";
            }
            $a=array();
            // $new_store = json_decode($stores);
            // foreach($response as $tt)
            // {
            //     $data[]= $tt->name;
            // }
            
            // $list = array();
            $i = 0;
            foreach($stores as $store)
            {
                array_push($a,$store);
                
                $q = $this->db->query("Select products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title, store_login.user_fullname, store_login.user_id from products 
            inner join categories on categories.id = products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
           
                left join store_login on store_login.user_id=products.store_id_login
                where 1 and products.product_name LIKE '".$search."%' and products.store_id_login='".$store->user_id."'" );
            // $list[$i]->data = $q->result();
            
            $a[$i]->product = $q->result();
            $i++;
            }
            
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
            $b = array('1', '2', '3');
            return $a; 
      }
      
      function get_product_by_id($prod_id){
            $q = $this->db->query("Select products.*, categories.title from products 
            inner join categories on categories.id = products.category_id
            where 1 and products.product_id = '".$prod_id."' limit 1");
            return $q->row();
            
      }
      
      function get_header_product_by_id($prod_id){
            $q = $this->db->query("Select header_products.*, header_categories.title from header_products 
            inner join header_categories on header_categories.id = header_products.category_id
            where 1 and header_products.product_id = '".$prod_id."' limit 1");
            return $q->row();
            
      }
      
      function get_purchase_list(){
        $q = $this->db->query("SELECT purchase. * , products.product_name, users.user_fullname, store_login.user_fullname FROM purchase
          LEFT JOIN products ON products.product_id = purchase.product_id
         LEFT JOIN users ON purchase.store_id_login = users.user_id
            LEFT JOIN store_login ON purchase.store_id_login = store_login.user_id");
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
      function rewards_value(){
        
        $q = $this->db->query("Select point from rewards where id=1");
            return $q->result();
      }
      
      function update_reward($data){
         
        $this->db->where('id', 1);
        $this->db->update('rewards', $data);
        
      }
      
      function coupon($data)
      {
          
          $this->db->insert('coupons',$data);
          return true;
      }
      
      function coupon_list()
      {
          $query = $this->db->get('coupons');
          return $query->result();
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

      function getCoupon($id)
      {
        $this->db->select('*');
        $this->db->from('coupons');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row_array(); 

      }

      function lookup($keyword){ 
        $this->db->select('*')->from('products'); 
        $this->db->like('product_name',$keyword,'after'); 

        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 
      
       function looku($keyword){ 
        $this->db->select('*')->from('categories'); 

        $this->db->like('title',$keyword,'after');
        $this->db->where('parent',0) ;
        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 

       function look($keyword){ 
        $this->db->select('*')->from('categories'); 
        $this->db->like('title',$keyword,'after');
        $this->db->where('parent>',0) ; 
        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 

      function get_sale_by_user($user_id){
            $q = $this->db->query("Select sale.*, user_location.*, store_login.user_fullname as vendor_name, delivery_boy.user_name as delivery_boy_name, delivery_boy.user_phone as delivery_boy_phone, delivery_boy.user_lat as delivery_boy_lat, delivery_boy.user_lng as delivery_boy_lng from sale
            left join user_location on user_location.location_id=sale.location_id
            left join delivery_boy on delivery_boy.user_name=sale.assign_to
            left join store_login on store_login.user_id=sale.new_store_id
            where sale.user_id = '".$user_id."' and sale.status != 3 ORDER BY sale.sale_id DESC");
            return $q->result();
      }
      function get_sale_by_user2($user_id){
            $q = $this->db->query("Select * from delivered_order where user_id = '".$user_id."' ORDER BY sale_id DESC");
            
            $q = $this->db->query("Select sale.*, store_login.user_fullname as vandor_name from sale
            inner join store_login on store_login.user_id = sale.new_store_id
            where sale.user_id = '".$user_id."' and sale.status BETWEEN '3' AND '4'  ORDER BY sale.sale_id DESC");
            
            return $q->result();
      }
      function get_sale_orders($filter=""){
         $sql = "Select distinct sale.*,registers.user_fullname, registers.user_phone,registers.pincode,
         registers.socity_id,registers.house_no, socity.socity_name, user_location.socity_id, sale.new_store_id ,
         user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile  from sale 
            inner join registers on registers.user_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join socity on socity.socity_id = user_location.socity_id
            left outer join users on users.user_id = user_location.store_id
            where 1 ".$filter." ORDER BY sale_id DESC";
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
        $q = $this->db->query("Select si.*,p.* from sale_items si 
        inner join products p on p.product_id = si.product_id where sale_id = '".$sale_id."'");
       /* $data['data'][]= $q->result();
        $q = $this->db->query("Select si.*,hp.* from sale_items si 
        inner join header_products hp on hp.product_id = si.product_id 
        where sale_id = '".$sale_id."'");
        $data['data'][] = $q->result();
        /*if(empty($data)){
         $q = $this->db->query("Select si.*,hp.* from sale_items si 
        inner join header_products hp on hp.product_id = si.product_id 
        where sale_id = '".$sale_id."'");
        }*/

    //int_r($data);exit();*/
            return $q->result();
      }
      
      function get_leftstock(){
        $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock from products 
        left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
            ");
        return $q->result();
      }
      
      function get_all_users(){
         $sql = "Select registers.*, ifnull(sale_order.total_amount, 0) as total_amount, total_orders, ifnull(sale_order.total_rewards, 0) as total_rewards  from registers 
            
            left outer join (Select sum(total_amount) as total_amount, count(sale_id) as total_orders, sum(total_rewards) as total_rewards, user_id from sale group by user_id) as sale_order on sale_order.user_id = registers.user_id
            where 1 order by user_id DESC";
            $q = $this->db->query($sql);
            
            return $q->result();
      }

      function adddealproduct($data)
      {
        $this->db->insert('deal_product',$data);
        return true;
      }

       function getdealproducts()
      {

        $query = $this->db->get('deal_product');
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
      
      function get_order_list()
      {
          
      }
      function delivery_boy_order($delivery_boy_id, $filter){
            $q = $this->db->query("Select sale.*,user_location.*, store_login.user_fullname as store_name from sale
            left outer join store_login on store_login.user_id = sale.new_store_id
            left outer join user_location on user_location.location_id = sale.location_id
            where assign_to = '".$delivery_boy_id."' ".$filter." ORDER BY sale_id DESC");
            return $q->result();
      }
      function get_store_list_by_id($store_id){
        $q = $this->db->query("Select * from store_login where  user_id ='".$user_id."'");
            return $q->row();
      }
       function sms_store_list()
      {
          $this->db->select('*');
          $this->db->from('message');
          $this->db->where('store_id',0);
          $query = $this->db->get();
          return $query->row();
      
      }
       function get_complain()
      {
        $this->db->select('*');
        $this->db->from(' user_complain');
        
        $query = $this->db->get();
        return $query->result(); 

      }
}
?>