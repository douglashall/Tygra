<?php

/* 
 * Class to abstract person data
 */
class PersonObject implements KurogoObject
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $thumbnail;
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
    
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
    
    public function getFirstName() {
        return $this->firstName;
    }
    
	public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    
    public function getLastName() {
        return $this->lastName;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }
    
    public function getThumbnail() {
        return $this->thumbnail;
    }
    
    public function toArray() {
    	return get_object_vars($this);
    }
}