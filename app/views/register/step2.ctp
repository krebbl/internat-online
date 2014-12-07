<fieldset>
	<legend>Gesetzliche Vertreter</legend>
	<?= $this->element('pupil_parent_form2',array(
			'num' => 0,
			'pupilParent' => $this->data['PupilParent'][0],
			'addressErrors' => @$errors['PupilParentAddress0'],
			'removable' => false, 
			'errors' => @$errors['PupilParent0']))?>
	<div class="clearfix form-row">
			<?= $form->input(
							"splitted_custody", 
							array(
								'label' => 'Gemeinsames Sorgerecht bei getrenntlebenden Erziehungsberechtigten',
								'before' => '<br/>',
								'type' => 'checkbox',
								'onChange' => 'toggleForm(this)',
								'div' => array(
									'class' => 'form-col checkbox'
								)
					)); ?>
		</div>
</fieldset>
<fieldset>
	<legend>Weiterer Vertreter</legend>
	<?= $this->element('pupil_parent_form2',array(
			'num' => 1,
			'pupilParent' => $this->data['PupilParent'][1],
			'addressErrors' => @$errors['PupilParentAddress1'],
			'removable' => true, 
			'errors' => @$errors['PupilParent1']))?>
	
</fieldset>
