<?php include('header.php');?>

<div class="container" style="padding-top: 2em">

	<div class="in-maincol">
		<?php echo html_entity_decode($page->content); ?>
	</div>

	<div class="in-sidecol">
		<!--<img src="<?php echo base_url('gocart/themes/default/assets/images/adspace_05.gif'); ?>" style="margin-top:0">
		
		<img src="<?php echo base_url('gocart/themes/default/assets/images/adspace_05.gif'); ?>">
		<img src="<?php echo base_url('gocart/themes/default/assets/images/adspace_05.gif'); ?>">
        -->
        <?php
        foreach($this->boxes as $box):
            $box_image	= '<img src="'.base_url('uploads/'.$box->image).'" />';
            if($box->link)
            {
                $target=false;
                if($box->new_window)
                {
                    $target=' target="_blank"';
                }
                echo '<a href="'.$box->link.'"'.$target.'>'.$box_image.'</a>';
            }
            else
            {
                echo $box_image;
            }
        endforeach;?>
	</div>


</div>
 


<?php include('footer.php');?>