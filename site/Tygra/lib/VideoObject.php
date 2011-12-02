<?php

/* 
 * Class to abstract course data
 */
class VideoObject implements KurogoObject
{
    protected $entryid; 
    protected $entity; 
    protected $linkurl;
    protected $siteid;
    protected $topicid;
    protected $shared;
    protected $modifiedon;
    protected $title;
    protected $description;
    protected $imgurl;
    
    public function setEntryId($entryid) {
        $this->entryid = $entryid;
    }

    public function getEntryId() {
        return $this->entryid;
    }
    
    public function setEntity($entity) {
        $this->entity = $entity;
    }
    
    public function getEntity() {
        return $this->entity;
    }
    
    public function setLinkUrl($linkurl) {
        $this->linkurl = $linkurl;
    }
    
    public function getLinkUrl() {
        return $this->linkurl;
    }
    
    public function setSiteId($siteid) {
        $this->siteid = $siteid;
    }
    
    public function getSiteId() {
        return $this->siteid;
    }
    
    public function setTopicid($topicid) {
        $this->topicid = $topicid;
    }
    
    public function getTopicid() {
        return $this->topicid;
    }
    
    public function setShared($shared) {
        $this->shared = $shared;
    }
    
    public function getShared() {
        return $this->shared;
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