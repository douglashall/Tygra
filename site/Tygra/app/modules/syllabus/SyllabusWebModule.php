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
				
				$syllabus = array();
				if ($items) {
					foreach ($items as $item) {
						if (count($item['syllabus']) == 0)
							continue;
							
						$url = "";
						$description=null;
						if (count($item['syllabus']) == 1) {
							$url = $item['syllabus'][0]['linkUrl'];
							if ($item['syllabus'][0]['description'])
								$description = $item['syllabus'][0]['description'][0];
						} else
							$url = $this->buildBreadcrumbURL('detail', array(
								keyword=>$item['keyword'])
								);
								
						$syllabus[] = array(
						'title'=>$item['siteTitle'],
						'url'=>$url,
						'subtitle'=>$description
						);
					}
				}
				
				$this->assign('results', $syllabus);
				break;
			case 'detail':
				$keyword = $this->getArg('keyword');
				$items = $user->getUserData('syllabus');
				if (!$items) {
					$items = $controller->search($user);
					$user->setUserData('syllabus', $items);
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
							$this->setPageTitles($item['siteTitle']);
							break;
						}
					}
	 			}
				$this->assign('results', $syllabus);
				break;
		}
	}
}
