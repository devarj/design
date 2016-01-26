<?php include('header.php'); ?>
<div style="background-color:white;">
    <h2 class="dash-headers">Generate Waybill</h2>
    <hr>
    <h2>Order Number:<?= $order_number; ?></h2>
    <table class="dash-table table table-striped table-hover">
        <tr><th><h3>Waybill No.</h3></th><td><h3><?= $waybill_no; ?></h3></td></tr>
        <tr><th>Shipping Address</th><td><?= $address1 ?></td></tr>
<!--        <tr><th>City</th><td><?= $city ?></td></tr>
        <tr><th>Country</th><td><?= $country ?></td></tr>-->
        <tr><th>Name:</th><td><?= $fullname ?></td></tr>
        <tr><th>Contact No.</th><td><?= $phone ?></td></tr>
        <tr><th>Email</th><td><?= $email ?></td></tr>
    </table>
    <br/>
    <h3>Products</h3>
    <table class="dash-table table table-striped table-hover">
        <thead class="dash-th">
            <tr><th>Item Code</th><th>Product Name</th><th>Quantity</th><th>Total</th></tr>
        </thead>
        
        <?php
        foreach($products_orders->contents as $orderkey=>$product) {

//            if ($currency == 'dollar') {
//                $price = number_format($po->usdprice,2);
//                $c_price = 'USD ';
//            } else {
//                $price = number_format($po->price,2);
//                $c_price = 'Php ';
//            }
//
//            $prodTot = $prodTot + $po->order_quantity * $price;
            ?>
            <tr>
                <td><?php echo $product['sku']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $product['quantity']; ?></td>
                <td><?php echo $this->config->item('currency_symbol'). number_format($product['subtotal'], 2); ?></td>
            </tr>
<?php   } ?>
        <tr><td></td><td></td><td><b>TOTAL :</td><td> <?php echo $this->config->item('currency_symbol'). number_format($subtotal,2) ?></td></tr>
    </table>
    <br/>
    <form method="post" action="<?= base_url("waybill/insert_waybill") ?>" onsubmit="return confirm('Are you sure you want to submit?');">
        <input type='hidden' name="waybillno" value='<?= $waybill_no; ?>'/>
        <input type='hidden' name='order_num' value='<?= $order_number; ?>'>
        <table class="dash-table table table-striped table-hover">
            <tr><th>Pick up Location</th><td><input id="pickUpLoc" type="text" name="pickUpLoc" value="" placeholder="Pick up Location" ></td></tr>
            <tr><th>Pick up Date</th>
                <td>
                    <input id="start_top"  value="<?php echo isset($_POST["pickupDate"])?$_POST["pickupDate"]:date('Y-m-d');?>" class="span2" type="text" style="margin-top: 5px;" readonly />
                    <input id="start_top_alt" type="hidden" name="pickupDate" />
<!--                    <select name="month" style="width: 100px">
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <select name="day" style="width: 50px">
                        <?php
                        for ($i = 1; $i < 32; $i++) {
                            if ($i < 10) {
                                $i = "0" . $i;
                            }
                            ?><option value="<?= $i ?>"><?= $i ?></option><?php } ?>
                    </select>
                    <select name="year" style="width: 70px">
                        <?php
                        $year = date('Y');
                        for ($i = 2030; $i >= $year; $i--) {
                            $selected = "";
                            if ($i == $year) {
                                $selected = "selected";
                            }
                            ?><option value="<?= $i ?>" <?= $selected ?> ><?= $i ?></option><?php } ?>

                    </select>-->
                </td>
            </tr>
            <tr><th>Pick up Time</th>
                <td>
                    <select name="hour" style="width: 55px"><?php
                        for ($i = 0; $i < 24; $i++) {
                            if ($i < 10) {
                                $i = "0" . $i;
                            }
                            ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php } ?>
                    </select>
                    :
                    <select name="min" style="width: 55px"><?php
                        for ($i = 0; $i < 60; $i++) {
                            if ($i < 10) {
                                $i = "0" . $i;
                            }
                            ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                    <?php 
                        } 
                    ?>
                    </select>
                </td>
            </tr>
            <tr><th>Pick up Person</th><td><input id="pickUpPerson" type="text" name="pickUpPerson" value="" placeholder="Pick up Person" ></td></tr>
            <tr><th>Contact Details</th><td><input id="pickUpContact" type="text" name="pickUpContact" value="" placeholder="Contact Details" ></td></tr>
        </table>
        <input class="btn btn-primary" type="submit" value="Generate Waybill"/>
        <input class="btn btn-primary" type="button" onclick="history.go(-1);" value="Cancel">
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // set the datepickers individually to specify the alt fields
        $('#start_top').datepicker({dateFormat: 'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
        $('#start_bottom').datepicker({dateFormat: 'yy-mm-dd', altField: '#start_bottom_alt', altFormat: 'yy-mm-dd'});
    });
</script>
<?php include('footer.php');?>