<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<?php 
	    $head['headTitle'] = sprintf("%s - YoBackend", ($categoryId > 0) ? 'Update' : 'Add');
	    $this->load->view('admin/includes/head',$head);
	?>
	<!-- END HEAD -->
	<body class="update-category">
		<?php $this->load->view('admin/includes/header'); ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<div class="page-content-wrapper">
						<!-- BEGIN CONTENT BODY -->
						<div class="page-content">
							<h1 class="page-header"><?php echo ($categoryId > 0) ? 'Update' : 'Add' ?> Category</h1>
							<?php
							if (isset($txtSuccess))
								echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
							elseif (isset($txtError))
								echo '<p class="alert alert-danger">' . $txtError . '</p>';
							?>
							<!-- END PAGE HEADER-->
							<!-- BEGIN PROFILE CONTENT -->
							<div class="profile-content">
								<div class="portlet light ">
									<div class="portlet-body">
										<?php echo form_open_multipart('index.php/admin/category/update/' . $categoryId, array('class' => 'category-form', 'role' => 'form')); ?>
										<!--<form role="form" action="#">-->
										<div class="row">
											<div class="col-sm-6 ">
												<div class="form-group">
													<label class="control-label">Category Name <span class="required">*</span></label>
													<input type="text" required value="<?php
													if (set_value('CategoryName'))
														echo set_value('CategoryName');
													else
														echo $categoryName;
													?>" class="form-control" required name="CategoryName" />
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label class="control-label">Status</label>
													<?php if (set_value('StatusId')) $statusId = set_value('StatusId'); ?>
													<select class="form-control" name="StatusId">
														<?php foreach ($listStatus as $s) { ?>
															<option value="<?php echo $s['StatusId']; ?>"<?php if ($s['StatusId'] == $statusId) echo ' selected="selected"'; ?>><?php echo $s['StatusName']; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label class="control-label">Display Order</label>
													<?php if (set_value('DisplayOrder')) $displayOrder = set_value('DisplayOrder'); ?>
													<select class="form-control" name="DisplayOrder">
														<?php for ($i = 100; $i > 0; $i--) { ?>
															<option value="<?php echo $i; ?>"<?php if ($i == $displayOrder) echo ' selected="selected"'; ?>><?php echo $i; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label class="control-label">Parent Category</label>
													<?php if (set_value('ParentCategoryId')) $parentCategoryId = set_value('ParentCategoryId'); ?>
													<select class="form-control" name="ParentCategoryId">
														<option value="0">None</option>
														<?php
														foreach ($listCategories as $c) {
															if ($c['CategoryId'] != $categoryId) {
																?>
																<option value="<?php echo $c['CategoryId']; ?>"<?php if ($c['CategoryId'] == $parentCategoryId) echo ' selected="selected"'; ?>><?php echo $c['CategoryName']; ?></option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label">
												<input type="checkbox" class="make-switch" name="IsTop" data-size="small"<?php if ($isTop == 1) echo ' checked'; ?>/>
												Top
											</label>

										</div>
										<div class="form-group clearfix">
											<label class="control-label">Category Image</label><br>
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail">
													<img id="image_preview_cate" src="<?php echo $categoryImage; ?>" alt="" /> 
													<input type="text" hidden="hidden" name="CategoryImage" id="categoryImage" value="<?php echo $categoryImage; ?>"/>
												</div>
												<div class="select-img">
													<label for="uploadfileinputCate" class="btn-success btn default btn-file ">
														CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
														<input type="file" name="CategoryImage" class="uploadfileinput" id="uploadfileinputCate"> 
													</label>
												</div>
											</div>
										</div>
										<br>
										<div class="form-group clearfix">
											<label class="control-label">Category Icon</label><br>
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" >
													<img id="image_preview_icon" src="<?php echo $categoryIcon; ?>" alt="" /> 
													<input type="text" hidden="hidden" name="CategoryIcon" id="categoryIcon" value="<?php echo $categoryIcon; ?>"/>
												</div>
												<div  class="select-img">
													<label for="uploadfileinputIcon" class="btn-success btn default btn-file ">
														CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
														<input type="file" name="CategoryIcon" class="uploadfileinput" id="uploadfileinputIcon"> 
													</label>
												</div>
											</div>
										</div>
										<div class="submit">
											<input type="submit" name="submit" class="btn green btn-success" value="Save"/>
											<a href="<?php echo site_url('admin/category'); ?>" class="btn default btn-back">Back</a>
										</div>
										<!--</form>-->
										<?php echo form_close(); ?>
									</div>
								</div>
							</div>
							<!-- END PROFILE CONTENT -->
						</div>
					</div>
				</div>
			</div>
			<!-- END CONTENT -->
		</div>
		<?php $this->load->view('admin/includes/script-head'); ?>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".category-form").validate();

			});
			(function () {
                $('#uploadfileinputCate').click(function() {
					var finder = new CKFinder();
					finder.resourceType = 'Images';
					finder.selectActionFunction = function(fileUrl) {
						$('#image_preview_cate').attr("src",fileUrl);
						$('#categoryImage').val(fileUrl);
					};
					finder.popup();
				});
				$('#uploadfileinputIcon').click(function() {
					var finder = new CKFinder();
					finder.resourceType = 'Images';
					finder.selectActionFunction = function(fileUrl) {
						$('#image_preview_icon').attr("src",fileUrl);
						$('#categoryIcon').val(fileUrl);
					};
					finder.popup();
				});

            })(jQuery);
		</script>
	</body>
</html>