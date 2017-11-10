<div id="carousel-latest-video" class="carousel slide category-new" data-ride="carousel" data-interval="false">
  	<div class="carousel-inner" role="listbox">
	<?php 
		$numberPost = count($videosLatest); 
		$numberPage = ceil($numberPost / 4);
        $offset = 0;
		for ($pageIndex = 0; $pageIndex < $numberPage; $pageIndex++):
        $offset = $pageIndex * 4;
    ?>
    	<div class="item <?= $pageIndex == 0 ? 'active' : '' ?>"">
	    	<div class="row">
	    		<?php
			        for ($postIndex = (0 + $offset); $postIndex < ($offset + 4) && $postIndex < $numberPost; $postIndex++):
			        	$videoModel = $videosLatest[$postIndex];
				        $title = $videoModel['VideoTitle'];
				        $view = $videoModel['ViewCount'];
				        $like = $videoModel['likedCounter'];
				        $image = $videoModel['VideoImage'];
			        
			    ?>
		      	<div class="col-sm-6">
					<div class="item-video clearfix">
						<div class="video-image">

							<a href="<?php 
								if ($videoModel['videoVip'] == 0) {
									echo $videoModel['videoDetailPath'];
								} else {
									if ($customer_model) {
										if ($customer_model['IsVip'] == 0) {//customer is not subscribed
											echo site_url(SUBSCRIPTION);
										} else {//check expire
											echo $videoModel['videoDetailPath'];
										}
									} else {
										echo site_url(LOGIN_ALERT);
									}
								} 
								?>">
								<img src="<?php echo $image ?>" alt="">
							</a>
							<?php if ($videoModel['videoVip'] == 1) { ?>
                            <h6 style="padding: 10px; margin-bottom: 0px; margin-top: 0px; background-color:#ffcc00; color:#000000;"><b>Subscription</b></h6>
                            <?php } ?>
						</div>
						<div class="video-infor clearfix carousel-caption">
							<h5><a href="#"><?php echo $title ?></a></h5>
							<div class="video-action">
								<div class="view">
									<i class="fa fa-eye" aria-hidden="true"></i>
									<span><?php echo $view ?></span>
								</div>
								<div class="wishlist">
									<i class="fa fa-heart" aria-hidden="true"></i>
									<span><?php echo $like ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endfor; ?>
			</div>
    	</div>
  	<?php endfor; ?>
  	</div>
  	<?php if ($numberPost > 0): ?>
  		<!-- Controls -->
	  	<a class="left carousel-control" href="#carousel-latest-video" role="button" data-slide="prev">
	  		<i class="fa fa-angle-left" aria-hidden="true"></i>
	  	</a>
	  	<a class="right carousel-control" href="#carousel-latest-video" role="button" data-slide="next">
	  		<i class="fa fa-angle-right" aria-hidden="true"></i>
	  	</a>	
  	<?php endif ?>
</div>