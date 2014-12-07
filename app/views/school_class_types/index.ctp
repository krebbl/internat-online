<?= $this->element('filter_box') ?>
<?= $form->create('SchoolClassType',array('action' => 'listaction')); ?>
<?= 
	$this->element('action_box',
		array('elements' => array(),
			'add' => true
		)
	) 
?>
<?php
		$col_widths = array(
					'30',
					'180',
					'350',
					'160',
					'160',
					'160'
				);
		echo $this->element('table_header',
			array(
				'headers' => array(
					'Abkürzung',
					'Name',
					'Ausbildungsdauer',
					'Ausbildungsklassen',
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
			<?php foreach ($schoolClassTypes as $schoolClassType): ?>
				<tr>
					<td>
						<input 
							type="checkbox" 
							name="data[SchoolClassType][ids][]"
							class="default-checkbox"
							value="<?= $schoolClassType['SchoolClassType']['id'] ?>"
							<?= ((isset($data['SchoolClassType']['ids']) && in_array($data['SchoolClassType']['ids'],$schoolClassType['SchoolClassType']['id']))?'checked="checked"':'') ?>
						/>
					</td>
					<td>
						<?= $schoolClassType['SchoolClassType']['abbreviation'] ?>
					</td>
					<td>
						<?=  $schoolClassType['SchoolClassType']['name'] ?>
					</td>
					<td>
						<?=  $schoolClassType['SchoolClassType']['duration'] / 2 ?> Jahre
					</td>
					<td>	
						<?= $html->link(count($schoolClassType['SchoolClass']).' ABKs', 
							array('controller'=>'schoolClasses', 'action'=>'byschoolclasstype', $schoolClassType['SchoolClassType']['id']));
						?>
					</td>
					<td>
						<?= $html->link('bearbeiten',
							array('controller'=>'school_class_types', 'action'=>'edit', $schoolClassType['SchoolClassType']['id']));
						?>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<?= $this->element('table_footer', array('number' => count($schoolClassTypes), 'label' => 'Ausbildungsrichtungen')) ?>
<?= $form->end(); ?>