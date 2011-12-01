<?php

 class IsitesVideoController extends DataController
 {
    protected $cacheFolder = "Videos"; // set the cache folder
    protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
    
    public function search($huid) {
    
    	$baseURL = $this->baseURL;
    	//print_r("baseURL=".$baseURL);
    	
        $this->setBaseUrl($baseURL.'video/by_user/'.$huid.'.json');
        $data = $this->getParsedData();
        $results = $data['video']['docs'];
        
        //print_r($results);
        
        return $results;
    }
    
    public function searchByIdAndSite($huid, $keyword){
    	$videos = array();
    	$results = $this->search($huid);
    	foreach($results as $video){
    	    if(strcmp($video['sitekey'], $keyword)==0){
        		 $videos[] = $video;
        	}
        }
     	return isset($videos) ? $videos : false;   
    }

	public function getItemByHuidAndVideoId($huid, $id){
		$results = $this->search($huid);
		
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
 