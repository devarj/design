<?php include('header.php');?>

<?php 
 $segments = $this->uri->total_segments();
        $base_url = $this->uri->segment_array();
        if(!$segments && !$base_url)
        {
            ?>
<?php } ?>


</div>


<div class="container mainCont" style="min-height: 555px;">
  <br />
  <div class="row">
    <div class="col-md-4">
      <div class="categoryPanel">
        <div class="side-col">
		
            <div class="clearfix sTogMobile">
            <ul class="hghlght">  
              <li class="categoryCont">
                <h3><a href="<?php echo site_url().'cart/allproducts';?>">Services Offered</a></h3>
              </li>
              <!--
              <?php foreach($this->categories as $cat_menu):?>
              <li>
                <span class="glyphicon glyphicon-chevron-right" style="font-size:0.8em; color:#8bc53f;"></span>&nbsp;&nbsp;
                <a href="<?php echo site_url($cat_menu['category']->slug);?>" style="font-size: 0.89em;">
                    
                     <?php echo ucwords(strtolower($cat_menu['category']->name));?>
                    
                </a>
              </li>
              <?php endforeach;?>-->
              </ul>
            </div>
            <table >
              <?php
                function list_categories($cats, $sub='') {         
                foreach ($cats as $cat):?>
                  <tr>
                    <td style="padding:8px 0;">
                    <?php echo  $sub; ?>
                    <span class="glyphicon glyphicon-play" style="font-size:0.8em; color:#8bc53f;"></span>&nbsp;&nbsp;
                      <a class="sideCatA" style="" href="<?php echo site_url($cat['category']->slug);?>">
                        <?php echo ucwords(strtolower($cat['category']->name));?>
                      </a>
                    </td>
                  </tr>
                  <?php
                    if (sizeof($cat['children']) > 0)
                    {
                    $sub2 = str_replace('&rarr;&nbsp;', '&nbsp;', $sub);
                            $sub2 .=  '&nbsp;&nbsp;&nbsp;&nbsp;';
                            list_categories($cat['children'], $sub2);
                    }
                endforeach;
              }

              list_categories($this->categories);?>
			  <tr>
				<td>
					<span class="glyphicon glyphicon-play" style="font-size:0.8em; color:#8bc53f;"></span>&nbsp;&nbsp;
					<a class="sideCatA" style="" href="<?php echo base_url('custom-order');?>">
                       Custom Order
                      </a>
				</td>
			  </tr>
            </table><br />

            <div class="TogMobile" style="z-index:1000;">
              <div class="btn-group pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  Categories&nbsp;&nbsp;<span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <?php foreach($this->categories as $cat_menu):?>
                      <li>
                        <a href="<?php echo site_url($cat_menu['category']->slug);?>">
                          <div class="togglecat">
                           <?php echo ucwords(strtolower($cat_menu['category']->name));?>
                          </div>
                        </a>
                    </li>
                <?php endforeach;?>
                </ul>
              </div>
            </div>
          </div> <!-- side-col -->
      </div>
    </div>
    <div class="col-md-8">
       <div class="row">
			<h2 class="text-center">Custom Products Offered</h2>
			<div class="col-md-4">
				<div class="panel panel-primary">
				  <div class="panel-heading">
					<h3 class="panel-title text-center">Custom Tshirt</h3>
				  </div>
				  <div class="panel-body">
					<a href="<?php echo base_url('cart/customshirt'); ?>"><img src="<?php echo theme_img('shirt.jpg'); ?>" class="img-responsive" /></a>
				  </div>
				</div>
			</div>
			<!--<div class="col-md-4">
				<div class="panel panel-primary">
				  <div class="panel-heading">
					<h3 class="panel-title text-center">Custom Mugs</h3>
				  </div>
				  <div class="panel-body">
					<img src="<?php echo theme_img('Custom Mug.jpg'); ?>" class="img-responsive" />
				  </div>
				</div>
			</div>-->
			<div class="col-md-4">
				<div class="panel panel-primary">
				  <div class="panel-heading">
					<h3 class="panel-title text-center">Custom Tarpaulin</h3>
				  </div>
				  <div class="panel-body">
					<a href="<?php echo base_url('cart/customtarp'); ?>"><img src="<?php echo theme_img('ZZZT-803.jpg'); ?>" class="img-responsive" /></a>
				  </div>
				</div>
			</div>
	   </div>

    </div>
  </div>
  <div class="row">
    <div class="col-md-12 clearfix" style="border-bottom:1.5px solid #8CC43F;"></div>
  </div>
  
  <div class="row">
    
  </div><!-- row -->


</div> <!-- container -->


<?php include('footer.php'); ?>