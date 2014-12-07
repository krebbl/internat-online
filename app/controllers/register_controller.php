<?php
class RegisterController extends AppController {
	var $name = 'Register';
	var $helpers = array('Html', 'Form');
	var $layout = 'registration';
	
	var $uses = array('Pupil','PupilParent','Address','SchoolSemester','County','Nationality','School','Company','SchoolClassType','SchoolClass');
	
	function beforeFilter(){
		$this->Auth->allowedActions = array('*');
	}
	
	function success(){
		$pw = $this->Session->read('pw');
		if(!$pw){
			$this->redirect('index');
		}else{
			$this->pageTitle = "Anmeldung erfolgreich";
			$this->Session->setFlash('Du hast dich erfolgreich angemeldet','default', array(), 'success');	
			$this->set('pw',$this->Session->read('pw'));
			$this->render('success');
			$this->Session->destroy();
		}
	}
	
	function index() {
		$this->pageTitle = "Anmeldung f&uuml;r das Internat der Meininger Berufsschulen";
		if(!isset($this->data)){
			$page = 1;
			$targetPage = 1;
			$this->Session->destroy();
		}else{
			$page = $this->data['_page'];
			if($page > 1 && !$this->Session->check('page1')){
				$page = 1;
				$targetPage = 1;
				$this->Session->destroy();
			}else{
				if(isset($this->data['next'])){
				$targetPage = $page + 1;
				}else if(isset($this->data['back'])){
					if($page > 1)
						$targetPage = $page - 1;
					else
						$targetPage = 1;
				}
				
				unset($this->data['next']);
				unset($this->data['back']);
			}
			
		}		
		
		// IF FORM SUBMIT IS VALID
		if($targetPage < $page || $this->bindAndValidate($page,$targetPage)){
			if($targetPage > $page){
				// SAVE THE LAST STEP
				$this->Session->write('page'.$page,$this->data);
			}
			// READ   pw
			if($targetPage < 6){
				$this->data = $this->Session->read('page'.$targetPage);
				$this->referenceData($targetPage);
				$this->set('page',$targetPage);
				$this->render('stepform');
			}else{
				//$this->render('success');
				$this->redirect('success');
			}
		}else{
			$this->set('page',$page);
			$this->referenceData($page);
			$this->render('stepform');
		}
		
	}
	
	private function referenceData($page){
		if($page == 1){
			$this->set('counties',$this->County->find('list',array('order' => 'name ASC')));
			$this->set('nationalities',$this->Nationality->find('list',array('order' => 'name ASC')));
		}else if($page == 2){
			
			
		}else if($page == 3){
			$this->set('semesters',$this->SchoolSemester->findAllForDateSelect());
			
			
			
			$this->set('companies',$this->Company->find('list',array('order' => 'name ASC')));
    		$this->set('schools',$this->School->find('list',array('order' => 'name ASC')));
			$this->set('schoolClassTypes',$this->SchoolClassType->findAllForSelect());
		}else if($page == 4){
			$currentSemester = $this->SchoolSemester->findCurrentSemester();
			
			$nextSemester = $this->SchoolSemester->findNextSemester($currentSemester);
			
			if(empty($nextSemester)){
				$this->set('semester',$currentSemester);
			}else{
				$this->set('semester',$nextSemester);
			}
			
		}else if($page == 5){
			$this->data = array();
			for($i = 1; $i < 5; $i++){
				$this->set("page".$i,$this->Session->read('page'.$i));
			}
			$data = $this->Session->read('page1');
			$this->set('nationality',$this->Nationality->findById($data['Pupil']['nationality_id']));
			$this->set('county',$this->County->findById($data['Pupil']['county_id']));
			
			
			$data = $this->Session->read('page3');
			if(!empty($data['SchoolClass']['school_class_type_id'])){
				$this->set('schoolClassType',$this->SchoolClassType->findById($data['SchoolClass']['school_class_type_id']));
				$this->set('schoolSemester',$this->SchoolSemester->findById($data['SchoolClass']['start_semester']));
			}
			
			// debug($data);
			if(isset($data['NewSchool']) && $data['NewSchool'] == 1){
				$this->set('school',$data['School']);
			}else if(!empty($data['Pupil']['school_id'])){
				$school = $this->School->findById($data['Pupil']['school_id']);
				$this->set('school',$school['School']);
			}
			
			if(isset($data['NewCompany']) && $data['NewCompany'] == 1){
				$this->set('company',$data['Company']);
			}else if(!empty($data['Pupil']['company_id'])){
				$company = $this->Company->findById($data['Pupil']['company_id']);
				$this->set('company',$company['Company']);
			}
		}
		$this->set('page',$page);
	}
	
