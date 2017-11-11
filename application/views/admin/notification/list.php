<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<?php 
	    $head['headTitle'] = sprintf("%s - YoBackend", 'List Notification');
	    $this->load->view('admin/includes/head',$head);
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
							<span>List Notification</span>
						</h1>
						<!-- END PAGE HEADER-->
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="portlet-body">
									<table class="table table-striped table-bordered table-hover table-header-fixed" id="sample_2">
										<thead>
											<tr>
												<th>Create At</th>
												<th>Title</th>
												<th>Message	</th>
												<th>Data</th>
												<th>Type</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$author = array();
											foreach ($pages as $v) {
												// echo'<pre>';var_dump($v);
												?>
												<tr>
													<td><?php echo $v[Notification_model::COL_CREATE_AT]; ?></td>
													<td><?php echo $v[Notification_model::COL_TITLE] ?> </td>
													<td><?php echo $v[Notification_model::COL_MESSAGE] ?></td>
													<td>
														<?php  if ($v['type'] == NOTIFICATION_VIDEO_TYPE ) { ?>
															<a href="<?php echo base_url('index.php/admin/video/update/'.$v['video_id']); ?>">
															
																<?php echo $v['video_title'] ;?>
															</a>
														<?php } ?>
														<?php if ($v['type'] == NOTIFICATION_NEWS_TYPE ) { ?>
															<a href="<?php echo base_url('index.php/admin/news/update/'.$v['news_id']) ?>">
																
																<?php echo $v['news_title'] ?>
															</a>
														<?php } ?>
													</td>
													<td>
														<?php if ($v['type'] == NOTIFICATION_VIDEO_TYPE ): ?>
															<span class="label label-sm label-success"> Video </span>
														<?php endif ?>
														<?php if ($v['type'] == NOTIFICATION_NEWS_TYPE ): ?>
															<span class="label label-sm label-warning"> News </span>
														<?php endif ?>
													</td>
													<td>
														<a href="<?php echo base_url('index.php/admin/notification/delete/' . $v[Notification_model::COL_ID]) ?>" onclick="return confirm('Are you sure to delete this comment?');" class=" btn btn-delete">
																		<i class="icon-tag"></i> Delete </a>
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
