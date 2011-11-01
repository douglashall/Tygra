<?php

/* 
 * Class to abstract course data
 */
class CourseObject implements KurogoObject
{
    protected $id;
    protected $title;
    protected $syllabus;
    protected $enrollees;
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getSyllabus() {
        return $this->syllabus;
    }

    public function setSyllabus($syllabus) {
        $this->syllabus = $syllabus;
    }
    
    public function getEnrollees() {
        return $this->enrollees;
    }

    public function setEnrollees($enrollees) {
        $this->enrollees = $enrollees;
    }
    
    public function toArray() {
    	return get_object_vars($this);
    }
}