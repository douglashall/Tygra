<?php

/* 
 * Class to abstract group data
 */
class GroupObject implements KurogoObject
{
    protected $id; // this is the group id, something like 'ScaleCourseSiteEnroll:k8246'
    protected $name;
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
    
    public function toArray() {
    	return get_object_vars($this);
    }
}