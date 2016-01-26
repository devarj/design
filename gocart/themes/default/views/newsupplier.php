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
			<h1>Register as New Supplier</h1>
		</div>
		</div>
		<?php echo form_open('secure/register_supplier'); ?>
			<input type="hidden" name="submitted" value="submitted" />
			<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />

			<fieldset>
				<div class="row">
					<div class="col-md-6">
						<label>Company Name</label>
						<input type="text" name="company" />
					</div>
					<div class="col-md-6">
						<label>Business Permit</label>
						<input type="text" name="permit" />
					</div>
				</div>
				<div class="row">	
					<div class="col-md-6">
						<label for="account_firstname"><?php echo lang('account_firstname');?></label>
						<input type="text" name="firstname" />
					</div>
				
					<div class="col-md-6">
						<label for="account_lastname"><?php echo lang('account_lastname');?></label>
						<input type="text" name="lastname" />
					</div>
				</div>
			
				<div class="row">
					<div class="col-md-6">
						<label for="account_email"><?php echo lang('account_email');?></label>
						<input type="email" name="email" />
					</div>
				
					<div class="col-md-6">
						<label for="account_phone"><?php echo lang('account_phone');?></label>
						<input type="text" name="phone" />
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
					<input type="hidden" name="access" value="Supplier" />
					<input type="submit" value="<?php echo lang('form_register');?>" class="btn btn-primary btn-sm" />
					<a href="<?php echo site_url('supplier-admin'); ?>" class="btn btn-primary btn-sm"><?php echo lang('go_to_login');?></a>
				</div>

			</fieldset>
		</form>
		
	</div>
</div>
<?php include('footer.php');