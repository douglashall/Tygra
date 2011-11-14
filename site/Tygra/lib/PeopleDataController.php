<?php

class PeopleDataController extends AuthenticatedDataController
{
    protected $cacheFolder = "People"; // set the cache folder
    protected $cacheSuffix = "json";   // set the suffix for cache files
    protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
    protected $path;

    protected function init($args) {
    	
        parent::init($args);
        
        $baseURL = $this->baseURL;
        $this->setBaseURL($baseURL."people/course_person/");
        
    }
    
	protected function url() {
        $url = $this->baseURL;
        if ($this->path) {
        	$url .= $this->path;
        }
        if (count($this->filters)>0) {
            $glue = strpos($this->baseURL, '?') !== false ? '&' : '?';
            $url .= $glue . http_build_query($this->filters);
        }
        return $url;
    }
    
    public function findPerson($q)
    {
    	$this->path = "$q.json";
        $data = $this->getParsedData();

        if (isset($data['person']))
			return $data['person'];
    }

    // not used yet
    public function getItem($id){}

}