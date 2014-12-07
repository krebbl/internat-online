
<?= $form->create('SchoolClassType',array('action' => 'edit')); ?>
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
		</div><div class="clearfix">
			<?= $form->input('duration', array('label' => 'Ausbildungsdauer in Semestern', 'div' => 'form-col')); ?>
			<?= $form->input('permanent', 
					array(
						'before' => '<br/>',
						'label' => 'Dauerbelegung',
						'onClick' => 'doCheckAll(this)',
						'div' => array(
							'class' => 'form-col checkbox'
						
							)
					)) ?>
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
			
			<?php foreach ($schoolClasses as $schoolClass) { 
					$allocations = explode(",",$schoolClass['SchoolClass']['allocation']);	
					
			?>
				<?= $this->element(
						'school_class_allocation_row',
						array(	'schoolClass' => $schoolClass, 
								'start_cw'		=> 1,
								'stop_cw'		=> 26,
								'allocations'	=> $allocations
						)
					) 
				?>
			<?php } ?>
		</tbody>
		</table>
	</fieldset>
	<fieldset>
		<legend>Belegung (2. H&auml;lfte)</legend>
		<table border="0" cellspacing="5" cellpadding="5" class="allocations">
			<?= $this->element('school_class_allocation_head',
						array(	'start_cw'		=> 26,
								'stop_cw'		=> 53
						)
					) 
				?>
			<tbody>
			
			<?php foreach ($schoolClasses as $schoolClass) { 
					$allocations = explode(",",$schoolClass['SchoolClass']['allocation']);	
					
			?>
				<?= $this->element(
						'school_class_allocation_row',
						array(	'schoolClass' => $schoolClass, 
								'start_cw'		=> 26,
								'stop_cw'		=> 53,
								'allocations'	=> $allocations
						)
					) 
				?>
			<?php } ?>
		</tbody>
		</table>
	</fieldset>
</div>
<?= $this->element('edit_form_end') ?>