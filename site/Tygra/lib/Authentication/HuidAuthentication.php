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
       	print('login='.$login.'; ');
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
	     		foreach ($person['courses'] as $course) {
					$result = new CourseObject();
					if (isset($course['title']))
	     				$result->setTitle($course['title']);
					if (isset($course['keyword']))
	     				$result->setKeyword($course['keyword']);
					$courses[] = $result;
	     		}
		        $user->setCourses($courses);
		        print("You are logged in as the user ".$user->getFullName());
	        	return $user;
	        }
        }
		return new AnonymousUser();       
        
    }
}
