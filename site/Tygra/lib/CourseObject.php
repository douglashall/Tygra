<?php

/* 
 * Class to abstract course data
 */
class CourseObject implements KurogoObject
{
    protected $keyword; //site keyword
    protected $title; // site title
    protected $videos = array();
    protected $siteId;
    protected $numVideos;
    
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
    	 //print_r("CourseObject[ ".var_dump($this->videos)." ]<br />");
        return $this->videos;
    }
    
    public function setNumVideos($count) {
        $this->numVideos = $count;
       
    }
    
    public function getNumVideos() {
        return $this->numVideos;
    }
    
    public function findVideoByEntryId($entryid){
    	foreach($this->$videos as $video){
    		if($video->getEntryId() == $entryid){
    			return $video;
    		}
    	}
    	return NULL;
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