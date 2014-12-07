<?php

App::import('Component', 'Session');

function filterZeros(&$element){
	$b = ($element != 0);
	if($element < 10){
		$element = "0".$element;
	}
	return $b;
};

class SchoolClass extends AppModel {
	var $name = 'SchoolClass';
	var $displayField = 'abbreviation';
	var $Session;
	var $validate = array(
		'start_semester' => array(
			array(
				'rule' =>'limitDuplicateSemesterStart',
				'message' => 'Ausbildungsklasse mit dem Anfangssemester existiert bereits.'),
			'notempty'
		)
	);
	
	var $belongsTo = array(
		'SchoolClassType' => array(
			'className' => 'SchoolClassType',
			'fields' => array('name','abbreviation','duration','permanent'),
			'order' => 'abbreviation'
		),
		'SchoolSemester' => array(
			'className' => 'SchoolSemester',
			'foreignKey' => 'start_semester',
			'conditions' => '',
			'fields' => array('YEAR(start_date) as agegroup', 'start_date'),
			'order' => 'start_date DESC'
		)
	);
	
	var $hasMany = array(
		'Pupil' => array(
			'className' => 'Pupil',
			'foreignKey' => 'school_class_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => array('id','firstname'),
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	var $semesterCache = array();
	
	function findBySchoolClassTypeAndYear($sct_id,$year){
		return $this->find('first',
			array(
				'fields' => 'SchoolClass.id',
				'condition' => array(
					'SchoolClass.school_class_type_id' => $sct_id,
					'YEAR(SchoolSemester.start_date)'  => $year 
				),
				'recursive' => 1
			)
		);
	}
	
	function findAllForSelectBySchoolClassType($sct_id){
		$school_classes = $this->find('all',array(
			'fields' => array('SchoolClass.id','CONCAT(SchoolClassType.abbreviation," ",SUBSTRING(YEAR(SchoolSemester.start_date),3)) as name'),
			'order' => 'name ASC',
			'conditions' => array('SchoolClass.school_class_type_id' => $sct_id),
			'recursive' => 1));
		$school_class_list = array();
		foreach ($school_classes as $num => $sc) {
			$school_class_list[$sc['SchoolClass']['id']] = $sc[0]['name'];
		}
		return $school_class_list;
	}
	
	private function getSemesterCondition($semester){
		return array(
					'SchoolSemester.start_date <=' => $semester['SchoolSemester']['start_date'],
					"(YEAR(\"".$semester['SchoolSemester']['start_date']."\") - YEAR(SchoolSemester.start_date) + YEAR(\"".$semester['SchoolSemester']['stop_date']."\") - YEAR(SchoolSemester.stop_date)) <=  SchoolClassType.duration"
			);
	}
	
	function findAllBySemester($semester){
		return $this->find('all',
				array(
					'conditions' => $this->getSemesterCondition($semester),
					'recursive' => 1
				)
			);
	}
	
	function invalidateSemesterCache($semesterID){
		$this->Session->destroy('SchoolClasses.'.$semesterID);
	}
	
	function findAllIdsBySemester($semester){
		return $this->findAllIdsByCondition(
				$this->getSemesterCondition($semester)
			);
	}
	
	function findAllIdsByCalendarWeek($cw){
		if($cw == 0){
			$cw = date("W");
		}
		if($cw < 10){
			$cw = "0".$cw;
		}
		return $this->findAllIdsByCondition(
				array("POSITION('$cw' IN SchoolClass.allocation) > 0"));
	}
	
	private function findAllIdsByCondition($condition){
		$schoolClasses = $this->find('all',
			array(
				'fields' => 'id',
				'conditions' => $condition,
				'recursive' => 0
			)
		);
		
		// map the ids to an array
		function extractId($sc)
		{
		    return($sc['SchoolClass']['id']);
		}
		return array_map("extractId", $schoolClasses);
	}
	
	function deleteAllByCondition($condition){
		$ids = $this->findAllIdsByCondition($condition);
		$this->deleteAllByIds($ids);
	}
	
	function deleteAllByIds($ids){
		$this->Pupil->recursive = -1;
		$this->Pupil->updateFieldIdsByCondition(
			array(
				'Pupil.school_class_id' => $ids),
			'school_class',
			NULL);
			
		$this->deleteAll(array('SchoolClass.id' => $ids));
	}
	
	function saveWithAllocations($schoolClass,$sc_id){
		$schoolClass['allocation'] = $this->serializeAllocations($schoolClass['allocation']);
		$sc_data = array('allocation' => $schoolClass['allocation']);
		
		$this->id = $sc_id;
		parent::save($sc_data);
	}
	
	function limitDuplicateSemesterStart($data){
		$existing_abbreviation_count = $this->find(
        	'count', 
        	array(
        		'conditions' => 
        			array(
        				"id !=" => ($this->id == NULL)?'0':$this->id, 
						'school_class_type_id' => @$this->data['SchoolClass']['school_class_type_id'],
	        			'start_semester' => $data['start_semester'])
	        		,
	        	'recursive' => -1) );
		return $existing_abbreviation_count < 1;
    }
	
	function serializeAllocations($allocation){
		
		return implode(",",array_filter($allocation,"filterZeros"));
	}

}
?>