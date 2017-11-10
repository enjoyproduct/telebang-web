<div id="carousel-most-video" class="carousel slide category-new" data-ride="carousel" data-interval="false">
  	<div class="carousel-inner" role="listbox">
	<?php 
		$numberPost = count($videosMost); 
		$numberPage = ceil($numberPost / 5);
        $offset = 0;
		for ($pageIndex = 0; $pageIndex < $numberPage; $pageIndex++):
        $offset = $pageIndex * 5;
    ?>
    	<div class="item <?= $pageIndex == 0 ? 'active' : '' ?>"">
	    	<ul class="list-item">
	    		<?php
			        for ($postIndex = (0 + $offset); $postIndex < ($offset + 5) && $postIndex < $numberPost; $postIndex++):
			        $videoModel = $videosMost[$postIndex];
			        $title = $videoModel['VideoTitle'];
			        $view = $videoModel['ViewCount'];
			        $like = $videoModel['likedCounter'];
			        $image = $videoModel['VideoImage'];
 			
			    ?>
		      	<li class="clearfix">
					<div class="item-video clearfix">
						<a href="<?php 
							// echo $videoModel['videoDetailPath']; 
							if ($videoModel['videoVip'] == 0) {
	                            echo $videoModel['videoDetailPath'];
	                        } else {
	                            if ($customer_model) {
	                                if ($customer_model['IsVip'] == 0) {//customer is not subscribed
	                                    echo site_url(SUBSCRIPTION);
	                                } else {//check expire
	                                    echo $videoModel['videoDetailPath'];
	                                }
	                            }
	                        }
                        
						?>">
							<div class="thumbnail w3">
								<img src="<?php echo $image ?>" alt="">
							</div>
						</a>
						<div class="video-infor">
							<h5><a href="<?php 
							// echo $videoModel['videoDetailPath'] 
							if ($videoModel['videoVip'] == 0) {
	                            echo $videoModel['videoDetailPath'];
	                        } else {
	                            if ($customer_model) {
	                                if ($customer_model['IsVip'] == 0) {//customer is not subscribed
	                                    echo site_url(SUBSCRIPTION);
	                                } else {//check expire
	                                    echo $videoModel['videoDetailPath'];
	                                }
	                            }
	                        }
							?>"><?php echo $title ?></a></h5>
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
				<?php endfor; ?>
			</ul>
    	</div>
  	<?php endfor; ?>
  	</div>
  	<?php if ($numberPost > 5): ?>
  		<!-- Controls -->
	  	<a class="left carousel-control" href="#carousel-most-video" role="button" data-slide="prev">
	  		<i class="fa fa-angle-left" aria-hidden="true"></i>
	  	</a>
	  	<a class="right carousel-control" href="#carousel-most-video" role="button" data-slide="next">
	  		<i class="fa fa-angle-right" aria-hidden="true"></i>
	  	</a>	
  	<?php endif ?>
</div>