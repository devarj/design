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
                <h3><a href="<?php echo site_url().'cart/allproducts';?>">Printing Services</a></h3>
              </li>
			  <li>
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
			  
            </table>
			  </li>
			   <li class="categoryCont">
                <h3><a href="<?php echo site_url().'cart/allproducts';?>">Customize Services</a></h3>
              </li>
			  <li>
			  <table>
			  <tr>
				<td>
					<span class="glyphicon glyphicon-play" style="font-size:0.8em; color:#8bc53f;"></span>&nbsp;&nbsp;
					<a class="sideCatA" style="" href="<?php echo base_url('custom-order');?>">
                       Customize services
                      </a>
				</td>
			  </tr>
            </table>
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
            <br />

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
        
            <?php if(count($products) > 0):?>
            <div class="col-md-12" style="padding: 0">
              <ul class="hghlght">  
              <li class="">
                <h3><a href="<?php echo site_url().'cart/allproducts';?>">PRODUCTS</a></h3>
              </li>
              </ul>
              <div class="prod-col clearfix">
              <?php foreach($products as $product):?>
                <div class="prod-item">
                  <?php
                      $photo  = theme_img('no_picture.jpg', lang('no_image_available'));
                      $product->images  = array_values($product->images);

                      if(!empty($product->images[0]))
                      {
                          $primary  = $product->images[0];
                          foreach($product->images as $photo)
                          {
                              if(isset($photo->primary))
                              {
                                  $primary  = $photo;
                              }
                          }

                          $photo  = '<img src="'.base_url('uploads/images/medium/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
                          $photo_url = base_url('uploads/images/medium/'.$primary->filename);

                      }
                      else
                      {
                          $photo_url = theme_img('no_picture.jpg');
                      }
                  ?>
                  <div class="prod-img" style="background: url('<?php echo $photo_url; ?>') center / contain no-repeat #fff;">

                    

                      <a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>">
                          <img src="<?php echo base_url('gocart/themes/default/assets/images/blank.png'); ?>">
                      </a>
                  </div>
                  <div class="prod-desc">
                      <div class="prod-title">
                          <a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $product->name;?></a>
                          <span class="title-sku"> <?php echo $product->sku;?> </span>
                      </div>

                      <?php
                      if($product->saleprice > 0):?>
                          <div class="prod-priceCont clearfix" style="text-align:right; padding-top:0px!important; line-height:1.1em;">
                              <span class="prod-sale"><b><?php echo format_currency($product->price); ?><?php echo (empty($product->unit))?'':'/'.$product->unit; ?></b></span><br/>
                              <span class="prod-price"><b><?php echo format_currency($product->saleprice); ?><?php echo (empty($product->unit))?'':'/'.$product->unit; ?></b></span>
                              <a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>" class="btn btn-nxled btn-sm pull-right" style="margin-top:7px;text-transform:uppercase;"> Add To Cart </a>
                          </div>
                      <?php else:
                          ?>
                          <div class="prod-priceCont clearfix" style="text-align:right;">
                            <span class="prod-price"><b><?php echo format_currency($product->price); ?><?php echo (empty($product->unit))?'':'/'.$product->unit; ?></b></span>
                            <a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>" class="btn btn-nxled btn-sm pull-right" style="margin-top:7px;text-transform:uppercase;"> Add To Cart </a>
                          </div>
                      <?php endif;?>
                     
                  </div><!-- prod-desc -->
                </div><!-- prod-item -->
                  <?php endforeach?>


              </div><!-- prod-col -->
            </div><!--col-md-12 -->
              <?php endif;?>

                  <div class="col-md-12">
                    <ul class="pagination pagination-sm pull-right">            
                      <?php echo $this->pagination->create_links();?>
                    </ul>
                  </div> 
    </div><!-- col-md-9 -->
  </div>
  <div class="row">
    <div class="col-md-12 clearfix" style="border-bottom:1.5px solid #8CC43F;"></div>
  </div>
  <!-- Featured Products -->
  <?php if(count($featured_products) > 0):?>
    <div class="row">
      <div class="col-md-12" style="margin-top: 20px; ">
                <!-- related products -->
                    <div class="related-ulist related clearfix">
                                <!-- <h3><?php echo lang('related_products_title'); ?></h3> -->
                               <h3 class="" style="margin-top: 10px;margin-bottom:20px;">FEATURED PRODUCTS</h3>
                               <div id="similar" class="owl-carousel owl-theme">     
                                    <?php foreach($featured_products as $b):?>        
                                    <div class="related-item">
                                    <?php
                                        $photo  = theme_img('no_picture.jpg', lang('no_image_available'));
                                        $data['images']       = (array)json_decode($b->images);

                                        if(!empty($data['images']))
                                        {
                                            $primary = $data['images'];
                                            foreach($data['images'] as $photo)
                                            {
                                                $primary = $photo;
                                            }

                                            $photo     = '<img src="'.base_url('uploads/images/medium/'.$primary->filename).'"/>';
                                            $photo_url = base_url('uploads/images/medium/'.$primary->filename);

                                        }
                                        else
                                        {
                                            $photo_url = theme_img('no_picture.jpg');
                                        }
                                    ?>
                                            <a href="<?php echo site_url(implode('/', $base_url).'/'.$b->slug); ?>">
                                                <div class="sml-img" style="background: url('<?php echo $photo_url; ?>') center / contain no-repeat #fff;">
                                                    <img src="<?php echo base_url('gocart/themes/default/assets/images/relatedblank.png'); ?>">
                                                </div>
                                            </a>
                                        <div class="prod-desc">
                                            <div class="prod-title">
                                                <a href="<?php echo site_url(implode('/', $base_url).'/'.$b->slug); ?>"><?php echo $b->name;?></a>
                                                <span class="title-sku"> <?php echo $b->sku;?> </span>
                                            </div>

                                          <?php if ($b->saleprice > 0):?>
                                              <div class="prod-priceCont clearfix" style="text-align:right; padding-top:0px!important; line-height:1.1em;">
                                                  <span class="prod-sale"><b><?php echo format_currency($b->price); ?><?php echo (empty($b->unit))?'':'/'.$b->unit; ?></b></span><br/>
                                                  <span class="prod-price"><b><?php echo format_currency($b->saleprice); ?><?php echo (empty($b->unit))?'':'/'.$b->unit; ?></b></span>
                                                  <a href="<?php echo site_url(implode('/', $base_url).'/'.$b->slug); ?>" class="btn btn-nxled btn-sm pull-right" style="margin-top:7px;text-transform:uppercase;"> Add To Cart </a>
                                              </div>
                                          <?php else:
                                              ?>
                                              <div class="prod-priceCont clearfix" style="text-align:right;">
                                                <span class="prod-price"><b><?php echo format_currency($b->price); ?><?php echo (empty($b->unit))?'':'/'.$b->unit; ?></b></span>
                                                <a href="<?php echo site_url(implode('/', $base_url).'/'.$b->slug); ?>" class="btn btn-nxled btn-sm pull-right" style="margin-top:7px;text-transform:uppercase;"> Add To Cart </a>
                                              </div>
                                          <?php endif;?>
                                        </div><!-- prod-desc -->


                                    </div>
                            <?php endforeach?>
                                   
                                </div>
                    </div>
       </div>
            <!-- related products -->
    </div>
<?php endif; ?>  

  <div class="row">
    
  </div><!-- row -->


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
          var owl = $("#featured");
         
          owl.owlCarousel({
             
              itemsCustom : [
                [0, 1],
                [400,1],
                [450, 2],
                [600, 3],
                [700, 3],
                [1000, 4],
                [1200, 4],
                [1400, 4],
                [1600, 4]
              ],
              navigation : true
         
          });
         
        });
    </script>


    <script>
    $(document).ready(function() { 
          var owl = $("#newarrive");
         
          owl.owlCarousel({
             
              itemsCustom : [
                [0, 1],
                [400,1],
                [450, 2],
                [600, 3],
                [700, 3],
                [1000, 4],
                [1200, 4],
                [1400, 4],
                [1600, 4]
              ],
              navigation : true
         
          });
         
        });
    </script>

    <script>
    $(document).ready(function() { 
          var owl = $("#bstseller ");
         
          owl.owlCarousel({
             
              itemsCustom : [
                [0, 1],
                [400,1],
                [450, 2],
                [600, 3],
                [700, 3],
                [1000, 4],
                [1200, 4],
                [1400, 4],
                [1600, 4]
              ],
              navigation : true
         
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
   

<?php include('footer.php'); ?>