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

  protected function showLogin() {
    return $this->getOptionalModuleVar('SHOW_LOGIN', true);
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
//	if($keyword) {
		
		// set the title for the page
		$course = $user->findCourseByKeyword($keyword);
		$this->setPageTitle($course->getTitle());
	
  		switch ($this->page) {
      		case 'help':
        	break;
              
      		case 'index':
		
      			$this->assign('user', $user);
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

							if($module->getOptionalModuleVar('totalCount')){
								$total = $module->getTotalCount($keyword);
								if($total > 0){
									$modules[$id]['badge'] = $total;
								} else {
									$modules[$id]['img'] = preg_replace("/\.png/", "Gray.png", $modules[$id]['img']);
									$modules[$id]['img'] = preg_replace("/images\//", "images\/tygra_", $modules[$id]['img']);
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
        	break;
    	} // end switch
//	} // ending the if(keyword)
  }// ending initializeForPage()

} // end of class
