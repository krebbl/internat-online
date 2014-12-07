<?php
class PupilsController extends AppController {
	var $uses = array(
    	"Pupil","PupilCar","SchoolSemester","SchoolClass","SchoolClassType","Deposit","Nationality","County","PupilParent","PupilComment","Address","School","Company");
	var $name = 'Pupils';
	
	function beforeFilter(){
		parent::beforeFilter();
		Configure::write('debug', 0);
	}
	
	function index(){
		
		// set semesters
    	$semester = $this->getSemesterFromRequest();
		$this->set('semesters',$this->SchoolSemester->findAllSemesters());
		$this->set('currentSemester',$this->SchoolSemester->findCurrentSemester());
		
		$this->pageTitle = 'Schüler im '.$semester[0]['title'];
		
		// $schoolClassIds = $this->SchoolClass->findAllIdsBySemester($semester);
		// $pupils = $this->Pupil->findAllBySchoolClassIDs($schoolClassIds);
		
		$pupils = $this->Pupil->findAllBySemester($semester);
		
		$this->set('pupils',$pupils);
		//$timer = new TimerHelper();
		//$this->set('timer',$timer);
		//$timer->start("rendering");
		$this->render();
    }
	
	function checkedout(){
		
		// set semesters
    	$semester = $this->getSemesterFromRequest();
		$this->set('semesters',$this->SchoolSemester->findAllSemesters());
		$this->set('currentSemester',$this->SchoolSemester->findCurrentSemester());
		
		$this->pageTitle = 'Abgemeldete Schüler im '.$semester[0]['title'];
		
		// $schoolClassIds = $this->SchoolClass->findAllIdsBySemester($semester);
		// $pupils = $this->Pupil->findAllBySchoolClassIDs($schoolClassIds);
		
		$pupils = $this->Pupil->findAllBySemester($semester,TRUE);
		
		$this->set('pupils',$pupils);
		//$timer = new TimerHelper();
		//$this->set('timer',$timer);
		//$timer->start("rendering");
		$this->render('index');
    }
	
	function current(){
		$currentCW = date('W');
    	// set semesters
		if(! $this->data['cw']){
			$this->data['cw'] = $currentCW;
		}
		$this->set('currentSemester',$this->SchoolSemester->findCurrentSemester());
		
		$schoolClassIds = $this->SchoolClass->findAllIdsByCalendarWeek($this->data['cw']);
		$pupils = $this->Pupil->findAllBySchoolClassIDs($schoolClassIds);
		
		$this->set('pupils',$pupils);
		$this->set('current_cw',$currentCW);
		$this->pageTitle = 'Belegung für die '.$this->data['cw'].'.KW';
    }
	
