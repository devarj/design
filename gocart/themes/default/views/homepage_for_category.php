<?php include('header.php');?>
<style>
	.banner-home{display: block;}
	.bub{display: block;}
	.headerMargin{margin-top:0}
</style>
	
	

<div class="row">
		<!--<?php if(isset($subcategories) && count($subcategories) > 0):?>
		
		<?php else:?>
		<div class="col-md-12">
		</div>
		<?php endif;?>
		-->

				<br style="clear:both;"/>
        
        <!-- chad new revise -->
        
         <div class="left-col">         	
         	<!-- category start -->
         				<!-- sample menu -->

         			
						<?php foreach($this->categories as $cat_menu):?>
						<!-- <div class="catData">
							
										<a href="<?php echo site_url($cat_menu['category']->slug);?>#anchor"><?php echo ucwords(strtolower($cat_menu['category']->name));?></a>
									
						</div> -->
						<?php endforeach;?>

						<select class="form-control resShow" placeholder="CATEGORIES">
							<option value="">CATEGORIES</option>
               			<?php
                    		function list_categories_2($cats, $sub='') {			
						foreach ($cats as $cat):?>
							
								<option  style="padding: 3px 8px;"><?php echo  $sub; ?><a style="font-size: 11px; line-height:13px; text-transform: uppercase; text-decoration: none;" href="<?php echo site_url($cat['category']->slug);?>"><?php echo ucwords(strtolower($cat['category']->name));?></a></option>
							
						<?php
						if (sizeof($cat['children']) > 0)
						{
			                            $sub2 = str_replace('&rarr;&nbsp;', '&nbsp;', $sub);
			                            $sub2 .=  '&nbsp;&nbsp;&nbsp;&rarr;&nbsp;';
			                            list_categories_2($cat['children'], $sub2);
						}
						endforeach;
			                    }
		
                    	list_categories_2($this->categories);
                
               			 ?>
               			 </select>

         				<!-- end sample menu -->
         				<span class="resHide">
         				<div class="topData">
								CATEGORIES
						</div>
						<?php foreach($this->categories as $cat_menu):?>
						<!-- <div class="catData">
							
										<a href="<?php echo site_url($cat_menu['category']->slug);?>#anchor"><?php echo ucwords(strtolower($cat_menu['category']->name));?></a>
									
						</div> -->
						<?php endforeach;?>

						<table class="table table-striped">
               			<?php
                    		function list_categories($cats, $sub='') {			
						foreach ($cats as $cat):?>
							<tr>
								<td  style="padding: 3px 8px;"><?php echo  $sub; ?><a style="font-size: 11px; line-height:13px; text-transform: uppercase; text-decoration: none;" href="<?php echo site_url($cat['category']->slug);?>"><?php echo ucwords(strtolower($cat['category']->name));?></a></td>
							</tr>
						<?php
						if (sizeof($cat['children']) > 0)
						{
			                            $sub2 = str_replace('&rarr;&nbsp;', '&nbsp;', $sub);
			                                    $sub2 .=  '&nbsp;&nbsp;&nbsp;&rarr;&nbsp;';
			                            list_categories($cat['children'], $sub2);
						}
						endforeach;
			                    }
		
                    	list_categories($this->categories);
                
               			 ?>
                    	</table>
                    </span>



         	<!-- end of category -->
 

         </div>

