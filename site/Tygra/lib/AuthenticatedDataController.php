<?php

abstract class AuthenticatedDataController extends DataController
{
 
  	protected function url() {
        $url = $this->baseURL;
        if ($this->path) {
        	$url .= $this->path;
        	$this->path = NULL;
        }
        if (count($this->filters)>0) {
            $glue = strpos($this->baseURL, '?') !== false ? '&' : '?';
            $url .= $glue . http_build_query($this->filters);
        }
        
        return $url;
    }
    
    protected function initStreamContext($args) {
    	$streamContextOpts = array();
        
        if (isset($args['HTTP_PROXY_URL'])) {
            $streamContextOpts['http'] = array(
                'proxy'          => $args['HTTP_PROXY_URL'], 
                'request_fulluri'=> TRUE
            );
        }
        
        if (isset($args['HTTPS_PROXY_URL'])) {
            $streamContextOpts['https'] = array(
                'proxy'          => $proxyConfigs['HTTPS_PROXY_URL'], 
                'request_fulluri'=> TRUE
            );
        }
        
    	if (isset($args['USERNAME']) && isset($args['PASSWORD'])) {
            $streamContextOpts['http'] = array(
                'header'         => "Authorization: Basic " . base64_encode($args['USERNAME'] . ":" . $args['PASSWORD'])
            );
        }
        
        $this->streamContext = stream_context_create($streamContextOpts);
    }

}