<?php

class AddressesController extends AppController {
	var $uses = array('Address');
    var $name = 'Addresses';
  	
	function beforeFilter(){
		$this->Auth->allow('details');
	}
	
    function details($id = 0,$type = NULL){
		$this->History->saveHistory = false; 
		
		Configure::write('debug',0);  
    	
		if($id > 0){
			$this->Address->recursive = 0;
			$address = $this->Address->findByContactIdAndContactType($id,$type);
	    	$this->set('address',$address['Address']);
	    	
			// TODO: Find a better way to do this
			if($type == 'School'){
				$controller = 'schools';
			}
			if($type == 'company'){
				$controller = 'companies';
			}
			$this->set('controller',$controller);
			$this->set('id',$id);	    	
		}
		$this->render('/elements/address_details', FALSE);
    	
	  }
}
?>