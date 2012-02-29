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
				$keyword = $this->getArg('keyword');
				$items = $user->getUserData('syllabus');
				if (!$items) {
					$items = $controller->search($user);
//					$user->setUserData('syllabus', $items);
				}
				$syllabus = array();
				if ($items) {
					foreach ($items as $item) {
						if ($keyword == $item['keyword']) {
							if (count($item['syllabus']) == 0)
								break;
							foreach($item['syllabus'] as $hit) {	
								$description=null;
								if ($hit['description'])
									$description = $hit['description'][0];
									
								$syllabus[] = array(
								'title'=>$hit['title'][0],
								'url'=>$hit['linkUrl'],
								'subtitle'=>$description
								);
							}
							break;
						}
					}
	 			}
				$this->assign('results', $syllabus);
				break;
		}
	}

// OTD: I assume this is how this method will be called:
// first check that the module supports this method
// if yes - call $module->getTotalCount($courseKeyword), providing the course site keyword as a param
// if ($module->getOptionalModuleVar('totalCount')) {
//     $total = $module->getTotalCount('k76521');
	
	public function getTotalCount($keyword) {
		$ret = 0;
		$session = $this->getSession();
		$user = $session->getUser();
		$items = $user->getUserData('syllabus');
		if (!$items) {
			$controller = DataController::factory('SyllabusDataController');
			$items = $controller->search($user);
//			$user->setUserData('syllabus', $items);
		}
		if ($items) {
			foreach ($items as $item) {
				if ($keyword == $item['keyword']) {
					$ret = count($item['syllabus']);
					break;
				}
			}
		}
		
		return $ret;
	}
}
