<?php
$this->load->view('header.php');
//error_reporting(E_ALL);
?>

<div class="page-header" id="anchor">
    <h1><?php echo 'Auto Shipment Items'; ?></h1>
</div>
<div class="row">
    <table  class="table table-striped" id="myTable"> 
        <tr>
            <th>Date Start</th>
            <th>Items </th>
            <th>Total Price </th>
            <th>Run Every</th>
            <th>Next Run</th>
            <th>
                <a href="<?php echo base_url('ship/add'); ?>" class="btn btn-info btn-sm">Add New</a>
                <?php if (!$address): ?>
                    <!--<a href="<?php echo base_url('ship/add_address'); ?>" class="btn btn-info btn-sm">Add Address </a>-->
                <?php endif; ?>
            </th>

        </tr>
        <tbody>
            <?php
            foreach ($autoship as $key => $value)
            {
                ?>
                <tr>
                    <td><?php echo date('F-d-Y', strtotime($value->date_start)); ?></td>
                    <td>    <table  class="table table-striped" border="0"> 
                            <tr>
                                <td>Item Name</td>
                                <td>Quantity</td>
                                <td>Price</td>
                            </tr>
                            <?php
                            foreach ($autoship_details as $key => $value1)
                            {
                                if ($key == $value->id)
                                {
                                    foreach ($value1 as $key => $value_details)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $value_details->name; ?></td>
                                            <td><?php echo $value_details->quantity; ?></td>
                                            <td><?php echo format_currency($value_details->price); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </table>
                    </td>
                    <td><?php echo format_currency($value->total_price); ?></td>

                    <td><?php echo $value->run_every; ?></td>
                    <td class="success"><?php echo date('F-d-Y (D)', strtotime($value->cron_date)); ?></td>
                    <td>
                        <?php // echo date('M-d (l) -Y',strtotime("+7 day", strtotime(date('Y-m-d'))));?>
                        <a href="<?php echo 'ship/edit/' . $value->id; ?>" class="btn btn-info btn-sm">EDIT</a>
                        <a href="<?php echo base_url('ship/delete') . '/' . $value->id; ?>" class="btn btn-danger btn-sm">Remove</a>
                    </td>

                </tr>
            <?php } ?>


        </tbody>
        <tfoot>
            <tr>
            </tr>
        </tfoot>
    </table>
</div>
<?php
// include('footer.php');
$this->load->view('footer.php');
?>