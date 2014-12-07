
<div style="width: 300px; float: left;">
<?= $form->create('Dialog',array('action' => 'set','onsubmit' => 'return false;')); ?>
	<div class="form-body">
		<div class="form-header clearfix">
			<h3><?= $this->data['Pupil']['firstname']." ".$this->data['Pupil']['lastname'] ?></h3>
		</div>
		<fieldset>
			<legend>Neuer Kommentar</legend>
			<div class="form-row clearfix">
				<?= $form->input('Pupil.id', 
				array(
					'type' => 'hidden'
				)) ?>
				<?= $form->input(
						'PupilComment.text', 
						array(
							'label' => 'Kommentar',
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
			name="checkin" 
			class="icon_save_s" 
			value="Speichern" 
			onclick="doAction('/pupils_ajax/commentsdialog');"/>
	</div>	
<?= $form->end(); ?>
</div>

<div style="width: 300px; float: left; border-left: 2px solid white;">
	<div class="form-body">
		<fieldset>
			<legend>Letzte Kommentare</legend>
		<?php if(!empty($PupilComments)): ?>
		
			<div class="form-row clearfix">
				<?php foreach($PupilComments as $PupilComment):?>
					<div class="comment-text">
						<p><?= $PupilComment['PupilComment']['text']?></p>
					</div>
					<div class="comment-details">
						<?= $PupilComment['PupilComment']['created']?> von 
						<?= $PupilComment['User']['username']?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<div class="comment-text">keine Kommentare</div>
		<?php endif;?>
		</fieldset>
	</div>
</div>
