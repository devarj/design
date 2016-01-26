
<!--<H3><?php // echo lang('order_number')?>: <?php echo $order_id ?></H3>-->

<!--{download_section}-->

<div class="confirm_customer">
<?php
//if($customer['company'] != '')
//{
//	echo '<div class="company_name">'.$customer['company'].'</div>';
//}
?>
<!--<br/><br/>-->
	<table width="100%" border="0" cellspacing="0" cellpadding="5">	
		<!-- <tr height="15">
			<td bgcolor="#DD127B" width="60" >                 
            </td>
            <td bgcolor="#db2e87" width="60">               
            </td>
            <td bgcolor="#be2574" width="60" >                 
            </td>
            <td bgcolor="#e64598" width="60">                 
            </td>
            <td bgcolor="#DD127B" width="60">                 
            </td>
        </tr>  
        <tr height="13">
          	<td colspan="5" bgcolor="#DD127B" >                	
            </td>           
        </tr> -->    
        <tr>
        	<td align="center" colspan="5" bgcolor="#ffffff"><br/><img src="http://nxled.com.ph/assets/img/nxled-logo.jpg" title="nxled" width="200"><br/><br/><br/>
        	</td>
        </tr>
        <!-- <tr>
        	<td colspan="5" bgcolor="#DD127B" height="12">
        	</td>
        </tr> -->
        <tr height="10">
        	<td width="100%" bgcolor="#282828" colspan="5">
        		<font color="#fff" face="Arial, Helvetica, sans-serif" size="-1">
                	Hi <b><?php echo $order->ship_firstname;?> <?php echo $order->ship_lastname;?></b>!<br/><br/>

                	Thank you for using <?php echo config_item('company_name'); ?>, the NeXt Generation LED Lighting. We have received your payment. Thus, your order is now in process to be delivered on <?php echo date('m/d/Y',strtotime($order->shipped_on));?>.<br/><br/>
        			Please see your order details below:<br/><br/><br/>
	                <b>Delivery To:</b> <?php echo $order->ship_firstname;?> <?php echo $order->ship_lastname;?> <br/><br/>
	                <b>Shipping Address:</b> 
	                    <?php 
	                        echo $order->ship_address1.' ';
						  	if(!empty($order->ship_address2)) {
	                            echo $order->ship_address2.' ';
	                        }
						  	echo $order->ship_city.', '.$order->ship_zone.' '.$order->ship_zip;
	                    ?>  <br/><br/>
	                <b>Contact Details:</b> <?php echo $order->ship_email;?> | <?php echo $order->ship_phone;?> <br/><br/>
					
					<table border="1" bordercolor="#8ec343">
						<tr>
	                        <td bgcolor="#333"><?php echo lang('sku')?></td>
	                        <td bgcolor="#333"><?php echo lang('name')?></td>
	                        <td bgcolor="#333"><?php echo lang('price')?></td>
	                        <td bgcolor="#333"><?php echo lang('quantity')?></td>
	                        <td bgcolor="#333"><?php echo lang('cart_total')?></td>
						</tr>
                    <?php foreach ($order->contents as $cartkey=>$product):?>	
                        <tr>
                            <td><?php echo $product['sku']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo format_currency($product['price']);   ?></td>
                            <td><?php //echo $product['quantity'];?> 
                                <?php 
                                    $aa[0] = '';
                                    if ($product['quantity'] == 0.25)
                                    {
                                        $aa[0] = '';
                                        $fraction = '   1/4';
                                    }
                                    elseif ($product['quantity'] == 0.5)
                                    {
                                        $aa[0] = '';
                                        $fraction = '   1/2';
                                    }
                                    elseif ($product['quantity'] == 0.75)
                                    {
                                        $aa[0] = '';
                                        $fraction = '  3/4';
                                    }
                                    else
                                    {
                                        $aa = explode('.', $product['quantity']);
                                        if ($aa[1] == 25)
                                        {
                                            $fraction = '  1/4';
                                        }
                                        elseif ($aa[1] == 5)
                                        {
                                            $fraction = '  1/2';
                                        }
                                        elseif ($aa[1] == 75)
                                        {
                                            $fraction = '  3/4';
                                        }
                                    }
                                    echo (strpos($product['quantity'], ".") !== false) ? $aa[0] . $fraction : $product['quantity']; 
                                ?>
                                <?php echo (empty($product['unit']))?'':$product['unit']; ?>
                            </td>
                            <td><?php echo format_currency($product['price']*$product['quantity']); ?></td>
						</tr>
                    <?php endforeach;?>
						<tr>
	                        <td colspan="4"><b><?php echo lang('subtotal')?></b></td>
	                        <td><?php echo format_currency($order->subtotal); ?></td>
						</tr>
                    <?php if (config_item('allow_delivery_charge')) : ?>
						<tr>
	                        <td colspan="4"><b><?php echo lang('delivery_charge')?></b></td>
	                        <td><?php echo format_currency($order->shipping) ?></td>					
							
						</tr>
                    <?php endif; ?>
						<tr>
	                        <td colspan="4" bgcolor="#333"><b><?php echo lang('grand_total')?></b></td>
	                        <td bgcolor="#333">
	                            <b><?php echo format_currency($order->total); ?></b>
	                            <br/>VAT Inclusive
	                        </td>
						</tr>
					</table>
					<br/><br/>
					<center>
						This email serves as your order confirmation form. Your official receipt will be provided upon delivery.<br/>
						<i>This is an electronically generated email</i>
					</center>
        		</font>
        	</td>
        </tr>
        <tr>
        	<td bgcolor="#333" colspan="5"><font face="Arial, Helvetica, sans-serif" color="#ffffff" size="-2"><center>For further assistance, you can contact us through our email cs@88db.com.ph or our hotline (+632) 955-1000.</center></font></td>
        </tr>
        <!--<tr colspan="5">
        <td  align="center" colspan="5" bgcolor="#ffffff"><br/><br/><br/></td>
    </tr>
    <tr height="13">
        <td colspan="5" bgcolor="#F8A035" > </td>           
    </tr> 
    <tr height="15">
        <td bgcolor="#f6931b" width="60" > </td>
        <td bgcolor="#f9b410" width="60"> </td>
        <td bgcolor="#fde102" width="60" > </td>
        <td bgcolor="#f5851f" width="60"> </td>
        <td bgcolor="#f9b410" width="60"> </td>
    </tr>-->
