<?php include('header.php'); ?>

<?php echo form_open($this->config->item('admin_folder').'/tips/form/'.$id); ?>


<div class="tabbable">
	
	<ul class="nav nav-tabs">
		<li class="active"><a href="#content_tab" data-toggle="tab"><?php echo lang('content');?></a></li>
	</ul>
	
	<div class="tab-content">
		<div class="tab-pane active" id="content_tab">
			<fieldset>
				<label for="tip">Tip</label>
				<?php
				$data	= array('rows'=>'3', 'name'=>'tip', 'value'=>set_value('tip', html_entity_decode($tip)), 'class'=>'span12');
				echo form_textarea($data);
				?>
			</fieldset>
		</div>
	</div>
</div>

<div class="form-actions">
	<button type="sfabumit" class="btn btn-primary"><?php echo lang('form_save');?></button>
</div>	
</form>
<?php include('footer.php'); ?>