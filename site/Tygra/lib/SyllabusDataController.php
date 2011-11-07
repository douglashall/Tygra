<?php

 class SyllabusDataController extends DataController
 {
     protected $cacheFolder = "Syllabus"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
//	 protected $path;
//	
// 	protected function url() {
//        $url = $this->baseURL;
//        if ($this->path) {
//        	$url .= $this->path;
//        	$this->path = NULL;
//        }
//        if (count($this->filters)>0) {
//            $glue = strpos($this->baseURL, '?') !== false ? '&' : '?';
//            $url .= $glue . http_build_query($this->filters);
//        }
//        
//        return $url;
//    }
//    
//     public function search($q)
//     {
//         $this->path = "$q.json";
//         $data = $this->getParsedData();
//
//         $results = array();
//         foreach ($data['Courses'] as $item) {
//             $course = new CourseObject();
//             $course->setId($item['courseId']);
//             $course->setTitle($item['title']);
//             $course->setSyllabus($item['syllabusUrl']);
//             $results[] = $course->toArray();
//         }
//
//         return $results;
     //user: F7455492-E3B1-11E0-B26E-E0A8BADA4195
     //pwd: lcnnWEMnqrDLSVL5CifU
//https://isites.harvard.edu/services/search/select/?userid=70602482&q=Syllabus&omitHeader=true&fq=sitekey:k63478&start=0&rows=250&fl=id,title,description,siteid&wt=json&fq=category:topic
     public function search($user)
     {
     	$syllabusSet = false;
     	if ($user->getCourses()) {
     		foreach ($user->getCourses() as $course) {
     			if($course->getSyllabus()) {
     				$syllabusSet = true;
     			}
     		}
     	}
     	if ($syllabusSet ==  false) {
	     // this an icommonsapi application key
	     	$SERVER_USER_CREDENTIALS=base64_encode('F7455492-E3B1-11E0-B26E-E0A8BADA4195:lcnnWEMnqrDLSVL5CifU');
			$sitekeys = '';
			foreach ($user->getCourses() as $course) {
				if (strlen($sitekeys) > 0)
					$sitekeys = $sitekeys.'%20OR%20';
				$sitekeys = $sitekeys.$course->getKeyword();
			}
	     	
			// set application key for icommonsapi service
	         $this->addHeader('Authorization', 'Basic ' . $SERVER_USER_CREDENTIALS);
	         // set the base url
	         $queryString = sprintf("userid=%s&q=Syllabus&omitHeader=true&fq=category:topic&start=0&rows=100&wt=json&fq=sitekey:%s&fl=topicid,title,sitekey,linkurl,description,fileurl",$user->getUserID(),$sitekeys);
	         $this->setBaseUrl('https://isites.harvard.edu/services/search/select/'.$queryString);
	// OTD: I commented out addFilter b/c addFilter does not allow to add multiple params with the same name i.e 'fq'         
	//         $this->addFilter('userid',$userId);
	//         $this->addFilter('q','Syllabus');
	//         $this->addFilter('omitHeader','true');
	//         $this->addFilter('fq','category:topic');
	//         $this->addFilter('start','0');
	//         $this->addFilter('rows','100');
	//         $this->addFilter('wt','json');
	//         $this->addFilter('fq','sitekey:k63478');
	//         $this->addFilter('fl','topicid,title,sitekey,linkurl,description,fileurl');
	
	         $data = $this->getParsedData();
//	         $results = array();
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
     	
		$results = array();
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
     		
		return $results;
     }

     // not used yet
     public function getItem($id){}

 }