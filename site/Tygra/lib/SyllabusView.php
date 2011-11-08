<?php

/* 
 * Class to abstract course data
 */
class SyllabusView implements KurogoObject
{
    protected $siteHref;
    protected $siteTitle;
    protected $syllabus;
    
    public function setSyllabus($syllabus) {
        $this->syllabus = $syllabus;
    }

    public function getSyllabus() {
        return $this->syllabus;
    }
    
    public function setSiteTitle($siteTitle) {
        $this->siteTitle = $siteTitle;
    }
    
    public function getSiteTitle() {
        return $this->siteTitle;
    }
    
    public function setSiteHref($siteHref) {
        $this->siteHref = $siteHref;
    }
    
    public function getSiteHref() {
        return $this->siteHref;
    }
    
    
    public function toArray() {
    	return get_object_vars($this);
    }
}