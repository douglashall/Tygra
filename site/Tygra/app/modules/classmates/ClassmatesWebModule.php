<?php

class ClassmatesWebModule extends WebModule
{
	protected $id='courses';
	protected function initializeForPage() {
		//$controller = DataController::factory('ActivityDataController');
	    
		switch ($this->page)
		{
			case 'index':
				//$items = $controller->search('10564158');
				$this->assign('results', array());
				break;
		}
	}
}
