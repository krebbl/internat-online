<label for="gender">Geschlecht</label>
<select name="data[not_male]" id="gender" onchange="this.form.submit()">
	<option 
		value="2"
		<?= (!isset($this->data['not_male']))?'selected="selected"':''; ?>>
		Alle
	</option>
	<option 
		value="0"
		<?= (isset($this->data['not_male']) &&  $this->data['not_male'] == 0)?'selected="selected"':''; ?>>
		Männer
	</option>
	<option 
		value="1"
		<?= (isset($this->data['not_male']) && $this->data['not_male'] == 1)?'selected="selected"':''; ?>>
		Frauen
	</option>
</select>