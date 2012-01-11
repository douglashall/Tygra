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
    
    
    public function updateCourse($courseObj){
    	$ukeyword = $courseObj->getKeyword();
        for($i = 0; $i < sizeof($courses); ++$i){
    		if(strcmp($this->$courses[$i]->getKeyword(), $ukeyword)==0){
    			$this->$courses[$i] = $courseObj;
    		}
    	}
    }
    
    public function addVideosToCourse($keyword, $videos){
    	//print_r("inside User->addVideosToCourse<br/>");
    	//print_r(var_dump($videos)."<br/>");
    	$course = $this->findCourseByKeyword($keyword);
    	//print_r(var_dump($course)."<br/>");
    	$course->setVideos($videos);
    }
    
    public function getVideosByKeyword($keyword){
    	foreach($this->$courses as $course){
    		if(strcmp($course->getKeyword(), $keyword)==0){
    			return $course->getVideos();
    		}
    	}
    	return NULL;
    }
    
    public function getVideoByEntryId($entryid){
    	//print_r(var_dump($courses));
    	foreach($this->$courses as $course){
    		foreach($course->getVideos() as $video){
    			if(strcmp($video->getEntryId(), $entryid)==0){
    				return $video;
    			}
    		}
    	}
    	return NULL;
    }
    
    public function setCourses($courses) {
    	$this->courses = $courses;
    }
    

    
}
