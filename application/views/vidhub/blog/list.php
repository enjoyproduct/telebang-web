<?php $this->load->view(THEME_VM_DIR.'/includes/header'); ?>
<script>
	var page 	= <?php echo $page ?>;
	var perPage = <?php echo $perPage ?>;
</script>
<div id="is-content" class="is-content" data-is-full-width="true">
	<div class="content-area ">
		<div class="breadcrumb bg-category">
			<div class="container">
				<h3 class="headding-title">
					Blog
				</h3>
			</div>
		</div>
		<div class="section ">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="list-blog" id="div-list-blog">
							<?php foreach ($listBlogs as $value): ?>
								<div class="item-blog">
									<div class="category"><?php echo date('d-M-Y', $value['update_at']) ?></div>
									<h3>
										<a href="<?php echo $value['newDetailPath'] ?>">
											<?php echo $value['title'] ?>
										</a>
									</h3>
									<div class="img-blog">
										<a href="<?php echo $value['newDetailPath'] ?>">
											<img src="<?php echo getImagePath($value['thumbnail']) ?>" alt="<?php echo $value['title'] ?>">
										</a>
										<div class="video-action">
											<div class="view">
												<i class="fa fa-eye" aria-hidden="true"></i>
												<span><?php echo $value['view'] ?> Views</span>
											</div>
										</div>
									</div>
									<div class="description">
										<?php echo $value['short_description'] ?>
									</div>
									<a href="<?php echo $value['newDetailPath'] ?>" class="button-submit">READ MORE</a>
								</div>
							<?php endforeach ?>
						</div>
						<button class="loadmore" id="load-more-blog">LOAD MORE</button>
					</div>
					<div class="col-sm-4">
						<?php $this->load->view(THEME_VM_DIR.'/includes/socical'); ?>
						<div class="sider-bar lastest-new ">
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
<script>
	$('#load-more-blog').click(function(){
			$.ajax({
					url:"<?php echo base_url('api/getListNews'); ?>" + '/' + (page + 1) + '/' + perPage,
					type:'GET',
					success:function(res){
						res = JSON.parse(res);
						var htmlAppend = '';
						if(res.content) {
							console.log(res.content);
							for(var i=0,len = res.content.length;i<len;i++) {
								htmlAppend += '<div class="item-blog">';
								htmlAppend += '<div class="category">HUMAN OF AFRICA</div>';
								htmlAppend += '<h3>'+ res.content[i].title +'</h3>';
								htmlAppend += '<div class="img-blog"> <a href="<?php echo $value['newDetailPath'] ?>">';
								htmlAppend += '<img src="'+ res.content[i].thumbnail +'" alt=""></a>';
								htmlAppend += '<div class="video-action">';
								htmlAppend += '<div class="view">';
								htmlAppend += '<i class="fa fa-eye" aria-hidden="true"></i>';
								htmlAppend += '<span>'+ res.content[i].view +' Views</span>';
								htmlAppend += '</div></div></div>';
								htmlAppend += '<div class="description">'+ res.content[i].short_description +'</div>';
								htmlAppend += '<a href="' + 'blog/' + to_slug(res.content[i].title)+'-'+ res.content[i].id +'.html'+'" class="button-submit">READ MORE</a></div>';
							}
						}
						$('#div-list-blog').append(htmlAppend);
					htmlAppend = '';
						page = page + 1;
					}
			});
	});

	function to_slug(str) {
    str = str.toLowerCase();

    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');

    str = str.replace(/([^0-9a-z-\s])/g, '');

    str = str.replace(/(\s+)/g, '-');

    str = str.replace(/^-+/g, '');

    str = str.replace(/-+$/g, '');

    // return
    return str;
}
</script>