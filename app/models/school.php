<?php
class School extends AppModel {

	var $name = 'School';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			array(
				'rule' => 'notempty', 
				'message' => 'Das Feld darf nicht leer sein'),
			array(
				'rule' => 'doesNotExist',
				'message' => 'Eine Schule mit diesem Namen existiert bereits')
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasOne = array(
		'Address' => array(
			'className' => 'Address',
			'foreignKey' => 'contact_id',
			'dependent' => true,
			'conditions' => array('Address.contact_type' => 'school'),
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Pupil' => array(
			'className' => 'Pupil',
			'foreignKey' => 'school_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	function findAll(){
		return $this->find('all',array(
			'fields' => array(
				'School.*',
				'Address.*'		
				),
			'order' => 'School.name ASC'
			)
		);
	}
	
	function deleteAllByIds($ids){
		$this->Pupil->recursive = -1;
		$this->Pupil->updateFieldIdsByCondition(
			array(
				'Pupil.school_id' => $ids),
			'school',
			NULL);
			
		$this->deleteAll(array('School.id' => $ids),TRUE);
	}
	
	function doesNotExist($data){
		$this->recursive = -1;
		$result = $this->find(
        	'count', 
        	array(
        		'conditions' => 
        			array(
						"School.id !=" => ($this->id == NULL)?'0':$this->id,
        				'School.name' => $data['name']
					)
					
				)
			);
		return ($result == 0);
	}
}
?>