	 function moveBy($field,$id){
    	if (!empty($this->data) && isset($this->data['move'])){
    		# MOVING
    		if(isset($this->data['Pupil']['ids']) && count($this->data['Pupil']['ids'])> 0){
    			if(isset($this->data['Pupil'][$field.'_id'])){ 
					$this->Pupil->updateFieldIdsByPupilIds(
						$this->data['Pupil']['ids'],
						$field,
						$this->data['Pupil'][$field.'_id']);
					$this->Session->setFlash('Schüler erfolgreich verschoben','default',array(),'success');
				}	
			}else{
				$this->Session->setFlash('Keine Schüler ausgewählt','default',array(),'error');
			}
		}
		
		$pupils = $this->Pupil->findAllByFieldAndId($field,$id);
		
		$title = 'Sch&uuml;ler f&uuml;r ';
		if($field == 'school'){
			$row = $this->School->findById($id,array('fields' => 'name'));
			$title .= $row['School']['name'];
			$this->set('schools',$this->School->find('list',array('order' => 'School.name')));
		}else if($field == 'school_class'){
			$schoolClass = $this->setDataForSchoolClassType($id);
			$title .= $schoolClass['SchoolClassType']['abbreviation'].' '.$schoolClass[0]['agegroup'];
		}else if($field == 'company'){
			$row = $this->Company->findById($id,array('fields' => 'name'));
			$title .= $row['Company']['name'];
			$this->set('companies',$this->Company->find('list',array('order' => 'Company.name')));
		}
		
		$this->pageTitle = $title;
		$this->set('target','pupil_form_'.$field);
		$this->set('pupils',$pupils);
		
		
		# TODO: Set List for change
		
    }
	  
    
    function edit($id = 0){
    	$this->History->saveHistory = false; 
		
		
		# Setting the ReferenceData
		$this->set('companies',$this->Company->find('list',array('order' => 'name ASC')));
    	$this->set('schools',$this->School->find('list',array('order' => 'name ASC')));
    	$this->set('counties',$this->County->find('list',array('order' => 'name ASC')));
		$this->set('nationalities',$this->Nationality->find('list',array('order' => 'name ASC')));
		
		if (!empty($this->data) && isset($this->data['submit'])) {

			$this->setDataForSchoolClassType($this->data['Pupil']['school_class_id']);

			$success = true;

			$validationErrors = array();

			#Pupil Validation
			$this->Pupil = new Pupil();
			$this->Pupil->createAndValidate(
				$this->data['Pupil'],
				$validationErrors['Pupil'],
				$success);
			
			# Address Validation
			$this->Address = new Address();
			$this->Address->createAndValidate(
				$this->data['Address'][0],
				$validationErrors['Address'],
				$success);
			
			# Deposit Validation
			$this->Deposit = new Deposit();
			$createDeposit = $this->isCreateRequest($this->data['Deposit']);
			$removeDeposit = $this->isRemoveRequest($this->data['Deposit']);
			if($createDeposit){	
				
				if(!isset($this->data['Deposit']['paid_out'])){
					$this->data['Deposit']['paid_out'] = array();
				}
				
				$this->Deposit->createAndValidate(
					$this->data['Deposit'],
					$validationErrors['Deposit'],
					$success);
					
				unset($this->data['Deposit']['paid_out']);
			}
			
			# Car Validation
			$createCar = $this->isCreateRequest($this->data['PupilCar']);
			$removeCar = $this->isRemoveRequest($this->data['PupilCar']);
			$this->PupilCar = new PupilCar();
			if($createCar){
				$this->PupilCar->createAndValidate($this->data['PupilCar'],$validationErrors,$success);
			}
			
			$PupilParent = array();
			$PupilParentAddress = array();
			$PupilParentPhone = array();
			$createParent = array();
			$removeParent = array();
			
			$createParentAddress = array();
			$removeParentAddress = array();
			for ($i=0; $i < 2; $i++) { 
				$createParent[$i] = $this->isCreateRequest(@$this->data['PupilParent'][$i]);
				$PupilParent[$i] = new PupilParent();
				if($createParent[$i] || $i == 0)
				{
					# PupilParent i Validation
					$PupilParent[$i]->createAndValidate(
						$this->data['PupilParent'][$i],
						$validationErrors['pupilParent'.$i],
						$success);

					# PupilParent i Address Validation
					$PupilParentAddress = @$this->data['PupilParent'][$i]['address'];
					$createParentAddress[$i] = $this->isCreateRequest($PupilParentAddress);
					if($createParentAddress[$i])
					{
						$PupilParent[$i]->address->createAndValidate(
							$PupilParentAddress,
							$validationErrors['pupilParentAddress'.$i],
							$success);
					}
					$removeParentAddress[$i] = $this->isRemoveRequest($PupilParentAddress);
				}
				$removeParent[$i] = $this->isRemoveRequest(@$this->data['PupilParent'][$i]);
			}
						
			if ($success){
				#TODO Save the shit
				$this->Pupil->save();
				$p_id = $this->Pupil->getID();
				
				$this->Address->data['Address']['contact_type'] = 'pupil';
				$this->Address->data['Address']['contact_id'] = $p_id;
				$this->Address->save();
				
				if($createDeposit){
					$this->Deposit->data['Pupil']['pupil_id'] = $p_id;
					$this->Deposit->save();
				}
				
				if($removeDeposit){
					$this->Deposit->remove();
				}
				
				if($createCar){
					$this->PupilCar->data['Pupil']['pupil_id'] = $p_id;
					$this->PupilCar->save();
				}
				
				if($removeCar){
					$this->PupilCar->remove();
				}
				
				for ($i=0; $i < 2; $i++) { 
					if($createParent[$i])
					{
						$PupilParent[$i]->data['PupilParent']['pupil_id'] = $p_id;
						$PupilParent[$i]->save();
						
						if($createParentAddress[$i]){
							$PupilParent[$i]->address->data['Address']['contact_type'] = 'parent';
							$PupilParent[$i]->address->data['Address']['contact_id'] = $PupilParent[$i]->getID();	

							$PupilParent[$i]->address->save();
						}
						if($removeParentAddress[$i]){
							$PupilParent[$i]->address->remove();
							unset($this->data['PupilParent'][$i]['address']);
						}	
					}
					
					
					if($removeParent[$i]){
						$PupilParent[$i]->remove($this->data['PupilParent'][$i]['id']);
						unset($this->data['PupilParent'][$i]);
					}
					
				}
				
				
				
				$this->Session->setFlash('Schüler erfolgreich gespeichert','default',array(),'success');
				$this->History->goBack(0);
			} else {
				#TODO do not save the shit
				$this->set('errors',$validationErrors);
				$this->Session->setFlash('Schüler konnte nicht gespeichert werden','default',array(),'error');
			}
		}
		if(!empty($this->data) && isset($this->data['print'])){
			$this->redirect(array('controller' => 'print','action' => 'pupil', $this->data['Pupil']['id']));
		}
		if (empty($this->data)) {
			
			$this->Pupil->recursive = 2;
			$this->Pupil->unbindModel(
				array(
					'belongsTo' => array('School','Company')
				)	
			);
			$this->Pupil->PupilParent->recursive = 1;
			
			$this->Pupil->PupilComment->recursive = 1;
			
			$this->Pupil->Deposit->unbindModel(
				array(
					'belongsTo' => array('Pupil')
				)
			);
			if($id > 0){
				$this->data = $this->Pupil->read('*', $id);
				
			}
			$this->setDataForSchoolClassType(@$this->Pupil->data['Pupil']['school_class_id']);
		}
		if($id > 0){
			$this->pageTitle = $this->data['Pupil']['firstname']." ".$this->data['Pupil']['lastname']." (angemeldet am ".$this->data['Pupil']['created'].")";
    	}else{
			$this->pageTitle = 'Schüler erstellen';
		}
	}
	
