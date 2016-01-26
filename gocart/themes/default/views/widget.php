<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo (!empty($seo_title)) ? $seo_title .' - ' : ''; echo $this->config->item('company_name'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if(isset($meta)):?>
	<?php echo $meta;?>
<?php else:?>
<meta name="Keywords" content="Shopping Cart, eCommerce, Code Igniter">
<meta name="Description" content="Go Cart is an open source shopping cart built on the Code Igniter framework">
<?php endif;?>
<?php echo theme_css('bootstrap.min.css', true);?>
<?php //echo theme_css('bootstrap.min-1.css', true);?>
<?php echo theme_css('bootstrap-responsive.min.css', true);?>
<?php echo theme_css('styles.css', true);?>
<?php echo theme_css('vallenato.css', true);?>
<?php echo theme_css('bootstrap-overide.css', true);?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

<?php // echo theme_js('jquery.js', true);?>
<?php echo theme_js('vallenato.js', true);?>
<?php echo theme_js('bootstrap.min.js', true);?>
<?php echo theme_js('squard.js', true);?>
<?php echo theme_js('equal_heights.js', true);?>
<!--
<?php echo theme_css('rmm-css/responsivemobilemenu.css', true);?>
<?php echo theme_js('rmm-js/responsivemobilemenu.js', true);?>
-->
<!--
<?php echo theme_js('../owl-carousel/iosOverlay.js', true);?>
<?php echo theme_js('../owl-carousel/modernizr-2.0.6.min.js', true);?>
-->
<?php echo theme_js('../owl-carousel/owl.carousel.js', true);?>

<?php echo theme_css('../owl-carousel/owl.carousel.css', true);?>
<?php echo theme_css('../owl-carousel/owl.transitions.css', true);?>
<?php echo theme_css('../owl-carousel/owl.theme.css', true);?>
<!--
<?php echo theme_css('../owl-carousel/iosOverlay.css', true);?>
-->
<?php
//with this I can put header data in the header instead of in the body.
if(isset($additional_header_info))
{
	echo $additional_header_info;
}

?>
<style>
    body{
         padding: 0 !important; 
    }
  
</style>
</head>
    <body>
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
        
<?php
$attributes = array('class' => 'navbar-search','target' => '_blank');
echo form_open('cart/search', $attributes);?>
        <label>88DB e-Grocery 88DB</label>
<input style="" type="text" name="term" id="autocomplete" class="input-sm searchCustom" placeholder="<?php echo lang('search');?>"/>
<input class="btn btn-success btn-sm" type="submit" value="Go" style="margin-top: .25rem;">
</form>

<xmp>
         <!--widget code--> 
         <iframe style="background-color: grey;" frameborder="0" scrolling="yes" height="70px" width="500px;" src="<?php echo base_url();?>widget"></iframe> 
     <!--widget code--> 
</xmp>

                                    
                                        
<!--footer-->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55185922-1', 'auto');
  ga('send', 'pageview');

</script>
<!--<iframe style="background-color: graytext;" frameborder="0" scrolling="yes" height="800px" width="100%" src="http://localhost/mayd/widget">test</iframe>--> 
</body>
</html>
<!--footer-->
                                      
