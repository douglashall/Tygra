<?php

 class ClassmatesDataController extends DataController
 {
     protected $cacheFolder = "Classmates"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

     public function search($q)
     {
         // set the base url
         $this->setBaseUrl('http://vm1.isites.harvard.edu/mobile/classmates.json');
         //$this->setBaseUrl('http://localhost:8080/icommonsapi/whatsnew/by_user/10564158.json');
         //$this->addFilter('alt', 'json'); //set the output format to json

         $data = $this->getParsedData();
         $results = array();
         foreach ($data['classes']['class'][0]['classmate'] as $item) {
             $person = new PersonObject();
             $person->setId($item['id']);
             $person->setFirstName($item['firstname']);
             $person->setLastName($item['lastname']);
             $person->setEmail($item['email']);
             $person->setThumbnail($item['thumbnail']);
             $results[] = $person->toArray();
         }

         return $results;
     }

     // not used yet
     public function getItem($id){
     	 $this->setBaseUrl('http://vm1.isites.harvard.edu/mobile/classmates.json');
         $data = $this->getParsedData();
         $person = new PersonObject();
         foreach ($data['classes']['class'][0]['classmate'] as $item) {
             if ($item['id'] == $id) {
                 $person->setId($item['id']);
                 $person->setFirstName($item['firstname']);
                 $person->setLastName($item['lastname']);
                 $person->setEmail($item['email']);
                 $person->setThumbnail($item['thumbnail']);
                 break;
             }
         }
         
         return $person->toArray();
     }

 }