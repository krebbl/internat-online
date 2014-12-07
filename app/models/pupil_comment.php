<?php
class PupilComment extends AppModel {

	var $name = 'PupilComment';
	var $validate = array(
		'text' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Pupil' => array(
			'className' => 'Pupil',
			'foreignKey' => 'pupil_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User'
		)
	);
	
	function findLatestComments($limit){
		$this->recursive = 1;
		return $this->find('all',array(
			'fields' => array(
				'PupilComment.*',
				'Pupil.id, Pupil.firstname, Pupil.lastname',
				'User.id, User.username'
			),
			'order' => array(
				'PupilComment.created DESC'
			),
			'limit' => $limit
			));
	}

}
?>