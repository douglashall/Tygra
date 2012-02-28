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
    protected $termName;
    protected $termDisplayName;
    protected $termNum;
    protected $academicYear;
    protected $calendarYear;
    protected $schoolId;	
    
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
    
    public function setTermName($termName) {
        $this->termName = $termName;
    }
    
    public function getTermName() {
        return $this->termName;
    }
    
    public function setTermNum($termName) {
        $this->termNum = ($this->termName === 'Fall' ? 1 
            :  $this->termName === 'Spring' ? 2
            :  3);
    }
    
    public function getTermNum() {
        return $this->termNum;
    }
    
    public function setAcademicYear($academicYear) {
        $this->academicYear = $academicYear;
    }
    
    public function getAcademicYear() {
        return $this->academicYear;
    }
    
    public function toArray() {
        return array("keyword" => $this->keyword, "title" => $this->title, "videos" => $this->videos);
    }
    
    public function sortCmp($b) {
        $av = array($this->getAcademicYear(), $this->getTermNum(), $this->getTitle());
        $bv = array($b->getAcademicYear(), $b->getTermNum(), $b->getTitle());

        if($av[0] < $bv[0]) {
            return -1;
        } else if($av[0] == $bv[0]) {
            if($av[1] < $bv[1]) {
                return -1;
            } else if($av[1] == $bv[1]) {
                return strcasecmp($av[2], $bv[2]);
            } else {
                return 1;
            }           
        } else {
            return 1;
        }
    }
}
