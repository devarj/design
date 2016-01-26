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
	return confirm('<?php echo lang('confirm_delete_tip');?>');
}
//]]>
</script>



<a style="float:right;" class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/tips/form'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_tip');?></a>

<!--<strong style="float:left;"><?php // echo lang('sort_tips')?></strong>-->

<table class="table table-striped">
	<thead>
		<tr>
			<!--<th><?php // echo lang('sort');?></th>-->
			<th><?php echo lang('title');?></th>
			<th><?php echo lang('image');?></th>
			<th></th>
		</tr>
	</thead>
	<?php echo (count($tips) < 1)?'<tr><td style="text-align:center;" colspan="5">'.lang('no_tips').'</td></tr>':''?>

	<?php if($tips):?>
	<tbody id="tips_sortable">
	<?php
	foreach ($tips as $tip):
		?>
		<tr id="boxes-<?php echo $tip->id;?>">
			<!--<td class="handle"><a class="btn" style="cursor:move"><span class="icon-align-justify"></span></a></td>-->
			<td><?php echo $tip->tip;?></td>
            <td>
                <?php if($tip->image != ''):?>
                <img src="<?php echo base_url('uploads/tips_upload/'.$tip->image);?>" alt="<?php echo $tip->tip;?>"/>
                <?php endif;?>
            </td>
			<td>
				<div class="btn-group" style="float:right">
					<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/tips/form/'.$tip->id); ?>"><i class="icon-pencil"></i> <?php echo lang('edit');?></a>
					<a class="btn btn-danger" href="<?php echo site_url($this->config->item('admin_folder').'/tips/delete/'.$tip->id); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<?php endif;?>
</table>
<?php include('footer.php'); ?>