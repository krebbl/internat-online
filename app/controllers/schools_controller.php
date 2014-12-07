<?php
class SchoolsController extends AppController {
	var $name = 'Schools';
	
	
	function index() {
		$this->pageTitle = 'Schulen';
		
		$this->School->recursive = 1;
		$this->set('schools',$this->School->findAll());
	}
	
	function edit($id = 0){
		$this->History->saveHistory = false;
		
		if($id == 0){
			$this->pageTitle = 'Schule erstellen';
		}else{
			$this->pageTitle = 'Schule bearbeiten';
		}
		
		if (!empty($this->data)) {
			if(isset($this->data['submit'])){			
				$success = true;
				
				$validationErrors = array();
				
				#Pupil Validation
				$this->School = new School();
				$this->School->createAndValidate(
					$this->data,
					$validationErrors['School'],
					$success);
				#
				
				# Address Validation
				$this->Address = new Address();
				$this->Address->createAndValidate(
					$this->data['Address'],
					$validationErrors['Address'],
					$success);
				
				if ($success){
					$this->School->save();
					
					$this->Address->create($this->data['Address'], $this->School);
					$this->Address->save();
					
					$this->Session->setFlash('Schule erfolgreich gespeichert','default', array(), 'success');
					$this->History->goBack(0);
				} else {
					
					$this->set('errors',$validationErrors);
					$this->Session->setFlash('Schule konnte nicht gespeichert werden.','default', array(), 'error');
				}
			}else{
				$this->History->goBack(0);
			}
		}else if($id != 0){
			$this->data = $this->School->read('School.*, Address.*', $id);	
		}
	}
	
	function doDelete(){
		if(isset($this->data['School']['ids'])){
			$ids = $this->data['School']['ids'];
			$this->School->deleteAllByIds($ids);
			
			$this->Session->setFlash('Schulen erfolgreich gelöscht','default', array(), 'success');
			$this->History->goBack(0);
		}else{
			$this->Session->setFlash('Nichts ausgewählt','default', array(), 'error');
			$this->History->goBack(0);
		}	
	}
}
?>