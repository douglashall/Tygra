<?php

/* 
 * Class to abstract course data
 */
class CourseObject implements KurogoObject
{
    protected $keyword; //site keyword
    protected $title; // site title
    protected $syllabus;
    protected $enrollees;
    
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
    
    public function addSyllabusObject(SyllabusObject $o) {
    	if ($o->getKeyword() == $this->keyword) {
    		if (!$this->syllabus)
    			$this->syllabus = array();
    		// add files in place of topics for the same topic id
    		$replacedTopicWithFile = false;
    		foreach ($this->syllabus as $item) {
    			if ($item->getTopicId() == $o->getTopicId() && $item->getCategory() == 'topic' && $o->getCategory() == 'file') {
    				$item->setTitle($o->getTitle());
    				$item->setLinkUrl($o->getLinkUrl());
    				$item->setCategory($o->getCategory());
    				$replacedTopicWithFile = true;
    			}
    		}
    		if (!$replacedTopicWithFile)
    			$this->syllabus[] = $o;	
    	}
    }
    
    public function getSyllabusAsArray() {
		$items = array();
    	if ($this->syllabus) {
			foreach ($this->syllabus as $item) {
				$items[] = $item->toArray();
			}
    	}
    	
    	return $items;
    }
}