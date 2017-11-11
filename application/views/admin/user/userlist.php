<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<?php 
	    $head['headTitle'] = sprintf("%s - YoBackend", 'User List');
	    $this->load->view('admin/includes/head',$head);
	?>
	<body class="user-list">
		<?php $this->load->view('admin/includes/header'); ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<!-- BEGIN CONTENT BODY -->
					<div class="page-content ">
						<h1 class="page-header clearfix">
							<span>User list</span>
							<div class="btn-add">
								<a class="btn btn-success" href="<?php echo base_url('index.php/admin/user/update'); ?>">
									Create User 
									<i class="fa fa-plus" aria-hidden="true"></i>
								</a>   
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
								<div class="">
									<div class="portlet-body">
										<table class="table table-striped table-bordered table-hover table-header-fixed" id="sample_2">
											<thead>
												<tr>
													<th>UserName</th>
													<th>Email</th>
													<th>First Name</th>
													<th>Last Name</th>
													<th>Status</th>
													<th>Role</th>
													<th>Vip</th>
													<th>Actions</th>
												</tr>
											</thead>
											<!--<tfoot>
												<tr>
													<th>UserName</th>
													<th>Email</th>
													<th>First Name</th>
													<th>Last Name</th>
													<th>Status</th>
													<th>Role</th>
													<th>Is Vip</th>
													<th>Actions</th>
												</tr>
											</tfoot>-->
											<tbody>
												<?php foreach ($listUsers as $u) { ?>
													<tr>
														<td><?php echo $u['UserName']; ?></td>
														<td><?php echo $u['Email']; ?></td>
														<td><?php echo $u['FirstName']; ?></td>
														<td><?php echo $u['LastName']; ?></td>
														<td><span class="label label-sm <?php echo getValueFromListObject($listStatus, 'StatusId', 'CssClass', $u['StatusId']); ?>"><?php echo getValueFromListObject($listStatus, 'StatusId', 'StatusName', $u['StatusId']); ?></span></td>
														<td><span class="label label-sm <?php echo getValueFromListObject($listRoles, 'RoleId', 'CssClass', $u['RoleId']); ?>"><?php echo getValueFromListObject($listRoles, 'RoleId', 'RoleName', $u['RoleId']); ?></span></td>
														<td><?php echo ($u['IsVip'] == 1) ? 'Yes' : 'No'; ?></td>
														<td>
															<div class="btn-group">
																<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions
																	<i class="fa fa-angle-down"></i>
																</button>
																<ul class="dropdown-menu" role="menu">
																	<li>
																		<a href="<?php echo base_url('index.php/admin/user/update/' . $u['UserId']) ?>">
																			<i class="icon-docs"></i> Edit </a>
																	</li>
																	<li>
																		<a href="<?php echo base_url('index.php/admin/user/delete/' . $u['UserId']) ?>" onclick="return confirm('Are you sure to delete this user?');">
																			<i class="icon-tag"></i> Delete </a>
																	</li>
																	<?php if ($u['StatusId'] == 1) { ?>
																		<li>
																			<a href="<?php echo base_url('index.php/admin/user/updatestatus/' . $u['UserId']) ?>">
																				<i class="icon-user"></i> Update Status </a>
																		</li>
																	<?php } ?>
																</ul>
															</div>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
								<!-- END EXAMPLE TABLE PORTLET-->
							</div>
						</div>
					</div>
					<!-- END CONTENT BODY -->
				</div>
			</div>
		</div>
		<?php $this->load->view('admin/includes/script-head'); ?>
	</body>
</html>
