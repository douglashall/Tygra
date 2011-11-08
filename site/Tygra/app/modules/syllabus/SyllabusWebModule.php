<?php

class SyllabusWebModule extends WebModule
{
	protected $id='syllabus';
	protected function initializeForPage() {
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('SyllabusDataController');
	    
		switch ($this->page)
		{
			case 'index':
				$items = $controller->search($user);
				$this->assign('results', $items);
				break;
		}
	}
}
