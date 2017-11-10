<h4 class="title-siderbar">
	Most News
</h4>
<div id="carousel-most-new" class="carousel slide category-new" data-ride="carousel" data-interval="false">
  	<div class="carousel-inner" role="listbox">
  		<?php 
		$numberPost = count($newMost); 
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
						$newModel 	= $newMost[$postIndex];
						$image 		= $newModel['thumbnail'];
						$title 		= $newModel['title'];
						$view 		= $newModel['view'];
						$date 		= $newModel['update_at'];
						$newPath 	= $newModel['newDetailPath'];
			        if($image){
			            if(strpos($image, 'http') === false){
			                $image = base_url(IMAGE_PATH.$image);
			            }
			        }
			        else{
			            $image = base_url(NO_IMAGE_PATH);
			        }
			        if($postIndex % $perPage == 0) {
			        	?>
							<div class="item-video first clearfix">
								<time datetime="" >
									<?php echo date('d',$date) ?>
									<span><?php echo date('M',$date) ?></span>
								</time>
								<div class="last-new-img">
									<a href="<?php 
									// echo $newPath 
									if ($newModel['videoVip'] == 0) {
                                        echo $newModel['videoDetailPath'];
                                    } else {
                                        if ($customer_model) {
                                            if ($customer_model['IsVip'] == 0) {//customer is not subscribed
                                                echo site_url(SUBSCRIPTION);
                                            } else {//check expire
                                                echo $newModel['videoDetailPath'];
                                            }
                                        }
                                    } 
									?>">
										<img src="<?php echo $image ?>" alt="">
									</a>
								</div>
								<div class="video-infor clearfix">
									<h5><a href="#"><?php echo $title ?></a></h5>
									<div class="video-action">
										<div class="view">
											<i class="fa fa-eye" aria-hidden="true"></i>
											<span><?php echo $view ?> views</span>
										</div>
									</div>
								</div>
							</div>
			        	<?php
			        }else{
				?>
					<ul class="list-item">
						<li>
							<div class="item-video clearfix">
								<div class="thumbnail last-new-img">
									<a href="<?php 
									// echo $newPath 
									if ($newModel['videoVip'] == 0) {
                                        echo $newModel['videoDetailPath'];
                                    } else {
                                        if ($customer_model) {
                                            if ($customer_model['IsVip'] == 0) {//customer is not subscribed
                                                echo site_url(SUBSCRIPTION);
                                            } else {//check expire
                                                echo $newModel['videoDetailPath'];
                                            }
                                        }
                                    } 
									?>">
										<img src="<?php echo $image ?>" alt="">
									</a>
								</div>
								<time datetime="" >
									<?php echo date('d',$date) ?>
									<span><?php echo date('M',$date) ?></span>
								</time>
								<div class="video-infor">
									<h5><a href="<?php 
									// echo $newPath 
									if ($newModel['videoVip'] == 0) {
                                        echo $newModel['videoDetailPath'];
                                    } else {
                                        if ($customer_model) {
                                            if ($customer_model['IsVip'] == 0) {//customer is not subscribed
                                                echo site_url(SUBSCRIPTION);
                                            } else {//check expire
                                                echo $newModel['videoDetailPath'];
                                            }
                                        }
                                    } 
									?>"><?php echo $title  ?></a></h5>
									<div class="video-action">
										<div class="view">
											<i class="fa fa-eye" aria-hidden="true"></i>
											<span><?php echo $view ?> views</span>
										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>
				<?php } ?>
				<?php endfor ?>
			</div>
		</div>
		<?php endfor; ?>
	</div>
	<?php if ($numberPost > 4): ?>
  		<!-- Controls -->
	  	<a class="left carousel-control" href="#carousel-most-new" role="button" data-slide="prev">
	  		<i class="fa fa-angle-left" aria-hidden="true"></i>
	  	</a>
	  	<a class="right carousel-control" href="#carousel-most-new" role="button" data-slide="next">
	  		<i class="fa fa-angle-right" aria-hidden="true"></i>
	  	</a>	
  	<?php endif ?>
</div>