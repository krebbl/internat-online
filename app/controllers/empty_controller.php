<?php
class EmptyController extends AppController {
	var $uses = array();
	function index(){
		$this->set("str","Hello World");
		$this->render("index",FALSE);
	}
}
?>