<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php 
    $head['headTitle'] = sprintf("%s - YoBackend", 'Dashboard');
    $this->load->view('admin/includes/head',$head);
?>

<body>
<?php $this->load->view('admin/includes/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('admin/includes/sidebar'); ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="page-content">
                <h1 class="page-header">Dashboard</h1>
                <div class="header-dashboard clearfix">
                    <div class="quick-search">
                        <div class="quick-search-left">
                            <span>Quick</span>PUBLISH
                        </div>
                        <div class="quick-search-form">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#url-form" aria-controls="url-form" role="tab" data-toggle="tab" aria-expanded="true">url</a></li>
                                <li role="presentation"><a href="#upload-form" aria-controls="upload-form" role="tab" data-toggle="tab" aria-expanded="false">upload</a></li>
                                <li role="presentation"><a href="#embed-form" aria-controls="embed-form" role="tab" data-toggle="tab" aria-expanded="false">Embed</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in  active clearfix" id="url-form">
                                    <form action="<?php echo base_url('index.php/admin/video/quickAddUrl'); ?>"  method="post">
                                        <input type="text" name="videoUrl" class="form-control" placeholder="Paste URL here…">
                                        <input type="submit" class="btn btn-search" value="Add video">
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane fade clearfix" id="upload-form">
                                    <label class="control-label">Upload Video</label>
                                    <form hidden="" id="quick_upload" action="<?php echo base_url('index.php/admin/video/quickUpload'); ?>" method="post">
                                        <input type="text" name="uploadUrl" id="uploadUrl">
                                        <input type="submit" >
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane fade clearfix" id="embed-form">
                                    <h3>Embed video</h3>
                                    <textarea name="" id="" cols="150" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-dashboard">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <a href="<?php echo base_url('index.php/admin/video'); ?>">
                                <div class="item-content">
                                    <div class="icon-image ">
                                        <img src="assets/images/combined-shape.png" alt="">
                                    </div>
                                    <h5>Videos Management</h5>
                                    <span>Click here to access and manage your Videos</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="<?php echo base_url('index.php/admin/category'); ?>">
                                <div class="item-content">
                                    <div class="icon-image ">
                                        <img src="assets/images/category.png" alt="">
                                    </div>
                                    <h5>Video Categories</h5>
                                    <span>Click here to access and manage your Video Categories</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="<?php echo base_url('index.php/admin/user/userlist'); ?>">
                                <div class="item-content">
                                    <div class="icon-image ">
                                        <img src="assets/images/user.png" alt="">
                                    </div>
                                    <h5>Users</h5>
                                    <span>Click here to access and manage your Users</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="<?php echo base_url('index.php/admin/news'); ?>">
                                <div class="item-content">
                                    <div class="icon-image ">
                                        <img src="assets/images/new.png" alt="">
                                    </div>
                                    <h5>News/Blog</h5>
                                    <span>Click here to access and manage your News post</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6"> 
                            <a href="<?php echo base_url('index.php/admin/staticpage'); ?>">
                                <div class="item-content">
                                    <div class="icon-image ">
                                        <img src="assets/images/static.png" alt="">
                                    </div>
                                    <h5>Pages</h5>
                                    <span>Click here to access and manage your Pages</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="<?php echo base_url('index.php/admin/config'); ?>">
                                <div class="item-content">
                                    <div class="icon-image ">
                                        <img src="assets/images/setting.png" alt="">
                                    </div>
                                    <h5>Settings</h5>
                                    <span>Click here to access and manage your Setting</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="https://codecanyon.net/user/inspitheme/portfolio" target="_blank">
                                <div class="item-content">
                                    <div class="icon-image ">
                                        <img src="assets/images/dowload.png" alt="">
                                    </div>
                                    
                                    <h5>App Download</h5>
                                    <span>Click here to download App</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="http://inspius.com/envato/forums/" target="_blank">
                                <div class="item-content">
                                    <div class="icon-image ">
                                        <img src="assets/images/support.png" alt="">
                                    </div>
                                    <h5>Support Forum</h5>
                                    <span>Click here to create ticket support</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/includes/script-head'); ?>
    <script>
        $(function(){
            $('#upload-form').click(function() {
                var finder = new CKFinder();
                finder.resourceType = 'Videos';
                finder.selectActionFunction = function(fileUrl) {
                $('input#uploadUrl').val(fileUrl);
                $('#quick_upload').submit();
                };
                finder.popup();
            });
        });
    </script>
</body>
</html>