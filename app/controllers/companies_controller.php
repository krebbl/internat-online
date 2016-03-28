<?php
class CompaniesController extends AppController {

	var $name = 'Companies';
	var $scaffold;
	
	
	function index() {
		$this->pageTitle = 'Firmen';
		
		$this->Company->recursive = 1;
		$this->set('companies',$this->Company->findAll(null,null,array('Company.name ASC')));
	}
	
	function edit($id = 0){
		$this->History->saveHistory = false;
		
		if($id == 0){
			$this->pageTitle = 'Firma erstellen';
		}else{
			$this->pageTitle = 'Firma bearbeiten';
		}
		
		if (!empty($this->data)) {
			if(isset($this->data['submit'])){			
				$success = true;
				
				$validationErrors = array();
				
				#Pupil Validation
				$this->Company = new Company();
				$this->Company->createAndValidate(
					$this->data,
					$validationErrors['Company'],
					$success);
				#
				
				# Address Validation
				$this->Address = new Address();
				$this->Address->createAndValidate(
					$this->data['Address'],
					$validationErrors['Address'],
					$success);
				
				
				
				if ($success){
					$this->Company->save();
					
					$this->Address->create($this->data['Address'], $this->Company);
					$this->Address->save();
					
					$this->Session->setFlash('Firma erfolgreich gespeichert','default', array(), 'success');
					$this->History->goBack(0);
				} else {
					
					$this->set('errors',$validationErrors);
					$this->Session->setFlash('Firma konnte nicht gespeichert werden.','default', array(), 'error');
				}
			}else{
				$this->History->goBack(0);
			}
		}else if($id != 0){
			$this->data = $this->Company->read(array('Company.*', 'Address.*'), $id);
		}
	}
	
	function doDelete(){
		if(isset($this->data['Company']['ids'])){
			$ids = $this->data['Company']['ids'];
			$this->Company->deleteAllByIds($ids);
			
			$this->Session->setFlash('Firmen erfolgreich gelöscht','default', array(), 'success');
			$this->History->goBack(0);
		}else{
			$this->Session->setFlash('Nichts ausgewählt','default', array(), 'error');
			$this->History->goBack(0);
		}
	}
}
?>