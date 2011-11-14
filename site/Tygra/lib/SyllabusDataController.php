<?php

 class SyllabusDataController extends AuthenticatedDataController
 {
     protected $cacheFolder = "Syllabus"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

    protected function init($args) {
    	
        parent::init($args);
        
        $baseURL = $this->baseURL;
        $this->setBaseURL($baseURL.'search/select/');
        
    }

     public function search($user)
     {
		$results = array();
		$sitekeys = '';
		foreach ($user->getCourses() as $course) {
			if (strlen($sitekeys) > 0)
				$sitekeys = $sitekeys.'%20OR%20';
			$sitekeys = $sitekeys.$course->getKeyword();
		}
			
		$category = '(file%20OR%20topic)';
			
		if (strlen($sitekeys) > 0) {
     		$this->path = sprintf("userid=%s&q=title:syllabus+-hidden&omitHeader=true&fq=category:%s&start=0&rows=100&wt=json&fq=sitekey:%s&fl=topicid,title,sitekey,linkurl,description,category",$user->getUserID(),$category,$sitekeys);
	
	        $data = $this->getParsedData();
			foreach ($data['response']['docs'] as $item) {
				$result = new SyllabusObject();
				if (isset($item['title']))
					$result->setTitle($item['title']);
				if (isset($item['sitekey']))
					$result->setKeyword($item['sitekey']);
				if (isset($item['category']))
					$result->setCategory($item['category']);
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
 			$href = sprintf("%s/%s",$this->getIsitesUrl(),$course->getKeyword());
 			$view->setSiteHref($href);
			$view->setSyllabus($course->getSyllabusAsArray());
			$results[] = $view->toArray();
 		}
		return $results;
     }

     // not used yet
     public function getItem($id){}

 }