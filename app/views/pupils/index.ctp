<?= $form->create('Pupil', array('action' => $this->action)); ?>
<?= $this->element('filter_box',
	array('elements' =>
		array(
			$this->element('pupil_filter_semester')
		)
	)
); ?>
<?= $form->end(); ?>
<?= $this->element('pupil_table_default'); ?>