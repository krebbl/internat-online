<?php
class PupilsAjaxController extends AppController {
	 var $uses = array(
    	"Pupil", "Address", "Company");
		
	function beforeFilter(){
		parent::beforeFilter();
		// $timer->start("History");
		$this->History->saveHistory = false;
		Configure::write('debug',0);
		
		$this->layout = 'default';
		$this->layoutPath = 'json';
		// debug("Saving History took: ".$timer->stop("History"));
		$this->Auth->deny('*');
		$this->Auth->allow('schoolclassselection');
	}
	
	function schoolClassSelection($sct_id){
		$this->loadModel("SchoolClass");
		$this->set('schoolClasses',$this->SchoolClass->findAllForSelectBySchoolClassType($sct_id));
		
		$this->render('/pupils/ajax/school_class_selection_list', FALSE);
	}	
	
	function depositDialog($p_id = 0){
		$this->loadModel("Deposit");
		// $timer->start("Query");
    	if(! empty($this->data)){
    		$this->data['Deposit']['pupil_id'] = $this->data['Pupil']['id'];
    		
    		$this->Deposit->create($this->data['Deposit']);
    		if($this->Deposit->save($this->data['Deposit'],false)){
    			$this->data['Deposit']['id'] = $this->Deposit->getID();
    			$this->data['Deposit']['paid_in'] = $this->Deposit->field('paid_in');
    			$this->data['Deposit']['paid_out'] = $this->Deposit->field('paid_out');
    			
    			$this->set('deposit',$this->data['Deposit']);
    			$this->set('pupil',$this->data['Pupil']);
    			
    			$this->render('/elements/pupil_table_deposit');
    		}else{
    			$this->set('status','error');
    			$this->render('/pupils/dialogs/deposit');
    		}		
    	}else if($p_id > 0){
    		$this->Pupil->recursive = 0;
			$this->Pupil->unbindModel(
				array(
					'belongsTo' => array('School','Company','SchoolClass','SchoolClassType','SchoolSemester'),
					'hasMany' => array('PupilParent','PupilComment'),
					'hasOne' => array('Address')
				)	
			);
			$this->Pupil->Deposit->unbindModel(
				array(
					'belongsTo' => array('Pupil')
				)
			);
		
			
			$this->data = $this->Pupil->read(array('Pupil.id', 'Pupil.firstname','Pupil.lastname, Deposit.*'), $p_id);
			if($this->data['Deposit']['paid_out'] == '0001-01-01' || empty($this->data['Deposit']['paid_out'])){
				$this->data['Deposit']['paid_out'] = date("Y-m-d");
			}
			// debug("Query took: ".$timer->stop("Query"));
			$this->render('/pupils/dialogs/deposit', FALSE);
    	}
    }

	function invoiceDialog() {
		$ids = $this->params['url']["ids"];
		if(isset($ids)) {

			$pupils = $this->Pupil->findAllById($ids, array());
			$companyIds = array();

			foreach ($pupils as $p) {
				$companyIds[] = $p['Pupil']['company_id'];
			}

			$addresses = $this->Address->find('all', array(
				'fields' => array('Address.*', 'Company.name'),
				'joins' => array('LEFT JOIN companies Company ON Company.id = contact_id'),
				'conditions' => array(
					'contact_id' => $companyIds,
					'contact_type' => array('company_invoice', 'company'))
			));
			$addressOptions = array();
			foreach ($addresses as $address) {
				$contact = !empty($address['Address']['contact']) ? $address['Address']['contact'] : $address['Company']['name'];
				$addressOptions[$address['Address']['id']] = ($contact). " / " . $address['Address']['street'] . " in " . $address['Address']['zipcode'] . " " . $address['Address']['city'];
			}
			
			$this->set('addressOptions', $addressOptions);
			$this->data['Pupil']["ids"] = $ids;
		}
		$this->render('/pupils/dialogs/invoice', FALSE);
	}
    
