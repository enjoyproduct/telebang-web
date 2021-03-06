<?php $this->load->view(THEME_VM_DIR.'/includes/header'); ?>
<script>
	var page 	= <?php echo $page ?>;
	var perPage = <?php echo $perPage ?>;
</script>

<div id="is" class="is" data-is-full-width="true">
	<div class=-area ">
		<div class="breadcrumb bg-category">
			<div class="container">
				<h3 class="headding-title">
					Search Result
				</h3>
			</div>
		</div>
		<div class="section ">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="section top">
							<?php $this->load->view(THEME_VM_DIR.'/elements/featured-category'); ?>
						</div>
						<div class="section list-category">
							<h4>
								<?php 
									if ($message)
										echo $message;
								?>
							</h4>
							<div class="row" id="list-video">
								<?php 
									foreach ($listVideos as $value) {
								?>
									<div class="col-sm-4">
										<div class="item-video clearfix">
											<div class="video-image">
												<a href="<?php echo $value['videoDetailPath'] ?>">
													<img src="<?php echo $value['VideoImage'] ?>" alt="">
												</a>
											</div>
											<div class="video-infor clearfix">
												<h5><a href="<?php echo $value['videoDetailPath'] ?>"><?php echo $value['VideoTitle'] ?></a></h5>
												<div class="video-action">
													<div class="view">
														<i class="fa fa-eye" aria-hidden="true"></i>
														<span><?php echo $value['ViewCount'] ?></span>
													</div>
													<div class="wishlist">
														<i class="fa fa-heart" aria-hidden="true"></i>
														<span><?php  echo $value['likedCounter'] ?></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
									}
								?>
							</div>
							<?php if ($perPage): ?>
								<button class="loadmore" id="loadmore-video">LOAD MORE</button>
							<?php endif ?>
						</div>
					</div>
					<div class="col-sm-4">
						<?php $this->load->view(THEME_VM_DIR.'/includes/socical'); ?>
						<div class="sider-bar">
							<?php $this->load->view(THEME_VM_DIR.'/sidebar/category'); ?>
						</div>
						<div class="sider-bar">
							<h4 class="title-siderbar">
								Popular Videos
							</h4>
							<?php $this->load->view(THEME_VM_DIR.'/sidebar/popular'); ?>
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
<script>
	$('#loadmore-video').click(function(){
		$.ajax({
			url:"<?php echo base_url(THEME_CONTROLLER_PATH.'/videos/searchAjax'); ?>" + '/' + (page + 1) + '/' + perPage,
			type:'GET',
			success:function(res){
				res = JSON.parse(res);
				var htmlAppend = '';
				if(res) {
					console.log(res);
					for(var i=0,len = res.length;i<len;i++) {
						htmlAppend += '<div class="col-sm-4">';
						htmlAppend += '<div class="item-video clearfix">';
						htmlAppend += '<div class="video-image">';
						htmlAppend += '<a href="'+ res[i].videoDetailPath +'">';
						htmlAppend += '<img src="'+ res[i].VideoImage +'" alt=""></a></div>';
						htmlAppend += '<div class="video-infor clearfix">';
						htmlAppend += '<h5><a href="'+ res[i].videoDetailPath +'">'+ res[i].VideoTitle +'</a></h5>';
						htmlAppend += '<div class="video-action"><div class="view">';
						htmlAppend += '<i class="fa fa-eye" aria-hidden="true"></i>';
						htmlAppend += '<span>'+ res[i].ViewCount +'</span></div>';
						htmlAppend += '<div class="wishlist">';
						htmlAppend += '<i class="fa fa-heart" aria-hidden="true"></i>';
						htmlAppend += '<span>'+ res[i].likedCounter +'</span>';
						htmlAppend += '</div></div></div></div></div>';
					}
					htmlAppend += '';
				}
				$('#list-video').append(htmlAppend);
			htmlAppend = '';
				page = page + 1;
			}
		});
	});
</script>
