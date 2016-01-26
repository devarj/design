
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            <div class="page-header">
            	<h2><?php echo lang('form_checkout');?></h2>
            </div>
        </div>
	
<?php include('order_details.php');?>
<br>
<br>
<?php include('summary.php');?>   
                      <script>
function myFunction() {
    var points = document.getElementById("points").value;
    if(points === '')
    {
        alert('Please select reward points.');
    }else
    {
       var a =  confirm('Are you sure you want to use '+points +' reward points?');
       if(a === true)
       {
              var url = "<?php echo base_url('cart/click_reward_points') ?>/"+points;
           window.location = url;
       }else
       {
//           alert(a);
       }
    }
    


}
</script>            

<div class="row">
	<div class="col-md-12" style="text-align:right">
		<a class="btn btn-info btn-sm" href="<?php echo site_url('checkout/place_order');?>">Proceed to Order</a>
	</div>
</div>  

<!-- <hr>
<div class="row">
    <div class="col-md-12">
    Disclaimer: Product photos and actual product upon delivery may vary. All products are guaranteed fresh.
    </div>
</div> -->
    
</div>
</div>