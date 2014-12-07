<?php
class PrintController extends AppController {
	var $name = 'Print';
	var $uses = array('Pupil'); 
    
	function beforeFilter(){
		
		$this->Auth->allow('bypw');
		$this->Auth->allow('index');
		
		$this->History->saveHistory = false;
		// Configure::write('debug',0);
		
		$this->layout = 'pdf';
	}
	
    function index() 
    { 
		Configure::write('debug',0);
		$this->pageTitle = "Anmeldebogen ausdrucken";
        $this->layout = 'registration';
        $this->render();
		
    } 
	
	function pupil($p_id){
		
		$this->Pupil->recursive = 2;
		$this->Pupil->unbindModel(
				array(
					'belongsTo' => array('SchoolSemester')
				)	
			);
		$pupil = $this->Pupil->findById($p_id);
		$this->set('pupil',$pupil);
		$this->render('/print/pupil',false);
	}
	
	function bypw($pw = 0){
		$this->Pupil->recursive = 2;
		$this->Pupil->unbindModel(
				array(
					'belongsTo' => array('SchoolSemester')
				)	
			);
		if($pw === 0){
			$pw = $this->data['Pupil']['password'];
		}
		$pupil = $this->Pupil->findByPassword($pw);
		if(empty($pupil)){
			$this->layout = 'registration';
        	$this->redirect('index');
			// $this->redirect('/register');
		}else{
			$this->set('pupil',$pupil);
			$this->render('/print/pupil',false);
		}
	}
}
?>