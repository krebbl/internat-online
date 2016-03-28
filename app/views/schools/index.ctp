<?= $form->create('School',array('action' => $this->action)); ?>
	<?= $this->element('filter_box') ?>
<?= $form->end(); ?>
<?= $form->create('School',array('action' => 'listaction')); ?>
<?= 
	$this->element('action_box',
		array('elements' => array(),
			'add' => true
		)
	) 
?>
<?		
		$col_widths = array(
					'30',
					'430',
					'120',
					'120',
					'120',
					'120'
				);
	?>
    <?= $this->element('table_header',
	array(
		'col_widths' => $col_widths,
		'headers' => array(
			'Name',
			'Abkürzung',
			'Ort',
			'Schüler',
			'Bearbeiten'
		)
	)
) ?>
	<div class="table-wrapper">
		<table id="ContentTable">
			<?= $this->element('table_cols',array('widths' => $col_widths)); ?>
			<tbody>
			<?php foreach ($schools as $school): ?>
				<tr>
					<td>
						<input 
							type="checkbox" 
							name="data[School][ids][]"
							class="default-checkbox"
							value="<?= $school['School']['id'] ?>"
							<?= ((isset($data['School']['ids']) && in_array($data['School']['ids'],$school['School']['id']))?'checked="checked"':'') ?>
						/>
					</td>
					<td>
						<?= $school['School']['name'] ?>
					</td>
					<td>
						<?= $school['School']['abbreviation'] ?>
					</td>
					<td>
						<?=  $school['Address']['city'] ?>
					</td>
					<td>	
						<?= $html->link(count($school['Pupil']).' Schüler', 
							array('controller'=>'pupils', 'action'=>'moveby/school', $school['School']['id']));
						?>
					</td>
					<td>
						<?= $html->link('bearbeiten',
							array('controller'=>'schools', 'action'=>'edit', $school['School']['id']));
						?>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<?= $this->element('table_footer', array('number' => count($schools), 'label' => 'Schulen')) ?>
<?= $form->end(); ?>