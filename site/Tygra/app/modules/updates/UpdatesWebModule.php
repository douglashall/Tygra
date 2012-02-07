<?php

class UpdatesWebModule extends WebModule
{
	protected $id='updates';
	protected function initializeForPage() {
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('UpdatesDataController');

		switch ($this->page)
		{
			case 'index':
				$sections = $controller->search($user->getUserID());
				$this->assign('sections', $sections);
				break;
		}
	}

	public function getTotalCount($keyword) {
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('UpdatesDataController');
		$sections = $controller->search($user->getUserID());

		$totalCount = 0;
		if($sections) {
			foreach($sections as $section) {
				$totalCount += count($section['items']);
			}
		}

		return $totalCount;
	}
}
