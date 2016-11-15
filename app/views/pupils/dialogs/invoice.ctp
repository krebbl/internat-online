<?= $form->create('pupils', array('id' => "invoiceform",'action' => 'listaction')); ?>
	<div class="form-body">
		<div class="form-header clearfix">
			<h3>Rechung erstellen</h3>
		</div>
		<fieldset class="">
			<legend>Zeitraum</legend>
			<div class="form-row clearfix">
				<?php
					$options = array();
					$time = time();
					for($i = 0; $i < 30; $i++) {

						$options[date("c", $time)] = date("W.K\\W y", $time);
						$time -= (7 * 60 * 60 * 24);
						if($i === 4) {
							$start = date("c", $time);
						}
					}
				?>
				<?= $form->input('Pupil.ids',
						array(
							'type' => 'hidden'
						)) ?>
				<?= $form->input(
						'Invoice.start',
						array(
							'label' => 'Von',
							'type' => 'select',
							'value' => $start,
							'options' => $options,
							'div' => array(
								'class' => 'form-col',
							)
			)); ?>
				<?= $form->input(
						'Invoice.end',
						array(
							'label' => 'Bis',
							'options' => $options,
							'type' => 'select',
							'div' => array(
								'class' => 'form-col',
							)
			)); ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-row clearfix">
				<?= $form->input(
					'Invoice.nr',
					array(
						'label' => 'Rechnungsnr.',
						'div' => array(
							'class' => 'form-col',
						)
					)); ?>
				<?= $form->input(
					'Invoice.type',
					array(
						'label' => 'Rechnungstyp',
						'type' => 'select',
						'options' => array('FOOD' => "Essen", 'RENT' => "Miete", "BOTH" => "Alles"),
						'div' => array(
							'class' => 'form-col',
						)
					)); ?>

			</div>
		</fieldset>
	</div>
	<div class="clearfix"></div>
	<div class="form-buttons">
		<input 
				type="submit" 
				name="data[generateInvoice]"
				class="icon_save_s" 
				value="Rechnung erstellen" />
	</div>
<?= $form->end(); ?>
