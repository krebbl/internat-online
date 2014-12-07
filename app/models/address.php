<?php

class Address extends AppModel {
    var $name = 'Address';
	var $validate = array(
		'street' => array('notempty'),
		'city' => array('notempty'),
		'home_nr' => array('notempty'),
		'zipcode' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Darf nicht leer sein',
				'last' => true
				),
			'postal' => array(
				'rule' => array('postal','/[0-9]{5}$/','DE'),
				'message' => 'Keine gültige PLZ'
			)
		)
	);
    // NO belongsTo because of ContactType!
	
	function create($data,&$contact){
		$data['contact_type'] = get_class($contact);
		$data['contact_id'] = $contact->getID();
		parent::create($data);
	}
}

?>