     function carDialog($p_id = 0){
     	$this->loadModel("PupilCar");
		if(! empty($this->data)){
    		$this->data['PupilCar']['pupil_id'] = $this->data['Pupil']['id'];
    		
    		if($this->PupilCar->save($this->data['PupilCar'])){
    			$this->data['PupilCar']['id'] = $this->PupilCar->getID();
    		
    			$this->set('car',$this->data['PupilCar']);
    			$this->set('pupil',$this->data['Pupil']);
    			
    			$this->render('/elements/pupil_table_car');
    		}else{
    			$this->set('status','error');
    			$this->render('/pupils/dialogs/car');
    		}		
    	}else if($p_id > 0){
    		$this->Pupil->recursive = 0;
			$this->Pupil->unbindModel(
				array(
					'belongsTo' => array('School','Company','SchoolClass','SchoolClassType','SchoolSemester'),
					'hasMany' => array('PupilParent','PupilComment'),
					'hasOne' => array('Address')
				)	
			);
			$this->Pupil->PupilCar->unbindModel(
				array(
					'belongsTo' => array('Pupil')
				)
			);
			$this->data = $this->Pupil->read(array('Pupil.id', 'Pupil.firstname', 'Pupil.lastname', 'PupilCar.*'), $p_id);
	
			$this->render('/pupils/dialogs/car', FALSE);
    	}
    }
    
    function roomDialog($p_id = 0){
    	
    	if(! empty($this->data)){
    		$this->Pupil->id = $this->data['Pupil']['id'];
    		if($this->Pupil->save($this->data['Pupil'])){
    			$this->set('pupil',$this->data['Pupil']);
    			$this->render('/elements/pupil_table_room');
    		}else{
    			$this->set('status','error');
    			$this->render('/pupils/dialogs/room');
    		}		
    	}else if($p_id > 0){
    		$this->Pupil->recursive = -1;
			$this->Pupil->unbindModel(
				array(
					'belongsTo' => array('School','Company','SchoolClass','SchoolClassType','SchoolSemester'),
					'hasMany' => array('PupilParent','PupilComment','Deposit'),
					'hasOne' => array('Address')
				)	
			);
			$this->data = $this->Pupil->read(array('Pupil.id', 'Pupil.firstname', 'Pupil.lastname','Pupil.room'), $p_id);
			
			$this->render('/pupils/dialogs/room', FALSE);
    	}
	}
	
	function commentsDialog($p_id = 0){
		$this->loadModel("PupilComment");
    	if(! empty($this->data)){
    		$this->data['PupilComment']['pupil_id'] = $this->data['Pupil']['id'];
   
			$user = $this->Auth->user();
			$this->data['PupilComment']['user_id'] = $user['User']['id'];
			if($this->PupilComment->save($this->data['PupilComment'])){
    			
    			$this->set('pupil',$this->data['Pupil']);
    			$this->set('comments',$this->PupilComment->find('count', array('conditions' => array('PupilComment.pupil_id' => $this->data['Pupil']))));
				$this->render('/elements/pupil_table_comment');
    		}else{
    			$this->set('status','error');
    			$this->render('/pupils/dialogs/comments');
    		}		
    	}else if($p_id > 0){
    		$this->Pupil->recursive = -1;
			$this->Pupil->unbindModel(
				array(
					'belongsTo' => array('School','Company','SchoolClass','SchoolClassType','SchoolSemester'),
					'hasMany' => array('PupilParent','PupilComment'),
					'hasOne' => array('Address')
				)	
			);
			
			$this->data = $this->Pupil->read(array('Pupil.id', 'Pupil.firstname', 'Pupil.lastname'), $p_id);
			$this->set(
				'PupilComments',
				$this->PupilComment->find('all', 
					array(
						'conditions' => array('PupilComment.pupil_id' => $p_id),
						'limit' => 3, 
						'order' => array('PupilComment.created DESC')
				)
			));
			
			$this->render('/pupils/dialogs/comments', FALSE);
    	}
	}
	
	function checkOutDialog($p_id = 0){
    	if(! empty($this->data)){
    		$this->Pupil->id = $this->data['Pupil']['id'];
    		if($this->Pupil->save($this->data['Pupil'])){
    			$this->set('pupil',$this->data['Pupil']);
    			$this->render('/elements/pupil_table_check_out');
    		}else{
    			$this->set('status','error');
    			$this->render('/pupils/dialogs/check_out');
    		}		
    	}else if($p_id > 0){
    		$this->Pupil->recursive = -1;
			$this->Pupil->unbindModel(
				array(
					'belongsTo' => array('School','Company','SchoolClass','SchoolClassType','SchoolSemester'),
					'hasMany' => array('PupilParent','PupilComment','Deposit'),
					'hasOne' => array('Address')
				)	
			);
			$this->data = $this->Pupil->read(array('Pupil.id', 'Pupil.firstname', 'Pupil.lastname', 'Pupil.checked_out', 'Pupil.banished'), $p_id);
			
			$this->render('/pupils/dialogs/check_out', FALSE);
    	}
	}
	
}
?>