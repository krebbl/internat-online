<?php 
/* SVN FILE: $Id$ */
/* School Fixture generated on: 2009-05-01 15:05:18 : 1241183298*/

class SchoolFixture extends CakeTestFixture {
	var $name = 'School';
	var $table = 'schools';
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
		'modified'  => '2009-05-01 15:08:18',
		'created'  => '2009-05-01 15:08:18'
	));
}
?>