<?php

 class CourseInformationDataController extends AuthenticatedDataController
 {
     protected $cacheFolder = "CourseInformation"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
     
    protected function init($args) {
    	
        parent::init($args);
        
        $baseURL = $this->baseURL;
        $this->setBaseURL($baseURL.'courses/by_keyword/');
        
    }
     
     public function search($keyword)
     {
         $this->path = "$keyword.json";
         
         $data = $this->getParsedData();
         //TODO: replace with random generated string
		 $count = 10;
         $results = array();
         $results = $data['courses'];
         
         foreach ($results as $item) {
        	 $info = new CourseInformationObject();
        	 $info->setTitle($item['title']);
          	 $info->setSubTitle($item['subTitle']);
			 
			 $info->setCredits($item['credits']);
			 $info->setInstructorsDisplay($item['instructorsDisplay']);
			 $info->setPrereq($item['prereq']);
			 
			 $info->setMeetingTime($item['meetingTime']);
			 $info->setLocation($item['location']);
			 $info->setDescription($item['description']);
			 $info->setExamGroup($item['examGroup']);
			 
			 
			 $term = $item['term'];
			 $info->setTermDisplayName($term['displayName']);
			 
			 $course = $item['course'];
			 $info->setDepartment($course['department']);
			 $info->setSchoolId($this->getSchoolName($course['schoolId']));
			 $info->setRegistrarCode($course['registrarCode']);
			 

           	 //print_r("  info=".var_dump($info));
         	 $results[] = $info->toArray();
         }
         //return $results;
         return $info->toArray();
     }

    // not used yet
	public function getItem($id){}
	
	//Translate SchoolId to  Friendly School Name 
	//
	protected function getSchoolName($schoolId) {
		$schoolName = $schoolId;
		switch ($schoolId){
		
				case 'hsph':
					$schoolName = "School of Public Health";
					break;
				case 'colgsas':
					$schoolName = "Harvard College";
					break;
				case 'fas':
					$schoolName = "Harvard College";
					break;
				case 'hds':
					$schoolName = "Harvard Divinity School";
					break;
				case 'gsd':
					$schoolName = "Harvard Design School";
					break;
				case 'gse':
					$schoolName = "Graduate School of Education";
					break;
				case 'dce':
					$schoolName = "Division of Continuing Education";
					break;
				case 'hls':
					$schoolName = "Harvard Law School";
					break;
				case 'arb':
					$schoolName = "Arnold Arboretum";
					break;
				case 'ext':
					$schoolName = "Harvard Extension School";
					break;
				case 'rad':
					$schoolName = "Radcliffe College";
					break;
				case 'sum':
					$schoolName = "Harvard Summer School";
					break;
				case 'ksg':
					$schoolName = "Kennedy School of Government";
					break;
				case 'ksg':
					$schoolName = "Harvard Kennedy School";
					break;
				case 'hilr':
					$schoolName = "Institute for Learning and Retirement";
					break;
				case 'hcl':
					$schoolName = "Harvard College library";
					break;
				
			}// end switch
	
		
		return $schoolName;
	}


}



?>