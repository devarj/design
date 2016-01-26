<?php include('header.php'); ?>

<?php echo form_open($this->config->item('admin_folder').'/freebies/form/'.$id); ?>


<div class="tabbable">
	
	<ul class="nav nav-tabs">
		<li class="active"><a href="#content_tab" data-toggle="tab"><?php echo lang('content');?></a></li>
	</ul>
	
	<div class="tab-content">
		<div class="tab-pane active" id="content_tab">
			<fieldset>
				<label for="amount">Amount</label>
				<?php
				$data	= array('name'=>'amount', 'value'=>set_value('amount', $amount), 'class'=>'span12');
				echo form_input($data);
				?>
                                <label for="freebies">Freebie</label>
				<?php
				$data	= array('name'=>'freebie', 'value'=>set_value('freebie', $freebie), 'class'=>'span12');
				echo form_input($data);
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