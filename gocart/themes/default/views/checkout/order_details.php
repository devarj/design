<div class="row">
	<?php if(!empty($customer['bill_address'])):?>
	<div class="col-md-12">
			<div class="col-md-6 nopad">
				<?php echo format_address($customer['bill_address'], true);?>
			</div>

			<div class="col-md-6 nopad">
				<?php echo $customer['bill_address']['phone'];?><br/>
				<?php echo $customer['bill_address']['email'];?><br/>
				<?php echo $customer['bill_address']['deliverydate'].' '.$customer['bill_address']['deliverytime'];?><br/><br/>
				<?php echo (empty($customer['bill_address']['notes']))?'':$customer['bill_address']['notes'];?>
			</div>
	</div>
	<?php endif;?>

<?php if(config_item('require_shipping')):?>
	<?php if($this->go_cart->requires_shipping()):?>
		<div class="col-md-12">

			
				<div class="col-md-6">				
				<?php echo format_address($customer['ship_address'], true);?>
				</div>
			

		
				<div class="col-md-6">
					<?php echo $customer['ship_address']['phone'];?><br/>
					<?php echo $customer['ship_address']['email'];?><br/>
					<?php echo $customer['ship_address']['deliverydate'].' '.$customer['ship_address']['deliverytime'];?><br/><br/>
					<?php echo (empty($customer['ship_address']['notes']))?'':$customer['ship_address']['notes'];?>
				</div>
			


		</div>

		<?php
		
		if(!empty($shipping_method) && !empty($shipping_method['method'])):?>
		<div class="row">
			<div class="col-md-12">
				<p><a href="<?php echo site_url('checkout/step_2');?>" class="btn btn-poppy btn-sm"><?php echo lang('shipping_method_button');?></a></p>
				<strong><?php echo lang('shipping_method');?></strong><br/>
				<?php echo $shipping_method['method'].': '.format_currency($shipping_method['price']);?>
			</div>
		</div>
		<?php endif;?>
	<?php endif;?>
<?php endif;?>
<br>
<?php if(!empty($payment_method)):?>
			<div class="col-md-6" style="padding-top: 1em">
				<p></p>
				<?php echo $payment_method['description'];?>
			</div>
			<div class="col-md-6" style="padding-top: 1em; text-align:right">
				<a href="<?php echo site_url('checkout/step_3');?>" class="btn btn-danger btn-sm"><?php echo lang('payment_method_button');?></a>
			</div>
		
<?php endif;?>
</div>