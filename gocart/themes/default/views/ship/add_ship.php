<?php
$this->load->view('header.php');
//error_reporting(E_ALL);
?>

<?php
if (isset($_SERVER['HTTPS']))
{
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}
else
{
    $protocol = 'http';
}
//        $url_define = $protocol . "://" . $_SERVER['HTTP_HOST'] . '/prod/mayd';
$url_define = $protocol . "://" . $_SERVER['HTTP_HOST'] . '/mayd';
?>

<script type="text/javascript">
    $(function() {
        $("#datepicker").datepicker({minDate: 3});
    });
</script>



<div class="page-header" id="anchor">
    <h1><?php echo 'Auto Shipment'; ?></h1>
</div>

<?php if (!empty($category->description)): ?>
    <!--    <div class="row">
            <div class="span12"><?php echo $category->description; ?></div>
        </div>-->
<?php endif; ?>


<?php if ((!isset($subcategories) || count($subcategories) == 0) && (count($products) == 0)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert">×</a>
        <?php echo lang('no_products'); ?>
    </div>
<?php endif; ?>

<div class="row">
    <form id="order_submit_form" action="<?php echo site_url('ship/post'); ?>" method="post"  onsubmit="if (confirm('<?php echo 'Are you sure you want this products to be auto ship?'; ?>')) {
                return true;
            } else {
                return false;
            }">
        <table  class="table table-striped" id="myTable"> 
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total Price<div id="totalprice"><input name="totalprice" value="0" class="col-sm-2" readonly=""/></div></td>
                    <!--                </tr>
                                    <tr>-->
                    <td>Date<div></div><input type="text" id="datepicker" name="deliverydate" readonly></td>
                    <td class="col-md-2">
                        <div>Run Every :</div><select class="form-control quantity-slt" name="cron">
                            <option name="weekly">Weekly </option>
                            <option name="monthly">Monthly </option>
                        </select>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div id="autoshipbutton" style="display:none">
            <input style="padding:10px 15px; font-size:16px;" type="button" class="btn btn-primary btn-large" onclick="validation();"
                   value="<?php echo 'Auto Ship' ?>" />
        </div>


    </form>
</div>

<br style="clear:both;"/>
<div class="row">
    <?php
//    print_r('<pre>');
//    var_dump($products);
//    print_r('<pre>');
    ?>
    <?php if (count($products) > 0): ?>
        <table class="table table-striped" >
            <?php foreach ($products as $product): ?>
                <tr class="">
                    <?php
                    $photo = theme_img('no_picture.png', lang('no_image_available'));
                    $product->images = array_values($product->images);

                    if (!empty($product->images[0]))
                    {
                        $primary = $product->images[0];
                        foreach ($product->images as $photo)
                        {
                            if (isset($photo->primary))
                            {
                                $primary = $photo;
                            }
                        }

                        $photo = '<img style="min-height: 80px; max-height: 80px;" src="' . base_url('uploads/images/small/' . $primary->filename) . '" alt="' . $product->seo_title . '"/>';
                        $photo_url = base_url('uploads/images/small/' . $primary->filename);
                    }
                    else
                    {
                        $photo_url = '';
                    }
                    ?>
                    <td> <?php echo $photo; ?> </td>
                    <td><h5><?php echo $product->name; ?></h5></td>
                    <td> <span><i style="font-size:1.25rem"><?php echo lang('product_price'); ?></i> <b><?php echo format_currency($product->price); ?><?php echo (empty($product->unit)) ? '' : '/' . $product->unit; ?></b></span></td>
                    <?php
                    if ((bool) $product->track_stock && $product->quantity < 1)
                    {
                        ?>  <td><div class="stock_msg"><?php echo lang('out_of_stock'); ?></div>  </td>
                    <?php } ?>
                    <td class="col-md-1">
                        <select class="form-control quantity-slt all_select"
                                name="quantity_<?php echo $product->id; ?>" id="quantity_<?php echo $product->id; ?>"
                                onchange="select(<?php echo $product->id; ?>, this.value, '<?php echo $product->name; ?>', '<?php echo $product->price; ?>')">
                                    <?php for ($x = 0; $x <= 20; $x++): ?>
                                <option><?php echo $x; ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                    <td><input type="checkbox" class="all_checkbox" name="check_<?php echo $product->id; ?>" id="check_<?php echo $product->id; ?>" onchange='check("<?php echo $product->id; ?>")'></td>
                </tr>
            <?php endforeach ?>
        </table> 
    <?php endif; ?>

    <br style="clear:both;"/>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.all_select').prop('disabled', 'disabled');
        $('.all_select').val(0);
        $('.all_checkbox').prop('checked', false);
    });
    function check(x)
    {
        if ($("#check_" + x).is(":checked"))
        {
            $('#quantity_' + x).prop('disabled', false);
        } else
        {
            $('#quantity_' + x).prop('disabled', 'disabled');
            $('#quantity_' + x).val(0);
            $('#tr_' + x).remove();
            compute_total_price();
        }

    }
    function select(a, val, title, price)
    {
        var subtotal = (price * val);
//        $('#myTable tr:last').after('<tr id="tr_' + a + '"><td>' + title + '</td><td> ' + val + '</td><td class="price">' + a + '</td></tr>');
        $('#myTable > tbody:last').after('<tr id="tr_' + a + '"><td>' + title + '</td><input type="hidden" name="productid[]" value="' + a + '"/><input type="hidden" name="qty[]" value="' + val + '"/><input type="hidden" name="subtotal[]" value="' + subtotal + '"/><td> ' + val + '</td><td class="price">' + subtotal + '</td></tr>');

        compute_total_price();
        $('#quantity_' + a).prop('disabled', 'disabled');
    }
    function compute_total_price()
    {
        var tdtotal = 0;
        $(".price").each(function() {
            tdtotal += parseInt($(this).text().replace(",", ""));
        })
        $('#totalprice').html('<input name="totalprice" value="₱' + tdtotal + '.00" class="col-sm-2" readonly=""/><input type="hidden" name="total_price" value="' + tdtotal + '"/>');
        if (tdtotal !== 0)
        {
            $('#autoshipbutton').css('display', 'block');
        } else
        {
            $('#autoshipbutton').css('display', 'none');
        }
    }
    function validation()
    {
        if ($('#datepicker').val() === '')
        {
            alert('Please Select Date to start the shipment.');
        } else
        {
            $('#order_submit_form').submit();
        }

    }
</script>
<?php
// include('footer.php');
$this->load->view('footer.php');
?>