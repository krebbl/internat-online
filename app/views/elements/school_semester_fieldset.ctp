<fieldset>
	<legend><?= $label ?></legend>
	<div class="clearfix">
		<?= $form->input($path.'.start_date',
				array(
					'label' => 'Start',
					'type' => 'date',
					'dateFormat' => 'DMY',
					'minYear' => date('Y') - 5,
					'maxYear' => date('Y') + 5 ,
					'class' => 'datefield',
					'separator' => '.',
					'div' => 'form-col',						
					'after' => $this->element('field_error',array('message' => @$errors[$path]['start_date']))
				)); ?>
		<?= $form->input($path.'.stop_date',
				array(
					'label' => 'Stop',
					'type' => 'date',
					'dateFormat' => 'DMY',
					'minYear' => date('Y') - 5,
					'maxYear' => date('Y') + 5,
					'class' => 'datefield',
					'separator' => '.',
					'div' => 'form-col',
					'after' => $this->element('field_error',array('message' => @$errors[$path]['stop_date']))
				)); ?>
		<div class="form-col">
			<br/>
			<span style="font-size: 11px;">(Bitte inklusive letzter Ferien bis zum Ende angeben)</span>
		</div>
	</div>
</fieldset>