<?php 
/**
 * Maximum size of the array containing the user navigation history
 */
define('STUDIOSIPAK_MAX_HISTORY', 10);
/*
 * HistoryComponent: User navigation history
 * @author: Studio Sipak
 * @website: http://webdesign.janenanneriet.nl
 * @license: MIT
 * @version: 0.1
 * */
class HistoryComponent extends Object
{
	var $data = array();
	var $started = false;
	var $controller = true;
	var $saveHistory = true;
	
	function startup(&$controller) {
		// This test will prevent it from running twice.
		if(!$this->started) {
			$this->started = true;
			$this->controller = $controller;
		}
		$this->data = $controller->Session->read('User.history');
	}
	
	function beforeRender(&$controller) { 		
		if(@$controller->params['bare'] == 0 && $this->saveHistory) {
			// debug("saving url:");
			// debug($controller->params);
			$this->_addUrl($controller->params);
			$controller->Session->write('User.history', $this->data);
		}
		
		$this->saveHistory = true;
	}

	function goBack($step = 1) {
		
		$pos = count($this->data) - $step - 1;
		$this->controller->redirect($this->data[$pos]);
		exit();
	}

	function show() {
		return $this->data;
	}

	function _addUrl($params) {
		count($params['url']) ? $url = '/'.$params['url']['url'] : $url = '/';
		if(strpos($url,'ico')) return;
		if(count($this->data) == STUDIOSIPAK_MAX_HISTORY) {
			$this->_deleteUrl();
		}
		$this->data[] = $url;
	}

	function _deleteUrl($position = 0) {
		if($position == 0) {
			
			$url = array_shift($this->data);
		//	debug("url delted:");
		//	debug($url);
		}
		else {
			array_splice($this->data, $position, 1);
		}
	}

}
?>