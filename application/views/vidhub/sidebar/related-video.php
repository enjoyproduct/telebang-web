<h4 class="title-siderbar">
	Related Video
</h4>
<div id="carousel-related-video" class="carousel slide category-new" data-ride="carousel" data-interval="false">
  	<div class="carousel-inner" role="listbox">
	  	<?php 
			$numberPost = count($relatedVideo); 
			$numberPage = ceil($numberPost / 4);
	        $offset = 0;
			for ($pageIndex = 0; $pageIndex < $numberPage; $pageIndex++):
	        $offset = $pageIndex * 4;
	    ?>
	    	<div class="item <?= $pageIndex == 0 ? 'active' : '' ?>"">
				<div class="last-new">
					<?php 
						$perPage = 4;
						for ($postIndex = (0 + $offset); $postIndex < ($offset + 4) && $postIndex < $numberPost; $postIndex++):
							$relaModel = $relatedVideo[$postIndex];
							$title = $relaModel['VideoTitle'];
							$view = $relaModel['ViewCount'];
							$image = $relaModel['VideoImage'];
							$like = $relaModel['likedCounter'];
					?>
						<ul class="list-item">
							<li>
								<div class="item-video clearfix">
									<a href="<?php 
									// echo $relaModel['videoDetailPath'] 
									if ($relaModel['videoVip'] == 0) {
			                            echo $relaModel['videoDetailPath'];
			                        } else {
			                            if ($customer_model) {
			                                if ($customer_model['IsVip'] == 0) {//customer is not subscribed
			                                    echo site_url(SUBSCRIPTION);
			                                } else {//check expire
			                                    echo $relaModel['videoDetailPath'];
			                                }
			                            }
			                        }
			                        ?>">
										<div class="last-new-img">
											<img src="<?php echo getImagePath($image) ?>" alt="">
										</div>
									</a>
									<div class="video-infor">
										<h5><a href="<?php 
										// echo $relaModel['videoDetailPath'] 
										if ($relaModel['videoVip'] == 0) {
				                            echo $relaModel['videoDetailPath'];
				                        } else {
				                            if ($customer_model) {
				                                if ($customer_model['IsVip'] == 0) {//customer is not subscribed
				                                    echo site_url(SUBSCRIPTION);
				                                } else {//check expire
				                                    echo $relaModel['videoDetailPath'];
				                                }
				                            }
				                        }
										?>"><?php echo $title  ?></a></h5>
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
							</li>
						</ul>
					<?php endfor ?>
				</div>
			</div>
		<?php endfor; ?>
	</div>
	<?php if ($numberPost > 4): ?>
  		<!-- Controls -->
	  	<a class="left carousel-control" href="#carousel-related-video" role="button" data-slide="prev">
	  		<i class="fa fa-angle-left" aria-hidden="true"></i>
	  	</a>
	  	<a class="right carousel-control" href="#carousel-related-video" role="button" data-slide="next">
	  		<i class="fa fa-angle-right" aria-hidden="true"></i>
	  	</a>	
  	<?php endif ?>
</div>