<?php 
/* SVN FILE: $Id$ */
/* County Test cases generated on: 2009-05-01 15:05:04 : 1241184004*/
App::import('Model', 'County');

class CountyTestCase extends CakeTestCase {
	var $County = null;
	var $fixtures = array('app.county', 'app.state', 'app.pupil');

	function startTest() {
		$this->County =& ClassRegistry::init('County');
	}

	function testCountyInstance() {
		$this->assertTrue(is_a($this->County, 'County'));
	}

	function testCountyFind() {
		$this->County->recursive = -1;
		$results = $this->County->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('County' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'state_id'  => 1,
			'updated_at'  => '2009-05-01 15:20:04',
			'created_at'  => '2009-05-01 15:20:04'
		));
		$this->assertEqual($results, $expected);
	}
}
?>