<?= $form->create('Dialog',array('action' => 'set','onsubmit' => 'return false;')); ?>
	<div class="form-body">
		<div class="form-header clearfix">
			<h3><?= $this->data['Pupil']['firstname']." ".$this->data['Pupil']['lastname'] ?></h3>
		</div>
		<fieldset class="">
			<legend>Abmeldung</legend>
			<?= $form->input('Pupil.id', 
				array(
					'type' => 'hidden'
				)) ?>
			<?= $form->input('Pupil.banished', 
				array(
					'before' => '<br/>',
					'label' => 'Ausgewiesen',
					'div' => array(
						'class' => 'form-col checkbox',
						'style' => 'width: 100%'
					)
				)) ?>
			<?= $form->input('Pupil.checked_out', 
				array(
					'label' => 'Abgemldet am',
					'dateFormat' => 'DMY',
					'class' => 'datefield',
					'separator' => '.',
					'div' => array(
						'class' => 'form-col',
						'style' => 'width: 100%'
					)
				)) ?>
		</fieldset>
	</div>
	<div class="clearfix"></div>
	<div class="form-buttons">
		<input 
			type="submit" 
			name="checkin" 
			class="icon_save_s" 
			value="Speichern" 
			onclick="doAction('/pupils_ajax/checkoutdialog');"/>
	</div>
<?= $form->end(); ?>