<?php

/**
 * Created by PhpStorm.
 * User: Billy
 * Date: 2/14/17
 * Time: 17:19
 */
class Push
{
    //notification title
    private $title;

    //notification message
    private $message;

    //notification image url
    private $image = null;

    //notification image url
    private $type;

    //notification image url
    private $contentID;

    //initializing values in this constructor
    function __construct($title, $message, $type, $contentID) {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->contentID = $contentID;
    }

    //getting the push notification
    public function getPush() {
        $res = array();
        $res['title'] = $this->title;
        $res['message'] = $this->message;

        $imagePath = $this->image;
        if($imagePath != null)
            $imagePath = base_url(IMAGE_PATH.$imagePath);

        $res['image'] = $imagePath;
        $res['content_type'] = $this->type;
        $res['content_id'] = $this->contentID;
        return $res;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getContentID()
    {
        return $this->contentID;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getImage()
    {
        if($this->image == null)
            return '';

        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }
}