<?php
class SchoolClassesController extends AppController {
	var $uses = array('Pupil','SchoolClass','SchoolClassType','SchoolSemester');
	var $name = 'SchoolClasses';
	var $helpers = array('Html', 'Form', 'Javascript');
	var $createAction = 'createBySchoolClassType';
	
	function index(){
		$this->pageTitle = 'Ausbildungsklassen';
		
		$semester = $this->getSemesterFromRequest();
		
		$this->set('semesters',$this->SchoolSemester->findAllSemesters());
		$this->set('schoolClasses', $this->SchoolClass->findAllBySemester($semester));
	}
	
	function bySchoolClassType($sct_id = 0){
		$schoolClassType = $this->SchoolClassType->findById($sct_id);
		
		$this->pageTitle = 'Ausbildungsklassen für '.$schoolClassType['SchoolClassType']['name'];
		
		$this->set('schoolClasses', $this->SchoolClass->findAllBySchoolClassTypeId($sct_id));
		$this->set('schoolClassType', $schoolClassType);
		
		$this->render('index');
	}
	
	function bySchoolSemester($ss_id = 0){
		$this->set('schoolClasses', $this->SchoolClass->findAllByStartSemester($ss_id,array(
			'order' => 'start_semester DESC')));
		$this->pageTitle = 'Ausbildungsklassen für Semester';
		$this->render('index');
	}
	
	function allocations($sct_id = 0){
		if(!empty($this->data)){
			
			foreach($this->data['SchoolClass'] as $sc_id => $schoolClass){				
				$this->SchoolClass->saveWithAllocations($schoolClass,$sc_id);
			}
		}
		
		if($sct_id > 0){
			$this->set('SchoolClassType',$this->SchoolClassType->read($sct_id));
			$this->set('sct_id', $sct_id);
			$this->set('schoolClasses', $this->SchoolClass->findAllBySchoolClassTypeId($sct_id));
		}
		
	}
	
	function edit($id = 0, $sct_id = 0){
		$this->History->saveHistory = false;
		
		if (!empty($this->data) && isset($this->data['submit'])){
			$success = true;
				
			$validationErrors = array();
			#Preparing Allocation Data
			$id = 0;
			if(isset($this->data['SchoolClass']['id'])){
				$id = $this->data['SchoolClass']['id'];
			}
			
			$this->data['SchoolClass']['allocation'] = $this->SchoolClass->serializeAllocations($this->data['SchoolClass']);
			
			#SchoolClass Validation
			$this->SchoolClass = new SchoolClass();
			$this->SchoolClass->createAndValidate(
				$this->data,
				$validationErrors['SchoolClass'],
				$success);
			if ($success){
				if($this->SchoolClass->save()){
					$this->Session->setFlash('Ausbildungsklasse erfolgreich gespeichert','default', array(), 'success');
				}else{
					$this->Session->setFlash('Die Ausbildungsklasse konnte nicht gespeichert werden. <b>Bitte informieren Sie den Support</b>','default',array(),'error');	
				};
				$this->redirect('index');
			}else{
				$this->Session->setFlash('Die Ausbildungsklasse konnte nicht gespeichert werden.','default',array(),'success');
			}
		
		}
				
		if($id != 0){
			$this->pageTitle = 'Ausbildungsklasse bearbeiten';
			if (empty($this->data)) {
				$this->data = $this->SchoolClass->read(null, $id);
			}
			$this->set('schoolClassType',$this->SchoolClassType->findById($this->data['SchoolClass']['school_class_type_id']));
		}else{
			$this->pageTitle = 'Ausbildungsklasse erstellen';
			if($sct_id != 0){
				$this->set('schoolClassType',$this->SchoolClassType->findById($sct_id));	
				$this->data['SchoolClass']['school_class_type_id'] = $sct_id;
			}
		}
		$this->set('schoolClassTypes',$this->SchoolClassType->findAllForSelect());
		$this->set('semesters',$this->SchoolSemester->findAllForSelect());
	}
	
	protected function callCreateAction(){
		$this->redirect('edit/0/'.@$this->data['sct_id']);
	}
	
	protected function doDelete(){
		if(isset($this->data['SchoolClass']['ids'])){
			$ids = $this->data['SchoolClass']['ids'];
			$this->SchoolClass->deleteAllByIds($ids);
			
			$this->Session->setFlash('Ausbildungsklassen erfolgreich gelöscht!', true);
			$this->History->goBack(0);
		}		
	}
}
?>