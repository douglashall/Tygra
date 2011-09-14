<?php

Kurogo::includePackage('Video');

class VideoAPIModule extends APIModule {    
protected $id='video';  // this affects which .ini is loaded
protected $vmin = 1;
protected $vmax = 1;
protected $feeds = array();

public static function cleanVideoArray($videoArray) {

$cleanArray = array();
foreach ($videoArray as $key => $value)
{
$cleanKey = ltrim($key, "\0*");
$cleanArray[$cleanKey] = $value;
if($cleanKey == 'published') {
$cleanArray['publishedTimestamp'] = intval($value->format('U'));
} 
}
//error_log(print_r($cleanArray, true));
return $cleanArray;
}

	protected function getFeed($feed=null) {
        $feed = isset($this->feeds[$feed]) ? $feed : $this->getDefaultSection();
        $feedData = $this->feeds[$feed];
        
        $controller = DataController::factory($feedData['CONTROLLER_CLASS'], $feedData);
        return $controller;
    }
    
    protected function getDefaultSection() {
        return key($this->feeds);
    }

public function initializeForCommand() {
$this->feeds = $this->loadFeedData();

switch ($this->command) {
case 'sections':
error_log(print_r(VideoModuleUtils::getSectionsFromFeeds($this->feeds), true));
$this->setResponse(VideoModuleUtils::getSectionsFromFeeds($this->feeds));
$this->setResponseVersion(1);                
break;
case 'videos':
case 'search':            
// videos commands requires one argument: section.
// search requires two arguments: section and q (query).
	$section = $this->getArg('section');
	$query = $this->getArg('q');                

	//$feedData = $this->feeds[$section];
	//$controller = DataController::factory($feedData['CONTROLLER_CLASS'], $feedData);
	$controller = $this->getFeed($section);
	$totalItems = $controller->getTotalItems();
	$videos = array();

		if ($this->command == 'search') {
			$items = $controller->search($query, 0, 20);
		}
		else {
			$items = $controller->items(0, 50);
		}

		foreach ($items as $video) {
			$videos[] = array(
				"id" =>$video->getID(),
				"title" =>$video->getTitle(),
				"description" => strip_tags($video->getDescription()),
				"author" =>$video->getAuthor(),
				"published" =>$video->getPublished(),
				"date" =>$video->getPublished()->format('M n, Y'),
				"url" =>$video->getURL(),
				"image" =>$video->getImage(),
				"width" =>$video->getWidth(),
				"height" =>$video->getHeight(),
				"duration" =>$video->getDuration(),
				"tags" =>$video->getTags(),
				"mobileURL" =>$video->getMobileURL(),
				"streamingURL" =>$video->getStreamingURL(),
				"stillFrameImage" =>$video->getStillFrameImage());
		}


		$this->setResponse($videos);
		$this->setResponseVersion(1);                
		break; 
		
case 'detail':
	$section = $this->getArg('section');
	$feedData = $this->feeds[$section];
	$controller = DataController::factory($feedData['CONTROLLER_CLASS'], $feedData);
	 $videoid = $this->getArg('videoid');
            
                if ($video = $controller->getItem($videoid)) {
                	$result = array(
                	"id" =>$video->getID(),
					"title" =>$video->getTitle(),
					"description" => strip_tags($video->getDescription()),
					"author" =>$video->getAuthor(),
					"published" =>$video->getPublished(),
					"date" =>$video->getPublished()->format('M n, Y'),
					"url" =>$video->getURL(),
					"image" =>$video->getImage(),
					"width" =>$video->getWidth(),
					"height" =>$video->getHeight(),
					"duration" =>$video->getDuration(),
					"tags" =>$video->getTags(),
					"mobileURL" =>$video->getMobileURL(),
					"streamingURL" =>$video->getStreamingURL(),
					"stillFrameImage" =>$video->getStillFrameImage());
					$this->setResponse($result);
					$this->setResponseVersion(1);    
				}else{
					$this->throwError(new KurogoError("Video Not Found"));
				}
                
break;
default:
$this->invalidCommand();
break;
}
}
}
