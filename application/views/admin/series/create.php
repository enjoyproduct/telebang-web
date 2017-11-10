<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<?php
$head['headTitle'] = sprintf("%s Series - YoBackend", ($id > 0) ? 'Update' : 'Add');
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
                    <h1 class="page-header"><?php echo ($id > 0) ? 'Update' : 'Add' ?> Series</h1>
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
                                <?php echo form_open_multipart('index.php/admin/series/update/' . $id, array ('class' => 'video-form', 'role' => 'form')); ?>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="session clearfix">
                                            <div class="form-group">
                                                <label class="control-label">Series Name</label>
                                                <input type="text" id="name" required value="<?php
                                                if (set_value('name'))
                                                    echo set_value('name');
                                                else
                                                    echo $name;
                                                ?>" class="form-control" name="name" required="required"/>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Series Description</label>
                                                <textarea class="form-control" rows="5" id="desc" name="desc"><?php
                                                    if (set_value('desc'))
                                                        echo set_value('desc');
                                                    else
                                                        echo $desc;
                                                    ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="session clearfix">
                                            <label class="control-label">Completed
                                                <input type="checkbox" class="make-switch" name="IsCompleted" data-size="small"<?php if ($isCompleted == 1) echo ' checked'; ?>/>
                                            </label>
                                        </div>

                                        <div class="session clearfix">
                                            <div class="form-group clearfix">
                                                <h5>Series Thumbnail</h5>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img id="thumbnail" class="image_preview" src="<?php echo $thumbnail; ?>" alt="" />
                                                        <input type="text" hidden="hidden" name="VideoImageFetch" id="videoImageFetch" value="<?php echo $thumbnail; ?>"/>
                                                        <input type="text" hidden="hidden" name="VideoTypeId" id="videoTypeId" value="<?php echo $thumbnail; ?>"/>
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
                                <a href="<?php echo site_url('index.php/admin/series'); ?>"
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
