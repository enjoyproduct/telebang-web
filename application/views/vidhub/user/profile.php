<?php $this->load->view(THEME_VM_DIR.'/includes/header'); ?>
<script>
	var page 	= <?php echo $page ?>;
	var perPage = <?php echo $perPage ?>;
</script>
<div id="is-content" class="is-content user-content" data-is-full-width="true">
	<div class="banner-box" style="background-image: url('<?php echo getAvatarPath($user['Avatar']); ?>');">
		<div class="box-infor">
			<div class="container">
				<div class="banner-info clearfix">
					<div class="avatar" >
						<label  for="avatar_file" >
							<div class="img-avarta">
								<img id="img_avatar" src="<?php echo getAvatarPath($user['Avatar']); ?>" alt="">
							</div>
						</label>
						<input type="file" name="Avatar_file"  class="hidden" id="avatar_file" value=""/>
						<div class="action_change" style="display: none;">
							<button  id="submit_avatar" hidden name="submit_avatar" class="" ><i class="fa fa-check" aria-hidden="true"></i></button> 
							<button id="unsubmit_avatar" hidden name="unsubmit_avatar" class="" ><i class="fa fa-times" aria-hidden="true"></i></button> 
						</div>
					</div>
					<h2>
						<?php echo $user['FirstName'] ?> <?php echo $user['LastName'] ?> 
						<div class="col-right">
							<a href="http://inspius.com/" class="btn">
								<i class="fa fa-play-circle" aria-hidden="true"></i>
								SUBSCRIBE
							</a>
						</div>
					</h2>
				</div>
				<div class="row">
					<div class="col-sm-10 col-sm-offset-2">
						<div class="tab-title">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist"><!-- 
							    <li role="presentation" ><a href="#saveVideo" aria-controls="saveVideo" role="tab" data-toggle="tab">SAVED VIDEO </a></li>
							    <li role="presentation"><a href="#playlist" aria-controls="playlist" role="tab" data-toggle="tab">PLAYLISTS</a></li> -->
							   
							    <li role="presentation" class="active"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"> PROFILE</a></li>
							     <li role="presentation"><a href="#myvideo" aria-controls="myvideo" role="tab" data-toggle="tab">MY VIDEOS </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="tab-user">
			<!-- Tab panes -->
			<div class="tab-content"><!-- 
			    <div role="tabpanel" class="tab-pane " id="saveVideo">SAVED</div>
			    <div role="tabpanel" class="tab-pane" id="playlist">PLAYLISTS</div> -->
			    <div role="tabpanel" class="tab-pane" id="myvideo">
			    	<div class="box-content">
			    		<div class="row">
			    			<div class="section list-category">
								<h4>
									<?php 
										if ($message)
											echo $message;
									?>
								</h4>
								<div class="row" id="listvideo">
									<?php 
										foreach ($listVideos as $value) {
									?>
										<div class="col-sm-4">
											<div class="item-video clearfix">
												<div class="video-image">
													<a href="<?php echo $value['videoDetailPath'] ?>">
														<img src="<?php echo $value['VideoImage'] ?>" alt="">
													</a>
												</div>
												<div class="video-infor clearfix">
													<h5><a href="<?php echo $value['videoDetailPath'] ?>"><?php echo $value['VideoTitle'] ?></a></h5>
													<div class="video-action">
														<div class="view">
															<i class="fa fa-eye" aria-hidden="true"></i>
															<span><?php echo $value['ViewCount'] ?></span>
														</div>
														<div class="wishlist">
															<i class="fa fa-heart" aria-hidden="true"></i>
															<span><?php  echo $value['likedCounter'] ?></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php
										}
									?>
								</div>
								<button class="loadmore" id="loadmore">LOAD MORE</button>
							</div>
			    		</div>
			    	</div>
			    </div>
			    <div role="tabpanel" class="tab-pane active" id="settings">
			    	<div class="row">
			    		<div class="col-sm-3">
			    			<ul class="nav nav-tabs" role="tablist">
							    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Overview</a></li>
							    <li role="presentation"><a href="#changePass" aria-controls="changePass" role="tab" data-toggle="tab">Change Password</a></li>
							</ul>
			    		</div>
			    		<div class="col-sm-9">
			    			<div class="tab-content">
			    				
							    <div role="tabpanel" class="tab-pane active" id="profile">
							    	<h2>Profile</h2>
							    	<?php echo form_open_multipart(THEME_CONTROLLER_PATH.'/user/setting', array('role' => 'form')); ?>
							    		<?php
											if (isset($txtSuccess))
												echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
											elseif (isset($txtError))
												echo '<p class="alert alert-danger">' . $txtError . '</p>';
										?>
							    		<div class="row">
							    			<input type="text" class="form-control hidden" value="2" name="StatusId">
							    			<input type="text" class="form-control hidden" value="3" name="RoleId">
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3">
								    				<label for="">FirstName</label>
								    			</div>
								    			<div class="col-sm-5">
								    				<input type="text" class="form-control" value="<?php echo $user['FirstName'] ?>" name="FirstName">
								    			</div>
							    			</div>
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3">
								    				<label for="">LastName</label>
								    			</div>
								    			<div class="col-sm-5">
								    				<input type="text" value="<?php echo $user['LastName']; ?>" class="form-control" name="LastName"/>
								    			</div>
							    			</div>
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3">
								    				<label for="">Email</label>
								    			</div>
								    			<div class="col-sm-5">
								    				<input type="email" value="<?php echo $user['Email']; ?>" class="form-control" name="Email"/>
								    			</div>
							    			</div>
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3">
								    				<label for="">Address</label>
								    			</div>
								    			<div class="col-sm-5">
								    				<textarea class="form-control" rows="2" name="Address"><?php echo $user['Address']; ?></textarea>
								    			</div>
							    			</div>
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3">
								    				<label for="">PhoneNumber</label>
								    			</div>
								    			<div class="col-sm-5">
								    				<input type="text" value="<?php echo $user['PhoneNumber']; ?>" class="form-control" name="PhoneNumber" />
								    			</div>
							    			</div>
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3">
								    				<label for="">City</label>
								    			</div>
								    			<div class="col-sm-5">
								    				<input type="text" value="<?php echo $user['City']; ?>" class="form-control" name="City" />
								    			</div>
							    			</div>
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3">
								    				<label for="">Country</label>
								    			</div>
								    			<div class="col-sm-5">
								    				<input type="text" value="<?php echo $user['Country']; ?>" class="form-control" name="Country" />
								    			</div>
							    			</div>
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3"></div>
								    			<div class="col-sm-5">
								    				<input type="submit" class="btn" name="submit"  value="Change" id="btn-profile" >
								    			</div>
							    			</div>
							    		</div>
							    	<?php echo form_close(); ?>
							    </div>
							    <div role="tabpanel" class="tab-pane " id="changePass">
							    	<h2>Change Password</h2>
							    	<form method="post">
							    		<div class="alert alert-danger" style="display: none;">
											<div id="value"></div>
										</div>
										<div class="alert alert-success" style="display: none;">
											<div id="value"></div>
										</div>
							    		<div class="row">
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3">
								    				<label for="">Old Password</label>
								    			</div>
								    			<div class="col-sm-5">
								    				<input type="password" class="form-control" id="old_password" value="" name="old_password">
								    			</div>
							    			</div>
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3">
								    				<label for="">New Password</label>
								    			</div>
								    			<div class="col-sm-5">
								    				<input type="password" class="form-control" id="new_password" name="new_password">
								    			</div>
							    			</div>
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3">
								    				<label for="">Retype Password</label>
								    			</div>
								    			<div class="col-sm-5">
								    				<input type="password" class="form-control" id="re_password" name="re_password">
								    			</div>
							    			</div>
							    			<div class="form-group clearfix">
								    			<div class="col-sm-3"></div>
								    			<div class="col-sm-5">
								    				<input type="submit" class="btn"  value="Change" id="changepass" >
								    			</div>
							    			</div>
							    		</div>
							    	</form>
							    </div>
							</div>
			    		</div>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
