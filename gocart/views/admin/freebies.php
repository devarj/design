<?php include('header.php'); ?>

<script type="text/javascript">
function areyousure()
{
	return confirm('Are you sure you want to delete this freebie?');
}
</script>
<div class="btn-group pull-right">
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/freebies/form'); ?>"><i class="icon-plus-sign"></i> Add New Freebie</a>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Amount</th>
                        <th>Freebie</th>
			<th></th>
		</tr>
	</thead>
	
	<?php echo (count($pages) < 1)?'<tr><td style="text-align:center;" colspan="2">There are currently no freebies.</td></tr>':''?>
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
					<?php echo $dash.' &#8369; '.$page->amount; ?>
				</td>
                                <td>
					<?php echo $dash.' '.$page->freebie; ?>
				</td>
				<td>
					<div class="btn-group pull-right">
                        <a class="btn" href="<?php echo site_url($GLOBALS['admin_folder'].'/freebies/form/'.$page->id); ?>"><i class="icon-pencil"></i> <?php echo lang('edit');?></a>
						<a class="btn btn-danger" href="<?php echo site_url($GLOBALS['admin_folder'].'/freebies/delete/'.$page->id); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
                        <a class="btn btn-danger status" name="<?php echo $page->id; ?>"><?php echo $page->status == 1 ? 'Activated' : 'Deactivated';?></a>
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
<script type="text/javascript">

    $(document).ready(function(){
       $('.status').click(function(){
           var valueID = $(this).text();
           
           if(valueID === 'Activated'){
               valueID = "0";
           }else{
               valueID = "1";
           }

           var values = "status="+valueID+"&id="+$(this).attr("name");

           $(this).text(valueID=='0' ? "Deactivated" : "Activated");

           $.ajax({
               type: "POST",
               url: "<?php echo base_url().$this->config->item('admin_folder'); ?>/freebies/statusUpdate",
               data: values,
               cache: false,
               error: function(ts){
                 alert(ts.responseText);  
               },
                success: function(html){  
               }
           });

           return false;

       }) ;

    });



</script>
<?php include('footer.php');