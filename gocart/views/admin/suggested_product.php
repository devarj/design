<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_file');?>');
}
</script>



<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo 'Product Name';?></th>
				<th><?php echo 'Description';?></th>
				<th><?php echo 'Creator Details';?></th>
			</tr>
		</thead>
		<tbody>
		<?php echo (count($file_list) < 1)?'<tr><td style="text-align:center;" colspan="3">'.lang('no_files').'</td></tr>':''?>
		<?php 
                $i = 1;
                foreach ($file_list as $file): ?>
			<tr>
                            <td><strong><?= $i ?></strong>. &nbsp;<?php echo $file->product_name; ?></td>
				<td><?php echo $file->product_desc; ?></td>
				<td style="width:20%">
                                    
						 <!-- <ul>
							<li><strong>Name: </strong><?php echo $file->name; ?></li>
							<li><strong>Email: </strong><?php echo $file->name; ?></li>
							<li><strong>Date Created: </strong><?php echo date('M-d-Y H:i',  strtotime($file->date)); ?> </li>
						</ul>  -->
 
                                    <table style="border-style:none;">
                                        <tr>
                                            <td><strong>Name :</strong></td>
                                            <td>   <?php echo $file->name; ?> </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email :</strong></td>
                                            <td>   <?php echo $file->name; ?> </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date Created : </strong></td>
                                            <td>   <?php echo date('M-d-Y H:i',  strtotime($file->date)); ?> </td>
                                        </tr>
                                    </table>
                                </td>
                                
                                
<!--				<td>
					<div class="btn-group" style="float:right">
						<a class="btn" href="<?php echo  site_url($this->config->item('admin_folder').'/digital_products/form/'.$file->id);?>"><i class="icon-pencil"></i> <?php echo lang('edit');?></a>
						
						<a class="btn btn-danger" href="<?php echo  site_url($this->config->item('admin_folder').'/digital_products/delete/'.$file->id);?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
					</div>
				</td>-->
			</tr>
		<?php  $i ++;endforeach; ?>
		</tbody>
</table>

<?php include('footer.php'); ?>