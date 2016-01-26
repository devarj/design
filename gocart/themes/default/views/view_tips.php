<?php include('header.php'); ?>

<div class="container" style="padding-top: 2em">

  <div class="in-maincol">
    <h1 class="titleHead" style="font-size: 30px; font-weight: normal; text-transform: uppercase;">Energy Saving Tips</h1>
    <img src="http://i.imgur.com/xQ9FKJT.gif" class="pinkLine">
   <?php
foreach($tips as $tip) { ?>
  <div class="row">
    <div class="col-md-12">
      <div id="<?php echo $tip->id; ?>" name="<?php echo $tip->id; ?>" class="col-md-12 nopad" style="border-bottom:2px solid #e1e1e1; ">
        <!-- <b>Daily Tips </b> -->
          <br>
            <p><?php echo $tip->tip; ?></p>
      </div>
     </div>
   </div>

<?php } ?>
</div>

  <div class="in-sidecol">
    <img src="<?php echo base_url('gocart/themes/default/assets/images/adspace_05.gif'); ?>" style="margin-top:0">
    <!--
    <img src="<?php echo base_url('gocart/themes/default/assets/images/adspace_05.gif'); ?>">
    <img src="<?php echo base_url('gocart/themes/default/assets/images/adspace_05.gif'); ?>">
    -->
  </div>


</div>

 


<?php include('footer.php');?>