<?php include('header.php'); ?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	create_sortable();	
});
// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};
function create_sortable()
{
	$('#tips_sortable').sortable({
		scroll: true,
		helper: fixHelper,
		axis: 'y',
		handle:'.handle',
		update: function(){
			save_sortable();
		}
	});	
	$('#tips_sortable').sortable('enable');
}

function save_sortable()
{
	serial=$('#tips_sortable').sortable('serialize');
			
	$.ajax({
		url:'<?php echo site_url($this->config->item('admin_folder').'/tips/organize');?>',
		type:'POST',
		data:serial
	});
}
function areyousure()
{
	return confirm('Are you sure to this action?');
}
//]]>
</script>



<a style="float:right;" class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/items/form'); ?>"><i class="icon-plus-sign"></i>Add New Item</a>

<!--<strong style="float:left;"><?php // echo lang('sort_tips')?></strong>-->

<table class="table table-striped">
	<thead>
		<tr>
			<!--<th><?php // echo lang('sort');?></th>-->
			<th>Name</th>
			<th>Status</th>
			<th>Total Stocks</th>
			<th>Current Stocks</th>
			<th>Dispense</th>
			<th></th>
		</tr>
	</thead>
	<?php echo (count($raws) < 1)?'<tr><td style="text-align:center;" colspan="5">No Item Found</td></tr>':''?>

	<?php if($raws):?>
	<tbody id="tips_sortable">
	<?php
	foreach ($raws as $raw):
	
		$where['itemid'] = $raw->id;
		$stocks = $this->Common_model->get_where('stocks', $where, 1);
		$i = 0;
		$ii = 0;
		foreach($stocks as $stock){
			$i += $stock->qty;
		}
		foreach($stocks as $stock){
			$ii += $stock->dispense;
		}
		
		$ci = $i - $ii;
		?>
		<tr id="boxes-<?php echo $raw->id;?>">
			<!--<td class="handle"><a class="btn" style="cursor:move"><span class="icon-align-justify"></span></a></td>-->
			<td><?php echo $raw->name;?></td>
			<td><?php echo ($raw->status == 1) ? 'Enabled' : 'Disabled';?></td>
			<td><?php echo $i; ?></td>
			<td><?php echo $ci; ?></td>
			<td><?php echo $ii; ?></td>
			<td>
				<div class="btn-group" style="float:right">
					<a onclick="return areyousure();" class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/items/reset/'.$raw->id); ?>"><i class="icon-refresh"></i> Reset</a>
					<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/items/form/'.$raw->id); ?>"><i class="icon-pencil"></i> <?php echo lang('edit');?></a>
					<a class="btn btn-danger" href="<?php echo site_url($this->config->item('admin_folder').'/items/delete/'.$raw->id); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<?php endif;?>
</table>
<?php include('footer.php'); ?>