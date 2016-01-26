<?php include('header.php'); ?>
	<form action="<?php echo base_url('admin/designs/add'); ?>" method="POST" enctype="multipart/form-data">
		<label> Name</label>
		<input type="text" name="name" class="form-control" />
		<label> Price</label>
		<input type="text" name="price" class="form-control" />
		<label>Design</label>
		<input type="file" name="design" class="form-control" />
		<div class="form-actions">
			<input class="btn btn-primary" type="submit" value="<?php echo lang('save');?>"/>
		</div>
	
	</form>
<?php include('footer.php');