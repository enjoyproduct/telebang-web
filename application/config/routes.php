<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Welcome';

// http://www.kode-blog.com/codeigniter-seo-friendly-urls/


//cms
$route['admin'] =  'admin/dashboard';

// Video Detail : abc.om/slug-id.html
$route['(:any)-(:num).html'] = THEME_CONTROLLER_PATH . '/videos/video_detail_page/$2';

// Home
$route[HOME_PATH] =  THEME_CONTROLLER_PATH . '/home';

// Video by Category : abc.com/cat_id
$route['category/(:any)'] = THEME_CONTROLLER_PATH . '/videos/videos_by_category_page/$1';

// Video categories page
$route['categories'] = THEME_CONTROLLER_PATH . '/videos/video_category_page';

// Blog
$route['blogs'] = THEME_CONTROLLER_PATH . '/blog';

// Blog Detail
$route['blog/(:any)-(:num)\.html'] = THEME_CONTROLLER_PATH . '/blog/detail/$2';

// About Us
$route['about-us'] = THEME_CONTROLLER_PATH . '/about';

// Contact us
$route['contact-us'] = THEME_CONTROLLER_PATH . '/contact';

$route['contact-form'] = THEME_CONTROLLER_PATH . '/contact';
// Subscription
$route['subscription_history/(:any)'] = THEME_CONTROLLER_PATH . '/subscription/subscription_history/$1';
$route['subscription'] = THEME_CONTROLLER_PATH . '/subscription/subscription_view';
// User Setting
$route['user'] = THEME_CONTROLLER_PATH . '/user/setting';

// My Video
$route['my-video'] = THEME_CONTROLLER_PATH . '/user/my_videos';

// Theme setting
$route['general-setting'] = THEME_CONTROLLER_PATH . '/themesetting';
$route['slide-setting'] = THEME_CONTROLLER_PATH . '/slidersetting';
//Login Alert
$route['login_alert'] = THEME_CONTROLLER_PATH . '/alert';