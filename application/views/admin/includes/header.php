<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
        <div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Admin</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php echo base_url('index.php/admin/user/profile'); ?>">My Profile</a></li> |
				<li><a href="<?php echo base_url('index.php/admin/user/logout'); ?>">Logout</a></li>
			</ul>
        </div>
	</div>
</nav>