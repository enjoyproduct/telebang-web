<?php 
	$youtube_id = 'https://www.youtube.com/embed/'.getYouTubeIdFromURL($videoDetail['VideoUrl']);
?>
<div class="video-play">
	<iframe src="<?php echo $youtube_id ?>"  frameborder="0" allowfullscreen ></iframe> 
</div>