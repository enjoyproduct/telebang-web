<div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:800px;height:300px;overflow:hidden;visibility:hidden;">
    <!-- Loading Screen -->
    <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
        <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
        <div style="position:absolute;display:block;background:url('assets/images/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
    </div>
    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:800px;height:300px;overflow:hidden;">

        <?php 
        foreach ($sliderVideo as $value):        
        ?>
            <div class="item-slider">
                <a href="<?php echo $value['url'] ?>">
                    <div class="icon">
                        <?php if ( V1_SLIDE_TYPE_VIDEO == $value['type']): ?>
                            <img  src="assets/images/group-23.png" />
                        <?php endif ?>
                    </div>
                    <img data-u="image" class="img-slider" src="<?php echo $value['image'] ?>" />
                    <div class="infor-text">
                        <h6 style="z-index: 2"><?php echo $value['title'] ?></h6>
                        <h5 style="z-index: 2"><?php echo $value['sub_title'] ?></h5>
                    </div>
                </a>
            </div>
        <?php endforeach ?>
        <!-- <a data-u="any" href="http://www.jssor.com" style="display:none"></a> -->
        
    </div>
    <!-- Arrow Navigator -->
    <span data-u="arrowleft" class="jssora13l"  data-autocenter="2"></span>
    <span data-u="arrowright" class="jssora13r" data-autocenter="2"></span>
</div>