<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>Youtube Playlist Subscribe</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <base href="<?php echo base_url(); ?>"/>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/global/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/global/dashboard.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<body class="video-list">
<?php $this->load->view('admin/includes/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('admin/includes/sidebar'); ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="page-content">
                <h1 class="page-header"><span>Youtube Channel</span>
                    <div class="btn-add">
                        <a class="btn btn-success"
                           href="<?php echo base_url('index.php/admin/youtube_chanel/create'); ?>">Create
                            New<i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </h1>
                <?php
                if (isset($txtSuccess))
                    echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
                elseif (isset($txtError))
                    echo '<p class="alert alert-danger">' . $txtError . '</p>';
                ?>
                <!-- END PAGE HEADER-->
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="">
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover table-header-fixed"
                                       id="sample_2">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Channel ID or Username</th>
                                        <th>Categories</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $author = array();
                                    foreach ($items as $item) {
                                        ?>
                                        <tr>
                                            <td><?php echo $item['title']; ?></td>
                                            <td>
                                                <?php if($item['username'] != '') {echo $item['username'];} else {  echo $item['chanel_id'];} ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $cateNames = "";
                                                    $categoryIds = explode(',', $item['category_ids']);
                                                    foreach ($categoryIds as $categoryId) {
                                                            if (isset($listCategories[$categoryId]))
                                                                    $cateNames.=$listCategories[$categoryId] . ', ';
                                                    }
                                                    if (!empty($cateNames))
                                                            echo substr($cateNames, 0, strlen($cateNames) - 2);
                                                ?>
                                                <?php //  echo $item['category_ids']; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-expanded="false">Actions
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="<?php echo base_url('index.php/admin/youtube_chanel/importNow/' . $item['id']) ?>">
                                                                <i class="icon-docs"></i> Import Now </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo base_url('index.php/admin/youtube_chanel/detail/' . $item['id']) ?>">
                                                                <i class="icon-docs"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo base_url('index.php/admin/youtube_chanel/delete/' . $item['id']) ?>"
                                                               onclick="return confirm('Are you sure to delete this page?');">
                                                                <i class="icon-tag"></i> Delete </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END FOOTER -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
        type="text/javascript"></script>
<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="assets/pages/scripts/table-datatables-fixedheader.min.js" type="text/javascript"></script>
</body>

</html>
