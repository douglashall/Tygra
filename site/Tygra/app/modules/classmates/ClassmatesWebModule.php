<?php

class ClassmatesWebModule extends WebModule
{
	protected $id='classmates';
	protected function initializeForPage() {
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('ClassmatesDataController');
		switch ($this->page)
		{
			//display course groups and members
			case 'index':
				$sections = array();
				$keyword = $this->getArg('keyword');
 				$groups = $user->getUserData('groups_'.$keyword);
 				if (!$groups) {
					$groups = $controller->findCourseGroups($keyword, $user->getUserID());
 				}
				if ($groups) {
					foreach ($groups as $group) {
						$items = array();
						$members = $group['members'];
						if ($members) {
							foreach ($members as $member) {
								$items[] = array(
										'title'=>$member['lastName'].', '.$member['firstName'],
										'url'=>$this->buildBreadcrumbURL('detail', array(
												'keyword'=>$keyword,
												'id'=>$member['id']))
								);
							}
						}
						$sections[] = array(
						'label'=>$group['name'],
						'items'=>$items
						);
					}
				}
				$this->assign('sections', $sections);
				break;
			// display student info	
			case 'detail':
				$studentId = $this->getArg('id');		
				$person = $controller->getItem($studentId);
				$this->assign('item', $person);
				$this->setPageTitles($person['firstName'].' '.$person['lastName']);
				$this->assign('photoUrl', $this->getPhotoUrl($person['huid']));
				break;
		}
	}
	
	protected function getPhotoUrl($userId) {
		$photoUrlBase = $this->getModuleVar('id_photo_url');
		$pwd = $this->getModuleVar('id_photo_password');
		$timestamp = time();
		$randomString = $this->randomString(30);
		$remoteAddr = $_SERVER["REMOTE_ADDR"];
		if ($remoteAddr == '127.0.0.1') {
			$remoteAddr = gethostbyname(gethostname());
		}
		
		$payload = RC4Crypt::encrypt($pwd, $userId.'|'.$remoteAddr.'|'.$timestamp.'|'.$randomString);
		
		$photoUrl = $photoUrlBase.bin2hex($payload).'.jpg';
		
		return $photoUrl;
	}
	
	function randomString($length = 50) {
	    $string = '';
	 
	    for ($i = 0; $i < $length; ++$i) {
	         
	        $type = rand(1, 5);
	 
	        switch ($type) {
	            case 1:
	                // lowercase letters
	                $ascii_start = 65;
	                $ascii_end = 90;                
	                break;
	            case 2:
	                // uppercase leters
	                $ascii_start = 97;
	                $ascii_end = 122;
	                break;        
	            case 3:
	                // Space
	                $ascii_start = 32;
	                $ascii_end = 32;                
	                break;   
	            case 4:
	                // numbers
	                $ascii_start = 48;
	                $ascii_end = 57;                
	                break;
	            case 5:
	                // Punctuation
	                $ascii_start = 33;
	                $ascii_end = 47;
	                break;
	        }
	         
	        $string .= chr(rand($ascii_start, $ascii_end));
	    }
	    return $string;
	}
}
