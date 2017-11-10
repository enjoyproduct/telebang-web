<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<?php 
	    $head['headTitle'] = sprintf("%s - YoBackend", 'Update Setting');
	    $this->load->view('admin/includes/head',$head);
	?>
	<!-- END HEAD -->
	<body class="update-setting">
		<?php $this->load->view('admin/includes/header'); ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<div class="page-content-wrapper">
						<!-- BEGIN CONTENT BODY -->
						<div class="page-content">
							<h1 class="page-header">Update Setting</h1>
							<?php
							if (isset($txtSuccess))
								echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
							elseif (isset($txtError))
								echo '<p class="alert alert-danger">' . $txtError . '</p>';
							?>
							<!-- END PAGE HEADER-->
							<div class="row">
								<div class="col-md-12">
									<!-- BEGIN PROFILE CONTENT -->
									<div class="profile-content">
										<div class="row">
											<div class="col-md-12">
												<div class="portlet light ">
													<div class="portlet-body">
														<?php echo form_open('index.php/admin/config/update/', array('class' => 'config-form', 'role' => 'form')); ?>
														<!--<form role="form" action="#">-->
														<div class="row">
															<div class="form-group col-sm-4">
																<label class="control-label">User Status Default</label>
																<?php
																if (set_value('STATUS_USER'))
																	$statusId = set_value('STATUS_USER');
																else
																	$statusId = $listConfigs['STATUS_USER'];
																?>
																<select class="form-control" name="STATUS_USER">
																	<?php foreach ($listStatus as $s) { ?>
																		<option value="<?php echo $s['StatusId']; ?>"<?php if ($s['StatusId'] == $statusId) echo ' selected="selected"'; ?>><?php echo $s['StatusName']; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="form-group col-sm-4">
																<label class="control-label">Video Status Default</label>
																<?php
																if (set_value('STATUS_VIDEO'))
																	$statusId = set_value('STATUS_VIDEO');
																else
																	$statusId = $listConfigs['STATUS_VIDEO'];
																?>
																<select class="form-control" name="STATUS_VIDEO">
																	<?php foreach ($listStatus as $s) { ?>
																		<option value="<?php echo $s['StatusId']; ?>"<?php if ($s['StatusId'] == $statusId) echo ' selected="selected"'; ?>><?php echo $s['StatusName']; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="form-group col-sm-4">
																<label class="control-label">Comment Status Default</label>
																<?php
																if (set_value('STATUS_COMMENT'))
																	$statusId = set_value('STATUS_COMMENT');
																else
																	$statusId = $listConfigs['STATUS_COMMENT'];
																?>
																<select class="form-control" name="STATUS_COMMENT">
																	<option value="<?php echo COMMENT_STATUS_PENDING ?>" <?php if(COMMENT_STATUS_PENDING == $statusId) {
																		echo 'selected';} ?> >Pending</option>
																	<option value="<?php echo COMMENT_STATUS_APPROVED ?>" <?php if(COMMENT_STATUS_APPROVED == $statusId) {
																		echo 'selected';} ?> >Approved</option>
																</select>
															</div>
														</div>
														<div class="row">
															<div class="form-group col-sm-6">
																<label class="control-label">Admin Email <span class="required">*</span></label>
																<input type="email" required value="<?php
																if (set_value('ADMIN_EMAIL'))
																	echo set_value('ADMIN_EMAIL');
																else
																	echo $listConfigs['ADMIN_EMAIL'];
																?>" class="form-control" name="ADMIN_EMAIL" />
															</div>
														</div>
														<div class="margiv-top-10">
															<input type="submit" name="submit" class="btn green btn-success" value="Save"/>
														</div>
														<!--</form>-->
														<?php echo form_close(); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- END PROFILE CONTENT -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->
		</div>
		<!-- END FOOTER -->
		<?php $this->load->view('admin/includes/script-head'); ?>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".config-form").validate();
			});
		</script>
	</body>
</html>