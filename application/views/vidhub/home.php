<?php $this->load->view(THEME_VM_DIR.'/includes/header'); ?>

<div id="is-content" class="is-content" data-is-full-width="true">
	<?php $this->load->view(THEME_VM_DIR.'/carousel/slider'); ?>
	<div class="content-area ">
		<div class="section">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<h3 class="headding-title">
							Latest Video
						</h3>
						<?php $this->load->view(THEME_VM_DIR.'/elements/latest-video'); ?>
					</div>
					<div class="col-sm-4">
						<?php $this->load->view(THEME_VM_DIR.'/includes/socical'); ?>
						<?php $this->load->view(THEME_VM_DIR.'/sidebar/category'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="section most-view">
			<?php $this->load->view(THEME_VM_DIR.'/elements/most-video'); ?>
		</div>
		<div class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<div class="feature-video">
							<h3 class="headding-title">
								Featured Videos
							</h3>
							<?php $this->load->view(THEME_VM_DIR.'/elements/featured'); ?>
						</div>
						<div class="banner">
							<h1 class="clearfix">
								<span class="main-color">LOVE OUR VIDEOS?</span> SUBSCRIBE NOW!
								<a href=""  target="_blank" class="btn pull-right">COMING SOON</a>
							</h1>
						</div>
						<div class="row">		
							<?php $this->load->view(THEME_VM_DIR.'/elements/category_selected'); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="sider-bar">
							<h4 class="title-siderbar">
								Popular Videos
							</h4>
							<?php $this->load->view(THEME_VM_DIR.'/sidebar/popular'); ?>
						</div>
						<div class="sider-bar banner-home">
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