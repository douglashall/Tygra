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
		    	//$numVideos = $course->getNumVideos();
		    	$numVideos = $controller->findVideoCountByHuidAndKeyword($huid, $course->getKeyword());	
	     		$course->setNumVideos($numVideos);
		    	//print_r('count: '.$numVideos.'<br />');
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
			//icb.topic632609.icb.video17492
			
			$vs = $controller->findVideosByHuidAndKeyword($huid, $keyword);
			
			//print_r(var_dump($vs));
			
			$varray = array();
			foreach($vs as $v){
				$vid = new VideoObject($v);
				array_push($varray, $vid);
			}
			
			$videoArrayList = array();
			//if(!empty( $varrays)){
				foreach( $varray as $value) {
					
					$vidArray = $value->toArray();
					$entryid = $value->getEntryId();
					$topicid = $value->getTopicId();
					$entityid = $value->getEntity();
					//print_r($entityid);
					$modDate = $value->getModifiedOn();
  					$datetime = date("F j, Y g:i a", strtotime($modDate)); 
					$urlArray = array('modDate'=>$datetime,
									  'url'=>$this->buildBreadcrumbURL(
									  		             'detail', array(
													     'videoid'=>$entryid, 
														 'entity'=>$entityid,
												  	     'keyword'=>$keyword, 
												  	     'topicid'=>$topicid
												        )
											      )
									        );
					$merged = $vidArray + $urlArray;
					$videoArrayList[] = $merged;
					
				}
			//}
			
            $this->assign('videos', $videoArrayList);
            $this->assign('noResultsText',"No videos found");
        	
        	break;
        case 'detail':
        	
  			$videoid = $this->getArg('videoid');
  			$keyword = $this->getArg('keyword');
  			$topicid = $this->getArg('topicid');
  			$entityid = $this->getArg('entity');
  			//print_r('detail: '.$entityid);
  			$huid = $user->getUserId();
  			//$course = $user->findCourseByKeyword($keyword);
  			//$videos = $course->getVideos();
  			//$video = $videos[$videoid];
  			//print_r($videoid.'<br />'.$huid.'<br /> entity:'.$entityid.'<br />');
  			
  			//icb.topic632609.icb.video17492
  			$videoStr = $entityid.'.icb.video'.$videoid;
  			//print_r('str: '.$videoStr.'<br />');
  			$vid = $controller->findVideoByUserAndEntryId($huid, $videoStr);
  			//print_r(var_dump($vid));
  			$video = new VideoObject($vid);
  			//print_r('one: '.$vid['id']);
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