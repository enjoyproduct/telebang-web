<?php $currentUrl = uri_string();  ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		jssor_1_slider_init();
	});
</script>
</div>
<footer id="is-footer-copyright-group">
	<div id="footer" class="footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<h3 class="headding-footer">
						<?php echo $themeConfig[V1_theme_config_model::COL_FOOTER_LOGO] ?>
					</h3>
					<p>
						<?php echo $themeConfig[V1_theme_config_model::COL_FOOTER_ABOUT] ?>
					</p>
					<div class="store-app clearfix">
						<?php 
							$google = $themeConfig[V1_theme_config_model::COL_ANDROID_URL];
							$ios = $themeConfig[V1_theme_config_model::COL_IOS_URL];
						?>
						<?php if ($google): ?>
							<div class="google-play app">
								<a href="<?php echo $google ?>" target="_blank">
									<img src="assets/images/google-play.png" alt="">
								</a>
							</div>
						<?php endif ?>
						<?php if ($ios): ?>
							<div class="ios-play app">
								<a href="<?php echo $ios ?>" target="_blank">
									<img src="assets/images/app-store.png" alt="">
								</a>
							</div>
						<?php endif ?>
					</div>
				</div>
				<div class="col-sm-4">
					<h3 class="headding-footer">
						Categories
					</h3>
					<ul class="clearfix category-list">
						<?php foreach ($listParentCategories as  $value): ?>
							<li><a href="<?php echo $value['url_list_video'] ?>"><?php echo $value['CategoryName'] ?> <span>(<?php  echo $value['videos_counter'] ?> )</span></a></li>
						<?php endforeach ?>
					</ul>
				</div>
				<div class="col-sm-4">
					<h3 class="headding-footer">
						Join Our Newsletters
					</h3>
					<p>
						Another category of software that is known to leave bits and pieces.
					</p>
					<div class="newsletter">
						<form action="" >
							<i class="fa fa-envelope-o" aria-hidden="true"></i>
							<input type="email" name="EMAIL" placeholder="Your email here…" required class="form-control" />
							<input type="submit" value="SUBSCRIBE now !" class="form-control btn"/>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="copyright">
						<?php echo $themeConfig[V1_theme_config_model::COL_FOOTER_COPYRIGHT] ?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="menu-footer">
						<ul>
							<li class="has-sub nav-item<?php if (strpos($currentUrl, HOME_PATH) !== false) echo ' active open'; ?>">
								<a  href="<?php echo site_url(HOME_PATH) ?>">Home</a>
							</li>
							<li class="has-sub nav-item<?php if (strpos($currentUrl, ABOUTS_PATH) !== false) echo ' active open'; ?>">
								<a href="<?php echo ABOUTS_PATH ?>">About us  </a>
							</li>
							<li class="has-sub nav-item<?php if (strpos($currentUrl, CONTACT_US) !== false) echo ' active open'; ?>">
								<a href="<?php echo CONTACT_US ?>"> Contact us</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

</body>
</html>