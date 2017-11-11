<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<?php 
	    $head['headTitle'] = sprintf("%s Video - YoBackend", ($videoId > 0) ? 'Update' : 'Add');
	    $this->load->view('admin/includes/head',$head);
	?>
	<!-- END HEAD -->
	<body class="update-video">
		<?php $this->load->view('admin/includes/header'); ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<div class="page-content-wrapper">
						<!-- BEGIN CONTENT BODY -->
						<div class="page-content">
							<h1 class="page-header"><?php echo ($videoId > 0) ? 'Update' : 'Add' ?> Video</h1>
							<!-- END PAGE TITLE-->
							<?php
							if (isset($txtSuccess))
								echo '<p class="alert alert-success">' . $txtSuccess . '</p>';
							elseif (isset($txtError))
								echo '<p class="alert alert-danger">' . $txtError . '</p>';
							?>
							<!-- BEGIN PROFILE CONTENT -->
							<div class="profile-content">
								<div class="portlet light ">
									<div class="portlet-body">
										<?php echo form_open_multipart('index.php/admin/video/update/' . $videoId, array('class' => 'video-form', 'role' => 'form')); ?>
										<!--<form role="form" action="#">-->
										<div class="session clearfix">
											<div class="row ">
												<div class="form-group col-sm-10">
													<label class="control-label">Video Url (Youtube, Vimeo, Facebook...)</label>
													<div class="input-group">
														<input type="text" class="form-control" id="videoUrl" name="VideoUrl" value="<?php
														if (set_value('VideoUrl'))
															echo set_value('VideoUrl');
														else
															echo $videoUrl;
														?>">
														<span class="input-group-btn">
															<button class="btn blue " type="button" id="fetchVideoInfo"><span style="display: none" class="loading-icon glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Fetch Video Info</button>
														</span>
													</div>
												</div>
												<div class="form-group col-sm-2">
													<label class="control-label">Upload Video</label>
													<div class="input-group">
														<button class="btn blue btn-success" type="button" id="uploadVideo">Upload Video <i class="fa fa-upload" aria-hidden="true"></i></button>
													</div>                                                
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-8">
												<div class="session clearfix">
													<div class="form-group">
														<label class="control-label">Video Title</label>
														<input type="text" id="videoTitle" required value="<?php
														if (set_value('VideoTitle'))
															echo set_value('VideoTitle');
														else
															echo $videoTitle;
														?>" class="form-control" name="VideoTitle" required="required"/>
													</div>
													<div class="form-group">
														<label class="control-label">Video Description</label>
															<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
															<script>tinymce.init({ selector:'textarea' });</script>															
															<textarea class="form-control" rows="5" id="videoDesc" name="VideoDesc">
																<?php
																	if (set_value('VideoDesc'))
																		echo set_value('VideoDesc');
																	else
																		echo $videoDesc;
																?>																	
															</textarea>
													</div>
												</div>
												<div class="session clearfix">
													<div class="form-group clearfix">
														<h5>Episode</h5>
														<div class="row">
															<div class="form-group col-sm-6">
																<label class="control-label">Series ID</label>
																<input type="number" value="<?php
																if (set_value('Series'))
																	echo set_value('Series');
																else
																	echo $series;
																?>" class="form-control" name="Series"/>
															</div>

															<div class="form-group col-sm-6">
																<label class="control-label">Episode No.</label>
																<input type="number" value="<?php
																if (set_value('EpisodeNo'))
																	echo set_value('EpisodeNo');
																else
																	echo $episodeNo;
																?>" class="form-control" name="EpisodeNo" />
															</div>
														</div>
													</div>

												</div>
												<div class="session clearfix">
													<div class="form-group clearfix">
														<h5>Social</h5>
														<div class="row">
															<div class="form-group col-sm-6">
																<label class="control-label">View Count</label>
																<input type="number" value="<?php
																if (set_value('ViewCount'))
																	echo set_value('ViewCount');
																else
																	echo $viewCount;
																?>" class="form-control" name="ViewCount" />
															</div>
															<div class="form-group col-sm-6">
																<label class="control-label">Share Count</label>
																<input type="number" value="<?php
																if (set_value('ShareCount'))
																	echo set_value('ShareCount');
																else
																	echo $shareCount;
																?>" class="form-control" name="ShareCount" />
															</div>
															<div class="form-group col-sm-6">
																<label class="control-label">Like Count</label>
																<input type="number" value="<?php
																if (set_value('LikeCount'))
																	echo set_value('LikeCount');
																else
																	echo $likeCount;
																?>" class="form-control" name="LikeCount" />
															</div>
															<div class="form-group col-sm-6">
																<label class="control-label">Download Count</label>
																<input type="number" value="<?php
																if (set_value('DownloadCount'))
																	echo set_value('DownloadCount');
																else
																	echo $downloadCount;
																?>" class="form-control" name="DownloadCount" />
															</div>
														</div>
													</div>

												</div>
											</div>
											<div class="col-sm-4">
												<div class="session clearfix">
													<div class="form-group ">
														<label class="control-label">Status</label>
														<?php if (set_value('StatusId')) $statusId = set_value('StatusId'); ?>
														<select class="form-control" name="StatusId">
															<?php foreach ($listStatus as $s) { ?>
																<option value="<?php echo $s['StatusId']; ?>"<?php if ($s['StatusId'] == $statusId) echo ' selected="selected"'; ?>><?php echo $s['StatusName']; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="form-group ">
														<label class="control-label">Video Length (second)</label>
														<input type="number" id="videoLength" value="<?php
														if (set_value('VideoLength'))
															echo set_value('VideoLength');
														else
															echo $videoLength;
														?>" class="form-control" name="VideoLength"/>
													</div>
												</div>
												<div class="session clearfix">
													<div class="form-group clearfix">
														<h5>Video Thumbnail</h5>
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-new thumbnail">
																<img id="videoImage"  class="image_preview"  src="<?php echo $videoImage; ?>" alt="" />
																<input type="text" hidden="hidden" name="VideoImageFetch" id="videoImageFetch" value="<?php echo $videoImage; ?>"/>
																<input type="text" hidden="hidden" name="VideoTypeId" id="videoTypeId" value="<?php echo $videoTypeId; ?>"/>
															</div>
															<div class="select-img">
																<label for="uploadfileinput" class="btn-success btn default btn-file ">
																	<input type="file" name="VideoImage" id="uploadfileinput"> 
																	CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
																</label>
															</div>
														</div>
													</div>
												</div>
												<div class="session clearfix">
													<div class="form-group ">
														<h5>Category</h5>
														<div class="bg-white input-multiselect" >
															<?php foreach ($listCategories as $c) {  ?>
																<div class="checkbox">
																	<label>
																		<input type="checkbox" name="Categories[]" value="<?php echo $c['CategoryId']; ?>"<?php if (in_array($c['CategoryId'], $categoryIds)) echo ' checked="checked"'; ?>>
																		<?php echo $c['level'].$c['CategoryName']; ?>
																	</label>
																</div>
															<?php } ?>
														</div>
													</div>
												</div>
												<div class="session clearfix">
													<label class="control-label">Vip
														<input type="checkbox" class="make-switch" name="IsVip" data-size="small"<?php if ($isVip == 1) echo ' checked'; ?>/>
													</label>
													<label class="control-label">Trending
														<input type="checkbox" class="make-switch" name="IsTrending" data-size="small"<?php if ($isTrending == 1) echo ' checked'; ?>/>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="margiv-top-10">
										<input type="submit" name="submit" id="btnSubmit" class="btn green btn-success" value="Save"/>
										<a href="javascript:window.history.go(-1);" class="btn default btn-back">Back</a>
									</div>
									<!--</form>-->
									<?php echo form_close(); ?>
								</div>
							</div>
							<!-- END PROFILE CONTENT -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('admin/includes/script-head'); ?>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".video-form").validate();
				$('#fetchVideoInfo').click(function() {
					var videoUrl = $('input#videoUrl').val();
					$('.loading-icon').show();
					if (videoUrl.length > 0) {
						$.post("<?php echo site_url('index.php/admin/video/fetchVideoInfo'); ?>",
								{
									url: videoUrl
								},
						function(data, status) {
							$('.loading-icon').hide();
							if (status == "success") {
								if (data == "0")
									alert("Please enter Video url");
								else if (data == "1")
									alert("Please enter Video url on Youtube or Vimeo");
								else if (data == "2")
									alert("An error occurred in the implementation process!");
								else {
									var json = $.parseJSON(data);
									$(json).each(function(i, val) {
										$.each(val, function(k, v) {
											if (k == "type")
												$('input#videoTypeId').val(v);
												//$('select#videoType').val(v);
											else if (k == "duration")
												$('input#videoLength').val(v);
											else if (k == "title")
												$('input#videoTitle').val(v);
											else if (k == "description")
												$(tinymce.get('videoDesc').getBody()).text(v);
											else if (k == "image") {
												$('input#videoImageFetch').val(v);
												$('img#videoImage').attr('src', v);
											}
										});
									});
								}
							}
							else {
								alert("An error occurred in the implementation process!");
							}
						});
					}
					else {
						alert("Please enter Video url");
						$('input#videoUrl').focus();
					}
				});

				$('#uploadVideo').click(function() {
					var finder = new CKFinder();
					finder.resourceType = 'Videos';
					finder.selectActionFunction = function(fileUrl) {
						$('input#videoUrl').val(fileUrl);
						$('#fetchVideoInfo').addClass('disabled');
					};
					finder.popup();
				});

			});
			(function () {
                // function readURL(input) {

                //     if (input.files && input.files[0]) {
                //         var reader = new FileReader();

                //         reader.onload = function (e) {
                //             $('.image_preview').attr('src', e.target.result);
                //         };

                //         reader.readAsDataURL(input.files[0]);
                //     }
                // }

                // $("#uploadfileinput").change(function () {
                //     readURL(this);
                // });
                $('#uploadfileinput').click(function() {
					var finder = new CKFinder();
					finder.resourceType = 'Images';
					finder.selectActionFunction = function(fileUrl) {
						$('#videoImage').attr("src",fileUrl);
						$('#videoImageFetch').val(fileUrl);
					};
					finder.popup();
				});
            })(jQuery);
		</script>
	</body>
</html>
