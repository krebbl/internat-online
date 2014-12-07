<?= $form->create('Company',array('action' => $this->action)); ?>
	<?= $this->element('filter_box') ?>
<?= $form->end(); ?>
<?= $form->create('Companies',array('action' => 'listaction')); ?>
<?= 
	$this->element('action_box',
		array('elements' => array(),
			'add' => true
		)
	) 
?>
<?php 	$col_widths = array(
					'30',
					'430',
					'150',
					'150',
					'150',
				);
		echo $this->element('table_header',
			array(
				'col_widths' => $col_widths,
				'headers' => array(
					'Name',
					'Ort',
					'Schüler',
					'Bearbeiten'
				)
			)
		)
	?>
	<div class="table-wrapper">
		<table id="ContentTable">
			<?= $this->element('table_cols',array('widths' => $col_widths)); ?>
			<tbody>
			<?php foreach ($companies as $company): ?>
				<tr>
					<td>
						<input 
							type="checkbox" 
							name="data[Company][ids][]"
							class="default-checkbox"
							value="<?= $company['Company']['id'] ?>"
							<?= ((isset($data['Company']['ids']) && in_array($data['Company']['ids'],$company['Company']['id']))?'checked="checked"':'') ?>
						/>
					</td>
					<td>
						<?= $company['Company']['name'] ?>
					</td>
					<td>
						<?=  $company['Address']['city'] ?>
					</td>
					<td>	
						<?= $html->link(count($company['Pupil']).' Schüler', 
							array('controller'=>'pupils', 'action'=>'moveby/company', $company['Company']['id']));
						?>
					</td>
					<td>
						<?= $html->link('bearbeiten',
							array('controller'=>'Companies', 'action'=>'edit', $company['Company']['id']));
						?>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<?= $this->element('table_footer', array('number' => count($companies), 'label' => 'Schulen')) ?>
<?= $form->end(); ?>