<?php include('header.php'); ?>

<script type="text/javascript">
function areyousure()
{
	return confirm('Are you sure you want to delete this tip?');
}
</script>
<div class="btn-group pull-right">
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/tips/form'); ?>"><i class="icon-plus-sign"></i> Add New Tip</a>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo lang('title');?></th>
			<th></th>
		</tr>
	</thead>
	
	<?php echo (count($pages) < 1)?'<tr><td style="text-align:center;" colspan="2">There are currently no tips.</td></tr>':''?>
	<?php if($pages):?>
	<tbody>
		
		<?php
		$GLOBALS['admin_folder'] = $this->config->item('admin_folder');
		function page_loop($pages, $dash = '')
		{
			foreach($pages as $page)
			{?>
			<tr class="gc_row">
				<td>
					<?php echo $dash.' '.$page->tip; ?>
				</td>
				<td>
					<div class="btn-group pull-right">
                                                <a class="btn" href="<?php echo site_url($GLOBALS['admin_folder'].'/tips/form/'.$page->id); ?>"><i class="icon-pencil"></i> <?php echo lang('edit');?></a>
						<a class="btn btn-danger" href="<?php echo site_url($GLOBALS['admin_folder'].'/tips/delete/'.$page->id); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
					</div>
				</td>
			</tr>
			<?php
			page_loop($page->children, $dash.'-');
			}
		}
		page_loop($pages);
		?>
	</tbody>
	<?php endif;?>
</table>
<?php include('footer.php');