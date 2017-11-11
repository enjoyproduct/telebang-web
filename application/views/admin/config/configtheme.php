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