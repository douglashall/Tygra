<?php

class SyllabusWebModule extends WebModule
{
	protected $id='syllabus';
	protected function initializeForPage() {
		$controller = DataController::factory('SyllabusDataController');
	    
		switch ($this->page)
		{
			case 'index':
				$items = $controller->search('10564158');
				$this->assign('results', $items);
				break;
		}
	}
}
