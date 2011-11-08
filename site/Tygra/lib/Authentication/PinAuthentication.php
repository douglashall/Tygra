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
        if (empty($login)) {
            return new AnonymousUser();       
        }
        
        $controller = DataController::factory('PeopleDataController');
		$person = $controller->findPerson($login);
		
        $user = new $this->userClass($this);
        $user->setUserID($login);
        $user->setEmail($person['email']);
        $user->setFirstName($person['firstName']);
        $user->setLastName($person['lastName']);
        return $user;
    }
    
    public function getLogoutUrl() {
    	return $this->logoutUrl;
    }
    
}
