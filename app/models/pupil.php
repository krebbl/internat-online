<?php
App::import('Component', 'Session');

class Pupil extends AppModel
{
    const GENDER_BOTH = 2;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 0;

    var $name = 'Pupil';
    var $uses = array('Pupil', 'SchoolClass');

    var $validate = array(
        'firstname' => array('notempty'),
        'lastname' => array('notempty'),
        'birthplace' => array('notempty')
    );

    var $belongsTo = array(
        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id',
            'fields' => array('School.abbreviation', 'School.id', 'School.name')
        ),
        'Company' => array(
            'className' => 'Company',
            'foreignKey' => 'company_id',
            'fields' => array('Company.name', 'Company.id')
        ),
        'SchoolClass' => array(
            'className' => 'SchoolClass',
            'foreignKey' => 'school_class_id',
            'fields' => array('start_semester', 'school_class_type_id')
        ),
        'Nationality' => array(
            'className' => 'Nationality',
            'fields' => array('name')
        ),
        'County' => array(
            'className' => 'County',
            'fields' => array('name', 'state_id')
        )
    );

    var $hasOne = array(
        'Address' => array(
            'conditions' => array('Address.contact_type' => 'pupil'),
            'foreignKey' => 'contact_id',
            'dependent' => true
        ),
        'Deposit' => array(
            'dependent' => true
        ),
        'PupilCar' => array(
            'dependent' => true
        )
    );

    var $hasMany = array(
        'PupilParent' => array(
            'className' => 'PupilParent',
            'foreignKey' => 'pupil_id',
            'dependent' => true,
            'limit' => '2',
        ),
        'PupilBill' => array(
            'className' => 'PupilBill',
            'foreignKey' => 'pupil_id',
            'dependent' => true
        ),
        'PupilComment' => array(
            'className' => 'PupilComment',
            'foreignKey' => 'pupil_id',
            'dependent' => true,
            'order' => array('created DESC')
        )
    );

    function findByPassword($pw)
    {
        return $this->find(
            'first',
            array('conditions' => "passwd = '" . $pw . "'")
        );
    }

    function findAllNewPupils($limit)
    {
        $this->recursive = 0;
        $this->unbindModel(
            array(
                'hasMany' => array('PupilParent'),
                'hasOne' => array('Address')));
        $this->bindModel(
            array(
                'belongsTo' =>
                    array(
                        'SchoolClassType' => array(
                            'foreignKey' => false,
                            'conditions' => array('SchoolClassType.id = SchoolClass.school_class_type_id')
                        ),
                        'SchoolSemester' => array(
                            'foreignKey' => false,
                            'conditions' => array('SchoolSemester.id = SchoolClass.start_semester')
                        )))
        );
        return $this->find('all', array(
                'fields' => array(
                    'Pupil.*',
                    'SchoolClassType.abbreviation, SchoolClassType.id, SchoolClassType.duration',
                    'SUBSTRING(YEAR(SchoolSemester.start_date),3) as start',
                    '(DATE_ADD(Pupil.birthdate, INTERVAL 18 YEAR) < NOW()) as is_adult'
                ),
                'order' => array(
                    'created DESC'
                ),
                'limit' => $limit
            )
        );

    }

    function findAllBySchoolSemesterID($schoolSemesterID, $checked_out = false)
    {
        $this->recursive = 1;
        $this->PupilComment->recursive = 1;
        $this->unbindModel(
            array(
                'hasMany' => array('PupilParent'),
                'hasOne' => array('Address')));

        $this->bindModel(
            array(
                'belongsTo' =>
                    array(
                        'SchoolClassType' => array(
                            'foreignKey' => false,
                            'conditions' => array('SchoolClassType.id = SchoolClass.school_class_type_id')
                        )))
        );
        return $this->find('all', array(
                'fields' => array(
                    'Pupil.*',
                    'Deposit.*',
                    'PupilCar.*',
                    'Company.id, Company.name',
                    'School.abbreviation, School.id, School.name',
                    'SchoolClassType.abbreviation, SchoolClassType.id, SchoolClassType.duration',
                    'UNIX_TIMESTAMP(SchoolSemester.start_date) as start',
                    '(DATE_ADD(Pupil.birthdate, INTERVAL 18 YEAR) < NOW()) as is_adult'
                ),
                'conditions' => array(
                    'and' => array(
                        'or' => array(
                            array('Pupil.school_class_id' => NULL),
                            array('Pupil.school_class_id' => 0),
                            array('Pupil.permanent' => 1)
                        ),
                        ($checked_out) ? 'Pupil.checked_out IS NOT NULL' : 'Pupil.checked_out IS NULL OR Pupil.checked_out = ´0000-00-00´'
                    )
                ),
                'order' => array(
                    'lastname ASC',
                    'firstname ASC'
                )
            )
        );
    }

    function findAllBySemester($semester, $checked_out = false)
    {
        $scIDs = $this->SchoolClass->findAllIdsBySemester($semester);
        // $this->Session = new SessionComponent();
        // $key = "Pupils.Semester".$semester['SchoolSemester']['id'];
        // $results = $this->Session->read($key);
        //if(!isset($results)){
        $results = $this->findAllBySchoolClassIDs($scIDs, $checked_out);
        //	$this->Session->write($key,$results);
        //}
        return $results;
    }

    function findAllByIDs($IDs)
    {
        $this->recursive = 1;
        $this->PupilComment->recursive = 1;
        $this->PupilBill->recursive = 1;
        $this->unbindModel(
            array(
                'hasMany' => array('PupilParent')));

        $this->bindModel(
            array(
                'belongsTo' =>
                    array(
                        'SchoolSemester' => array(
                            'foreignKey' => false,
                            'conditions' => array('SchoolSemester.id = SchoolClass.start_semester')
                        ),
                        'SchoolClassType' => array(
                            'foreignKey' => false,
                            'conditions' => array('SchoolClassType.id = SchoolClass.school_class_type_id')
                        )))
        );

        return $this->find('all', array(
                'fields' => array(
                    'Pupil.id, Pupil.lastname, Pupil.firstname, Pupil.male, Pupil.birthdate, Pupil.room, (DATE_ADD(Pupil.birthdate, INTERVAL 18 YEAR) < NOW()) as is_adult',
                    'Pupil.min_to_arrive, Pupil.min_to_depart, Pupil.food_on_account, Pupil.rent_on_account',
                    'Deposit.nr, Deposit.block, Deposit.paid_in, Deposit.paid_out',
                    'Address.id, Address.zipcode, Address.city',
                    'Company.id, Company.name',
                    'School.id, School.name',
                    'SchoolClass.id',
                    'SchoolClassType.abbreviation, SchoolClassType.id',
                    'YEAR(SchoolSemester.start_date) as start'
                ),
                'contain' => array('PupilBill'),
                'conditions' => array(
                    array('Pupil.id' => $IDs)
                ),
                'order' => array(
                    'lastname ASC',
                    'firstname ASC'
                )
            )
        );
    }

    function findAllBySchoolClassIDs($schoolClassIds, $checked_out = false)
    {
        $this->recursive = 1;
        $this->PupilComment->recursive = 1;
        $this->unbindModel(
            array(
                'hasMany' => array('PupilParent'),
                'hasOne' => array('Address')));

        $this->bindModel(
            array(
                'belongsTo' =>
                    array(
                        'SchoolSemester' => array(
                            'foreignKey' => false,
                            'conditions' => array('SchoolSemester.id = SchoolClass.start_semester')
                        ),
                        'SchoolClassType' => array(
                            'foreignKey' => false,
                            'conditions' => array('SchoolClassType.id = SchoolClass.school_class_type_id')
                        )))
        );

        return $this->find('all', array(
                'fields' => array(
                    'Pupil.*',
                    'Deposit.*',
                    'PupilCar.*',
                    'Company.id, Company.name',
                    'School.abbreviation, School.id, School.name',
                    'SchoolClassType.abbreviation, SchoolClassType.id, SchoolClassType.duration',
                    'UNIX_TIMESTAMP(SchoolSemester.start_date) as start',
                    '(DATE_ADD(Pupil.birthdate, INTERVAL 18 YEAR) < NOW()) as is_adult'
                ),
                'conditions' => array(
                    'or' => array(
                        array('Pupil.school_class_id' => $schoolClassIds),
                        'and' => array(
                            array('Pupil.permanent' => 1),
                            'or' => array(
                                array('Pupil.school_class_id' => NULL),
                                array('Pupil.school_class_id' => 0)
                            )
                        )
                    ),
                    ($checked_out) ? 'Pupil.checked_out IS NOT NULL' : 'Pupil.checked_out IS NULL OR Pupil.checked_out = `0000-00-00`'
                ),
                'order' => array(
                    'lastname ASC',
                    'firstname ASC'
                )
            )
        );
    }

    function findAllByFieldAndId($field, $id)
    {
        return $this->find(
            'all',
            array(
                'conditions' => array($field . '_id' => $id),
                'fields' => array('firstname', 'lastname'),
                'order' => array('lastname', 'firstname'),
                'recursive' => 0
            )
        );
    }

    function updateFieldIdsByPupilIds($pupil_ids, $field, $id)
    {
        return $this->updateFieldIdsByCondition(array('Pupil.id' => $pupil_ids), $field, $id);
    }

    function updateFieldIdsByCondition($condition, $field, $id)
    {
        return $this->updateAll(array($field . '_id' => $id), $condition);
    }

    function deleteAllByIds($ids)
    {
        $this->deleteAll(array('Pupil.id' => $ids), TRUE);
    }
}

?>