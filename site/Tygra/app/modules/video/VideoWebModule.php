<?php

class VideoWebModule extends WebModule
{
  protected $id='video';
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
             	$results[] = array(
             		'keyword'=>$course->getTitle(),
             		'url'=>$this->buildBreadcrumbURL('list-course-videos', 
             			array('keyword'=>$course->getKeyword(), 'title'=>$course->getTitle()))
             	);
             }
             $this->assign('results', $results);
             
             break;
        case 'list-course-videos':
        	
			$keyword = $this->getArg('keyword');
			$title = $this->getArg('title');
			$this->setPageTitles($title);
			$course = $user->findCourseByKeyword($keyword);
			
			// find videos by course and huid
			
			$results = $controller->findVideosByHuidAndKeyword($huid, $keyword);
        	$videos = array();		
		    // add videos to the course object only when the user clicks on a course
		    foreach($results as $video){
		        		
		        $videoObject = new VideoObject();
		        preg_match_all('/([\d]+)/', $video['id'], $matches);
      			$videoObject->setEntryId($matches[0][1]);
      			$videoObject->setEntity($video['entity']);
      			$videoObject->setLinkUrl($video['linkurl']);
      			$videoObject->setSiteId($video['siteid']);
      			$videoObject->setTopicid($video['topicid']);
      			$videoObject->setShared($video['shared']);
      			$videoObject->setModifiedOn($video['modifiedon']);
      			$videoObject->setTitle($video['title'][0]);
      			$videoObject->setDescription($video['description'][0]);
      			$videoObject->setImgUrl($video['imageurl']);
      			$videos[] = $videoObject;
		    }
		    //print_r("Videos>>>>>>>>".var_dump($videos));
		    
		    // this line doesn't seem to work
        	//$course->setVideos($videos);
			
			$videoObjectList = $videos;
			$videoArrayList = array();
			//print_r(">>>>>".var_dump($videoObjectList));
			if(!empty( $videos)){
				foreach( $videos as $videoObj) {
					$vidArray = $videoObj->toArray();
					$entryid = $videoObj->getEntryId();
					$topicid = $videoObj->getTopicId();
					//print_r("topicId=".$topicid);
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
  			
  			// icb.topic464910.icb.video39461
  			$entryid = "icb.topic".$topicid.".icb.video".$videoid;
  			//print_r($entryid);
  			$results = $controller->findVideoByUserAndEntryId($huid, $entryid);
  			
  			//$course = $user->findCourseByKeyword($keyword);
  			
  			//print_r(var_dump($results));
  			
  			foreach($results as $video){
  					$this->assign('videoid', $video['entity']);
					$this->assign('keyword',$keyword);
      				$this->assign('videoTitle', $video['title'][0]);
      				$this->assign('videoThumbnail', $video['imageurl']);
      				$this->assign('videoDescription', $video['description'][0]);
      				$this->assign('modifiedOn', $video['modifiedon']);
      				$this->assign('topicid',$video['topicid']);
      				$this->assign('entryid',$videoid);
  			}
  			
  			/*
			foreach($course->getVideos() as $video){
				print_r($video);
				if($video->getEntryId()==$videoid){
					
					$this->assign('videoid', $videoid);
					$this->assign('keyword',$keyword);
      				$this->assign('videoTitle', $video->getTitle());
      				$this->assign('videoThumbnail', $video->getImgUrl());
      				$this->assign('videoDescription', $video->getDescription());
      				$this->assign('modifiedOn', $video->getModifiedOn());
      				$this->assign('topicId',$video->getTopicId());
				}
			}*/
   			break;     
     	}
  	}
}