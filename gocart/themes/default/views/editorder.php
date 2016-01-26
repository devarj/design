<?php include('header.php'); ?>
<div class="container" style="padding: 100px 0 240px 0;">



    <div class="page-header clearfix">
        <div class="col-md-4">
        <h2>Your Order</h2>
        </div>
    <?php echo form_open('cart/update_cart', array('id' => 'update_cart_form')); ?>
    </div>

    <div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th style="width:10%;"><?php echo lang('sku'); ?></th>
						<th style="width:30%;"><?php echo lang('name'); ?></th>
						<th style="width:10%;"><?php echo lang('price'); ?></th>
						<th style="width:10%;"><?php echo lang('quantity'); ?></th>
						<th style="width:10%; text-align: right"><?php echo lang('totals'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($content->contents as $key => $cc){
							$stocks = getStock($cc['stock_id']);
					?>
						<tr>
							<td><?php echo $cc['sku']; ?></td>
							<td><?php echo $cc['name']; ?></td>
							<td><?php echo $cc['price']; ?></td>
							<td><div class="control-group">
						<div class="controls">
                            <div class="input-append">
                            <select class="txtbx-80 " name="qty[<?php echo $cartkey; ?>]" data-id="<?php echo $key; ?>" onChange="updateQty(<?php echo $key; ?>, <?php echo $content->id; ?>, this)">
							<?php
								
								for ($x = 1; $x <= $stocks; $x ++): ?>
									<option <?php echo ($cc['quantity'] == $x) ? 'selected' : ''; ?>><?php echo $x; ?></option>
							<?php endfor; ?>
							</select>
							<button class="btn btn-danger btn-xs" type="button" onclick="if (confirm('<?php echo lang('remove_item'); ?>')) {
								window.location = '<?php echo site_url('cart/remove_item/'); ?>';
									}"> <i class="glyphicon glyphicon-remove"></i></button>
                                        </div>
                                    </div>
                                </div></td>
							<td><?php echo $cc['subtotal']; ?></td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>
			</div>
		</div>
	</div>

  
    <div class="row">
        <div class="col-md-8">
            
        </div>
        <div class="col-md-4" style="text-align:right">
            <!--<input class="btn btn-poppy btn-sm" type="submit" value="<?php echo lang('form_update_cart'); ?>"/>-->
            <a href="<?php echo site_url('cart/update_order'); ?>" class="btn btn-success btn-sm"> Update </a>
            <?php if ($this->Customer_model->is_logged_in(false, false) || !$this->config->item('require_login')): ?>
                <input class="btn btn-sm btn-danger" type="submit" onclick="$('#redirect_path').val('checkout');" value="<?php echo lang('form_continue'); ?>"/>
            <?php endif; ?>
        </div>
    </div>

    </form>
<div></div></div>

<script>
	function updateQty(id, oid, sel){
			
		if(confirm('Are you sure about this?')){
			window.location.href = '<?php echo base_url('cart/update_qty'); ?>/'+id+'/'+oid+'/'+sel.value;
		}
	}
</script>
<?php include('footer.php'); ?>