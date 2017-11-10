<?php $this->load->view(THEME_VM_DIR.'/includes/header'); ?>

<div id="is-content" class="is-content" data-is-full-width="true">
	<div class="content-area ">
		<div class="breadcrumb bg-category">
			<div class="container">
				<h3 class="headding-title">
					Contact Us
				</h3>
			</div>
		</div>
		<div class="section ">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="contact-info">
							<img src="assets/images/img-contact.jpg" alt="">
							<div class="description">
								These tours are made for lovers and groups alike, as well as offering customized tours and additional single accommodations. Designed to dazzle the most inexperienced, as well as most elegant wine connoisseur, tours run May to November and are generally booked for five day and six nights stays.
							</div>
						</div>
						<div class="section">
							<div class="contact-form">
								<?php  echo $this->session->flashdata('email_sent');  ?>
								<?php  echo form_open_multipart(THEME_CONTROLLER_PATH.'/contact/form', array ('class' => 'video-form', 'role' => 'form')); ?>
								<form>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-input">
												<i class="fa fa-user" aria-hidden="true"></i>
												<input type="text" name="name" class="form-control" required placeholder="Your name">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-input">
												<i class="fa fa-envelope-o" aria-hidden="true"></i>
												<input type="email" name="email" class="form-control" required placeholder="Your email">
											</div>
										</div>
										<div class="col-sm-12">
											<textarea  id="" rows="10" class="form-control" required placeholder="Add a public comment"></textarea>
										</div>
									</div>	
									<input type="submit" class="button-submit" name="" value="SUBMIT">
								</form>
								<?php  echo form_close(); ?>
							</div>
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