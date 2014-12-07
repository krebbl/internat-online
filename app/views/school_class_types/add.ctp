<?= $form->create('SchoolClassType',array('action' => 'add')); ?>
<div class="form-body">
	<fieldset>
		<legend>Details</legend>
		<div class="clearfix">
			<?= $form->input('id', array('type'=>'hidden')); ?> 
			<?= $form->input('abbreviation',
					array(
						'label' => 'Abkürzung',
						'div' => 'form-col'
					)); ?>
			<?= $form->input(
						'name', 
						array(
							'div' => array(
								'class' => 'form-col',
								'style' => 'width: 60%'
							)
				)); ?>
		</div>
		<div class="clearfix">
			<?= $form->input('duration', array('label' => 'Ausbildungsdauer in Semestern', 'div' => 'form-col')); ?>
		</div>
	</fieldset>
</div>
<?= $this->element('edit_form_end') ?>