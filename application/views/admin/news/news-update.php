<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<?php 
    $head['headTitle'] = sprintf("%s - YoBackend", ($id > 0) ? 'Update' : 'Add');
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
                    <h1 class="page-header"><?php echo ($id > 0) ? 'Update' : 'Add' ?> News Page</h1>
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
                                                <?php echo form_open_multipart('index.php/admin/news/update/' . $id, array('class' => 'news-form', 'role' => 'form')); ?>
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
                                                <div class="form-group">
                                                    <label class="control-label">Short Description</label>
                                                    <textarea class="form-control" rows="5" id="ShortDescription" name="ShortDescription"><?php
                                                        if (set_value('ShortDescription'))
                                                            echo set_value('ShortDescription');
                                                        else
                                                            echo $short_description;
                                                        ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Description</label>
														<textarea class="form-control" rows="5" id="pageDesc" name="Description"><?php
                                                        if (set_value('Description'))
                                                            echo set_value('Description');
                                                        else
                                                            echo $description;
                                                        ?>
                                                            
                                                        </textarea>
                                                </div>
                                                <div class="form-group clearfix">
                                                    <label class="control-label">Thumbnail</label><br>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            <img class="image_preview" src="<?php echo $thumbnail; ?>" alt=""/>
                                                            <input type="text" hidden="hidden" name="Thumbnail" id="thumbnail" value="<?php echo $thumbnail; ?>"/>
                                                        </div>
                                                        <div >
                                                            <label for="uploadfileinput" class="btn-success btn default btn-file ">
                                                                CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
                                                                <input type="file" name="Thumbnail" id="uploadfileinput"> 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix">
                                                    <label class="control-label" for="document-cat_asm">Category</label>
                                                    <div class="bg-white form-control input-multiselect clearfix" style="height:auto" tabindex="0">
                                                        <?php foreach ($categories as $c) { ?>
                                                            <div class="checkbox">
                                                                <label for="category<?php echo $c['id']; ?>">
                                                                    <input type="checkbox" name="Categories[]" id="category<?php echo $c['id']; ?>" value="<?php echo $c['id']; ?>"<?php if (in_array($c['id'], $categoryIdsSelected)) echo ' checked="checked"'; ?>>
                                                                    <?php echo $c['title']; ?>
                                                                </label>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="margiv-top-10">
                                                <input type="submit" name="submit" id="btnSubmit" class="btn green btn-success"
                                                       value="Save"/>
                                                <?php if ($id > 0) { ?>
                                                    <a href="<?php echo site_url('index.php/admin/news/delete/' . $id); ?>"
                                                       class="btn default btn-back">Delete</a>
                                                <?php } ?>
                                                <a href="<?php echo site_url('index.php/admin/news'); ?>"
                                                   class="btn default btn-back">Back</a>
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
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
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
        $('#uploadfileinput').click(function() {
            var finder = new CKFinder();
            finder.resourceType = 'Images';
            finder.selectActionFunction = function(fileUrl) {
                $('.image_preview').attr("src",fileUrl);
                $('#thumbnail').val(fileUrl);
            };
            finder.popup();
        });
        
    })(jQuery);
</script>