</div>



<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-10 footGrad" style="height:50px;box-sizing:border-box;text-indent: 0px; padding:10px;">
                <div class="clearfix row"  style="">
                    <span style="color: #0B0B3F; text-transform: uppercase;">&copy; iDesign <?php echo date('Y'); ?>. All Rights Reserved.</span>
                </div>
            </div>
            <div class="col-md-2" style="height:50px; padding:10px;">
                <div class="clearfix row soc-med-cont"  style="text-align:right;">
                    <a href="" target="_blank" title="Facebook" alt="Facebook Link">
                        <img src="<?php echo base_url('gocart/themes/default/assets/img/fb-icon.png'); ?>"  alt="" style="height:35px;"/>    
                    </a>
                    
                    <a href="" target="_blank" title="" alt="Twitter Link">
                        <img src="<?php echo base_url('gocart/themes/default/assets/img/twtr-icon.png'); ?>" alt="" style="height:35px;margin-left:15px;"/>    
                    </a>
                </div>
            </div>
        </div>       
    </div>
</footer>



<script type="text/javascript">
	$(window).load(function(){
		$('#pop_up_main').hide();
	});
    $(document).ready(function() {
		
    $("#txtboxToFilter").keydown(function (e) {
        
        if (((e.keyCode > 95 && e.keyCode < 106) ||
            (e.keyCode > 47 && e.keyCode < 58))  ||
         e.keyCode == 8 ||
         e.keyCode == 46 ||
         e.keyCode == 13 ||
         (e.keyCode == 107 || (e.keyCode == 187 && e.shiftKey == true)) ||
         (e.keyCode == 65 && e.ctrlKey == true) ||
         e.keyCode == 9) {
                 // let it happen, don't do anything
            return;
        } else {
            e.preventDefault();
        }
    });
});
</script>


</body>
</html>