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
		
	 		$keyword = $this->getArg('keyword');
	 		$course = $user->findCourseByKeyword($keyword);
	 		$vs = $controller->findVideosByKeyword($keyword);
	 		$title = $course->getTitle();
	 		
	 		//print_r($huid."<br />");
	 		//print_r($keyword."<br />");
	 		
	 		//$list = $controller->findVideosByKeyword($keyword);
	 		
	 		//if($vid = $controller->findVideoByUserAndEntryId($huid, $videoStr)){
	 		
	 		//print_r(var_dump($list));
	 		 		
	 		if($vs = $controller->findVideosByKeyword($keyword)){
	 			 			
		 		$varray = array();
		 		foreach($vs as $v){
		 			$vid = new VideoObject($v);
		 			array_push($varray, $vid);
		 		}
		 			
		 		$videos = array();
				foreach( $varray as $value) {
					$vidArray = $value->toArray();
					$entryid = $value->getEntryId();
					$modDate = $value->getModifiedOn();
					$datetime = date("F j, Y g:i a", strtotime($modDate));
					$urlArray = array('modDate'=>$datetime,
									  'url'=>$this->buildBreadcrumbURL(
									  		             'detail', array(
													     'videoid'=>$entryid, 
												  	     'keyword'=>$keyword
							)
						)
					);
					$merged = $vidArray + $urlArray;
					$videos[] = $merged;
				}
				
				$this->assign('videos', $videos);
				$this->assign('pageTitle', $title);
				$this->assign('listcourses',"false");
				$this->assign('noResultsText',"[list-course-videos] No videos found");
	 		}
	 		/*else {
	 			$this->redirectTo('home');
	 			
	 		}*/
	 		break;
	 	case 'detail':
	 		$videoid = $this->getArg('videoid');
	 		$keyword = $this->getArg('keyword');
	 		
	 		//print_r($keyword."<br />");
	 		//print_r($huid);
	 		
	 		//$topicid = $this->getArg('topicid');
	 		//$entityid = $this->getArg('entity');
	 		
	 		$huid = $user->getUserId();
	 		//$videoStr = $entityid.'.icb.video'.$videoid;
	 		
	 		//if($vid = $controller->findVideoByUserAndEntryId($huid, $videoStr)){
	 		
		 		$vs = $controller->findVideosByKeyword($keyword);
		 		$urls = array();
		 		foreach($vs as $v){
		 			if($v['id']==$videoid){
		 				foreach($v['asset']['videoFileRefs'] as $ref){
		 					if($ref['mediaType']=="video"){
								//array_push($urls, $url['sourceUrl']);
								$embed = $ref['embed'];
		 					}
						}
		 			}
		 		}
		 		
	 			//$video = new VideoObject($vid);
		 		
		 		//$thumbnail = $video->getImgUrl();
		 		//$title = $video->getTitle();
	    			//$this->setPageTitles($title);
		 		//$desc = $video->getDescription();
		 		//$modDate = $video->getModifiedOn();
		 		//$datetime = date("F j, Y g:i a", strtotime($modDate));

		 		//$this->assign('mediaurls', $urls);
		 		//print_r("embed: ".$embed);
		 		$this->assign('keyword',$keyword);
		 		//$this->assign('videoTitle', $title);
		 		//$this->assign('videoThumbnail', $thumbnail);
		 		$this->assign('embed', $embed);
		 		//$this->assign('videoDescription', $desc);
		 		//$this->assign('modifiedOn', $datetime );
		 		//$this->assign('topicid',$topicid);
		 		$this->assign('entryid',$videoid);
	 		//}
	 	//	else {
	 	//		$this->redirectTo('home');
	 	//	}
	 		break;
	 	}
	}
	
	// overriding this method from Module.php because it's hard coded for home...  which is kinda silly
  protected function getModuleNavigationConfig() {
      static $moduleNavConfig;
      if (!$moduleNavConfig) {
          $moduleNavConfig = ModuleConfigFile::factory('video', 'module');
      }
      
      return $moduleNavConfig;
  }
	
/*
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
*/
  /*
	public function getTotalCount($keyword) {
		$session = $this->getSession();
		$user = $session->getUser();
		$huid = $user->getUserId();
		$controller = DataController::factory('IsitesVideoController');
		$numVideos = $controller->findVideoCountByHuidAndKeyword($huid, $keyword);
		return 5;
	}
	*/
  
  	public function getTotalCount($keyword){
  		$session = $this->getSession();
		$user = $session->getUser();
		$huid = $user->getUserId();
  		$controller = DataController::factory('IsitesVideoController');
  		
  		$videos = $controller->findVideosByKeyword($keyword);
  		//$lectureVideos = $controller->findVideosByKeyword($keyword);
  		
  		//print_r("videos = ".count($videos));
  		
  		return count($videos);
  		
  	}
  
}