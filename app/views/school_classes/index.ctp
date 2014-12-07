<?= $form->create('SchoolClass',array('action' => $this->action)); ?>
<?php 
	if(isset($semesters)){
		$filter = array($this->element('pupil_filter_semester',array('semesters' => $semesters)));
		$hidden = "";
	}else{
		$filter = array();	
		$hidden = '<input type="hidden" name="data[sct_id]" value="'.$schoolClassType['SchoolClassType']['id'].'"/>';
	}?>
<?= $this->element('filter_box',array('elements' => $filter)) ?>
<?= $form->end(); ?>

<?= $form->create('SchoolClass',array('action' => 'listaction')); ?>
	<?= 
		$this->element('action_box',
			array('elements' => array(
				$hidden
				),
				'add' => true
			)
		) 
	?>
	
	<?php
		$col_widths = array(
					'30',
					'500',
					'150',
					'150'
				);
	
		echo $this->element('table_header',
			array(
				'headers' => array(
					'Abkürzung',
					'Schüler',
					'Bearbeiten'
				),
				'col_widths' => $col_widths
			)
		)
	?>
	<div class="table-wrapper">
		<table id="ContentTable">
			<?= $this->element('table_cols',array('widths' => $col_widths)); ?>
			<tbody>
			<?php foreach ($schoolClasses as $schoolClass) { ?>
				<tr>
					<td class="checkbox"><input 
							class="default-checkbox"
							type="checkbox" 
							name="data[SchoolClass][ids][]" 
							value="<?=$schoolClass['SchoolClass']['id']?>" 
							<?= (isset($data['SchoolClass']['ids']))?'checked="checked"':''; ?> 
						/>
					</td>
					<td>
						<?= $schoolClass['SchoolClassType']['abbreviation'] ?>
						<?= $schoolClass[0]['agegroup'] ?>						
					</td>
					<td>
						<?= $html->link(count($schoolClass['Pupil']).' Schüler', 
							array('controller'=>'pupils', 'action'=>'moveby/school_class', $schoolClass['SchoolClass']['id'])) ?>
					</td>	
					<td>		
						<?= $html->link('bearbeiten',
								array('controller'=>'school_classes', 'action'=>'edit', $schoolClass['SchoolClass']['id']));
						?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<?= $this->element('table_footer', array('number' => count($schoolClasses), 'label' => 'Ausbildungsklassen')) ?>
</form>