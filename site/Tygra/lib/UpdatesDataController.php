<?php

 class UpdatesDataController extends DataController
 {
     protected $cacheFolder = "Activity"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

     public function search($q)
     {
         // set the base url
         $this->setBaseUrl('http://vm1.isites.harvard.edu/mobile/updates.json');
         //$this->setBaseUrl('http://localhost:8080/icommonsapi/whatsnew/by_user/10564158.json');
         //$this->addFilter('alt', 'json'); //set the output format to json

         $data = $this->getParsedData();
         $results = $data['whatsnews']['sections'][0]['items'];

         return $results;
     }

     // not used yet
     public function getItem($id){}

 }