<label for="calendarWeek">Kalender-Woche</label>
<select name="data[cw]" onchange="handleCWChange(event)" id="calendarWeek">
	<?php for ($i = 1; $i < 53; $i++) { ?>
		<option 
			value="<?= $i ?>"
			<?= (isset($this->data['cw']) && $i == $this->data['cw'])?'selected="selected"':''; ?>
		><?= $i ?>. KW <?= ($i == $current_cw)?'(Aktuell)':'' ?></option>
	<?php } ?>
</select>
<script>
	function handleCWChange(e) {
		var val = e.target.value;
		location.href = e.target.form.action + "/" + val;
	}
</script>