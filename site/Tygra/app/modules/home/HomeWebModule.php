<?php

class HomeWebModule extends WebModule
{
	protected $id='home';
	protected $encoding = 'UTF-8';
	protected $httpHeaders = array();
	protected $pageCacheSettings = array('index' => 86400);

	protected function showLogin() {
		return $this->getOptionalModuleVar('SHOW_LOGIN', false);
	}

	protected function addHttpHeader($headerStr) {
		$this->httpHeaders[$headerStr] = false;
	}

	protected function removeHttpHeader($headerStr) {
		$this->httpHeaders[$headerStr] = true;
	}

	protected function sendHttpHeaders() {
		foreach($this->httpHeaders as $header => $remove) {
			if($remove) {
				header_remove($header);
			} else {
				header($header);
			}
		}
	}

	// This method is invoked from WebModule::displayPage(). 
	//
	// NOTE: this hook method does NOT exist in the core Kurogo WebModule. It
	// was added to WebModule (site/Tygra/lib/WebModule.php) in order to
	// override the default caching headers. 
	protected function beforePageRender() {
		parent::beforePageRender();

		if(isset($this->pageCacheSettings[$this->page])) {
			$cacheMaxAge = $this->pageCacheSettings[$this->page];
			$this->addHttpHeader(sprintf('Cache-Control: private, max-age=%s, post-check=%s, pre-check=%s', $cacheMaxAge, intval($cacheMaxAge/2), $cacheMaxAge));
			$this->addHttpHeader("Expires: " . gmdate('D, d M Y H:i:s', time() + $cacheMaxAge) . ' GMT');
			$this->removeHttpHeader('Pragma'); // removes no-cache pragma sent by kurogo
		}

		$this->sendHttpHeaders();
	}

	protected function initializeForPage() {
		$session = $this->getSession();
		$user = $session->getUser();

		$userId= $user->getUserID();
		$restrictedFlag = false;
		if (Kurogo::getOptionalSiteVar('USER_LIST')){
			$list = Kurogo::getOptionalSiteVar('USER_LIST');
			$user_list = explode(",", $list);
	
			if (!in_array($userId, $user_list) ){
				$this->assign('restrictedFlag', "true");
				$restrictedFlag = true;
				return;
			}
		}

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
				        $total = $updatesModule->getTotalCountForCourses($user->getCourseKeywords());
				        if($total == 0) {
				            $navModules['updates']['img'] = '/modules/home/images/updatesGray'.$this->imageExt;
				            unset($navModules['updates']['url']);
				        }
				    }
				}
				$this->assign('modules', $navModules);
				$this->assign('terms', $this->getTerms());
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

	protected function getTerms() {
		$session = $this->getSession();
		$user = $session->getUser();
		$courses = $user->getCourses();
		
		if(empty($courses)) {
			return array();
		}
		
		// builds a list of course items
		foreach($courses as $course) {
			$items[] = array(
				'item' => array(
					'title' => $course->getTitle(),
					'url'   => $this->buildBreadcrumbURLForModule('course', '', array('keyword' => $course->getKeyword()))
				),
				'group' => $course->getTermGroupName(),
				'grouplabel' => $course->getTermDisplayName(),
				'sort' => array($course->getYearOrder(), $course->getTermOrder(), $course->getTitle())
			);
		}

		$sortedItems = $this->rSortCourseItems($items);
		//error_log('sorted items: '.var_export($sortedItems,1));
		
		// groups the items by term
		$terms = array();
		foreach($sortedItems as $item) {
			$group = $item['group'];
			if(isset($terms[$group])) {
				$terms[$group]['items'][] = $item['item'];
			} else {
				$terms[$group] = array(
					'label' => $item['grouplabel'],
					'items' => array($item['item'])
				);
			}			
		}
		
		$result = array_values($terms);
		//error_log('terms: '.var_export($result,1));
		
		return $result;
	}

	protected function rSortCourseItems($items) {
		usort($items, array(get_class($this), 'cmpCourseItems')); // user-defined sort
		return $items;
	}

	static function cmpCourseItems($a, $b) {
		$av = $a['sort'];
		$bv = $b['sort'];
		
		if($av[0] > $bv[0]) {
			return -1;
		} else if($av[0] == $bv[0]) {
			if($av[1] > $bv[1]) {
				return -1;
			} else if($av[1] == $bv[1]) {
				return strcasecmp($av[2], $bv[2]);
			} else {
				return 1;
			}           
		} else {
			return 1;
		}
	}

	public function searchItems($searchTerms, $limit=null, $options=null) {
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('HomeDataController');
		$items = $controller->search($user, $searchTerms);

		$searchResults = array();
		if ($items) {
			foreach($items as $item) {
				$searchResults[] = $this->linkForSearchItem($item);
			}
		}

		return $searchResults;
	}

	public function linkForSearchItem($item, $options=null) {
		$sitetitle = $item['sitetitle'];
		$topictitle = isset($item['topictitle']) ? $item['topictitle'] : '';
		$linkurl = str_replace(' ', '%20', $item['linkurl']);
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
