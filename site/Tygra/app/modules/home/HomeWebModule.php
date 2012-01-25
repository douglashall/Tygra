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
				$this->assign('results', array());
				if ($this->getOptionalModuleVar('SHOW_FEDERATED_SEARCH', true)) {
					$this->assign('showFederatedSearch', true);
					$this->assign('placeholder', $this->getLocalizedString("SEARCH_PLACEHOLDER", Kurogo::getSiteString('SITE_NAME')));
				}
				$this->assign('modules', $this->getModuleNavList());
				$this->assign('courses', $user->getCourses());
				break;
			case 'search':
				$searchTerms = $this->getArg('filter');
				$searchResults = $this->searchItems($searchTerms);
				$this->assign('searchTerms', $searchTerms);
				$this->assign('searchResults', $searchResults);
				$this->setLogData($searchTerms);
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
