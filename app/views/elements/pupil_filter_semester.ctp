<label for="semesters">Semester</label>
<select name="semesterId" onchange="this.form.submit()" id="semesters">
	<?php foreach ($semesters as $semester) : ?>
		<option
			value="<?= $semester['SchoolSemester']['id'] ?>"
			<?= (isset($semesterId) && $semester['SchoolSemester']['id'] == $semesterId) ? 'selected="selected"' : ''; ?>
			><?= $semester[0]['title'] ?></option>
	<?php endforeach ?>
</select>