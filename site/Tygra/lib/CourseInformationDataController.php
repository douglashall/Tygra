<?php

 class CourseInformationDataController extends AuthenticatedDataController
 {
     protected $cacheFolder = "CourseInformation"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
     
    protected function init($args) {
    	
        parent::init($args);
        
        $baseURL = $this->baseURL;
        $this->setBaseURL($baseURL.'courses/by_keyword/');
        
    }
     
     public function search($keyword)
     {
         $this->path = "$keyword.json";
         
         $data = $this->getParsedData();
         //TODO: replace with random generated string
		 $count = 10;
         $results = array();
         $results = $data['courses'];
         
         foreach ($results as $item) {
        	 $info = new CourseInformationObject();
        	 $info->setTitle($item['title']);
          	 $info->setSubTitle($item['subTitle']);
			 $info->setDescription($item['description']);
			 $info->setCredits($item['credits']);
			 $info->setInstructorsDisplay($item['instructorsDisplay']);
			 $info->setMeetingTime($item['meetingTime']);
			 
			 $term = $item['term'];
			 $info->setTermDisplayName($term['displayName']);
			 
			 $course = $item['course'];
			 $info->setDepartment($course['department']);
			 $info->setSchoolId($course['schoolId']);

           	 //print_r("  info=".var_dump($info));
         	 $results[] = $info->toArray();
         }
         //return $results;
         return $info->toArray();
     }

    // not used yet
	public function getItem($id){}

}

?>