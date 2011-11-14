<?php
/**
  * @package Authentication
  */
class HarvardUser extends User
{
    // an array of CourseObject
    protected $courses = array();
    
    public function getCourses() {
    	return $this->courses;
    }
    
    public function setCourses($courses) {
    	$this->courses = $courses;
    }
}
