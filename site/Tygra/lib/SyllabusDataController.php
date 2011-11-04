<?php

 class SyllabusDataController extends DataController
 {
     protected $cacheFolder = "Syllabus"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

     public function search($q)
     {
         $url = $this->baseURL;
     	 $this->setBaseURL("$url$q.json");
         $data = $this->getParsedData();
         $this->setBaseURL($url);

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