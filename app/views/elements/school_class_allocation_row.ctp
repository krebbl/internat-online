<tr>
	<td>
		<?php if(@$schoolClass['SchoolClassType']): ?>
			<?= @$schoolClass['SchoolClassType']['abbreviation'] ?>
			<?= @$schoolClass[0]['agegroup'] ?>
			<?= @$schoolClass['SchoolClass']['extension'] ?>
		<?php endif ?>
	</td>
	<?php for($i = $start_cw; $i < $stop_cw; $i++): 
			$checked = 	in_array("$i",$allocations);
	?>
		<td>
			<input 
				type="hidden" 
				name="data[SchoolClass][<?= (isset($schoolClass['SchoolClass']['id']))?$schoolClass['SchoolClass']['id']:0 ?>][allocation][]" 
				value="0"  
			/>
			<input 
				type="checkbox"
				class="default-checkbox"
				name="data[SchoolClass][<?= (isset($schoolClass['SchoolClass']['id']))?$schoolClass['SchoolClass']['id']:0 ?>][allocation][]" 
				value="<?= $i ?>" 
				<?= ($checked)?'checked="checked"':''; ?> 
			/>
		</td>
	<?php endfor ?>
</tr>