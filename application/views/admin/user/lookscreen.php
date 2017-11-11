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
	</head>F
	<body class="">
		<div class="page-lock">
			<div class="page-logo">
				<a class="brand" href="index.html">
					<img src="assets/pages/img/logo-big.png" alt="logo" /> </a>
			</div>
			<div class="page-body">
				<div class="lock-head"> Locked </div>
				<div class="lock-body">
					<?php echo form_open('index.php/admin/user/lookscreen', array('class' => 'lock-form pull-left')); ?>
					<!--<form class="lock-form pull-left" action="index.html" method="post">-->
					<h4><?php echo $user['FirstName'] . ' ' . $user['LastName']; ?></h4>
					<div class="form-group">
						<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" />
					</div>
					<div class="form-actions">
						<input type="submit" name="submit" class="btn red uppercase" value="Login"/>
						<!--<button type="submit" class="btn red uppercase">Login</button>-->
					</div>
					<!--</form>-->
					<?php echo form_close(); ?>
				</div>
				<div class="lock-bottom">
					<a href="<?php echo base_url('index.php/admin/user/logout'); ?>">Not <?php echo $user['FirstName'] . ' ' . $user['LastName']; ?>?</a>
				</div>
			</div>
			<div class="page-footer-custom"> <?php echo COPYRIGHT; ?> </div>
		</div>
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