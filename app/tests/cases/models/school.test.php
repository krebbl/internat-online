<?php 
/* SVN FILE: $Id$ */
/* School Test cases generated on: 2009-05-01 15:05:18 : 1241183298*/
App::import('Model', 'School');

class SchoolTestCase extends CakeTestCase {
	var $School = null;
	var $fixtures = array('app.school', 'app.address', 'app.pupil');

	function startTest() {
		$this->School =& ClassRegistry::init('School');
	}

	function testSchoolInstance() {
		$this->assertTrue(is_a($this->School, 'School'));
	}

	function testSchoolFind() {
		$this->School->recursive = -1;
		$results = $this->School->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('School' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'modified'  => '2009-05-01 15:08:18',
			'created'  => '2009-05-01 15:08:18'
		));
		$this->assertEqual($results, $expected);
	}
}
?>