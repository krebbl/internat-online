<?php


class PagesController extends AppController{
	var $uses = array('Pupil','PupilComment'); 
	
	function index(){
		$this->pageTitle = 'Übersicht';
		
		$this->render('home');
	}
	function display(){
		$this->pageTitle = 'Willkommen im Adminbereich';
		
		$newPupils = $this->Pupil->findAllNewPupils(18);
		$this->set('newPupils',$newPupils);
		$comments = $this->PupilComment->findLatestComments(6);
		$this->set('comments',$comments);
		
		$this->render('home');
	}
}
?>