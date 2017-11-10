<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<?php 
	    $head['headTitle'] = sprintf("%s - YoBackend", 'Category List');
	    $this->load->view('admin/includes/head',$head);
	?>
	<!-- END HEAD -->
	
	<body class="category-list">
		<?php $this->load->view('admin/includes/header'); ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<div class="page-content">
						<h1 class="page-header clearfix">
							<span>Category list</span>
							<div class="btn-add">
								<a class="btn btn-success" href="<?php echo base_url('index.php/admin/category/update'); ?>">Create Category <i class="fa fa-plus" aria-hidden="true"></i></a>    
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
													<th>No.</th>
													<th>Category Name</th>
													<th>Display Order</th>
													<th>Is Top</th>
													<th>Status</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php 

												$no = 1;
												foreach ($listCategories as $c) { ?>
													<tr>
														<td><?php echo  $no; $no++ ?></td>
														<td><?php echo  $c['level'].$c['CategoryName']; ?></td>
														
														<td><?php echo $c['DisplayOrder']; ?></td>
														<td><?php echo ($c['IsTop'] == 1) ? 'Yes' : 'No'; ?></td>
														<td>
															<span class="label label-sm <?php echo getValueFromListObject($listStatus, 'StatusId', 'CssClass', $c['StatusId']); ?>">
																<?php echo getValueFromListObject($listStatus, 'StatusId', 'StatusName', $c['StatusId']); ?>
															</span>
														</td>
														<td>
															<div class="btn-group">
																<button class=" btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions
																	<i class="fa fa-angle-down"></i>
																</button>
																<ul class="dropdown-menu" role="menu">
																	<li>
																		<a href="<?php echo base_url('index.php/admin/category/update/' . $c['CategoryId']) ?>">
																			<i class="icon-docs"></i> Edit 
																		</a>
																	</li>
																	<li>
																		<a href="<?php echo base_url('index.php/admin/category/delete/' . $c['CategoryId']) ?>" onclick="return confirm('Are you sure to delete this category?');">
																			<i class="icon-tag"></i> Delete 
																		</a>
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
								<!-- END EXAMPLE TABLE PORTLET-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('admin/includes/script-head'); ?>
	</body>
</html>