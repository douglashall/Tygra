<?php

class ClassmatesWebModule extends WebModule
{
	protected $id='classmates';
	protected function initializeForPage() {
		$controller = DataController::factory('ClassmatesDataController');
	    
		switch ($this->page)
		{
			case 'index':
				$items = $controller->search('10564158');
				$this->assign('results', $items);
				break;
		}
	}
}
