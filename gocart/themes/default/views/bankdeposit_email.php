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
        	<td height="12" colspan="5" bgcolor="#DD127B">
        	</td>
        </tr> -->
        <tr height="10">
        	<td width="100%" bgcolor="#282828" colspan="5">
        		<font color="#fff" face="Arial, Helvetica, sans-serif" size="-1">
                Hi <b><?php echo $order->ship_firstname;?> <?php echo $order->ship_lastname;?></b>!<br/><br/>

        			Thank you for using NXLED, the NeXt Generation LED Lighting. You have selected bank transfer as your mode of payment.<br/><br/>
        			Please see step-by-step instructions on how to pay your order through bank deposit below:<br/><br/><br/>
        			<b>Destination Bank:</b>  Bank of the Philippine Islands<br/><br/>
					<b>Destination Bank Branch:</b>   Julia Vargas Ave.<br/><br/>
					<b>Destination Bank Account No.:</b>  2431-0094-82<br/><br/>
					<b>Destination Account Name:</b>   88DB PHILIPPINES INC.<br/><br/><br/>
					Your order details are as follows:<br/><br/>
					<table border="1" bordercolor="#8ec343">
						<tr>
							<td bgcolor="#333">SKU</td>
							<td bgcolor="#333">NAME</td>
							<td bgcolor="#333">PRICE</td>
							<td bgcolor="#333">QUANTITY</td>
							<td bgcolor="#333">TOTAL</td>
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
                    <?php 
                    $delivery_charge = (config_item('allow_delivery_charge')) ? config_item('delivery_amount') : 0;
                    if (config_item('allow_delivery_charge')) : ?>
						<tr>
	                        <td colspan="4"><b><?php echo lang('delivery_charge')?></b></td>
	                        <td><?php echo format_currency($delivery_charge) ?></td>					
							
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
					A few reminders to keep in mind:<br/>
					<ol>
						<li>Please deposit exact amount due as stated above.<br/></li>
						<li>Non-payment within 2 days from order date will cancel your order.</li>
						<li>To validate your payment, please send a scanned (or photographed) copy of your deposit slip to <a href="mailto:finance@88db.com.ph" style="color: #7f7f7f;">finance@88db.com.ph</a>.</li>
						<li>You will be notified via email once your payment has been validated.</li>
						<li><b>Earliest delivery date is 3 days after you've completed your payment.</b> If you have set your delivery date earlier, it will be automatically rescheduled to arrive 3 days after your payment.</li>
					</ol>
					<br/><br/>
					Happy Shopping!<br/><br/>
                	<?php echo config_item('company_name'); ?><br/><br/>
        		</font>
        	</td>
        </tr>
        <tr>
        	<td bgcolor="#333" colspan="5"><font face="Arial, Helvetica, sans-serif" color="#ffffff" size="-2"><center>For further assistance, you can contact us through our email cs@88db.com.ph or our hotline (+632) 955-1000.</center></font></td>
        </tr>
        <!-- <tr colspan="5">
        	<td  align="center" colspan="5" bgcolor="#ffffff"><br/><br/><br/>
        	</td>
        </tr>
        <tr height="13">
          	<td colspan="5" bgcolor="#DD127B" >                	
            </td>           
        </tr> 
        <tr height="15">
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
        </tr> -->  
    </table>
