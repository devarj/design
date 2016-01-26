<?php include('header.php');
$GLOBALS['option_value_count']		= 0;
?>
<style type="text/css">
	.sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
	.sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; height: 18px; }
	.sortable li>span { position: absolute; margin-left: -1.3em; margin-top:.4em; }
</style>

<script type="text/javascript"> 
//<![CDATA[

</script>

<?php echo form_open($this->config->item('admin_folder').'/sproducts/form/'.$id ); ?>
<div class="row">
	<div class="span6">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#product_info" data-toggle="tab"><?php echo lang('details');?></a></li>
			</ul>
		</div>
		<div class="tab-content">
			<div class="tab-pane active" id="product_info">
				<div class="row">
					<div class="span6">
						<label>Product Name</label>
						<input type="text" name="name"  value="<?php echo set_value('name', $name); ?>"/>
					</div>
					<div class="span6">
						<label>Product Price</label>
						<input type="text" name="price" value="<?php echo set_value('price', $price); ?>" />
					</div>
					<div class="span6">
						<label>Item Type</label>
						<select name="type">
							<option value="">-Select Item Type-</option>
							<?php
								foreach($raws as $raw){
							?>
								<option value="<?php echo $raw->id; ?>"><?php echo $raw->name; ?></option>
							<?php
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="span6">
						<fieldset>
							<legend><?php echo lang('inventory');?></legend>
							<div class="row" style="padding-top:10px;">
								<div class="span2">
									<label for="quantity"><?php echo lang('quantity');?> </label>
									<input type="text" name="qty" value="<?php echo set_value('qty', $qty); ?>"/>
								</div>
							</div>
							<div class="row" style="padding-top:10px;">
								<div class="span2">
									<label for="quantity"><?php echo lang('unit');?> </label>
									<select name="unit">
										<option value="">-Select Unit-</option>
										<option value="pcs">Pieces</option>
										<option value="bundle">Bundle</option>
										<option value="packs">Packs</option>
									</select>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>

<div class="form-actions">
	<button type="submit" class="btn btn-primary"><?php echo lang('form_save');?></button>
</div>
</form>
<?php
//this makes it easy to use the same code for initial generation of the form as well as javascript additions
function replace_newline($string) {
  return trim((string)str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $string));
}
?>
<script type="text/javascript">
//<![CDATA[
var option_count		= <?php echo $counter?>;
var option_value_count	= <?php echo $GLOBALS['option_value_count'];?>

function add_related_product()
{
	//if the related product is not already a related product, add it
	if($('#related_product_'+$('#product_list').val()).length == 0 && $('#product_list').val() != null)
	{
		<?php $new_item	 = str_replace(array("\n", "\t", "\r"),'',related_items("'+$('#product_list').val()+'", "'+$('#product_item_'+$('#product_list').val()).html()+'"));?>
		var related_product = '<?php echo $new_item;?>';
		$('#product_items_container').append(related_product);
		run_product_query();
	}
	else
	{
		if($('#product_list').val() == null)
		{
			alert('<?php echo lang('alert_select_product');?>');
		}
		else
		{
			alert('<?php echo lang('alert_product_related');?>');
		}
	}
}

function add_category()
{
	//if the related product is not already a related product, add it
	if($('#categories_'+$('#category_list').val()).length == 0 && $('#category_list').val() != null)
	{
		<?php $new_item	 = str_replace(array("\n", "\t", "\r"),'',category("'+$('#category_list').val()+'", "'+$('#category_item_'+$('#category_list').val()).html()+'"));?>
		var category = '<?php echo $new_item;?>';
		$('#categories_container').append(category);
		run_category_query();
	}
}


function remove_related_product(id)
{
	if(confirm('<?php echo lang('confirm_remove_related');?>'))
	{
		$('#related_product_'+id).remove();
		run_product_query();
	}
}

function remove_category(id)
{
	if(confirm('<?php echo lang('confirm_remove_category');?>'))
	{
		$('#category_'+id).remove();
		run_product_query();
	}
}

function photos_sortable()
{
	$('#gc_photos').sortable({	
		handle : '.gc_thumbnail',
		items: '.gc_photo',
		axis: 'y',
		scroll: true
	});
}
//]]>
</script>
<?php
function related_items($id, $name) {
	return '
			<tr id="related_product_'.$id.'">
				<td>
					<input type="hidden" name="related_products[]" value="'.$id.'"/>
					'.$name.'</td>
				<td>
					<a class="btn btn-danger pull-right btn-mini" href="#" onclick="remove_related_product('.$id.'); return false;"><i class="icon-trash icon-white"></i> '.lang('remove').'</a>
				</td>
			</tr>
		';
}

function category($id, $name) {
	return '
			<tr id="category_'.$id.'">
				<td>
					<input type="hidden" name="categories[]" value="'.$id.'"/>
					'.$name.'</td>
				<td>
					<a class="btn btn-danger pull-right btn-mini" href="#" onclick="remove_category('.$id.'); return false;"><i class="icon-trash icon-white"></i> '.lang('remove').'</a>
				</td>
			</tr>
		';
}

include('footer.php'); ?>