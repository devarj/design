<?php include('header.php'); ?>

<div class="row">
	<div class="col-md-6 offset3">
		<div class="page-header">
			<h1><?php echo lang('forgot_password');?></h1>
		</div>

		

		<?php echo form_open('secure/forgot_password', 'class="form-horizontal"') ?>
				<fieldset>
									<div class="col-md-12 nopad">
										<div class="control-group">
											<label class="control-label" for="email"><?php echo lang('email');?></label><br>
											<div class="controls">
												<input type="text" name="email" class="col-md-8"/>
											</div>
										</div>
									</div>
								
									<div class="col-md-12 nopad" style="padding-top:2rem">
										<div class="control-group">
											<div class="controls col-md-4 nopad">
												<input type="hidden" value="submitted" name="submitted"/>
												<input type="submit" value="<?php echo lang('reset_password');?>" name="submit" class="btn btn-sm btn-danger"/>
											</div>
											
											<div class="col-md-4 nopad">
												<a href="<?php echo site_url('secure/login'); ?>" class="btn btn-sm btn-success"><?php echo lang('return_to_login');?></a>
											</div>

										</div>
									</div>
								
												
				</fieldset>
		</form>
		
		
	</div>
</div>

<?php include('footer.php'); ?>
