<html>
    <head>
        <style>
        
body  {
    background-color:white;
  background-image: <?php echo base_url();?>("body.jpg");
  /*background-color: #cccccc;*/
}
/*#rcorners1 {*/
/*#008080*/
/*  border-radius: 25px;*/
/*  background: #73AD21;*/
/*  padding: 20px; */
/*  width: 200px;*/
/*  height: 150px;  */
/*}*/
#rcorners1 {
 /* border-radius: 15px;*/
 /*border: 2px solid #73AD21;*/
 /* background:#fef9ef;*/
 /* padding: 10px;*/
 background:#67b748;
  /*width: 200px;*/
  height: 170px;  
}
#rcorners2 {
  /*border-radius:0px;*/
  border: 2px solid #73AD21;
  background:#fef9ef;
  /*padding: 0px; */
  /*width: 200px;*/
  /*height: 150px;  */
}
        </style>
    </head>
        <body ><br><br>
        <table  align="center" width="25%" height="100%" cellspacing="0" cellpadding="0" >
            <tr>
                <td  id="rcorners1" align="center"><BR><BR><img src="<?php echo base_url();?>uploads/user.JPG"  width="20%" height="30%" style="margin-top: 0px"><b><h1>Account Created</b></h1></td>
               
                </tr>
                <tr>
                <td id="rcorners2"><b>Hii <?= $user['user_name'];?>,</b><br>Congratulation your account has been successfully created. your email id<b> <?= $user['user_email'];?></b> and password is <b><?= $user['password'];?> </b>
                    </td>
               
                </tr>
                
            </table>
            <!--<table  align="center" width="40%" height="20%" cellspacing="0" cellpadding="0" bgcolor="white" id="rcorners1">-->
            <!--   <tr>-->
            <!--      <td><b>Hi Madhuri,</b><br><br>Your GOFRESH order ORD022361117 has been delivered at 8:05 PM on 2nd june</td> -->
                  
            <!--   </tr> -->
               
            <!--</table>-->
            <!--<table align="center" width="40%" height="40%" cellspacing="0" cellpadding="0" bgcolor="white" id="rcorners1">-->
            <!--   <tr><br>-->
            <!--      <td align="center"><img src="<?php echo base_url();?>uploads/logo.png" width="20%" height="40%" style="margin-top: 13px"><BR><h1>We were happy to serve you</h1><BR>Order Id: ORD022361117</td> -->
            <!--     </tr>  -->
              
            <!--</table>-->
            <!--<table align="center" width="40%" height="20%" cellspacing="0" cellpadding="0" bgcolor="white" id="rcorners1">-->
            <!--   <tr><br>-->
            <!--      <td>Regards,<BR>GOFRESH</td> -->
            <!--     </tr>  -->
            <!--   </table>-->
            <!--   <table align="center" width="40%" height="10%" cellspacing="0" cellpadding="0" bgcolor="">-->
            <!--   <tr>-->
            <!--      <td align="center"><img src="<?php echo base_url();?>uploads/l.png" width="40%" height="60%" style="margin-top: 13px"></td> -->
            <!--     </tr>  -->
            <!--   </table>-->
            
        </body>
</html>