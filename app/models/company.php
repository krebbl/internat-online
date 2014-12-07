<?php
class Company extends AppModel {

	var $name = 'Company';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			array(
				'rule' => 'notempty', 
				'message' => 'Das Feld darf nicht leer sein'),
			array(
				'rule' => 'doesNotExist',
				'message' => 'Eine Firma mit diesem Namen existiert bereits')
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Pupil' => array(
			'className' => 'Pupil',
			'foreignKey' => 'company_id',
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
	
	var $hasOne = array(
		'Address' => array(
			'className' => 'Address',
			'foreignKey' => 'contact_id',
			'dependent' => true,
			'conditions' => array('Address.contact_type' => 'company'),
			'fields' => '',
			'order' => ''
		)
	);
	
	function deleteAllByIds($ids){
		$this->Pupil->recursive = -1;
		$this->Pupil->updateFieldIdsByCondition(
			array(
				'Pupil.company_id' => $ids),
			'company',
			NULL);
			
		$this->deleteAll(array('Company.id' => $ids),TRUE);
	}
	
	function doesNotExist($data){
		$this->recursive = -1;
		$result = $this->find(
        	'count', 
        	array(
        		'conditions' => 
        			array(
						"Company.id !=" => ($this->id == NULL)?'0':$this->id,
        				'Company.name' => $data['name']
					)
					
				)
			);
		return ($result == 0);
	}

}
?>