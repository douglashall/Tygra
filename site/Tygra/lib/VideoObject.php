<?php

/* 
 * iSites Video Object Class
 */
class VideoObject implements KurogoObject
{
    protected $entryid; 
    protected $linkurl = array();
    protected $modifiedon;
    protected $title;
    protected $description;
    protected $imgurl;
    
	function __construct($video) {
				
		if(isset($video['id'])){
   			$this->entryid = $video['id'];
		}

		if(isset($video['asset']['videoFileRefs'][0]['sourceUrl'])){
			
			/*
			 * In this case we have a list of videos and possibly an audio(mp3) file.
			 */
			foreach($video['asset']['videoFileRefs'] as $v){
				array_push($this->linkurl, $v['sourceUrl']);
			}
			
		}

		if(isset($video['asset']['videoFileRefs'][0]['dateCreated'])){
			
			foreach($video['asset']['videoFileRefs'] as $v){
				/*
					This check for mediaType = 'Video' is no longer valid as we now 
					process both audio and video. I just commented it out in case it 
					break anything we can easily undo
				*/
				//if($v['mediaType'] == "video"){
					$this->modifiedon = $v['dateCreated'];
				//}
			}
		}
		
		if(isset($video['title'][0])){
      		$this->title   = $video['title'][0];
		}
		elseif(isset($video['displayTitle'])){
			$this->title   = $video['displayTitle'];
		}
		
		if(isset($video['caption'])){
      	$this->description = $video['caption'];
		}
		
		if(isset($video['imageurl'])){
      		$this->imgurl  = $video['imageurl'];
		}
   	}
   	
   	static function cmp_obj($a, $b)
    {
        $al = strtolower($a->getModifiedOn());
        $bl = strtolower($b->getModifiedOn());
        if ($al == $bl) {
            return 0;
        }
        return ($al < $bl) ? +1 : -1;
    }
    
    public function setEntryId($entryid) {
        $this->entryid = $entryid;
    }

    public function getEntryId() {
        return $this->entryid;
    }
    
    public function setLinkUrl($linkurl) {
        $this->linkurl = $linkurl;
    }
    
    public function getLinkUrl() {
        return $this->linkurl;
    }
    
    public function setModifiedOn($modifiedon) {
        $this->modifiedon = $modifiedon;
    }
    
    public function getModifiedOn() {
        return $this->modifiedon;
    }
      
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function setImgUrl($imgurl) {
        $this->imgurl = $imgurl;
    }
    
    public function getImgUrl() {
        return $this->imgurl;
    }
    
    public function toArray() {
    	return get_object_vars($this);
    }
}