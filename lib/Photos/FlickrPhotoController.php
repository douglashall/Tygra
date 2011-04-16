<?php

 class FlickrPhotoController extends PhotoDataController
 {
    protected $DEFAULT_PARSER_CLASS='FlickrDataParser';
    protected $cacheFileSuffix='rss';
    protected $group;
    
    public function search($q, $start, $limit) {
        Debug::die_here($this);                
    }
    
    protected function url() {
    
        if ($this->group) {
            $this->setBaseURL('http://api.flickr.com/services/feeds/groups_pool.gne');
            $this->addFilter('id', $this->group);
            $this->addFilter('format', 'rss_200');
        } elseif ($this->author || $this->tag) {
            $this->setBaseURL('http://api.flickr.com/services/feeds/photos_public.gne');
            $this->addFilter('format', 'rss_200');

            if ($this->author) {
                $this->addFilter('id', $this->author);
            }
            
            if ($this->tag) {
                $this->addFilter('tags', $this->tag);
            }
        }
                
        return parent::url();
    }

    protected function init($args) {
        parent::init($args);

        if (isset($args['GROUP']) && strlen($args['GROUP'])) {
            $this->group = $args['GROUP'];
        }
        
    }
    
    public function getItem($id)
    {
        if (!$id) {
            return null;
        }
        
        $items = $this->items();
        
        foreach ($items as $item) {
            if ($item->getID()==$id) {
                return $item;
            }
        }
        
        return null;
    }
}
 
class FlickrDataParser extends RSSDataParser
{
    protected function parseEntry($entry) {
        $photo = new FlickrPhotoObject();
        $photo->setTitle($entry->getTitle());
        $photo->setDescription($entry->getDescription());
        $photo->setID($entry->getGUID());
        $photo->setAuthor($entry->getAuthor());
        $published = new DateTime($entry->getPubDate());
        $photo->setPublished($published);
        if ($image = $entry->getChildElement('MEDIA:CONTENT')) {
            $photo->setImage($image->getAttrib('URL'));
            $photo->setWidth($image->getAttrib('WIDTH'));
            $photo->setHeight($image->getAttrib('HEIGHT'));
        }

        if ($thumbnail = $entry->getChildElement('MEDIA:THUMBNAIL')) {
            $photo->setThumbnail($thumbnail->getAttrib('URL'));
        }

        if ($tags = explode(" ", $entry->getProperty('MEDIA:CATEGORY'))) {
            $photo->setTags($tags);
        }

        return $photo;
    }
    
    public function parseData($data) {
        $data = parent::parseData($data);
        $photos = array();
        foreach ($data as $item) {
            $photos[] = $this->parseEntry($item);
        }
        
        return $photos;
    }
}

class FlickrPhotoObject extends PhotoObject
{
    protected $type = 'flickr';
}    