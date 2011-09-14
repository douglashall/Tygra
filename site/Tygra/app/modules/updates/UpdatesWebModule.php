<?php

class UpdatesWebModule extends WebModule
{
	protected $id='updates';
	protected function initializeForPage() {
		$controller = DataController::factory('UpdatesDataController');
	    
		switch ($this->page)
		{
			case 'index':
				$items = $controller->search('10564158');
				$this->assign('results', $items);
				break;
		}
	}
}
