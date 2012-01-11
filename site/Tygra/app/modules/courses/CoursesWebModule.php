<?php

class CoursesWebModule extends WebModule
{
	protected $id='courses';

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
				
		      	$this->assign('modules', $modules2);
		
				//error_log(var_export($user, 1));
	    		$courses = $user->getCourses();
				$this->assign('courses', $courses);
				
				
				
				break;
		}
	}
}
