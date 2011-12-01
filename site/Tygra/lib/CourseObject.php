<?php

/* 
 * Class to abstract course data
 */
class CourseObject implements KurogoObject
{
    protected $keyword; //site keyword
    protected $title; // site title
    protected $videos; //videos associated with the site
    protected $siteId;
    
    public function setKeyword($keyword) {
        $this->keyword = $keyword;
    }

    public function getKeyword() {
        return $this->keyword;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setVideos($videos) {
        $this->videos = $videos;
    }
    
    public function getVideos() {
        return $this->videos;
    }
    
    public function setSiteId($siteId) {
        $this->siteId = $siteId;
    }
    
    public function getSiteId() {
        return $this->siteId;
    }
    
    public function toArray() {
    	return array("keyword" => $this->keyword, "title" => $this->title, "videos" => $this->videos);
    }
}