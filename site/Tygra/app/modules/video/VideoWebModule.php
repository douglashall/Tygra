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
			$videoObjectList = $course->getVideos();
			$videoArrayList = array();
			
			foreach($videoObjectList as $videoObject) {
				$vidArray = $videoObject->toArray();
				$entryId = $videoObject->getEntryId();
				$urlArray = array('url'=>$this->buildBreadcrumbURL('detail', array('videoid'=>$entryId, 'keyword'=>$keyword)));
				$merged = $vidArray + $urlArray;
				$videoArrayList[] = $merged;
			}
			
             $this->assign('videos', $videoArrayList);
        	
        	break;
        case 'detail':
  			$videoid = $this->getArg('videoid');
  			$keyword = $this->getArg('keyword');
  			print_r($videoid);
  			
  			$course = $user->findCourseByKeyword($keyword);
			foreach($course->getVideos() as $video){
				if($video->getEntryId()==$videoid){
					$this->assign('videoid', $videoid);
					$this->assign('keyword',$keyword);
      				$this->assign('videoTitle', $video->getTitle());
      				$this->assign('videoThumbnail', $video->getImgUrl());
      				$this->assign('videoDescription', $video->getDescription());
      				$this->assign('modifiedOn', $video->getModifiedOn());
      				$this->assign('topicId',$video->getTopicId());
				}
			}

   			break;     
     }
  }
}