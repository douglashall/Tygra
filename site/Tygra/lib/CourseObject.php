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
    
    public function getTermOrder() {
    	$orderOf = array(
    		'Fall' => 1,
    		'Spring' => 2,
		);
		$defaultOrder = 3;
		
		return isset($orderOf[$this->termName]) ? $orderOf[$this->termName] : $defaultOrder;
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
    
    public function toArray() {
        return array("keyword" => $this->keyword, "title" => $this->title, "videos" => $this->videos);
    }
}
