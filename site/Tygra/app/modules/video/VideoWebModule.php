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
             //search for videos
             
             $items = $controller->search($huid);
             
             $siteList = array();

             //prepare the list
             foreach ($items as $video) {
             	
             	// need to store keyword in this array ? 
             	$keyword = $video['sitekey'];
             	$siteList[$keyword]++;
				
             }
            
             $courseList = array_keys($siteList);
             $results = array();
             foreach ($courseList as $course){
             	$results[] = array(
             		'keyword'=>$course,
             		'url'=>$this->buildBreadcrumbURL('list-course-videos', 
             			array('keyword'=>$course))
             	);
             }
			 //print_r($results);
             // send the results to the template
             $this->assign('results', $results);
             
             break;
        case 'list-course-videos':
        	
			$keyword = $this->getArg('keyword');
			//$this->assign('pageTitle', $keyword);
			$this->setPageTitles($keyword);
        	 //search for videos
             $items = $controller->searchByIdAndSite($huid, $keyword);
             //print_r($items);
             $videos = array();

             //prepare the list
             foreach ($items as $video) {
                 $videos[] = array(
                     'title'=>$video['title'][0],
                     'img'=>$video['imageurl'],
                 	 'url'=>$this->buildBreadcrumbURL('detail', array(
            		 'videoid'=>$video['id']))
                 );
             }

             $this->assign('videos', $videos);
        	
        	break;
        case 'detail':
  			$videoid = $this->getArg('videoid');
   			if ($video = $controller->getItemByHuidAndVideoId($huid, $videoid)) {
      			$this->assign('videoid', $videoid);
      			$this->assign('videoTitle', $video['title'][0]);
      			$this->assign('videoThumbnail', $video['imageurl']);
      			$this->assign('videoDescription', $video['content'][0]);
      			$this->assign('keyword',$video['sitekey']);
      			$this->assign('topicId',$video['topicid']);
      			preg_match_all('/([\d]+)/', $videoid, $matches);
      			$this->assign('entryId',$matches[0][1]);
  			} else {
      			$this->redirectTo('index');
   			}
   			break;     
     }
  }
}