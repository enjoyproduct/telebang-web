<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<?php 
	    $head['headTitle'] = sprintf("%s - YoBackend", 'Update Setting');
	    $this->load->view('admin/includes/head',$head);
	?>
	<!-- END HEAD -->
	<body class="update-setting">
		<?php $this->load->view('admin/includes/header');  ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="page-content">
                <h1 class="page-header clearfix">
                    <span>List Slider Video</span>
                    <div class="btn-add">
                        <a class="btn btn-success" href="<?php echo base_url(THEME_CONTROLLER_PATH.'/SliderSetting/add'); ?>">Create Slider <i class="fa fa-plus" aria-hidden="true"></i></a>
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
                                    <th>Order</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $author = array ();
                                foreach ($listSlider as $v) {
                                    ?>
                                    <tr>
                                        <td><?php echo $v[V1_slider_model::COL_ORDER] ?></td>
                                        <td><?php echo $v[V1_slider_model::COL_TITLE] ?></td>
                                        <td>
                                        	<?php 
                                        		$image = getImagePath($v[V1_slider_model::COL_IMAGE]);
                                        	?>
						                    <img src="<?php echo $image ?> " alt="">
                                        </td>
                                         <td>
                                         	<?php echo $v[V1_slider_model::COL_TYPE] ?>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="<?php echo base_url(THEME_CONTROLLER_PATH.'/SliderSetting/update/' .  $v[V1_slider_model::COL_ID]) ?>">
                                                            <i class="icon-docs"></i> Edit </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url(THEME_CONTROLLER_PATH.'/SliderSetting/delete/' .  $v[V1_slider_model::COL_ID]) ?>" onclick="return confirm('Are you sure to delete this slider?');">
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
			<!-- END CONTENT -->
		</div>
		<!-- END FOOTER -->
		<?php $this->load->view('admin/includes/script-head'); ?>
	</body>
</html>