<?php

	
 include('header.php');
	?>

<script type="text/javascript">
    window.onload = function()
    {
        $('.product').equalHeights();
    }
</script>

<div class="" style="padding-top: 2em; min-height: 555px;">

    <!-- chad new revise -->
    <!--<div class="row">
        <div class="col-md-12 " style="padding:0px;border-bottom:1.5px solid #8cc43f;margin-bottom:100px;">

            <div class="prodImgCont">
                <div id="primary-img">
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

                                $photo = '<img class="responsiveImage" src="' . base_url('uploads/images/medium/' . $primary->filename) . '" alt="' . $product->seo_title . '"/>';
                            }
                            echo $photo
                        ?>
                </div>

                    <div class="prodImgThumb clearfix">
                        <?php if (count($product->images) > 1): ?>
                            <ul>
                                <?php foreach ($product->images as $image): ?>
                                    <li>
                                        <img onclick="$(this).squard('310', $('#primary-img'));" src="<?php echo base_url('uploads/images/medium/' . $image->filename); ?>"/>
                                    </li>
                                <?php endforeach; ?>
                            </ul><?php endif; ?>
                    </div>  <!-- prodImgThumb -->
        <!--
            <</div><!-- prodImgCont -->


            
          <!--
        </div><!-- col-md12 --><!--
    </div>-->

    <div class="row" style="">
        <div class="col-md-4">
            <div class="prodImgCont">

                <div id="primary-img">
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
                                $photo = '<img class="responsiveImage" src="' . base_url('uploads/images/medium/' . $primary->filename) . '" alt="' . $product->seo_title . '"/>';
                            }
                            echo $photo
                        ?>
                </div>
                <div class="prodImgThumb clearfix">

                    <?php if (count($product->images) > 1): ?>
                        <ul>
                            <?php foreach ($product->images as $image): ?>
                                <li>
                                    <img onclick="$(this).squard('310', $('#primary-img'));" src="<?php echo base_url('uploads/images/medium/' . $image->filename); ?>"/>
                                </li>
                            <?php endforeach; ?>
                        </ul><?php endif; ?>
                </div>  <!-- prodImgThumb -->
            </div><!-- prodImgCont -->
        </div>
        <div class="col-md-6">
            <div class="prodDescCont">
                <span style="font-size:0.9em;color:#c8c8c8;">Home > Products > <?php echo $product->name; ?></span><br><br>
                <?php if(!empty($base_url) && is_array($base_url)):?>
                    <!--<div class="row">
                        <div class="col-md-12">
                            <ul class="breadcrumb" style="margin-bottom:0">
                                <?php
                                $url_path   = '';
                                $count      = 1;
                                
                                foreach($base_url as $bc):
                                    $url_path .= '/'.$bc;
                                    if($count == count($base_url)):?>
                                        <li class="active"><?php echo ucwords(strtolower(str_replace('-', ' ', $bc)));?></li>
                                    <?php else:?>
                                        <li><a href="<?php echo site_url($url_path);?>"><?php echo ucwords(strtolower(str_replace('-', ' ', $bc)));?></a></li> <span class="divider glyphicon glyphicon-chevron-right"></span>
                                    <?php endif;
                                    $count++;
                                endforeach;?>
                            </ul>
                        </div> 
                    </div>-->
                <?php endif;?>
                <!--
                <div class="col-md-12 row-1">
                    <a href="<?php echo site_url();?>"><img src="<?php echo base_url('gocart/themes/default/assets/images/back-btn_03.gif'); ?>" class="back-btn"> Back to Products</a>
                </div>-->               

                <div class="">
                    <div class="prodTitle">
                        <?php echo $product->name; ?><br />
                        <span style="color:#fff;font-size: 0.6em;"><?php echo $product->sku; ?></span>
                                            
                    </div>

                        <?php if ($product->saleprice > 0): ?>
                           
                            <div class="prodPrice">
                                <strike style="font-size:0.8em;color:#c8c8c8;"><?php echo format_currency($product->price); ?></strike><br />
                                <span style="color:#8bc53f;"><?php echo format_currency($product->saleprice); ?><?php echo (empty($product->unit)) ? '' : '/' . $product->unit; ?></span>
                            </div>                                      
                        <?php else: ?>
                            <div class="prodPrice">
                                <span style="color:#8bc53f;"><?php echo format_currency($product->price); ?><?php echo (empty($product->unit)) ? '' : '/' . $product->unit; ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="prodDesc">
                             <div style="padding: 0; margin: 0; line-height: .5em;"><?php echo $product->description; ?></div>
                        </div>

                        
                </div>
            </div>  
        </div>
        <div class="col-md-2">
            <!-- add to cart col -->
                            <div class="prodAddCart"> 
                                    <?php echo form_open('cart/add_to_cart', 'class="form-horizontal"'); ?>
                                        <input type="hidden" name="cartkey" value="<?php echo $this->session->flashdata('cartkey'); ?>" />
                                            <input type="hidden" name="id" value="<?php echo $product->id ?>"/>
                                          
                                                <fieldset style="clear:both;">
                                                    <?php if (count($options) > 0): ?>
                                                        <?php
                                                        foreach ($options as $option):
                                                            $required = '';
                                                            if ($option->required)
                                                            {
                                                                $required = ' <p class="help-block">Required</p>';
                                                            }
                                                            ?>
                                                            <div class="control-group">
                                                                <label class="control-label"><?php echo $option->name; ?></label>
                                                                <?php
                                                                /*
                                                                  this is where we generate the options and either use default values, or previously posted variables
                                                                  that we either returned for errors, or in some other releases of Go Cart the user may be editing
                                                                  and entry in their cart.
                                                                 */

                                                                //if we're dealing with a textfield or text area, grab the option value and store it in value
                                                                if ($option->type == 'checklist')
                                                                {
                                                                    $value = array();
                                                                    if ($posted_options && isset($posted_options[$option->id]))
                                                                    {
                                                                        $value = $posted_options[$option->id];
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    if (isset($option->values[0]))
                                                                    {
                                                                        $value = $option->values[0]->value;
                                                                        if ($posted_options && isset($posted_options[$option->id]))
                                                                        {
                                                                            $value = $posted_options[$option->id];
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        $value = false;
                                                                    }
                                                                }

                                                                if ($option->type == 'textfield'):
                                                                    ?>
                                                                    <div class="controls">
                                                                        <input type="text" name="option[<?php echo $option->id; ?>]" value="<?php echo $value; ?>" class="textstuff"/>
                                                                        <?php echo $required; ?>
                                                                    </div>
                                                                <?php elseif ($option->type == 'textarea'): ?>
                                                                    <div class="controls">
                                                                        <textarea class="textstuff" name="option[<?php echo $option->id; ?>]"><?php echo $value; ?></textarea>
                                                                        <?php echo $required; ?>
                                                                    </div>
                                                                <?php elseif ($option->type == 'droplist'): ?>
                                                                    <div class="controls">
                                                                        <select class="form-control textstuff" name="option[<?php echo $option->id; ?>]">
                                                                            <option value=""><?php echo lang('choose_option'); ?></option>

                                                                            <?php
                                                                            foreach ($option->values as $values):
                                                                                $selected = '';
                                                                                if ($value == $values->id)
                                                                                {
                                                                                    $selected = ' selected="selected"';
                                                                                }
                                                                                ?>

                                                                                <option<?php echo $selected; ?> value="<?php echo $values->id; ?>">
                                                                                    <?php
                                                                                    echo($values->price != 0) ? '(' . format_currency($values->price) . ') ' : '';
                                                                                    echo $values->name;
                                                                                    ?>
                                                                                </option>

                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <?php echo $required; ?>
                                                                    </div>
                                                                    <?php
                                                                elseif ($option->type == 'radiolist'):
                                                                    ?>
                                                                    <div class="controls">
                                                                        <?php
                                                                        foreach ($option->values as $values):

                                                                            $checked = '';
                                                                            if ($value == $values->id)
                                                                            {
                                                                                $checked = ' checked="checked"';
                                                                            }
                                                                            ?>
                                                                            <label class="radio">
                                                                                <input<?php echo $checked; ?> type="radio" name="option[<?php echo $option->id; ?>]" value="<?php echo $values->id; ?>"/>
                                                                                <?php echo $option->name; ?> <?php
                                                                                echo($values->price != 0) ? '(' . format_currency($values->price) . ') ' : '';
                                                                                echo $values->name;
                                                                                ?>
                                                                            </label>
                                                                        <?php endforeach; ?>
                                                                        <?php echo $required; ?>
                                                                    </div>
                                                                    <?php
                                                                elseif ($option->type == 'checklist'):
                                                                    ?>
                                                                    <div class="controls">
                                                                        <?php
                                                                        foreach ($option->values as $values):

                                                                            $checked = '';
                                                                            if (in_array($values->id, $value))
                                                                            {
                                                                                $checked = ' checked="checked"';
                                                                            }
                                                                            ?>
                                                                            <label class="checkbox">
                                                                                <input<?php echo $checked; ?> type="checkbox" name="option[<?php echo $option->id; ?>][]" value="<?php echo $values->id; ?>"/>
                                                                                <?php
                                                                                echo($values->price != 0) ? '(' . format_currency($values->price) . ') ' : '';
                                                                                echo $values->name;
                                                                                ?>
                                                                            </label>

                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                    <?php echo $required; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>

                                                    <div class="control-group" style="text-align:left!important;">
                                                        <span class="frm-el-Cont" style="float:left;margin-top:10px;font-weight:600;font-size:1.2em;"><?php echo lang('quantity') ?>:</span>                                         
                                                            <?php if ($stock > 0) : ?>
                                                                <span class="frm-el-Cont">
                                                                    <select class="form-control textstuff" name="quantity">

                                                                    <?php for ($x = 1; $x <= $stock; $x ++): ?>
                                                                        <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                                    <?php endfor; ?>

                                                                    </select>
                                                                </span>
                                                     </div>
                                                    </div>

                                                            <?php endif; ?>
                                                            <div class="" style="padding-top: 1em; text-align:right; padding-left: 0; padding-right: 0">
                                                                <button href="#" type="submit" class="btn btn-nxled btn-sm pull-right" value="submit" style="text-transform:uppercase;"> Add To Cart </button>
                                                            </div>
                                                </fieldset>
												
                                                <input type="hidden" name="stock_id" value="<?php echo $product->stock_id; ?>" />
                                    </form>
                                 <!-- end of add to cart -->                    
        </div><!--col-md-2 -->
       
    </div>
 <br><br />
    <div class="row"><div class="col-md-12" style="border-bottom:1.5px solid #8ec343;"></div></div>

    <!-- Featured Products --><!--
    <br /><br />
    <div class="row">
        <div class="col-md-12" style="box-sizing: border-box;">
            <h3>PEOPLE ALSO VIEWED</h3>
            <div class="prod-col clearfix" style="margin-top:20px;">
            <?php for($x=0;$x<5;$x++){?>
                <div class="feat-item">
                    <div class="prod-img" style="background: url('http://192.21.0.57/prod/nxled2/uploads/images/medium/f20da6853b79d9d8fcfc6ee2f9f5f873.png') center / contain no-repeat #fff;">
                        <a href="http://192.21.0.57/prod/nxled/outdoor-lighting/security-light-w-sensor6">
                            <img src="http://192.21.0.57/prod/nxled2/gocart/themes/default/assets/images/blank.png">
                        </a>
                    </div>
                    <div class="prod-desc">
                        <div class="prod-title">
                            <a href="http://192.21.0.57/prod/nxled2/outdoor-lighting/security-light-w-sensor6">SECURITY LIGHT w/ SENSOR</a>
                            <span class="title-sku"> ANX-EL401AC </span>
                        </div>

                      <div class="prod-priceCont clearfix">
                          <div class="col-md-12" style="text-align: right">
                            <span class="prod-price"><b>PHP 4,599.75/PC</b></span>
                          </div>
                      </div>
                      <a href="#" class="btn btn-nxled btn-sm pull-right" style="text-transform:uppercase;"> Add To Cart </a>
                    </div><!-- prod-desc -->
               <!-- </div>
              <?php }?>
            </div>
        </div>
    </div
    <!-- Featured Products -->
    <div class="row">
      <div class="col-md-12" style="margin-top: 20px;">
                <!-- related products -->
                    <div class="related-ulist related clearfix">
                        <?php if (!empty($product->related_products)): ?>   
                                <!-- <h3><?php echo lang('related_products_title'); ?></h3> -->
                                <h3 class="" style="margin-top: 10px;margin-bottom:20px;">PEOPLE ALSO VIEWED</h3>
                                

                                <div id="similar" class="owl-carousel owl-theme">                       

                                        <?php foreach ($product->related_products as $relate): ?>
                                         <div class="related-item">
                                            <?php
                                            $photo = theme_img('no_picture.png', lang('no_image_available'));
                                            $relate->images = array_values((array) json_decode($relate->images));

                                            if (!empty($relate->images[0]))
                                            {
                                                $primary = $relate->images[0];
                                                foreach ($relate->images as $photo)
                                                {
                                                    if (isset($photo->primary))
                                                    {
                                                        $primary = $photo;
                                                    }
                                                }

                                                $photo = '<img src="' . base_url('uploads/images/thumbnails/' . $primary->filename) . '" alt="' . $relate->seo_title . '"/>';
                                                $photo_url = base_url('uploads/images/small/' . $primary->filename);
                                            }
                                            ?>
                                            <a href="<?php echo site_url($relate->slug); ?>">
                                                <div class="sml-img" style="background: url('<?php echo $photo_url; ?>') center / contain no-repeat #fff;">
                                                    <img src="<?php echo base_url('gocart/themes/default/assets/images/relatedblank.png'); ?>">
                                                </div>
                                            </a>
                                            <div class="prod-desc">
                                                <div class="prod-title">
                                                    <a href="<?php echo site_url($relate->slug); ?>"><?php echo $relate->name; ?></a>
                                                    <span class="title-sku"> <?php echo $relate->sku; ?> </span>
                                                </div>

                                                
                                              <?php if ($relate->saleprice > 0):?>
                                                  <div class="prod-priceCont clearfix" style="text-align:right; padding-top:0px!important; line-height:1.1em;">
                                                      <span class="prod-sale"><b><?php echo format_currency($relate->price); ?><?php echo (empty($b->unit))?'':'/'.$relate->unit; ?></b></span><br/>
                                                      <span class="prod-price"><b><?php echo format_currency($relate->saleprice); ?><?php echo (empty($b->unit))?'':'/'.$relate->unit; ?></b></span>
                                                      <a href="<?php echo site_url(implode('/', $base_url).'/'.$b->slug); ?>" class="btn btn-nxled btn-sm pull-right" style="margin-top:7px;text-transform:uppercase;"> Add To Cart </a>
                                                  </div>
                                              <?php else:
                                                  ?>
                                                  <div class="prod-priceCont clearfix" style="text-align:right;">
                                                    <span class="prod-price"><b><?php echo format_currency($relate->price); ?><?php echo (empty($relate->unit))?'':'/'.$relate->unit; ?></b></span>
                                                    <a href="<?php echo site_url(implode('/', $base_url).'/'.$b->slug); ?>" class="btn btn-nxled btn-sm pull-right" style="margin-top:7px;text-transform:uppercase;"> Add To Cart </a>
                                                  </div>
                                              <?php endif;?>
                                            </div><!-- prod-desc -->
                                        </div>
                                        <!--
                                        <div class="item">
                                            <?php
                                            $photo = theme_img('no_picture.png', lang('no_image_available'));
                                            $relate->images = array_values((array) json_decode($relate->images));

                                            if (!empty($relate->images[0]))
                                            {
                                                $primary = $relate->images[0];
                                                foreach ($relate->images as $photo)
                                                {
                                                    if (isset($photo->primary))
                                                    {
                                                        $primary = $photo;
                                                    }
                                                }

                                                $photo = '<img src="' . base_url('uploads/images/thumbnails/' . $primary->filename) . '" alt="' . $relate->seo_title . '"/>';
                                                $photo_url = base_url('uploads/images/small/' . $primary->filename);
                                            }
                                            ?>

                                            <div class="sml-img" style="background: url('<?php echo $photo_url; ?>') center / contain no-repeat #fff;">
                                                <a href="<?php echo site_url($relate->slug); ?>">
                                                    <img src="<?php echo base_url('gocart/themes/default/assets/images/relatedblank.png'); ?>">
                                                </a>
                                            </div>

                                            <div class="sml-desc col-md-12">
                                                <div class="title">
                                                    <a href="<?php echo site_url($relate->slug); ?>"><?php echo $relate->name; ?></a>
                                                    <span class="title-sku"> *SKU here* </span>
                                                </div>

                                                <div class="feat-price clearfix">                                         
                                                  <?php if ($b->saleprice > 0):?>
                                                  <div class="col-md-6">                                          
                                                      <span class="sale"><b><?php echo format_currency($relate->saleprice); ?></b></span>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <span class="price"><b><?php echo format_currency($product->price); ?></b></span>
                                                      </div>
                                                  <?php else:?>
                                                  <div class="col-md-12" style="padding: 0; text-align: right">
                                                      <span class="price"><b><?php echo format_currency($relate->price); ?></b></span>
                                                    </div>
                                                  <?php endif;?>
                                                      </div>
                                            </div>

                                        </div> <!-- item -->

                                        <?php endforeach; ?>
                                </div>
                                 <?php endif; ?>
                    </div>
       </div>
            <!-- related products -->
    </div>
</div>
</div>



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

<script type="text/javascript"><!--
$(function() {
        $('.category_container').each(function() {
            $(this).children().equalHeights();
        });
    });
//--></script>

<script type="text/javascript">
$("#slideshow > div:gt(0)").hide();

setInterval(function() { 
  $('#slideshow > div:first')
    .fadeOut(5000)
    .next()
    .fadeIn(5000)
    .end()
    .appendTo('#slideshow');
},  7000);
</script>

<script type="text/javascript">
$("#slideshow2 > div:gt(0)").hide();

setInterval(function() { 
  $('#slideshow2 > div:first')
    .fadeOut(8000)
    .next()
    .fadeIn(8000)
    .end()
    .appendTo('#slideshow2');
},  10000);
</script>

<?php include('footer.php'); ?>