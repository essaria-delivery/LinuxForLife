<html>
    <head>
        <style>
        body {
  background-color: #73AD21;
  /*008080*/
}

/*#rcorners1 {*/
/*  border-radius: 25px;*/
/*  background: #73AD21;*/
/*  padding: 20px; */
/*  width: 200px;*/
/*  height: 150px;  */
/*}*/
#rcorners1 {
  border-radius: 15px;
  border: 2px solid #73AD21;
  background:white;
  padding: 20px; 
  /*width: 200px;*/
  /*height: 150px;  */
}
        </style>
    </head>
        <body><br><br>
            <table  align="center" width="40%" height="20%" cellspacing="0" cellpadding="0" bgcolor="white" id="rcorners1">
               <tr>
                  <td><b>Hi <?= $order['user_name'];?>,</b><br><br>Your GOFRESH order id.# <?= $order['order_id'];?> has been delivered</td> 
                  
               </tr> 
               
            </table>
            <br>
            
            <table align="center" width="40%" height="40%" cellspacing="0" cellpadding="0" bgcolor="white" id="rcorners1">
               <tr><br>
                  <td align="center"><img src="<?php echo base_url();?>uploads/logo.png" width="20%" height="40%" style="margin-top: 13px"><BR><h1>We were happy to serve you</h1><BR>Order Id: #<?= $order['order_id'];?></td> 
                 </tr>  
              
            </table>
            <br>
            <table align="center" width="40%" height="20%" cellspacing="0" cellpadding="0" bgcolor="white" id="rcorners1">
               <tr><br>
                  <td>Regards,<BR>GOFRESH</td> 
                 </tr>  
               </table>
               <table align="center" width="40%" height="10%" cellspacing="0" cellpadding="0" bgcolor="">
               <tr>
                  <td align="center"><img src="<?php echo base_url();?>uploads/l.png" width="40%" height="60%" style="margin-top: 13px"></td> 
                 </tr>  
               </table>
            
        </body>
</html>