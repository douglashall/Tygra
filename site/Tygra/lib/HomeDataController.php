<?php

class HomeDataController extends AuthenticatedDataController {
	protected $cacheFolder = "Home"; // set the cache folder
	protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

	public function search($user, $query = '') {
		$huid = $user->getUserID();
		$courses = $user->getCourses();
		$result = array();
		$sitekeys = '';

		foreach ($courses as $course) {
			if (strlen($sitekeys) > 0) {
				$sitekeys = $sitekeys.' OR ';
			}
			$sitekeys = $sitekeys.$course->getKeyword();
		}

		if(strlen($sitekeys) > 0) {
			$query = str_replace(array('\\', '/'), ' ', $query); // tomcat doesn't like encoded slashes

			$formattedQuery = "userid=$huid"
				."&fq=sitekey:".rawurlencode($sitekeys)
				."&fq=-category:".rawurlencode('page OR site')
				."&fl=".rawurlencode('sitetitle,topictitle,linkurl')
				."&q=".rawurlencode($query)
				."&qt=dismax" // use the dismax solr parser for user-submitted queries
				."&omitHeader=true"
				."&wt=json"
				."&start=0"
				."&rows=100";

			$this->setBaseUrl($this->baseURL.'search/select/'.$formattedQuery);
			$data = $this->getParsedData();
			$results = $data['response']['docs'];
		}

		return $results;
	}

	public function getItem($id){
	}
}

?>
