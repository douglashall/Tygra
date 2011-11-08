<?php

 class SyllabusDataController extends AuthenticatedDataController
 {
     protected $cacheFolder = "Syllabus"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
	 protected $path;

    protected function init($args) {
    	
        parent::init($args);
        
        $baseURL = $this->baseURL;
        $this->setBaseURL($baseURL.'search/select/');
        
    }

     public function search($user)
     {
		$results = array();
     	$syllabusSet = false;
     	if ($user->getCourses()) {
     		foreach ($user->getCourses() as $course) {
     			if($course->getSyllabus()) {
     				$syllabusSet = true;
     			}
     		}
     	}
     	if ($syllabusSet ==  false) {
			$sitekeys = '';
			foreach ($user->getCourses() as $course) {
				if (strlen($sitekeys) > 0)
					$sitekeys = $sitekeys.'%20OR%20';
				$sitekeys = $sitekeys.$course->getKeyword();
			}
			
			if (strlen($sitekeys) > 0) {
     		$this->path = sprintf("userid=%s&q=Syllabus&omitHeader=true&fq=category:topic&start=0&rows=100&wt=json&fq=sitekey:%s&fl=topicid,title,sitekey,linkurl,description,fileurl",$user->getUserID(),$sitekeys);
	
	        $data = $this->getParsedData();
			foreach ($data['response']['docs'] as $item) {
				$result = new SyllabusObject();
				if (isset($item['title']))
					$result->setTitle($item['title']);
				if (isset($item['sitekey']))
					$result->setKeyword($item['sitekey']);
				if (isset($item['fileurl']))
					$result->setFileUrl($item['fileurl']);
				if (isset($item['linkurl']))
					$result->setLinkUrl($item['linkurl']);
				if (isset($item['description']))
				    $result->setDescription($item['description']);
				if (isset($item['topicid']))
				    $result->setTopicId($item['topicid']);
				foreach ($user->getCourses() as $course) {
					$course->addSyllabusObject($result);
				}
	         }
     	}
     	
 		foreach ($user->getCourses() as $course) {
 			$view = new SyllabusView();
 			$view->setSiteTitle($course->getTitle());
 			if($course->getSyllabus()) {
 				$items = array();
				foreach ($course->getSyllabus() as $item) {
					$items[] = $item->toArray();
				}
 				
 				$view->setSyllabus($items);
 			}
			$results[] = $view->toArray();
 		}
     	}
     		
		return $results;
     }

     // not used yet
     public function getItem($id){}

 }