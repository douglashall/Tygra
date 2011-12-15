<?php
/**
  * @package Authentication
  */

/**
  * @package Authentication
  */
class HuidAuthentication extends AuthenticationAuthority
{
    protected $authorityClass = 'huid';
    protected $userClass='HarvardUser';
    
	protected function validUserLogins() { 
        return array('FORM');
    }
		
    protected function auth($login, $password, &$user) {
        return AUTH_FAILED;
    }

    //does not support groups
    public function getGroup($group) {
        return false;
    }

    public function login($login, $pass, Session $session, $options) {
       	//print('login='.$login.'; ');
        $user = $this->getUser($login);
        $session->login($user);
      	return AUTH_OK;
    }
    
    public function validate(&$error) {
        return true;
    }

    protected function reset($hard=false)
    {
        parent::reset($hard);
        if ($hard) {
            // this where we would log out of google
        }
    }

    public function getUser($login) {
        if (!empty($login)) {
	        $controller = DataController::factory('PeopleDataController');
			$person = $controller->findPerson($login);
	        if (isset($person['id'])) {
		        $user = new $this->userClass($this);
		        $user->setUserID($person['id']);
		        $user->setEmail($person['email']);
		        $user->setFirstName($person['firstName']);
		        $user->setLastName($person['lastName']);
		        $user->setFullName($person['firstName']." ".$person['lastName']."(".$person['id'].")");
		        if (!isset($person['courses']))
		        	return $user;
		        $courses = array();
		        $vidCount = 0;
	     		foreach ($person['courses'] as $course) {
					$result = new CourseObject();
					if (isset($course['title']))
	     				$result->setTitle($course['title']);
					if (isset($course['keyword'])) {
	     				$result->setKeyword($course['keyword']);
					}

					$courses[] = $result;
	     		}
		        $user->setCourses($courses);
<<<<<<< HEAD
=======
		        
/*		        $offset = 1;
	        	        
		        foreach($user->getCourses() as $course){
		        	$videos = array();
		        	// get the course keyword
		        	$keyword = $course->getKeyword();
		        	
		        	// get the huid of the user
		        	$huid    = $user->getUserId();
		        	
		        	// get the videos associated with the user and course
        			$videoController = DataController::factory('IsitesVideoController');
        			$results = $videoController->findVideosByHuidAndKeyword($huid, $keyword);
        			
		        	// add videos to the course object
		        	foreach($results as $video){
		        		$videoObject = new VideoObject($video);
		        		//print_r($videoObject->getEntryId().'<br />');
		        		$videos[$videoObject->getEntryId()] = $videoObject;
		        		//print_r(var_dump($videos).'<br /><br />');
      					//array_push($videos, $videoObject);
		        	}
		        	//print_r(var_dump($videos));
		        	//print_r(var_dump(array_keys($videos)));
		        	
		        	
		    //foreach ($videos as $key => $value){
 			//	print_r( $key.'=>'.$value.'<br />');
			//}
		        	
        			$course->setVideos($videos);
		        }
*/		        
		        
>>>>>>> 8e8db417c3ff782115d3d42f43a9bc4c575f886b
	        	return $user;
	        }
        }
		return new AnonymousUser();       
    }
}
