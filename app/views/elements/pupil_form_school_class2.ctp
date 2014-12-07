<?= $form->input('SchoolClass.school_class_type_id',
		array(
			'id' => 'SchoolClassSelection',
			'label' => 'Ausbildungsrichtung',
			'type' => 'select',
			'selected' => @$schoolClassTypeId,
			'div' => array(
				
				'class' => 'form-col'
				
			),
			'empty' => array('0' => 'Keine'))); ?>
<?php  
	  setlocale(LC_TIME, 'deu');
	  echo $form->input('SchoolClass.start_semester', 
		array(
				'label' => 'Start der Ausbildung',
				'type' => 'select',
				'dateFormat' => 'M-Y',
				'options' => $semesters,
				'div' => array(
					'class' => 'form-col'
				)
			)
		); ?>