	private function bindAndValidate($page, $targetPage){
		$errors = array();
		$isValid = true;
		switch($page){
			case 1:
				
				$this->Pupil->createAndValidate($this->data['Pupil'],$errors,$isValid);
				$this->Address->createAndValidate($this->data['Address'],$errors,$isValid);
				
				break;
			case 2:
				$this->PupilParent->createAndValidate($this->data['PupilParent'][0],$errors['PupilParent0'],$isValid);
				if($this->data['PupilParent0']['ignore_address'] == 0){
					$this->Address->createAndValidate($this->data['PupilParent'][0]['address'],$errors['PupilParentAddress0'],$isValid);
				}
				if($this->isCreateRequest($this->data['PupilParent'][1])){
					$this->PupilParent->createAndValidate($this->data['PupilParent'][1],$errors['PupilParent1'],$isValid);
					if($this->data['PupilParent1']['ignore_address'] == 0){
						$this->Address->createAndValidate($this->data['PupilParent'][1]['address'],$errors['PupilParentAddress1'],$isValid);
					}	
				}
    	
				break;
			case 3:
				if(isset($this->data['NewSchool']) && $this->data['NewSchool'] == 1){
					$this->School->createAndValidate($this->data['School'],$errors['School'],$isValid);
	
					$this->Address->createAndValidate($this->data['SchoolAddress'],$errors['SchoolAddress'],$isValid);
				}
				
				if(isset($this->data['NewCompany']) && $this->data['NewCompany'] == 1){
					$this->Company->createAndValidate($this->data['Company'],$errors['Company'],$isValid);
					$this->Address->createAndValidate($this->data['CompanyAddress'],$errors['CompanyAddress'],$isValid);
				}
				// debug($this->data);
				
				break;
			case 4:
				break;
			case 5:
				// ALL PAGES VALID
				// DO THE SUBMIT STUFF
				// GENERATE AN UNQIUE CODE
				//
							
				// create school and company with address
				$data = $this->Session->read('page3');
				
				$school_id;
				if(isset($data['NewSchool']) && $data['NewSchool'] == 1){
					$this->School->create($data['School']);
					$this->School->save();
					
					$this->Address->create($data['SchoolAddress'],$this->School);
					$this->Address->save();
					
					$school_id = $this->School->getID();
				}else{
					$school_id = $data['Pupil']['school_id'];
				}
				// debug("SCHOOL_ID: ".$school_id);
				
				$school_id;
				if(isset($data['NewCompany']) && $data['NewCompany'] == 1){
					$this->Company->create($data['Company']);
					$this->Company->save();
					
					$this->Address->create($data['CompanyAddress'],$this->Company);
					$this->Address->save();
					
					$company_id = $this->Company->getID();
				}else{
					$company_id = $data['Pupil']['company_id'];
				}
				// debug("COMPANY_ID: ".$company_id);
				
				// create school class
				$school_class_id = NULL;
				$schoolClassType = $this->SchoolClassType->findById($data['SchoolClass']['school_class_type_id']);
				if(!empty($schoolClassType)){
					$this->SchoolClass->recursive = -1;
					$schoolClass = $this->SchoolClass->find('first',
						array(
							'fields' => 'id',
							'conditions' => array(
								'school_class_type_id' => $data['SchoolClass']['school_class_type_id'],
								'start_semester' => $data['SchoolClass']['start_semester']
							)
						)
					);
					
					if(empty($schoolClass)){
						//debug("CREATE NEW SCHOOLCLASS");
						$this->SchoolClass->create($data['SchoolClass']);
						$this->SchoolClass->save();
						$school_class_id = $this->SchoolClass->getID();
					}else{
						$school_class_id = $schoolClass['SchoolClass']['id'];
						
					}
				}
				//debug("SCHOOLCLASS_ID: ".$school_class_id);
				
				// create pupil with address
				$data = $this->Session->read('page1');
				$d4 = $this->Session->read('page4');
				$d2 = $this->Session->read('page2');
				$pdata = array_merge($data['Pupil'],$d4['Pupil']);
				
				$pdata['company_id'] = $company_id;
				$pdata['school_id'] = $school_id;
				$pdata['school_class_id'] = $school_class_id;
				$pdata['splitted_custody'] = $d2['splitted_custody'];
				$pdata['passwd'] = substr(md5(uniqid(mt_rand(), true)),0,8);
				$this->Session->write('pw',$pdata['passwd']);
				
				$this->Pupil->create($pdata);
				$this->Pupil->save();
				
				$this->Address->create($data['Address'],$this->Pupil);
				$this->Address->save();
				
				$pupil_id = $this->Pupil->getID();
				
				// create parents with address
				$data = $d2;
				
				for($i = 0; $i < 2; $i++){
					if($i == 0 || $this->isCreateRequest($data['PupilParent'][$i])){
						$data['PupilParent'][$i]['pupil_id'] = $pupil_id;
						$this->PupilParent->create($data['PupilParent'][$i]);
						$this->PupilParent->save();
						if($data['PupilParent'.$i]['ignore_address'] == 0){
							$this->Address->create($data['PupilParent'][$i]['address'],$this->PupilParent);
							$this->Address->save();	
						}
					}
				}
				break;
		}
		$this->set('errors',$errors);
		return $isValid;
	}
	
	private function isCreateRequest($data){
		if(! isset($data)) return false;
		return ($data['id'] != "" &&  ! isset($data['remove'])) || isset($data['add']);
	}
}
?>