<?php

 class IsitesVideoController extends DataController
 {
    protected $cacheFolder = "Videos"; // set the cache folder
    protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
    
    public function search($user, $query) {
    
    	$huid = $user->getUserID();
    	$baseURL = $this->baseURL;
    	
    	$courses = $user->getCourses();
    	
    	$courseList = "(sitekey:";
    	foreach($courses as $course){
    		$courseList .= $course->getKeyword() .'%20OR%20sitekey:';
    	}
    	$lenOriginal = strlen($courseList);
    	$lenTrim = strlen("%20OR%20sitekey:");
     	$newCourseList = substr($courseList, 0, $lenOriginal-$lenTrim);
    	$newCourseList .= "))";
    	
    	$sPattern = '/\s*/m';
		$sReplace = '+';
    	preg_replace($sPattern, $sReplace, $query);
    	
    	$searchTerms = "((title:".$query."%20OR%20description:".$query."%20OR%20topictitle:".$query.")%20AND%20".$newCourseList."&omitHeader=true&fq=category:video&fq=userid:".$huid."&start=0&rows=100&wt=json";
    	
    	$formattedQuery = "userid=".$huid."&q=".$searchTerms;
    	
    	//print_r("fq=".$formattedQuery." END");
    	    	
    	$this->setBaseUrl($baseURL.'video/by_query/'.base64_encode($formattedQuery).'.json');
    	$data = $this->getParsedData();
    	$results = $data['video']['docs'];
   
        return $results;
    	/*
    	// if not make the call
    	if(empty($videos)){
    		//print_r("Getting videos from search");
        	$this->setBaseUrl($baseURL.'video/by_userandkeyword/'.$huid.'/'.$keyword.'.json');
        	//print_r($this->baseURL);
        	$data = $this->getParsedData();
        	$results = $data['video']['docs'];
        	$course->setVideos($results);
        	return $results;
    	}
    	*/
        
        //print_r($results);
        //return $vidoes;
        
    }
    
     public function findVideosByHuidAndKeyword($huid, $keyword) {
    
    	$baseURL = $this->baseURL;
        $this->setBaseUrl($baseURL.'video/by_userandkeyword/'.$huid.'/'.$keyword.'.json');
        $data = $this->getParsedData();
        $results = $data['video']['docs'];
        //$course->setVideos($results);
        return $results;
    }
    
    public function findVideoByUserAndEntryId($huid, $entryid) {
    
    	$baseURL = $this->baseURL;
        $this->setBaseUrl($baseURL.'video/by_userandentryid/'.$huid.'/'.$entryid.'.json');
        $data = $this->getParsedData();
        $results = $data['video']['docs'];
        //$course->setVideos($results);
        return $results;
    }
    
	public function getItemByHuidAndVideoId($huid, $keyword, $id){
		$results = $this->search($huid, $keyword);
		
        foreach ($results as $video) {
        	if(strcmp($video['id'], $id)==0){
        		 $result = $video;
        	}
        }
     	return isset($result) ? $result : false;   
	}
	
	public function getItem($id){
	}

}
 