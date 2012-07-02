<?php

class CourseInformationWebModule extends WebModule
{
	protected $id='courseinformation';
	protected function initializeForPage() {
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('CourseInformationDataController');

		switch ($this->page)
		{
			case 'index':
				$keyword = $this->getArg('keyword');
				$information = $controller->search($keyword);
				
				$this->assign('results', $information);
				$this->setPageTitles('Course Information');
				break;
		}
	
		
	}
	
	
}

?>