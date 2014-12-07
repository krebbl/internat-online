<?php
class County extends AppModel {

	var $name = 'County';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'State' => array(
			'className' => 'State',
			'conditions' => '',
			'fields' => array('name'),
			'order' => ''
		)
	);

	var $hasMany = array(
		'Pupil' => array(
			'className' => 'Pupil',
			'foreignKey' => 'county_id',
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

}
?>