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
				$sections = $controller->search($user->getUserId(), $this->getArg('keyword'));
				$this->assign('sections', $sections);
				$this->setPageTitles('Updates');
				break;
		}
	}

	public function getTotalCount($keyword) {
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('UpdatesDataController');
		$sections = $controller->search($user->getUserID(), $keyword);

		$totalCount = 0;
		if($sections) {
			foreach($sections as $section) {
				$totalCount += count($section['items']);
			}
		}

		return $totalCount;
	}
}

?>
