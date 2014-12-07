<?php 
/* SVN FILE: $Id$ */
/* State Test cases generated on: 2009-05-01 15:05:13 : 1241183953*/
App::import('Model', 'State');

class StateTestCase extends CakeTestCase {
	var $State = null;
	var $fixtures = array('app.state', 'app.county');

	function startTest() {
		$this->State =& ClassRegistry::init('State');
	}

	function testStateInstance() {
		$this->assertTrue(is_a($this->State, 'State'));
	}

	function testStateFind() {
		$this->State->recursive = -1;
		$results = $this->State->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('State' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'updated_at'  => '2009-05-01 15:19:13',
			'created_at'  => '2009-05-01 15:19:13'
		));
		$this->assertEqual($results, $expected);
	}
}
?>