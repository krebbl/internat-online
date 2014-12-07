<?php
App::import('Helper','Timer');

class AjaxController extends AppController {		
	
	function beforeFilter(){
		$timer = new TimerHelper();
		// $timer->start("History");
		$this->History->saveHistory = false;
		// Configure::write('debug',0);
		
		$this->layout = 'default';
		$this->layoutPath = 'json';
		// debug("Saving History took: ".$timer->stop("History"));
	}
}
?>