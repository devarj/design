<?php include('header.php'); ?>
<script type="text/javascript">    
    $(document).ready(function(){ 
//        $("#invoices_table").dataTable(); 
//        if(<?php echo count($invoices); ?> != 0){
//             $("#invoices_table").dataTable(); 
//        }
    });
    $(function() {
        $( "#date_from" ).datepicker();
        $( "#date_to" ).datepicker();
    });
</script>
<!--
<style type="text/css">
  .textBox{width: 100px;}

  @media all (max-width: 675px) {
     .textBox{width: 100%; display: block;}
  }
</style>-->

<div class="row">
    <div class="span12" style="border-bottom:1px solid #f5f5f5;margin-bottom: 30px; ">
        <div class="row">
            <div class="span12">
            
            <div class="column column50 clearfix">
                <form method="post" action="<?php echo site_url("/admin/invoice"); ?>">
                    <input id="date_from" value="<?php echo $start;?>" class="textBox" type="text" name="start" placeholder="Start Date" style="margin-top: 5px; " />
                    <input id="date_to" value="<?php echo $end;?>" class="textBox" type="text" name="end" placeholder="End Date" style="margin-top: 5px;" />
                    <button class="btn btn-primary" name="submit" value="search" style="margin-bottom: 5px;"><?php echo lang('search') ?></button>
                </div>
                <div class="column column50 clearfix align-right">
                <!--<button class="btn btn-primary" name="submit" value="export_to_csv" style="margin-top: 5px;"> Ms Excel (CSV)</button>-->
                    <?php
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)))
                    {
                    ?>
            <!--            <a class="btn" href="#">PDF</a>-->
                    <?php
                    }
                    else
                    {
                    ?>
                        <button class="btn btn-primary" onclick="javascript:window.print();" style="margin-top: 5px;"> Print</button>
                    <?php
                    }
                    ?>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="simpleTable clearfix">    
<table class="dash-table table table table-striped" id="invoices_table">
	<thead>
		<tr>  
      <th>Invoice Date</th>
			<th>Invoice Number</th>
			<th>Order Number</th>
			<th>Date Delivered</th>
			<th>Waybill Number</th>
			<th>Total</th>
			<th>Transaction Fee</th>
			<th>Net Amount</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($invoices as $data):?>
		<tr>
            <td><?php echo date('Y-m-d', strtotime($data->invoice_date)); ?></td>
			<td><?php echo $data->invoice_no; ?></td>
			<td><?php echo $data->order_number; ?></td>
            <td><?php echo $data->ordered_on; ?></td>
            <td><?php echo $data->waybill_no; ?></td>
            <td class="align-right"><?php echo $data->subtotal; ?></td>
            <td class="align-right"><?php echo $data->transaction_fee; ?></td>
            <td class="align-right"><?php echo $data->net_amount; ?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
</div>

<!-------------------------------------------------------------------------------------->
<?php foreach ($invoices as $data):?>
<div class="accordTable clearfix" id="accordion-container">
          <h6 class="accordion-header">
            Invoice Date: <strong><?php echo $data->invoice_date; ?></strong><br>
          <b class="titleDesc">
              Invoice Number: <?php echo $data->invoice_no; ?><br>
              Order Number: <?php echo $data->order_number; ?>
          </b>           
          </h6>

<div class="accordion-content open-content">
      <span class="table100">
        <span class="table50">
           <b class="titleDesc">Date Delivered:</b> 
        </span>          
        <span class="table50">
              <?php echo $data->ordered_on; ?>
        </span>
      </span>
      
      <span class="table100">
        <span class="table50">
           <b class="titleDesc">Waybill Number:</b> 
        </span>          
        <span class="table50">
              <?php echo $data->waybill_no; ?>
        </span>
      </span>

      <span class="table100">
        <span class="table50">
           <b class="titleDesc">Total:</b> 
        </span>          
        <span class="table50">
              <?php echo $data->subtotal; ?>
        </span>
      </span>

      <span class="table100">
        <span class="table50">
           <b class="titleDesc">Transaction Fee:</b> 
        </span>          
        <span class="table50">
              <?php echo $data->transaction_fee; ?>
        </span>
      </span>
    
      <span class="table100">
        <span class="table50">
           <b class="titleDesc">Net Amount:</b> 
        </span>          
        <span class="table50">
              <?php echo $data->net_amount; ?>
        </span>
      </span>
      
</div>
</div>
<?php endforeach; ?>
<!-------------------------------------------------------------------------------------->

<?php include('footer.php'); ?>