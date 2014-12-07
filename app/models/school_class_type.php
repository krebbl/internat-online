<?php
class SchoolClassType extends AppModel {
	var $name = 'SchoolClassType';
	var $displayField = 'name';
	
	var $validate = array(
		'abbreviation' => array(
			array(
				'rule' =>'limitDuplicateAbbreviation',
				'message' => 'Abkürzung existiert bereits.'),
			'notempty',
		),
		'name' => array('notempty'),
		'duration' => array('numeric'),
		'permanent' => array('boolean')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'SchoolClass' => array(
			'className' => 'SchoolClass',
			'foreignKey' => 'school_class_type_id',
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
	
	function findAllForSelect(){
		$school_classes_types = $this->find('all',array(
			'fields' => array('SchoolClassType.id, SchoolClassType.name, SchoolClassType.abbreviation'),
			'order' => 'abbreviation ASC',
			'recursive' => 0));
		$sct_list = array();
		foreach ($school_classes_types as $num => $sct) {
			if($sct['SchoolClassType']['name'] == ''){
				$sct['SchoolClassType']['name'] = $sct['SchoolClassType']['abbreviation'];
			}else{
				$sct['SchoolClassType']['name'] .= " (".$sct['SchoolClassType']['abbreviation'].")";
			}
			$sct_list[$sct['SchoolClassType']['id']] = $sct['SchoolClassType']['name'];
		}
		return $sct_list;
	}
	
	function limitDuplicateAbbreviation($data){
        $existing_abbreviation_count = $this->find(
        	'count', 
        	array(
        		'conditions' => 
        			array(
        				"id !=" => ($this->id == NULL)?'0':$this->id, 
	        			'abbreviation' => $data['abbreviation'])
	        		,
	        	'recursive' => -1) );
        return $existing_abbreviation_count < 1;
    }

}
?>