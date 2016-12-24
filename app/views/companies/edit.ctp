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
	<fieldset>
		<legend>Rechnungsadressen</legend>
		<div class="clearfix">
			<?php foreach($this->data['InvoiceAddress'] as $i => $address){ ?>
				<?= $this->element('address_form', array(
					'address_is_set' => false,
					'with_contact' => true,
					'add' => false,
					'removable' => true,
					'address_path' => "InvoiceAddress.".$i,
					'address' => $this->data['InvoiceAddress'][$i],
					'errors' => @$errors['InvoiceAddress.'.$i]
				)) ?>

			<?php } ?>
		</div>
		<div class="clearfix">
			<?= $this->element('address_form', array(
				'address_is_set' => false,
				'add' => true,
				'with_contact' => true,
				'removable' => true,
				'address_path' => "NewInvoiceAddress",
				'address' => $this->data['NewInvoiceAddress'],
				'errors' => @$errors['NewInvoiceAddress']
			)) ?>
		</div>
	</fieldset>
</div>
<?= $this->element('edit_form_end') ?>