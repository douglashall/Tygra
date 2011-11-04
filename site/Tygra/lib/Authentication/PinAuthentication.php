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
    protected $peopleDataUrl;
    
	public function init($args)
    {
        parent::init($args);
        $args = is_array($args) ? $args : array();
        if (!isset($args['PEOPLE_DATA_URL']) || strlen($args['PEOPLE_DATA_URL'])==0) {
            throw new KurogoConfigurationException("People data url not set");
        }

        $this->peopleDataUrl = $args['PEOPLE_DATA_URL'];
    }
    
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
        if (empty($login)) {
            return new AnonymousUser();       
        }
        
        $controller = DataController::factory('PeopleDataController');
		$controller->setBaseURL($this->peopleDataUrl);
		$person = $controller->findPerson($login);
		
        $user = new $this->userClass($this);
        $user->setUserID($login);
        $user->setEmail($person['email']);
        $user->setFirstName($person['firstName']);
        $user->setLastName($person['lastName']);
        return $user;
    }
}

/**
  * @package Authentication
  */
class HarvardUser extends User
{

}
