<?= $form->create('Dialog',array('action' => 'set','onsubmit' => 'return false;')); ?>
	<div class="form-body">
		<div class="form-header clearfix">
			<h3><?= $this->data['Pupil']['firstname']." ".$this->data['Pupil']['lastname'] ?></h3>
		</div>
		<fieldset class="">
			<legend>Zimmer</legend>
			<?= $form->input('Pupil.id', 
				array(
					'type' => 'hidden'
				)) ?>
			<?= $form->input(
					'Pupil.room', 
					array(
						'label' => 'Zimmer',
						'div' => array(
							'class' => 'form-col',
						)
		)); ?>
		</fieldset>
	</div>
	<div class="clearfix"></div>
	<div class="form-buttons">
		<input 
			type="submit" 
			name="checkin" 
			class="icon_save_s" 
			value="Speichern" 
			onclick="doAction('/pupils_ajax/roomdialog');"/>
	</div>
<?= $form->end(); ?>