<?php

abstract class PhotoDataController extends DataController
{
    protected $cacheFolder='Photos';
    protected $tag;
    protected $author;

    public static function getVideoDataControllers() {
        return array(
            'FlickrVideoController'=>'Flickr'
        );
    }
    
    protected function init($args) {
        parent::init($args);

        if (isset($args['TAG']) && strlen($args['TAG'])) {
            $this->tag = $args['TAG'];
        }
        
        if (isset($args['AUTHOR']) && strlen($args['AUTHOR'])) {
            $this->author = $args['AUTHOR'];
        }
    }

    abstract public function search($q, $start, $limit);
}
