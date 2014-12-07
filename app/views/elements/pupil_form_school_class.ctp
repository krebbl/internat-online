<?= $form->input('SchoolClass.school_class_type_id',
		array(
			'id' => 'SchoolClassSelection',
			'label' => 'Ausbildungsrichtung',
			'type' => 'select',
			'selected' => @$schoolClassTypeId,
			'onChange' => 'loadSchoolClasses(this);',
			'div' => array(
				
				'class' => 'form-col'
				
			),
			'empty' => array('0' => 'Keine'))); ?>
<div class="form-col" id="SchoolClassDiv">
<?= $form->input('Pupil.school_class_id', 
		array(
			'label' => 'Ausbildungsklasse',
			'type' => 'select', 
			'options' => $schoolClasses,
			'empty' => array('0' => 'Keine'))); ?>
</div>
<div class="form-col">
<?= $form->input('Pupil.subclass', 
		array(
			'label' => 'Unterklasse',
			)); ?>
</div>