<?php
class PupilcBill extends AppModel {

	var $name = 'PupilBill';
	var $validate = array();

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