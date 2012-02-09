<?php

class UpdatesDataController extends AuthenticatedDataController {
	protected $cacheFolder = "Updates"; // set the cache folder
	protected $cacheSuffix = "json";   // set the suffix for cache files
	protected $DEFAULT_PARSER_CLASS='JSONDataParser'; // the default parser

	protected function init($args) {
		parent::init($args);
		$this->setBaseURL($this->baseURL."whatsnew/");
	}

	public function search($user_id, $keyword) {
		if($keyword) {
			return $this->findByKeyword($user_id, $keyword);
		}

		return $this->findByUser($user_id);
	}

	public function findByKeyword($user_id, $keyword) {
		$this->setBaseUrl($this->baseURL."by_keyword/$keyword.json");
		$this->addFilter('userId', $user_id);

		$data = $this->getParsedData();
		$results = $data['whatsnews']['sections'];

		return $results;
	}

	public function findByUser($user_id) {
		$this->setBaseUrl($this->baseURL."by_user/$user_id.json");

		$data = $this->getParsedData();
		$results = $data['whatsnews']['sections'];

		return $results;
	}

	// not used yet
	public function getItem($id){}

}

?>
