<?php $this->load->view(THEME_VM_DIR.'/includes/header'); ?>

<div id="is-content" class="is-content blog-detail" data-is-full-width="true">
	<div class="content-area ">
		<div class="image" style="background-image: url('<?php echo $images ?>');">
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<div class="title-info">
						<div class="category">
							<?php echo date('d-M-Y', $date) ?>
						</div>
						<div class="entry-action">
							<span class="view">
								<i class="fa fa-eye" aria-hidden="true"></i>
								<span><?php echo $view ?></span>
							</span>
						</div>
						<h5 >
							<?php echo $title ?>
						</h5>
					</div>
					<div class="description">
						<?php echo $description ?>
					</div>
					<div class="socical-share clearfix">
						<?php $this->load->view(THEME_VM_DIR.'/elements/share-video'); ?>
					</div>
					
					<div class="article-recent">
						<div class="row">
								<?php
								 if ($preNews): ?>
									<div class="col-sm-6">
										<a href="<?php echo $preNews['newDetailPath'] ?>" class="clearfix">
								    		<div class="article-paging  text-left ">
								    			<span class="icon icon-left">
								    				<i class="fa fa-angle-left" aria-hidden="true"></i>
								    			</span>
											   	<div class="left">
											   		Previous Post <br> 
												    <span class="title">
												    	<?php echo $preNews['title'] ?>
												    </span>    
											   	</div>
								    		</div>
										</a>
							    	</div>
								<?php endif ?>

								<?php if ($nextNews): ?>
							    	<div class="col-sm-6">
										<a href="<?php echo $nextNews['newDetailPath'] ?>" class="clearfix">
								    		<div class="article-paging text-right clearfix">
								    			<div class="right">
												    Next Post <br>
												    <span class="title ">
												    	<?php echo $nextNews['title'] ?>
												    </span>    
								    			</div>
								    			<span class="icon icon-right">
								    				<i class="fa fa-angle-right" aria-hidden="true"></i>
								    			</span>
								    		</div>
										</a>
							    	</div>
								<?php endif ?>
						</div>
					</div>
					
				</div>
				<div class="col-sm-4">
					<div class="section">
						<?php $this->load->view(THEME_VM_DIR.'/includes/socical'); ?>
						<div class="sider-bar">
							<?php $this->load->view(THEME_VM_DIR.'/sidebar/most-new'); ?>
						</div>
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