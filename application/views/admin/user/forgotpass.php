<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<head>
		<meta charset="utf-8" />
		<title>Category List - Yovideo</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<base href="<?php echo base_url(); ?>"/>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/dashboard.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<body class=" login">
		<!-- BEGIN LOGO -->
		<div class="logo">
			<a href="<?= base_url(); ?>"> <img src="http://inspius.com/img/logo2.png" alt="" /> </a>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN LOGIN -->
		<div class="content">
			<!-- BEGIN LOGIN FORM -->
			<?php echo form_open('index.php/admin/user/forgotpass/' . $token, array('class' => 'login-form')); ?>
			<!--<form class="login-form" action="index.html" method="post">-->
			<h3 class="form-title font-green">Forgot Password</h3>
			<?php if (isset($txtSuccess)) echo '<p class="alert alert-success">' . $txtSuccess . '</p>'; ?>
			<div class="alert alert-danger<?php if (!isset($loginError)) echo ' display-hide'; ?>">
				<button class="close" data-close="alert"></button>
				<span> <?php echo isset($loginError) ? $loginError : "Enter your password."; ?> </span>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">Password</label>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" /> </div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword" /> </div>
			<div class="form-actions">
				<input type="submit" class="btn green uppercase" name="submit" value="Change Password" />    
				<a href="<?php echo base_url('user'); ?>">Login</a>  
			</div>
		</div>
		<div class="copyright"> <?php echo COPYRIGHT; ?> </div>
		<!--[if lt IE 9]>
		<script src="assets/global/plugins/respond.min.js"></script>
		<script src="assets/global/plugins/excanvas.min.js"></script>
		<![endif]-->
		<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
		<script src="assets/global/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
		<script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
		<script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
		<script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
		<script src="assets/pages/scripts/table-datatables-fixedheader.min.js" type="text/javascript"></script>
	</body>
</html>