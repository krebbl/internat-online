<?= $form->create('SchoolClass',array('action' => 'edit')); ?>
<div class="form-body">
	<fieldset>
		<legend>Details</legend>
		<div class="clearfix">
			<?= $form->input('SchoolClass.id', array('type'=>'hidden')); ?> 
			<?= $form->input('SchoolClass.school_class_type_id',
					array(
						'type' => 'select',
						'options' => $schoolClassTypes,
						'label' => 'Ausbildungsrichtung',
						'disabled' => isset($schoolClassType),
						'div' => 'form-col'
					)); ?>
			<?= $form->input('SchoolClass.start_semester', array(
					'label' => 'Ausbildungsbeginn',
					'options' => $semesters,
					'div' => 'form-col')); ?>				
		</div>
	</fieldset>
	<fieldset>
		<legend>Belegung (1. H&auml;lfte)</legend>
		<table border="0" cellspacing="5" cellpadding="5" class="allocations">
			<?= $this->element('school_class_allocation_head',
						array(	'start_cw'		=> 1,
								'stop_cw'		=> 26
						)
					) 
				?>
			<tbody>
			<?= $this->element(
					'school_class_allocation_row',
					array(	'schoolClass' => $this->data, 
							'start_cw'		=> 1,
							'stop_cw'		=> 26,
							'allocations'	=> explode(",",@$this->data['SchoolClass']['allocation'])
					)
				) 
			?>
		</tbody>
		</table>
	</fieldset>
	<fieldset>
		<legend>Belegung (2. H&auml;lfte)</legend>
		<table border="0" cellspacing="5" cellpadding="5" class="allocations">
			<?= $this->element('school_class_allocation_head',
						array(	'start_cw'		=> 26,
								'stop_cw'		=> 52
						)
					) 
				?>
			<tbody>
			<?= $this->element(
					'school_class_allocation_row',
					array(	'schoolClass' => $this->data, 
							'start_cw'		=> 26,
							'stop_cw'		=> 52,
							'allocations'	=> explode(",",@$this->data['SchoolClass']['allocation'])
					)
				) 
			?>
		</tbody>
		</table>
	</fieldset>
</div>
<?= $this->element('edit_form_end') ?>