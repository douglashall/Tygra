<?php

/* 
 * Class to abstract course data
 */
class SyllabusObject implements KurogoObject
{
	//	title,sitekey,linkurl,coursecode,fileurl,sitetitle
	
    protected $topicId;
    protected $title;
    protected $keyword;
    protected $linkUrl;
    protected $category;
    protected $description;
    
    public function setKeyword($keyword) {
        $this->keyword = $keyword;
    }

    public function getKeyword() {
        return $this->keyword;
    }

    public function setTopicId($topicId) {
        $this->topicId = $topicId;
    }

    public function getTopicId() {
        return $this->topicId;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getLinkUrl() {
        return $this->linkUrl;
    }

    public function setLinkUrl($linkUrl) {
        $this->linkUrl = $linkUrl;
    }
    
    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function toArray() {
    	return get_object_vars($this);
    }
}