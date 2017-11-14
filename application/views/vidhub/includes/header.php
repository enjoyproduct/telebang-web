<?php 
    $head['headTitle'] = sprintf("YoBackend");
    $this->load->view(THEME_VM_DIR.'/includes/head',$head);
    $currentUrl = uri_string(); 
?>
<script>
	var user_id = <?php echo $customer_model['UserId']? : 0; ?>;
</script>
<body>
	<div id="wrapper" class="wrapper">
		<header id="is-header" class="is-header header-container">
			<div class="header-top">
				<div class="container">
					<div class="row">
						<div class="col-sm-3">
							<div class="header-logo">
								<a href="<?php echo site_url(HOME_PATH) ?>">
									<?php $logoImg = $themeConfig[V1_theme_config_model::COL_HEADER_LOGO]; ?>
									<?php if ($logoImg){ ?>
										<img src="<?php echo getImagePath($logoImg) ?>" alt="">
									<?php }else { ?>
										<?php echo $themeConfig[V1_theme_config_model::COL_FOOTER_LOGO] ?>
									<?php } ?>
								</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="header-search">
								<form id='search-video' action='<?php echo THEME_CONTROLLER_PATH.'/videos/search' ?>' type='GET'>
									<input type="text" class="form-control form-search" name='keyword' value="" placeholder="Search videos…">
									<i class="fa fa-search" aria-hidden="true"></i>
								</form>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="header-action">
								<?php if ($customer_model){  ?>
									<div class="avatar-user">
										<a href="<?php echo site_url(USER_SETTING_PATH) ?>">
											<img src="<?php echo getAvatarPath($customer_model['Avatar']) ?>" alt="">
										</a>
									</div>
									<div class="info-user">Hello, <br>
										<div class="dropdown">
										  	<button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    	<span><?php echo getFullName($customer_model) ?></span>
										    	<span class="caret"></span>
										  	</button>
										  	<ul class="dropdown-menu" aria-labelledby="dLabel">
										    <!-- 	<li><a href="#">SAVED VIDEO</a></li>
										    	<li><a href="#">MY CHANNEL</a></li> -->
										    	<li><a href="<?php echo site_url(USER_SETTING_PATH) ?>">PROFILE</a></li>
										    	<li><a href="<?php echo base_url(THEME_CONTROLLER_PATH.'/auth/logout'); ?>">SIGN OUT</a></li>
										  	</ul>
										</div>
									</div>
								<?php }else{ ?>
									<div class="avatar-user">
										<a href="#">
											<img src="<?php echo base_url(NO_IMAGE_PATH) ?>" alt="">
										</a>
									</div>
									<div class="info-user">Hello, <br>
										<?php $this->load->view(THEME_VM_DIR.'/includes/login'); ?>
									</div>
								<?php } ?>

							</div>
							<div class="navbar-header">
		                      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myScrollspy">
		                          <span class="sr-only">Toggle navigation</span>
		                          <span class="icon-bar"></span>
		                          <span class="icon-bar"></span>
		                          <span class="icon-bar"></span>
		                      </button>
		                    </div>
						</div>
					</div>
				</div>
				<!-- <div class="header-content container">
					<?php if (!$customer_model){  ?>
					<p class="col-xs-9" style="margin-top: 10px;"><font color="red">*Please login in order to see VIP video</font></p>
					<?php } else if ($customer_model['IsVip'] == 0) {?>
					<p class="col-xs-9" style="margin-top: 10px;"><font color="red">*You need to subscribe in order to see VIP video</font></p>
					<?php }?>
				</div> -->
			</div>
			<div class="header-content">	
				<div class="container">
					<nav class="navbar navbar-default">
						<div  class="navbar-collapse collapse" id="myScrollspy" >
							<ul  class="nav nav-sidebar">
								<li class="has-sub nav-item<?php if (strpos($currentUrl, HOME_PATH) !== false) echo ' active open'; ?>">
									<a  href="<?php echo site_url(HOME_PATH) ?>">HOME</a>
								</li>
								<li class="has-sub nav-item<?php if (strpos($currentUrl, CATEGORIES_PATH) !== false) echo ' active open'; ?>">
									<a href="<?php echo site_url(CATEGORIES_PATH) ?>"> CATEGORIES   </a>
								</li>
								<li class="has-sub nav-item<?php if (strpos($currentUrl, BLOG_PATH) !== false) echo ' active open'; ?>">
									<a href="<?php echo BLOG_PATH ?>"> NEWS/BLOGS</a>
								</li>
								<li class="has-sub nav-item<?php if (strpos($currentUrl, ABOUTS_PATH) !== false) echo ' active open'; ?>">
									<a href="<?php echo ABOUTS_PATH ?>">ABOUT US  </a>
								</li>
								<li class="has-sub nav-item<?php if (strpos($currentUrl, CONTACT_US) !== false) echo ' active open'; ?>">
									<a href="<?php echo CONTACT_US ?>"> CONTACT US</a>
								</li>
								<?php if ($customer_model) { 
										if ($customer_model['IsVip'] == 0) { ?>
											<li class="has-sub nav-item<?php if (strpos($currentUrl, SUBSCRIPTION_HISTORY) !== false) echo ' active open'; ?>">
												<a href="<?php echo site_url(SUBSCRIPTION) ?>"> SUBSCRIPTIONS</a>
											</li>
									<?php } else { ?> 
										<li class="has-sub nav-item<?php if (strpos($currentUrl, SUBSCRIPTION_HISTORY) !== false) echo ' active open'; ?>">
												<a href="<?php echo site_url(SUBSCRIPTION_HISTORY.'/'.$customer_model['UserId']) ?>"> SUBSCRIPTION HISTORY</a>
											</li>
								<?php }}?>
							</ul>
						</div>
					</nav>
				</div>
			</div>
			<?php if ($upload == 1): ?>
				<a href="#" title="" class="btn-upload btn">
					<i class="fa fa-plus" aria-hidden="true"></i>
				</a>
			<?php endif ?>
		</header><!-- End .is-header -->
		