<?php include('header.php'); ?>
<div class="container" style="padding: 100px 0 240px 0;">
<?php if ($this->go_cart->total_items() == 0): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert">×</a>
        <?php echo lang('empty_view_cart'); ?>
    </div>
<?php else: ?>


    <div class="page-header clearfix">
        <div class="col-md-4">
        <h2><?php echo lang('your_cart'); ?></h2>
        </div>
    <?php echo form_open('cart/update_cart', array('id' => 'update_cart_form')); ?>
        <div class="col-md-8" style="text-align:right; padding-top:2rem">
            <!--<input class="btn btn-poppy btn-sm" type="submit" value="<?php echo lang('form_update_cart'); ?>"/>-->
            <a href="<?php echo site_url('cart/allproducts'); ?>" class="btn btn-success btn-sm"> Shop More </a>
            <?php if ($this->Customer_model->is_logged_in(false, false) || !$this->config->item('require_login')): ?>
                <input class="btn btn-sm btn-danger" type="submit" onclick="$('#redirect_path').val('checkout');" value="<?php echo lang('form_continue'); ?>"/>
            <?php endif; ?>
        </div>
    </div>

    <?php include('checkout/summary.php'); ?>

  
    <div class="row">
        <div class="col-md-8">
            <?php if (!$this->Customer_model->is_logged_in(false, false)): ?>
            <label class="alert alert-info"><?php echo lang('coupon_notification'); ?></label>
            <?php else: ?>
            <label><?php echo lang('coupon_label'); ?></label>
            <input type="text" name="coupon_code" class="txtbx-25">
            <input class="btn btn-info btn-sm" type="submit" value="<?php echo lang('apply_coupon'); ?>"/>
            <?php endif; ?>
            <?php if ($gift_cards_enabled): ?>
                <label style="margin-top:15px;"><?php echo lang('gift_card_label'); ?></label>
                <input type="text" name="gc_code" class="span3" style="margin:0px;">
                <input class="btn btn-info btn-sm"  type="submit" value="<?php echo lang('apply_gift_card'); ?>"/>
            <?php endif; ?>
        </div>
        <div class="col-md-4" style="text-align:right">
            <!--<input class="btn btn-poppy btn-sm" type="submit" value="<?php echo lang('form_update_cart'); ?>"/>-->
            <a href="<?php echo site_url('cart/allproducts'); ?>" class="btn btn-success btn-sm"> Shop More </a>
            <?php if ($this->Customer_model->is_logged_in(false, false) || !$this->config->item('require_login')): ?>
                <input class="btn btn-sm btn-danger" type="submit" onclick="$('#redirect_path').val('checkout');" value="<?php echo lang('form_continue'); ?>"/>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="text-align:center">
            <input id="redirect_path" type="hidden" name="redirect" value=""/>

            <?php if (!$this->Customer_model->is_logged_in(false, false)): ?>
                <input class="btn btn-primary" type="submit" onclick="$('#redirect_path').val('checkout/login');" value="<?php echo lang('login'); ?>"/>
                <input class="btn btn-primary" type="submit" onclick="$('#redirect_path').val('checkout/register');" value="<?php echo lang('register_now'); ?>"/>
            <?php endif; ?>

        </div>
    </div>
    
    <!-- <hr>
    <div class="row">
        <div class="col-xs-12 col-md-8">
        Disclaimer: Product photos and actual product upon delivery may vary. All products are guaranteed fresh.
        </div>
    </div> -->

    </form>
<?php endif; ?>
<div></div></div>
<?php include('footer.php'); ?>