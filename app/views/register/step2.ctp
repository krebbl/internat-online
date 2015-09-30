<fieldset>
	<legend>Gesetzliche Vertreter</legend>
	<?= $this->element('pupil_parent_form2',array(
			'num' => 0,
			'pupilParent' => $this->data['PupilParent'][0],
			'addressErrors' => @$errors['PupilParentAddress0'],
			'removable' => false, 
			'errors' => @$errors['PupilParent0']))?>
</fieldset>
<div class="clearfix form-row">
    <?=
    $form->input(
        "splitted_custody",
        array(
            'label' => 'Gemeinsames Sorgerecht bei getrenntlebenden Erziehungsberechtigten',
            'before' => '<br/>',
            'separator' => '<br/>',
            'legend' => 'Sorgerecht',
            'type' => 'radio',
            'options' => array(
                '0' => 'Gemeinsames Sorgerecht bei <strong>zusammenlebenden</strong> Sorgeberechtigten',
                '1' => 'Gemeinsames Sorgerecht bei <strong>getrenntlebenden</strong> Sorgeberechtigten',
                '2' => 'Alleiniges Sorgerecht des angegebenen Sorgeberechtigten'
            ),
            'onChange' => 'toggleForm(this)',
            'div' => array(
                'class' => ''
            )
        )); ?>
</div>
<fieldset>
	<legend>Weiterer Vertreter</legend>
	<?= $this->element('pupil_parent_form2',array(
			'num' => 1,
			'pupilParent' => $this->data['PupilParent'][1],
			'addressErrors' => @$errors['PupilParentAddress1'],
			'removable' => true, 
			'errors' => @$errors['PupilParent1']))?>
	
</fieldset>
