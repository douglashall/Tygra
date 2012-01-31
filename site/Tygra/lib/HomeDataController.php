<?php

class HomeDataController extends AuthenticatedDataController {
	protected $cacheFolder = "Home"; // set the cache folder
	protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

	public function search($user, $query = '') {
		$huid = $user->getUserID();

		$query = str_replace(array('\\', '/'), ' ', $query); // tomcat doesn't like encoded slashes
		$query = trim($query);

		$formattedQuery = "userid=$huid"
			."&fq=".rawurlencode("userid:$huid")
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

		return $results;
	}

	public function getItem($id){
	}
}

?>
