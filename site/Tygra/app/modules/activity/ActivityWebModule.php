<?php

class ActivityWebModule extends WebModule
{
	protected $id='activity';
	protected function initializeForPage() {
		$controller = DataController::factory('ActivityDataController');
	    
		switch ($this->page)
		{
			case 'index':
				$items = $controller->search('10564158');
				$this->assign('results', $items);
				break;
		}
	}
}