	private function isCreateRequest($data){
		if(! isset($data)) return false;
		return ($data['id'] != "" &&  ! isset($data['remove'])) || isset($data['add']);
	}
	
	private function isRemoveRequest($data){
		if(! isset($data)) return false;
		return $data['id'] != "" && isset($data['remove']);
	}
	
	private function setDataForSchoolClassType($sc_id = 0){
		$this->set('schoolClassTypes',$this->SchoolClassType->findAllForSelect());
		
		if($sc_id > 0){
			$SchoolClass = $this->SchoolClass->findById($sc_id);
			$sct_id = $SchoolClass['SchoolClass']['school_class_type_id'];
			$this->set('schoolClassTypeId',$sct_id);
			$this->set('schoolClasses', $this->SchoolClass->findAllForSelectBySchoolClassType($sct_id));
			return $SchoolClass;
		}else{
			$this->set('schoolClasses', array());
		}
		
		return null;
	}
    
   function doDelete(){
		if(isset($this->data['Pupil']['ids'])){
			$ids = $this->data['Pupil']['ids'];
			$this->Pupil->deleteAllByIds($ids);
			
			$this->Session->setFlash('Schüler erfolgreich gelöscht','default', array(), 'success');
			$this->History->goBack(0);
		}	
	}
	
	function export(){
		Configure::write('debug',0);
		
		$this->History->saveHistory = false; 
		
		$ids = $this->data['Pupil']['ids'];
		if(!empty($ids)){
			$pupils = $this->Pupil->findAllByIDs($ids);
			$this->set('pupils',$pupils);
			$this->layout = 'excel';
			$this->render('excel/list');
			//$this->render('deposits');
		}else{
			$this->Session->setFlash('Nichts ausgewählt','default', array(), 'error');
			$this->History->goBack(0);
		}
		
		
	}
    
}

?>