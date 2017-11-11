<h3 class="headding-sidebar">
	Categories
</h3>
<div id='cssmenu'>
	<ul>
	   	<?php
		   	function displayCate ($listCategoriesTree){
			   	foreach ($listCategoriesTree as $cate) {
			   		if(count($cate['children']) > 0) {
			   			echo '<li class=\'has-sub\' > <div class=\'icon-category\'><img src='.getImagePath($cate['CategoryIcon']).' alt=""></div>';
			   			echo '<a href="'.$cate['url_list_video'] .'" class=\'form-control\'><span>'.$cate['CategoryName'].'</span></a>';
			   			echo '<ul>';
			   			foreach ($cate['children'] as  $children) {
			   				displayCate(array($children));
			   			}
			   			echo '</ul>';
			   			echo '</li>';
			   		} else {
		   				echo '<li class=\'last\'> <div class=\'icon-category\' ><img src='.getImagePath($cate['CategoryIcon']).' alt=""></div>';
		   				echo '<a href="'.$cate['url_list_video'] .'" class=\'form-control\'><span>'.$cate['CategoryName'].'</span></a>';
		   				echo '</li> ';
			   		}
			   	}
			   	return;
	   		}
	   		displayCate($listCategoriesTree);
	   	?>
	</ul>
<a href="<?php echo site_url(CATEGORIES_PATH); ?>" class="form-control btn">SEE ALL CATEGORIES</a>
</div>
<script type="text/javascript">slider_category();</script>