<table class="header">
	<?php if(isset($col_widths)): 
		array_push($col_widths,'20');
	?>
		<?= $this->element('table_cols',array('widths' => $col_widths)); ?>
	<?php endif ?>
	<thead>
		<tr>
			<th class="checkbox">
				<input 
						type="checkbox" 
						name="all"
						onclick="doCheckAll(this)" 
						value="0"/>
			</th>
			<?php foreach($headers as $header): ?>
				<th><?= $header ?></th>
			<?php endforeach ?>
			<th></th>
		</tr>
	</thead>
</table>