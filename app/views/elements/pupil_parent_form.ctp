<div class="clearfix" >
	<?php 
		$parent_setted = @$pupilParent['id'] != 0 || isset($pupilParent['add']); 
	?>
	<div <?= ((! $parent_setted && $removable)?'style="display: none"':'') ?>>
		<div class="clearfix">
			<?= $form->input("PupilParent.$num.id", array('type'=>'hidden')); ?>
			<?= (isset($this->data['PupilParent'][$num]['add']) || !$removable)?
					$form->input("PupilParent.$num.add", array('type'=>'hidden','value' => true)):''; ?>
			<?= $form->input(
						"PupilParent.$num.firstname",
						array(
							'label' => 'Vorname',
							'div' => array(
								'class' => 'form-col'
							),
							'after' => $this->element('field_error',array('message' => @$errors['firstname']))
				)); ?>
			<?= $form->input(
						"PupilParent.$num.lastname",
						array(
							'label' => 'Nachname',
							'div' => array(
								'class' => 'form-col'
							),
							'after' => $this->element('field_error',array('message' => @$errors['lastname']))
				)); ?>
		</div>
		<?= $this->element('address_form',array(
			'removable' => true,
			'address_path' => "PupilParent.$num.address",
			'address' => @$pupilParent['address'],
			'errors' => @$addressErrors
		)) ?>
	</div>
	<div style="float: right; text-align: right;">
		<?php if($removable){ ?>
			<a 
				href="javascript:;" 
				onclick="showForm(this);" 
				style="<?= ($parent_setted)?'display: none':'' ?>">Vertreter hinzufügen</a>
			<a 
				href="javascript:;" 
				onclick="hideForm(this);"
				style="<?= (! $parent_setted)?'display: none':'' ?>">Vertreter entfernen</a>	
		<?php } ?>
	</div>
</div>