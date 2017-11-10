<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<?php 
	    $head['headTitle'] = sprintf("%s - YoBackend", 'User Login');
	    $this->load->view('admin/includes/head',$head);
	?>
	
	<body class="login">
		<div class="container">
			<!-- BEGIN LOGIN FORM -->
			<?php echo form_open('index.php/admin/user/login', array('class' => 'form-signin')); ?>
			<h2 class="form-signin-heading">Yovideo Management</h2>
			<?php if (isset($txtSuccess)) echo '<p class="alert alert-success">' . $txtSuccess . '</p>'; ?>
			<div class="alert alert-danger<?php if (!isset($loginError)) echo ' display-hide'; ?>">
				<button class="close" data-close="alert"></button>
				<span> <?php echo isset($loginError) ? $loginError : "Enter any username and password."; ?> </span>
			</div>
			<div class="form-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label">Username</label>
				<input class="form-control" type="text" placeholder="Username" name="username" value="<?php if (isset($userName)) echo $userName; ?>"/>
			</div>
			<div class="form-group">
				<label class="control-label">Password</label>
				<input class="form-control" type="password" autocomplete="off" placeholder="Password" name="password" value="<?php if (isset($userPass)) echo $userPass; ?>"/> </div>
			<div class="form-actions">
				<button type="submit" class="btn btn-success">Login</button>
				<label class="rememberme check">
					<input type="checkbox" name="remember" value="1" /> Remember 
				</label>
			</div>
			<div class="form-actions">
				<p class="copyright">Copyright © 2016 <a href="http://inspius.com" target="_blank">Inspius</a> Singapore PTE</p>
			</div>
		</div>
		<!--[if lt IE 9]>
		<script src="assets/global/plugins/respond.min.js"></script>
		<script src="assets/global/plugins/excanvas.min.js"></script>
		<![endif]-->
		<!-- BEGIN CORE PLUGINS -->
		<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
		<script src="assets/global/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	</body>

</html>