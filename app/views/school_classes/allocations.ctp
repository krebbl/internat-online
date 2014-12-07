<?= $form->create('SchoolClass',array('action' => 'allocations/'.$sct_id)); ?>
<div class="form-body">
	<fieldset>
		<legend>Details</legend>
		<div class="clearfix form-row">
			<?= $form->input('SchoolClassType.permanent', 
					array(
						'before' => '<br/>',
						'label' => 'Dauerbelegung',
						'div' => array(
							'class' => 'form-col checkbox'
						)
					)) ?>
		</div>
		<table border="0" cellspacing="5" cellpadding="5">
			<head>
				<tr>
					<th>Ausbildungsklasse</th>
					<?php for($i = 1; $i < 23; $i++): ?>
						<th><?= $i ?></th>
					<?php endfor ?>
				</tr>
			</thead>
			<tbody>
			
			<?php foreach ($schoolClasses as $schoolClass) { 
					$allocations = explode(",",$schoolClass['SchoolClass']['allocation']);	
					
			?>
				<tr>
					<td>
						<?= $schoolClass['SchoolClassType']['abbreviation'] ?>
						<?= $schoolClass[0]['agegroup'] ?>
					</td>
					<?php for($i = 1; $i < 23; $i++): 
							$checked = 	$schoolClass['SchoolClassType']['permanent'] && !in_array("$i",$allocations) || in_array("$i",$allocations);
					?>
						<td>
							<input 
								type="checkbox" 
								name="data[SchoolClass][<?= $schoolClass['SchoolClass']['id'] ?>][allocation][]" 
								value="<?= $i ?>" 
								<?= ($checked)?'checked="checked"':''; ?> 
							/>
						</td>
					<?php endfor ?>
				</tr>
			<?php } ?>
		</tbody>
		</table>
	</fieldset>
</div>
<?= $form->end('Save'); ?>