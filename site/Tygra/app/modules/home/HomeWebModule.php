<?php

class HomeWebModule extends WebModule
{
	protected $id='home';
	protected $encoding = 'UTF-8';

	protected function showLogin() {
		return $this->getOptionalModuleVar('SHOW_LOGIN', true);
	}

	protected function initializeForPage() {
		$session = $this->getSession();
		$user = $session->getUser();

		switch ($this->page)
		{
			case 'index':
				$this->setPageTitles('My Courses');
				$this->assign('results', array());
				if ($this->getOptionalModuleVar('SHOW_FEDERATED_SEARCH', true)) {
					$this->assign('showFederatedSearch', true);
					$this->assign('placeholder', $this->getLocalizedString("SEARCH_PLACEHOLDER", Kurogo::getSiteString('SITE_NAME')));
				}

				$navModules = $this->getModuleNavList();
				if(isset($navModules['updates'])) {
				    $updatesModule = self::factory('updates');
				    if($updatesModule->getOptionalModuleVar('totalCountForCourses')) {
				        $keywords = array();
				        $total = $updatesModule->getTotalCountForCourses($user->getCourseKeywords());
				        if($total == 0) {
				            $navModules['updates']['img'] = '/modules/home/images/updatesGray'.$this->imageExt;
				            unset($navModules['updates']['url']);
				        }
				    }
				}
				$this->assign('modules', $navModules);

				$courses = $user->getCourses();
				$courseItems = array();
				foreach($courses as $course) {
					$courseItems[] = array(
						'title' => $course->getTitle(),
						'url'   => $this->buildBreadcrumbURLForModule('course', '', array(
							'keyword' => $course->getKeyword()
						))
					);
				}
				$this->assign('courseItems', $courseItems);
				break;
			case 'search':
				$searchTerms = $this->getArg('filter');
				if(strlen($searchTerms) > 0) {
					$searchResults = $this->searchItems($searchTerms);
					$this->assign('searchTerms', $searchTerms);
					$this->assign('searchResults', $searchResults);
					$this->setLogData($searchTerms);
				} else {
					$this->redirectToModule($this->id, 'index'); // search was blank
				}
				break;
		}
	}

	public function searchItems($searchTerms, $limit=null, $options=null) {
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('HomeDataController');
		$items = $controller->search($user, $searchTerms);

		$searchResults = array();
		foreach($items as $item) {
			$searchResults[] = $this->linkForSearchItem($item);
		}

		return $searchResults;
	}

	public function linkForSearchItem($item, $options=null) {
		$sitetitle = $item['sitetitle'];
		$topictitle = isset($item['topictitle']) ? $item['topictitle'] : '';
		$linkurl = $item['linkurl'];
		$title = $sitetitle . ($topictitle !== '' ? " ($topictitle)" : '');

		$result = array(
			'title' => $this->htmlEncodeString($title),
			'url' => $linkurl
		);

		return $result;
	}

	protected function htmlEncodeString($string) {
		return mb_convert_encoding($string, 'HTML-ENTITIES', $this->encoding);
	}
}

?>
