<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
			<div class="page-header">
				<h2><?php echo lang('form_checkout');?></h2>
			</div>
		</div>

<?php if (validation_errors()):?>
	<div class="alert alert-error">
		<a class="close" data-dismiss="alert">×</a>
		<?php echo validation_errors();?>
	</div>
<?php endif;?>

<?php include('order_details.php');?>
</div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
    	<div class="row">
			<h2><?php echo lang('payment_method');?></h2>
		</div>
			<div class="tabbable tabs-left">
				<ul class="nav nav-tabs">
				<?php
				if ($this->config->item('allow_credit_card')) :
                    $payment_methods['pesopay']['name'] = 'Credit Card';
                    $payment_methods['pesopay']['form'] = '<div class="row">
                                                                <div class="col-md-12" style="text-align:center; padding:2rem 0">
                                                                    <img  src="' . theme_img('visa_mastercard_logo.png') . '" border="0" style="width: 200px; margin: .25em">
                                                                </div>
                                                                <div class="col-md-12">
                                                                    You will be directed to Pesopay website to verify your payment.
                                                                </div>
                                                            </div>';
                endif;
				if ($this->config->item('allow_bank_deposit')) :
                    $payment_methods['bankdeposit']['name'] = 'Bank Deposit';
                    $payment_methods['bankdeposit']['form'] = '<div class="row">
                                                                <div class="col-md-12" style="text-align:center;padding:2rem 0">
                                                                    <img  src="' . theme_img('bdo.jpg') . '" border="0" style="width: 100px;"> &nbsp;
                                                                    <img  src="' . theme_img('bpi.jpg') . '" border="0" style="width: 100px;"> &nbsp;
                                                                    <img  src="' . theme_img('logo-ubp.png') . '" border="0" style="width: 200px;margin: .25em"> &nbsp;
                                                                </div>
                                                                <div class="col-md-12">
                                                                Please see bank deposit information below:
                                                                    <table width="90%">
                                                                        <tr>
                                                                            <th colspan="3"><center> <h3>OVER-THE-COUNTER BANKS </h3></center></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <b>Banco de Oro (BDO) </b><br><br>
                                                                                <b>Account Name</b><br>
                                                                                88DB PHILIPPINES INC.<br>
                                                                                <b>Account No.</b><br>
                                                                                13-4011031-6<br>
                                                                                <b>Bank Branch</b><br>
                                                                                Emerald Ave. Ortigas<br>
                                                                                <b>Swift code</b><br>
                                                                                BNORPHMM
                                                                            </td>
                                                                            <td>
                                                                                <b>Bank of the Philippine Islands (BPI)</b><br><br>
                                                                                <b>Account Name</b><br>
                                                                                88DB PHILIPPINES INC.<br>
                                                                                <b>Account No.</b><br>
                                                                                2431-0094-82<br>
                                                                                <b>Bank Branch</b><br>
                                                                                Julia Vargas Ave<br>
                                                                                <b>Swift code</b><br>
                                                                                BOPIPHMM
                                                                            </td>
                                                                            <td>
                                                                                <b>UNIONBANK OF THE PHILS</b><br><br>
                                                                                <b>Account Name</b><br>
                                                                                88DB PHILIPPINES INC.<br>
                                                                                <b>Account No.</b><br>
                                                                                00-059-002937-0<br>
                                                                                <b>Bank Branch</b><br>
                                                                                UBP PLAZA-MERALCO AVE.<br>
                                                                                <b>Swift code</b><br>
                                                                                UBPHPHMM
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                <br>
                                                                    You will be receive bank deposit instruction email to validate your payment.
                                                                </div>
                                                            </div>';
                endif;
				if ($this->config->item('allow_otc_nonbank')) :
                    $payment_methods['otc_nonbank']['name'] = 'Over-the-Counter Non-Bank';
                    $payment_methods['otc_nonbank']['form'] = '<div class="row">
                                                                <div class="col-md-12" style="text-align:center;padding:2rem 0">
                                                                    <img  src="' . theme_img('westernunion.png') . '" border="0" style="width: 100px;"> &nbsp;
                                                                    <img  src="' . theme_img('lbc.png') . '" border="0" style="width: 100px;margin: .25em"> &nbsp;
                                                                    <img  src="' . theme_img('mlrp.png') . '" border="0" style="width: 100px;margin: .25em"> &nbsp;
                                                                </div>
                                                                <div class="col-md-12">
                                                                Please see information below:
                                                                    <table width="70%">
                                                                        <tr>
                                                                            <th colspan="2"><center> <h3>OVER-THE-COUNTER NON-BANKS</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2"><center>(Western Union, LBC, MLhullier Padala)</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Beneficiary:</th>
                                                                            <td>88DB Philippines, Inc.</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Destination Bank:</th>
                                                                            <td>Bank of the Philippine Islands</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Destination Bank Branch:</th>
                                                                            <td>Julia Vargas Ave.</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Destination Bank Account No.:</th>
                                                                            <td>2431-0094-82</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Destination Account Name:</th>
                                                                            <td>88DB PHILIPPINES INC.</td>
                                                                        </tr>
                                                                    </table>
                                                                <br>
                                                                    You will be receive instruction email to validate your payment.
                                                                </div>
                                                            </div>';
                endif;
                if ($this->config->item('allow_ubiz')) :
                    $payment_methods['ubiz']['name'] = 'UBIZ';
                    $payment_methods['ubiz']['form'] = '<div class="row">
                                                            <div class="col-md-12" style="text-align:center; padding:2rem 0">
                                                                <img  src="' . theme_img('logo-ubp.png') . '" border="0" style="width: 200px;margin: .25em">
                                                            </div>
                                                            <div class="col-md-12">
                                                                You will be directed to UBIZ website to verify your payment.
                                                            </div>
                                                        </div>';
                endif;
                if(empty($payment_method))
				{
					$selected	= key($payment_methods);
				}
				else
				{
					$selected	= $payment_method['module'];
				}
				foreach($payment_methods as $method=>$info):?>
<li <?php echo ($selected == $method)?'class="active"':'';?>><a href="#payment-<?php echo $method;?>" data-toggle="tab"><?php echo $info['name'];?></a></li>
				<?php endforeach;?>
				</ul>
				<div class="tab-content">
<?php foreach ($payment_methods as $method=>$info):?>
            <div id="payment-<?php echo $method;?>" class="tab-pane<?php echo ($selected == $method)?' active':'';?>">
                    <?php echo form_open('checkout/step_3', 'id="form-'.$method.'"');?>
                            <input type="hidden" name="module" value="<?php echo $method;?>" />
                            <?php echo $info['form'];?>
                            <input class="btn btn-sm btn-primary pull-right" type="submit" value="<?php echo lang('confirm_your_order_details');?>" style="margin-top:2rem;"/>
                    </form>
            </div>
<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>