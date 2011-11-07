<?php

class SyllabusWebModule extends WebModule
{
	protected $id='syllabus';
	protected function initializeForPage() {
		$controller = DataController::factory('SyllabusDataController');
		$session = $this->getSession();
		$user = $session->getUser();
	    
		switch ($this->page)
		{
			case 'index':
				$items = $controller->search($user);
				var_export($items);
				$this->assign('results', $items);
				break;
		}
	}
}
