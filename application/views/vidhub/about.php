<?php $this->load->view(THEME_VM_DIR.'/includes/header'); ?>

<div id="is-content" class="is-content" data-is-full-width="true">
	<div class="content-area ">
		<div class="breadcrumb bg-category">
			<div class="container">
				<h3 class="headding-title">
					<?php echo $pageTitle ?>
				</h3>
			</div>
		</div>
		<div class="section ">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="portlet-body">
							<?php echo $pageDesc ?>
						</div>
					</div>
					<div class="col-sm-4">
						<?php $this->load->view(THEME_VM_DIR.'/includes/socical'); ?>
						<div class="sider-bar">
							<?php $this->load->view(THEME_VM_DIR.'/sidebar/banner'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view(THEME_VM_DIR.'/includes/footer'); ?>