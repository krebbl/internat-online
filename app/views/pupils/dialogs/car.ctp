<?= $form->create('Dialog',array('action' => 'set','onsubmit' => 'return false;')); ?>	
	<div class="form-body">
		<div class="form-header clearfix">
			<h3><?= $this->data['Pupil']['firstname']." ".$this->data['Pupil']['lastname'] ?></h3>
		</div>
		<fieldset class="">
			<legend>Auto</legend>
			<div class="form-row clearfix">
				<?= $form->input('Pupil.id', 
						array(
							'type' => 'hidden'
						)) ?>
				<?= $form->input('PupilCar.id', 
						array(
							'type' => 'hidden'
						)) ?>
				<?= $form->input(
						'PupilCar.name', 
						array(
							'label' => 'Typ',
							'div' => array(
								'class' => 'form-col',
							)
			)); ?>
				<?= $form->input(
						'PupilCar.color', 
						array(
							'label' => 'Farbe',
							'div' => array(
								'class' => 'form-col',
							)
			)); ?>
				<?= $form->input(
					'PupilCar.sign', 
					array(
						'label' => 'Kennzeichen',
						'div' => array(
							'class' => 'form-col',
						)
		)); ?>
			</div>
		</fieldset>
	</div>
	<div class="clearfix"></div>
	<div class="form-buttons">
		<input 
				type="submit" 
				name="checkin" 
				class="icon_save_s" 
				value="Speichern" 
				onclick="doAction('/pupils_ajax/cardialog');"/>
	</div>
<?= $form->end(); ?>
