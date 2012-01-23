<?php

class HomeWebModule extends WebModule
{
	protected $id='home';


	protected function showLogin() {
    	return $this->getOptionalModuleVar('SHOW_LOGIN', true);
  	}


	protected function initializeForPage() {
		//$controller = DataController::factory('ActivityDataController');
	  	$session = $this->getSession();
		$user = $session->getUser();
	    
		switch ($this->page)
		{
			case 'index':
				
				//$items = $controller->search('10564158');
				$this->assign('results', array());
				
				if ($this->getOptionalModuleVar('SHOW_FEDERATED_SEARCH', true)) {
		            $this->assign('showFederatedSearch', true);
		            $this->assign('placeholder', $this->getLocalizedString("SEARCH_PLACEHOLDER", Kurogo::getSiteString('SITE_NAME')));
		        }
				$modules = $this->getModuleNavList();

				$modules2 = array();
				$modules2['updates'] = $modules['updates'];
				$modules2['links'] = $modules['links'];
				$modules2['logout'] = $modules['logout'];
				
				//error_log(var_export($modules2['updates'], 1));
				// add badges...
				//$modules2['updates']['badge'] = 1;
				
				
				
		      	$this->assign('modules', $modules2);
		
				//error_log(var_export($user, 1));
	    		$courses = $user->getCourses();
				$this->assign('courses', $courses);
				
				
				
				break;
			
			case 'search':
				$searchTerms = $this->getArg('filter');

	        	
	
				$ch = curl_init();
		        if(!$ch) {
		            error_log('Error: initializing curl session');
		            return false;
		        }

		        $proxy = "proxy.unix.fas.harvard.edu:8888";
				$url = "https://isites.harvard.edu/services/search/select/".$searchTerms;
		        $userpwd = "F7455492-E3B1-11E0-B26E-E0A8BADA4195:lcnnWEMnqrDLSVL5CifU";

		        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		        curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
		        curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_PROXY, $proxy);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		        curl_setopt($ch, CURLOPT_HEADER, 0);
		        curl_setopt($ch, CURLOPT_TIMEOUT, 25);

		        $data = curl_exec($ch);
		        $info = curl_getinfo($ch);
		        $result = array('data' => $data, 'info' => $info);

		        error_log(var_export($result, 1));

		        curl_close($ch);
		
	
	
				$federatedResults = array();

	        	foreach ($this->getAllModuleNavigationData(self::EXCLUDE_DISABLED_MODULES) as $type=>$modules) {

	            	foreach ($modules as $id => $info) {

	              		$module = self::factory($id);
	              		if ($module->getModuleVar('search')) {
	                		$results = array();
	                		$total = $module->federatedSearch($searchTerms, 2, $results);
	                		$federatedResults[] = array(
	                  			'title'   => $info['title'],
	                  			'results' => $results,
	                  			'total'   => $total,
	                  			'url'     => $module->urlForFederatedSearch($searchTerms),
	                			);
	                		unset($module);
	              		}
	            	}
	        	}

	        	$this->assign('federatedResults', $federatedResults);
	        	$this->assign('searchTerms',      $searchTerms);
	        	$this->setLogData($searchTerms);
	
				break;
			
				
		}
	}
}
