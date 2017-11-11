<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php
$head['headTitle'] = sprintf("%s - YoBackend", 'Series List');
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
                    <span>Series list</span>
                    <div class="btn-add">
                        <a class="btn btn-success" href="<?php echo base_url('index.php/admin/series/update'); ?>">Create Series <i class="fa fa-plus" aria-hidden="true"></i></a>
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
                                    <th>Create at</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $author = array ();
                                foreach ($listSeries as $v) {
                                    $lastUpdate = new DateTime($v['created_at']);
                                    ?>
                                    <tr>
                                        <td><?php echo $lastUpdate->format('Y-m-d  H:i'); ?></td>
                                        <td><?php echo $v['name']; ?></td>
                                        <td><?php
                                            if($v['completed'])
                                                echo 'Completed';
                                            else
                                                echo 'On Going';
                                            ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="<?php echo base_url('index.php/admin/series/listVideoBySeriesId/' . $v['id_series']) ?>">
                                                            <i class="icon-docs"></i> List Video </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url('index.php/admin/series/createVideoForSeriesId/' . $v['id_series']) ?>">
                                                            <i class="icon-docs"></i> Create Video </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url('index.php/admin/series/update/' . $v['id_series']) ?>">
                                                            <i class="icon-docs"></i> Edit </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url('index.php/admin/series/delete/' . $v['id_series']) ?>" onclick="return confirm('Are you sure to delete this video?');">
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
