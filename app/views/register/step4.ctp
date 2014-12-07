<fieldset>
	<legend>An- und Abreise</legend>
		
		<div class="clearfix form-row">
			<?= $form->input('Pupil.arrival_day', 
					array(
						'label' => 'Tag der Anreise',
						'dateFormat' => 'DMY',
						'class' => 'datefield',
						'selected' => $semester['SchoolSemester']['start_date'],
						'separator' => '.',
						'div' => array(
							'class' => 'form-col'
						)
					)) ?>
			<?= $form->input('Pupil.permanent', 
					array(
						'before' => '<br/>',
						'label' => 'Dauerbeleger (jede Woche anwesend)',
						'div' => array(
							'class' => 'form-col checkbox'
						)
					)) ?>
		</div>
		<div class="info">
			<p><b>Hinweis: </b> Bitte gib an, wie lange die Hin- und Rückfahrt mit <b>öffentlichen Verkehrsmitteln</b> dauern würde.</p>
		</div>
		<div class="clearfix form-row">
			<?= $form->input('Pupil.min_to_arrive', 
					array(
						'label' => 'Dauer der Hinfahrt (in Minuten)',
						'default' => 0,
						'div' => array(
							'class' => 'form-col'
						)
					)) ?>
			<?= $form->input('Pupil.min_to_depart', 
					array(
						'label' => 'Dauer der R&uuml;ckfahrt (in Minuten)',
						'default' => 0,
						'div' => array(
							'class' => 'form-col'
						)
					)) ?>
		</div>
</fieldset>

