<?php
/**
  * @package Authentication
  */

/**
  * @package Authentication
  */
class PinAuthentication extends AuthenticationAuthority
{
    protected $authorityClass = 'pin';
    protected $userClass='HarvardUser';
    protected $logoutUrl="https://login.pin1.harvard.edu/pin/logout";
    
	protected function validUserLogins() { 
        return array('LINK');
    }
		
    protected function auth($login, $password, &$user) {
        return AUTH_FAILED;
    }

    //does not support groups
    public function getGroup($group) {
        return false;
    }

    public function login($login, $pass, Session $session, $options) {
    	$headers = apache_request_headers();
		if (!isset($headers['HU-PIN-USER-ID'])) {
			return AUTH_FAILED;
		}
        $user = $this->getUser($headers['HU-PIN-USER-ID']);
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
		        $user->setFullName($person['firstName']." ".$person['lastName']);
		        
		        // add course data
		        if (isset($person['courses'])) {
			        $courses = array();
		     		foreach ($person['courses'] as $course) {
						$result = new CourseObject();
						if (isset($course['title']))
		     				$result->setTitle($course['title']);
						if (isset($course['keyword']))
		     				$result->setKeyword($course['keyword']);
		     					
						$courses[] = $result;
		     		}
			        $user->setCourses($courses);
		        }
		        
		        // add video data to courses
		        $videos = array();
		        foreach($user->getCourses() as $course){
		        	// get the course keyword
		        	$keyword = $course->getKeyword();
		        	
		        	// get the huid of the user
		        	$huid    = $user->getUserId();
		        	
		        	// get the videos associated with the user and course
		        	$this->setBaseUrl($baseURL.'video/by_userandkeyword/'.$huid.'/'.$keyword.'.json');
        			$data = $this->getParsedData();
        			$results = $data['video']['docs'];
        			
		        	// add videos to the course object
		        	foreach($results as $video){
		        		
		        		print_r($video);
		        		
		        		$videoObject = new VideoObject();
		        		// set each field
		        		preg_match_all('/([\d]+)/', $video['id'], $matches);
      					$videoObject->setEntryId($matches[0][1]);
      					$videoObject->setEntit($video['entity']);
      					$videoObject->setLinkUrl($video['linkurl']);
      					$videoObject->setSiteId($video['siteid']);
      					$videoObject->setTopicid($video['topicid']);
      					$videoObject->setShared($video['shared']);
      					$videoObject->setModifiedOn($video['modifiedon']);
      					$videoObject->setTitle($video['"title'][0]);
      					$videoObject->setImgUrl($video['imageurl']);
      					array_push($videos, $videoObject);
		        	}
        			$course->setVideos($videos);
        			
		        	// create video object to store course info
		        }
	        	return $user;
	        }
        }
		return new AnonymousUser();       
    }
    
    public function getLogoutUrl() {
    	return $this->logoutUrl;
    }
    
}
