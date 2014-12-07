<?= $form->create('SchoolSemester',array('action' => 'edit')); ?>
<div class="form-body">
	<fieldset>
		<legend>Zeitraum</legend>
		<div class="clearfix">
			<?= $form->input('SchoolSemester.id', array('type'=>'hidden')); ?> 	
			<?= $form->input('SchoolSemester.start_date',
					array(
						'label' => 'Start',
						'type' => 'date',
						'dateFormat' => 'DMY',
						'minYear' => date('Y') - 5,
						'maxYear' => date('Y') + 5 ,
						'class' => 'datefield',
						'separator' => '.',
						'div' => 'form-col'
					)); ?>
			<?= $form->input('SchoolSemester.stop_date',
					array(
						'label' => 'Stop',
						'type' => 'date',
						'dateFormat' => 'DMY',
						'minYear' => date('Y') - 5,
						'maxYear' => date('Y') + 5,
						'class' => 'datefield',
						'separator' => '.',
						'div' => 'form-col'
					)); ?>
		</div>
	</fieldset>
</div>
<?= $this->element('edit_form_end') ?>