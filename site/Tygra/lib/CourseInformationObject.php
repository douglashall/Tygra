<?php

/* 
 * Class to abstract course information data
 */
class CourseInformationObject implements KurogoObject
{
    protected $keyword; 
    protected $title;
    protected $subTitle; 
    protected $credits;
    protected $description;
    protected $instructorsDisplay;
    protected $preeq;

    protected $registrarCode;
    protected $department;
    protected $termName;
    protected $termDisplayName;
    protected $meetingTime;
    protected $location;
    protected $examGroup;
    protected $academicYear;
    protected $calendarYear;
    protected $school;
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
       
    public function setSubTitle($subTitle) {
        $this->subTitle = $subTitle;
    }
        
    public function getSubTitle() {
        return $this->subTitle;
    }  

    public function setCredits($credits) {
        $this->credits = $credits;
    }
      
    public function getCredits() {
        return $this->credits;
    } 
    
    public function setDescription($description) {
        $this->description = $description;
    }
      
    public function getDescription() {
        return $this->description;
    } 
    
    public function setInstructorsDisplay($instructorsDisplay) {
        $this->instructorsDisplay = $instructorsDisplay;
    }
      
    public function getInstructorsDisplay() {
        return $this->instructorsDisplay;
    } 
    
    public function setPrereq($prereq) {
        $this->prereq = $prereq;
    }
      
    public function getPrereq() {
        return $this->prereq;
    }    
    
  	public function setRegistrarCode($registrarCode) {
        $this->registrarCode = $registrarCode;
    }
      
    public function getRegistrarCode() {
        return $this->registrarCode;
    } 
    
    public function setDepartment($department) {
        $this->department = $department;
    }
      
    public function getDepartment() {
        return $this->department;
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
    public function setMeetingTime($meetingTime) {
        $this->meetingTime = $meetingTime;
    }
    public function getMeetingTime() {
        return $this->meetingTime;
    }

    public function setLocation($location) {
        $this->location = $location;
    }
    public function getLocation() {
        return $this->location;
    }
    public function setExamGroup($examGroup) {
        $this->examGroup = $examGroup;
    }
    public function getExamGroup() {
        return $this->examGroup;
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
    
   /* public function getTermOrder() {        
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
    }*/
 
    
    public function toArray() {
    	return get_object_vars($this);
    }
}