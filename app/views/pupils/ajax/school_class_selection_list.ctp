<?= $form->input('Pupil.school_class_id', 
	array(
		'options' => $schoolClasses,
		'label' => 'Ausbildungsklasse',
		'type' => 'select',
		'empty' => array('0' => 'Keine'))); ?>