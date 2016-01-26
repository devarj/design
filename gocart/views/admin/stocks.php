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

<table class="table table-striped">
	<thead>
		<tr>
			<th>Supplier</th>
			<th>Item Type</th>
			<th>Available Stocks</th>
			<th>Dispense</th>
			<th>Total Stocks</th>
			<th></th>
		</tr>
	</thead>
	<?php echo (count($stocks) < 1)?'<tr><td style="text-align:center;" colspan="5">No Stock Found</td></tr>':''?>

	<?php if($stocks):?>
	<tbody id="tips_sortable">
	<?php
	foreach ($stocks as $stock):
		$where_s['id'] = $stock->sid;
		$where_it['id'] = $stock->itype;
		$where_st['poid'] = $stock->id;
		
		$s = $this->Common_model->get_where('admin', $where_s, 0);
		$item = $this->Common_model->get_where('raw', $where_it, 0);
		$value = $this->Common_model->get_where('stocks', $where_st, 0);
		
		?>
		<tr id="boxes">
			<td><?php echo $s->company; ?></td>
			<td><?php echo $item->name; ?></td>
			<td><?php echo $value->qty - $value->dispense; ?></td>
			<td><?php echo $value->dispense; ?></td>
			<td>
			<form action="<?php echo base_url('admin/stocks/update'); ?>" method="POST">
			<input type="text" class="form-control" name="newstock" value="<?php echo $value->qty; ?>" />
			<input type="hidden" name="stock_id" value="<?php echo $value->id; ?>" />
			<input type="hidden" name="id" value="<?php echo $stock->id; ?>" />
			</td>
			<td>
				<div class="btn-group" style="float:right">
					<button class="btn btn-default">Update Stock</button>
					</form>
				</div>
				
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<?php endif;?>
</table>
<?php include('footer.php'); ?>