<?php

 class ClassmatesDataController extends AuthenticatedDataController
 {
     protected $cacheFolder = "Classmates"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
     
    protected function init($args) {
    	
        parent::init($args);
        
        $baseURL = $this->baseURL;
        $this->setBaseURL($baseURL.'groups/course_enrollment/');
        
    }
     
     public function search($keyword, $userId)
     {
         $this->path = "$keyword/$userId.json";
         $data = $this->getParsedData();
         //TODO: replace with random generated string
		 $count = 0;
         $results = array();
         foreach ($data['enrollment'] as $item) {
             $person = new PersonObject();
             $person->setId($count++);
             $person->setHuid($item['id']);
             $person->setFirstName($item['firstName']);
             $person->setLastName($item['lastName']);
             $person->setEmail($item['email']);
             $results[] = $person->toArray();
         }

         return $results;
     }

     // not used yet
     public function getItem($id){
     	 $this->setBaseUrl('http://vm1.isites.harvard.edu/mobile/classmates.json');
         $data = $this->getParsedData();
         $person = new PersonObject();
         foreach ($data['classes']['class'] as $class) {
             foreach ($class['classmate'] as $item) {
	             if ($item['id'] == $id) {
	                 $person->setHuid($item['id']);
	                 $person->setFirstName($item['firstName']);
	                 $person->setLastName($item['lastName']);
	                 $person->setEmail($item['email']);
	                 $person->setThumbnail($item['thumbnail']);
	                 break;
	             }
             }
         }
         
         return $person->toArray();
     }

 }