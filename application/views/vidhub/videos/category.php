<?php $this->load->view(THEME_VM_DIR.'/includes/header'); ?>

<div id="is-content" class="is-content" data-is-full-width="true">
	<div class="content-area ">
		<div class="breadcrumb bg-category">
			<div class="container">
				<h3 class="headding-title">
					Categories
				</h3>
			</div>
		</div>
		<div class="section ">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="section list-category top">
							<div class="row">
								<?php 
									foreach ($listCategory as $value) {
										?>
											<div class="col-sm-4">
												<div class="item-category">
													<a href="<?php echo $value['url_list_video'] ?>" title="">
														<div class="image-cate">
																<img src="<?php echo getImagePath($value['CategoryImage'])  ?>" alt="<?php echo $value['CategoryName'] ?>">
														</div>
														<div class="infor-cate">
															<h6><?php echo $value['CategoryName'] ?></h6>
															<span><i class="fa fa-video-camera" aria-hidden="true"></i><?php echo $value['videos_counter'] ?></span>
														</div>
													</a>
												</div>
											</div>
										<?php
									}
								?>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<?php $this->load->view(THEME_VM_DIR.'/includes/socical'); ?>
						<div class="sider-bar">
							<?php $this->load->view(THEME_VM_DIR.'/sidebar/category'); ?>
						</div>
						<div class="sider-bar">
							<?php $this->load->view(THEME_VM_DIR.'/sidebar/banner'); ?>
						</div>
						<div class="sider-bar lastest-new">
							<?php $this->load->view(THEME_VM_DIR.'/sidebar/latest-new'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view(THEME_VM_DIR.'/includes/footer'); ?>