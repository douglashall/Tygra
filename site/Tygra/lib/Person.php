<?php

/* 
 * iSites person
 */
class Person extends User
{
    protected $thumbnail;
    // a Map<siteKeyword, CourseObject>
    protected $courses = array();
    
    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }
    
    public function getThumbnail() {
        return $this->thumbnail;
    }
    
    public function getCourses() {
    	return $this->courses;
    }
    
    public function setCourses($courses) {
    	$this->courses = $courses;
    }
    
    public function toArray() {
    	return get_object_vars($this);
    }
}