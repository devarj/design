<?php include('header.php');?>

<?php if(validation_errors()):?>
<div class="alert allert-error">
	<a class="close" data-dismiss="alert">×</a>
	<?php echo validation_errors();?>
</div>
<?php endif;?>
<script type="text/javascript">
$(document).ready(function(){
	$('.delete_address').click(function(){
		if($('.delete_address').length > 1)
		{
			if(confirm('<?php echo lang('delete_address_confirmation');?>'))
			{
				$.post("<?php echo site_url('secure/delete_address');?>", { id: $(this).attr('rel') },
					function(data){
						$('#address_'+data).remove();
						$('#address_list .my_account_address').removeClass('address_bg');
						$('#address_list .my_account_address:even').addClass('address_bg');
					});
			}
		}
		else
		{
			alert('<?php echo lang('error_must_have_address');?>');
		}	
	});
	
	$('.edit_address').click(function(){
		$.post('<?php echo site_url('secure/address_form'); ?>/'+$(this).attr('rel'),
			function(data){
				$('#address-form-container').html(data).modal('show');
			}
		);
//		$.fn.colorbox({	href: '<?php echo site_url('secure/address_form'); ?>/'+$(this).attr('rel')});
	});
	
	if ($.browser.webkit) {
	    $('input:password').attr('autocomplete', 'off');
	}
});


function set_default(address_id, type)
{
	$.post('<?php echo site_url('secure/set_default_address') ?>/',{id:address_id, type:type});
}

function uploadFile(sel, id){
	var file_data = $('#'+sel).prop('files')[0];
	var form_data = new FormData();
	form_data.append('file', file_data);
	$.ajax({
		url: '<?php echo base_url('cart/uploadFile'); ?>/'+id,
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(file_name){
			$('#holder'+id).fadeOut(function(){
				$('#text'+id).html(file_name);
				$('#text'+id).attr('href', '<?php echo base_url('uploads'); ?>/'+file_name);
				$('#text'+id).fadeIn();
				$('#current'+id).fadeOut();
			});
		}
	 });
}




</script>


<?php
$first		= array('id'=>'firstname', 'class'=>'col-md-12', 'name'=>'firstname', 'value'=> set_value('firstname', $customer['firstname']));
$last		= array('id'=>'lastname', 'class'=>'col-md-12', 'name'=>'lastname', 'value'=> set_value('lastname', $customer['lastname']));
$email		= array('id'=>'email', 'class'=>'col-md-12', 'name'=>'email', 'value'=> set_value('email', $customer['email']));
$phone		= array('id'=>'phone', 'class'=>'col-md-12', 'name'=>'phone', 'value'=> set_value('phone', $customer['phone']));

$password	= array('id'=>'password', 'class'=>'col-md-12', 'name'=>'password', 'value'=>'');
$confirm	= array('id'=>'confirm', 'class'=>'col-md-12', 'name'=>'confirm', 'value'=>'');
?>	

<div class="row">
	<div class="col-md-12">
		<div class="my-account-box">
		<?php echo form_open('secure/my_account'); ?>
			<fieldset>
				<h2><?php echo lang('account_information');?></h2> 
				
					<div class="col-md-6">
						<label for="account_firstname"><?php echo lang('account_firstname');?></label>
						<?php echo form_input($first);?>
					</div>
				
					<div class="col-md-6">
						<label for="account_lastname"><?php echo lang('account_lastname');?></label>
						<?php echo form_input($last);?>
					</div>
				
			
		
					<div class="col-md-6">
						<label for="account_email"><?php echo lang('account_email');?></label>
						<?php echo form_input($email);?>
					</div>
				
					<div class="col-md-6">
						<label for="account_phone"><?php echo lang('account_phone');?></label>
						<?php echo form_input($phone);?>
					</div>
				
			
				
					<div class="col-md-12">
						<label class="checkbox">
							<input type="checkbox" name="email_subscribe" value="1" <?php if((bool)$customer['email_subscribe']) { ?> checked="checked" <?php } ?>/> <?php echo lang('account_newsletter_subscribe');?>
						</label>
					</div>
				
			
				
					<div class="col-md-12">
					
							<strong><?php echo lang('account_password_instructions');?></strong>
						
					</div>
				
			
			
					<div class="col-md-6">
						<label for="account_password"><?php echo lang('account_password');?></label>
						<?php echo form_password($password);?>
					</div>

					<div class="col-md-6">
						<label for="account_confirm"><?php echo lang('account_confirm');?></label>
						<?php echo form_password($confirm);?>
					</div>

					<div class="col-md-12" style="text-align:center; padding-top:1rem">
						<input type="submit" value="<?php echo lang('form_submit');?>" class="btn  btn-sm btn-warning" />
					</div>	
			

			</fieldset>
		</form>
		</div>
	</div>
