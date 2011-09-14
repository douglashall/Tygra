<?php

 class SyllabusDataController extends DataController
 {
     protected $cacheFolder = "Syllabus"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

     public function search($q)
     {
         // set the base url
         $this->setBaseUrl('http://vm1.isites.harvard.edu/mobile/syllabus.json');
         //$this->setBaseUrl('http://localhost:8080/icommonsapi/whatsnew/by_user/10564158.json');
         //$this->addFilter('alt', 'json'); //set the output format to json

         $data = $this->getParsedData();
         $results = array();
         foreach ($data['Courses'] as $item) {
             $course = new CourseObject();
             $course->setId($item['courseId']);
             $course->setTitle($item['title']);
             $course->setSyllabus($item['syllabusUrl']);
             $results[] = $course->toArray();
         }

         return $results;
     }

     // not used yet
     public function getItem($id){}

 }