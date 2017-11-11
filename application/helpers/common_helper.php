<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('getValueFromListObject')) {
    function getValueFromListObject($listObj, $keyId, $keyName, $objId)
    {
        $retVal = "";
        foreach ($listObj as $obj) {
            if ($obj[$keyId] == $objId) {
                $retVal = $obj[$keyName];
                break;
            }
        }
        return $retVal;
    }
}

if (!function_exists('getAvatarPath')){
    function getAvatarPath($image){
        if($image){
            if(strpos($image, 'http') === false){
                $image = base_url(USER_PATH.$image);
            }
        }
        else{
            $image = base_url(USER_PATH.'logo_inspius.png');
        }
        return $image;
    }
}

if (!function_exists('getImagePath')){
    function getImagePath($image){
        if($image){
            if(strpos($image, 'http') === false){
                $image = base_url(IMAGE_PATH.$image);
            }
        }
        else{
            $image = base_url(NO_IMAGE_PATH);
        }
        return $image;
    }
}

if (!function_exists('ddMMyyyy')) {
    function ddMMyyyy($dateStr, $dateFormat = "d/m/Y")
    {
        if (!empty($dateStr)) return date_format(date_create(trim($dateStr)), $dateFormat);
        return '';
    }
}

if (!function_exists('replaceSqlString')) {
    function replaceSqlString($arr)
    {
        foreach ($arr as $key => $value) {
            $arr[$key] = str_replace("'", "''", $value);
        }
        return $arr;
    }
}

if (!function_exists('isVideoFile')) {
    function isVideoFile($fileName)
    {
        $parts = explode('.', trim($fileName));
        if (!empty($parts)) {
            $ext = strtolower($parts[count($parts) - 1]);
            if (in_array($ext, array('mp4', '3gp', 'avi', 'webm', 'mkv', 'flv', 'ogg', 'wmv', 'mp3', 'm3u8'))) return true;
        }
        return false;
    }
}


function parse_vimeo($link)
{
    $regexstr = '~
            # Match Vimeo link and embed code
            (?:&lt;iframe [^&gt;]*src=")?       # If iframe match up to first quote of src
            (?:                         # Group vimeo url
                https?:\/\/             # Either http or https
                (?:[\w]+\.)*            # Optional subdomains
                vimeo\.com              # Match vimeo.com
                (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
                \/                      # Slash before Id
                ([0-9]+)                # $1: VIDEO_ID is numeric
                [^\s]*                  # Not a space
            )                           # End group
            "?                          # Match end quote if part of src
            (?:[^&gt;]*&gt;&lt;/iframe&gt;)?        # Match the end of the iframe
            (?:&lt;p&gt;.*&lt;/p&gt;)?              # Match any title information stuff
            ~ix';

    preg_match($regexstr, $link, $matches);

    return $matches[1];
}

if (!function_exists('getYouTubeIdFromURL')) {
    function getYouTubeIdFromURL($url)
    {
      $url_string = parse_url($url, PHP_URL_QUERY);
      parse_str($url_string, $args);
      return isset($args['v']) ? $args['v'] : false;
    }
}
if (!function_exists('to_slug')) {
function to_slug($str) {
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '-', $str);
    return $str;
}
}
if (!function_exists('getFullName')) {
    function getFullName($user)
    {   
        $fullname = '';
        $first_name = $user['FirstName'];
        if($first_name && !empty($first_name))
            $fullname = $first_name;

        $last_name = $user['LastName'];
        if($last_name && !empty($last_name))
            $fullname = $fullname.' '.$last_name;

        if(empty($fullname))
            $fullname =  $user['UserName'];

        return $fullname;

    }
}