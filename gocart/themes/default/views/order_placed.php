<?php include('header.php'); ?>

<div class="page-header">
	<h3>Thank you for your order with <?php echo $this->config->item('company_name'); ?>!</h3>
</div>

<div class="page-header" style="margin-top: 20px;">
	<h2><?php echo lang('order_number');?>: <?php echo $order_id;?></h2>
</div>

<?php
// content defined in canned messages
echo $download_section;
?>

<div class="row">
	<div class="col-md-4">
		<h3><?php echo lang('account_information');?></h3>
		<?php echo (!empty($customer['company']))?$customer['company'].'<br/>':'';?>
		<?php echo $customer['firstname'];?> <?php echo $customer['lastname'];?><br/>
		<?php echo $customer['email'];?> <br/>
		<?php echo $customer['phone'];?>
	</div>
	<?php
	$ship = $customer['ship_address'];
	$bill = $customer['bill_address'];
	?>
	<?php if($ship != $bill):?>
	<div class="col-md-4">
		<h3><?php echo lang('billing_information');?></h3>
		<?php echo format_address($bill, TRUE);?><br/>
		<?php echo $bill['email'];?><br/>
		<?php echo $bill['phone'];?>
	</div>
	<?php endif;?>
</div>

<div class="row">
	<div class="col-md-4">
		<h3><?php echo lang('payment_information');?></h3>
		<?php echo $payment['description']; ?>
	</div>
	
</div>

<table class="table table-bordered table-striped" style="margin-top:20px;">
	<thead>
		<tr>
			<th style="width:10%;"><?php echo lang('sku');?></th>
			<th style="width:30%;"><?php echo lang('name');?></th>
			<th style="width:10%;"><?php echo lang('price');?></th>
			<!--<th><?php echo lang('description');?></th>-->
			<th style="width:10%;"><?php echo lang('quantity');?></th>
			<th style="width:8%;"><?php echo lang('totals');?></th>
		</tr>
	</thead>
	
	<tfoot>
		<?php if($go_cart['group_discount'] > 0)  : ?> 
		<tr>
			<td colspan="4"><strong><?php echo lang('group_discount');?></strong></td>
			<td><?php echo format_currency(0-$go_cart['group_discount']); ?></td>
		</tr>
		<?php endif; ?>

		<tr>
			<td colspan="4"><strong><?php echo lang('subtotal');?></strong></td>
			<td><?php echo format_currency($go_cart['subtotal']); ?></td>
		</tr>
		
		<?php if($go_cart['coupon_discount'] > 0)  : ?> 
		<tr>
			<td colspan="4"><strong><?php echo lang('coupon_discount');?></strong></td>
			<td><?php echo format_currency(0-$go_cart['coupon_discount']); ?></td>
		</tr>

		<?php if($go_cart['order_tax'] != 0) : // Only show a discount subtotal if we still have taxes to add (to show what the tax is calculated from) ?> 
		<tr>
			<td colspan="4"><strong><?php echo lang('discounted_subtotal');?></strong></td>
			<td><?php echo format_currency($go_cart['discounted_subtotal']); ?></td>
		</tr>
		<?php endif;

		endif; ?>
		<?php // Show shipping cost if added before taxes
		if($this->config->item('tax_shipping') && $go_cart['shipping_cost']>0) : ?>
		<tr>
			<td colspan="4"><strong><?php echo lang('shipping');?></strong></td>
			<td><?php echo format_currency($go_cart['shipping_cost']); ?></td>
		</tr>
		<?php endif ?>
		
		<?php if($go_cart['order_tax'] != 0) : ?> 
		<tr>
			<td colspan="4"><strong><?php echo lang('taxes');?></strong></td>
			<td><?php echo format_currency($go_cart['order_tax']); ?></td>
		</tr>
		<?php endif;?>
		
		<?php // Show shipping cost if added after taxes
		if(!$this->config->item('tax_shipping') && $go_cart['shipping_cost']>0) : ?>
		<tr>
			<td colspan="4"><strong><?php echo lang('shipping');?></strong></td>
			<td><?php echo format_currency($go_cart['shipping_cost']); ?></td>
		</tr>
		<?php endif;?>
		
		<?php if($go_cart['gift_card_discount'] != 0) : ?> 
		<tr>
			<td colspan="4"><strong><?php echo lang('gift_card');?></strong></td>
			<td><?php echo format_currency(0-$go_cart['gift_card_discount']); ?></td>
		</tr>
		<?php endif;?>
        <?php 
        $delivery_charge = ($this->config->item('allow_delivery_charge')) ? $this->config->item('delivery_amount') : 0;
        if ($this->config->item('allow_delivery_charge')) : ?>
        <tr>
            <td colspan="4"><strong><?php echo lang('delivery_charge'); ?></strong></td>
            <td><?php echo format_currency($go_cart['delivery_charge']); ?></td>
        </tr>
        <?php endif; ?>
		<tr> 
			<td colspan="4"><strong><?php echo lang('grand_total');?></strong></td>
			<td><?php echo format_currency($go_cart['total']); ?></td>
		</tr>
	</tfoot>

	<tbody>
	<?php
	$subtotal = 0;
	foreach ($go_cart['contents'] as $cartkey=>$product):?>
		<tr>
			<td><?php echo $product['sku'];?></td>
			<td><?php echo $product['name']; ?></td>
			<td><?php echo format_currency($product['base_price']);   ?><?php echo (empty($product['unit'])) ? '' : '/' . $product['unit']; ?></td>
<!--			<td><?php
//                echo $product['excerpt'];
//				if(isset($product['options'])) {
//					foreach ($product['options'] as $name=>$value)
//					{
//						if(is_array($value))
//						{
//							echo '<div><span class="gc_option_name">'.$name.':</span><br/>';
//							foreach($value as $item)
//								echo '- '.$item.'<br/>';
//							echo '</div>';
//						} 
//						else 
//						{
//							echo '<div><span class="gc_option_name">'.$name.':</span> '.$value.'</div>';
//						}
//					}
//				}
				?></td>-->
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
            </td>
			<td><?php echo format_currency($product['price']*$product['quantity']); ?></td>
		</tr>			
	<?php endforeach; ?>
	</tbody>
</table>
<div class="row">
    <?php if ($order_freebie): ?>
        <div class="col-xs-12 col-md-8">
            <div class="alert alert-success">
                You have a freebie of <?php echo $order_freebie->freebie ?> (<?php echo format_currency($order_freebie->amount); ?>)
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="row">
	<div class="col-md-12">
		<a class="btn btn-primary btn-large btn-block" href="<?php echo site_url();?>">Go back to Home</a>
	</div>
</div>

<?php include('footer.php');