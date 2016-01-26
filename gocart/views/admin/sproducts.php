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
	
	$('#qty').keyup(function(){
		var max = $(this).attr('data-max');
		var inputval = $(this).val();
		//max = (int)max;
		//inputval = (int)inputval;
		if(max > inputval){
			//console.log('Desire number exceed available quantity!');
			//$(this).val('');
		}
	});
	
	$('#submit').click(function(){
		var qty = $('#qty').val();
		var id = $('#id').val();
		var type = $('#type').val();
		var sid = $('#sid').val();
		
		$.ajax({
			url: '<?php echo base_url('admin/pos/request'); ?>/'+id+'/'+qty+'/'+type+'/'+sid,
			success: function(data){
				if(data){
					$("#order").modal('hide');
					$('#record'+id).fadeOut();
					$('#msg').fadeIn();
					//alert(data);
					//$('#status'+id).html('Requested('+qty+')');
				}
			}
		});
	});
	
});
	function order(id, name, max, type, sid){
		$("#order").modal('show');
		$('#id').val(id);
		$('#type').val(type);
		$('#sid').val(sid);
		$('#qty').attr('data-max', max);
		$('#pname').html(name);
	}
</script>
<style type="text/css">
	.pagination {
		margin:0px;
		margin-top:-3px;
	}
</style>
<div class="alert alert-success" id="msg" style="display: none;">
		<a class="close" data-dismiss="alert">×</a>	
		Successfully ordered!
		</div>
<div class="btn-group pull-right">

</div>
	<?php
		if($adminstate){
	?>
	<label>Filter Cheapest by Item Type:</label>
	<select id="filter">
		<option value="">-Select-</option>
		<?php
			foreach($raws as $raw){
		?>
			<option value="<?php echo $raw->id; ?>"><?php echo $raw->name; ?></option>
		<?php
			}
		?>
	</select>
	<?php
		}
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
				<th>Quantity</th>
				<th>iDesign Status</th>
				<th>
				<?php
					if(!$adminstate){
				?>
					<span class="btn-group pull-right">
						<a class="btn" style="font-weight:normal;"href="<?php echo site_url($this->config->item('admin_folder').'/sproducts/form');?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_product');?></a>
					</span>
				<?php
					}
				?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php echo (count($products) < 1)?'<tr><td style="text-align:center;" colspan="9">'.lang('no_products').'</td></tr>':''?>
	<?php foreach ($products as $product):
		$where['spid'] = $product->id;
		$requested = $this->Common_model->get_where('po', $where, 1);
		
			$count = 0;
			foreach($requested as $rqt){
				$count += $rqt->qty;
			}
	?>
			<tr <?php echo ($filtered === true) ? 'class="success"' : ''; ?> id="record<?php echo $product->id; ?>">
				<td><?php echo $product->id; ?></td>
				<td><?php echo getSupplier($product->sid); ?></td>
				<td><?php echo $product->name; ?></td>
				<td><?php echo getiType($product->type); ?></td>
				<td><?php echo $product->price; ?></td>
				<td><?php echo $product->unit; ?></td>
				<td><?php echo $product->qty; ?></td>
				<td><span id="status<?php echo $product->id; ?>"><?php echo ($product->status == 0) ? 'Pending': 'Requested('.$count.')' ; ?></span></td>
				<td>
				<?php
					if(!$adminstate){
				?>
					<span class="btn-group pull-right">
						<!--<a class="btn" href="<?php echo  site_url($this->config->item('admin_folder').'/pos/form/'.$product->id);?>"><i class="icon-pencil"></i>  <?php echo lang('edit');?></a>
						<a class="btn btn-danger" href="<?php echo  site_url($this->config->item('admin_folder').'/products/delete/'.$product->id);?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>-->
					</span>
				<?php
					}else{
				?>
					<span class="btn-group pull-right">
						<a class="btn" onClick="order(<?php echo $product->id; ?>, '<?php echo ucfirst($product->name); ?>', <?php echo $product->qty; ?>, <?php echo $product->type; ?>, <?php echo getSupplierID($product->sid); ?> )"><i class="icon-file"></i>  Request</a>
					</span>
				<?php
					}
				?>
				</td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
</form>
<div class="modal hide fade" id="order">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 class="text-center">Request <span id="pname"></span></h3>
  </div>
  <div class="modal-body">
    <label>Quantity</label>
	<input type="text" name="qty" data-max="" id="qty"/>
	<input type="hidden" name="id" id="id" />
	<input type="hidden" name="type" id="type" />
	<input type="hidden" name="sid" id="sid" />
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary" id="submit">Submit</button>
  </div>
</div>
<?php include('footer.php'); ?>