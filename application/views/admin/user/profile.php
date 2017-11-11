<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<?php 
	    $head['headTitle'] = sprintf("%s - YoBackend", 'Profile');
	    $this->load->view('admin/includes/head',$head);
	 ?>
	<body class="profile">
		<?php $this->load->view('admin/includes/header'); ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<div class="page-content">
						<h1 class="page-header">User Profile</h1>
						<?php
						if (isset($txtSuccess))
							echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
						elseif (isset($txtError))
							echo '<p class="alert alert-danger">' . $txtError . '</p>';
						?>
						<!-- END PAGE HEADER-->
						<div class="row">
							<div class="col-md-4">
								<img src="<?php echo empty($user['Avatar']) ? 'assets/pages/media/profile/profile_user.jpg' : USER_PATH . $user['Avatar']; ?>" class="img-responsive" alt="">

								<h4><?php echo $user['FirstName'] . ' ' . $user['LastName']; ?></h4>
								<span class="text-muted"><?php echo $user['UserName']; ?></span>
							</div>
							<div class="col-md-8">
								<div class="tab-profile">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#tab_1_1" data-toggle="tab">Personal Info</a>
										</li>
										<!--<li>
											<a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
										</li>-->
										<li>
											<a href="#tab_1_3" data-toggle="tab">Change Password</a>
										</li>
										<!--<li>
											<a href="#tab_1_4" data-toggle="tab">Privacy Settings</a>
										</li>-->
									</ul>
									<div class="tab-content">
										<!-- PERSONAL INFO TAB -->
										<div class="tab-pane active" id="tab_1_1">
											<?php echo form_open_multipart('index.php/admin/user/profile', array('role' => 'form')); ?>
											<!--<form role="form" action="#">-->
											<div class="row">
												<div class="form-group col-sm-6">
													<label class="control-label">First Name</label>
													<input type="text" value="<?php echo $user['FirstName']; ?>" class="form-control" name="FirstName" />
												</div>
												<div class="form-group col-sm-6">
													<label class="control-label">Last Name</label>
													<input type="text" value="<?php echo $user['LastName']; ?>" class="form-control" name="LastName"/>
												</div>
											</div>
											<div class="row">
												<div class="form-group col-sm-6">
													<label class="control-label">Email</label>
													<input type="email" value="<?php echo $user['Email']; ?>" class="form-control" name="Email"/>
												</div>
												<div class="form-group col-sm-6">
													<label class="control-label">Phone Number</label>
													<input type="text" value="<?php echo $user['PhoneNumber']; ?>" class="form-control" name="PhoneNumber" />
												</div>
											</div>
											<div class="form-group">
												<label class="control-label">Address</label>
												<textarea class="form-control" rows="2" name="Address"><?php echo $user['Address']; ?></textarea>
											</div>
											<div class="row">
												<div class="form-group col-sm-6">
													<label class="control-label">Country</label>
													<input type="text" value="<?php echo $user['Country']; ?>" class="form-control" name="Country" />
												</div>
												<div class="form-group col-sm-6">
													<label class="control-label">City</label>
													<input type="text" value="<?php echo $user['City']; ?>" class="form-control" name="City" />
												</div>
											</div>
											<div class="row">
												<div class="form-group col-sm-6">
													<label class="control-label">Zip</label>
													<input type="text" value="<?php echo $user['Zip']; ?>" class="form-control" name="Zip" />
												</div>
												<div class="form-group col-sm-6">
													<label class="control-label">Status</label>
													<select class="form-control" name="StatusId">
														<?php foreach ($listStatus as $s) { ?>
															<option value="<?php echo $s['StatusId']; ?>"<?php if ($s['StatusId'] == $user['StatusId']) echo ' selected="selected"'; ?>><?php echo $s['StatusName']; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="row">
												<div class="form-group col-sm-6">
													<label class="control-label">Role</label>
													<select class="form-control" name="RoleId">
														<?php foreach ($listRoles as $r) { ?>
															<option value="<?php echo $r['RoleId']; ?>"<?php if ($r['RoleId'] == $user['RoleId']) echo ' selected="selected"'; ?>><?php echo $r['RoleName']; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="form-group col-sm-6">
													<label class="control-label">Vip</label><br>
													<label for="IsVip"><input type="checkbox" id="IsVip" class="make-switch" name="IsVip" data-size="small"<?php if ($user['IsVip'] == 1) echo ' checked'; ?>/>   Vip</label>
												</div>
											</div>
											<div class="form-group clearfix">
												<label class="control-label">Profile Image</label><br>
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail">
														<img  class="image_preview" src="<?php echo $avatar; ?>" alt="" />
													</div>
													<div class="select-img">
														<label for="uploadfileinput" class="btn-success btn default btn-file ">
															CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
															<input type="file" name="Avatar" id="uploadfileinput"> 
														</label>
													</div>
												</div>
											</div>
											<div class="margiv-top-10">
												<input type="submit" name="submit" class="btn-success btn green" value="Save Changes"/>
												<!--<a href="javascript:;" class="btn green"> Save Changes </a>
												<a href="javascript:;" class="btn default"> Cancel </a>-->
											</div>
											<!--</form>-->
											<?php echo form_close(); ?>
										</div>
										<div class="tab-pane" id="tab_1_3">
											<?php echo form_open('index.php/admin/user/changepass'); ?>
											<!--<form action="#">-->
											<div class="form-group">
												<label class="control-label">Current Password</label>
												<input type="password" class="form-control" name="OldPass"/>
											</div>
											<div class="form-group">
												<label class="control-label">New Password</label>
												<input type="password" class="form-control" name="NewPass"/>
											</div>
											<div class="form-group">
												<label class="control-label">Re-type New Password</label>
												<input type="password" class="form-control" name="RePass"/>
											</div>
											<div class="margin-top-10">
												<input type="submit" name="submit" class="btn-success btn green" value="Save Changes"/>
												<!--<a href="javascript:;" class="btn green"> Change Password </a>
												<a href="javascript:;" class="btn default"> Cancel </a>-->
											</div>
											<!--</form>-->
											<?php echo form_close(); ?>
										</div>
									</div>
								</div>
							</div>
							<!-- END PROFILE CONTENT -->
						</div>
					</div>
					<!-- END CONTENT BODY -->
				</div>
			</div>
		</div>
		<?php $this->load->view('admin/includes/script-head'); ?>
		<script type="text/javascript">
			(function () {
				function readURL(input) {

					if (input.files && input.files[0]) {
						var reader = new FileReader();

						reader.onload = function (e) {
							$('.image_preview').attr('src', e.target.result);
						};

						reader.readAsDataURL(input.files[0]);
					}
				}

				$("#uploadfileinput").change(function () {
					readURL(this);
				});

//                $('#uploadfileinput').click(function() {
//					var finder = new CKFinder();
//					finder.resourceType = 'Images';
//					finder.selectActionFunction = function(fileUrl) {
//						$('.image_preview').attr("src",fileUrl);
//						$('.avatar').val(fileUrl);
//					};
//					finder.popup();
//				});
            })(jQuery);
		</script>
	</body>
</html>