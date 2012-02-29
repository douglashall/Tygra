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
	 		
	 		break;
	 	case 'detail':
	 		$videoid = $this->getArg('videoid');
	 		$keyword = $this->getArg('keyword');
	 		
	 		$huid = $user->getUserId();
	 		
	 		$vs = $controller->findVideosByKeyword($keyword);
	 		$urls = array();
	 		foreach($vs as $v){
	 			if($v['id']==$videoid){
	 				$title = $v['displayTitle'];
	 				foreach($v['asset']['videoFileRefs'] as $ref){
							$embed = $ref['embed'];
					}
	 			}
	 		}
	 		
	 		$this->assign('keyword',$keyword);
	 		$this->assign('videoTitle', $title);
	 		
	 		$this->assign('embed', $embed);
		 		
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
 
  
  	public function getTotalCount($keyword){
  		$session = $this->getSession();
		$user = $session->getUser();
		$huid = $user->getUserId();
  		$controller = DataController::factory('IsitesVideoController');
  		$videos = $controller->findVideosByKeyword($keyword);
  		  		
  		return count($videos);
  		
  	}
  
}