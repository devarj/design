<?php include('header.php'); ?>
<div class="row">
	<div class="span12">
		<div class="btn-group pull-right">
			<a class="btn" title="<?php echo lang('send_email_notification');?>" onclick="$('#notification_form').slideToggle();"><i class="icon-envelope"></i> <?php echo lang('send_email_notification');?></a>
			<!--<a class="btn" href="<?php echo site_url('admin/orders/packing_slip/'.$order->id);?>" target="_blank"><i class="icon-file"></i>Waybill<?php // echo lang('packing_slip');?></a>-->
		</div>
	</div>
</div>

<script type="text/javascript">
// store message content in JS to eliminate the need to do an ajax call with every selection
var messages = <?php
	$messages	= array();
	foreach($msg_templates as $msg)
	{
		$messages[$msg['id']]= array('subject'=>$msg['subject'], 'content'=>$msg['content']);
	}
	echo json_encode($messages);
	?>;
//alert(messages[3].subject);
// store customer name information, so names are indexed by email
var customer_names = <?php 
	echo json_encode(array(
		$order->email=>$order->firstname.' '.$order->lastname,
		$order->ship_email=>$order->ship_firstname.' '.$order->ship_lastname,
		$order->bill_email=>$order->bill_firstname.' '.$order->bill_lastname
	));
?>;
// use our customer names var to update the customer name in the template
function update_name()
{
	if($('#canned_messages').val().length>0)
	{
		set_canned_message($('#canned_messages').val());
	}
}

function set_canned_message(id)
{
	// update the customer name variable before setting content	
	$('#msg_subject').val(messages[id]['subject'].replace(/{customer_name}/g, customer_names[$('#recipient_name').val()]));
}	
</script>

<div id="notification_form" class="row" style="display:none;">
	<div class="span12">
		<?php echo form_open($this->config->item('admin_folder').'/orders/send_notification/'.$order->id);?>
			<fieldset>
				<label><?php echo lang('message_templates');?></label>
				<select id="canned_messages" onchange="set_canned_message(this.value)" class="span12">
					<option><?php echo lang('select_canned_message');?></option>
					<?php foreach($msg_templates as $msg)
					{
						echo '<option value="'.$msg['id'].'">'.$msg['name'].'</option>';
					}
					?>
				</select>

				<label><?php echo lang('recipient');?></label>
				<select name="recipient" onchange="update_name()" id="recipient_name" class='span12'>
					<?php 
						if(!empty($order->email))
						{
							echo '<option value="'.$order->email.'">'.lang('account_main_email').' ('.$order->email.')';
						}
						if(!empty($order->ship_email))
						{
							echo '<option value="'.$order->ship_email.'">'.lang('shipping_email').' ('.$order->ship_email.')';
						}
						if($order->bill_email != $order->ship_email)
						{
							echo '<option value="'.$order->bill_email.'">'.lang('billing_email').' ('.$order->bill_email.')';
						}
					?>
				</select>

				<label><?php echo lang('subject');?></label>
				<input type="text" name="subject" size="40" id="msg_subject" class="span12"/>

				<label><?php echo lang('message');?></label>
				<textarea id="content_editor" name="content" class="redactor"></textarea>

				<div class="form-actions">
					<input type="submit" class="btn btn-primary" value="<?php echo lang('send_message');?>" />
				</div>
			</fieldset>
		</form>
	</div>
</div>

<div class="row" style="margin-top:10px;">
	<div class="span4">
		<h3><?php echo lang('account_info');?></h3>
		<p>
		<?php echo (!empty($order->company))?$order->company.'<br>':'';?>
		<?php echo $order->firstname;?> <?php echo $order->lastname;?> <br/>
		<?php echo $order->email;?> <br/>
		<?php echo $order->phone;?>
		</p>
	</div>
	<div class="span4">
		<h3>Payment Details</h3>
		<p><strong>Transaction Number : </strong><?php echo $order->tnumber; ?>
		</p>
		<p><strong>Attached File : </strong><a href="<?php echo base_url('uploads/'.$order->attached); ?>" download><?php echo $order->attached; ?></a>
		</p>
		<p><strong>Order Status : </strong> <?php echo $order->payment_status; ?>
		</p>
		<?php
			if($order->payment_status == 'Cancelled'){
		?>
		<p><strong>Refunded Amount : </strong>
			PHP <?php
				echo ($order->down_amount * 0.30);
			?>
		<?php
			}
		?>
		</p>
	</div>
