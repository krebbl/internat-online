<div class="clearfix" id="<?= @$id ?>" <?= (@$hidden)?'style="display: none"':'' ?> >
	<?php $address_setted = @$address['id'] != "" || isset($address['add']); ?>
	<div <?= ((!$address_setted && $removable)?'style="display: none"':'') ?>>
		<div class="clearfix form-row">
			<?= $form->input($address_path.'.id', 
					array(
						'type' => 'hidden'
					)
				);
			?>
			<?= ($address_setted && !isset($address['remove']))?
					$form->input($address_path.'.add', array('type'=>'hidden')):''; ?>
			<?= (isset($address['remove']))?
					$form->input($address_path.'.remove', array('type'=>'hidden')):''; ?>
			<? if($with_contact) { ?>
				<div class="clearfix form-row">
			<?= $form->input(
				$address_path . '.contact',
				array(
					'label' => 'Kontakt',
					'div' => array(
						'class' => 'form-col',
					),
					'after' => $this->element('field_error', array('message' => @$errors['contact']))
				)) ?>
				</div>
			<? } ?>
			<?= $form->input(
					$address_path.'.street',
					array(
						'label' => 'Strasse + Hausnr.',
						'div' => array(
							'class' => 'form-col',
						),
						'after' => $this->element('field_error',array('message' => @$errors['street']))
			)); ?>
			<?= $form->input(
					$address_path.'.zipcode',
					array(
						'label' => 'PLZ',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 8%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['zipcode']))
			)); ?>
			<?= $form->input(
					$address_path.'.city',
					array(
						'label' => 'Stadt',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 20%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['city']))
			)); ?>
		</div>
		<div class="clearfix form-row">
			<?= $form->input(
					$address_path.'.home_nr',
					array(
						'label' => 'Telefonnummer',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 19%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['home_nr']))
			)); ?>
			<?= $form->input(
					$address_path.'.fax_nr',
					array(
						'label' => 'Fax*',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 19%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['fax_nr']))
			)); ?>
			<?= $form->input(
					$address_path.'.mobile_nr',
					array(
						'label' => 'Handy*',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 19%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['mobile_nr']))
			)); ?>
		</div>
	</div>
	<div class="col" style="float: right; text-align: right;">
		<br/>
		<?php if($removable){ ?>
			<a href="javascript:;"
				style="<?= ( $address_setted)?'display: none':'' ?>" 
				onclick="showForm(this);">
				Adresse hinzufügen</a>
			<a href="javascript:;" 
				style="<?= (! $address_setted)?'display: none':'' ?>"
				onclick="hideForm(this);">
					Adresse entfernen</a>
		<?php }?>
	</div>
</div>