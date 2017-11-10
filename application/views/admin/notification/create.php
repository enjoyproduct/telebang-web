<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php
$head['headTitle'] = "Notification - YoBackend";
$this->load->view('admin/includes/head',$head);
?>
<body class="update-video">
<?php $this->load->view('admin/includes/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('admin/includes/sidebar'); ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <h1 class="page-header clearfix">
                        <span>Create Push Notification</span>
                    </h1>
                    <!-- END PAGE TITLE-->
                    <?php
                    if (isset($txtSuccess))
                        echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
                    elseif (isset($txtError))
                        echo '<p class="alert alert-danger">' . $txtError . '</p>';
                    ?>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                                <div class="portlet-body">
                                                    <?php echo form_open_multipart('index.php/admin/notification/sendMultiplePush/' . $type.'/'.$content_id, array('class' => 'news-form', 'role' => 'form')); ?>
                                                    <!--<form role="form" action="#">-->
                                                    <div class="col-sm-8">
                                                        <div class="session clearfix">
                                                            <div class="form-group">
                                                                <label class="control-label">Title</label>
                                                                <input type="text" id="Title" required value="<?php
                                                                if (set_value('Title'))
                                                                    echo set_value('Title');
                                                                else
                                                                    echo $title;
                                                                ?>" class="form-control" name="Title" required="required"/>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label">Message</label>
                                                            <textarea class="form-control" rows="9" id="message" required="required" name="Message"><?php
                                                                if (set_value('Message'))
                                                                    echo set_value('Message');
                                                                else
                                                                    echo $message;
                                                                ?></textarea>
                                                            </div>

                                                        </div>
                                                        <div class="margiv-top-10">
                                                            <input type="submit" name="submit" id="btnSubmit" class="btn green  btn-success"
                                                                   value="Send Message"/>
                                                            <?php if ($type == NOTIFICATION_VIDEO_TYPE) { ?>
                                                                <a href="<?php echo site_url('index.php/admin/video'); ?>"
                                                                   class="btn default  btn-back">Cancel</a>
                                                            <?php } else if ($type == NOTIFICATION_NEWS_TYPE) { ?>
                                                                <a href="<?php echo site_url('index.php/admin/news'); ?>"
                                                                   class="btn default  btn-back">Cancel</a>
                                                            <?php } ?>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="session clearfix">
                                                            <div class="form-group clearfix">
                                                                <h5>Image</h5>
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail">
                                                                        <?php
                                                                        $imagePath = $image;
                                                                        if(empty($imagePath)){
                                                                            $imagePath = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
                                                                        } ?>
                                                                        <img id="videoImage" src="<?php echo $imagePath; ?>" alt="" >
                                                                        <input type="text"  name="Image" hidden="hidden" id="videoImageFetch" value="<?php echo $image; ?>"/>
                                                                    </div>
                                                                    <div class="select-img">
                                                                        <button class="btn blue btn-success" type="button" id="choose_image">Change Image <i class="fa fa-upload" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--</form>-->
                                                <?php echo form_close(); ?>
                                            </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- END PROFILE CONTENT -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
<?php $this->load->view('admin/includes/script-head'); ?>
</body>
</html>
<script type="text/javascript">
    $('#choose_image').click(function() {
        var finder = new CKFinder();
        finder.resourceType = 'Images';
        finder.selectActionFunction = function(fileUrl) {
            $('#videoImage').attr("src",fileUrl);
            $('#videoImageFetch').val(fileUrl);
        };
        finder.popup();
    });
</script>