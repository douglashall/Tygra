<?php

 class ClassmatesDataController extends DataController
 {
     protected $cacheFolder = "Classmates"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
     protected $path;

	protected function url() {
        $url = $this->baseURL;
        if ($this->path) {
        	$url .= $this->path;
        	$this->path = NULL;
        }
        if (count($this->filters)>0) {
            $glue = strpos($this->baseURL, '?') !== false ? '&' : '?';
            $url .= $glue . http_build_query($this->filters);
        }
        
        return $url;
    }
    
     public function search($q)
     {
         $this->path = "$q.json";
         $data = $this->getParsedData();

         $results = array();
         foreach ($data['classes']['class'] as $class) {
             foreach ($class['classmate'] as $item) {
	             $person = new PersonObject();
	             $person->setId($item['id']);
	             $person->setFirstName($item['firstname']);
	             $person->setLastName($item['lastname']);
	             $person->setEmail($item['email']);
	             $person->setThumbnail($item['thumbnail']);
	             $results[] = $person->toArray();
             }
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
	                 $person->setId($item['id']);
	                 $person->setFirstName($item['firstname']);
	                 $person->setLastName($item['lastname']);
	                 $person->setEmail($item['email']);
	                 $person->setThumbnail($item['thumbnail']);
	                 break;
	             }
             }
         }
         
         return $person->toArray();
     }

 }