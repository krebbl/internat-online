<?= $form->create('Dialog',array('action' => 'set','onsubmit' => 'return false;')); ?>
	<div class="form-body">
		<div class="form-header clearfix">
			<h3><?= $this->data['Pupil']['firstname']." ".$this->data['Pupil']['lastname'] ?></h3>
		</div>
		<fieldset id="kaution" class="">
			<legend>Kaution</legend>
			<div class="clearfix form-row">
				<?= $form->input('Deposit.id', 
						array(
							'type' => 'hidden'
						)) ?>
				<?= $form->input('Pupil.id', 
						array(
							'type' => 'hidden'
						)) ?>
				<?= $form->input(
							'Deposit.block', 
							array(
								'label' => 'Block',
								'div' => array(
									'class' => 'form-col',
									'style' => 'width: 20%'
								)
				)); ?>
				<?= $form->input(
							'Deposit.nr', 
							array(
								'label' => 'Nummer',
								'div' => array(
									'class' => 'form-col',
									'style' => 'width: 20%'
								)
				)); ?>
				<?= $form->input(
							'Deposit.value', 
							array(
								'label' => 'Betrag',
								'div' => array(
									'class' => 'form-col',
									'style' => 'width: 20%'
								)
				)); ?>
			</div>
			<div class="clearfix form-row">
				<?= $form->input('Deposit.paid_in', 
						array(
							'label' => 'Eingezahlt am',
							'dateFormat' => 'DMY',
							'class' => 'datefield',
							'separator' => '.',
							'div' => array(
								'class' => 'form-col',
								'style' => 'width: 45%'
							)
						)) ?>
				<?php if(isset($this->data['Deposit']['id'])){ ?>
				<?= $form->input('Deposit.paid_out', 
						array(
							'label' => 'Ausgezahlt am',
							'dateFormat' => 'DMY',
							'class' => 'datefield',
							'maxYear' => date("Y"),
							'separator' => '.',
							'div' => array(
								'class' => 'form-col',
								'style' => 'width: 45%'
							)
						)) ?>
				<?php } ?>
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
			onclick="doAction('/pupils_ajax/depositdialog');"/>
	</div>
<?= $form->end(); ?>