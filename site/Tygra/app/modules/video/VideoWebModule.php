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
	 		$title = $course->getTitle();
	 		 		
	 		if($vs = $controller->findVideosByHuidAndKeyword($huid, $keyword)){
	 			 			
		 		$varray = array();
		 		foreach($vs as $v){
		 			$vid = new VideoObject($v);
		 			array_push($varray, $vid);
		 		}
		 			
		 		$videos = array();
				foreach( $varray as $value) {
					$vidArray = $value->toArray();
					$entryid = $value->getEntryId();
					$topicid = $value->getTopicId();
					$entityid = $value->getEntity();
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
					$videos[] = $merged;
				}
				
				$this->assign('videos', $videos);
				$this->assign('pageTitle', $title);
				$this->assign('listcourses',"false");
				$this->assign('noResultsText',"[list-course-videos] No videos found");
	 		}
	 		else {
	 			$this->redirectTo('home');
	 			
	 		}
	 		break;
	 	case 'detail':
	 		$videoid = $this->getArg('videoid');
	 		$keyword = $this->getArg('keyword');
	 		$topicid = $this->getArg('topicid');
	 		$entityid = $this->getArg('entity');
	 		$huid = $user->getUserId();
	 		$videoStr = $entityid.'.icb.video'.$videoid;
	 		
	 		if($vid = $controller->findVideoByUserAndEntryId($huid, $videoStr)){
		 		$video = new VideoObject($vid);
		 		$thumbnail = $video->getImgUrl();
		 		$title = $video->getTitle();
	    			$this->setPageTitles($title);
		 		$desc = $video->getDescription();
		 		$modDate = $video->getModifiedOn();
		 		$datetime = date("F j, Y g:i a", strtotime($modDate));
		 			
		 		$this->assign('keyword',$keyword);
		 		$this->assign('videoTitle', $title);
		 		$this->assign('videoThumbnail', $thumbnail);
		 		$this->assign('videoDescription', $desc);
		 		$this->assign('modifiedOn', $datetime );
		 		$this->assign('topicid',$topicid);
		 		$this->assign('entryid',$videoid);
	 		}
	 		else {
	 			$this->redirectTo('home');
	 		}
	 		break;
	 	}
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
	public function getTotalCount($keyword) {
		$session = $this->getSession();
		$user = $session->getUser();
		$huid = $user->getUserId();
		$controller = DataController::factory('IsitesVideoController');
		$numVideos = $controller->findVideoCountByHuidAndKeyword($huid, $keyword);
		return $numVideos;
	}
}