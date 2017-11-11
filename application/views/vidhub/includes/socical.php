<?php 
	$facebook 	= $themeConfig[V1_theme_config_model::COL_FACEBOOK_URL];
	$twiter 	= $themeConfig[V1_theme_config_model::COL_TWITTER_URL];
	$google 	= $themeConfig[V1_theme_config_model::COL_GOOGLE_URL];
	$youtube 	= $themeConfig[V1_theme_config_model::COL_YOUTUBE_URL]
?>
<div class="sider-bar">		
	<div class="socical">
		<ul class="clearfix">
			<?php if ($facebook): ?>
				<li class="facebook">
					<a href="<?php echo $facebook ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
				</li>
			<?php endif ?>
			<?php if ($twiter): ?>
				<li class="twiter">
					<a href="<?php echo $twiter ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
				</li>
			<?php endif ?>
			<?php if ($google): ?>
				<li class="google">
					<a href="<?php echo $google ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
				</li>
			<?php endif ?>
			<?php if ($youtube): ?>
				<li class="youtube">
					<a href="<?php echo $youtube ?>" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
				</li>
			<?php endif ?>
		</ul>
	</div>
</div>		