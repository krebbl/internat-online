<?= $form->input('Pupil.company_id', 
		array(
			'label' => 'Firma',
			'options' => $companies,
			'type' => 'select', 
			'div' => array(
				'class' => 'form-col',
				'style' => 'width: 66%'
			),
			'onchange' => 'loadDetails(this,"Company")',
			'empty' => array(0 => 'keine'))); ?>