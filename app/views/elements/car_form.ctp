<div class="clearfix">
	<?php $car_setted = @$car['id'] != "" || isset($car['add']); ?>
	<div <?= ((!$car_setted && $removable)?'style="display: none"':'') ?>>
		<div>
			<?= $form->input($car_path.'.id', 
					array(
						'type' => 'hidden'
					)
				);
			?>
			<?= ($car_setted && !isset($car_setted['remove']))?
					$form->input($car_path.'.add', array('type'=>'hidden')):''; ?>
			<?= (isset($car_setted['remove']))?
					$form->input($car_path.'.remove', array('type'=>'hidden')):''; ?>
			<?= $form->input(
					$car_path.'.name',
					array(
						'label' => 'Typ',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 19%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['name']))
			)); ?>
			<?= $form->input(
					$car_path.'.color',
					array(
						'label' => 'Farbe',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 19%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['color']))
			)); ?>
			<?= $form->input(
					$car_path.'.sign',
					array(
						'label' => 'Kennzeichen',
						'div' => array(
							'class' => 'form-col',
							'style' => 'width: 19%'
						),
						'after' => $this->element('field_error',array('message' => @$errors['sign']))
			)); ?>
		</div>
	</div>
	<div class="col" style="float: right; text-align: right;">
		<br/>
		<?php if($removable){ ?>
			<a class="w-icon icon-car-add" href="javascript:;"
				style="<?= ( $car_setted)?'display: none':'' ?>" 
				onclick="showForm(this);">
				Auto hinzufügen</a>
			<a class="w-icon icon_delete_s" href="javascript:;" 
				style="<?= (! $car_setted)?'display: none':'' ?>"
				onclick="hideForm(this);">
					Auto entfernen</a>
		<?php }?>
	</div>
</div>