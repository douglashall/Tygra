<?php

class HomeDataController extends AuthenticatedDataController {
	protected $cacheFolder = "Home"; // set the cache folder
	protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

	public function search($user, $query = '') {
		$huid = $user->getUserID();

		$formattedQuery = "userid=$huid"
            ."&q=".rawurlencode($query)
            ."&fq=userid:$huid"
            ."&omitHeader=true"
            //."&defType=dismax" //  use this solr parser for user-submitted queries
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
