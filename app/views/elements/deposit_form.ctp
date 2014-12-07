<div class="clearfix">
	<?php $deposit_setted = @$deposit['id'] != "" || isset($deposit['add']); ?>
	<div <?= ((!$deposit_setted && $removable)?'style="display: none"':'') ?>>
		<div class="clearfix form-row">
			<?= $form->input('Deposit.id', 
					array(
						'type' => 'hidden'
					)) ?>
			<?= ($deposit_setted && !isset($deposit_setted['remove']))?
					$form->input('Deposit.add', array('type'=>'hidden')):''; ?>
			<?= (isset($deposit_setted['remove']))?
					$form->input('Deposit.remove', array('type'=>'hidden')):''; ?>
			<?= $form->input(
						'Deposit.block', 
						array(
							'label' => 'Block',
							'div' => array(
								'class' => 'form-col',
							)
			)); ?>
			<?= $form->input(
						'Deposit.nr', 
						array(
							'label' => 'Nummer',
							'div' => array(
								'class' => 'form-col',
							)
			)); ?>
			<?= $form->input(
						'Deposit.value', 
						array(
							'label' => 'Betrag',
							'div' => array(
								'class' => 'form-col',
							)
			)); ?>
		</div>
		<div class="clearfix form-row">
			<?= $form->input('Deposit.paid_in', 
					array(
						'label' => 'Eingezahlt am',
						'dateFormat' => 'DMY',
						'class' => 'datefield',
						'disabled' => false,
						'separator' => '.',
						'div' => array(
							'class' => 'form-col'
						)
					)) ?>
			<?php $paid_out = isset($this->data['Deposit']['paid_out']) && !empty($this->data['Deposit']['paid_out']) && $this->data['Deposit']['paid_out'] != '0000-00-00'; ?>
			<?= $form->input('Deposit.paid_out', 
					array(
						'label' => 'Ausgezahlt am',
						'dateFormat' => 'DMY',
						'class' => 'datefield',
						'disabled' => !$paid_out,
						'separator' => '.',
						'between' => 
							'<input type="checkbox" name="pay_out" onchange="enablePayOut(this)"'.(($paid_out)?'checked="checked"':'').' />',
						'div' => array(
							'class' => 'form-col'
						)
					)) ?>
		</div>
	</div>
	<div class="col" style="float: right; text-align: right;">
		<br/>
		<?php if($removable){ ?>
			<a class="w-icon icon-money-add" href="javascript:;"
				style="<?= ( $deposit_setted)?'display: none':'' ?>" 
				onclick="showForm(this);">
				Kaution hinzufügen</a>
			<a class="w-icon icon-money-remove" href="javascript:;" 
				style="<?= (! $deposit_setted)?'display: none':'' ?>"
				onclick="hideForm(this);">
					Kaution entfernen</a>
		<?php }?>
	</div>
</div>