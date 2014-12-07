<fieldset>
	<legend>Angaben zur Person</legend>
	<div class="clearfix form-row">
		<?= $form->input('Pupil.id', array('type'=>'hidden')); ?> 
		<?= $form->input('Pupil.firstname',
				array(
					'label' => 'Vorname',
					'div' => 'form-col'
				)); ?>
		<?= $form->input(
					'Pupil.lastname', 
					array(
						'label' => 'Nachname',
						'div' => array(
							'class' => 'form-col',
						)
			)); ?>
		<?= $form->input(
					'Pupil.male',
					array(
						'label' => 'Geschlecht',
						'div' => array(
							'class' => 'form-col',
						),
						'default' => 1,
						'options' => array(0 => 'Weiblich', 1 => 'Männlich')
					)
			)?>
	</div>
	<div class="clearfix form-row">
		<?= $form->input('Pupil.birthdate',
				array(
					'label' => 'Geburtsdatum',
					'dateFormat' => 'DMY',
					'minYear' => date('Y') - 30,
					'maxYear' => date('Y') - 15 ,
					'class' => 'datefield',
					'separator' => '.',
					'div' => 'form-col'
				)
			); ?>
		<?= $form->input(
					'Pupil.birthplace', 
					array(
						'label' => 'Geburtsort',
						'div' => array(
							'class' => 'form-col',
						)
			)); ?>
		<?= $form->input(
					'Pupil.email', 
					array(
						'label' => 'Email*',
						'div' => array(
							'class' => 'form-col',
						)
			)); ?>
	</div>
</fieldset>
<fieldset>
	<legend>Kontaktdetails</legend>
	
	<div class="clearfix">
		<?= $this->element('address_form',array(
			'address_is_set' => true,
			'removable' => false,
			'address_path' => "Address",
			'address' => $this->data['Address'],
			'errors' => @$errors['Address']
		)) ?>
	</div>
	<div class="clearfix">
		<?= $form->input(
					'Pupil.nationality_id', 
					array(
						'label' => 'Nationalität',
						'div' => array(
							'class' => 'form-col',
						)
			)); ?>
		<?= $form->input(
					'Pupil.county_id', 
					array(
						'label' => 'Landkreis',
						'div' => array(
							'class' => 'form-col',
						)
			)); ?>
	</div>
</fieldset>
