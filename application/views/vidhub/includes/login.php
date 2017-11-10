<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
	Login / Register
</button>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
		    <div class="modal-body">
		        <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">Login</a></li>
				    <li role="presentation"><a href="#register" aria-controls="register" role="tab" data-toggle="tab">Register</a></li>
			  	</ul>
			  	<!-- Tab panes -->
			  	<div class="tab-content clearfix">
				    <div role="tabpanel" class="tab-pane active" id="login">
				    	<!-- <span>LOGIN WITH SOCIAL ACCOUNT</span> -->
				    	<!-- <div class="social-login clearfix">
				    		<a href="" class="btn-facebook" > <i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>
				    		<a href="" class="btn-google" > <i class="fa fa-google-plus" aria-hidden="true"></i> Google</a>
				    	</div> -->
				    	<form method="post"  accept-charset="utf-8">
				    		<div class="alert alert-danger" style="display: none;">
								<div id="value"></div>
							</div>
							<div class="alert alert-success" style="display: none;">
								<div id="value"></div>
							</div>
					    	<div class="form-group form-input">
					    		<i class="fa fa-user" aria-hidden="true"></i>
								<input id="username" class="form-control" type="text" placeholder="Username" name="username" required />
							</div>
							<div class="form-group form-input">
								<i class="fa fa-unlock-alt" aria-hidden="true"></i>
								<input id="password" class="form-control" type="password" placeholder="Password" required name="password" /> 
							</div>
							<div class="form-actions form-submit">
								<input type="submit" name="submit" value="Login" class="submit btn btn-login"/>
								<button type="button" class="btn btn-forgot" data-toggle="modal" data-target="#fogotPass">
									FORGOT PASSWORD?
								</button>
							</div>
				    	</form>
				    </div>
				    <div role="tabpanel" class="tab-pane" id="register">
				    	<!-- <span>REGISTER WITH SOCIAL ACCOUNT</span> -->
					    	<!-- <div class="social-login clearfix">
					    		<a href="" class="btn-facebook" > <i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>
					    		<a href="" class="btn-google" > <i class="fa fa-google-plus" aria-hidden="true"></i> Google</a>
					    	</div> -->
				    	<form method="post" >
							<div class="alert alert-danger" style="display: none;">
								<div id="value"></div>
							</div>
							<div class="alert alert-success" style="display: none;">
								<div id="value"></div>
							</div>
					    	<div class="form-group form-input">
					    		<i class="fa fa-user" aria-hidden="true"></i>
								<input id="user_name" class="form-control" type="text" placeholder="Username" name="username" required />
							</div>
							<div class="form-group form-input">
								<i class="fa fa-lock" aria-hidden="true"></i>
								<input id="password_register" class="form-control" type="password" placeholder="Password" required name="password" /> 
							</div>
							<div class="form-group form-input">
								<i class="fa fa-lock" aria-hidden="true"></i>
								<input id="confirm_pass" class="form-control" type="password" placeholder="Confirm Password" required name="confirmpass" /> 
							</div>
							<div class="form-group form-input">
								<i class="fa fa-envelope-o" aria-hidden="true"></i>
								<input id="email" class="form-control"  type="email" pattern="[^ @]*@[^ @]*" placeholder="Email" required name="email" /> 
							</div>
							<div class="form-actions form-submit">
								<input type="submit" name="submit" value="Register" id="btnregister" class="btn btn-login"/>
								<button type="button" class="btn btn-forgot" data-dismiss="modal">Close</button>
							</div>
						</form>
				    </div>
			  	</div>
		    </div>
	    </div>
  	</div>
