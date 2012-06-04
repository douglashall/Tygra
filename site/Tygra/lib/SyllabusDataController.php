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
		$huid = $user->getUserID();	
		$results = array();
		$sitekeys = '';
		foreach ($user->getCourses() as $course) {
			if (strlen($sitekeys) > 0)
				$sitekeys = $sitekeys.' OR ';
			$sitekeys = $sitekeys.$course->getKeyword();
		}
			
		if (strlen($sitekeys) > 0) {
			
     		$this->path = "userid=$huid"
     		."&q=".rawurlencode('title:syllabus -title:hidden')
     		."&fq=category:".rawurlencode('(file OR topic)')
     		."&fq=sitekey:".rawurlencode('('.$sitekeys.')')
     		."&fl=".rawurlencode('topicid,title,sitekey,linkurl,description,category')
            ."&omitHeader=true"
            ."&wt=json"
            ."&start=0"
            ."&rows=100";
     		
	        $data = $this->getParsedData();
	        
			if ($data) {
		        // initialize a CourseSyllabus object for each course
		        $coursesSyllabusCollection = array();
				foreach ($user->getCourses() as $course) {
					$courseSyllabus = new CourseSyllabus();
					$courseSyllabus->setKeyword($course->getKeyword());
					$courseSyllabus->setTitle($course->getTitle());
					$coursesSyllabusCollection[] = $courseSyllabus;
				}
			
				foreach ($data['response']['docs'] as $item) {
					$result = new SyllabusObject();
					if (isset($item['title']))
						$result->setTitle($item['title']);
					if (isset($item['sitekey']))
						$result->setKeyword($item['sitekey']);
					if (isset($item['category']))
						$result->setCategory($item['category']);
					if (isset($item['linkurl']))
						$result->setLinkUrl(str_replace(' ', '%20', $item['linkurl']));
					if (isset($item['description']))
					    $result->setDescription($item['description']);
					if (isset($item['topicid']))
					    $result->setTopicId($item['topicid']);
					foreach ($coursesSyllabusCollection as $courseSyllabus)
						$courseSyllabus->addSyllabusObject($result);
		        }
		        
		 		foreach ($coursesSyllabusCollection as $courseSyllabus) {
		 			$view = new SyllabusView();
		 			$view->setKeyword($courseSyllabus->getKeyword());
		 			$view->setSiteTitle($courseSyllabus->getTitle());
		 			$href = sprintf("%s/%s",$this->getIsitesUrl(),$courseSyllabus->getKeyword());
		 			$view->setSiteHref($href);
					$view->setSyllabus($courseSyllabus->toArray());
					$results[] = $view->toArray();
		 		}
			}
 		}
     	
		return $results;
     }

     // not used yet
     public function getItem($id){}

 }
 
 class CourseSyllabus {
    protected $keyword; //site keyword
    protected $title; //site title
    protected $syllabus = array();
    
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
    
    public function addSyllabusObject(SyllabusObject $o) {
    	if ($o->getKeyword() == $this->keyword) {
//    		if ($o->getTopicId() == 844633)
//    		var_export($o);
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
    public function toArray() {
		$items = array();
    	if ($this->syllabus) {
			foreach ($this->syllabus as $item) {
				$items[] = $item->toArray();
			}
    	}
    	return $items;
    }
 }
 
