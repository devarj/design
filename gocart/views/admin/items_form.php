<?php include('header.php'); ?>

<?php

$name			= array('name'=>'name', 'id'=>'name', 'value' => set_value('tip', $name));

if(!empty($id)){
$where['itemid'] = $id;
$stocks = $this->Common_model->get_where('stocks', $where, 1);
$total = 0;
$dispense = 0;

	foreach($stocks as $stock){
		$total += $stock->qty;
		$dispense += $stock->dispense;
	}
}

?>

<?php echo form_open_multipart($this->config->item('admin_folder').'/items/form/'.$id); ?>
	<label for="title">Name</label>
	<?php echo form_input($name); ?>
	<label for="image">Current Stock</label>
	<input type="text" class="form-control" name="curstock" value="<?php echo $total - $dispense; ?>"  />
	<label for="image">Status</label>
	<select name="status">
		<option value="">-Select Status-</option>
		<option value="0">Disable</option>
		<option value="1">Enable</option>
	</select>
	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value="<?php echo lang('save');?>"/>
	</div>
</form>


<?php include('footer.php'); ?>