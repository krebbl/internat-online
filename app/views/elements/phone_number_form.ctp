<div class="clearfix">
	<?php $phone_number_setted = @$phone_number['id'] != "" || isset($phone_number['add']); ?>
	<div <?= ((!$phone_number_setted && $removable)?'style="display: none"':'') ?>>
		<div>
			<?= $form->input($phone_number_path.'.id', 
					array(
						'type' => 'hidden'
					)
				);
			?>
			<?= ($phone_number_setted && !isset($phone_number['remove']))?
					$form->input($phone_number_path.'.add', array('type'=>'hidden')):''; ?>
			<?= (isset($phone_number['remove']))?
					$form->input($phone_number_path.'.remove', array('type'=>'hidden')):''; ?>
			<?= $form->input(
					$phone_number_path.'.home',
					array(
						'label' => 'Telefon',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 19%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['home']))
			)); ?>
			<?= $form->input(
					$phone_number_path.'.fax',
					array(
						'label' => 'Fax',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 19%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['fax']))
			)); ?>
			<?= $form->input(
					$phone_number_path.'.mobile',
					array(
						'label' => 'Handy',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 19%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['mobile']))
			)); ?>
		</div>
	</div>
	<div class="col" style="float: right; text-align: right;">
		<br/>
		<?php if($removable){ ?>
			<a href="javascript:;"
				style="<?= ( $phone_number_setted)?'display: none':'' ?>" 
				onclick="showForm(this);">
				Telefonnummer hinzufügen</a>
			<a href="javascript:;" 
				style="<?= (! $phone_number_setted)?'display: none':'' ?>"
				onclick="hideForm(this);">
					Telefonnummer entfernen</a>
		<?php }?>
	</div>
</div>