</table>
</div>
<!--
<div class="gc_view_cart_wrapper">	
	<table class="gc_view_cart" cellpadding="5" cellspacing="5" border="0">
		<thead>
			<tr>
				<th class="header_left">&nbsp;</th>
				<th class="product_info" colspan="2"><?php // echo lang('product_information');?></th>
				<th colspan="2"><?php // echo lang('price_and_quantity');?></th>
				<th class="header_right">&nbsp;</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3" class="gc_view_cart_totals"><?php // echo lang('subtotal');?></td>
				<td colspan="3" class="gc_total">
					<?php // echo format_currency($this->go_cart->subtotal()); ?>
				</td>
			</tr>
            <?php 
//            $delivery_charge = (config_item('allow_delivery_charge')) ? config_item('delivery_amount') : 0;
//            if (config_item('allow_delivery_charge')) : ?>
            <tr>
                <td colspan="4"><b><?php // echo lang('delivery_charge')?></b></td>
                <td><?php // echo format_currency($delivery_charge) ?></td>					
            </tr>
            <?php // endif; ?>
			<tr>
				<td colspan="3" class="gc_view_cart_totals"><?php // echo lang('shipping');?>: <?php // echo $shipping['method'] ?></td>
				<td colspan="3" class="gc_total"><?php // echo format_currency($shipping['price']) ?></td>
			<tr>
		<?php // if($this->go_cart->coupon_discount() > 0)  :?> 
			<tr>
				<td colspan="3" class="gc_view_cart_totals"><?php // echo lang('coupon_discount');?></td>
				<td colspan="3" class="gc_total"><?php // echo format_currency(0-$this->go_cart->coupon_discount()); ?>                </td>
			</tr>
			<?php // if($this->go_cart->order_tax() != 0) :// Only show a discount subtotal if we still have taxes to add (to show what the tax is calculated from) ?> 
			<tr>
				<td colspan="3" class="gc_view_cart_totals"><?php // echo lang('discounted_subtotal');?></td>
				<td colspan="3" class="gc_total"><?php // echo format_currency($this->go_cart->discounted_subtotal(), 2, '.', ','); ?>                </td>
			</tr>

