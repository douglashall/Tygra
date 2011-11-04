<?php

 class PeopleDataController extends DataController
 {
     protected $cacheFolder = "People"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

     public function findPerson($q)
     {
     	 $url = $this->baseURL;
     	 $this->setBaseURL("$url/$q.json");
         $data = $this->getParsedData();
         $this->setBaseURL($url);

         $result = $data['people'][0];
         
         return $result;
     }

     // not used yet
     public function getItem($id){}

 }