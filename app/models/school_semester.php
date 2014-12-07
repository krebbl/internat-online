<?php

class SchoolSemester extends AppModel {
	var $name = 'SchoolSemester';
	var $validate = array(
		'start_date' => array('date'),
		'stop_date' => array(
			array(
				'rule' => array('date')
			),
			array(
				'rule' =>'isAfterStartDate',
				'message' => 'Das Semesterende muss vor Semesteranfang sein.'),
			array(
				'rule' =>'doesNotExist',
				'message' => 'Semester schon vorhanden.')
		)
	);
	var $actsAs = array('DateFormatter');
	var $_myFields = array(
			'id',
			"CASE WHEN YEAR(start_date) < YEAR(stop_date) THEN concat('Wintersemester ',YEAR(start_date),'/',YEAR(stop_date))
				ELSE concat('Sommersemester ',YEAR(start_date))
				END as title",
			'start_date','stop_date','UNIX_TIMESTAMP(start_date) as start');
	
	var $hasMany = array(
		'SchoolClass' => array(
			'className' => 'SchoolClass',
			'foreignKey' => 'start_semester',
			'dependent' => true,
			'conditions' => '',
			'fields' => 'SchoolClass.id',
			'order' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	function findAllForDateSelect(){
		$semesters = $this->findAll();
		$list = array();
		foreach($semesters as $semester){
			$list[] = array('value' => $semester['SchoolSemester']['id'], 'name' => __(strftime("%B",$semester[0]['timestamp']),TRUE)." - ".strftime("%Y",$semester[0]['timestamp']));
		}
		return $list;
	}
	
	function findSemesterByIdOrGetCurrent($id = 0){
		if($id){
			$this->recursive = 0;
			return $this->findSemesterById($id);
		}
		return $this->findCurrentSemester();
	}
	
	function findCurrentSemester(){
		$date = date("Y-m-d");
		$this->recursive = 0;
		return $this->find('first',array(
			'fields' => $this->_myFields,
			'conditions' => array("AND" => array(
				array("UNIX_TIMESTAMP(start_date) <= UNIX_TIMESTAMP(NOW())"),
				array("UNIX_TIMESTAMP(stop_date) >= UNIX_TIMESTAMP(NOW())")
					)
				)
			)
		);
	}
	
	function findCurrentWinterSemester(){
		$year = $this->getCurrentYear();
		$this->recursive = 0;
		return $this->find('first',array(
			'fields' => $this->_myFields,
			'conditions' => array("YEAR(stop_date) = $year AND YEAR(stop_date) > YEAR(start_date)")));
	}
	
	function findNextSemester($semester){
		$this->recursive = 0;
		return $this->find('first',array(
			'fields' => $this->_myFields,
			'conditions' => array(
				"YEAR(SchoolSemester.start_date) = YEAR('".$semester['SchoolSemester']['stop_date']."')",
				"YEAR(SchoolSemester.stop_date) > YEAR('".$semester['SchoolSemester']['start_date']."')")));
	}
	
	function findSemesterById($id){
		return $this->find(
				'first',
				array(
					'fields' => $this->_myFields,
					'conditions' => array("id = $id"),));
	}
	
	function findAll(){
		return $this->find('all',array(
			'order' => 'SchoolSemester.start_date DESC',
			'fields' => array(
				'SchoolSemester.*',
				"UNIX_TIMESTAMP(start_date) as timestamp",
				"CASE WHEN YEAR(start_date) < YEAR(stop_date) THEN concat('Wintersemester ',YEAR(start_date),'/',YEAR(stop_date))
					ELSE concat('Sommersemester ',YEAR(start_date))
						END as title")));
	}
	
	function findAllForSelect(){
		$semesters = $this->findAll();
		$list = array();
		foreach($semesters as $semester){
			$list[$semester['SchoolSemester']['id']] = $semester[0]['title'];
		}
		return $list;
	}
	
	function getCurrentCW(){
		return date("W",time());
	}
	
	function getCurrentYear(){
		return date("Y",time());;
	}
	
	function findAllSemesters(){
		return $this->find('all',
			array(
				'fields' => $this->_myFields,
				'order' => 'start_date DESC'
			)
		);
	}
	
	function isAfterStartDate($data){
		return (strtotime($this->data['SchoolSemester']['start_date']) < strtotime($data['stop_date']));
	}
	
	function doesNotExist($data){
		$result = $this->find(
        	'count', 
        	array(
        		'conditions' => 
        			array(
						"id !=" => ($this->id == NULL)?'0':$this->id,
        				array(
							'OR' => array(
								'TIMESTAMP(SchoolSemester.start_date) <= TIMESTAMP("'.$this->data['SchoolSemester']['start_date'].'") AND TIMESTAMP(SchoolSemester.stop_date) >= TIMESTAMP("'.$this->data['SchoolSemester']['start_date'].'")'
								,
								'TIMESTAMP(SchoolSemester.start_date) <= TIMESTAMP("'.$data['stop_date'].'") AND TIMESTAMP(SchoolSemester.stop_date) >= TIMESTAMP("'.$data['stop_date'].'")'
								)					
						)
					)
					
				)
			);
		return ($result == 0);
	}

}
?>