<?php
class SchoolSemestersController extends AppController {
	var $uses = array('SchoolSemester','SchoolClassType','SchoolClass');
	var $name = 'SchoolSemesters';
	var $helpers = array('Html', 'Form');
	var $createAction = 'create_year';
	
	function index() {
		$this->SchoolSemester->recursive = 1;
		$ss = $this->SchoolSemester->findAll();
		$this->set('SchoolSemesters',$ss);
		$this->pageTitle = 'Semester&uuml;bersicht';
	}

	function edit($id = null) {
		$this->History->saveHistory = false;
		
		$this->pageTitle = 'Semester bearbeiten';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SchoolSemester', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if(isset($this->data['submit'])){
				$success = true;
				$validationErrors = array();
				
				$this->SchoolSemester = new SchoolSemester();
				$this->SchoolSemester->createAndValidate(
					$this->data,
					$validationErrors,
					$success
				);
				
				if ($success) {
					$this->SchoolSemester->save();
					$this->Session->setFlash('Semester erfolgreich gespeichert', 'default', array(), 'success');
					$this->History->goBack(0);
				} else {
					// $this->data = $this->SchoolSemester->read(null, $id);
					$this->Session->setFlash('Semester konnte nicht gespeichert werden', 'default', array(), 'error');
				}
			}else{
				$this->History->goBack(0);
			}
			
		}
		if (empty($this->data)) {
			$this->data = $this->SchoolSemester->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SchoolSemester', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SchoolSemester->del($id)) {
			$this->Session->setFlash(__('SchoolSemester deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function create_year(){
		$this->History->saveHistory = false;
		
		$this->pageTitle = 'Neues Schuljahr anlegen';
		
		if (!empty($this->data)) {
			$success = true;
			$validationErrors = array();
			
			$this->Wintersemester = new SchoolSemester();
			$this->Wintersemester->createAndValidate(
				$this->data['Wintersemester'],
				$validationErrors['Wintersemester'],
				$success);
				
			$this->Summersemester = new SchoolSemester();
			$this->Summersemester->createAndValidate(
				$this->data['Summersemester'],
				$validationErrors['Summersemester'],
				$success);
			
			if(! (strtotime($this->Wintersemester->data['SchoolSemester']['stop_date']) 
				< strtotime($this->Summersemester->data['SchoolSemester']['start_date']))){
				$success = false;
			}
			
			if($success){
				$this->Wintersemester->save();
				$this->Summersemester->save();
				foreach ($this->data['SchoolClassType'] as $id) {
					$sc = array(
						'id' => '',
						'school_class_type_id' => $id,
						'start_semester' => $this->Wintersemester->getID(),
						'extension' => 'NEW'	
					);
					$this->SchoolClass->save($sc);
				}
				
				$this->Session->setFlash(__('Schuljahr erfolgreich angelegt', true));
				$this->redirect('index');
			}else{
				$this->set('errors',$validationErrors);
				$this->Session->setFlash(__('Schuljahr konnte nicht angelegt werden. Please, try again.', true));
			}
			
		}
		$this->set('schoolClassTypes',$this->SchoolClassType->find('all',array('order' => 'SchoolClassType.abbreviation asc')));
	}
	
	function deleteAll(){	
		if (empty($this->data)) {
			$this->Session->setFlash('Nichts ausgewählt','default', array(), 'error');
			$this->redirect(array('action'=>'index'));
		}else if($this->SchoolSemester->deleteAll(array('id' => $this->data['SchoolSemester']['ids']))){
			$this->Session->setFlash('Semester erfolgreich gelöscht','default', array(), 'success');
			$this->History->goBack(0);
		}else{
			$this->History->goBack(0);
		}
		
		/*
		if(is_array($id) && $this->SchoolSemester->deleteAll(array('id' => $id))){
			$this->Session->setFlash(__('Ausbildungsrichtungen gelöscht', true));
			$this->redirect(array('action'=>'index'));
		}*/
	}
	

}
?>