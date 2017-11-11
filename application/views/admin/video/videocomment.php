<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<?php 
	    $head['headTitle'] = sprintf("%s - YoBackend", 'Video List Comment');
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
							<span>Video list comment</span>
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
												<th>Comment</th>
												<th>Email</th>
												<th>Video</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$author = array();
											foreach ($pages as $v) {
												?>
												<tr>
													<td><?php echo date('Y-m-d H:i:s',$v['create_at']); ?></td>
													<td><?php echo $v['comment'] ?> </td>
													<td><?php echo $v['Email'] ?></td>
													<td><a href="<?php echo base_url('index.php/admin/video/update/'.$v['VideoId']) ?>"><?php echo $v['VideoTitle']; ?></a></td>
													<td>
													<?php  
														$check = $v['status_comment'];
														if ($check == 1) {
															?>
																<span class="label label-sm label-info">Pending</span>
															<?php
														}
														if ($check == 2) {
															?>
																<span class="label label-sm label-success">Approved</span>
															<?php
														}
													?>
													</td>
													<td>
														<div class="btn-group">
															<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions
																<i class="fa fa-angle-down"></i>
															</button>
															<ul class="dropdown-menu" role="menu">
																<li>
																	<a href="<?php echo base_url('index.php/admin/video_comment/updateStatus/' .COMMENT_STATUS_APPROVED."/".$v['id']) ?>">
																		<i class="icon-docs"></i> Approved </a>
																</li>
																<li>
																	<a href="<?php echo base_url('index.php/admin/video_comment/updateStatus/'.COMMENT_STATUS_PENDING."/".$v['id']) ?>">
																		<i class="icon-docs"></i> Pending </a>
																</li>
																<li>
																	<a href="<?php echo base_url('index.php/admin/video_comment/delete/' . $v['id']) ?>" onclick="return confirm('Are you sure to delete this comment?');">
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
