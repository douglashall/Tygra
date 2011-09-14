<?php

 class IsitesVideoController extends VideoDataController
 {
    protected $DEFAULT_PARSER_CLASS='IsitesVideoDataParser';
    protected $playlist;
    
 	private function setStandardFilters() {
 		$this->setBaseUrl('http://vm1.isites.harvard.edu/mobile/video.json');
    }
    
    public function search($q, $start=0, $limit=null) {
    
        $this->setStandardFilters();
    	
        $this->addFilter('q', $q); //set the query
        $this->addFilter('max-results', $limit);
        $this->addFilter('start-index', $start+1);
        $this->addFilter('orderby', 'relevance');
    
        $items = parent::items(0, $limit);
        return $items;
    }
    
    protected function init($args) {
        parent::init($args);

        if (isset($args['PLAYLIST']) && strlen($args['PLAYLIST'])) {
            $this->playlist = $args['PLAYLIST'];
        }

        $this->setStandardFilters();
    }
    
    public function items($start=0, $limit=null) {
    
        $this->addFilter('max-results', $limit);
        $this->addFilter('start-index', $start+1);
                
        $items = parent::items(0, $limit);
        return $items;
    }

    protected function isValidID($id) {
        return preg_match("/^[A-Za-z0-9_-]+$/", $id);
    }
    
	 // retrieves video based on its id
	public function getItem($id)
	{
	    if (!$this->isValidID($id)) {
	        return false;
	    }
        $this->setBaseUrl("http://gdata.youtube.com/feeds/mobile/videos/$id");
        $this->addFilter('alt', 'jsonc'); //set the output format to json
        $this->addFilter('format', 6); //only return mobile videos
        $this->addFilter('v', 2); // version 2

        return $this->getParsedData();
	}
}
 
class IsitesVideoDataParser extends DataParser
{
    protected function parseEntry($entry) {
        $video = new IsitesVideoObject();
        $video->setURL($entry['URL']);
        $video->setTitle($entry['title']);
        $video->setImage($entry['thumbnail']);
        $video->setStillFrameImage($entry['thumbnail']);
        return $video;
    }
    
    public function parseData($data) {
        if ($data = json_decode($data, true)) {
            $videos = array();

            foreach ($data['Courses'][0]['videos'] as $entry) {
                $videos[] = $this->parseEntry($entry);
            }
                
            return $videos;
        } 

        return array();
        
    }
}

class IsitesVideoObject extends VideoObject
{
    protected $type = 'isites';
    
    public function canPlay(DeviceClassifier $deviceClassifier) {
        if (in_array($deviceClassifier->getPlatform(), array('blackberry','bbplus'))) {
            return $this->getStreamingURL();
        }

        return true;
    }
}