<?php 
//			endif;
//		endif;
?>
           <?php // if($this->go_cart->order_tax() != 0) : ?> 
         	<tr>
				<td colspan="3"class="gc_view_cart_totals"><?php // echo lang('taxes');?></td>

				<td colspan="3" class="gc_total"><?php // echo format_currency($this->go_cart->order_tax()); ?>                </td>
			</tr>
          <?php // endif;   ?>

           <?php // if($this->go_cart->gift_card_discount() != 0) : ?> 
         	<tr>
				<td colspan="3"class="gc_view_cart_totals"><?php // echo lang('gift_card');?></td>

				<td colspan="3" ><?php // echo format_currency($this->go_cart->gift_card_discount()); ?>                </td>
			</tr>
          <?php // endif;   ?>
            <tr class="cart_grand_total"> 
				<td colspan="3" class="gc_view_cart_totals">
					<div class="cart_total_line_left"></div>
					<?php // echo lang('grand_total');?>
				</td>
				<td colspan="3" class="gc_total">
					<div class="cart_total_line_right"></div>
					<span id="gc_total_price"><?php // echo format_currency($this->go_cart->total()+$delivery_charge); ?></span>
				</td>
			</tr>
		</tfoot>
		<tbody class="cart_items">
		<?php
//		$td	= 'class="gc_even"';
//		$subtotal = 0;
//		foreach ($this->go_cart->contents() as $cartkey=>$product):?>	
			<tr <?php // echo $td;?>>
				<td class="table_left">&nbsp;</td>
				<td class="cart_product_info">
					<span class="cart_product_name"><?php // echo $product['name']; ?></span><br/>
					<span class="cart_product_code">Sku: <?php // echo $product['sku']; ?></span>
				</td>
				<td class="cart_product_description">
					
					<?php 
//                        echo $product['excerpt'];
//						if(isset($product['options'])) {
//							echo '<table cellspacing="0" cellpadding="0">';
//							foreach ($product['options'] as $name=>$value)
//							{
//								echo '<tr class="cart_options">';
//								if(is_array($value))
//								{
//									echo '<td class="cart_option"><strong>'.$name.':</strong></td><td class="cart_option">';
//									foreach($value as $item)
//									{
//										echo '<div>'.$item.'</div>';
//									}
//									echo '</td>';
//								} 
//								else 
//								{
//									echo '<td class="cart_option"><strong>'.$name.':</strong></td><td class="cart_option" > '.$value.'</td>';
//								}
//								echo '</tr>';
//							}
//							echo '</table>';
//						}
						?>
					
				</td>
				<td class="cart_quantity">
					<?php // echo format_currency($product['price']);   ?> &nbsp;x&nbsp; <?php // echo $product['quantity'];?>
				</td>
				<td class="total"><?php // echo format_currency($product['price']*$product['quantity']); ?></td>
				<td class="table_right">&nbsp;</td>
			</tr>
		<?php	
//		if ($td == 'class="gc_even"')
//		{
//			$td = 'class="gc_odd"';
//		}
//		else
//		{
//			$td = 'class="gc_even"';
//		}
		?>
		<?php // endforeach;?>
		</tbody>
	</table>
</div>-->