<?php

class VideoWebModule extends WebModule
{
  protected $id='video';
  protected $encoding = 'UTF-8';
  
 
  
  protected function initializeForPage() {
  	
  	 //instantiate controller
     $controller = DataController::factory('IsitesVideoController');
     
     // get the current logged in user
     $session = $this->getSession();
	 $user = $session->getUser();
	 $huid = $user->getUserID();
	 
	 //print_r('called initializeForPage('.$this->page.') for user '.$user->getFullName());
	 
     switch ($this->page) {
        case 'index':
             
             $siteList = array();
             
             $courses = $user->getCourses();
             
             foreach ($courses as $course){
		    	$numVideos = count($course->getVideos());
             	$results[] = array(
             		'keyword'=>$course->getTitle(),
             		'numVideos'=>$numVideos,
             		'url'=>$this->buildBreadcrumbURL('list-course-videos', 
             			array('keyword'=>$course->getKeyword(), 'title'=>$course->getTitle(), ))
             	);
             }
             $this->assign('noResultsText',"No courses found");
             $this->assign('results', $results);
             
             break;
        case 'list-course-videos':
        	
			$keyword = $this->getArg('keyword');
			$title = $this->getArg('title');
			$this->setPageTitles($title);
			$course = $user->findCourseByKeyword($keyword);
			
			//print_r('USER='.var_dump($user));
			
			$courseVideos = $course->getVideos();
			
			$videoArrayList = array();
			if(!empty( $courseVideos)){
				foreach( $courseVideos as $key => $value) {
					
					$vidArray = $value->toArray();
					$entryid = $value->getEntryId();
					$topicid = $value->getTopicId();
					$modDate = $value->getModifiedOn();
  					$datetime = date("F j, Y g:i a", strtotime($modDate)); 
					$urlArray = array('modDate'=>$datetime,
									  'url'=>$this->buildBreadcrumbURL(
									  		             'detail', array(
													     'videoid'=>$entryid, 
												  	     'keyword'=>$keyword, 
												  	     'topicid'=>$topicid
												        )
											      )
									        );
					$merged = $vidArray + $urlArray;
					$videoArrayList[] = $merged;
					
				}
			}
			
            $this->assign('videos', $videoArrayList);
            $this->assign('noResultsText',"No videos found");
        	
        	break;
        case 'detail':
        	
  			$videoid = $this->getArg('videoid');
  			$keyword = $this->getArg('keyword');
  			$topicid = $this->getArg('topicid');
  			$huid = $user->getUserId();
  			$course = $user->findCourseByKeyword($keyword);
  			$videos = $course->getVideos();
  			$video = $videos[$videoid];
  			$thumbnail = $video->getImgUrl();
  			$title = $video->getTitle();
  			$desc = $video->getDescription();
  			$modDate = $video->getModifiedOn();
  			$datetime = date("F j, Y g:i a", strtotime($modDate)); 
  			//print_r(var_dump($modDate).'<br />');
  			//print_r(var_dump($datetime));
  			
			$this->assign('keyword',$keyword);
      		$this->assign('videoTitle', $title);
      		$this->assign('videoThumbnail', $thumbnail);
      		$this->assign('videoDescription', $desc);
      		$this->assign('modifiedOn', $datetime );
      		$this->assign('topicid',$topicid);
      		$this->assign('entryid',$videoid);
  			
   			break;     
     	}
  	}
  	
    protected function htmlEncodeString($string) {
        return mb_convert_encoding($string, 'HTML-ENTITIES', $this->encoding);
    }
  	
    public function linkforItem(KurogoObject $video, $options=null) {    
    	
		$entryid = $video->getEntryId();
		$topicid = $video->getTopicId();
    	$videoData = $video->toArray();
    	$linkdata = array(
            'title'=>$this->htmlEncodeString($video->getTitle()),
            'url'  =>$this->buildBreadcrumbURL('detail', array('videoid'=>$entryid, 'topicid'=>$topicid,
                                            'uid'    => $video->getEntryId(),
                                            'filter' => $this->getArg('filter')
                    ))
        );
    	$merged = $videoData + $linkdata;
        return $merged;
    }
  	
    public function searchItems($searchTerms, $limit=null, $options=null) {
    	$session = $this->getSession();
	 	$user = $session->getUser();
    	$controller = DataController::factory('IsitesVideoController');
        $results = $controller->search($user, $searchTerms);
       	$videos = array();
   	    foreach($results as $video){
			$videoObject = new VideoObject($video);
      		$videos[] = $videoObject;
     	}
        return $videos;
    }
    

}