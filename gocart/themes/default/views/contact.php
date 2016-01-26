<?php include('header.php');?>
<style>
	.banner-home{display: block;}
	.bub{display: block;}
	.headerMargin{margin-top:2rem}
</style>

<div class="row">

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
    <div class="col-md">

    <?php if(validation_errors()): ?>
    	<div class="alert alert-success">
    	<a class="close" data-dismiss="alert">×</a>
    	<?php echo validation_errors(); ?>
    	</div>
    <?php endif;?>

    <?php if(isset($success)):?>
    <div class="alert alert-success"><a class="close" data-dismiss="alert">×</a><?php echo $success;?></div>
	<?php endif;?>

    
    
    	<!-- ojt emil -->
    	<div class="col-md-11">
    	<div class="alert alert-success" role="alert" style="border-radius: 0; border-color: #379324; padding: 10px 20px 10px 20px; text-align: justify;">
				As we do our best to provide convenience to our shoppers, we welcome everyone who would like to share their products with us. If you want your items to be sold here at eGrocery, fill out the form below and we'll reach out to you the soonest time possible.
		</div>
    	<div class="panel panel-default" style="border-radius: 0;">
			<div class="panel-heading" style="background-color: #f39c12; border-radius: 0;">
				<h3 class="panel-title" style="color:#ffffff;">Supplier Registration</h3>
			</div>
			<div class="panel-body">
			<!-- form -->
		    	<?php echo form_open('cart/supplier', 'class="form-horizontal"'); ?>
					<div class="form-group">
				    	<label for="fullname" class="col-sm-offset-1 col-sm-2 control-label" style="text-align: left;">Full Name: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control input-sm" id="fullname" placeholder="Full Name" style="border-radius: 0;">
				    	</div>
				  	</div>
				 	<div class="form-group">
				    	<label for="Company" class="col-sm-offset-1 col-sm-2 control-label" style="text-align: left;">Company: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control input-sm" id="Company" placeholder="Company" style="border-radius: 0;">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="contact" class="col-sm-offset-1 col-sm-2 control-label" style="text-align: left;">Contact No.: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control input-sm" id="contact" placeholder="Contact No." style="border-radius: 0;">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="address" class="col-sm-offset-1 col-sm-2 control-label" style="text-align: left;">Address: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control input-sm" id="address" placeholder="Address" style="border-radius: 0;">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="message" class="col-sm-offset-1 col-sm-2 control-label" style="text-align: left;">Message: </label>
				    	<div class="col-sm-8">
				      		<textarea class="form-control input-sm" rows="3" style="border-radius:0;"></textarea>
				    	</div>
				  	</div>
				  	 <div class="form-group">
					    <div class="col-sm-offset-3 col-sm-8">
					    	<button type="submit" class="btn btn-radical btn-sm pull-right">Submit</button>
						</div>
					</div>
				</form>
				<!-- end of form -->
		  	</div>
		</div>
    	
		</div>

				    

		<input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
		<input type="hidden" value="submitted" name="submitted"/>
				    
    <!-- form -->
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

</div> <!-- row -->
<?php include('footer.php');?>