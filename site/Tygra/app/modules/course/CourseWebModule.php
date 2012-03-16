<?php
/**
  * @package Module
  * @subpackage Home
  */

/**
  * @package Module
  * @subpackage Home
  */
class CourseWebModule extends WebModule {
  protected $id = 'course';
  protected $hideFooterLinks = false;
	protected $encoding = 'UTF-8';

	protected $keyword = '';

  protected function showLogin() {
    return $this->getOptionalModuleVar('SHOW_LOGIN', false);
  }

  private function getTabletModulePanes($tabletConfig) {
    $modulePanes = array();
    
    foreach ($tabletConfig as $blockName => $moduleID) {
      $module = self::factory($moduleID, 'pane', $this->args);
      
      $paneContent = $module->fetchPage(); // sets pageTitle var
      
      $this->importCSSAndJavascript($module->exportCSSAndJavascript());
      
      $modulePanes[$blockName] = array(
        'id'      => $moduleID,
        'url'     => self::buildURLForModule($moduleID, 'index'),
        'title'   => $module->getTemplateVars('pageTitle'),
        'content' => $paneContent,
      );  
    }
   
    return $modulePanes;
  }

	// overriding this method from Module.php because it's hard coded for home...  which is kinda silly
  protected function getModuleNavigationConfig() {
      static $moduleNavConfig;
      if (!$moduleNavConfig) {
          $moduleNavConfig = ModuleConfigFile::factory('course', 'module');
      }
      
      return $moduleNavConfig;
  }
     
  protected function initializeForPage() {
  	$session = $this->getSession();
	$user = $session->getUser();
	
	// get the course title for the page
	$keyword = $this->getArg('keyword');
	$extraArgs = array(
		'keyword' => $keyword
	);
	$this->assign('extraArgs',$extraArgs);
//	if($keyword) {
		
		// set the title for the page
		$course = $user->findCourseByKeyword($keyword);
	
  		switch ($this->page) {
      		case 'help':
        	break;
              
      		case 'index':
		
      			$this->setPageTitles($course->getTitle());
      			$this->assign('user', $user);
      			$this->assign('keyword', $keyword);
      			
      			//print_r("Hello".$keyword);
      			
        		if ($this->pagetype == 'tablet') {
          
          			$this->assign('modulePanes', $this->getTabletModulePanes($this->getModuleSection('tablet_panes')));
          			$this->addInternalJavascript('/common/javascript/lib/ellipsizer.js');
          			$this->addOnOrientationChange('moduleHandleWindowResize();');
        		} else {
	
					$modules = $this->getModuleNavList();
 					foreach($this->getAllModuleNavigationData() as $type => $moduleObjs){
						foreach($moduleObjs as $id => $info){
							$module = self::factory($id);
							$modules[$id]['url'] = $this->buildBreadcrumbURLForModule($id, '', array('keyword' => $keyword));
							$modules[$id]['class'] = "module";
							
							$schools = $module->getOptionalModuleVar('displayForSchools', null);
							if(isset($schools) && $course->getSchoolId() && !in_array($course->getSchoolId(), $schools)) {
								unset($modules[$id]);
							} else if($module->getOptionalModuleVar('totalCount')){
								$total = $module->getTotalCount($keyword);
								if($total > 0){
									if($module->getOptionalModuleVar('displayTotalCount')) {
										//$modules[$id]['badge'] = $total;
										$modules[$id]['title'] .= " ($total)";
									}
								} else {
									$modules[$id]['img'] = DS. implode(DS, array('modules', 'home', 'images', $id.'Gray'.$this->imageExt));
									$modules[$id]['class'] .= ' disabledmodule';
									unset($modules[$id]['url']);
								}
							}
						}
					}
					
					$this->assign('modules', $modules);
					$this->assign('hideImages', $this->getOptionalModuleVar('HIDE_IMAGES', false));
        		}
        
        		if ($this->getOptionalModuleVar('SHOW_FEDERATED_SEARCH', true)) {
            		$this->assign('showFederatedSearch', true);
            		$this->assign('placeholder', $this->getLocalizedString("SEARCH_PLACEHOLDER", Kurogo::getSiteString('SITE_NAME')));
        		}
        		$this->assign('SHOW_DOWNLOAD_TEXT', DownloadWebModule::appDownloadText($this->platform));
        		$this->assign('displayType', $this->getModuleVar('display_type'));

// 		to be removed: test getTotalCount()         
//		foreach ($this->getAllModuleNavigationData(self::EXCLUDE_DISABLED_MODULES) as $type=>$modules) {
//            foreach ($modules as $id => $info) {
//              $module = self::factory($id);
//              if ($module->getOptionalModuleVar('totalCount')) {
//              	$total = $module->getTotalCount('k76521');
//              	$total = $module->getTotalCount('k68389');
//              }
//            }
//		}
		

        	break;
        
     		case 'search':
        
				$searchTerms = $this->getArg('filter');
				$searchResults = $this->searchItems($searchTerms, 0, $keyword);
				$this->assign('searchTerms', $searchTerms);
				$this->assign('searchResults', $searchResults);
				$this->setLogData($searchTerms);

/*
        		$federatedResults = array();
     
        		foreach ($this->getAllModuleNavigationData(self::EXCLUDE_DISABLED_MODULES) as $type=>$modules) {
        			//error_log(var_export($modules, 1));
					
            		foreach ($modules as $id => $info) {
            			$module = self::factory($id);
              			error_log($id);
						if ($module->getModuleVar('search')) {
                			error_log("has a search...");
							$results = array();
                			error_log("---");
							$total = $module->federatedSearch($searchTerms, 2, $results);
                			error_log("---");
							$federatedResults[] = array(
                  				'title'   => $info['title'],
                  				'results' => $results,
                  				'total'   => $total,
                  				'url'     => $module->urlForFederatedSearch($searchTerms),
                				);
                			unset($module);
              			}
            		}
        		}


				error_log(var_export($federatedResults, 1));
			
        		$this->assign('federatedResults', $federatedResults);
        		$this->assign('searchTerms',      $searchTerms);
        		$this->setLogData($searchTerms);
*/
        	break;
    	} // end switch
//	} // ending the if(keyword)
  }// ending initializeForPage()


	public function searchItems($searchTerms, $limit=null, $keyword=null) {
		//error_log($keyword);
		$session = $this->getSession();
		$user = $session->getUser();
		$controller = DataController::factory('CourseDataController');
		$items = $controller->search($user, $keyword, $searchTerms);

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

} // end of class
