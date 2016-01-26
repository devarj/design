<?php 
include('header.php'); 
?>

<div class="container mainCont" >

  <br />
  <div class="row">
  	<div class="col-md-12" style="margin-top:15px;text-align:center; color:#0A0D3C;">
  		<h1>Welcome To iDesign Online Store </h2>
      <div style="width: 200px; height: 1.2px; background-color: ##F18E00; margin: 0 auto; margin-top:5px;"></div>
  	</div>
  </div>
  <br />
 <div class="row">
	<div class="col-md-12">
		<div class="row">
		<div class="col-md-12" style="padding: 0">
              <ul class="hghlght">  
              <li class="">
                <h3><a href="<?php echo site_url().'cart/allproducts';?>">Select Design</a></h3>
              </li>
              </ul>
              <div class="prod-col clearfix">
              <?php foreach($designs as $design):?>
                <div class="prod-item">
                  <div class="prod-img" style="background: url('uploads/<?php echo $design->design; ?>') center / contain no-repeat #fff;">

                      <a href="">
                          <img src="<?php echo base_url('gocart/themes/default/assets/images/blank.png'); ?>">
                      </a>
                  </div>
                  <div class="prod-desc">
                      <div class="prod-title">
                          <a href=""><?php echo $design->name;?></a>
                      </div>

                          <div class="prod-priceCont clearfix" style="text-align:right;">
                            <span class="prod-price"><b><?php echo format_currency($design->price); ?></b></span>
                            <a href="" class="btn btn-nxled btn-sm pull-right" style="margin-top:7px;text-transform:uppercase;"> Choose </a>
                          </div>
                     
                  </div><!-- prod-desc -->
                </div><!-- prod-item -->
				
                  <?php endforeach?>
			

              </div><!-- prod-col -->
            </div>
		</div>
	</div>
 </div>
 <br />
  <div class="row">
  	<div class="col-md-12" style="margin-top:15px;text-align:center; color:#F18E00;">
		<div class="alert alert-dismissible alert-info">
		  <strong>Contact us</strong><br />
		  <strong>Mobile: 09178147321</strong><br />
		  <strong>Email: <a href="mailto: idesign@ymail.com">idesign@ymail.com</a></strong>
		</div>
	
      <div style="width: 200px; height: 1.2px; background-color: ##F18E00; margin: 0 auto; margin-top:5px;"></div>
  	</div>
  </div>
  <div class="row">
  	<div class="col-md-12" style="margin-top:15px;text-align:center; color:#F18E00;">
  		<a href="<?php echo base_url('secure/newsupplier'); ?>"><h4>Register as Supplier</h4></a>
  		<a href="<?php echo base_url('secure/register'); ?>"><h4>Register as Customer</h4></a>
  		<a href="<?php echo base_url('secure/login'); ?>"><h4>Login</h4></a>
      <div style="width: 200px; height: 1.2px; background-color: ##F18E00; margin: 0 auto; margin-top:5px;"></div>
  	</div>
  </div>
  <br />
</div> <!-- container -->

  <script>
    $(document).ready(function() { 
          var owl = $("#similar");
         
          owl.owlCarousel({
             
              itemsCustom : [
                [0, 2],
                [450, 3],
                [600, 3],
                [700, 3],
                [800, 3],
                [1000, 4],
                [1200, 5],
                [1400, 5],
                [1600, 5]
              ],
              navigation : true,
              navigationText : false
         
          });
         
        });
    </script>                     
  
  <script>
    $(document).ready(function() {
 
  $("#owl-demo").owlCarousel({
 
      autoPlay: 3000, //Set AutoPlay to 3 seconds
 
      items : 1,
      itemsDesktop : [1199,1],
      itemsDesktopSmall : [979,1]
 
  });
 
});
  </script>  

    <script>
    document.getElementById("asd").onclick = function () {
    document.getElementById("pop_up_main").style.display = "none";
      };     
    </script>

<!--
<div class="row">
	<div class="span12">
		<div id="myCarousel" class="carousel slide">
			<!-- Carousel items -->
<!--			<div class="carousel-inner">
				<?php
				$active_banner	= 'active ';
				foreach($banners as $banner):?>
					<div class="<?php echo $active_banner;?>item">
						<?php
						
						$banner_image	= '<img src="'.base_url('uploads/'.$banner->image).'" />';
						if($banner->link)
						{
							$target=false;
							if($banner->new_window)
							{
								$target=' target="_blank"';
							}
							echo '<a href="'.$banner->link.'"'.$target.'>'.$banner_image.'</a>';
						}
						else
						{
							echo $banner_image;
						}
						?>
					
					</div>
				<?php 
				$active_banner = false;
				endforeach;?>
			</div>
			<!-- Carousel nav -->
<!--			<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
	</div>
</div>

<script type="text/javascript">
$('.carousel').carousel({
  interval: 5000
});
</script>


<div class="row">
	<?php foreach($boxes as $box):?>
	<div class="span3">
		<?php
		
		$box_image	= '<img class="responsiveImage" src="'.base_url('uploads/'.$box->image).'" />';
		if($box->link != '')
		{
			$target	= false;
			if($box->new_window)
			{
				$target = 'target="_blank"';
			}
			echo '<a href="'.$box->link.'" '.$target.' >'.$box_image.'</a>';
		}
		else
		{
			echo $box_image;
		}
		?>
	</div>
	<?php endforeach;?>
</div>
-->
<?php include('footer.php'); ?>