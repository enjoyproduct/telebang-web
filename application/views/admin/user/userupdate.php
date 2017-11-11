<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<?php 
	    $head['headTitle'] = sprintf("%s User - YoBackend", ($userId>0) ? 'Update' : 'Add');
	    $this->load->view('admin/includes/head',$head);
	?>
	<!-- END HEAD -->
	<body class="user-update">
		<?php $this->load->view('admin/includes/header'); ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<div class="page-content-wrapper">
						<!-- BEGIN CONTENT BODY -->
						<div class="page-content">
							<h1 class="page-header"><?php echo ($userId>0) ? 'Update' : 'Add' ?> User</h1>
							<?php
							if (isset($txtSuccess))
								echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
							elseif (isset($txtError))
								echo '<p class="alert alert-danger">' . $txtError . '</p>';
							?>
							<!-- END PAGE HEADER-->
							
								<!-- BEGIN PROFILE CONTENT -->
							<div class="profile-content">
								<div class="portlet light ">
									<div class="portlet-body">
										<div class="row">
											<?php echo form_open_multipart('index.php/admin/user/update/' . $userId, array('class' => 'user-form','role' => 'form')); ?>
											<div class="col-sm-5">
												<?php if ($userId > 0){?>
													<div class="row">
														<div class="form-group col-sm-6">
															<label class="control-label">Old Password</label>
															<input type="password" class="form-control" name="UserPass"/>
														</div>
														<div class="form-group col-sm-6">
															<label class="control-label">New Password</label>
															<input type="password" class="form-control" name="NewPass"/>
														</div>
														<div class="form-group col-sm-6">
															<label class="control-label">Confirm New Password</label>
															<input type="password" class="form-control" name="RePass" />
														</div>
	                                                </div>
	                                            <?php } ?>
												<div class="form-group">
													<label class="control-label">UserName <span class="required">*</span></label>
													<input type="text" required value="<?php
													if (set_value('UserName'))
														echo set_value('UserName');
													else
														echo $userName;
													?>" class="form-control" name="UserName" <?php if ($flag != 3) echo 'readonly'; ?>/>
												</div>
												<?php if ($flag == 3) { ?>
													<div class="form-group">
														<label class="control-label">New Password</label>
														<input type="password" class="form-control" required name="UserPass" id="userPass"/>
													</div>
													<div class="form-group">
														<label class="control-label">Re-type New Password <span class="required" id="msg"></span></label>
														<input type="password" class="form-control" required name="RePass" id="rePass"/>
													</div>
												<?php } ?>
												<div class="form-group ">
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-new thumbnail" >
															<img class="image_preview" src="<?php echo $avatar; ?>" alt="" />
														</div>
														<div class="select-img">
															<label for="uploadfileinput" class="btn-success btn default btn-file ">
																CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
																<input type="file" name="Avatar" id="uploadfileinput"> 
															</label><br>
															<span>No file choosen</span>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-7 portlet-body-right">
												<div class="row">
													<div class="form-group col-sm-6">
														<label class="control-label">First Name</label>
														<input type="text" value="<?php
														if (set_value('FirstName'))
															echo set_value('FirstName');
														else
															echo $firstName;
														?>" class="form-control" required name="FirstName" />
													</div>
													<div class="form-group col-sm-6">
														<label class="control-label">Last Name</label>
														<input type="text" value="<?php
														if (set_value('LastName'))
															echo set_value('LastName');
														else
															echo $lastName;
														?>" class="form-control" required name="LastName"/>
													</div>
												</div>
												<div class="row">
													<div class="form-group col-sm-6">
														<label class="control-label">Email</label>
														<input type="email" value="<?php
														if (set_value('Email'))
															echo set_value('Email');
														else
															echo $email;
														?>" class="form-control" required name="Email"/>
													</div>
													<div class="form-group col-sm-6">
														<label class="control-label">Phone Number</label>
														<input type="text" value="<?php
														if (set_value('PhoneNumber'))
															echo set_value('PhoneNumber');
														else
															echo $phoneNumber;
														?>" class="form-control" name="PhoneNumber" />
													</div>
                                                </div>
                                                <div class="form-group">
													<label class="control-label">Address</label>
													<textarea class="form-control" rows="2" name="Address"><?php
														if (set_value('Address'))
															echo set_value('Address');
														else
															echo $address;
														?></textarea>
												</div>
												<div class="row">
													<div class="form-group col-sm-6">
														<label class="control-label">Country</label>
														<input type="text" value="<?php
														if (set_value('Country'))
															echo set_value('Country');
														else
															echo $country;
														?>" class="form-control" name="Country" />
													</div>
													<div class="form-group col-sm-6">
														<label class="control-label">City</label>
														<input type="text" value="<?php
														if (set_value('City'))
															echo set_value('City');
														else
															echo $city;
														?>" class="form-control" name="City" />
													</div>
												</div>
												<div class="row">
													<div class="form-group col-sm-6">
														<label class="control-label">Zip</label>
														<input type="text" value="<?php
														if (set_value('Zip'))
															echo set_value('Zip');
														else
															echo $zip;
														?>" class="form-control" name="Zip" />
													</div>
													<div class="form-group col-sm-6">
														<label class="control-label">Status</label>
														<?php if (set_value('StatusId')) $statusId = set_value('StatusId'); ?>
														<select class="form-control" name="StatusId">
															<?php foreach ($listStatus as $s) { ?>
																<option value="<?php echo $s['StatusId']; ?>"<?php if ($s['StatusId'] == $statusId) echo ' selected="selected"'; ?>><?php echo $s['StatusName']; ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="row">
													<div class="form-group col-sm-6">
														<label class="control-label">Role</label>
														<?php if (set_value('RoleId')) $roleId = set_value('RoleId'); ?>
														<select class="form-control" name="RoleId">
															<?php foreach ($listRoles as $r) { ?>
																<option value="<?php echo $r['RoleId']; ?>"<?php if ($r['RoleId'] == $roleId) echo ' selected="selected"'; ?>><?php echo $r['RoleName']; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="form-group col-sm-6">
														<input id="check-vip" type="checkbox" class="make-switch" name="IsVip" data-size="small"<?php if ($isVip == 1) echo ' checked'; ?>/>
														<label class="control-label check-vip" for="check-vip">Vip
														</label>
													</div>
												</div>
											</div>
											<div class="col-sm-5">
												<input type="submit" name="submit" id="btnSubmit" class="btn green btn-success" value="Save"/>
												<a href="<?php echo site_url('admin/user/userlist'); ?>" class="btn default btn-back">Back</a>
												<input type="text" hidden="hidden" id="flag" value="<?php echo $flag; ?>"/>
											</div>
											<!--</form>-->
											<?php echo form_close(); ?>
											</div>
										</div>
									</div>
									<!-- END PROFILE CONTENT -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->
		</div>
		<?php $this->load->view('admin/includes/script-head'); ?>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".user-form").validate();
				var flag = $('input#flag').val();
				if (flag == 3) {
					$('input#userPass').prop('required', true);
					$('input#rePass').prop('required', true);
				}
				$('input#btnSubmit').click(function() {
					if (flag == 3) {
						if ($('input#userPass').val() != $('input#rePass').val()) {
							$('span#msg').text('Password is not match');
							$('input#rePass').focus();
							return false;
						}
					}
				});
			});
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

                
            })(jQuery);
		</script>
	</body>
</html>