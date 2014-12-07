<?php 
/* SVN FILE: $Id$ */
/* County Fixture generated on: 2009-05-01 15:05:04 : 1241184004*/

class CountyFixture extends CakeTestFixture {
	var $name = 'County';
	var $table = 'counties';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'state_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated_at' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_at' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'state_id'  => 1,
		'updated_at'  => '2009-05-01 15:20:04',
		'created_at'  => '2009-05-01 15:20:04'
	));
}
?>