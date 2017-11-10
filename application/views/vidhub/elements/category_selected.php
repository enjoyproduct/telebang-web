<?php 
if(!$categories_selected)
	return;
	$col_sm = 'col-sm-'.(12/count($categories_selected));
	$perPage = 4;
foreach($categories_selected  as $key1 => $cat_model) {
	$count[$key1] = count($cat_model);
	$countKey = count($key1);
	?>
	<div class="<?php echo $col_sm ?>">
		<div id="carousel-category-new-<?php echo $key1+1 ?>" class="category-new  carousel slide" data-ride="carousel" data-interval="false">
		  	<div class="carousel-inner" role="listbox">
		  		<?php 
				$numberPost = count($cat_model['videos']); 
				$numberPage = ceil($numberPost / 4);
		        $offset = 0;
				for ($pageIndex = 0; $pageIndex < $numberPage; $pageIndex++):
		        $offset = $pageIndex * 4;
		    ?>
	    	<div class="item <?= $pageIndex == 0 ? 'active' : '' ?>"">
				<div class="list-music">
					<h3 class="headding-title"><?php echo $cat_model['CategoryName'] ?></h3>
					<?php
					$perPage = 4;
					for ($postIndex = (0 + $offset); $postIndex < ($offset + 4) && $postIndex < $numberPost; $postIndex++):
						$newCate = $cat_model['videos'][$postIndex];
						$image = $newCate['VideoImage'];
						$title = $newCate['VideoTitle'];
						$view = $newCate['ViewCount'];
						$like = $newCate['likedCounter'];
						
						if($postIndex % $perPage == 0) {
							?>
								<div class="item-video first clearfix">
									<a href="<?php 
									// echo $newCate['videoDetailPath'] 
									if ($newCate['videoVip'] == 0) {
		                                echo $newCate['videoDetailPath'];
		                            } else {
		                                if ($customer_model) {
		                                    if ($customer_model['IsVip'] == 0) {//customer is not subscribed
		                                        echo site_url(SUBSCRIPTION);
		                                    } else {//check expire
		                                        echo $newCate['videoDetailPath'];
		                                    }
		                                } else {
											echo site_url(LOGIN_ALERT);
										}
		                            }
									?>">
										<div class="thumbnail w4">
											<img src="<?php echo getImagePath($image) ?>" alt="">
										</div>
									</a>
									<?php if ($newCate['videoVip'] == 1) { ?>
			                            <h6 style="padding: 10px; margin-bottom: 0px; margin-top: 0px; background-color:#ffcc00; color:#000000;"><b>Subscription</b></h6>
		                            <?php } ?>
									<div class="video-infor clearfix">
										<h5><a href="<?php 
										// echo $newCate['videoDetailPath'] 
										if ($newCate['videoVip'] == 0) {
			                                echo $newCate['videoDetailPath'];
			                            } else {
			                                if ($customer_model) {
			                                    if ($customer_model['IsVip'] == 0) {//customer is not subscribed
			                                        echo site_url(SUBSCRIPTION);
			                                    } else {//check expire
			                                        echo $newCate['videoDetailPath'];
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
							<?php
						} else {
						?>
						<ul class="list-item">
							<li>
								<div class="item-video clearfix">
									<a href="<?php 
										// echo $newCate['videoDetailPath'] 
										if ($newCate['videoVip'] == 0) {
			                                echo $newCate['videoDetailPath'];
			                            } else {
			                                if ($customer_model) {
			                                    if ($customer_model['IsVip'] == 0) {//customer is not subscribed
			                                        echo site_url(SUBSCRIPTION);
			                                    } else {//check expire
			                                        echo $newCate['videoDetailPath'];
			                                    }
			                                }
			                            }
									?>">
										<div class="thumbnail w3">
											<img src="<?php echo getImagePath($image) ?>" alt="">
										</div>
									</a>
									<?php if ($newCate['videoVip'] == 1) { ?>
			                            <h6 style="padding: 10px; margin-bottom: 0px; margin-top: 0px; background-color:#ffcc00; color:#000000;"><b>Subscription</b></h6>
		                            <?php } ?>
									<div class="video-infor">
										<h5><a href="<?php 
											// echo $newCate['videoDetailPath'] 
										if ($newCate['videoVip'] == 0) {
			                                echo $newCate['videoDetailPath'];
			                            } else {
			                                if ($customer_model) {
			                                    if ($customer_model['IsVip'] == 0) {//customer is not subscribed
			                                        echo site_url(SUBSCRIPTION);
			                                    } else {//check expire
			                                        echo $newCate['videoDetailPath'];
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
						</ul>
					<?php } endfor ?>
					</div>
				</div>
				<?php endfor; ?>
			</div>
			<?php if ($numberPost > 0): ?>
		  		<!-- Controls -->
			  	<a class="left carousel-control" href="#carousel-category-new-<?php echo $key1+1 ?>" role="button" data-slide="prev">
			  		<i class="fa fa-angle-left" aria-hidden="true"></i>
			  	</a>
			  	<a class="right carousel-control" href="#carousel-category-new-<?php echo $key1+1 ?>" role="button" data-slide="next">
			  		<i class="fa fa-angle-right" aria-hidden="true"></i>
			  	</a>	
		  	<?php endif ?>
		</div>
	</div>
<?php } ?>



