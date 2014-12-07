<?php
class Deposit extends AppModel {

	var $name = 'Deposit';
	var $validate = array(
		'paid_in' => array('date'),
		'paid_out' => array(
			'date' => array(
				'allowEmpty' => true,
				'required' => false,
				'rule' => 'date'
			)
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Pupil' => array(
			'className' => 'Pupil',
			'foreignKey' => 'pupil_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>