</div>
<div class="modal fade" id="fogotPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content clearfix">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><</span></button>
		        <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
		    </div>
		    <form method="post" >
		    	<div class="alert alert-danger" style="display: none;">
					<div id="value"></div>
				</div>
				<div class="alert alert-success" style="display: none;">
					<div id="value"></div>
				</div>
		    	<div class="clearfix">
				    <div class="modal-body">
				        <div class="form-group form-input">
							<i class="fa fa-envelope-o" aria-hidden="true"></i>
							<input id="emailfogot" class="form-control" type="text" placeholder="Enter your email here"  value="" name="emailfogot" /> 
						</div>
				    </div>
				    <div class="modal-footer pull-left ">
				        <button type="submit" class="btn btn-send" id="sendemail" class="sendemail">Save</button>
				        <button type="button" class="btn btn-forgot" data-dismiss="modal">Close</button>
				    </div>
		    	</div>
		    </form>
	    </div>
  	</div>
</div>



<script type="text/javascript">
// Ajax post
	$(document).ready(function() {
	    $(".submit").click(function(event) {
		    event.preventDefault();
		    var user_name = $("input#username").val();
		    var password = $("input#password").val();
		    var url = "<?php echo base_url('index.php/'.THEME_CONTROLLER_PATH.'/auth/login'); ?>";
		    console.log(url);
		    jQuery.ajax({
		        type: "POST",
		        url: url,
		        dataType: 'json',
		        data: {
		        	username: user_name,
		        	password: password
		        },
		        success: function(res) {
		        	console.log(res);
		        	var message = res.message;
		            if (message == "Login Successflly!")
		            {
		            	location.reload();
		            }else{
		            	jQuery("div.alert-danger").show();
						jQuery("div#value").html(res.message);
		            }
		        },
		        complete: function(res) {
		        	// console.log(res);
		        	// alert('complete');
		        }

	        });
	    });
	    $(".btn-forgot").click(function(e){
	    	e.preventDefault();
	    	$('#myModal').hide();
	    	$('.modal-backdrop').hide();
	    });
	    $(".close").click(function(e){
	    	e.preventDefault();
	    	$('#myModal').show();
	    	$('#fogotPass').hide();
	    	$('.modal-backdrop').hide();
	    });

	    $("#sendemail").click(function(event){
	    	event.preventDefault();
	    	var email = $("#emailfogot").val();
	    	jQuery.ajax({
	    		type: "POST",
	    		url: "<?php echo base_url('/api/forgot_password'); ?>",
	    		dataType: 'json',
	    		data: {
	    			email: email
	    		},
	    		success: function(res){
	    			var code = res.code;
		            if (code > 0)
		            {
		            	jQuery("div.alert-success").show();
		            }else{
		            	jQuery("div.alert-danger").show();
		            }

		            jQuery("div#value").html(res.message);
	    		}
	    	});
	    });
	    $("#btnregister").click(function(event){
	    	event.preventDefault();
	    	var username = $("input#user_name").val();
	    	var password = $("input#password_register").val();
	    	var confirmpass = $("input#confirm_pass").val();
	    	var email = $("input#email").val();

	    	if (password != confirmpass){
		        jQuery("div.alert-danger").show();
		        jQuery("div.alert-success").hide();
		        jQuery("div#value").html("Passwords do no match!");
	    	}else{
	    		jQuery("div.alert-success").show();
	    		jQuery("div.alert-danger").hide();
		        jQuery("div#value").html("Passwords match!");
		        var url = "<?php echo base_url('index.php/'.THEME_CONTROLLER_PATH.'/auth/register'); ?>";
			    jQuery.ajax({
		    		type: "POST",
		    		url: url,
		    		dataType: 'json',
		    		data: {
		    			username: username,
		    			password: password,
		    			email: email
		    		},
		    		success: function(res){
		    			console.log(res);
		    			var code = res.code;
			            jQuery("div#value").html(res.message);
		    			if (code > 0) {
			        		location.reload();
		    			}else{
			        		jQuery("div#value").html(res.message);
		    			}
		    		}, 
		    		complete: function(res) {
		    			// console.log('complete');
		    		}
		    	});
		    }
	    });
	});
</script>   