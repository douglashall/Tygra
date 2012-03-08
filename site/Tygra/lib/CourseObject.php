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
    protected $academicYear;
    protected $calendarYear;
    protected $schoolId;
    private $termOrder; // lazy init, maps termNames to orderNumbers
    
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

    public function setSchoolId($schoolId) {
        $this->schoolId = $schoolId;
    }
    
    public function getSchoolId() {
        return $this->schoolId;
    }
    
    public function setTermName($termName) {
        $this->termName = $termName;
    }
    
    public function getTermName() {
        return $this->termName;
    }
    
    public function setTermDisplayName($termDisplayName) {
        $this->termDisplayName = $termDisplayName;
    }
    
    public function getTermDisplayName() {
        return $this->termDisplayName;
    }
    
    public function setAcademicYear($academicYear) {
        $this->academicYear = $academicYear;
    }
    
    public function getAcademicYear() {
        return $this->academicYear;
    }
    
    public function setCalendarYear($calendarYear) {
        $this->calendarYear = $calendarYear;
    }
    
    public function getCalendarYear() {
        return $this->calendarYear;
    }
    
    public function getYearOrder() {
        return $this->calendarYear;
    }
    
    public function getTermOrder() {        
        if(!isset($this->termOrder)) {
            $this->termOrder = array_flip(array(
                'Winter',
                'Winter-Spring',
                'Spring',
                'Spring 1',
                'Spring 2',
                'Spring Saturday',
                'Summer',
                'Summer 1',
                'Summer 2',
                'Full Year',
                'Fall',
                'Fall 1',
                'Fall 2',
                'Fall-Winter',
                'Fall Saturday',
            ));
        }
        
        $defaultOrder = 999;
        if(isset($this->termOrder[$this->termName])) {
            return $this->termOrder[$this->termName];
        }
        
        return $defaultOrder;
    }
    
    public function getTermGroupName() {
        return "{$this->termName} {$this->calendarYear}";
    }
    
    public function toArray() {
        return array("keyword" => $this->keyword, "title" => $this->title, "videos" => $this->videos);
    }
}
