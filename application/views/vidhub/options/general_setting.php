<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<?php 
	    $head['headTitle'] = sprintf("%s - YoBackend", 'Theme Setting');
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
		                    <span>Theme Setting</span>
		                </h1>
		                <?php
		                    if (isset($txtSuccess))
		                        echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
		                    elseif (isset($txtError))
		                        echo '<p class="alert alert-danger">' . $txtError . '</p>';
		                ?>
	                	<?php echo form_open_multipart(THEME_CONTROLLER_PATH.'/ThemeSetting/submit/', array ('class' => 'video-form', 'role' => 'form')); ?>
	                		
							<div class="session clearfix ">
								<div class="form-setting">
									<div class="row">
										<!-- Nav tabs -->
										<div class="col-sm-2">
											<ul class="nav nav-tabs" role="tablist">
											    <li role="presentation" class="<?php if($tab_position == 1) echo 'active'; ?>"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General Setting</a></li>
											    <li role="presentation" class="<?php if($tab_position == 2) echo 'active'; ?>"><a href="#header" aria-controls="header" role="tab" data-toggle="tab">Header Setting</a></li>
											    <li role="presentation" class="<?php if($tab_position == 3) echo 'active'; ?>"><a href="#footer" aria-controls="footer" role="tab" data-toggle="tab">Footer Setting</a></li>
											    <li role="presentation" class="<?php if($tab_position == 4) echo 'active'; ?>"><a href="#video" aria-controls="video" role="tab" data-toggle="tab">Video Setting</a></li>
											</ul>
										</div>
										<div class="col-sm-10">
											<!-- Tab panes -->
											<div class="tab-content">
											    <div role="tabpanel" class="tab-pane <?php if($tab_position == 1) echo 'active'; ?>" id="general">
											    	<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Android</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text" value="<?php echo $android_url  ?>" class="form-control" name="Android" required="required"/>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">IOS</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text"   value="<?php echo $ios_url ?>" class="form-control" name="Ios" required="required"/>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Facebook</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text"  value="<?php echo $facebook_url  ?>" class="form-control" name="Facebook"/>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Google</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text"  value="<?php echo $google_url  ?>" class="form-control" name="Google" required="required"/>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Tiwtter</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text" value="<?php echo $twitter_url  ?>" class="form-control" name="Tiwtter" required="required"/>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Youtube</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text" value="<?php echo $youtube_url  ?>" class="form-control" name="Youtube" required="required"/>
				                						</div>
				                					</div>
											    </div>
											    <div role="tabpanel" class="tab-pane <?php if($tab_position == 2) echo 'active'; ?>" id="header">
											    	<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Site Title</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text" value="<?php echo $site_title  ?>" class="form-control" name="Title" required="required"/>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Site Headding</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text" value="<?php echo $site_headding  ?>" class="form-control" name="Headding" required="required"/>
				                						</div>
				                					</div>
				                					<div class="form-group clearfix">
							                            <label class="control-label">Favicon</label>
							                            <div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-new thumbnail">
																<div class="image-box">
																	<img  id="image_preview_favicon"  src="<?php echo $site_favicon ?>" alt="" /> 
																	<input type="text" hidden="hidden" name="Favicon"  id="favicon" value="<?php echo $site_favicon ?>"/>
																</div>
															</div>
															<div class="select-img">
																<label for="uploadfilefavicon" class="btn-success btn default btn-file ">
																	CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
																	<input type="file" name="Favicon" id="uploadfilefavicon"  class="uploadfileinput"> 
																</label>
															</div>
														</div>
							                        </div>
							                        <div class="form-group clearfix">
							                            <label class="control-label">Header Logo</label>
							                            <div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-new thumbnail">
																<div class="image-box">
																	<img  id="image_preview_logo"  src="<?php echo $header_logo ?>" alt="" /> 
																	<input type="text" hidden="hidden" name="Logo" id="logo" value="<?php echo $header_logo ?>"/>
																</div>
															</div>
															<div class="select-img">
																<label for="uploadfilelogo" class="btn-success btn default btn-file ">
																	CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
																	<input type="file" name="Logo" id="uploadfilelogo" class="uploadfileinput"> 
																</label>
															</div>
														</div>
							                        </div>
											    </div>
											    <div role="tabpanel" class="tab-pane <?php if($tab_position == 3) echo 'active'; ?>" id="footer">
											    	<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Footer Title</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text" value="<?php echo $footer_logo  ?>" class="form-control" name="FooterTitle"/>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Footer About</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text" value="<?php echo $footer_about  ?>" class="form-control" name="About" />
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Copyright</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text" value='<?php echo $footer_copyright ?>' class="form-control" name="Copyright" />
				                						</div>
				                					</div>
											    </div>
											    <div role="tabpanel" class="tab-pane <?php if($tab_position == 4) echo 'active'; ?>" id="video">
											    	<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Category video 1</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<?php if (set_value('Category1')) $home_category_1 = set_value('Category1'); ?>
															<select class="form-control" name="Category1">
																<option value="0">None</option>
																<?php
																foreach ($listCategories as $c) {
																	?>
																	<option value="<?php echo $c['CategoryId']; ?>"<?php if ($c['CategoryId'] == $home_category_1) echo ' selected="selected"'; ?>><?php echo $c['CategoryName']; ?></option>
																	<?php
																}
																?>
															</select>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Category video 2 </label>
				                						</div>
				                						<div class="col-sm-6">
				                							<?php if (set_value('Category2')) $home_category_2 = set_value('Category2'); ?>
															<select class="form-control" name="Category2">
																<option value="0">None</option>
																<?php
																foreach ($listCategories as $c) {
																	?>
																	<option value="<?php echo $c['CategoryId']; ?>"<?php if ($c['CategoryId'] == $home_category_2) echo ' selected="selected"'; ?>><?php echo $c['CategoryName']; ?></option>
																	<?php
																}
																?>
															</select>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Jwplayer Key</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<input type="text" value="<?php echo $jwplayer_key  ?>" class="form-control" name="JwplayerKey"/>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">About </label>
				                						</div>
				                						<div class="col-sm-6">
				                							<?php if (set_value('About_url')) $about_url = set_value('About_url'); ?>
															<select class="form-control" name="About_url">
																<option value="0">None</option>
																<?php
																foreach ($listPage as $c) {

																	?>
																	<option value="<?php echo $c['slug']; ?>"<?php if ($c['slug'] == $about_url) echo ' selected="selected"'; ?>><?php echo $c['PageTitle']; ?></option>
																	<?php

																}
																?> 

															</select>
				                						</div>
				                					</div>
				                					<div class="row form-group">
				                						<div class="col-sm-2">
				                							<label class="control-label">Enable Uppload</label>
				                						</div>
				                						<div class="col-sm-6">
				                							<label for="upload_enable" class="control-label">
				                								<input type="checkbox" class="make-switch" id="upload_enable" name="Upload_enable" data-size="small"<?php if ($upload_enable == 1) echo ' checked'; ?>/> <span>Check</span>
				                							</label>
				                						</div>
				                					</div>
											    </div>
											</div>
										</div>
									</div>
								</div>
	                			<div class="margiv-top-10">
	                                <input type="submit" name="submit" id="btnSubmit" class="btn green btn-success" value="Save"/>
	                            </div>
							</div>
		                    
	                    <?php echo form_close(); ?>
		            </div>
		        </div>
			</div>
			<!-- END CONTENT -->
		</div>
		<!-- END FOOTER -->
		<?php $this->load->view('admin/includes/script-head'); ?>
		<script type="text/javascript">
			(function () {
				$('#uploadfilelogo').click(function() {
					var finder = new CKFinder();
					finder.resourceType = 'Images';
					finder.selectActionFunction = function(fileUrl) {
						$('#image_preview_logo').attr("src",fileUrl);
						$('#logo').val(fileUrl);
					};
					finder.popup();
				});

		    })(jQuery);
		</script>
	</body>
</html>