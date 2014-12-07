<table class="filter-box">
	<tr>
		<td class="first">
			<?= $this->element('filter_input'); ?>
		</td>
		
		<?php
			if(isset($elements)): 
				foreach($elements as $element): ?>
					<td><?= $element ?></td>
		<?php 
				endforeach;
			endif; ?>
	</tr>
</table>