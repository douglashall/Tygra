<?php

abstract class AuthenticatedDataController extends DataController
{
    
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