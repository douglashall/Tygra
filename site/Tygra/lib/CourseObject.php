<?php

/** 
 * Class to abstract course data
 *
 * Note: courses with an external URL will have a NULL keyword and vice versa.
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
    protected $externalUrl;

    // class property that maps termName to order
	protected static $termOrder = array (
		'Winter' => 0,
		'Winter-Spring' => 1,
		'Spring' => 2,
		'Spring 1' => 3,
		'Spring 2' => 4,
		'Spring Saturday' => 5,
		'Summer' => 6,
		'Summer 1' => 7,
		'Summer 2' => 8,
		'Full Year' => 9,
		'Fall' => 10,
		'Fall 1' => 11,
		'Fall 2' => 12,
		'Fall-Winter' => 13,
		'Fall Saturday' => 14
	);
	
	// class property for when a term's order is unknown
	protected static $unknownTermOrder = 999;

    public function __construct($data = array()) {    		
            if (isset($data['title'])) {
            	$this->title = $data['title'];
            }
            if (isset($data['keyword'])) {
            	$this->keyword = $data['keyword'];
            }
            if (isset($data['termName'])) {
            	$this->termName = $data['termName'];
            }
            if (isset($data['termDisplayName'])) {
            	$this->termDisplayName = $data['termDisplayName'];
            }
            if (isset($data['academicYear'])) {
            	$this->academicYear = $data['academicYear'];
            }
            if (isset($data['calendarYear'])) {
            	$this->calendarYear = $data['calendarYear'];
            }
            if (isset($data['schoolId'])) {
            	$this->schoolId = $data['schoolId'];
            }
            if (isset($data['externalUrl'])) {
            	$this->externalUrl = $data['externalUrl'];
            }
    }
    
    public function setKeyword($keyword) {
        $this->keyword = $keyword;
    }

    public function getKeyword() {
        return $this->keyword;
    }
    
    public function hasKeyword() {
    	return isset($this->keyword);
    }
    
    public function keywordEquals($keyword = '') {
    	if($this->hasKeyword()) {
    		return strcmp($this->keyword, $keyword) == 0;
    	}
    	return false;
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

    public function setExternalUrl($externalUrl) {
        $this->externalUrl = $externalUrl;
    }

    public function getExternalUrl() {
        return $this->externalUrl;
    }
    
    public function hasExternalUrl() {
    	return isset($this->externalUrl);	
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
        if(isset(self::$termOrder[$this->termName])) {
            return self::$termOrder[$this->termName];
        }
        return self::$unknownTermOrder;
    }
    
    public function getTermGroupName() {
        return "{$this->termName} {$this->calendarYear}";
    }
    
    public function toArray() {
        return array("keyword" => $this->keyword, "title" => $this->title, "videos" => $this->videos);
    }
}
