<?php 
/* SVN FILE: $Id$ */
/* Company Fixture generated on: 2009-05-02 10:05:08 : 1241254568*/

class CompanyFixture extends CakeTestFixture {
	var $name = 'Company';
	var $table = 'companies';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'modified'  => '2009-05-02 10:56:08',
		'created'  => '2009-05-02 10:56:08'
	));
}
?>