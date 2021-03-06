<?php include('header.php'); ?>
<div style="background-color:white;">
    <h2 class="dash-headers">View Invoice</h2>
	<table class="dash-table table table-striped table-hover">
        <tr>
            <td colspan="4">
                <center><h2>Statement of Account</h2></center>
            </td>
        </tr>
        <tr>
            <td>Bill To: </td>
            <td>88DB PHILIPPINES INC</td>
            <td>Date:</td>
            <td><?php echo date('d/m/Y', strtotime($invoice_date)); ?></td>
        </tr>
        <tr>
            <td>Address: </td>
            <td>PH3 One Corporate Center Julia Vargas Ave</td>
            <td>No.:</td>
            <td><?= ($invoice_no == "")?$invoicenum:$invoice_no; ?></td>
        </tr>
        <tr>
            <td></td>
            <td>Cor Meralco Ave Ortigas Center Pasig City</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td></td>
            <td>Tel # 955-1000</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Contact Person:</td>
            <td> Joselyn Dela Cruz</td>
            <td colspan="2"></td>
        </tr>
    </table><br><br>
    <p>To Bill you for the following items:</p><br>
    <table class="dash-table table table-striped table-hover">
        <tr>
            <th>Invoice Order #</th>
            <th>Date Delivered</th>
            <th>Waybill #</th>
            <th>Amount</th>
        </tr>
        <?php
		//$transactfee = $grandtotal * 0.06;
		//$netamount = $grandtotal - $transactfee;
		$transactfee = $amount * 0.05;
		$netamount = $amount - $transactfee;
//        $currency = ($currency=='dollar') ? 'USD ': 'Php ';
        $currency = $this->config->item('currency_symbol');
		?>
		<tr>
			<td align="center"><?php echo $order_number; ?></td>
			<td align="center"><?php echo date('m/d/Y',strtotime($shipped_on)); ?></td>
			<td align="center"><?php echo $waybill_no; ?></td>
			<!--<td align="center"><?php // echo number_format($grandtotal,2) ?></td>-->
			<td align="center"> <?php echo $currency.number_format($amount,2) ?></td>
		</tr>
        <!--<tr><td></td><td colspan="2">Total </td><td align="right"> <?php // echo number_format($grandtotal,2) ?></td></tr>-->
        <tr>
            <td></td>
            <td colspan="2">Total </td>
            <td align="right"> <?php echo $currency.number_format($amount,2) ?></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Less Transaction Fee (5%) </td>
            <td align="right"> <?php echo $currency.number_format($transactfee,2)?></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Net Amount Due </td>
            <td align="right"> <?php echo $currency.number_format($netamount,2)?></td>
        </tr>
    </table>
    <br/><br/>
	<input class="btn btn-primary" type="button" onclick="history.go(-1);" value="Cancel">
</div>
<?php include('footer.php');?>