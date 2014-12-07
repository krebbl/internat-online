<?= $form->create('SchoolSemester',array('action' => 'create_year')); ?>
<div class="form-body">
	<?= $this->element('school_semester_fieldset', array(
		'label' => 'Wintersemester',
		'path' => 'Wintersemester',
		'errors' => @$errors
	)) ?>
	<?= $this->element('school_semester_fieldset', array(
		'label' => 'Sommersemester',
		'path' => 'Summersemester',
		'errors' => @$errors
	)) ?>
	<fieldset>
		<legend>Zu übernehmende Ausbildungsklassen</legend>
		<div class="clearfix">
			<table border="0" cellspacing="5" cellpadding="5" class="allocations">
			<head>
				<tr>
					<th><input 
								type="checkbox"
								class="allocation-checkbox"
								name="all" 
								value="1"
								onclick="doCheckAll(this)"  
							/></th>
					<th>Ausbildungsklasse</th>
					<th></th>
					<th>Ausbildungsklasse</th>
					<th></th>
					<th>Ausbildungsklasse</th>
					<th></th>
					<th>Ausbildungsklasse</th>
				</tr>
			</thead>
			<tbody>
			
			<?php
				$i = 0; 
				foreach ($schoolClassTypes as $schoolClassType) { ?>
				<?php if($i%4 == 0){ ?>
					<tr>
				<?php } ?>
						<td>
							<input 
								type="checkbox"
								class="default-checkbox"
								name="data[SchoolClassType][]" 
								value="<?= $schoolClassType['SchoolClassType']['id'] ?>"  
							/>
						</td>
						<td>
							<?= $schoolClassType['SchoolClassType']['abbreviation'] ?>
						</td>
				<?php if($i%4 == 3){ ?>
					</tr>
				<?php } ?>
				<?php $i++ ?>
			<?php } ?>
		</tbody>
		</table>
		</div>
	</fieldset>
</div>
<?= $this->element('edit_form_end') ?>