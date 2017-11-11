<?php $currentUrl = uri_string(); ?>
<div id="cssmenu" class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">

        <li class="nav-item<?php if (strpos($currentUrl, 'dashboard') !== false) echo ' active open'; ?>">
            <a href="<?php echo base_url('index.php/admin/dashboard'); ?>" class="nav-link ">
                <i class="fa fa-tachometer" aria-hidden="true"></i>
                <span class="title">Dashboard</span>
            </a>
        </li>

        <li class="has-sub nav-item<?php if (strpos($currentUrl, 'video') !== false) echo ' active open'; ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-video-camera" aria-hidden="true"></i>
                <span class="title">Videos</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo base_url('index.php/admin/video'); ?>" class="nav-link ">
                        <span class="title">Video List</span>
                    </a>
                </li>
                <li class="nav-item<?php if (strpos($currentUrl, 'index.php/admin/video/update') !== false) echo ' active open'; ?>">
                    <a href="<?php echo base_url('index.php/admin/video/update'); ?>" class="nav-link ">
                        <span class="title">Add Video</span>
                    </a>
                </li>

                <?php if (MODULE_YOUTUBE_ENABLE == true) { ?>
                    <li class="nav-item<?php if (strpos($currentUrl, 'index.php/admin/youtube_chanel') !== false) echo ' active open'; ?>">
                        <a href="<?php echo base_url('index.php/admin/youtube_chanel'); ?>" class="nav-link ">
                            <span class="title">Youtube Channel</span>
                        </a>
                    </li>
                <?php } ?>

                <li class="nav-item<?php if (strpos($currentUrl, 'index.php/admin/video/comment') !== false) echo ' active open'; ?>">
                    <a href="<?php echo base_url('index.php/admin/video_comment'); ?>" class="nav-link ">
                        <span class="title">All Comments</span>
                    </a>
                </li>
                <?php if (MODULE_SERIES_ENABLE == true) { ?>
                    <li class="nav-item<?php if (strpos($currentUrl, 'index.php/admin/series') !== false) echo ' active open'; ?>">
                        <a href="<?php echo base_url('index.php/admin/series'); ?>" class="nav-link ">
                            <span class="title">Series Management</span>
                        </a>
                    </li>
                <?php } ?>

            </ul>
        </li>
        <li class="has-sub nav-item<?php if (strpos($currentUrl, 'index.php/admin/category') !== false) echo ' active open'; ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-th" aria-hidden="true"></i>
                <span class="title">Categories</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo base_url('index.php/admin/category'); ?>" class="nav-link ">
                        <span class="title">Category List</span>
                    </a>
                </li>
                <li class="nav-item<?php if (strpos($currentUrl, 'index.php/admin/category/update') !== false) echo ' active open'; ?>">
                    <a href="<?php echo base_url('index.php/admin/category/update'); ?>" class="nav-link ">
                        <span class="title">Add Category</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="has-sub nav-item<?php if (strpos($currentUrl, 'index.php/admin/user') !== false) echo ' active open'; ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span class="title">Users</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo base_url('index.php/admin/user/userlist'); ?>" class="nav-link ">
                        <span class="title">User List</span>
                    </a>
                </li>
                <li class="nav-item<?php if (strpos($currentUrl, 'user/update') !== false) echo ' active open'; ?>">
                    <a href="<?php echo base_url('index.php/admin/user/update'); ?>" class="nav-link ">
                        <span class="title">Add User</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="has-sub nav-item<?php if (strpos($currentUrl, 'index.php/admin/news') !== false) echo ' active open'; ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                <span class="title">News/Blog</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo base_url('index.php/admin/news'); ?>" class="nav-link ">
                        <span class="title">News List</span>
                    </a>
                </li>
                <li class="nav-item<?php if (strpos($currentUrl, 'news/update') !== false) echo ' active open'; ?>">
                    <a href="<?php echo base_url('index.php/admin/news_category'); ?>" class="nav-link ">
                        <span class="title">Categories</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php if (NOTIFICATION_MODULE_ENABLE == true): ?>
            <li class="has-sub nav-item<?php if (strpos($currentUrl, 'index.php/admin/notification') !== false) echo ' active open'; ?>">

                <a href="<?php echo base_url('index.php/admin/Notification/viewList'); ?>" class="nav-link ">
                    <i class="fa fa-flag" aria-hidden="true"></i>
                    <span class="title">Notification</span>
                </a>
            </li>
        <?php endif ?>
        <li class="has-sub nav-item<?php if (strpos($currentUrl, 'index.php/admin/staticpage') !== false) echo ' active open'; ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="title">Static Pages</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item<?php if (strpos($currentUrl, 'staticpage') !== false) echo ' active open'; ?>">
                    <a href="<?php echo base_url('index.php/admin/staticpage'); ?>" class="nav-link ">
                        <span class="title">Page List</span>
                    </a>
                </li>
                <li class="nav-item<?php if (strpos($currentUrl, 'staticpage/update') !== false) echo ' active open'; ?>">
                    <a href="<?php echo base_url('index.php/admin/staticpage/update'); ?>" class="nav-link ">
                        <span class="title">Add Page</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php if ($user['RoleId'] == 1) { ?>
            <li class="nav-item<?php if (strpos($currentUrl, 'index.php/admin/config') !== false) echo ' active open'; ?>">
                <a href="<?php echo base_url('index.php/admin/config'); ?>" class="nav-link nav-toggle">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <span class="title">Settings</span>
                </a>
            </li>
        <?php } ?>
        <?php if (THEME_ENABLE == true): ?>
            <li class="nav-item
            <?php if (strpos($currentUrl, 'ThemeSetting') !== false) echo ' active open'; ?> 
            <?php if (strpos($currentUrl, 'SliderSetting') !== false) echo ' active open'; ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <span class="title">Theme Setting</span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item<?php if (strpos($currentUrl, 'ThemeSetting') !== false) echo ' active open'; ?>">
                        <a href="<?php echo base_url(THEME_CONTROLLER_PATH . '/ThemeSetting'); ?>"
                           class="nav-link nav-toggle">
                            <span class="title">General Setting</span>
                        </a>
                    </li>
                    <li class="nav-item<?php if (strpos($currentUrl, 'SliderSetting') !== false) echo ' active open'; ?>">
                        <a href="<?php echo base_url(THEME_CONTROLLER_PATH . '/SliderSetting'); ?>"
                           class="nav-link nav-toggle">
                            <span class="title">Slider Setting</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif ?>
    </ul>
    <div class="copyright">
        Copyright ©<br/> 2017 <a href="http://telebang.com" target="_blank">telebang</a> Proudly Nigerian.
    </div>
</div>
