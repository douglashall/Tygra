<?php

includePackage('Photos');

class PhotosWebModule extends WebModule
{
    protected $id='photos'; 
    protected $feeds = array();
    protected $bookmarkLinkTitle = 'Bookmarked Photos';
   
    protected function detailURLForBookmark($aBookmark) {
        parse_str($aBookmark, $params);
        return $this->buildBreadcrumbURL('detail', $params, true);
    }

    protected function getTitleForBookmark($aBookmark) {
        parse_str($aBookmark, $params);
        $titles = array($params['title']);
        if (isset($params['subtitle'])) {
            $titles[] = $params['subtitle'];
        }
        return $titles;
        
    }
    
    protected function initialize() {
        $this->feeds = $this->loadFeedData();
    }
    
    protected function getListItemForPhoto(PhotoObject $photo, $section, $paneLink=false) {
    
        Debug::die_here($photo);

        $listItemArray = VideoModuleUtils::getListItemForVideo($video, $section, $this);
        
        $args = array(
            'section'=>$section,
            'videoid'=>$video->getID()
        );

        // Add breadcrumb.
        
        if ($paneLink) {
          $listItemArray['url'] = $this->buildURL('detail', $args);
        } else {
          $listItemArray['url'] = $this->buildBreadcrumbURL('detail', $args);
        }
        
        return $listItemArray;
    }

    private function getSectionsFromFeeds() {
         $sections = array();
         foreach ($this->feeds as $index => $feedData) {
              $sections[] = array(
                'value'    => $index,
                'title'    => $feedData['TITLE']
              );
         }         
         return $sections;
    }
    
    protected function initializeForPage() {
   
        if (count($this->feeds)==0) {
            throw new Exception("No photo feeds configured");
        }
    
        // Categories / Sections
        
        $section = $this->getArg('section');

        if (!isset($this->feeds[$section])) {
            $section = key($this->feeds);
        }
        
        $feedData = $this->feeds[$section];
        $this->assign('currentSection', $section);
        $this->assign('sections'      , $this->getSectionsFromFeeds());
        $this->assign('feedData'      , $feedData);
        
        $controller = DataController::factory($feedData['CONTROLLER_CLASS'], $feedData);

        switch ($this->page)
        {  
              case 'pane':
                $start = 0;

                $items = $controller->items($start, $maxPerPage);
                $videos = array();
                foreach ($items as $photo) {
                    $photos[] = $this->getListItemForVideo($video, $section, true);
                }
                
                $this->assign('videos', $videos);
                break;
            case 'search':
            case 'index':
        
                $maxPerPage = $this->getOptionalModuleVar('MAX_RESULTS', 20);
        	    $start = $this->getArg('start', 0);
        	    
                if ($this->page == 'search') {
                    if ($filter = $this->getArg('filter')) {
                        $searchTerms = trim($filter);
                        $items = $controller->search($searchTerms, $start, $maxPerPage);
                        $this->assign('searchTerms', $searchTerms);
                    } else {
                        $this->redirectTo('index', array('section'=>$section), false);
                    }
                } else {
                     $items = $controller->items($start, $maxPerPage);
                }
                             
                $totalItems = $controller->getTotalItems();
                $photos = array();
                foreach ($items as $photo) {
                    $photos[] = array(
                        'img'=>$photo->getThumbnail(),
                        'url'=>$this->buildBreadcrumbURL('detail',array('id'=>$photo->getID(),'section'=>$section))
                    );
                }
                
                $this->assign('photos', $photos);
                $this->assign('totalItems', $totalItems);
                
                $previousURL = null;
                $nextURL = null;
    
                if ($totalItems > $maxPerPage) {
                    $args = $this->args;
                 
                    if ($start > 0) {
                        $args['start'] = $start - $maxPerPage;
                        $previousURL = $this->buildBreadcrumbURL($this->page, $args, false);
                    }
                    
                    if (($totalItems - $start) > $maxPerPage) {
                        $args['start'] = $start + $maxPerPage;
                        $nextURL = $this->buildBreadcrumbURL($this->page, $args, false);
                    }		
                }
    
                $hiddenArgs = array(
                  'section'=>$section
                );
          
                $this->assign('start',       $start);
                $this->assign('previousURL', $previousURL);
                $this->assign('nextURL',     $nextURL);
                $this->assign('hiddenArgs',  $hiddenArgs);
                $this->assign('maxPerPage',  $maxPerPage);
                 
                $this->generateBookmarkLink();
                    
                break;
 
            case 'bookmarks':
            	
                $videos_bkms = array();

                foreach ($this->getBookmarks() as $aBookmark) {
                    if ($aBookmark) { // prevent counting empty string
                        $titles = $this->getTitleForBookmark($aBookmark);
                        $subtitle = count($titles) > 1 ? $titles[1] : null;
                        $videos_bkms[] = array(
                                'title' => $titles[0],
                                'subtitle' => $subtitle,
                                'url' => $this->detailURLForBookmark($aBookmark),
                        );
                    }
                }
                $this->assign('videos', $videos_bkms);
            
                break;
                
            case 'detail':
        
                $id = $this->getArg('id');
            
                if ($photo = $controller->getItem($id)) {
                    $this->assign('photoTitle',       $photo->getTitle());
                    $this->assign('photoURL',         $photo->getImage());
                    $this->assign('photoid',          $photo->getID());
                    $this->assign('photoDescription', $photo->getDescription());
                    $this->assign('photoAuthor'     , $photo->getAuthor());
                    $this->assign('photoDate'       , $photo->getPublished()->format('M n, Y'));

                    $body = $photo->getDescription() . "\n\n" . $photo->getImage();

                    $this->assign('shareEmailURL',    $this->buildMailToLink("", $photo->getTitle(), $body));
                    $this->assign('shareRemark',      $photo->getTitle());
    
                      // Bookmark
                      $cookieParams = array(
                        'section' => $section,
                        'title'   => $photo->getTitle(),
                        'id' => $id
                      );
    
                      $cookieID = http_build_query($cookieParams);
                      $this->generateBookmarkOptions($cookieID);
    
    
                } else {
                    $this->redirectTo('index', array('section'=>$section),false);
                }
                break;
        }
    }
    
  public function federatedSearch($searchTerms, $maxCount, &$results) {
  	 
    $section = key($this->feeds);
    if (!$section) return 0;
    $feedData = $this->feeds[$section];
    if (!$feedData) return 0;
    $controller = DataController::factory($feedData['CONTROLLER_CLASS'], $feedData);

  	$items = $controller->search($searchTerms, 0, $maxCount);
  	 
  	if ($items) {
  		$results = array();
  		foreach ($items as $video) {
  		    $listItem = $this->getListItemForVideo($video, $section);
  		    unset($listItem['subtitle']);
  			$results[] = $listItem;
  		}
  		return $controller->getTotalItems();
  	} else {
  		return 0;
  	}
  	
  }
  
 }