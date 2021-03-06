<h3 class="headding-title ">
    Featured Videos
</h3>
<div id="jssor_3" style="position:relative;margin:0 auto;top:0px;left:0px;width: 800px;height:350px;visibility:hidden;">
    <!-- Loading Screen -->
    <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
        <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
        <div style="position:absolute;display:block;background:url('assets/images/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
    </div>
    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:809px;height:350px;overflow:hidden;">
        <?php 
            foreach ($videoTrending as $value) {
        ?>
            <div>
                <div class="item-video clearfix">
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
                        <div class="thumbnail">
                            <img data-u="image" src="<?php echo getImagePath($value['VideoImage']) ?>" />
                        </div>
                    </a>
                    <?php if ($value['videoVip'] == 1) { ?>
                                <h6 style="padding: 10px; margin-bottom: 0px; margin-top: 0px; background-color:#ffcc00; color:#000000;"><b>Subscription</b></h6>
                            <?php } ?>
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
            </div>
        <?php
            }
        ?>
    </div>
    <!-- Bullet Navigator -->
    <div data-u="navigator" class="jssorb05 dot-cate" style="bottom:-5px;" data-autocenter="1">
        <!-- bullet navigator item prototype -->
        <div data-u="prototype"></div>
    </div>
</div>
<script type="text/javascript">jssor_carousel_category();</script>