</div>

<?php echo form_open($this->config->item('admin_folder').'/orders/view/'.$order->id, 'class="form-inline"');?>
<fieldset>
	<div class="row" style="margin-top:20px;">

<!--		<div class="span4">
			<h3><?php echo lang('payment_status');?></h3>
			<?php
			echo form_dropdown('payment_status', $this->config->item('payment_statuses'), $order->payment_status, 'class="span4"');
			?>
		</div>-->
	</div>
	<hr>
<!--	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="<?php echo lang('update_order');?>"/>
	</div>-->
</fieldset>
</form>
<table class="table table-striped">
	<tr>
		<td>Downpayment Amount:</td>
		<td>
		
		<?php
		if($order->down_amount == null){
		?>
		<form action="<?php echo base_url('admin/orders/down_amount/'.$order->id); ?>" method="POST">
			<input type="text" name="down_amount" class="form-control" />
			<input type="submit" class="btn btn-info" value="Save" />
		</form>
		<?php
		}else{
		
		?>
		<p align="left"><?php echo $order->down_amount; ?></p>
		<?php
		}
		?>
		
		</td>
	</tr>
</table>

<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo lang('name');?></th>
			<th><?php echo lang('description');?></th>
			<th><?php echo lang('price');?></th>
			<th><?php echo lang('quantity');?></th>
			<th><?php echo lang('total');?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($order->contents as $orderkey=>$product):?>
		<tr>
			<td>
				<?php echo $product['name'];?>
				<?php echo (trim($product['sku']) != '')?'<br/><small>'.lang('sku').': '.$product['sku'].'</small>':'';?>
				
			</td>
			<td>
				<?php //echo $product['excerpt'];?>
				<?php
				
				// Print options
				if(isset($product['options']))
				{
					foreach($product['options'] as $name=>$value)
					{
						$name = explode('-', $name);
						$name = trim($name[0]);
						if(is_array($value))
						{
							echo '<div>'.$name.':<br/>';
							foreach($value as $item)
							{
								echo '- '.$item.'<br/>';
							}	
							echo "</div>";
						}
						else
						{
							echo '<div>'.$name.': '.$value.'</div>';
						}
					}
				}
				
				if(isset($product['gc_status'])) echo $product['gc_status'];
				?>
			</td>
			<td><?php echo format_currency($product['price']);?></td>
			<td><?php echo $product['quantity'];?></td>
			<td><?php echo format_currency($product['price']*$product['quantity']);?></td>
		</tr>
		<?php endforeach;?>
		</tbody>
		<tfoot>
		<?php if($order->coupon_discount > 0):?>
		<tr>
			<td><strong><?php echo lang('coupon_discount');?></strong></td>
			<td colspan="3"></td>
			<td><?php echo format_currency(0-$order->coupon_discount); ?></td>
		</tr>
		<?php endif;?>
                <?php if($order->reward_points > 0):?>
		<tr>
			<td><strong><?php echo 'Reward Discount';?></strong></td>
			<td colspan="3"></td>
			<td><?php echo format_currency(0-$order->reward_points); ?></td>
		</tr>
		<?php endif;?>
		
		<tr>
			<td><strong><?php echo lang('subtotal');?></strong></td>
			<td colspan="3"></td>
			<td><?php echo format_currency($order->subtotal); ?></td>
		</tr>
		
		<?php if($order->gift_card_discount > 0):?>
		<tr>
			<td><strong><?php echo lang('giftcard_discount');?></strong></td>
			<td colspan="3"></td>
			<td><?php echo format_currency(0-$order->gift_card_discount); ?></td>
		</tr>
		<?php endif;?>
		<tr>
			<td><h3><?php echo lang('total');?></h3></td>
			<td colspan="3"></td>
			<td><strong><?php echo format_currency($order->total); ?></strong></td>
		</tr>
	</tfoot>
</table>

<?php include('footer.php');