// Ajax post
	$(document).ready(function() {
	    $("#changepass").click(function(event){
	    	event.preventDefault();
	    	var user_id = <?php echo $user['UserId'] ?>;
	    	var oldpass = $("input#old_password").val();
	    	var newpass = $("input#new_password").val();
	    	var repass = $("input#re_password").val();

	    	if (newpass != repass){
	    		jQuery("div.alert-danger").show();
		    	jQuery("div.alert-success").hide();
		        jQuery("div#value").html("Passwords do no match!");
	    	}else{
			    jQuery.ajax({
		    		type: "POST",
		    		url: "<?php echo base_url(THEME_VM_DIR.'/auth/change_password'); ?>",
		    		dataType: 'json',
		    		data: {
		    			user_id: user_id,
		    			old_password: oldpass,
		    			new_password: newpass
		    		},
		    		success: function(res){
		    			var code = res.code;
			            jQuery("div#value").html(res.message);
		    			console.log(res);
		    			if (code > 0) {
		    				jQuery("div.alert-success").show();
		    				jQuery("div.alert-danger").hide();
		    				location.reload();
		    			}else{
		    				jQuery("div.alert-danger").show();
		    				jQuery("div.alert-success").hide();
		    			}
		    			jQuery("div#value").html(res.message);
		    		}
		    	});
		    }
	    });
	    var formData;
	    function readURL(input) {

	    if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#img_avatar').attr('src', e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#avatar_file").change(function(){
		    readURL(this);
		    formData = new FormData();
		    formData.append('avatar',$(this)[0].files[0]);
			formData.append('user_id','<?php echo $user['UserId'] ?>');
		    $('#submit_avatar').attr('hidden',false);
		    $('#unsubmit_avatar').attr('hidden',false);
		    $('.action_change').show();
		});

		$('#submit_avatar').click(function(){
			$.ajax({
				type:'POST',
				url:"<?php echo base_url(THEME_CONTROLLER_PATH.'/auth/change_avatar'); ?>",
				contentType: false,
				processData: false,
				data:formData,
				success:function(res){
					location.reload();
				}
			});
		});
		$('#unsubmit_avatar').click(function(){
			location.reload();
		});
			$('#loadmore').click(function(){
			$.ajax({
				url:"<?php echo base_url(THEME_CONTROLLER_PATH.'/user/loadMore'); ?>" + '/' + (page + 1) + '/' + perPage,
				type:'GET',
				success:function(res){
					res = JSON.parse(res);
					var htmlAppend = '';
					if(res) {
						for(var i=0,len = res.length;i<len;i++) {
							htmlAppend += '<div class="col-sm-4">';
							htmlAppend += '<div class="item-video clearfix">';
							htmlAppend += '<div class="video-image">';
							htmlAppend += '<a href="'+ res[i].videoDetailPath +'">';
							htmlAppend += '<img src="'+ res[i].VideoImage +'" alt=""></a></div>';
							htmlAppend += '<div class="video-infor clearfix">';
							htmlAppend += '<h5><a href="'+ res[i].videoDetailPath +'">'+ res[i].VideoTitle +'</a></h5>';
							htmlAppend += '<div class="video-action"><div class="view">';
							htmlAppend += '<i class="fa fa-eye" aria-hidden="true"></i>';
							htmlAppend += '<span>'+ res[i].ViewCount +'</span></div>';
							htmlAppend += '<div class="wishlist">';
							htmlAppend += '<i class="fa fa-heart" aria-hidden="true"></i>';
							htmlAppend += '<span>'+ res[i].likedCounter +'</span>';
							htmlAppend += '</div></div></div></div></div>';
						}
						htmlAppend += '';
					}
				$('#listvideo').append(htmlAppend);
				htmlAppend = '';
				console.log(page);
				page = page + 1;
				console.log(page);
				}
			});
		});
	});

	
</script> 
<?php $this->load->view(THEME_VM_DIR.'/includes/footer'); ?>
