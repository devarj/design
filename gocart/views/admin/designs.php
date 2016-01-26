<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete');?>');
}
</script>

<div style="text-align:right;">
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/designs/form'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_admin');?></a>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Image</th>
			<th>Price</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($designs as $design):?>
		<tr>
			<td><?php echo $design->name; ?></td>
			<td><?php echo $design->design; ?></td>
			<td><?php echo $design->price; ?></td>
			<td>
				<div class="btn-group" style="float:right;">
					<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/form/'.$design->id);?>"><i class="icon-pencil"></i> <?php echo lang('edit');?></a>	
					<a class="btn btn-danger" href="<?php echo site_url($this->config->item('admin_folder').'/designs/delete/'.$design->id); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
				</div>
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php include('footer.php'); ?>
