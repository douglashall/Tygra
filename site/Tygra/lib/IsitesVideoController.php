<?php

 class IsitesVideoController extends DataController
 {
    protected $cacheFolder = "Videos"; // set the cache folder
    protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
    
    public function search($user, $keyword) {
    
    	$huid = $user->getUserID();
    	$baseURL = $this->baseURL;
    	
    	// check to see if we already retrieved the video list
    	$course = $user->findCoursebyKeyword($keyword);
    	//print_r($course->toArray());
    	$videos = $course->getVideos();
    
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
    	print_r("Videos already in course");
        
        //print_r($results);
        return $vidoes;
        
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
 