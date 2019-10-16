<html>
<div class="material-datatables">
    <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%;padding-top: 50px !important;" >
<tr>
    <td class="esd-structure es-p10t es-p10b es-p20r es-p20l" esd-general-paddings-checked="false" align="left">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    
                    <td class="esd-container-frame" width="560" valign="top" align="center">
                        <table style="border-radius: 0px; border-collapse: separate;" width="100%" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td class="esd-block-text es-p10t es-p15b" align="center">
                                        <h1>Thanks for your order</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="esd-block-text es-p5t es-p5b es-p40r es-p40l" align="center">
                                        <p style="color: #333333;">You made an excellent choice by deciding to purchase one of the top selling product on GOFRESH. You'll receive an email when your items are shipped.</p>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td class="esd-stripe" esd-custom-block-id="1755" align="center">
        <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
            <tbody>
                <tr>
                    <td class="esd-structure es-p20t es-p30b es-p20r es-p20l" align="left">
                        <!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="280" valign="top"><![endif]-->
                        <table class="es-left" cellspacing="0" cellpadding="0" align="left">
                            <tbody>
                                <tr>
                                    <td class="es-m-p20b esd-container-frame" width="280" align="left">
                                        <table style="background-color: rgb(254, 249, 239); border-color: rgb(239, 239, 239); border-collapse: separate; border-width: 1px 0px 1px 1px; border-style: solid;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#fef9ef">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-block-text es-p20t es-p10b es-p20r es-p20l" align="left">
                                                        <h4>SUMMARY:</h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="esd-block-text es-p20b es-p20r es-p20l" align="left">
                                                        <table style="width: 100%;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left">
                                                            <tbody>
                                                                <tr>
                                                                    <td><span style="font-size: 14px; line-height: 150%;">Order #:</p></span></td>
                                                                  
                                                                    <td><span style="font-size: 14px; line-height: 150%;"><?= $order['id'];?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size: 14px; line-height: 150%;">Order Date:</span></td>
                                                                    <td><span style="font-size: 14px; line-height: 150%;"><?=$order['date'];?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span style="font-size: 14px; line-height: 150%;">Order Total:</span></td>
                                                                    <td><span style="font-size: 14px; line-height: 150%;">Rs:<?= $order['total_price'];?></span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <p style="line-height: 150%;"><br></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!--[if mso]></td><td width="0"></td><td width="280" valign="top"><![endif]-->
                        <table class="es-right" cellspacing="0" cellpadding="0" align="right">
                            <tbody>
                                <tr>
                                    <td class="esd-container-frame" width="280" align="left">
                                        <table style="background-color: rgb(254, 249, 239); border-collapse: separate; border-width: 1px; border-style: solid; border-color: rgb(239, 239, 239);" width="100%" cellspacing="0" cellpadding="0" bgcolor="#fef9ef">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-block-text es-p20t es-p10b es-p20r es-p20l" align="left">
                                                        <h4>SHIPPING ADDRESS:<br></h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="esd-block-text es-p20b es-p20r es-p20l" align="left">
                                                        <p><?= $order['address'];?></p>
                                                        <p><?= $order['house_no'];?></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!--[if mso]></td></tr></table><![endif]-->
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>

    <table class="es-content" cellspacing="0" cellpadding="0" align="center">
        <tbody>
            <tr>
                <td class="esd-stripe" esd-custom-block-id="1758" align="center">
                    <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                        <tbody>
                            <tr>
                                <td class="esd-structure es-p10t es-p10b es-p20r es-p20l" esd-general-paddings-checked="false" align="left">
                                    <!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="270" valign="top"><![endif]-->
                                    <table class="es-left" cellspacing="0" cellpadding="0" align="left">
                                        <tbody>
                                            <tr>
                                                <td class="es-m-p0r es-m-p20b esd-container-frame" width="270" valign="top" align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="esd-block-text es-p20l" align="left">
                                                                    <h4>ITEMS ORDERED</h4>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--[if mso]></td><td width="20"></td><td width="270" valign="top"><![endif]-->
                                    <table cellspacing="0" cellpadding="0" align="right">
                                        <tbody>
                                            <tr>
                                                <td class="esd-container-frame" width="270" align="left">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="esd-block-text" align="left">
                                                                    <table style="width: 100%;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><span style="font-size:13px;">NAME</span></td>
                                                                                <td style="text-align: center;" width="60"><span style="font-size:13px;"><span style="line-height: 100%;">QTY</span></span>
                                                                                </td>
                                                                                <td style="text-align: center;" width="100"><span style="font-size:13px;"><span style="line-height: 100%;">PRICE</span></span>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--[if mso]></td></tr></table><![endif]-->
                                </td>
                            </tr>
                            
                          
                         
                         <?php $i=0;
                         foreach($items as $item){ 
                         
                         ?>
                            <tr>
                             
                                <td class="esd-structure es-p5t es-p10b es-p20r es-p20l" esd-general-paddings-checked="false" align="left">
                                    <!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="178" valign="top"><![endif]-->
                                    <table class="es-left" cellspacing="0" cellpadding="0" align="left">
                                        <tbody>
                                            <tr>
                                                <td class="es-m-p0r es-m-p20b esd-container-frame" width="178" valign="top" align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="esd-block-image" align="center">
                                                                    <a href target="_blank"><img width="100px" height="100px" src="<?php echo $this->config->item('base_url').'uploads/products/'.$item->product_image; ?>" /></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--[if mso]></td><td width="20"></td><td width="362" valign="top"><![endif]-->
                                    <table cellspacing="0" cellpadding="0" align="right">
                                        <tbody>
                                            <tr>
                                                <td class="esd-container-frame" width="362" align="left">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="esd-block-text" align="left">
                                                                    <p><br></p>
                                                                    <table style="width: 100%;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?php echo $item->product_name; ?>
                               
                               <br></td>
                                                                                <td style="text-align: center;" width="60"> <?php echo $item->qty; ?></td>
                                                                                <td style="text-align: center;" width="100"> <?php echo $item->price; ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <p><br></p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--[if mso]></td></tr></table><![endif]-->
                                </td>
                            </tr>
                           <?php 
                           $i++;
                           
                           }?>
                            <tr>
                                <td class="esd-structure es-p5t es-p30b es-p40r es-p20l" align="left">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td class="esd-container-frame" width="540" valign="top" align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="esd-block-text" align="right">
                                                                    <table style="width: 500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="right">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="text-align: right; font-size: 18px; line-height: 150%;">Subtotal (<?= $i;?> items):</td>
                                                                                <td style="text-align: right; font-size: 18px; line-height: 150%;"><?= $order['total_price'];?></td>
                                                                            </tr>
                                                                            <!--<tr>-->
                                                                            <!--    <td style="text-align: right; font-size: 18px; line-height: 150%;">Flat-rate Shipping:</td>-->
                                                                            <!--    <td style="text-align: right; font-size: 18px; line-height: 150%; color: #d48344;"><strong>FREE</strong></td>-->
                                                                            <!--</tr>-->
                                                                            
                                                                            <tr>
                                                                                <td style="text-align: right; font-size: 18px; line-height: 150%;"><strong>Order Total:</strong></td>
                                                                                <td style="text-align: right; font-size: 18px; line-height: 150%; color: #d48344;"><strong>Rs:<?= $order['total_price'];?></strong></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <p style="line-height: 150%;"><br></p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    </table>
</div>
</html>

