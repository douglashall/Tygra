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
    
    public function findCourseByKeyword($keyword) {
    	
    	$courseObject = new CourseObject();
    	
    	foreach($this->courses as $course){
    		
    		if(strcmp($course->getKeyword(), $keyword)==0){
    			$courseObject = $course;
    		}
    	}
    	
    	return $courseObject;
    }
    
    public function setCourses($courses) {
    	$this->courses = $courses;
    }
    

    
}
