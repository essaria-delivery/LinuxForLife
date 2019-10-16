<html>
    <body>
    <form name="f1" method="post">
     <table width="60%" align="center" border="10" cellspacing="0" cellpadding="0" bgcolor="white"><br>
     
            <tr>
                <td> Product Name</td>
                <td><input type="text" name="prod_title"  value='<?php echo $products->product_name; ?>'></td></tr>
                
                 <!--print_r($products->product_name)?>-->
                 
                <tr>
                    <td><input type="submit" name="edit" value="EDIT"></td></tr>
                    <tr>
                    <td><input type="hidden" name="id" value='<?php echo $products->product_id; ?>'></td></tr>
                      <!--print_r($products->product_id)?>-->
                     
                </table>
                </form>
                </body>
                </html>