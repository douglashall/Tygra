	<?php
/**
  * @package Module
  * @subpackage Login
  */

/**
  * @package Module
  * @subpackage Login
  */
class LoginWebModule extends WebModule {
  protected $id = 'login';
  
  // ensure that the login module always has access 
  protected function getAccessControlLists($type) {
        return array(AccessControlList::allAccess());
  }


  protected function initializeForPage() {
    if (!Kurogo::getSiteVar('AUTHENTICATION_ENABLED')) {
        throw new KurogoConfigurationException($this->getLocalizedString("ERROR_AUTHENTICATION_DISABLED"));
    }
    
    $session = $this->getSession();
    
    //return URL
    $url = $this->getArg('url','');
    
    //see if remain logged in is enabled by the administrator, then if the value has been passed (i.e. the user checked the "remember me" box)
    $allowRemainLoggedIn = Kurogo::getOptionalSiteVar('AUTHENTICATION_REMAIN_LOGGED_IN_TIME');
    if ($allowRemainLoggedIn) {
        $remainLoggedIn = $this->getArg('remainLoggedIn', 0);
    } else {
        $remainLoggedIn = 0;
    }
    
    // initialize
    $authority = null;
    
    // cycle through the defined authorities in the config
    foreach (AuthenticationAuthority::getDefinedAuthenticationAuthorities() as $authorityIndex=>$authorityData) {
        // USER_LOGIN property determines whether the authority is used for logins (or just groups or oauth)
        $USER_LOGIN = $this->argVal($authorityData, 'USER_LOGIN', 'NONE');

        // trap the exception if the authority is invalid (usually due to misconfiguration)
        try {
            $authority = AuthenticationAuthority::getAuthenticationAuthority($authorityIndex);
            $authorityData['listclass'] = $authority->getAuthorityClass();
            $authorityData['title'] = $authorityData['TITLE'];
            $authorityData['url'] = $this->buildURL('login', array(
                'authority'=>$authorityIndex,
                'url'=>$url,
                'remainLoggedIn'=>$remainLoggedIn,
                'startOver'=>1
            ));
        } catch (KurogoConfigurationException $e) {
            Kurogo::log(LOG_WARNING, "Invalid authority data for %s: %s", $authorityIndex, $e->getMessage(), 'auth');
            $invalidAuthorities[$authorityIndex] = $e->getMessage();
        }
    }
                 
    //see if we have any valid authorities
    if (!$authority) {
        $message = $this->getLocalizedString("ERROR_NO_AUTHORITIES");
        //we don't
        throw new KurogoConfigurationException($message);
        
    }
    
    switch ($this->page)
    {
        case 'logoutConfirm':
            //this page is presented when a specific authority is chosen and the user is presented the option to actually log out.
            $authorityIndex = $this->getArg('authority');
            
            if (!$this->isLoggedIn($authorityIndex)) {
                // they aren't logged in
                $this->redirectTo('index', array());
            } elseif ($user = $this->getUser($authorityIndex)) {
                $authority = $user->getAuthenticationAuthority();
                
                $this->assign('message', $this->getLocalizedString('LOGIN_SIGNED_IN_SINGLE',
                    Kurogo::getSiteString('SITE_NAME'),
                    $authority->getAuthorityTitle(), 
                    $user->getFullName()
                ));
                
                $this->assign('url', $this->buildURL('logout', array('authority'=>$authorityIndex)));
                $this->assign('linkText', $this->getLocalizedString('SIGN_OUT'));
                $this->setTemplatePage('message');
            } else {
                //This honestly should never happen
                $this->redirectTo('index', array());
            }
            
            break;
        case 'logout':
            $authorityIndex = $this->getArg('authority');
            //hard logouts attempt to logout of the indirect service provider (must be implemented by the authority)
            $hard = $this->getArg('hard', false);

            if (!$this->isLoggedIn($authorityIndex)) {
                //not logged in
                $this->redirectTo('index', array());
            } elseif ($authority = AuthenticationAuthority::getAuthenticationAuthority($authorityIndex)) {
                $user = $this->getUser($authority);

                //log them out 
                $result = $session->logout($authority, $hard);
            } else {
                //This honestly should never happen
                $this->redirectTo('index', array());
            }
                
            if ($result) { 
                $this->setLogData($user, $user->getFullName());
                $this->logView();

                //if they are still logged in return to the login page, otherwise go home.
                if ($this->isLoggedIn()) {
                    $this->redirectTo('index', array('logout'=>$authorityIndex));
                } else {
                	if ($authorityData['USER_LOGIN'] == 'FORM') {
        				$this->redirectTo('login', array('url'=>$url));
		        	} else {
		        		header("Location: " . $authority->getLogoutUrl());
                    	exit();
		        	}
                }
            } else {
                //there was an error logging out
                $this->setTemplatePage('message');
                $this->assign('message', $this->getLocalizedString("ERROR_SIGN_OUT"));
            }
        
            break;
            
        case 'login':
    		if ($this->isLoggedIn($authority)) {
    			if ($url) {
                    header("Location: $url");
                    exit();
                } else {
                    $this->redirectToModule('home','',array('login'=>$authority));
                }
            }
            
        	$login          = $this->argVal($_POST, 'loginUser', '');
            $password       = $this->argVal($_POST, 'loginPassword', '');
            $options = array(
                'url'=>$url
            );
            
            $session  = $this->getSession();
			
    		$result = $authority->login($login, $password, $session, $options);

            switch ($result)
            {
                case AUTH_OK:
                    $user = $this->getUser($authority);
                    $this->setLogData($user, $user->getFullName());
                    $this->logView();
                    if ($url) {
                        header("Location: $url");
                        exit();
                    } else {
                        $this->redirectToModule('home','',array('login'=>$authorityIndex));
                    }
                    break;
                    
                default:
                    $this->_401();
            }
            
            break;
            
        case 'index':
        	if ($authorityData['USER_LOGIN'] == 'FORM') {
        		$this->assign('authority', $authority);
        	} else {
        		$this->redirectTo('login', array('url'=>$url));
        	}
        	break;
        	
    }
  }

  protected function _401() {
  	header("HTTP/1.1 401 Unauthorized");
	$url = $_SERVER['REQUEST_URI'];
	Kurogo::log(LOG_WARNING, "URL $url unauthorized", 'kurogo');
	echo <<<html
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>401 Unauthorized</title>
</head><body>
<h1>Unauthorized</h1>
<p>You are not authorized to access the requested URL $url on this server.</p>
</body></html>
html;
    exit();
  }
  
}

