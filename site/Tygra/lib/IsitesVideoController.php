<?php

class IsitesVideoController extends DataController
{
	protected $cacheFolder = "Videos"; // set the cache folder
	protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

	public function search($user, $query) {

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
		//print_r($query);
		 
		/*
		 * Build the search query string
		 */
		$searchTerms = "((title:".$query."%20OR%20description:".$query."%20OR%20topictitle:".$query."%20OR%20sitetitle:".$query.")%20AND%20".$newCourseList;
		$formattedQuery = "userid=".$huid."&q=".$searchTerms."&omitHeader=true&fq=category:video&fq=userid:".$huid."&start=0&rows=100&wt=json";
		 
		/*
		 * There are issues when you try to send the query in plain text to the search url.
		 * Base64 encode the query to send it to the search service
		 */
		
		//$b64EncodedQuery = base64_encode($formattedQuery);
		
		$this->setBaseUrl($baseURL.'video/by_query/'.urlencode($formattedQuery).'.json');
		$data = $this->getParsedData();
		$results = $data['video']['docs'];
		 
		return $results;
		 
	}

	public function findVideosByHuidAndKeyword($huid, $keyword) {

		$originalBaseURL = $this->baseURL;
		$baseURL = $this->baseURL;
		$this->setBaseUrl($baseURL.'video/by_user_and_keyword/'.$huid.'/'.$keyword.'.json');
		$data = $this->getParsedData();
		$this->baseURL = $originalBaseURL;
		$results = $data['video']['docs'];
		return $results;
	}
	
	public function findVideoCountByHuidAndKeyword($huid, $keyword) {

		$originalBaseURL = $this->baseURL;
		$baseURL = $this->baseURL;
		$this->setBaseUrl($baseURL.'video/count_by_user_and_keyword/'.$huid.'/'.$keyword.'.json');
		$data = $this->getParsedData();
		$this->baseURL = $originalBaseURL;
		$results = $data['video'];
		return $results;
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
