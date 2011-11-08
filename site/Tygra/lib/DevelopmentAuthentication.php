<?php
/*
 * Created on Oct 13, 2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 /**
  * @package Authentication
  */

/**
  * This authority uses a passwd style file
  * @package Authentication
  */
class DevelopmentAuthentication extends AuthenticationAuthority
{
    protected $userClass='HarvardUser';
    
    protected function validUserLogins()
    {
        return array('FORM', 'NONE');
    }
    
    public function validate(&$error) {
        return true;
    }

    
   
    public function auth($login, $password, &$user)
    {
        if ($this->userLogin == 'NONE') { // should be FORM
            return AUTH_FAILED;
        }
        if (strlen($login)==0) {
            return new AnonymousUser();       
        }

        $user = $this->getUser($login);;
        return AUTH_OK;
    }
    
    public function getUser($login) {
        if ($this->userLogin == 'NONE') { // should be FORM
            return AUTH_FAILED;
        }
        if (strlen($login)==0) {
            return new AnonymousUser();       
        }
        // call http://icd4.isites.harvard.edu:8861/icommonsapi/people/course_person/{userId}
        $url = sprintf("http://icd4.isites.harvard.edu:8861/icommonsapi/people/course_person/%s", $login);
        $options["http"]["header"] = "Accept: " . "application/json";
        //get the data
        $data = @file_get_contents($url, false, stream_context_create($options));
        
		if ($data) {
            $json = @json_decode($data, true);
//			var_export($json);


            if (isset($json['person']['id'])) {
		        $user = new $this->userClass($this);
		        $user->setUserID($json['person']['id']);
		        $user->setEmail('developer@harvard.edu');
		        $user->setFirstName($json['person']['firstName']);
		        $user->setLastName($json['person']['lastName']);
		        
		        $user->setFullName($json['person']['firstName']." ".$json['person']['lastName']."(".$json['person']['id'].")");
		        if (!isset($json['person']['courses']))
		        	return $user;
		        $courses = array();
         		foreach ($json['person']['courses'] as $course) {
					$result = new CourseObject();
					if (isset($course['title']))
         				$result->setTitle($course['title']);
					if (isset($course['keyword']))
         				$result->setKeyword($course['keyword']);
					$courses[] = $result;
         		}
		        $user->setCourses($courses);
		        print("You are logged in as the user ".$user->getFullName());
            }
		} else {
            return AUTH_FAILED;
		}
        return $user;
    }
    
    public function getGroup($group)
    {
    	return false;
    }

    public function init($args)
    {
        parent::init($args);
//    	print("Init dev authentication module");
    }
}
