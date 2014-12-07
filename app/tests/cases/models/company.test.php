<?php 
/* SVN FILE: $Id$ */
/* Company Test cases generated on: 2009-05-02 10:05:08 : 1241254568*/
App::import('Model', 'Company');

class CompanyTestCase extends CakeTestCase {
	var $Company = null;
	var $fixtures = array('app.company', 'app.pupil');

	function startTest() {
		$this->Company =& ClassRegistry::init('Company');
	}

	function testCompanyInstance() {
		$this->assertTrue(is_a($this->Company, 'Company'));
	}

	function testCompanyFind() {
		$this->Company->recursive = -1;
		$results = $this->Company->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Company' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'modified'  => '2009-05-02 10:56:08',
			'created'  => '2009-05-02 10:56:08'
		));
		$this->assertEqual($results, $expected);
	}
}
?>