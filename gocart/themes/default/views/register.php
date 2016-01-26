<?php
$additional_header_info = '<style type="text/css">#gc_page_title {text-align:center;}</style>';
include('header.php'); ?>
<?php
$company	= array('id'=>'bill_company', 'class'=>'col-md-12', 'name'=>'company', 'value'=> set_value('company'));
$first		= array('id'=>'bill_firstname', 'class'=>'col-md-12', 'name'=>'firstname', 'value'=> set_value('firstname'));
$last		= array('id'=>'bill_lastname', 'class'=>'col-md-12', 'name'=>'lastname', 'value'=> set_value('lastname'));
$email		= array('id'=>'bill_email', 'class'=>'col-md-12', 'name'=>'email', 'value'=>set_value('email'));
$phone		= array('id'=>'bill_phone', 'class'=>'col-md-12', 'name'=>'phone', 'value'=> set_value('phone'));
?>

<style>
	.headerMargin{margin-top:0}
</style>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="row">
		<div class="page-header">
			<h1><?php echo lang('form_register');?></h1>
		</div>
		</div>
		<?php echo form_open('secure/register'); ?>
			<input type="hidden" name="submitted" value="submitted" />
			<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />

			<fieldset>
				<div class="row">	
					<div class="col-md-6">
						<label for="account_firstname"><?php echo lang('account_firstname');?></label>
						<?php echo form_input($first);?>
					</div>
				
					<div class="col-md-6">
						<label for="account_lastname"><?php echo lang('account_lastname');?></label>
						<?php echo form_input($last);?>
					</div>
				</div>
			
				<div class="row">
					<div class="col-md-6">
						<label for="account_email"><?php echo lang('account_email');?></label>
						<?php echo form_input($email);?>
					</div>
				
					<div class="col-md-6">
						<label for="account_phone"><?php echo lang('account_phone');?></label>
						<?php echo form_input($phone);?>
					</div>
				</div>
			
				<div class="row">
					<div class="col-md-12">
						<label class="checkbox">
							<input type="checkbox" name="email_subscribe" value="1" <?php echo set_radio('email_subscribe', '1', TRUE); ?>/> <?php echo lang('account_newsletter_subscribe');?>
						</label>
					</div>
				</div>
			
				<div class="row">	
					<div class="col-md-6">
						<label for="account_password"><?php echo lang('account_password');?></label>
						<input type="password" name="password" value="" class="col-md-12"/>
					</div>

					<div class="col-md-6">
						<label for="account_confirm"><?php echo lang('account_confirm');?></label>
						<input type="password" name="confirm" value="" class="col-md-12"/>
					</div>
				</div>

				<div class="row" style="text-align:center; padding-top:2rem">
					<input type="submit" value="<?php echo lang('form_register');?>" class="btn btn-primary btn-sm" />
					<a href="<?php echo site_url('secure/login'); ?>" class="btn btn-primary btn-sm"><?php echo lang('go_to_login');?></a>
				</div>

			</fieldset>
		</form>
		
	</div>
</div>
<?php include('footer.php');