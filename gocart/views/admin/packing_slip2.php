<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo (!empty($seo_title)) ? $seo_title .' - ' : ''; echo $this->config->item('company_name'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Keywords" content="">
<?php if(isset($meta)):?>
    <meta name="Description" content="<?php echo $meta;?>">
<?php else:?>
<meta name="Description" content="">
<?php endif;?>

<!-- css files -->

<?php echo theme_css('bootstrap.css', true);?>
<?php echo theme_css('bootstrap.min.css', true);?>
<?php echo theme_css('nxled-newdesign.css', true);?>
<style type="text/css">
    .bord{
        border-width:0px;
        border-style: dashed;
        border-color: #bebebd;
    }
    #printable { display: none; }

    @media print{
        #non-printable { display: none; }
        #printable { display: block; }
         a {
            display:none;
        }
    } 
   

    @media screen{
        a {
        display:inline;
        }
    }
</style>
</head>

<body style=" background: #fff; color: #282828">
<div style="font-size:12px; font-family:arial, verdana, sans-serif;">
    <?php if ($this->config->item('site_logo')) : ?>
        <div>
        <!--<img src="<?php echo base_url($this->config->item('site_logo')); ?>" />-->
        </div>
    <?php endif; ?>
    <br /><br />
    <div class="">
        <div class="container">
            <div class="col-md-12" id="non-printable">
                <b style="float:right;font-size:2em;">Print Waybill</b><br /><br />
                <span class="pull-right">
                    <a href="<?php echo base_url('admin/orders/packing_slip') . '/' . $order->id; ?>">Switch to Two-Outs</a> |
                    <a href="" onClick="window.print();" >Print Waybill (4 Copies)</a> |
                    <a href="<?php echo base_url("admin/orders");?>">Back to Active Orders</a>
                </span>
                <hr />
            </div>
            <table width="100%">
                <tr>
                    <td width="50%">
                        <div class="col-md-12 bord" style="border-right-width: 1.5px;border-bottom-width: 1.5px;">
                            <br />
                            <table width="100%" style="">
                                <tr>
                                    <td colspan="4" width="50%" style="padding: 10px 0;" >
                                       <img src="<?php echo base_url('gocart/themes/default/assets/images/nxled_logo.jpg'); ?>" style="float:left; width: 170px; height: 67px;">            
                                        <img src="<?php echo base_url('gocart/themes/default/assets/images/88db_corporate.png');?>" style="float:left; height: 30px; margin-top: 2.8em; margin-left: 10px">  
                                        
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td colspan="2" style="border:2px solid  #E2E1E1; padding: 5px 5px 0 5px; line-height:1rem; max-width:50%;">
                                        <p style="font-size:9px;">ORDER NUMBER:</p>
                                        <P style="text-align:center; font-size:20px;"><?php echo $order->order_number; ?>
                                        <?php if (!empty($order->is_gift)): ?>
                                            <?php echo lang('packing_is_gift'); ?>
                                        <?php endif; ?>
                                    </p>
                                    </td>
                                    <td colspan="2" style="border:2px solid  #E2E1E1; padding: 5px 5px 0 5px; line-height:1rem; max-width:50%;">
                                        <p style="font-size:9px;">WAYBILL NUMBER:</p>
                                        <P style="text-align:center;font-size:20px;"><?php echo $order->waybill_no; ?>
                                        <?php if (!empty($order->is_gift)): ?>
                                            <?php echo lang('packing_is_gift'); ?>
                                        <?php endif; ?>
                                    </p>
                                    </td>
                                </tr >
                                <tr style="border-bottom:5px solid #E2E1E1; vertical-align:top;">
                                    <td colspan="2" width="50%" style="border:2px solid  #E2E1E1; padding: 10px 5px; line-height:1rem;">
                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP PERSON:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_person; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP LOCATION:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_loc; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP DATE & TIME:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_date.' '.$order->pickup_time; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PHONE NUMBER:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_contact; ?></span>
                                        <br/><br/><br/>

                                    </td>

                                    <td colspan="2" width="50%" style="border:2px solid  #E2E1E1; padding: 10px 5px; line-height:1rem;">
                                        <p style="margin-bottom:3px; font-size:9px;">SHIP TO NAME:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_firstname . ' ' . $order->ship_lastname; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">SHIPPING ADDRESS:</p>
                                        <span style="font-size:.8em;line-height: 1.2em;">
                                            <?php echo $order->ship_address1; ?><br>
                                            <?php echo (!empty($order->ship_address2)) ? $order->ship_address2 . '<br/>' : ''; ?>
                                            <?php echo $order->ship_city . ', ' . $order->ship_zone . ' ' . $order->ship_zip; ?><br/>
                                            <?php echo $order->ship_country; ?><br/>
                                        </span>
                                        <br/>

                                        <p style="margin-bottom:3px; font-size:9px;">EMAIL:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_email; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PHONE NUMBER:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_phone; ?></span>
                                        <br/><br/>
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">DECLARED VALUE:</p>
                                        <span style="font-size:12px;"><?php echo format_currency($order->subtotal); ?></span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">SPECIAL INSTRUCTION:</p>
                                        <span style="font-size:12px;">FRAGILE</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">DESCRIPTION OF PACKAGE:</p>
                                        <span style="font-size:12px;">ELECTRIC</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">WEIGHT:</p>
                                        <span style="font-size:12px;"></span>
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td colspan="4" style="border:2px solid  #E2E1E1;padding: 5px; line-height:1.5rem; width:25%;">
                                        <span style="font-size:16px; font-weight: bold;">Products</span>
                                    </td>
                                </tr>
                                <tr style="padding: 5px; line-height:1rem; width:25%;">
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">ITEM CODE:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">PRODUCT NAME:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:12.5%;">
                                        <span style="font-size:9px;">QUANTITY:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">TOTAL:</span>
                                    </td>
                                </tr>
                                <!-- Edit -->
                                <?php foreach($order->contents as $orderkey=>$product):?>
                                <tr>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['sku'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['name'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['quantity'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo format_currency($product['price']*$product['quantity']);?></span>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                                <!-- Edit -->
                                 <tr style="border-top:5px solid #E2E1E1;">
                                    <td colspan="3" style="text-align:right;border:2px solid  #E2E1E1;padding: 10px; line-height:1.5rem; width:75%;">
                                        <span style="font-size:16px; font-weight: bold;">TOTAL</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 10px; line-height:1.5rem; width:25%;">
                                        <span style="font-size:16px; font-weight: bold;"><?php echo format_currency($order->subtotal); ?></span>
                                    </td>
                                </tr>
                            </table>
                            <br />
                        </div>
                    </td>
                    <td width="50%">
                        <div class="col-md-12 bord" style="border-bottom-width: 1.5px;">
                            <br />
                            <table width="100%" style="">
                                <tr>
                                    <td colspan="4" width="50%" style="padding: 10px 0;" >
                                       <img src="<?php echo base_url('gocart/themes/default/assets/images/nxled_logo.jpg'); ?>" style="float:left; width: 170px; height: 67px;">            
                                        <img src="<?php echo base_url('gocart/themes/default/assets/images/88db_corporate.png');?>" style="float:left; height: 30px; margin-top: 2.8em; margin-left: 10px">  
                                        
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td colspan="2" style="border:2px solid  #E2E1E1; padding: 5px 5px 0 5px; line-height:1rem; max-width:50%;">
                                        <p style="font-size:9px;">ORDER NUMBER:</p>
                                        <P style="text-align:center; font-size:20px;"><?php echo $order->order_number; ?>
                                        <?php if (!empty($order->is_gift)): ?>
                                            <?php echo lang('packing_is_gift'); ?>
                                        <?php endif; ?>
                                    </p>
                                    </td>
                                    <td colspan="2" style="border:2px solid  #E2E1E1; padding: 5px 5px 0 5px; line-height:1rem; max-width:50%;">
                                        <p style="font-size:9px;">WAYBILL NUMBER:</p>
                                        <P style="text-align:center;font-size:20px;"><?php echo $order->waybill_no; ?>
                                        <?php if (!empty($order->is_gift)): ?>
                                            <?php echo lang('packing_is_gift'); ?>
                                        <?php endif; ?>
                                    </p>
                                    </td>
                                </tr >
                                <tr style="border-bottom:5px solid #E2E1E1; vertical-align:top;">
                                    <td colspan="2" width="50%" style="border:2px solid  #E2E1E1; padding: 10px 5px; line-height:1rem;">
                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP PERSON:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_person; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP LOCATION:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_loc; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP DATE & TIME:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_date.' '.$order->pickup_time; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PHONE NUMBER:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_contact; ?></span>
                                        <br/><br/><br/>

                                    </td>

                                    <td colspan="2" width="50%" style="border:2px solid  #E2E1E1; padding: 10px 5px; line-height:1rem;">
                                        <p style="margin-bottom:3px; font-size:9px;">SHIP TO NAME:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_firstname . ' ' . $order->ship_lastname; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">SHIPPING ADDRESS:</p>
                                        <span style="font-size:.8em;line-height: 1.2em;">
                                            <?php echo $order->ship_address1; ?><br>
                                            <?php echo (!empty($order->ship_address2)) ? $order->ship_address2 . '<br/>' : ''; ?>
                                            <?php echo $order->ship_city . ', ' . $order->ship_zone . ' ' . $order->ship_zip; ?><br/>
                                            <?php echo $order->ship_country; ?><br/>
                                        </span>
                                        <br/>

                                        <p style="margin-bottom:3px; font-size:9px;">EMAIL:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_email; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PHONE NUMBER:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_phone; ?></span>
                                        <br/><br/>
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">DECLARED VALUE:</p>
                                        <span style="font-size:12px;"><?php echo format_currency($order->subtotal); ?></span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">SPECIAL INSTRUCTION:</p>
                                        <span style="font-size:12px;">FRAGILE</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">DESCRIPTION OF PACKAGE:</p>
                                        <span style="font-size:12px;">ELECTRIC</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">WEIGHT:</p>
                                        <span style="font-size:12px;"></span>
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td colspan="4" style="border:2px solid  #E2E1E1;padding: 5px; line-height:1.5rem; width:25%;">
                                        <span style="font-size:16px; font-weight: bold;">Products</span>
                                    </td>
                                </tr>
                                <tr style="padding: 5px; line-height:1rem; width:25%;">
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">ITEM CODE:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">PRODUCT NAME:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:12.5%;">
                                        <span style="font-size:9px;">QUANTITY:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">TOTAL:</span>
                                    </td>
                                </tr>
                                <!-- Edit -->
                                <?php foreach($order->contents as $orderkey=>$product):?>
                                <tr>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['sku'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['name'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['quantity'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo format_currency($product['price']*$product['quantity']);?></span>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                                <!-- Edit -->
                                 <tr style="border-top:5px solid #E2E1E1;">
                                    <td colspan="3" style="text-align:right;border:2px solid  #E2E1E1;padding: 10px; line-height:1.5rem; width:75%;">
                                        <span style="font-size:16px; font-weight: bold;">TOTAL</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 10px; line-height:1.5rem; width:25%;">
                                        <span style="font-size:16px; font-weight: bold;"><?php echo format_currency($order->subtotal); ?></span>
                                    </td>
                                </tr>
                            </table>
                            <br />
                        </div>             
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <div class="col-md-12 bord" style="border-right-width: 1.5px;">
                            <br />
                            <table width="100%" style="">
                                <tr>
                                    <td colspan="4" width="50%" style="padding: 10px 0;" >
                                       <img src="<?php echo base_url('gocart/themes/default/assets/images/nxled_logo.jpg'); ?>" style="float:left; width: 170px; height: 67px;">            
                                        <img src="<?php echo base_url('gocart/themes/default/assets/images/88db_corporate.png');?>" style="float:left; height: 30px; margin-top: 2.8em; margin-left: 10px">  
                                        
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td colspan="2" style="border:2px solid  #E2E1E1; padding: 5px 5px 0 5px; line-height:1rem; max-width:50%;">
                                        <p style="font-size:9px;">ORDER NUMBER:</p>
                                        <P style="text-align:center; font-size:20px;"><?php echo $order->order_number; ?>
                                        <?php if (!empty($order->is_gift)): ?>
                                            <?php echo lang('packing_is_gift'); ?>
                                        <?php endif; ?>
                                    </p>
                                    </td>
                                    <td colspan="2" style="border:2px solid  #E2E1E1; padding: 5px 5px 0 5px; line-height:1rem; max-width:50%;">
                                        <p style="font-size:9px;">WAYBILL NUMBER:</p>
                                        <P style="text-align:center;font-size:20px;"><?php echo $order->waybill_no; ?>
                                        <?php if (!empty($order->is_gift)): ?>
                                            <?php echo lang('packing_is_gift'); ?>
                                        <?php endif; ?>
                                    </p>
                                    </td>
                                </tr >
                                <tr style="border-bottom:5px solid #E2E1E1; vertical-align:top;">
                                    <td colspan="2" width="50%" style="border:2px solid  #E2E1E1; padding: 10px 5px; line-height:1rem;">
                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP PERSON:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_person; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP LOCATION:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_loc; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP DATE & TIME:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_date.' '.$order->pickup_time; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PHONE NUMBER:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_contact; ?></span>
                                        <br/><br/><br/>

                                    </td>

                                    <td colspan="2" width="50%" style="border:2px solid  #E2E1E1; padding: 10px 5px; line-height:1rem;">
                                        <p style="margin-bottom:3px; font-size:9px;">SHIP TO NAME:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_firstname . ' ' . $order->ship_lastname; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">SHIPPING ADDRESS:</p>
                                        <span style="font-size:.8em;line-height: 1.2em;">
                                            <?php echo $order->ship_address1; ?><br>
                                            <?php echo (!empty($order->ship_address2)) ? $order->ship_address2 . '<br/>' : ''; ?>
                                            <?php echo $order->ship_city . ', ' . $order->ship_zone . ' ' . $order->ship_zip; ?><br/>
                                            <?php echo $order->ship_country; ?><br/>
                                        </span>
                                        <br/>

                                        <p style="margin-bottom:3px; font-size:9px;">EMAIL:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_email; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PHONE NUMBER:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_phone; ?></span>
                                        <br/><br/>
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">DECLARED VALUE:</p>
                                        <span style="font-size:12px;"><?php echo format_currency($order->subtotal); ?></span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">SPECIAL INSTRUCTION:</p>
                                        <span style="font-size:12px;">FRAGILE</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">DESCRIPTION OF PACKAGE:</p>
                                        <span style="font-size:12px;">ELECTRIC</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">WEIGHT:</p>
                                        <span style="font-size:12px;"></span>
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td colspan="4" style="border:2px solid  #E2E1E1;padding: 5px; line-height:1.5rem; width:25%;">
                                        <span style="font-size:16px; font-weight: bold;">Products</span>
                                    </td>
                                </tr>
                                <tr style="padding: 5px; line-height:1rem; width:25%;">
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">ITEM CODE:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">PRODUCT NAME:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:12.5%;">
                                        <span style="font-size:9px;">QUANTITY:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">TOTAL:</span>
                                    </td>
                                </tr>
                                <!-- Edit -->
                                <?php foreach($order->contents as $orderkey=>$product):?>
                                <tr>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['sku'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['name'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['quantity'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo format_currency($product['price']*$product['quantity']);?></span>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                                <!-- Edit -->
                                 <tr style="border-top:5px solid #E2E1E1;">
                                    <td colspan="3" style="text-align:right;border:2px solid  #E2E1E1;padding: 10px; line-height:1.5rem; width:75%;">
                                        <span style="font-size:16px; font-weight: bold;">TOTAL</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 10px; line-height:1.5rem; width:25%;">
                                        <span style="font-size:16px; font-weight: bold;"><?php echo format_currency($order->subtotal); ?></span>
                                    </td>
                                </tr>
                            </table>
                            <br />
                        </div>
                    </td>
                    <td width="50%">
                        <div class="col-md-12 bord" style="">
                            <br />
                            <table width="100%" style="">
                                <tr>
                                    <td colspan="4" width="50%" style="padding: 10px 0;" >
                                       <img src="<?php echo base_url('gocart/themes/default/assets/images/nxled_logo.jpg'); ?>" style="float:left; width: 170px; height: 67px;">            
                                        <img src="<?php echo base_url('gocart/themes/default/assets/images/88db_corporate.png');?>" style="float:left; height: 30px; margin-top: 2.8em; margin-left: 10px">  
                                        
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td colspan="2" style="border:2px solid  #E2E1E1; padding: 5px 5px 0 5px; line-height:1rem; max-width:50%;">
                                        <p style="font-size:9px;">ORDER NUMBER:</p>
                                        <P style="text-align:center; font-size:20px;"><?php echo $order->order_number; ?>
                                        <?php if (!empty($order->is_gift)): ?>
                                            <?php echo lang('packing_is_gift'); ?>
                                        <?php endif; ?>
                                    </p>
                                    </td>
                                    <td colspan="2" style="border:2px solid  #E2E1E1; padding: 5px 5px 0 5px; line-height:1rem; max-width:50%;">
                                        <p style="font-size:9px;">WAYBILL NUMBER:</p>
                                        <P style="text-align:center;font-size:20px;"><?php echo $order->waybill_no; ?>
                                        <?php if (!empty($order->is_gift)): ?>
                                            <?php echo lang('packing_is_gift'); ?>
                                        <?php endif; ?>
                                    </p>
                                    </td>
                                </tr >
                                <tr style="border-bottom:5px solid #E2E1E1; vertical-align:top;">
                                    <td colspan="2" width="50%" style="border:2px solid  #E2E1E1; padding: 10px 5px; line-height:1rem;">
                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP PERSON:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_person; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP LOCATION:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_loc; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PICKUP DATE & TIME:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_date.' '.$order->pickup_time; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PHONE NUMBER:</p>
                                        <span style="font-size:.8em;"><?php echo $order->pickup_contact; ?></span>
                                        <br/><br/><br/>

                                    </td>

                                    <td colspan="2" width="50%" style="border:2px solid  #E2E1E1; padding: 10px 5px; line-height:1rem;">
                                        <p style="margin-bottom:3px; font-size:9px;">SHIP TO NAME:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_firstname . ' ' . $order->ship_lastname; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">SHIPPING ADDRESS:</p>
                                        <span style="font-size:.8em;line-height: 1.2em;">
                                            <?php echo $order->ship_address1; ?><br>
                                            <?php echo (!empty($order->ship_address2)) ? $order->ship_address2 . '<br/>' : ''; ?>
                                            <?php echo $order->ship_city . ', ' . $order->ship_zone . ' ' . $order->ship_zip; ?><br/>
                                            <?php echo $order->ship_country; ?><br/>
                                        </span>
                                        <br/>

                                        <p style="margin-bottom:3px; font-size:9px;">EMAIL:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_email; ?></span>
                                        <br/><br/><br/>

                                        <p style="margin-bottom:3px; font-size:9px;">PHONE NUMBER:</p>
                                        <span style="font-size:.8em;"><?php echo $order->ship_phone; ?></span>
                                        <br/><br/>
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">DECLARED VALUE:</p>
                                        <span style="font-size:12px;"><?php echo format_currency($order->subtotal); ?></span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">SPECIAL INSTRUCTION:</p>
                                        <span style="font-size:12px;">FRAGILE</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">DESCRIPTION OF PACKAGE:</p>
                                        <span style="font-size:12px;">ELECTRIC</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 5px; line-height:1rem; width:25%;">
                                        <p style="margin-bottom:10px; font-size:9px;">WEIGHT:</p>
                                        <span style="font-size:12px;"></span>
                                    </td>
                                </tr>
                                <tr style="border-bottom:5px solid #E2E1E1;">
                                    <td colspan="4" style="border:2px solid  #E2E1E1;padding: 5px; line-height:1.5rem; width:25%;">
                                        <span style="font-size:16px; font-weight: bold;">Products</span>
                                    </td>
                                </tr>
                                <tr style="padding: 5px; line-height:1rem; width:25%;">
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">ITEM CODE:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">PRODUCT NAME:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:12.5%;">
                                        <span style="font-size:9px;">QUANTITY:</span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:1rem; width:25%;">
                                        <span style="font-size:9px;">TOTAL:</span>
                                    </td>
                                </tr>
                                <!-- Edit -->
                                <?php foreach($order->contents as $orderkey=>$product):?>
                                <tr>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['sku'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['name'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo $product['quantity'];?></span>
                                    </td>
                                    <td style="border-right:2px solid #E2E1E1; border-left:2px solid #E2E1E1; padding: 5px; line-height:.8rem;">
                                        <span style="font-size:12px;"><?php echo format_currency($product['price']*$product['quantity']);?></span>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                                <!-- Edit -->
                                 <tr style="border-top:5px solid #E2E1E1;">
                                    <td colspan="3" style="text-align:right;border:2px solid  #E2E1E1;padding: 10px; line-height:1.5rem; width:75%;">
                                        <span style="font-size:16px; font-weight: bold;">TOTAL</span>
                                    </td>
                                    <td style="border:2px solid  #E2E1E1;padding: 10px; line-height:1.5rem; width:25%;">
                                        <span style="font-size:16px; font-weight: bold;"><?php echo format_currency($order->subtotal); ?></span>
                                    </td>
                                </tr>
                            </table>
                            <br />
                        </div>             
                    </td>
                </tr>
            </table>

            

        </div>
    </div>
    <br />
<!-------------- original -------------------->
<!--
    <table style="border:1px solid #000; width:100%; font-size:12px;" cellpadding="5" cellspacing="0">
        <tr>
            <td style="width:20%; vertical-align:top;" class="packing">
                <h2 style="margin:0px">*<?php echo $order->order_number; ?>*</h2>
                <?php if (!empty($order->is_gift)): ?>
                    <h1 style="margin:0px; font-size:4em;"><?php echo lang('packing_is_gift'); ?></h1>
                <?php endif; ?>
            </td>
            <td style="width:40%; vertical-align:top;">
                <strong><?php echo lang('bill_to_address'); ?></strong><br/>
                <?php echo (!empty($order->bill_company)) ? $order->bill_company . '<br/>' : ''; ?>
                <?php echo $order->bill_firstname . ' ' . $order->bill_lastname; ?> <br/>
                <?php echo $order->bill_address1; ?><br>
                <?php echo (!empty($order->bill_address2)) ? $order->bill_address2 . '<br/>' : ''; ?>
                <?php echo $order->bill_city . ', ' . $order->bill_zone . ' ' . $order->bill_zip; ?><br/>
                <?php echo $order->bill_country; ?><br/>

                <?php echo $order->bill_email; ?><br/>
                <?php echo $order->bill_phone; ?>

            </td>
            <td style="width:40%; vertical-align:top;" class="packing">
                <strong><?php echo lang('ship_to_address'); ?></strong><br/>        
                <?php echo (!empty($order->ship_company)) ? $order->ship_company . '<br/>' : ''; ?>
                <?php echo $order->ship_firstname . ' ' . $order->ship_lastname; ?> <br/>
                <?php echo $order->ship_address1; ?><br>
                <?php echo (!empty($order->ship_address2)) ? $order->ship_address2 . '<br/>' : ''; ?>
                <?php echo $order->ship_city . ', ' . $order->ship_zone . ' ' . $order->ship_zip; ?><br/>
                <?php echo $order->ship_country; ?><br/>

                <?php echo $order->ship_email; ?><br/>
                <?php echo $order->ship_phone; ?>

                <br/>
            </td>
        </tr>

        <tr>
            <td style="border-top:1px solid #000;"></td>
            <td style="border-top:1px solid #000;">
                <strong><?php echo lang('payment_method'); ?></strong>
                <?php echo $order->payment_info; ?>
            </td>
            <td style="border-top:1px solid #000;">
                <strong><?php echo lang('shipping_details'); ?></strong>
                <?php echo $order->shipping_method; ?>
            </td>
        </tr>

        <?php if (!empty($order->gift_message)): ?>
            <tr>
                <td colspan="3" style="border-top:1px solid #000;">
                    <strong><?php echo lang('gift_note'); ?></strong>
                    <?php echo $order->gift_message; ?>
                </td>
            </tr>
        <?php endif; ?>

        <?php if (!empty($order->shipping_notes)): ?>
            <tr>
                <td colspan="3" style="border-top:1px solid #000;">
                    <strong><?php echo lang('shipping_notes'); ?></strong><br/><?php echo $order->shipping_notes; ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>

    <table border="1" style="width:100%; margin-top:10px; border-color:#000; font-size:12px; border-collapse:collapse;" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th width="5%" class="packing">
                    <?php echo lang('qty'); ?>
                </th>
                <th width="20%" class="packing">
                    <?php echo lang('name'); ?>
                </th>
                <th class="packing" >
                    <?php echo lang('description'); ?>
                </th>
            </tr>
        </thead>
        <?php $items = $order->contents; ?>


        <?php
        foreach ($order->contents as $orderkey => $product):
            $img_count = 1;
            ?>
            <tr>
                <td class="packing" style="font-size:20px; font-weight:bold;">
    <?php echo $product['quantity']; ?>
                </td>
                <td class="packing">
                    <?php echo $product['name']; ?>
    <?php echo (trim($product['sku']) != '') ? '<br/><small>sku: ' . $product['sku'] . '</small>' : ''; ?>
                </td>
                <td class="packing">
                    <?php
                    if (isset($product['options'])) {
                        foreach ($product['options'] as $name => $value) {
                            $name = explode('-', $name);
                            $name = trim($name[0]);
                            if (is_array($value)) {
                                echo '<div>' . $name . ':<br/>';
                                foreach ($value as $item) {
                                    echo '- ' . $item . '<br/>';
                                }
                                echo "</div>";
                            } else {
                                echo '<div>' . $name . ': ' . $value . '</div>';
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
                <?php endforeach; ?>
    </table> -->
</div>


<br class="break"/>

</body>
</html>