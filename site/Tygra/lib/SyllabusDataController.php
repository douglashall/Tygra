<?php

 class SyllabusDataController extends DataController
 {
     protected $cacheFolder = "Syllabus"; // set the cache folder
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