<?php include('header.php'); ?>
<script type="text/javascript">
    
</script>

<style>
    .banner-inside{display: block;}
    .banner-home{display: none;}
</style>
<!--copy this to http://www.freedomjapanesemarket.com/suggest-a-japanese-product/--> 
<div class="page-title">
    <h1>New Product Suggestion Form</h1>
</div>

<div class="row">



    <div class="col-1">
        <p>Do you know of some great, yet hard to find Philippines products that you would like to share with the world?<span style="mso-spacerun: yes;">&nbsp; 
            </span>Now it is easy to become a contributor and share your knowledge of products sold in Philippines!
            <span style="mso-spacerun: yes;">&nbsp; </span>All you have to do is fill out the form on this page.
            <!--and if we choose your product idea, we will give you 25 appreciation points and credit you as the contributor.-->
        </p>
        <h2><strong>How to Submit a Product Idea</strong><strong></strong></h2>
        <ol>
            <li>
                <h3>Personal Profile</h3>
                <p>Please write your profile in the third person, add information as to why you are a credible contributor (Example: Bob has loved all things Philippines ever since he worked in the country five years ago.) and try not to exceed five sentences.&nbsp; If you are not comfortable using your real name, please feel free to use a nickname or pen name.</p>
                <p>Note: We may edit your profile, but will work hard to retain the essence of who you are.</p>
                <p>Hint: Please keep a copy of your profile on your computer, tablet or phone so you can copy and paste the information each time you submit an idea.&nbsp;</p>
            </li>
            <li>
                <h3>Product Description</h3>
                <p>First and foremost, make sure the description is accurate and honest.&nbsp; It is easy to get carried away and lean towards hyperbole, but this is not the goal.&nbsp; We are not interested in just making a sale; our goal is to share cool products sold in Philippines with the rest of the world.&nbsp;</p>
                <p>Please write in the third person and make sure to keep the readers&rsquo; concerns in mind. &nbsp;</p>
                <p>Note: Descriptions may be edited before being added to our site.</p>
            </li>
        </ol></div>


    <div class="std"><div class="col2-set">
            <?php if (validation_errors()): ?>
                <div class="alert alert-error" style="color: red;">
                    <a class="close" data-dismiss="alert">×</a>
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>
            <div class="col-2">
                <small>Why not give it a try?</small>
                <small>Take five minutes to fill out a New Product Suggestion Form below.</small>
                <div id="form_3_form">

                    <!--<form id="order_submit_form" action="<?php // echo site_url('checkout/place_order');        ?>" method="post">-->
                    <form class="form-maker" action="<?php echo site_url('form/suggest/post'); ?>" method="post" name="form_3" id="form_3" enctype="multipart/form-data" class="form-">
                        <div class="fieldset fieldset-3">
                            <h2 class="legend">New Product Suggestion</h2>
                            <div class="field form-field-">
                                <label for="field_16" class="required" class="label-">

                                    <em>*</em>
                                    Name				</label>
                            </div>
                            <div class="input-box input-box-" >

                                <input type='text' name='name' id='name' class='input-text required-entry validate-alpha' style='' placeholder="Juan Dela Cruz" 
                                       value="<?php echo (isset($name) && $name != '') ? $name : (set_value('name') != '') ? set_value('name') : ''; ?>"/>				</div>
                            <div class="field form-field-">
                                <label for="field_21" class="required" class="label-">
                                    <em>*</em>Email				</label>
                            </div>
                            <div class="input-box input-box-" >
<input type='text' name='email' id='email' class='input-text required-entry validate-email' style='' placeholder="email@email.com" value="<?php echo (isset($email) && $email != '') ? $email : (set_value('email') != '') ? set_value('email') : ''; ?>"/>				</div>
                            <div class="field form-field-">
                                <label for="field_15" class="required" class="label-"><em>*</em>Personal Profile</label>
                            </div>
                            <div class="input-box input-box-" >
                                <textarea name='personal_profile' id='personal_profile' rows="5" cols="25"  value="" placeholder="Tell me about your self." ><?php echo (set_value('personal_profile') != '') ? set_value('personal_profile') : ''; ?></textarea>
                            </div>
                            <div class="field form-field-">
                                <label for="product_desc" class="required" class="label-">

                                    <em>*</em>
                                    Product Name				</label>
                            </div>
                            <div class="input-box input-box-" >
                                <input type='text' name='product_name' id='product_name' class='input-text required-entry validate-email' style='' placeholder="Product name" 
                                       value="<?php echo (set_value('product_name') != '') ? set_value('product_name') : ''; ?>"/>	
                            </div>
                            <div class="field form-field-">
                                <label for="product_desc" class="required" class="label-">

                                    <em>*</em>
                                    Product Description				</label>
                            </div>
                            <div class="input-box input-box-" >
                                <textarea name='product_desc' id='product_desc' 
                                          value="" placeholder="Tell me about the product" class='input-text required-entry validate-alpha' 
                                          style='' rows="5" cols="25"><?php echo (set_value('product_desc') != '') ? set_value('product_desc') : ''; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="buttons-set">
                            <p class="required">* Required Fields</p>
                            <button type="submit" title="Submit" class="button"><span><span>Submit</span></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript"><!--
$(function() {
        $('.category_container').each(function() {
            $(this).children().equalHeights();
        });
    });
    //--></script>

<?php include('footer.php'); ?>