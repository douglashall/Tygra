<?php

class UpdatesWebModule extends WebModule
{
	protected $id='updates';
	protected function initializeForPage() {
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('UpdatesDataController');
		$controller->setBaseURL($this->getModuleVar('data_url'));
	    
		switch ($this->page)
		{
			case 'index':
				$items = $controller->search($user->getUserID());
				$this->assign('results', $items);
				break;
		}
	}
}
