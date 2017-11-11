<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<?php
    $head['headTitle'] = sprintf("%s Slider - YoBackend", ($id > 0) ? 'Update' : 'Add');
    $this->load->view('admin/includes/head', $head);
?>
<!-- END HEAD -->
<body class="update-video">
<?php $this->load->view('admin/includes/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('admin/includes/sidebar'); ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <h1 class="page-header"><?php echo ($id > 0) ? 'Update' : 'Add' ?> Slider</h1>
                    <!-- END PAGE TITLE-->
                    <?php
                    if (isset($txtSuccess))
                        echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
                    elseif (isset($txtError))
                        echo '<p class="alert alert-danger">' . $txtError . '</p>';
                    ?>
                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content">
                        <div class="portlet light ">
                            <div class="portlet-body">
                                <?php echo form_open_multipart(THEME_CONTROLLER_PATH.'/SliderSetting/submit/' . $id, array ('class' => 'video-form', 'role' => 'form')); ?>
                                
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="session clearfix">
                                            <div class="form-group">
                                                <label class="control-label">Title</label>
                                                <input type="text" id="title" required value="<?php
                                                if (set_value('title'))
                                                    echo set_value('title');
                                                else
                                                    echo $title;
                                                ?>" class="form-control" name="title" required="required"/>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Sub Title</label>
                                               <input type="text" id="desc" required value="<?php
                                                    if (set_value('description'))
                                                        echo set_value('description');
                                                    else
                                                        echo $description;
                                                    ?>" class="form-control" name="description"/>
                                            </div>
                                            <div class="form-group clearfix">
                                                <div class="form-group">
                                                    <label  class="control-label">Slider Value <span>Id, Url, Link...</span></label>
                                                    <input type="text" id="type" required value="<?php
                                                    if (set_value('value'))
                                                        echo set_value('value');
                                                    else
                                                        echo $value;
                                                    ?>" class="form-control" name="value"/>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <div class="form-group">
                                                    <label  class="control-label">Slider Type</label>
                                                    <select class="form-control" name="type">
                                                        <option value="<?php echo V1_SLIDE_TYPE_VIDEO; ?>" <?php if (V1_SLIDE_TYPE_VIDEO == $type) echo ' selected="selected"'; ?>>Video</option>
                                                        <option value="<?php echo V1_SLIDE_TYPE_URL; ?>" <?php if (V1_SLIDE_TYPE_URL == $type) echo ' selected="selected"'; ?>>URL</option>
                                                        <option value="<?php echo V1_SLIDE_TYPE_NEWS; ?>" <?php if (V1_SLIDE_TYPE_NEWS == $type) echo ' selected="selected"'; ?>>News</option>
                                                    </select>
                                                </div>
                                            </div>
    
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="session clearfix">
                                            <div class="form-group clearfix">
                                                <div class="form-group">
                                                    <label  class="control-label">Display Order</label>
                                                    <input type="number" id="type" required value="<?php
                                                    if (set_value('display_order'))
                                                        echo set_value('display_order');
                                                    else
                                                        echo $display_order;
                                                    ?>" class="form-control" name="display_order" required="required"/>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <h5>Slider Thumbnail</h5>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img id="thumbnail" class="image_preview" src="<?php echo $image; ?>" alt="" />
                                                        <input type="text" hidden="hidden" name="VideoImageFetch" id="videoImageFetch" value="<?php echo $image; ?>"/>
                                                    </div>
                                                    <div class="select-img">
                                                        <label for="uploadfileinput" class="btn-success btn default btn-file ">
                                                            <input type="file" name="Thumbnail" id="uploadfileinput">
                                                            CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="margiv-top-10">
                                <input type="submit" name="submit" id="btnSubmit" class="btn green btn-success" value="Save"/>
                                <a href="<?php echo site_url(THEME_CONTROLLER_PATH.'/SliderSetting'); ?>"
                                   class="btn default btn-back">Back</a>
                            </div>
                            <!--</form>-->
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/includes/script-head'); ?>
<script type="text/javascript">
    $('#uploadfileinput').click(function() {
        var finder = new CKFinder();
        finder.resourceType = 'Images';
        finder.selectActionFunction = function(fileUrl) {
            $('.image_preview').attr("src",fileUrl);
            $('#videoImageFetch').val(fileUrl);
        };
        finder.popup();
    });

</script>
</body>
</html>
