<!-- BEGIN COMMENT CONTENT -->
<script>
	var page 	= <?php echo $page ?>;
	var perPage = <?php echo $perPage ?>;
	var videoId = <?php echo $id ?>
</script>
<h3 class="headding-comment">Leave A Reply</h3>
<div class="form-comment">
	<form method="post">
		<div class="alert alert-danger" style="display: none;">
			<div id="value"></div>
		</div>
		<div class="alert alert-success" style="display: none;">
			<div id="value"></div>
		</div>
		<textarea  id="comment_text" name="comment_text" rows="10" class="form-control" placeholder="Add a public comment"></textarea>
		<input type="submit" class="button-submit" name="" value="POST COMMENT">
	</form>
</div>
 <!-- END COMMENT CONTENT -->
<div class="list-comment">
	<h3 class="headding-comment">
		<?php if ($comments_counter > 1 ){ ?>
			<?php echo $comments_counter ?> Comments
		<?php } else { ?>
			<?php echo $comments_counter ?> Comment
		<?php } ?>
	</h3>
	<ul id="list-comment" class="list-unstyled " >
		<?php foreach ($listComments as  $value): ?>
			<li >
				<div class="item clearfix">
					<div class="avatar-user">
						<?php 
							$avatarComent = getImagePath($value['Avatar']);
							if ($avatarComent) {
								$avatarComent = USER_PATH.'logo_inspius.png';
							}else{
								$avatarComent = USER_PATH.$avatarComent;
							}
						 ?>
						<img src="<?php echo $avatarComent ?>" alt="">
					</div>
					<div class="info-comment">
						<h4 class="title-user">
							<?php echo $value['FirstName'] ?>  <?php echo $value['LastName'] ?> 
							<div class="entry-header">
								<span><i class="fa fa-calendar-o" aria-hidden="true"></i><time datetime=""><?php echo date('Y/m/d',$value['create_at']) ?></time></span>
							</div>
						</h4>
						<div class="text-comment">
							<?php echo $value['comment'] ?>
						</div>
					</div>
				</div>
			</li>
		<?php endforeach ?>
	</ul>
	<button  class="more loadmore" id="show-comment">SHOW MORE</button>
</div>
<script>
	$(document).ready(function() {
	    $(".button-submit").click(function(event){
	    	event.preventDefault();
	    	var video_id = <?php echo $id ?>;
	    	var comment_text = $('#comment_text').val();

		    jQuery.ajax({
	    		type: "POST",
	    		url: "<?php echo base_url('api/insertCommentVideo'); ?>",
	    		dataType: 'json',
	    		data: {
	    			video_id: video_id,
	    			comment_text: comment_text,
	    		},
	    		success: function(res){
	    			var code = res.code;
		            jQuery("div#value").html(res.message);
	    			console.log(res);
	    			if (code > 0) {
	    				jQuery("div.alert-success").show();
	    				jQuery("div.alert-danger").hide();
	    				location.reload();
	    			}else{
	    				jQuery("div.alert-danger").show();
	    				jQuery("div.alert-success").hide();
	    			}
	    			jQuery("div#value").html(res.message);
	    		}
	    	});
	    });
	    $('#show-comment').click(function(){
			$.ajax({
				url:"<?php echo base_url('api/getListCommentVideo'); ?>" + '/'+ videoId +'/'+ (page + 1) + '/' + perPage,
				type:'GET',
				success:function(res){
					res = JSON.parse(res);
					var htmlAppend = '';
					if(res.content) {
						console.log(res.content);
 						for(var i=0, len = res.content.length; i<len; i++) {
							var date = new Date(+res.content[i].create_at * 1000);
							var showDate = date.getFullYear() + '/' + date.getMonth() + '/' + date.getDate();
							htmlAppend += '<li >';
							htmlAppend += '<div class="item clearfix">';
							htmlAppend += '<div class="avatar-user">';
							htmlAppend += '<img src="'+ res.content[i].Avatar +'" alt=""></div>';
							htmlAppend += '<div class="info-comment">';
							htmlAppend += '<h4 class="title-user">'+ res.content[i].FirstName + ' ' + res.content[i].FirstName+'';
							htmlAppend += '<div class="entry-header">';
							htmlAppend += '<span><i class="fa fa-calendar-o" aria-hidden="true"></i><time datetime="">'+ showDate +'</time></span></h4>';
							htmlAppend += '<div class="text-comment">'+ res.content[i].comment +'</div>';
						}
					}
					$('#list-comment').append(htmlAppend);
				htmlAppend = '';
					page = page + 1;
				}
			});
		});
	});
</script>