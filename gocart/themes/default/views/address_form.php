<?php

$f_id		= array('id'=>'f_id', 'style'=>'display:none;', 'name'=>'id', 'value'=> set_value('id',$id));
$f_company	= array('id'=>'f_company', 'class'=>'col-md-12', 'name'=>'company', 'value'=> set_value('company',$company));
$f_address1	= array('id'=>'f_address1', 'class'=>'col-md-12', 'name'=>'address1', 'value'=>set_value('address1',$address1));
$f_address2	= array('id'=>'f_address2', 'class'=>'col-md-12', 'name'=>'address2', 'value'=> set_value('address2',$address2));
$f_first	= array('id'=>'f_firstname', 'class'=>'col-md-12', 'name'=>'firstname', 'value'=> set_value('firstname',$firstname));
$f_last		= array('id'=>'f_lastname', 'class'=>'col-md-12', 'name'=>'lastname', 'value'=> set_value('lastname',$lastname));
$f_email	= array('id'=>'f_email', 'class'=>'col-md-12', 'name'=>'email', 'value'=>set_value('email',$email));
$f_phone	= array('id'=>'f_phone', 'class'=>'col-md-12', 'name'=>'phone', 'value'=> set_value('phone',$phone));
$f_city		= array('id'=>'f_city', 'class'=>'col-md-12', 'name'=>'city', 'value'=>set_value('city',$city));
$f_zip		= array('id'=>'f_zip', 'maxlength'=>'10', 'class'=>'col-md-12', 'name'=>'zip', 'value'=> set_value('zip',$zip));

echo form_input($f_id);

?>

<script type="text/javascript">
$(function(){
	$('#f_country_id').change(function(){
			$.post('<?php echo site_url('locations/get_zone_menu');?>',{id:$('#f_country_id').val()}, function(data) {
			  $('#f_zone_id').html(data);
			});
		});
});

function save_address()
{
	$.post("<?php echo site_url('secure/address_form');?>/"+$('#f_id').val(), {	company: $('#f_company').val(),
																				firstname: $('#f_firstname').val(),
																				lastname: $('#f_lastname').val(),
																				email: $('#f_email').val(),
																				phone: $('#f_phone').val(),
																				address1: $('#f_address1').val(),
																				address2: $('#f_address2').val(),
																				city: $('#f_city').val(),
																				country_id: $('#f_country_id').val(),
																				zone_id: $('#f_zone_id').val(),
																				zip: $('#f_zip').val()
																				},
		function(data){
			if(data == 1)
			{
				window.location = "<?php echo site_url('secure/my_account');?>";
			}
			else
			{
				$('#form-error').html(data).show();
			}
		});
}
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('address_form');?></h4>
      </div>
      <div class="modal-body clearfix">
       <div class="alert allert-error hide" id="form-error">
			<a class="close" data-dismiss="alert">×</a>
		</div>
		<div class="row-fluid clearfix">
			<div class="col-md-12">
				<label><?php echo lang('address_company');?></label>
				<?php echo form_input($f_company);?>
			</div>
		</div>
		<div class="row-fluid clearfix">
			<div class="col-md-6">
				<label><?php echo lang('address_firstname');?></label>
				<?php echo form_input($f_first);?>
			</div>
			<div class="col-md-6">
				<label><?php echo lang('address_lastname');?></label>
				<?php echo form_input($f_last);?>
			</div>
		</div>
		<div class="row-fluid clearfix">
			<div class="col-md-6">
				<label><?php echo lang('address_email');?></label>
				<?php echo form_input($f_email);?>
			</div>
			<div class="col-md-6">
				<label><?php echo lang('address_phone');?></label>
				<?php echo form_input($f_phone);?>
			</div>
		</div>
		<div class="row-fluid clearfix">
			<div class="col-md-12">
				<label><?php echo lang('address');?></label>
				<?php
				echo form_input($f_address1);
				echo form_input($f_address2);
				?>
			</div>
		</div>
		<div class="row-fluid clearfix">
			<div class="col-md-12">
				<label><?php echo lang('address_country');?></label>
				<?php echo form_dropdown('country_id', $countries_menu, set_value('country_id', $country_id), 'id="f_country_id" class="col-md-12"');?>
			</div>
		</div>
		<div class="row-fluid clearfix">
			<div class="col-md-4">
				<label><?php echo lang('address_city');?></label>
				<?php //echo form_input($f_city);?>
                <?php echo form_dropdown('city', $city_menu, set_value('city',$city), 'id="f_city" class="col-md-12"'); ?>
			</div>
			<div class="col-md-6">
				<label><?php echo lang('address_state');?></label>
				<?php echo form_dropdown('zone_id', $zones_menu, set_value('zone_id', $zone_id), 'id="f_zone_id" class="col-md-12"');?>
			</div>
			<div class="col-md-2">
				<label><?php echo lang('address_postcode');?></label>
				<?php echo form_input($f_zip);?>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal"><?php echo lang('close');?></a>
		<a href="#" class="btn btn-primary" type="button" onclick="save_address(); return false;"><?php echo lang('form_submit');?></a>
      </div>
    </div>
  </div>
</div>