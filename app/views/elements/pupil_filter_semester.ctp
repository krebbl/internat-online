<label for="semesters">Semester</label>
<select name="data[semesterId]" onchange="this.form.submit()" id="semesters">
	<?php foreach ($semesters as $semester) : ?>
		<option
			value="<?= $semester['SchoolSemester']['id'] ?>"
			<?= (isset($this->data['semesterId']) && $semester['SchoolSemester']['id'] == $this->data['semesterId']) ? 'selected="selected"' : ''; ?>
			><?= $semester[0]['title'] ?></option>
	<?php endforeach ?>
</select>