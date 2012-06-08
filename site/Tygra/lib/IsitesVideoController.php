<?php

class IsitesVideoController extends AuthenticatedDataController
{
	protected $cacheFolder = "Videos"; // set the cache folder
	protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

	public function search($query) {
		error_log("***$user***");
		$baseURL = $this->baseURL;
		$huid = $user->getUserID();
		$courses = $user->getCourses();
		$courseList = "(sitekey:";

		/*
		 * For each course, get the keyword and add it to the search query
		 */
		foreach($courses as $course){
			$courseList .= $course->getKeyword() .'%20OR%20sitekey:';
		}
		 
		/* Trim off the end of the string.
		 len of '%20OR%20sitekey:' = 16
		 */
		$lenOriginal = strlen($courseList);
		$newCourseList = substr($courseList, 0, $lenOriginal-16);

		// close the search query
		$newCourseList .= "))";
		 
		/* replace any spaces in the original query with the + character  but in the url we need to specify this with the code %2b
		 * So a query like 'Hello world' would look like 'Hello%2bworld'
		 */
		$query = preg_replace('/\s+/i', '%2B', $query);
		 
		/*
		 * Build the search query string
		 */
		$searchTerms = "((title:".$query."%20OR%20description:".$query."%20OR%20topictitle:".$query."%20OR%20sitetitle:".$query.")%20AND%20".$newCourseList;
		$formattedQuery = "userid=".$huid."&q=".$searchTerms."&omitHeader=true&fq=category:video&fq=userid:".$huid."&start=0&rows=100&wt=json";
		
		$this->setBaseUrl($baseURL.'video/by_query/'.urlencode($formattedQuery).'.json');
		$data = $this->getParsedData();
		$results = $data['video']['docs'];
		
		 print_r("results: ".$results);
		 
		return $results;
		 
	}
	
	public function findVideosByKeyword($keyword){
		$originalBaseURL = $this->baseURL;
		$baseURL = 'http://tool2.isites.harvard.edu:8937/dvs/api/lectureVideoByKeyword/'.$keyword.'.json';
		$this->setBaseUrl($baseURL);
		$data = $this->getParsedData();
		$this->baseURL = $originalBaseURL;
		return $data;
	}
	
	public function findVideosByKeyword2($keyword, $userId){
		$originalBaseURL = $this->baseURL;
		$baseURL = $originalBaseURL.'/video/byKeywordanduserid/'.$keyword.'/'.$huid.'.json';
		$this->setBaseUrl($baseURL);
		$data = $this->getParsedData();
		$this->baseURL = $originalBaseURL;
		return $data;
	}
	
	public function findVideosByHuidAndKeyword($huid, $keyword) {

		$originalBaseURL = $this->baseURL;
		
		// this will change to the new icommonsapi call that enforces topicId permissions
		//$this->setBaseUrl('http://tool2.isites.harvard.edu:8937/dvs/api/lectureVideoByKeyword/'.$keyword.'.json');
		$this->setBaseUrl('http://tool2.isites.harvard.edu:8937/dvs/api/lectureVideoByKeyword/'.$keyword.'.json');
		
		$data = $this->getParsedData();
		$this->baseURL = $originalBaseURL;
		return $data;
	}

	public function findVideoByUserAndEntryId($huid, $entryid) {

		$baseURL = $this->baseURL;
		$this->setBaseUrl($baseURL.'video/by_user_and_entryid/'.$huid.'/'.$entryid.'.json');
		$data = $this->getParsedData();
		$results = $data['video']['docs'][0];
		return $results;
	}

	public function getItemByHuidAndVideoId($huid, $keyword, $id){
		$results = $this->search($huid, $keyword);
		foreach ($results as $video) {
			if(strcmp($video['id'], $id)==0){
				$result = $video;
			}
		}
		return isset($result) ? $result : false;
	}

	public function getItem($id){
	}

}
