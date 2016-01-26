<?php include('header.php'); ?>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="page-header">
			<h1><?php echo lang('login');?></h1>
		</div>
			<?php echo form_open('secure/login', 'class="form-horizontal"'); ?>
				<fieldset>
				
				<div class="row" style="margin-left:-15px">
					<div class="col-md-12">
					<div class="control-group" style="margin: 0 auto">
						<label class="control-label" for="email"><?php echo lang('email');?></label>
						<div class="controls">
							<input type="text" name="email" class="col-md-6"/>
						</div>
					</div>
					</div>
				</div>

				<div class="row" style="margin-left:-15px">
					<div class="col-md-12">
					<div class="control-group" style="margin: 0 auto">
						<label class="control-label" for="password"><?php echo lang('password');?></label>
						<div class="controls">
							<input type="password" name="password" class="col-md-6"/>
						</div>
					</div>
					</div>
				</div>
				
				<div class="row" style="margin-left:-15px">
					<div class="col-md-12" style="padding-bottom:1rem;">
					<div class="control-group">
						<div class="controls">
							<label class="checkbox">
								<input name="remember" value="true" type="checkbox" />
								 <?php echo lang('keep_me_logged_in');?>
							</label>
						</div>
					</div>
					</div>
				</div>
				<div class="row" style="margin-left:-15px">
					<div class="col-md-12">
						<a href="<?php echo site_url('secure/forgot_password'); ?>"><?php echo lang('forgot_password')?></a> | <a href="<?php echo site_url('secure/register'); ?>"><?php echo lang('register');?></a>
					<label class="control-label" for="password"></label>
						<div class="controls">
							<input type="submit" value="<?php echo lang('form_login');?>" name="submit" class="btn btn-sm btn-primary" style="margin-top:1rem"/>
						</div>
					</div>
				</div>
				</fieldset>
				

				<input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
				<input type="hidden" value="submitted" name="submitted"/>
				
			</form>
		
			
	</div>
</div>
<?php include('footer.php'); ?>