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
	 
     switch ($this->page) {
        case 'index':
             
             $siteList = array();
             $courses = $user->getCourses();
            
             $results = array();
             foreach ($courses as $course){

             	print_r($course.'<br />');
             	$keyword = $course->getKeyword();
             	$results = $controller->findVideosByHuidAndKeyword($huid, $keyword);
             	
             	// find videos by course and huid	
             	print_r($huid.'<br />');
             	print_r($keyword.'<br />');		
				print_r(var_dump($results).'<br />');
        		$videos = array();		
		    	// add videos to the course object only when the user clicks on a course
		    	
        		if(isset($results)){
		    		foreach($results as $video){
		        		$videoObject = new VideoObject($video);
      					$videos[] = $videoObject;
		    		}
        		}
             	
		    	$numVideos = count($videos);
		    	$course->setVideos($videos);
             	$results[] = array(
             		'keyword'=>$course->getTitle(),
             		'url'=>$this->buildBreadcrumbURL('list-course-videos', 
             			array('keyword'=>$course->getKeyword(), 'title'=>$course->getTitle().' count: '.$numVideos))
             	);
             }
             $this->assign('results', $results);
             
             break;
        case 'list-course-videos':
        	
			$keyword = $this->getArg('keyword');
			$title = $this->getArg('title');
			$this->setPageTitles($title);
			//$course = $user->findCourseByKeyword($keyword);
			
			// find videos by course and huid			
			$results = $controller->findVideosByHuidAndKeyword($huid, $keyword);
        	$videos = array();		
		    // add videos to the course object only when the user clicks on a course
		    foreach($results as $video){
		        $videoObject = new VideoObject($video);
      			$videos[] = $videoObject;
		    }
			
			$videoObjectList = $videos;
			$videoArrayList = array();
			if(!empty( $videos)){
				foreach( $videos as $videoObj) {
					$vidArray = $videoObj->toArray();
					$entryid = $videoObj->getEntryId();
					$topicid = $videoObj->getTopicId();
					$urlArray = array('url'=>$this->buildBreadcrumbURL('detail', 
						array('videoid'=>$entryid, 'keyword'=>$keyword, 'topicid'=>$topicid)));
					$merged = $vidArray + $urlArray;
					$videoArrayList[] = $merged;
				}
			}
			
            $this->assign('videos', $videoArrayList);
        	
        	break;
        case 'detail':
        	
  			$videoid = $this->getArg('videoid');
  			$keyword = $this->getArg('keyword');
  			$topicid = $this->getArg('topicid');
  			$huid = $user->getUserId();
  			$entryid = "icb.topic".$topicid.".icb.video".$videoid;
  			$results = $controller->findVideoByUserAndEntryId($huid, $entryid);
  			foreach($results as $video){
  					$this->assign('videoid', $video['entity']);
					$this->assign('keyword',$keyword);
      				$this->assign('videoTitle', $video['title'][0]);
      				$this->assign('videoThumbnail', $video['imageurl']);
      				$this->assign('videoDescription', $video['description'][0]);
      				$this->assign('modifiedOn', $video['modifiedon'] );
      				$this->assign('topicid',$video['topicid']);
      				$this->assign('entryid',$videoid);
  			}
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