<?php include('header.php');
?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_product');?>');
}

$(function(){
	$('#filter').change(function(){
		var x = this.value;
		window.location.href = '<?php echo base_url('admin/sproducts/index') ;?>/'+x;
	});
	
	$('.changeState').change(function(){
		var id = $(this).attr('data-id');
		var x = $(this).val();
		
		if(confirm('Are you sure to change the status?')){
			window.location.href = "<?php echo base_url('admin/spos/changestate'); ?>/"+id+"/"+x;
		}
	});
});
</script>
<style type="text/css">
	.pagination {
		margin:0px;
		margin-top:-3px;
	}
</style>
<div class="btn-group pull-right">
</div>
<?php
	//debug($orders, 1);
?>
	<table class="table table-striped" id="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Supplier</th>
				<th>Name</th>
				<th>Item Type</th>
				<th>Price</th>
				<th>Unit</th>
				<th>Quantity Order</th>
				<th>Status</th>
				<th>Supply Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($orders as $ord){
					$supwhere['id'] = $ord->spid; 
					$product = $this->Common_model->get_where('products_supplier', $supwhere, 0);
					$spwhere['id'] = $product->sid; 
					$supplier = $this->Common_model->get_where('admin', $spwhere, 0);
					$itwhere['id'] = $product->type;
					$item = $this->Common_model->get_where('raw', $itwhere, 0);
			?>	
				<tr>
					<td><?php echo $ord->id; ?></td>
					<td><?php echo $supplier->company; ?></td>
					<td><?php echo $product->name; ?></td>
					<td><?php echo $item->name; ?></td>
					<td><?php echo $product->price; ?></td>
					<td><?php echo $product->unit; ?></td>
					<td><strong><?php echo $ord->qty; ?></strong></td>
					<td><?php echo $ord->status; ?></td>
					<td><?php echo ($ord->sstatus == null) ? 'Pending' : $ord->sstatus; ?></td>
					<td>
						<select class="changeState" data-id="<?php echo $ord->id; ?>" <?php echo ($ord->status == 'Completed') ? 'disabled' : ''; ?>>
							<option value="">- Status -</option>
							<option value="Confirmed">Confirmed</option>
							<option value="Shipping">Shipping</option>
							<option value="Delayed">Delayed</option>
						</select>
					</td>
				</tr>
			<?php
				}
			?>	
		</tbody>
	</table>
</form>
<?php include('footer.php'); ?>