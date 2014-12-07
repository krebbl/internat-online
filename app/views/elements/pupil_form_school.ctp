<?= $form->input('Pupil.school_id', 
		array(
			'label' => 'Schule',
			'options' => $schools,
			'type' => 'select', 
			'div' => array(
				'class' => 'form-col',
				'style' => 'width: 66%'
			),
			'onchange' => 'loadDetails(this,"School")',
			'empty' => array(0 => 'keine'))); ?>