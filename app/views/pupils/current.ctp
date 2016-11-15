<?= $form->create('Pupil',array('action' => $this->action, 'type' => 'get')); ?>
	<?= $this->element('filter_box', 
		array('elements' => 
			array(
				$this->element('pupil_filter_cw'),
				$this->element('pupil_filter_company')
			)
		)
	); ?>
<?= $form->end(); ?>
<?= $this->element('pupil_table_default'); ?>