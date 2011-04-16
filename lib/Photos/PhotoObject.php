<?php

/* 
 * Class to abstract photo data
 */
class PhotoObject
{
    protected $type;
    protected $id;
    protected $title;
    protected $description;
    protected $author;
    protected $published;
    protected $thumbnail;
    protected $image;
    protected $width;
    protected $height;
    protected $tags;
    
    public function getType() {
        return $this->type;
    }
    
    public function setID($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setPublished(DateTime $published) {
        $this->published = $published;
    }

    public function getPublished() {
        return $this->published;
    }

    public function setImage($image) {
        $this->image = $image;
    }
    
    public function getImage() {
        return $this->image;
    }

    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }
    
    public function getThumbnail() {
        return $this->thumbnail;
    }

    public function setWidth($width) {
        $this->width = $width;
    }
    
    public function getWidth() {
        return $this->width;
    }

    public function setHeight($height) {
        $this->height = $height;
    }
    
    public function getHeight() {
        return $this->height;
    }

    public function setTags($tags) {
        $this->tags = $tags;
    }
    
    public function getTags() {
        return $this->tags;
    }
    
}
