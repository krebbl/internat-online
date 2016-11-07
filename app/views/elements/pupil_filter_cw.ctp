<label for="calendarWeek">Kalender-Woche</label>
<select name="data[cw]" onchange="this.form.submit()" id="calendarWeek">
	<?php for ($i = 1; $i < 53; $i++) { ?>
		<option 
			value="<?= $i ?>"
			<?= (isset($this->data['cw']) && $i == $this->data['cw'])?'selected="selected"':''; ?>
		><?= $i ?>. KW <?= ($i == $current_cw)?'(Aktuell)':'' ?></option>
	<?php } ?>
</select>