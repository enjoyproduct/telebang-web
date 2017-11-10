<?php $this->load->view(THEME_VM_DIR.'/includes/header'); ?>
<script>
	var video_id = <?php echo $id; ?>
</script>
<div id="is-content" class="is-content" data-is-full-width="true" >
	<div class="content-area ">
		<div class="video-play">
			<div class="container">
				<div id="video_player">
					<?php 
						if($video_type == 3){
							echo getEmbedVideo($video_path);
						}else{
							echo '<div id="player"></div>';
						}
					?>
				</div>
				<div class="clearfix ">
					<div class="share-detail ">
						<div class="pull-left">
							<ul class="clearfix action-share">
								<li id="like-button">
									<button class="click-action like-action" id="likeIcon">
										<?php if ($is_liked): ?>
											<i class="fa fa-thumbs-up" style="color: #f9a500" aria-hidden="true"></i>
										<?php else: ?>
											<i class="fa fa-thumbs-o-up"  aria-hidden="true"></i>
										<?php endif ?>
									</button>
								</li>
								<li>
									<button class="share-button">
										<i class="fa fa-share-alt" aria-hidden="true"></i>
										<?php $this->load->view(THEME_VM_DIR.'/elements/share-video'); ?> 
									</button>
								</li>
								<li><button class="click-action" id="clickcomment"><i class="fa fa-comment" aria-hidden="true"></i></button></li>
							</ul>
						</div>
					</div>
					<div class="video-action pull-right">
						<div class="view">
							<i class="fa fa-eye" aria-hidden="true"></i>
							<span><?php echo $view ?> views</span>
						</div>
						<div class="wishlist">
							<i class="fa fa-heart" aria-hidden="true"></i>
							<span><?php echo $like ?> like</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="section ">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="section video-detail">
							<h4 class="title"><?php echo $head_title ?></h4>
							<div class="action-info clearfix">
								<div class="col-left">
									<div class="avatar">
										<?php if ($avatar){ ?>
											<img src="<?php echo getImagePath($avatar); ?>" alt="">
										<?php }else{ ?>
											<img src="<?php echo base_url(NO_IMAGE_PATH) ?>" alt="">
										<?php } ?>
									</div>
									<div class="title-user">
										<a href="#">
											<?php echo $fullname ?> 
										</a>
									</div> <br>
									<div class="count-video">
										<?php echo $videos_counter_by_user ?> videos
									</div>
								</div>
								<div class="col-right">
									<a href="#" class="btn">
										<i class="fa fa-play-circle" aria-hidden="true"></i>
										SUBSCRIBE
									</a>
								</div>
							</div>
							<div class="entry-header">
								<span><i class="fa fa-calendar-o" aria-hidden="true"></i><time datetime=""><?php echo date_format(date_create($update_at) , 'Y-m-d');  ?></time></span>
								<span><i class="fa fa-comment" aria-hidden="true"></i><?php echo $comments_counter ?></span>
							</div>
							<div class="description">
								<?php echo $meta_description ?>
							</div>
						</div>
						<div class="session" id="comment">
							<?php $this->load->view(THEME_VM_DIR.'/elements/comment'); ?>
						</div>
					</div>
					<div class="col-sm-4">
						<?php $this->load->view(THEME_VM_DIR.'/includes/socical'); ?>
						<div class="sider-bar">
							<?php $this->load->view(THEME_VM_DIR.'/sidebar/related-video'); ?>
						</div>
						<div class="sider-bar">
							<?php $this->load->view(THEME_VM_DIR.'/sidebar/banner'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view(THEME_VM_DIR.'/includes/footer'); ?>

<script type="text/javascript">
	show_description();

	jwplayer.key = "<?php echo $themeConfig['jwplayer_key'] ?>";
	var playerInstance = jwplayer("player");
	playerInstance.setup({
		id:'player',
		file:"<?php echo $video_path ?>",
		controls: true,
		displaytitle: true,
		width: "100%",
		height: "600px",
		fullscreen: false,
		autostart: false,
		image: "<?php echo $image ?>"
	});
</script>