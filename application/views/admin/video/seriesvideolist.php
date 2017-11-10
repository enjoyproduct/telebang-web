<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <?php
        $head['headTitle'] = sprintf("%s - YoBackend", 'Video List');
        $this->load->view('admin/includes/head', $head);
    ?>
    <!-- END HEAD -->
    <body class="video-list">
        <?php $this->load->view('admin/includes/header'); ?>
        <div class="container-fluid">
            <div class="row">
                <?php $this->load->view('admin/includes/sidebar'); ?>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <div class="page-content">
                        <h1 class="page-header clearfix">
                            <span>Video list of Series <?php echo $series['name'] ?> </span>
                            <div class="btn-add">
                                <a class="btn btn-success" href="<?php echo base_url('index.php/admin/video/createVideoForSeriesId/' . $series['id_series']); ?>">Add More Video <i class="fa fa-plus" aria-hidden="true"></i></a> 
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
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover table-header-fixed" id="sample_2">
                                        <thead>
                                            <tr>
                                                <th>Episode No.</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $author = array ();
                                                foreach ($listVideos as $v) {
                                                    $lastUpdate = new DateTime($v['CrDateTime']);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $v['episode_no']; ?></td>
                                                        <td><?php echo $v['VideoTitle']; ?></td>
                                                        <td><span class="label label-sm <?php echo getValueFromListObject($listVideoTypes, 'VideoTypeId', 'CssClass', $v['VideoTypeId']); ?>"><?php echo getValueFromListObject($listVideoTypes, 'VideoTypeId', 'VideoTypeName', $v['VideoTypeId']); ?></span></td>
                                                        <td><span class="label label-sm <?php echo getValueFromListObject($listStatus, 'StatusId', 'CssClass', $v['StatusId']); ?>"><?php echo getValueFromListObject($listStatus, 'StatusId', 'StatusName', $v['StatusId']); ?></span></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions
                                                                    <i class="fa fa-angle-down"></i>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <?php if (NOTIFICATION_MODULE_ENABLE == true) { ?>
                                                                        <li>
                                                                            <a href="<?php echo base_url('index.php/admin/notification/create/' . NOTIFICATION_VIDEO_TYPE . '/' . $v['VideoId']) ?>">
                                                                                <i class="icon-docs"></i> Send Notification </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                    <li>
                                                                        <a href="<?php echo base_url('index.php/admin/video_comment/viewCommentListByVideoiD/' . $v['VideoId']) ?>">
                                                                            <i class="icon-docs"></i> List Comment </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="<?php echo base_url('index.php/admin/video/update/' . $v['VideoId']) ?>">
                                                                            <i class="icon-docs"></i> Edit </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="<?php echo base_url('index.php/admin/video/delete/' . $v['VideoId']) ?>" onclick="return confirm('Are you sure to delete this video?');">
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
<?php $this->load->view('admin/includes/script-head'); ?>
    </body>

</html>
