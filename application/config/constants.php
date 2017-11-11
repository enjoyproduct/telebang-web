<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//Video Status
define('STATUS_ACTIVED', 2);

//Video Comment
define('COMMENT_STATUS_PENDING', 1);
define('COMMENT_STATUS_APPROVED', 2);

// Notification Module
define('NOTIFICATION_VIDEO_TYPE', 'video');
define('NOTIFICATION_NEWS_TYPE', 'news');
define('NOTIFICATION_MODULE_ENABLE', true);
define('FIREBASE_API_KEY', 'AIzaSyBwNFokgw31X5sQkPEIQSkSMO5wOLPbPdA');

// view action status
define('VIEW_ACTION_UPDATE', 1);
define('VIEW_ACTION_ADD_NEW', 2);
define('VIEW_ACTION_ERROR', 3);


//path
define('ROOT_PATH', '');// inspius/yovideo-backend
define('USER_PATH', 'assets/uploads/users/');
define('IMAGE_PATH', 'assets/uploads/images/');
define('VIDEO_PATH', 'assets/uploads/videos/');
define('SUB_PATH', 'assets/uploads/subtitles/');
define('STATICS_PAGE_PATH', 'assets/uploads/statics_page/');

//Api
define('YOUTUBE_API_KEY', 'AIzaSyC0MnHIIjZbWDY6BzJIxLCyz9h5_RwK9Mw');

//
define('COPYRIGHT', 'telebang.com');

# time for youtube cronjob in minutes, 1->60
define('TIME_YOUTUBE_CRON', (1)); # 0-60 minutes
define('MODULE_YOUTUBE_ENABLE', true);
define('MODULE_SERIES_ENABLE', true);

// Default
define('NO_IMAGE_PATH', IMAGE_PATH . 'no_image_default.png');

# Theme config
define('THEME_ENABLE', true);
define('THEME_CONTROLLER_PATH', 'vidhub');
define('THEME_VM_DIR', 'vidhub');
// url
define('HOME_PATH', 'vidhub');
define('VIDEO_DETAIL_PATH', '%s-%d.html');
define('VIDEOS_BY_CATEGORY_PATH', 'category/%d');
define('CATEGORIES_PATH', 'categories');
define('BLOG_PATH', 'blogs');
define('BLOG_DETAIL_PATH', 'blog/%s-%d.html');
define('ABOUTS_PATH', 'about-us');
define('CONTACT_US', 'contact-us');
define('USER_SETTING_PATH', 'user');
define('USER_MY_VIDEO_PATH', 'my-video');
define('SUBSCRIPTION_HISTORY', 'subscription_history');
define('SUBSCRIPTION', 'subscription');
define('LOGIN_ALERT', 'login_alert');
// V1 Key :c1-your_key

define('V1_SLIDE_TYPE_VIDEO', 's1-video');
define('V1_SLIDE_TYPE_NEWS', 's1-news');
define('V1_SLIDE_TYPE_URL', 's1-url');


//paystack key
define('PAYSTACK_SECRET', 'sk_test_1254a67b29e8ffafa4ed35e59493991761c70922');
define('PAYSTACK_PUBLIC', 'pk_test_072172819201269dc2248e051196e7db6fd84dc5');

define('SUBSCRIPTION_AMOUNT_PER_MONTH', 25);