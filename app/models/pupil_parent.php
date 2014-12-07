<?php

class PupilParent extends AppModel {
    var $name = 'PupilParent';
    
    var $validate = array(
		'firstname' => array('notempty'),
		'lastname' => array('notempty')
	);
	
	var $hasOne = array(
		'address' => array(
			'className' => 'Address',
	        'conditions' => array('address.contact_type' => 'parent'),
	        'foreignKey' => 'contact_id',
            'dependent'    => true
	    )
	);
}

?>