<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<?php 
		$head['headTitle'] = sprintf("%s - YoBackend", 'News List');
		$this->load->view('admin/includes/head',$head);
	 ?>
	<body class="video-list">
		<?php $this->load->view('admin/includes/header'); ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<div class="page-content">
						<h1 class="page-header clearfix">
							<span>News List</span>
							<div class="btn-add">
								<a class="btn btn-success" href="<?php echo base_url('index.php/admin/news/update'); ?>">Create News <i class="fa fa-plus" aria-hidden="true"></i></a>
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
										<table class="table table-striped table-bordered table-hover table-header-fixed" id="sample_2">
											<thead>
												<tr>
													<th>Create At</th>
													<th>Title</th>
													<th>Description</th>
													<th>View Counter</th>
													<th>Actions</th>
											    </tr>
											</thead>
											<tbody>
												<?php
												$author = array();
												foreach ($pages as $page) {
													?>

													<tr>
														<td><?php echo date('Y-m-d H:i:s',$page['create_at']); ?></td>
													    <td><?php echo $page['title']; ?></td>
													    <td><?php echo $page['short_description']; ?></td>
													    <td><?php echo $page['view']; ?></td>
														<td>
															<div class="btn-group">
																<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions
																	<i class="fa fa-angle-down"></i>
																</button>
																<ul class="dropdown-menu" role="menu">
																	<?php if(NOTIFICATION_MODULE_ENABLE == true) { ?>
																		<li>
																			<a href="<?php echo base_url('index.php/admin/notification/create/'. NOTIFICATION_NEWS_TYPE.'/'. $page['id']) ?>">
																				<i class="icon-docs"></i> Send Notification </a>
																		</li>
																	<?php } ?>
																	<li>
																		<a href="<?php echo base_url('index.php/admin/news/update/' . $page['id']) ?>">
																			<i class="icon-docs"></i> Edit </a>
																	</li>
																	<li>
																		<a href="<?php echo base_url('index.php/admin/news/delete/' . $page['id']) ?>" onclick="return confirm('Are you sure to delete this page?');">
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
		<?php $this->load->view('admin/includes/script-head'); ?>>
	</body>

</html>
