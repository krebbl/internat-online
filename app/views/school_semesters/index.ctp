<?= $form->create('SchoolSemester',array('action' => 'listaction')); ?>
	<?= 
		$this->element('action_box',
			array('elements' => array(),
				'add' => true,
				'add_label' => 'Neues Schuljahr anlegen'
			)
		) 
	?>
	<?php 
		$col_widths = array(
					'30',
					'450',
					'150',
					'150',
					'150'
				);
		echo $this->element('table_header',
			array(
				'headers' => array(
					'Semester',
					'Beginn',
					'Ende',
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
			<?php foreach ($SchoolSemesters as $SchoolSemester) { 
				$now = time();
				$start = strtotime($SchoolSemester['SchoolSemester']['start_date']);
				$stop = strtotime($SchoolSemester['SchoolSemester']['stop_date']);
				$current = ($start < $now && $stop > $now);
				echo $html->tableCells(array(
					array(
						"<input 
							type=\"checkbox\" 
							name=\"data[SchoolSemester][ids][]\" 
							value=\"".$SchoolSemester['SchoolSemester']['id']."\"".
							((isset($data['SchoolSemester']['ids']) && in_array($data['SchoolSemester']['ids'],$SchoolSemester['SchoolSemester']['id']))?'checked="checked"':'') 
						."/>",
						(($current)?'<b>':'').$SchoolSemester[0]['title'].(($current)?'</b>':''),
						date("d.m.Y",$start),
						date("d.m.Y",$stop),
						$html->link('bearbeiten',
							array('controller'=>'school_semesters', 'action'=>'edit', $SchoolSemester['SchoolSemester']['id'])))
						)
					);
				} 
			?>
			</tbody>
		</table>
	</div>
	<?= $this->element('table_footer', array('number' => count($SchoolSemesters), 'label' => 'Semester')) ?>
<?= $form->end(); ?>