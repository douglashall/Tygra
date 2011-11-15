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
				$items = $user->getUserData('syllabus');
				if (!$items) {
					$items = $controller->search($user);
					$user->setUserData('syllabus', $items);
				}
				$this->assign('results', $items);
				break;
		}
	}
}
