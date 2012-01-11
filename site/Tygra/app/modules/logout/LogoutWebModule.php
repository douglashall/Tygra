<?php

class LogoutWebModule extends WebModule
{
	protected $id='logout';
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
			case 'index':
				$this->redirectToModule('login','logout',array('authority'=>$authority->getAuthorityClass()));
				break;
		}
	}
}
