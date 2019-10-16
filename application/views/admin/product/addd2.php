<html>
    <head>
        <script>
        function a()
        {
            document.getElementById("abc").style.visibility = "hidden";
            // var x = document.getElementById("");
            //  x.close(); 
            //  alert("hii");
            
        }
        function b()
        {
            var txt;
              var r = confirm("Press a button!\nEither OK or Cancel.\nThe button you pressed will be displayed in the result window.");
              if (r == true) {
                return true ;
              } else {
                return false ;
              } 
            
        }
        
        </script>
        <br>
        <h1><center> ADD PRODUCT</center></h1>
        </head>
        <body>
            
            <form name="f1" method="post">
        <table width="60%" align="center" border="10" cellspacing="0" cellpadding="0" bgcolor="white">
            <tr>
                <td> Product Name</td>
                <td><input type="text" name="prod_title"  placeholder="Product Title"></td></tr>
                <tr>
                    <td><input type="submit" name="addcatg" value="Add Product"></td></tr>
                </table>
                <table width="60%" align="center" border="10" cellspacing="0" cellpadding="0" bgcolor="white"><br>
                <?php foreach($products as $product){ ?>
                                                <tr>
                                                    <td>Product ID</td>
                                                    <td class="text-center"><?php echo $product->product_id; ?><td><td class="td-actions text-centet"><div class="btn-group">
                                                            <?php echo anchor('admin/edit_product/'.$product->product_id, '<button type="button" name="update" rel="tooltip" class="btn btn-success btn-round">
                                                            <i class="material-icons">UPDATE</i>
                                                        </button>', array("class"=>"")); ?>
                                                          <?php echo anchor('admin/edit_productt/'.$product->product_id, '<button type="button" name="delete" onclick="b()"rel="tooltip" class="btn btn-success btn-round">
                                                            <i class="material-icons">DELETE</i>
                                                        </button>', array("class"=>"")); ?></tr>
                                                    <tr>
                                                      <td>Product NAME</td>  
                                                    <td class="text-center"><?php echo $product->product_name; ?></td></tr>
                                                    <?php
                                                        }
                                                           ?>  
                                                    
     
                                                         
               
                </table>
                </form>
                </body>
                </html>