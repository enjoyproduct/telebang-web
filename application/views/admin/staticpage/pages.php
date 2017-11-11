<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->

	<head>
		<meta charset="utf-8" />
		<title><?php echo $PageTitle ?> - Yovideo</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<base href="<?php echo base_url(); ?>"/>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/dashboard.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<!-- END HEAD -->
	<body class="video-list" style="padding-top:0px">
		<div class="container-fluid" style="margin-top:0.5px">
			<div class="row">
				<div class="main" style="margin-top:0.5px">
					<div class="page-content">
						<h1 class="page-header"><?php echo $PageTitle ?></h1>
						<?php
						if (isset($txtSuccess))
							echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
						elseif (isset($txtError))
							echo '<p class="alert alert-danger">' . $txtError . '</p>';
						?>
						<!-- END PAGE HEADER-->
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="">
									<div class="portlet-body">
										<?php echo $PageDesc ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>
