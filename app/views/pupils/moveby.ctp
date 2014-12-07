<?= $this->element('filter_box'); ?>
<form action="<?= $this->here ?>" method="post">
<?= 
	$this->element('action_box',
		array(
			'delete' => false,
			'elements' => array(
				$this->element($target),
				'<br/><input type="submit" name="data[move]" class="small-icon icon-move-s" value="Verschieben"/>'
			)
		)
	) 
?>
<?=
		$this->element('table_header',
			array(
				'headers' => array(
					'Nachname',
					'Vorname',
					'Bearbeiten'
				)
			)
		)
	?>
	<div class="table-wrapper">
		<table id="ContentTable">
			<tbody>
			<?php foreach ($pupils as $pupil): ?>
				<tr>
					<td>
						<input 
							type="checkbox" 
							name="data[Pupil][ids][]"
							class="default-checkbox"
							value="<?= $pupil['Pupil']['id'] ?>"
							<?= ((isset($this->data['Pupil']['ids']) && in_array($pupil['Pupil']['id'],$this->data['Pupil']['ids']))?'checked="checked"':'') ?>
						/>
					</td>
					<td>
						<?= $pupil['Pupil']['lastname'] ?>
					</td>
					<td>
						<?= $pupil['Pupil']['firstname'] ?>
					</td>
					<td>
						<?= $html->link('bearbeiten',
							array('controller'=>'pupils', 'action'=>'edit', $pupil['Pupil']['id']));
						?>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<?= $this->element('table_footer', array('number' => count($pupils), 'label' => 'Sch&uuml;ler')) ?>
<?= $form->end(); ?>