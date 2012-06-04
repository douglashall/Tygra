<?php

 class ClassmatesDataController extends AuthenticatedDataController
 {
     protected $cacheFolder = "Classmates"; // set the cache folder
     protected $cacheSuffix = "json";   // set the suffix for cache files
     protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser
     protected $passPhrase = "OmSJ8Ft6^bhsd<jshg!576bkKHSBm>?DKDgfhg~drt";
     protected $icommonsApiUrl;
     
    protected function init($args) {
    	
        parent::init($args);
        if (isset($args['PASS_PHRASE'])) {
        	$this->passPhrase = $args['PASS_PHRASE'];
        }
        
        $this->icommonsApiUrl = $this->baseURL;
//        $this->setBaseURL($baseURL.'groups/course_enrollment/');
        
    }
     
     public function search($keyword, $userId)
     {
        $this->setBaseURL($this->icommonsApiUrl.'groups/classlist/');
     	$this->path = "$keyword/$userId.json";
         $data = $this->getParsedData();
         //TODO: replace with random generated string
         $results = array();
         foreach ($data['enrollment'] as $item) {
             $person = new PersonObject();
             $person->setId(RC4Crypt::encrypt($this->passPhrase, $item['id']));
             $person->setHuid($item['id']);
             $person->setFirstName($item['firstName']);
             $person->setLastName($item['lastName']);
             $person->setEmail($item['email']);
             $results[] = $person->toArray();
         }

         return $results;
     }
     
     public function findCourseGroups($keyword, $userId)
     {
        $this->setBaseURL($this->icommonsApiUrl.'groups/course_groups/');
     	$this->path = "$keyword/$userId.json";
     	$data = $this->getParsedData();
     	$results = array();
     	foreach ($data['groups'] as $item) {
     		$group = new GroupObject();
     		$group->setId($item['idType'].':'.$item['idValue']);
     		$group->setName($item['name']);
     		$results[] = $group->toArray();
     	}
     
     	return $results;
     }
     
     public function findCourseGroupMembers($id, $keyword, $userId)
     {
        $this->setBaseURL($this->icommonsApiUrl.'groups/course_group_members/');
     	$this->path = "$keyword/$id/$userId.json";
     	$data = $this->getParsedData();
     	$results = array();
     	foreach ($data['members'] as $item) {
     		$person = new PersonObject();
     		$person->setId(RC4Crypt::encrypt($this->passPhrase, $item['id']));
     		$person->setHuid($item['id']);
     		$person->setFirstName($item['firstName']);
     		$person->setLastName($item['lastName']);
     		$person->setEmail($item['email']);
     		$results[] = $person->toArray();
     	}
     
     	return $results;
     }
      
     // find a person by id
     public function getItem($id){
     	$this->setBaseURL($this->icommonsApiUrl.'people/by_id/');
     	$huid = RC4Crypt::decrypt($this->passPhrase, $id);
     	$this->path = "$huid.json";
     	$data = $this->getParsedData();
     	
        $person = new PersonObject();
        foreach ($data['people'] as $item) {
			if ($item['id'] == $huid) {
				$person->setId(RC4Crypt::encrypt($this->passPhrase, $item['id']));
				$person->setHuid($item['id']);
				$person->setFirstName($item['firstName']);
				$person->setLastName($item['lastName']);
				$person->setEmail($item['email']);
				break;
             }
        }
        
        return $person->toArray();
     }

 }