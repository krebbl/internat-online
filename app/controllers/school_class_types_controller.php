<?php
class SchoolClassTypesController extends AppController {
	var $uses = array('SchoolClassType','SchoolClass');
	var $name = 'SchoolClassTypes';
	var $helpers = array('Html', 'Form');
	var $createAction = 'add';
	
	function index() {
		$this->SchoolClassType->recursive = 1;
		$sct = $this->SchoolClassType->find('all',array('order' => 'SchoolClassType.abbreviation'));
		$this->set('schoolClassTypes',$sct);
		
		$this->set('tasks',
			array(
				array(
					'label' => 'Ausbildungsrichtung erstellen', 
					'link' => array('controller' => 'school_class_types', 'action' => 'add')
				)
			)
		);
		
		$this->pageTitle = 'Ausbildungsrichtungen';
	}

	function doDelete(){
		if(!empty($this->data['SchoolClassType']['ids'])){
	    	$this->SchoolClassType->deleteAll(
	    		array(
	    			'id' => $this->data['SchoolClassType']['ids']
			   	)
			);
			$this->SchoolClass->deleteAll(
				array(
					'school_class_type_id' => $this->data['SchoolClassType']['ids']
				)
			);
			
			$this->Session->setFlash('Ausbildungsrichtung erfolgreich gelöscht!', true);
			$this->History->goBack(0);
			
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SchoolClassType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('schoolClassType', $this->SchoolClassType->read(null, $id));
	}

	function add() {
		$this->History->saveHistory = false;
		$this->pageTitle = 'Neue Ausbildungsrichtung erstellen';
		if (!empty($this->data)) {
			$this->SchoolClassType->create($this->data);
			if ($this->SchoolClassType->save()) {
				$this->Session->setFlash('Ausbildungsrichtung erfolgreich gespeichert','default', array(), 'success');
				$this->redirect('index');
			} else {
				$this->Session->setFlash('Ausbildungsrichtung konnte nicht gespeichert werden','default', array(), 'error');
			}
		}
	}

	function edit($id = null) {
		$this->History->saveHistory = false;
		
		$this->pageTitle = 'Ausbildungsrichtung bearbeiten';
		if (!empty($this->data) && isset($this->data['submit'])) {

			
			if(isset($this->data['SchoolClass'])){
				foreach($this->data['SchoolClass'] as $sc_id => $schoolClass){
					$this->SchoolClass->saveWithAllocations($schoolClass,$sc_id);
				}
			}
			if ($this->SchoolClassType->save($this->data)) {
				$this->Session->setFlash('Ausbildungsrichtung erfolgreich gespeichert','default', array(), 'success');
				$this->redirect('index');
			} else {
				// $this->data = $this->SchoolClassType->read(null, $id);
				$this->Session->setFlash('Ausbildungsrichtung konnte nicht gespeichert werden','default', array(), 'error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SchoolClassType->read(null, $id);
		}
		$this->set('schoolClasses', $this->SchoolClass->findAllBySchoolClassTypeId($id));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SchoolClassType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SchoolClassType->del($id)) {
			$this->Session->setFlash(__('SchoolClassType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function deleteAll(){
		if (empty($this->data)) {
			$this->Session->setFlash(__('Keine Ausbildungsrichtungen ausgewählt!', true));
			$this->redirect(array('action'=>'index'));
		}else if($this->SchoolClassType->deleteAll(array('id' => $this->data['SchoolClassType']['ids']))){
			$this->Session->setFlash(__('Ausbildungsrichtungen erfolgreich gelöscht!', true));
			$this->redirect(array('action'=>'index'));
		}else{
			
			$this->redirect(array('action'=>'index'));
		}
	}
	

}
?>