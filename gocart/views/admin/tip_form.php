<?php include('header.php'); ?>

<?php

$title			= array('name'=>'tip', 'id'=>'tip', 'value' => set_value('tip', $tip));
$f_image		= array('name'=>'image', 'id'=>'image');
?>

<?php echo form_open_multipart($this->config->item('admin_folder').'/tips/form/'.$id); ?>
	<label for="title"><?php echo lang('title');?> </label>
	<?php echo form_input($title); ?>

	<label for="image"><?php echo lang('image');?> </label>
	<?php echo form_upload($f_image); ?>

	<?php if($id && $image != ''):?>
	<div style="text-align:center; padding:5px; border:1px solid #ccc;"><img src="<?php echo base_url('uploads/tips_upload/'.$image);?>" alt="current"/><br/><?php echo lang('current_file');?></div>
	<?php endif;?>
			
	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="<?php echo lang('save');?>"/>
	</div>
</form>
<!--<script type="text/javascript">
	$(document).ready(function() {
		$("#enable_on").datepicker({ dateFormat: 'mm-dd-yy'});
		$("#disable_on").datepicker({ dateFormat: 'mm-dd-yy'});
	});
	
	$('form').submit(function() {
		$('.btn').attr('disabled', true).addClass('disabled');
	});
</script>-->
<?php include('footer.php'); ?>