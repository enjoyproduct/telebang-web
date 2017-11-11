<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<title><?php echo ($slug != '') ? 'Update' : 'Add' ?> Static Page - Yovideo</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<base href="<?php echo base_url(); ?>"/>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/dashboard.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<body class="update-video">
		<?php $this->load->view('admin/includes/header'); ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<div class="page-content-wrapper">
						<!-- BEGIN CONTENT BODY -->
						<div class="page-content">
							<h1 class="page-header"><?php echo ($slug != '') ? 'Update' : 'Add' ?> Static Page</h1>
							<!-- END PAGE TITLE-->
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
														<?php echo form_open_multipart('index.php/admin/staticpage/update/' . $slug, array('class' => 'video-form', 'role' => 'form')); ?>
														<!--<form role="form" action="#">-->
														<div class="row">
														   <!--  <div class="form-group col-sm-3">
																<label class="control-label">Create Static Page</label>
 
															</div> -->
														</div>
														<div class="form-group">
															<label class="control-label">Title</label>
															<input type="text" id="PageTitle" required value="<?php
															if (set_value('PageTitle'))
																echo set_value('PageTitle');
															else
																echo $PageTitle;
															?>" class="form-control" name="PageTitle" required="required"/>
														</div>
													<div class="form-group">
															<label class="control-label">Description</label>
															<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
															  <script>tinymce.init({
															  selector: 'textarea',
															  height: 500,
															  theme: 'modern',
															  plugins: [
															    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
															    'searchreplace wordcount visualblocks visualchars code fullscreen',
															    'insertdatetime media nonbreaking save table contextmenu directionality',
															    'emoticons template paste textcolor colorpicker textpattern imagetools'
															  ],
															  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
															  toolbar2: 'print preview media | forecolor backcolor emoticons',
															  image_advtab: true,
															  templates: [
															    { title: 'Test template 1', content: 'Test 1' },
															    { title: 'Test template 2', content: 'Test 2' }
															  ],
															  content_css: [
															    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
															    '//www.tinymce.com/css/codepen.min.css'
															  ]
															 });</script>															
															<textarea class="form-control" rows="5" id="pageDesc" name="PageDesc"><?php
																if (set_value('PageDesc'))
																	echo set_value('PageDesc');
																else
																	echo $PageDesc;
																?>
															</textarea>
														</div>
												</div>
													<div class="margiv-top-10">
														<input type="submit" name="submit" id="btnSubmit" class="btn green btn-success" value="Save"/>
														<?php if ($slug != ''){ ?>
														<a href="<?php echo site_url('index.php/admin/staticpage/delete/'.$slug); ?>" class="btn default btn-back">Delete</a>
														<?php } ?>
														<a href="<?php echo site_url('index.php/admin/staticpage'); ?>" class="btn default btn-back">Back</a>
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
	<!--[if lt IE 9]>
	<script src="assets/global/plugins/respond.min.js"></script>
	<script src="assets/global/plugins/excanvas.min.js"></script>
	<![endif]-->
</body>
</html>
