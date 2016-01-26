<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo (!empty($seo_title)) ? $seo_title .' - ' : ''; echo $this->config->item('company_name'); ?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Keywords" content="">
<?php if(isset($meta)):?>
	<meta name="Description" content="<?php echo $meta;?>">
<?php else:?>
<meta name="Description" content="">
<?php endif;?>

<!-- css files -->

<?php echo theme_css('bootstrap.css', true);?>
<?php echo theme_css('bootstrap.min.css', true);?>
<?php echo theme_css('nxled-newdesign.css', true);?>
<?php echo theme_css('new-design.css', true);?>

<!-- outsource files -->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>


<!-- js files -->

<?php //echo theme_js('bootstrap.js', true);?>
<?php echo theme_js('bootstrap.min.js', true);?>
<?php echo theme_js('jquery.js', true);?>
<?php echo theme_js('jquery-ui.js', true);?>
<?php echo theme_js('equal_heights.js', true);?>
<?php echo theme_js('squard.js', true);?>

<?php echo theme_js('../owl-carousel/owl.carousel.js', true);?>
<?php echo theme_css('../owl-carousel/owl.carousel.css', true);?>
<?php echo theme_css('../owl-carousel/owl.transitions.css', true);?>
<?php echo theme_css('../owl-carousel/owl.theme.css', true);?>

<?php
//with this I can put header data in the header instead of in the body.
if(isset($additional_header_info))
{
	echo $additional_header_info;
}
$redirect = $this->Customer_model->is_logged_in(false, false);
?>
</head>

<body>
	<div class="mid-navbar" id="navi-bg">
		<div class="container"  style="">
			<div class="row">
			<div class="col-md-3 logoCont">
				<a href="<?php echo site_url();?>"><img src="<?php 
				echo (gethostname() == 'PH-PC395') ? '' : base_url('gocart/themes/default/assets/images/logo.jpg'); ?>"></a>
			</div>
			<div class="col-md-9 searchCont">
				<div class="" style="margin-top:10px;">
					<a href="<?php echo site_url('cart/view_cart');?>" class="cart_headercount" style="text-decoration:none; ">
						<i class="fa fa-shopping-cart"></i>
		                <?php
			                if ($this->go_cart->total_items()==0){
			                    echo lang('empty_cart');
			                }
			                else{
			                    if($this->go_cart->total_items() > 1){
			                        echo sprintf (lang('multiple_items'), $this->go_cart->total_items());
			                    }
			                    else{
			                        echo sprintf (lang('single_item'), $this->go_cart->total_items());
			                    }
		                	}
		                ?>
					</a>
					<script>
	                    $(document).ready(function(){
	                        $('#autocomplete').autocomplete({
	                            source: function( request, response ) {
	                                $.ajax({
	                                    url : '<?php echo site_url('cart/search_auto');?>',
	                                    dataType: "json",
	                                  data: {
	                                     name_startsWith: request.term,
	                                     type: 'product'
	                                  },
	                                   success: function( data ) {
	                                       response( $.map( data, function( item ) {
	                                          return {
	                                              label: item,
	                                              value: item
	                                          }
	                                      }));
	                                  }
	                                });
	                            },
	                            autoFocus: true,
	                            minLength: 0          
	                        });
	                    });
	                </script>
                	<?php echo form_open('cart/search', 'class="search-cont navbar-search"');?>
						<input type="text" name="term" id="autocomplete" class="searchHead" placeholder="SEARCH"/>
					</form>
				</div>
				<div class="" style="margin-top:10px;">
					<nav class="navbar">
					    <!-- Brand and toggle get grouped for better mobile display -->
					    <div class="navbar-header">
					      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
					    </div>

					    <!-- Collect the nav links, forms, and other content for toggling -->
					    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					      <ul class="nav navbar-nav navbar-right">
					        <li><a href="<?php echo site_url();?>">Home</a></li>
					        <li><a href="<?php echo site_url().'cart/allproducts';?>">Services</a></li>
							<?php
								if($redirect){
							?>
					        <li><a href="<?php echo site_url('secure/my_account');?>">My Account</a></li>
					        <li><a href="<?php echo site_url('secure/logout');?>">Logout</a></li>
							<?php
								}
								else{
							?>
							<li><a href="<?php echo site_url('secure/login');?>">Login</a></li>
							<?php
								}
							?>
					        <!--
					        <?php foreach($this->pages as $menu_page):?>
					        <li>
					        	<?php if(empty($menu_page->content)):?>
									<a href="<?php echo $menu_page->url;?>" <?php if($menu_page->new_window ==1){echo 'target="_blank"';} ?>><?php echo $menu_page->menu_title;?></a>
								<?php else:?>
									<a href="<?php echo site_url($menu_page->slug);?>"><?php echo $menu_page->menu_title;?></a>
								<?php endif;?>
					        </li>
					        <?php endforeach;?>  -->
					      </ul>
					    </div><!-- /.navbar-collapse -->
					</nav>
				</div>
			</div> <!-- search cont -->
			</div>
			<!--
			<div class="col-md-3 cartCont">
				<a href="<?php echo site_url('cart/view_cart');?>" class="cart_headercount" style="text-decoration:none; ">
					                	<i class="glyphicon glyphicon-shopping-cart"></i>
					                <?php
					                if ($this->go_cart->total_items()==0)
					                {
					                    echo lang('empty_cart');
					                }
					                else
					                {
					                    if($this->go_cart->total_items() > 1)
					                    {
					                            echo sprintf (lang('multiple_items'), $this->go_cart->total_items());
					                    }
					                    else
					                    {
					                            echo sprintf (lang('single_item'), $this->go_cart->total_items());
					                    }
					                }
					                ?>
					                </a>
			</div>-->
		</div>
	</div><!-- mid navbar -->

<div class="container mainCont">

		<?php if ($this->session->flashdata('message')):?>
			<div class="alert alert-info">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $this->session->flashdata('message');?>
			</div>
		<?php endif;?>
		
		<?php if ($this->session->flashdata('error')):?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $this->session->flashdata('error');?>
			</div>
		<?php endif;?>
		
		<?php if (!empty($error)):?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $error;?>
			</div>
		<?php endif;?>
		