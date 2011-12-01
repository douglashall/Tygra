<?php
/**
  * @package Authentication
  */
class HarvardUser extends User
{
    // an array of CourseObject
    protected $courses = array();
    protected $videos;
    
    public function getCourses() {
    	return $this->courses;
    }
    
    public function findCourseByKeyword($keyword) {
    	
    	foreach($this->courses as $course){
    		
    		if(strcmp($course->getKeyword(), $keyword)==0){
    			return $course;
    		}
    	}
    	
    	return null;
    }
    
    public function setCourses($courses) {
    	$this->courses = $courses;
    }
    

    
}
