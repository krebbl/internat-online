<?= $form->create('Company',array('action' => 'edit')); ?>
<div class="form-body">
	<fieldset>
		<legend>Details</legend>
		<div class="clearfix">
			<?= $form->input('Company.id', array('type'=>'hidden')); ?> 
			<?= $form->input(
						'Company.name',
						array(
							'label' => 'Name',
							'div' => array(
								'class' => 'form-col',
								'style' => 'width: 60%'
							)
				)); ?>			
		</div>
	</fieldset>
	<fieldset>
		<legend>Kontaktdaten</legend>
		<div class="clearfix">
			<?= $this->element('address_form',array(
				'address_is_set' => true,
				'removable' => false,
				'address_path' => "Address",
				'address' => $this->data['Address'],
				'errors' => @$errors['Address']
			)) ?>
		</div>
	</fieldset>
</div>
<?= $this->element('edit_form_end') ?>