</div> <!--row -->

<div class="row">
	<div class="span12">
	
		<div class="page-header">
			<h2><?php echo lang('order_history');?></h2>
		</div>
		<?php if($orders2):
			echo $orders_pagination;
		?>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th><?php echo lang('order_date');?></th>
					<th><?php echo lang('order_number');?></th>
					<th>Order Status</th>
					<th>Notes</th>
					<th>Transaction Number</th>
					<th>Document</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
			<?php
			//debug($orders2, 1);
			foreach($orders2 as $order): 
			?>
				<tr>
					<td>
						<?php $d = format_date($order->ordered_on); 
				
						$d = explode(' ', $d);
						echo $d[0].' '.$d[1].', '.$d[3];
				
						?>
					</td>
					<td><?php echo $order->order_number; ?></td>
					<td><?php echo $order->payment_status;?></td>
					<td><?php 
					if($order->payment_status == 'Pending'){
						echo ($order->tnumber == '') ? 'Please provide the transaction number. Cancelling order will be only available within a day after ordering the item/s. <b>Updating the order content is not allowed once you submitted transaction number.</b>' : 'Your order is now on validation process. If you cancel your order, please be aware that you will only receive 30% of refund.';
					}else if($order->payment_status == 'Cancelled'){
						 echo ($order->tnumber == '') ? 'You cancelled your order. ' : 'Your order is now cancelled. Please be advise that you will only receive 30% of refund. Thank you for choosing iDesign.';
					}
					else{
						
					}
					?></td>
					<td><?php
					
					if($order->payment_status != 'Cancelled'){
						if($order->tnumber == ''){
					?>
					<form action="<?php echo base_url('secure/submit_tnumber'); ?>" method="POST" onSubmit="return confirm('Are you sure to submit this transaction number?')">
						<input type="text" name="tnumber" required /> <button class="btn btn-primary">Save</button>
						<input type="hidden" name="id" value="<?php echo $order->id; ?>"/>
						</form>
					<?php
						}else{
							
							echo '<p class="text-success">'.$order->tnumber.'</p>';
						}
					}
					else{
						echo '<p class="text-warning">No Transaction Number needed.</p>';
					}
					?>
					</td>
					<td>
					<?php
						if($order->payment_status != 'Cancelled'){
					?>
							<div id="holder<?php echo $order->id; ?>">
								<input type="file" class="form-control" id="attached<?php echo $order->id;?>"/>
								<button onClick="uploadFile('attached<?php echo $order->id;?>', <?php echo $order->id;?>)">Upload</button>
							</div>
							<a id="text<?php echo $order->id; ?>"  download style="display: none;"></a>
							<?php
								if($order->attached != null){
							?>
							<a id="current<?php echo $order->id; ?>" href="<?php echo base_url('uploads/'.$order->attached); ?>" download>Current: <?php echo $order->attached; ?></a>
							<?php
							}
							?>
					<?php
						}
						else{
							echo 'Order Cancelled. No File is needed.';
						}
					?>
					</td>
					<td>
					
					<?php
					if($order->payment_status != 'Cancelled'){
						$cancel_exp = date('F d, Y h:i:sA', strtotime($order->ordered_on.' +1 day'));
						if($cancel_exp > date('F d, Y h:i:sA')){
							
					?>
					<?php
						if($order->tnumber == ''){
					?>
					<a href="<?php echo base_url('cart/open_order/'.$order->id); ?>" class="btn btn-default">Update</a>
					<?php
						}
					?>
						<a href="<?php echo base_url('cart/cancel_order/'.$order->id); ?>" onClick="return confirm('Are you sure?')" class="btn btn-danger">Cancel</a>
					<?php
						}
						else{
					?>
						Cancelling Order is not available.
					<?php
						}
					}
					else if($order->payment_status == 'Paid'){
						echo 'Cancelling Order is not available.';
					}
					
					?>
					
					</td>
				</tr>
		
			<?php endforeach;?>
			</tbody>
		</table>
		<?php else: ?>
			<?php echo lang('no_order_history');?>
		<?php endif;?>
		<br />
		<h4>Contact Us</h4>
		<table class="table table-bordered table-striped">
			<tr>
				<td>Mobile:</td>
				<td>09178147321</td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><a href="mailto: idesign@ymail.com">idesign@ymail.com</a></td>
			</tr>
		</table>
	</div>
</div>

<div id="address-form-container">
</div>
<?php include('footer.php');