<div class="cent-col">

	
         
                <!-- slider -->
   				<i class="banner-home">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">			 
					  <!-- Wrapper for slides -->
					  <div class="carousel-inner">
					    <div class="item active">
					    	<a href="<?php echo site_url($menu_page->slug);?>">
					      <img src="<?php echo base_url('gocart/themes/default/assets/images/Banner 1023x150.jpg'); ?>">
					  		</a>
					      <div class="carousel-caption">
					        <!-- insert caption -->
					      </div>
					    </div>

					    <div class="item">
					    	<a href="<?php echo site_url($menu_page->slug);?>">
					      <img src="<?php echo base_url('gocart/themes/default/assets/images/Banner 1023x150 3.jpg'); ?>">
					 		 </a>
					  </div>
					</div>

					  <!-- Controls -->

					  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
					    <span class="glyphicon glyphicon-chevron-left"></span>
					  </a>
					  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
					    <span class="glyphicon glyphicon-chevron-right"></span>
					  </a>
				</div>
					<!-- end for slides -->

                      <?php if(count($best_sellers) > 0):?>
                        <div class="title-ad">
								<div class="col-xs-12">
									<div class="col-xs-4">
										<span class="customNavigation">
										  <a class="btn btn-grey btn-xs prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
										  <a class="btn btn-grey btn-xs next"><span class="glyphicon glyphicon-chevron-right"></span></a>									  
										</span>
									</div>
											<div class="col-xs-4">
											<img src="<?php echo base_url('gocart/themes/default/assets/images/Bestsellers.png'); ?>">
											</div>
										<div class="col-xs-4">
											<span class="customNavigation">
											  <a class="btn btn-grey btn-xs play"><span class="glyphicon glyphicon-play"></a>
											  <a class="btn btn-grey btn-xs stop"><span class="glyphicon glyphicon-stop"></a>
											</span>
										</div>
								</div>								
						</div>

						<div id="owl-example" class="owl-carousel">
                            <?php foreach($best_sellers as $b):?>
                                <?php if($b->sku != 'Deleted'):?>
                                <div class="side-corner-tag">
                                <div class="productCol">
                                    <?php
                                    $photo	= theme_img('no_picture.jpg', lang('no_image_available'));
                                    $data['images']				= (array)json_decode($b->images);
                                                                        
                                    if(!empty($data['images']))
                                    {
                                        $primary = $data['images'];
                                        foreach($data['images'] as $photo)
                                        {
                                            $primary = $photo;
                                        }
                                        
                                        $photo	   = '<img src="'.base_url('uploads/images/small/'.$primary->filename).'"/>';
                                        $photo_url = base_url('uploads/images/small/'.$primary->filename);

                                    }
                                    else
                                    {
                                        $photo_url = theme_img('no_picture.jpg');
                                    }
                                    ?>
                                    <div class="imageProd clearfix" style="background: url('<?php echo $photo_url; ?>') center / cover no-repeat #fff;">
                                    <a href="<?php echo site_url(implode('/', $base_url).'/'.$b->slug); ?>">
                                        <!--<?php echo $photo; ?> -->
                                        <img src="<?php echo base_url('gocart/themes/default/assets/images/blank_link_05.png'); ?>">
                                    </a>
                                    </div>

                                    <div class="descProd clearfix" style="background: #fff;border: solid 1px #eee;border-top: 0;padding: 0 .5rem .5rem;color: #2c3e50;">
                                        <div class="col-md-12 priceCol">
                                        	<span class="post">
                                         <h5><a href="<?php echo site_url(implode('/', $base_url).'/'.$b->slug); ?>"><?php echo $b->name;?></a></h5>
                                        	</span>
                                        <?php if($b->saleprice > 0):?>
                                            <!--<div class="col-md-6 nopad">
                                                <span class="price-slash"><?php echo lang('product_reg');?> <?php echo format_currency($b->price); ?><?php echo (empty($b->unit))?'':'/'.$b->unit; ?> </span>
                                            </div>-->
                                            <div class="col-md-12 nopad">
                                                <span class="price-sale"><i style="priceFont"><?php echo lang('product_sale');?></i> <b><?php echo format_currency($b->saleprice); ?><?php echo (empty($b->unit))?'':'/'.$b->unit; ?></b></span>
                                            </div>
                                        <?php else: ?>
                                            <span><i class="priceFont"><?php echo lang('product_price');?></i> <b><?php echo format_currency($b->price); ?><?php echo (empty($b->unit))?'':'/'.$b->unit; ?></b></span>
                                        <?php endif; ?>

                                        <?php if((bool)$b->track_stock && $b->quantity < 1) { ?>
                                            <div class="stock_msg"><?php echo lang('out_of_stock');?></div>
                                        <?php } ?>
                                            </div>
                                        <!-- priceCol -->

                                        <div class="col-md-12 btnCol">
                                            <a href="<?php echo site_url(implode('/', $base_url).'/'.$b->slug); ?>" class="btn btn-xs btn-primary prod_status" name="<?php echo $b->id;?>"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>
                                        </div>
                                    </div> <!-- descProd -->

		                                </div>
		                                <!--<span class="btn-check" style="color:#fff"><i class="glyphicon glyphicon-ok"></i></span>-->
                                    <?php if($b->saleprice > 0):?>
		                                <p><span>Sale</span></p>
                                    <?php endif; ?>
		                            	</div>

                                <?php endif; ?>
                            <?php endforeach?>
                           </div> 
                      <?php endif; ?>                       
                                                       
				</i>
                <!-- end slider -->

                <!-- text area -->
				<div class="page-header" style="margin: 0 0;">
					<h1><?php echo $page_title; ?></h1>
				</div>
				
				<?php if(!empty($category->description)): ?>
				<!--<div class="row">-->
					<div class="col-md-12"><?php echo $category->description; ?></div>
				<!--</div>-->
				<?php endif; ?>
				
				
				<?php if((!isset($subcategories) || count($subcategories)==0) && (count($products) == 0)):?>
					<div class="alert alert-info">
						<a class="close" data-dismiss="alert">×</a>
						<?php echo lang('no_products');?>
					</div>
				<?php endif;?>
    <!-- end of text area -->



         	 <?php if(count($products) > 0):?>
				<div class="col-md-12 productThumb clearfix">

									<ul>
									<?php foreach($products as $product):?>
									
										<li class="productCol">
											<?php
											$photo	= theme_img('no_picture.jpg', lang('no_image_available'));
											$product->images	= array_values($product->images);
									
											if(!empty($product->images[0]))
											{
												$primary	= $product->images[0];
												foreach($product->images as $photo)
												{
													if(isset($photo->primary))
													{
														$primary	= $photo;
													}
												}

												$photo	= '<img src="'.base_url('uploads/images/small/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
												$photo_url = base_url('uploads/images/small/'.$primary->filename);

											}
                                            else{
                                                $photo_url = theme_img('no_picture.jpg');
                                            }
											?>
											<div class="side-corner-tag-2">
											<div class="imageProd clearfix" style="background: url('<?php echo $photo_url; ?>') center / cover no-repeat #fff;">
											<a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>">
												<!--<?php echo $photo; ?> -->
												
												<img src="<?php echo base_url('gocart/themes/default/assets/images/blank_link_05.png'); ?>"></a>
												
											</div>
											<!--<span class="btn-check" style="color:#fff"><i class="glyphicon glyphicon-ok"></i></span>-->
                                            <?php if($product->saleprice > 0):?>    
			                                <p><span>Sale</span></p>
                                            <?php endif; ?>
			                            	</div>

											<div class="descProd clearfix">
												<div class="col-md-12 priceCol">
													<span class="post">
											<h5><a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $product->name;?></a></h5>
													</span>
											<!-- <?php //if($product->excerpt != ''): ?>
											<div class="excerpt"><?php //echo $product->excerpt; ?></div>
											<?php //endif; ?> -->
											
												<?php if($product->saleprice > 0):?>
													<!--<div class="col-md-6 nopad">
														<span class="price-slash"><?php echo lang('product_reg');?> <?php echo format_currency($product->price); ?><?php echo (empty($product->unit))?'':'/'.$product->unit; ?> </span>
													</div>-->
													<div class="col-md-12 nopad">
														<span class="price-sale"><i class="priceFont"><?php echo lang('product_sale');?> </i> <b><?php echo format_currency($product->saleprice); ?><?php echo (empty($product->unit))?'':'/'.$product->unit; ?></b></span>
													</div>
												<?php else: ?>
													<!-- <span class="price-reg"><?php echo lang('product_price');?> <?php echo format_currency($product->price); ?><?php echo (empty($product->unit))?'':'/'.$product->unit; ?></span> -->
													<span><i class="priceFont"><?php echo lang('product_price');?></i> <b><?php echo format_currency($product->price); ?><?php echo (empty($product->unit))?'':'/'.$product->unit; ?></b></span>
												<?php endif; ?>
											
							                    <?php if((bool)$product->track_stock && $product->quantity < 1) { ?>
													<div class="stock_msg"><?php echo lang('out_of_stock');?></div>
												<?php } ?>
													</div>
												<!-- priceCol -->

												<div class="col-md-12 btnCol">
													<!--<a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>" class=" btn btn-xs btn-primary"> Add to Cart</a>-->
                                                    <a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"  class="btn btn-xs btn-primary prod_status" name="<?php echo $product->id;?>"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>
												 </div>


											</div> <!-- descProd -->

										</li>
										 
									<?php endforeach?>
									</ul>
				</div>
                    <?php endif;?>

				<div class="col-md-12">
					<ul class="pagination pagination-sm pull-right">
					
					<?php echo $this->pagination->create_links();?>

					</ul>

				</div> 
</div>


         <div class="right-col" id="bannerHide">
         	<div class="row" style="margin-right:0">
         	<div class="col-md-12 nopadR" style="margin-bottom:2rem">         		
         	<img src="<?php echo base_url('gocart/themes/default/assets/images/how-to-shop-gif.gif'); ?>" style="width:100%">
         	</div>
         </div>

         <!-- bubble character -->
         		<?php
					if(isset($daily_tip)){
					?>
					<i class="bub" style="font-style:normal;"  id="shop">
					<div class="container-fluid nopadR" id="anchor" style="background: radial-gradient(rgb(244,245,153), rgba(61, 213, 174,.7))">
						<div class="tipCont">					

							<div class="col-md-12 nopadL">
								<div class="bubble">
									<b>Daily Tips </b>
										<br>
											<p><i><?php echo $daily_tip->tip; ?></i> <a style="color: #379324; font-size:1.25rem; font-weight: 600"href="<?php echo site_url('cart/view_tips/#'.$daily_tip->id);?>">more</a></p>
					                  
								</div>
							</div>

							<div class="col-md-12"  style="text-align:center; margin-top:1rem">
								<script type="text/javascript">
								// place your images in this array
								var random_images_array = ['chef.png', 'D-guy2.png', 'Mom2.png'];
								    
								function getRandomImage(imgAr, path) {
								    path = path || 'gocart/themes/default/assets/images/'; // default path here
								    var num = Math.floor( Math.random() * imgAr.length );
								    var img = imgAr[ num ];
								    var imgStr = '<img src="' + path + img + '" class="avatar" alt = "">';
								    document.write(imgStr); document.close();
								}
								</script>

									<script type="text/javascript">getRandomImage(random_images_array, 'gocart/themes/default/assets/images/')</script>
								
							</div>


						</div>

					</div>
					</i>
				<?php } ?>	
         <!-- bubble end -->

         <!-- banner ad -->
         	<div class="col-md-12 nopad">
         		<img style="margin-top:2rem; width:100%" src="<?php echo base_url('gocart/themes/default/assets/images/ADSPACE.jpg'); ?>">
         	</div>
         	<div class="col-md-12 nopad">
         		<img style="margin-top:2rem; width:100%" src="<?php echo base_url('gocart/themes/default/assets/images/ADSPACE.jpg'); ?>">
         	</div>
         	<div class="col-md-12 nopad">
         		<img style="margin-top:2rem; width:100%" src="<?php echo base_url('gocart/themes/default/assets/images/ADSPACE.jpg'); ?>">
         	</div>	

         <!-- end banner ad -->



         </div>
        
        
        <!-- end of new revised -->
</div>

<script>
   $(function(){         
    $(".post h5").css('font-size',function(){
        var $numWords = $(this).text().length; // get length of text for current p element
        if (($numWords >= 1) && ($numWords < 15)) {
            return "1.5rem";
        }
        else if (($numWords >= 16) && ($numWords < 20)) {
            return "1.25rem";
        }
        else if (($numWords >= 21) && ($numWords < 25)) {
            return "1rem";
        }
        else {
            return "1.15rem";
        }           
    });    
});
	</script>

<script>
$(document).ready(function() {
 

var owl = $("#owl-example");
 
  owl.owlCarousel({
      items : 6, //10 items above 1000px browser width
      itemsDesktop : [1000,5], //5 items between 1000px and 901px
      itemsDesktopSmall : [900,3], // betweem 900px and 601px
      itemsTablet: [600,2], //2 items between 600 and 0
      itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
  });
 
  // Custom Navigation Events
  $(".next").click(function(){
    owl.trigger('owl.next');
  })
  $(".prev").click(function(){
    owl.trigger('owl.prev');
  })
  $(".play").click(function(){
    owl.trigger('owl.play',5000); //owl.play event accept autoPlay speed as second parameter
  })
  $(".stop").click(function(){
    owl.trigger('owl.stop');
  })
 
});
</script>
	
<script type="text/javascript">
	window.onload = function(){
		$('.product').equalHeights();
	}
</script>
<script type="text/javascript">
    $(document).ready(function(){
       $('.prod_status').click(function(){
           var values = "id="+$(this).attr("name");
           $.ajax({
               type: "POST",
               url: "<?php echo site_url('cart/ajax_cart');?>",
               data: values,
               cache: false,
               error: function(ts){
                 alert(ts.responseText);  
               },
                success: function(html){
                    if(html > 1){
                        $('.cart_headercount').html('<img style="max-width:20px"src="<?php echo base_url('gocart/themes/default/assets/images/cart-icon.png'); ?>"> There are ' + html + ' items in your cart');
                    }else{
                        $('.cart_headercount').html('<img style="max-width:20px"src="<?php echo base_url('gocart/themes/default/assets/images/cart-icon.png'); ?>"> There is ' + html + ' item in your cart');
                    }
                }
           });
           return false;
       }) ;
    });
</script>

<script>
$(document).ready(function() {
    $('#left-menu').sidr({
      name: 'sidr-left',
      side: 'left' // By default
    });
    $('#right-menu').sidr({
      name: 'sidr-right',
      side: 'right'
    });    
});
</script>

<script>
    $("a.btn.prod_status").click(function(){
	  $(this).parent().append("<div class='add'>Added</div>");
	  setTimeout(function () {
	    $("div.add").fadeOut();
	  }, 1200);
	  return false;
	});
</script>



<style>
	/*.add{position: absolute;font-size: 1.5rem; display: none;top: 30%; width: 100%;text-align: center;color: #fff;height: auto;background: rgba(36, 35, 35, 0.5);}*/
	.add{position: absolute;font-size: 1rem;top: 0}
</style>

<?php echo theme_js('../owl-carousel/custom.js', true);?>

<?php include('footer.php'); ?>