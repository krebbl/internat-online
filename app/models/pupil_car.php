<?php
class PupilCar extends AppModel {

	var $name = 'PupilCar';
	var $validate = array(
		'name' => array('notempty'),
		'color' => array('notempty'),
		'sign' => array('notempty')
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