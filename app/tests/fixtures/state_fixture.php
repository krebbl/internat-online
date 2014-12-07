<?php 
/* SVN FILE: $Id$ */
/* State Fixture generated on: 2009-05-01 15:05:13 : 1241183953*/

class StateFixture extends CakeTestFixture {
	var $name = 'State';
	var $table = 'states';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'updated_at' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_at' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'updated_at'  => '2009-05-01 15:19:13',
		'created_at'  => '2009-05-01 15:19:13'
	));
}
?>