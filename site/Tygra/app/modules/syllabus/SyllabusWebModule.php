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
			case 'detail':
				$keyword = $this->getArg('keyword');
				$items = $user->getUserData('syllabus');
				if (!$items) {
					$items = $controller->search($user);
					$user->setUserData('syllabus', $items);
				}
				if ($items) {
					foreach ($items as $item) {
						if ($keyword == $item['keyword']) {
							$this->assign('results', $item['syllabus']);
							$this->setPageTitle($item['siteTitle']);
							break;
						}
					}
	 			}
				break;
		}
	}
}
