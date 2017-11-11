<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php 
    $head['headTitle'] = sprintf("%s News Category Page - YoBackend", ($id > 0) ? 'Update' : 'Add');
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
                    <h1 class="page-header"></h1>
                    <h1 class="page-header clearfix">
                        <span><?php echo ($id > 0) ? 'Update' : 'Add' ?> News Category Page</span>
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
                                                <?php echo form_open_multipart('index.php/admin/news_category/update/' . $id, array('class' => 'news-form', 'role' => 'form')); ?>
                                                <!--<form role="form" action="#">-->

                                                <div class="form-group">
                                                    <label class="control-label">Title</label>
                                                    <input type="text" id="Title" required value="<?php
                                                    if (set_value('Title'))
                                                        echo set_value('Title');
                                                    else
                                                        echo $title;
                                                    ?>" class="form-control" name="Title" required="required"/>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <label class="control-label">Icon</label><br>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            <img src="<?php echo $icon; ?>" id="image_preview_icon" alt=""/>
                                                            <input type="text" hidden="hidden" name="Icon" id="icon" value="<?php echo $icon; ?>"/>
                                                        </div>
                                                        <div >
                                                            <label for="uploadfileinputIcon" class="btn-success btn default btn-file ">
                                                                CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
                                                                <input type="file" name="Icon"  class="uploadfileinput" id="uploadfileinputIcon"> 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <label class="control-label">Thumbnail</label><br>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            <img src="<?php echo $thumbnail; ?>" id="image_preview_cate" alt=""/>
                                                            <input type="text" hidden="hidden"  name="Thumbnail" id="thumbnail" value="<?php echo $thumbnail; ?>"/>
                                                        </div>
                                                        <div >
                                                            <label for="uploadfileinputCate" class="btn-success btn default btn-file ">
                                                                CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
                                                                <input type="file" name="Thumbnail"  class="uploadfileinput" id="uploadfileinputCate"> 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="margiv-top-10">
                                                <input type="submit" name="submit" id="btnSubmit" class="btn green  btn-success"
                                                       value="Save"/>
                                                <?php if ($id > 0) { ?>
                                                    <a href="<?php echo site_url('index.php/admin/news_category/delete/' . $id); ?>"
                                                       class="btn default  btn-back">Delete</a>
                                                <?php } ?>
                                                <a href="<?php echo site_url('index.php/admin/news_category'); ?>"
                                                   class="btn default  btn-back">Back</a>
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
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#pageDesc',
        height: 300,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
    (function () {
        $('#uploadfileinputCate').click(function() {
            var finder = new CKFinder();
            finder.resourceType = 'Images';
            finder.selectActionFunction = function(fileUrl) {
                $('#image_preview_cate').attr("src",fileUrl);
                $('#thumbnail').val(fileUrl);
            };
            finder.popup();
        });
        $('#uploadfileinputIcon').click(function() {
            var finder = new CKFinder();
            finder.resourceType = 'Images';
            finder.selectActionFunction = function(fileUrl) {
                $('#image_preview_icon').attr("src",fileUrl);
                $('#icon').val(fileUrl);
            };
            finder.popup();
        });
    })(jQuery);
</script>