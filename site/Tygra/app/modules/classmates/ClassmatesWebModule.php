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
			// courses
			case 'index':
				$items = array();
	 			foreach ($user->getCourses() as $course) {
					$items[] = $course->toArray();
					$this->assign('results', $items);
	 			}
				break;
			case 'people':
				$keyword = $this->getArg('keyword');
				$students = $user->getUserData('enrollee_'.$keyword);
				if (!$students) {
					$students = $controller->search($keyword, $user->getUserID());
					$user->setUserData('enrollee_'.$course->getKeyword(), $items);
				}
				$results = array("keyword" => $keyword, "people" => $students);
				$this->assign('results', $results);
				break;
			case 'detail':
				$id = $this->getArg('id');
				$keyword = $this->getArg('keyword');
				$students = $user->getUserData('enrollee_'.$keyword);
				if ($students) {
					foreach ($students as $student) {
						if ($id == $student['id']) {
							$this->assign('item', $student);
							// TODO: add a valid photoUrl to the module config
//							$this->assign('photoUrl', $this->getPhotoUrl($student['huid']));
							break;
						}
					}
	 			}
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
