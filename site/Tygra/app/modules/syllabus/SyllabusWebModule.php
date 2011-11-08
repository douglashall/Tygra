<?php

class SyllabusWebModule extends WebModule
{
	protected $id='syllabus';
	protected function initializeForPage() {
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('SyllabusDataController');
//		$controller->setBaseURL($this->getModuleVar('data_url'));
	    
		switch ($this->page)
		{
			case 'index':
				$items = $controller->search($user);
//				var_export($items);
				$this->assign('results', $items);
				break;
		}
	}
}
