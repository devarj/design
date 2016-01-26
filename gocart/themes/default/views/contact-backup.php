<form name="contact_form" action="" method="post">
    <div class="control-group">
        <label class="control-label" for="fullName">Full Name</label>
        <div class="controls">
            <input id="fullName" type="text" name="fullName" value="">
		</div>
    </div>
    <div class="control-group">
        <label class="control-label" for="yourCompany">Company</label>
            <div class="controls">
                <input id="yourCompany" type="text" name="yourCompany" value="">
			</div>
    </div>
    <div class="control-group">
        <label class="control-label" for="contactNumber">Contact Number</label>
            <div class="controls">
                <input id="contactNumber" type="text" name="contactNumber" value="">
			</div>
    </div>
    <div class="control-group">
        <label class="control-label" for="message">Message</label>
            <div class="controls textarea">
                <textarea id="message" name="message" rows="10"></textarea>
			</div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="ui-button ui-button-middle ui-button-main">Send</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        // Code for form validation
        $("form[name=contact_form]").validate({
            rules: {
				fullName: {
					required: true
				},
				yourCompany: {
					required: true
				}
				contactNumber: {
					required: true
				}
                message: {
                    required: true
                },
                address: {
                    required: true
                }
            },
            messages: {
				fullName: {
					required: "This field is required."
				}
                yourCompany: {
                    required: "This field is required."
                },
				contactNumber: {
                    required: "This field is required."
                },
                message: {
                    required: "This field is required."
                }
				address: {
                    required: "This field is required."
                },
            },
            errorLabelContainer: "#error_list",
            wrapper: "li",
            invalidHandler: function(form, validator) {
                $('html,body').animate({ scrollTop: $('h1').offset().top }, { duration: 250, easing: 'swing'});
            },
            submitHandler: function(form){
                $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
                form.submit();
            }
        });
    });
</script>