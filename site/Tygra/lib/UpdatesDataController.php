<?php

 class UpdatesDataController extends DataController
 {
     protected $cacheFolder = "Updates"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

     public function search($q)
     {
		 $url = $this->baseURL;
     	 $this->setBaseURL("$url$q.json");
         $data = $this->getParsedData();
         $this->setBaseURL($url);
         
         $results = $data['whatsnews']['sections'][0]['items'];

         return $results;
     }

     // not used yet
     public function getItem($id){}

 }