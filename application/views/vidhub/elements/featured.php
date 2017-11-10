<!-- Place somewhere in the <body> of your page -->
<div id="slider" class="flexslider">
  	<ul class="slides">
	  	<?php foreach ($videoTrending as $value):
	  		$image = $value['VideoImage'];
	  	?>
	  		<li>
		      	<div class="item-video clearfix">
	                <div class="img-feature">
	                	<a href="<?php 
	                	// echo $value['videoDetailPath'] 
	                	if ($value['videoVip'] == 0) {
                                echo $value['videoDetailPath'];
                            } else {
                                if ($customer_model) {
                                    if ($customer_model['IsVip'] == 0) {//customer is not subscribed
                                        echo site_url(SUBSCRIPTION);
                                    } else {//check expire
                                        echo $value['videoDetailPath'];
                                    }
                                } else {
									echo site_url(LOGIN_ALERT);
								}
                            } 
	                	?>">
	                    	<img data-u="image"  src="<?php echo $image ?>" />
	                	</a>
						<?php if ($value['videoVip'] == 1) { ?>
                            <h6 style="padding: 10px; margin-bottom: 0px; margin-top: 0px; background-color:#ffcc00; color:#000000;"><b>Subscription</b></h6>
                        <?php } ?>
	                </div>
	                
	                <div class="video-infor">
	                    <h5><a href="<?php 
	                    	// echo $value['videoDetailPath'] 
	                    	if ($value['videoVip'] == 0) {
                                echo $value['videoDetailPath'];
                            } else {
                                if ($customer_model) {
                                    if ($customer_model['IsVip'] == 0) {//customer is not subscribed
                                        echo site_url(SUBSCRIPTION);
                                    } else {//check expire
                                        echo $value['videoDetailPath'];
                                    }
                                } else {
									echo site_url(LOGIN_ALERT);
								}
                            } 
	                    ?>"><?php echo $value['VideoTitle']; ?></a></h5>
	                    <div class="video-action">
	                        <div class="view">
	                            <i class="fa fa-eye" aria-hidden="true"></i>
	                            <span><?php echo $value['ViewCount'] ?></span>
	                        </div>
	                        <div class="wishlist">
	                            <i class="fa fa-heart" aria-hidden="true"></i>
	                            <span><?php echo $value['likedCounter'] ?></span>
	                        </div>
	                    </div>
	                </div>
	            </div>
		    </li>
	  	<?php endforeach ?>
  	</ul>
</div>
<div id="carousel" class="flexslider">
  	<ul class="slides">
	  	<?php foreach ($videoTrending as $value):
	  		$image = $value['VideoImage'];
	  	?>
	  		<li>
		      	<div class="item-video clearfix">
	                <div class="img-feature-slider">
	                    <a href="<?php 
	                    // echo $value['videoDetailPath'] 
	                    if ($value['videoVip'] == 0) {
                                echo $value['videoDetailPath'];
                            } else {
                                if ($customer_model) {
                                    if ($customer_model['IsVip'] == 0) {//customer is not subscribed
                                        echo site_url(SUBSCRIPTION);
                                    } else {//check expire
                                        echo $value['videoDetailPath'];
                                    }
                                } else {
									echo site_url(LOGIN_ALERT);
								}
                            } 
	                    ?>">
	                        <img data-u="image" src="<?php echo getImagePath($image) ?>" />
	                    </a>
	                </div>
	                <div class="video-infor">
	                    <h5><a href="#"><?php echo $value['VideoTitle']; ?></a></h5>
	                    <div class="video-action">
	                        <div class="view">
	                            <i class="fa fa-eye" aria-hidden="true"></i>
	                            <span><?php echo $value['ViewCount'] ?></span>
	                        </div>
	                        <div class="wishlist">
	                            <i class="fa fa-heart" aria-hidden="true"></i>
	                            <span><?php echo $value['likedCounter'] ?></span>
	                        </div>
	                    </div>
	                </div>
	            </div>
		    </li>
	  	<?php endforeach ?>
  	</ul>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(window).load(function() {
		  	$('#carousel').flexslider({
			    animation: "slide",
			    controlNav: false,
			    animationLoop: false,
			    slideshow: false,
			    itemWidth: 220,
			    itemHeight: 80,
			    itemMargin: 30,
			    asNavFor: '#slider'
			  });
		  	$('#slider').flexslider({
		        animation: "slide",
		        controlNav: false,
		        animationLoop: false,
		        slideshow: false,
		        sync: "#carousel"
		    });
		});
	});
</script>